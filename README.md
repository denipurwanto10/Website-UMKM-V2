# Skripsi — Migrasi CI3 → React + Node.js + MySQL

Aplikasi Sistem Informasi UMKM. Arsitektur baru (React + TypeScript + Node.js + MySQL existing),
migrasi bertahap dari CodeIgniter 3. **CI3 tetap jalan** selama masa transisi, database `skripsi`
tidak diubah strukturnya.

## Struktur

```text
application/   Legacy CodeIgniter 3 (tetap dipakai selama migrasi)
server/api/    Legacy Node.js API — port 3000 (dipakai CI3 via cURL)
backend/       Backend BARU (Node.js + TypeScript) — port 3001
frontend/      Frontend BARU (React + TS + Vite + Tailwind v4 + shadcn pola) — port 5173
database/      Dump + backup MySQL
scripts/       Util sekali pakai (extract-polygons)
```

## Prasyarat

- Node.js 20+, MySQL 8 (database `skripsi` existing), Laragon/XAMPP untuk CI3 bila perlu.

## Menjalankan (stack baru)

```bash
# 1. Backend (port 3001)
cd backend
cp .env.example .env   # isi AUTH_SECRET + kredensial DB
npm install
npx tsx src/server.ts  # dev — atau: npm run build && npm start

# 2. Frontend (port 5173)
cd frontend
cp .env.example .env   # VITE_API_URL=http://localhost:3001/api
npm install
npm run dev
```

Buka http://localhost:5173 — direktori UMKM publik langsung tampil dari MySQL live.
Login memakai akun existing di tabel `users`.

## API baru (port 3001)

Kontrak konsisten: `{ success, message, data }`. Auth: JWT Bearer (`POST /api/auth/login`).

| Method | Endpoint | Akses |
|---|---|---|
| GET | `/api/health` | publik |
| POST | `/api/auth/login`, `/api/auth/register`, `/api/auth/logout` | publik |
| GET | `/api/auth/me` | login |
| GET/POST | `/api/users` | Admin |
| GET/PUT/DELETE | `/api/users/:username` | self/Admin |
| GET | `/api/umkm`, `/api/umkm/status/:status`, `/api/umkm/user/:username`, `/api/umkm/:id`, `/api/umkm/status/disetujui/count` | publik |
| POST/PUT/DELETE | `/api/umkm…` | login (Owner miliknya, Admin semua) |
| GET/POST | `/api/promosi`, `/api/promosi/user/:username`, `/api/promosi/:id` | baca publik, tulis login |
| PUT/DELETE | `/api/promosi/:id` | login |
| GET | `/api/stats` | login |
| GET | `/uploads/users|umkm/:file` | publik (foto existing) |

## Halaman React

Publik: `/` (direktori + cari), `/umkm/:id` (detail), `/peta` (Leaflet + poligon + data live),
`/login`, `/register`. Admin/Owner (login): `/dashboard`, `/umkm`, `/usaha/:id`, `/promosi`,
`/peta`, `/profil`. Khusus Admin: `/users`.

Halaman Peta memakai `frontend/public/data/kecamatan-polygons.json` — hasil ekstrak
`scripts/extract-polygons.mjs` dari `application/views/peta.php`, jadi geometri poligon
100% identik dengan CI3.

## Keamanan

- Parameterized queries di semua repository (allowlist kolom untuk SET dinamis).
- Respons auth tidak pernah memuat hash password.
- Upload: 2MB, jpg/png/gif, nama acak — parity config CI3.
- `.env` tidak masuk Git (lihat `.gitignore`).

## Dokumen migrasi

- `MIGRATION_MAP.md` — peta fitur CI3 → API baru → halaman React + status.
- `ARCHITECTURE.md` — topologi target.
- `database/backup-skripsi-2026-10-01.sql` — backup fresh sebelum migrasi tulis.
