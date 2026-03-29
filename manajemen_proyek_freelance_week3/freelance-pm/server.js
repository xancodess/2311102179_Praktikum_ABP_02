const express = require('express');
const session = require('express-session');
const { google } = require('googleapis');
const { v4: uuidv4 } = require('uuid');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// ─── Google OAuth2 Config ──────────────────────────────────────────────────
// TODO: Replace with your actual Google OAuth2 credentials
// Get these from: https://console.cloud.google.com/
const GOOGLE_CLIENT_ID = process.env.GOOGLE_CLIENT_ID || 'YOUR_GOOGLE_CLIENT_ID';
const GOOGLE_CLIENT_SECRET = process.env.GOOGLE_CLIENT_SECRET || 'YOUR_GOOGLE_CLIENT_SECRET';
const GOOGLE_REDIRECT_URI = process.env.GOOGLE_REDIRECT_URI || 'http://localhost:3000/auth/google/callback';

const oauth2Client = new google.auth.OAuth2(
  GOOGLE_CLIENT_ID,
  GOOGLE_CLIENT_SECRET,
  GOOGLE_REDIRECT_URI
);

// ─── Middleware ────────────────────────────────────────────────────────────
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));
app.use(session({
  secret: process.env.SESSION_SECRET || 'freelance-pm-secret-key-2025',
  resave: false,
  saveUninitialized: false,
  cookie: { secure: false, maxAge: 24 * 60 * 60 * 1000 }
}));

// ─── Data Helper Functions ─────────────────────────────────────────────────
const DATA_FILE = path.join(__dirname, 'data', 'projects.json');

function readProjects() {
  try {
    const raw = fs.readFileSync(DATA_FILE, 'utf8');
    return JSON.parse(raw);
  } catch (e) {
    return [];
  }
}

function writeProjects(projects) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(projects, null, 2));
}

// ─── HTML Pages ───────────────────────────────────────────────────────────
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'opening.html'));
});

app.get('/dashboard', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'dashboard.html'));
});

app.get('/projects', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'projects.html'));
});

app.get('/form', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'form.html'));
});

// ─── API: Projects CRUD ────────────────────────────────────────────────────
// GET all projects (JSON for DataTable)
app.get('/api/projects', (req, res) => {
  const projects = readProjects();
  res.json({ data: projects });
});

// GET single project
app.get('/api/projects/:id', (req, res) => {
  const projects = readProjects();
  const project = projects.find(p => p.id === req.params.id);
  if (!project) return res.status(404).json({ error: 'Project not found' });
  res.json(project);
});

