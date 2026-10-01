# Sistem Informasi UMKM Kabupaten Bandung

Aplikasi pendataan dan direktori UMKM: portal publik (peta sebaran Leaflet + direktori usaha),
dashboard admin (verifikasi, statistik, grafik), dan portal pemilik usaha (CRUD data UMKM &
promosi). Tema hitam-putih, responsif mobile, dark/light mode.

## Tech Stack

| Lapisan | Teknologi |
|---|---|
| Frontend | React 19, TypeScript, Vite, Tailwind CSS v4, shadcn/ui, React Router, TanStack Query, React Hook Form + Zod, Recharts, Leaflet, lucide-react, sonner |
| Backend | Node.js, Express, TypeScript (tsx saat dev), JWT Bearer, multer, mysql2 |
| Database | MySQL 8 (schema `skripsi`) |

## Struktur

```text
backend/     REST API (Express + TS) — port 3001
frontend/    Aplikasi web (React + Vite) — port 5173 (dev)
scripts/     Util sekali pakai (extract-polygons)
uploads/     Foto runtime (users/, umkm/)
database/    Dump MySQL lokal — TIDAK di-commit (berisi data asli)
```

## Menjalankan

```bash
# 1. Backend (port 3001)
cd backend
cp .env.example .env   # isi AUTH_SECRET + kredensial DB
npm install
npm run dev            # dev — atau: npm run build && npm start

# 2. Frontend (port 5173)
cd frontend
cp .env.example .env   # VITE_API_URL=http://localhost:3001/api
npm install
npm run dev
```

Buka http://localhost:5173 — direktori UMKM tampil dari MySQL live.
Production: `npm run build` di `frontend/` lalu sajikan `dist/`;
set `VITE_API_URL` ke URL API bila beda origin.

## API (port 3001)

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
| GET | `/uploads/users|umkm/:file` | publik (foto) |

## Halaman

Publik: `/` (beranda + direktori), `/usaha/:id` (detail), `/peta` (Leaflet + poligon kecamatan + data live),
`/login`, `/register`. Admin/Owner (login): `/dashboard`, `/umkm`, `/promosi`, `/peta`, `/profil`.
Khusus Admin: `/users`. Route tidak dikenal: halaman 404.

Data poligon peta: `frontend/public/data/kecamatan-polygons.json` (di-generate `scripts/extract-polygons.mjs`).

## Keamanan

- Semua query parameterized (mysql2), allowlist kolom untuk SET dinamis.
- Respons auth tidak pernah memuat hash password.
- Upload dibatasi 2MB, jpg/png/gif, nama file acak.
- `.env` dan dump database tidak masuk Git (lihat `.gitignore`).
