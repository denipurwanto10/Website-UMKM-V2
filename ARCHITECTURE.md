# ARCHITECTURE — Target React + Node.js + MySQL (existing DB)

## 1. Topologi target

```text
React + TS (Vite, Tailwind, shadcn/ui, shadcn-admin pola, Router, TanStack Query, RHF+Zod)
  │  REST JSON {success,message,data} — JWT Bearer
Node.js + TS (Express): routes → controllers → services → repositories → mysql2 pool
  │  parameterized queries only
MySQL `skripsi` EXISTING (users, umkm, promosi, platform[?]) — TANPA DROP/RENAME/RESET
CI3 legacy tetap jalan (document root tidak berubah) sampai final verification lolos
```

## 2. Struktur folder baru (di dalam root ini)

```text
frontend/  (Vite+TS: src/{assets,components/ui,layouts,pages,routes,hooks,services,lib,types,utils}, App.tsx, main.tsx)
backend/   (src/{config,routes,controllers,services,repositories,middleware,validators,models,utils}, server.ts + package.json + tsconfig.json)
legacy/    ← PINDAHAN application+system+index.php bila decommission (JANGAN sekarang)
MIGRATION_MAP.md, ARCHITECTURE.md (ini), README.md, API.md (nanti), .env.example (nanti)
```

Sneat `assets/` dipakai ulang secukupnya (CSS/img) — JANGAN bawa Bootstrap-nya bila shadcn mencukupi.

## 3. Kontrak API (ikut pola existing, dibakukan)

Base `/api`. Envelope: sukses `{success:true,message,data}` / gagal `{success:false,message,data:null}` + HTTP code benar (200/201/400/401/403/404/409/500). JANGAN expose SQL/stack/secret. Auth: `Authorization: Bearer <JWT>` (ganti skema `Bearer` — CI3 kirim `Bearer` string literal hari ini, samakan). Validasi ganda: Zod (FE) + validator (BE, port aturan form_validation CI3: users alpha_numeric+email+min8+matches, umkm required 9 field, promosi required 6 field).

## 4. Auth & authorization (perubahan terbesar)

Hari ini: session CI3 di FE-admin + JWT Node 1 jam yang hampir tak diverifikasi (cuma /api/profile). Target: login → Node keluarkan JWT (secret dari env, bukan 'secretkey123') → React simpan httpOnly cookie/token + guard route per `usertype` → **SEMUA endpoint tulis (POST/PUT/DELETE) wajib verifyToken + cek role** (Admin penuh; Owner hanya `username==sendiri` + umkm/promosi miliknya). FE guard BUKAN pengganti BE guard.

## 5. Aturan DB & query

`mysql2/promise` pool (env DB_HOST/PORT/NAME/USER/PASS), `?` binding di semua query (sudah begitu — pertahankan), repository per tabel (user/umkm/promosi.repository.ts), service untuk aturan bisnis (cek_username, guard promosi, bangun link marketplace, normalisasi wa 0→62). Prisma TIDAK disarankan (introspect-only pun risiko drift; mysql2 cukup).

## 6. Frontend

shadcn-admin layout (Sidebar data-driven dari fitur §6 inventory — tanpa menu dummy; mobile Sheet/Drawer), Table+Pagination shadcn untuk semua list, RHF+Zod untuk 3 form besar (User, UMKM 30-field, Promosi), TanStack Query (`services/*.service.ts`, state loading/empty/error), Lucide icons. Peta: Leaflet + GeoJSON hasil konversi QGIS shapefile (spike terpisah — file 9631 baris jangan diport mentah).

## 7. Risiko & keputusan tertunda

1. `platform` mati? → butuh jawaban owner (opsi: drop dari scope).
2. Secret JWT + kredensial DB masih hardcoded → pindah ke .env/.env.example + gitignore SEBELUM coding.
3. `DELETE users` akan ditolak FK bila user punya umkm/promosi → tentukan UX (blok + pesan vs cascade manual).
4. Password hash campuran `$2a$`/`$2y$` → pastikan bcryptjs verify keduanya lolos.
5. Repo ini BUKAN git — `git init` + checkpoint audit dulu.