// POST create project
app.post('/api/projects', async (req, res) => {
  try {
    const projects = readProjects();
    const newProject = {
      id: 'proj-' + uuidv4().substring(0, 8),
      clientName: req.body.clientName,
      contentType: req.body.contentType,
      deadline: req.body.deadline,
      price: parseFloat(req.body.price),
      currency: req.body.currency || 'USD',
      revisionStatus: req.body.revisionStatus || 'Draft',
      projectStatus: req.body.projectStatus || 'Active',
      paymentStatus: req.body.paymentStatus || 'Unpaid',
      notes: req.body.notes || '',
      googleEventId: null,
      createdAt: new Date().toISOString()
    };

    projects.push(newProject);
    writeProjects(projects);

    // Auto-sync to Google Calendar if user is authenticated
    if (req.session.tokens) {
      try {
        oauth2Client.setCredentials(req.session.tokens);
        const calendar = google.calendar({ version: 'v3', auth: oauth2Client });
        const event = {
          summary: `📹 DEADLINE: ${newProject.clientName} — ${newProject.contentType}`,
          description: `Proyek: ${newProject.contentType}\nHarga: ${newProject.currency} ${newProject.price}\nStatus Revisi: ${newProject.revisionStatus}\nStatus Bayar: ${newProject.paymentStatus}\nCatatan: ${newProject.notes}`,
          start: { date: newProject.deadline },
          end: { date: newProject.deadline },
          reminders: {
            useDefault: false,
            overrides: [
              { method: 'email', minutes: 24 * 60 * 3 },
              { method: 'popup', minutes: 24 * 60 }
            ]
          },
          colorId: '6'
        };

        const calRes = await calendar.events.insert({ calendarId: 'primary', resource: event });
        newProject.googleEventId = calRes.data.id;

        // Update the saved project with event ID
        const idx = projects.findIndex(p => p.id === newProject.id);
        projects[idx] = newProject;
        writeProjects(projects);
      } catch (calErr) {
        console.error('Google Calendar error:', calErr.message);
      }
    }

    res.status(201).json({ success: true, project: newProject });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// PUT update project
app.put('/api/projects/:id', async (req, res) => {
  try {
    const projects = readProjects();
    const idx = projects.findIndex(p => p.id === req.params.id);
    if (idx === -1) return res.status(404).json({ error: 'Project not found' });

    const oldProject = projects[idx];
    const updated = {
      ...oldProject,
      clientName: req.body.clientName || oldProject.clientName,
      contentType: req.body.contentType || oldProject.contentType,
      deadline: req.body.deadline || oldProject.deadline,
      price: req.body.price ? parseFloat(req.body.price) : oldProject.price,
      currency: req.body.currency || oldProject.currency,
      revisionStatus: req.body.revisionStatus || oldProject.revisionStatus,
      projectStatus: req.body.projectStatus || oldProject.projectStatus,
      paymentStatus: req.body.paymentStatus || oldProject.paymentStatus,
      notes: req.body.notes !== undefined ? req.body.notes : oldProject.notes,
      updatedAt: new Date().toISOString()
    };

    projects[idx] = updated;
    writeProjects(projects);

    // Update Google Calendar event if exists
    if (req.session.tokens && updated.googleEventId) {
      try {
        oauth2Client.setCredentials(req.session.tokens);
        const calendar = google.calendar({ version: 'v3', auth: oauth2Client });
        await calendar.events.patch({
          calendarId: 'primary',
          eventId: updated.googleEventId,
          resource: {
            summary: `📹 DEADLINE: ${updated.clientName} — ${updated.contentType}`,
            description: `Proyek: ${updated.contentType}\nHarga: ${updated.currency} ${updated.price}\nStatus Revisi: ${updated.revisionStatus}\nStatus Bayar: ${updated.paymentStatus}`,
            start: { date: updated.deadline },
            end: { date: updated.deadline }
          }
        });
      } catch (calErr) {
        console.error('Calendar update error:', calErr.message);
      }
    }

    res.json({ success: true, project: updated });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// DELETE project
app.delete('/api/projects/:id', async (req, res) => {
  try {
    const projects = readProjects();
    const idx = projects.findIndex(p => p.id === req.params.id);
    if (idx === -1) return res.status(404).json({ error: 'Project not found' });

    const project = projects[idx];

    // Delete Google Calendar event if exists
    if (req.session.tokens && project.googleEventId) {
      try {
        oauth2Client.setCredentials(req.session.tokens);
        const calendar = google.calendar({ version: 'v3', auth: oauth2Client });
        await calendar.events.delete({ calendarId: 'primary', eventId: project.googleEventId });
      } catch (calErr) {
        console.error('Calendar delete error:', calErr.message);
      }
    }

    projects.splice(idx, 1);
    writeProjects(projects);
    res.json({ success: true });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// ─── Google OAuth2 Routes ──────────────────────────────────────────────────
app.get('/auth/google', (req, res) => {
  const url = oauth2Client.generateAuthUrl({
    access_type: 'offline',
    scope: ['https://www.googleapis.com/auth/calendar.events'],
    prompt: 'consent'
  });
  res.redirect(url);
});

app.get('/auth/google/callback', async (req, res) => {
  const { code } = req.query;
  try {
    const { tokens } = await oauth2Client.getToken(code);
    req.session.tokens = tokens;
    oauth2Client.setCredentials(tokens);

    // Get user info
    const oauth2 = google.oauth2({ version: 'v2', auth: oauth2Client });
    const { data: userInfo } = await oauth2.userinfo.get();
    req.session.user = { name: userInfo.name, email: userInfo.email, picture: userInfo.picture };

    res.redirect('/dashboard');
  } catch (err) {
    console.error('OAuth callback error:', err);
    res.redirect('/?error=auth_failed');
  }
});

app.get('/auth/logout', (req, res) => {
  req.session.destroy();
  res.redirect('/');
});

app.get('/api/auth/status', (req, res) => {
  res.json({
    authenticated: !!req.session.tokens,
    user: req.session.user || null
  });
});

// ─── Start Server ──────────────────────────────────────────────────────────
app.listen(PORT, () => {
  console.log(`\n🎬 Freelance Video PM berjalan di http://localhost:${PORT}`);
  console.log(`📁 Data disimpan di: ${DATA_FILE}`);
  console.log(`\n⚠️  Jangan lupa isi GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET di .env\n`);
});
