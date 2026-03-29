/* ============================================================
   Freelance Video PM — Shared Utilities
   ============================================================ */

// ── Auth State ─────────────────────────────────────────────
let currentUser = null;
let isGCalConnected = false;

async function checkAuthStatus() {
  try {
    const res = await fetch('/api/auth/status');
    const data = await res.json();
    currentUser = data.user;
    isGCalConnected = data.authenticated;
    updateNavbarAuth();
    return data;
  } catch (e) {
    return { authenticated: false, user: null };
  }
}

function updateNavbarAuth() {
  const $gcalBtn = $('#gcal-btn');
  const $userArea = $('#navbar-user-area');

  if (isGCalConnected && currentUser) {
    $gcalBtn.removeClass('btn-gcal').addClass('btn-gcal connected')
      .html(`<i class="bi bi-calendar-check-fill"></i> <span>${currentUser.name.split(' ')[0]}</span>`);

    if (currentUser.picture) {
      $userArea.html(`
        <img src="${currentUser.picture}" class="user-avatar" alt="${currentUser.name}" onerror="this.src=''">
        <span class="user-name d-none d-md-inline">${currentUser.name.split(' ')[0]}</span>
        <a href="/auth/logout" class="btn-gcal" style="background:#e63946; font-size:0.75rem; padding:5px 10px;">
          <i class="bi bi-box-arrow-right"></i>
        </a>
      `);
    }
  } else {
    $gcalBtn.html('<i class="bi bi-google"></i> <span class="d-none d-md-inline">Hubungkan Google</span>');
  }
}

// ── Toast Notifications ────────────────────────────────────
function showToast(message, type = 'info', duration = 3500) {
  const icons = { success: 'bi-check-circle-fill', error: 'bi-x-circle-fill', info: 'bi-info-circle-fill' };
  const $toast = $(`
    <div class="pm-toast ${type}">
      <i class="bi ${icons[type] || icons.info}"></i>
      <span>${message}</span>
    </div>
  `);

  let $container = $('#pm-toast-container');
  if (!$container.length) {
    $container = $('<div id="pm-toast-container" class="pm-toast-container"></div>').appendTo('body');
  }

  $container.append($toast);

  setTimeout(() => {
    $toast.css('animation', 'toast-out 0.3s forwards');
    setTimeout(() => $toast.remove(), 300);
  }, duration);
}

// ── Badge Helpers ──────────────────────────────────────────
function statusBadge(status) {
  const map = {
    'Active':    ['badge-active',    '🟢'],
    'Completed': ['badge-completed', '✅'],
    'On Hold':   ['badge-onhold',    '⏸️'],
  };
  const [cls, icon] = map[status] || ['badge-onhold', '❓'];
  return `<span class="badge-pm ${cls}">${icon} ${status}</span>`;
}

function paymentBadge(status) {
  const map = {
    'Paid':    ['badge-paid',    '💰'],
    'Partial': ['badge-partial', '⏳'],
    'Unpaid':  ['badge-unpaid',  '❌'],
  };
  const [cls, icon] = map[status] || ['badge-unpaid', '❓'];
  return `<span class="badge-pm ${cls}">${icon} ${status}</span>`;
}

function revisionBadge(status) {
  const map = {
    'Draft':    ['badge-draft',   '📝'],
    'In Review':['badge-review',  '🔍'],
    'Final Cut':['badge-final',   '✂️'],
    'Approved': ['badge-approved','✅'],
  };
  const [cls, icon] = map[status] || ['badge-draft', '📝'];
  return `<span class="badge-pm ${cls}">${icon} ${status}</span>`;
}

// ── Deadline Formatter ─────────────────────────────────────
function formatDeadline(dateStr) {
  const date = new Date(dateStr);
  const now = new Date();
  const diffMs = date - now;
  const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
  const formatted = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

  if (diffDays < 0) {
    return `<span class="deadline-overdue">⚠️ ${formatted}</span>`;
  } else if (diffDays <= 7) {
    return `<span class="deadline-soon">🔔 ${formatted}</span>`;
  }
  return `<span>${formatted}</span>`;
}

// ── Currency Format ────────────────────────────────────────
function formatPrice(price, currency) {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: currency || 'USD',
    minimumFractionDigits: 0
  }).format(price);
}

// ── Set Active Nav Link ─────────────────────────────────────
function setActiveNav() {
  const path = window.location.pathname;
  $('.nav-links a').each(function() {
    const href = $(this).attr('href');
    if (href === path || (path === '/' && href === '/dashboard')) {
      $(this).addClass('active');
    } else {
      $(this).removeClass('active');
    }
  });
}

// ── Animate elements on scroll ─────────────────────────────
function initScrollReveal() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.reveal').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    observer.observe(el);
  });
}

// ── Navbar HTML ─────────────────────────────────────────────
function renderNavbar(activePage) {
  const pages = [
    { href: '/dashboard', icon: 'bi-speedometer2', label: 'Dasbor' },
    { href: '/projects',  icon: 'bi-table',         label: 'Proyek' },
    { href: '/form',      icon: 'bi-plus-circle',   label: 'Tambah' },
  ];

  const links = pages.map(p => `
    <a href="${p.href}" class="${activePage === p.href ? 'active' : ''}">
      <i class="bi ${p.icon}"></i>
      <span>${p.label}</span>
    </a>
  `).join('');

  return `
    <nav class="pm-navbar">
      <a href="/dashboard" class="brand">
        <span class="brand-dot"></span>
        FreelancePM
      </a>
      <div class="nav-links">${links}</div>
      <div class="d-flex align-items-center gap-2">
        <div id="navbar-user-area" class="d-flex align-items-center gap-2"></div>
        <a href="/auth/google" id="gcal-btn" class="btn-gcal">
          <i class="bi bi-google"></i>
          <span class="d-none d-md-inline">Hubungkan Google</span>
        </a>
      </div>
    </nav>
  `;
}
