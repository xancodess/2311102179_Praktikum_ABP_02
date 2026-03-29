# 🎬 FreelancePM — Sistem Manajemen Proyek Video Freelance

Aplikasi web untuk melacak proyek video freelance dengan integrasi **Google Calendar OAuth2**.

---

## 📁 Struktur Proyek

```
freelance-pm/
├── server.js              # Express server utama
├── package.json
├── .env.example           # Template environment variables
├── data/
│   └── projects.json      # Database JSON
└── public/
    ├── opening.html        # Halaman pembuka (animasi partikel)
    ├── dashboard.html      # Halaman 1: Dasbor & Metrik
    ├── form.html           # Halaman 2: Form Input Proyek (Create)
    ├── projects.html       # Halaman 3: Tabel + CRUD (Update/Delete)
    ├── css/
    │   └── style.css       # Design system lengkap
    └── js/
        └── app.js          # Shared utilities & helpers
```

---

## ⚙️ Cara Instalasi

### 1. Install dependencies

```bash
cd freelance-pm
npm install
```

### 2. Setup Google OAuth2

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru (atau gunakan yang ada)
3. **Enable** "Google Calendar API"
4. Buka **APIs & Services > Credentials**
5. Klik **Create Credentials > OAuth client ID**
6. Application type: **Web Application**
7. Tambahkan **Authorized redirect URI**: `http://localhost:3000/auth/google/callback`
8. Salin **Client ID** dan **Client Secret**

### 3. Buat file `.env`

```bash
cp .env.example .env
```

Edit `.env`:

```env
GOOGLE_CLIENT_ID=your_actual_client_id_here
GOOGLE_CLIENT_SECRET=your_actual_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:3000/auth/google/callback
SESSION_SECRET=buat-string-acak-panjang-di-sini
PORT=3000
```

### 4. Jalankan server

```bash
npm start
# atau untuk development dengan auto-reload:
npm run dev
```

### 5. Buka browser

```
http://localhost:3000
```

---

## 🗺️ Halaman-Halaman

| URL | Deskripsi |
|-----|-----------|
| `/` | Opening page dengan animasi partikel |
| `/dashboard` | Dasbor: metrik, grafik, deadline mendatang |
| `/form` | Form input proyek baru (Create) |
| `/projects` | Tabel DataTables + tombol Edit & Delete |

---

## 🔌 API Endpoints

| Method | URL | Deskripsi |
|--------|-----|-----------|
| `GET` | `/api/projects` | Ambil semua proyek (JSON untuk DataTable) |
| `GET` | `/api/projects/:id` | Ambil satu proyek |
| `POST` | `/api/projects` | Buat proyek baru + sync Google Calendar |
| `PUT` | `/api/projects/:id` | Update proyek + update event GCal |
| `DELETE` | `/api/projects/:id` | Hapus proyek + hapus event GCal |
| `GET` | `/auth/google` | Redirect ke halaman login Google |
| `GET` | `/auth/google/callback` | Callback OAuth2 dari Google |
| `GET` | `/auth/logout` | Logout & hapus session |
| `GET` | `/api/auth/status` | Cek status autentikasi |

---

## 🛠️ Teknologi

| Kategori | Teknologi |
|----------|-----------|
| Backend | **Node.js** + **Express** |
| Database | **JSON file** (`data/projects.json`) |
| Frontend Framework | **Bootstrap 5** |
| JavaScript Library | **jQuery 3.7.1** |
| jQuery Plugins | **jQuery UI** (Datepicker), **jQuery Validate**, **DataTables 1.13**, **DataTables Buttons** |
| Google API | **googleapis** (OAuth2 + Calendar v3) |
| Session | **express-session** |
| ID Generation | **uuid** |

---

## 📅 Fitur Google Calendar

Ketika pengguna **login dengan Google** dan **membuat proyek baru**:
- Event otomatis dibuat di Google Calendar primary
- Judul event: `📹 DEADLINE: [Nama Klien] — [Jenis Konten]`
- Tanggal: sesuai tenggat waktu
- **Notifikasi email** 3 hari sebelum deadline
- **Notifikasi popup** 1 hari sebelum deadline
- Saat proyek di-**update**, event GCal ikut diperbarui
- Saat proyek di-**delete**, event GCal ikut dihapus

---

## 🎨 Design System

| Token | Nilai | Penggunaan |
|-------|-------|-----------|
| `--navy` | `#13364F` | Navigasi, judul, aksen |
| `--purple` | `#845EA7` | Aksi utama, highlight |
| `--red` | `#E63946` | Hapus, peringatan kritis |
| `--bg` | `#F8F9FA` | Latar belakang halaman |
| Font Judul | Montserrat | Heading, metrik, brand |
| Font Body | Inter | Form, tabel, teks biasa |

---

## 📝 Catatan Penting

- Data disimpan di `data/projects.json` — **tidak ada database eksternal**
- Untuk production, ganti JSON file dengan database (MongoDB/PostgreSQL)
- Session tidak persisten setelah server restart (gunakan Redis untuk production)
- HTTPS wajib untuk production (Google OAuth2 requirement)

---

## 🚀 Quick Start (tanpa Google Calendar)

Jika ingin mencoba tanpa setup Google OAuth2:

1. Jalankan `npm start` (tanpa `.env`)
2. Semua fitur CRUD berjalan normal
3. Tombol "Hubungkan Google" akan redirect ke halaman error (normal)
4. Proyek tetap tersimpan di JSON file

---

*Dibuat dengan ❤️ menggunakan Node.js + Express + Bootstrap + jQuery*
