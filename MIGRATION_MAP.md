# MIGRATION MAP — CI3 + Node.js → React + Node.js + MySQL

> Hasil audit 2026-10-01. CI3 TIDAK dihapus, DB TIDAK diubah. Dokumen ini pemetaan, bukan eksekusi.
> Root project: `C:/laragon/www/skripsi`

## 1. PROJECT SUMMARY

```text
Backend Existing : CodeIgniter 3.1.13 (system/) + PHP (server jalan di PHP 8.4.12)
Frontend Existing: CI3 Views PHP + Sneat template (assets/, sneat-1.0.0/) — BUKAN SPA
Node.js          : Express 4.21.2 di server/api/index.js (1035 baris, ~30 endpoint), Node v26.10.0
Database         : MySQL `skripsi` (dump database/skripsi.sql, 235 baris, server asal 8.4.3)
Jumlah Controller: 7 (Welcome, Auth, Dashboard, Users, Umkm, Promosi, Api)
Jumlah Model     : 0 — application/models/ KOSONG. Semua query ada di Node.js (index.js), CI3 hanya cURL ke localhost:3000
Jumlah View      : 28 file (5 publik + 2 auth + 21 admin + error)
Jumlah Route     : ~45 route di application/config/routes.php
Jumlah Table     : 4 (users, umkm, promosi, platform)
Authentication   : CI3 session (files, sess_save_path=sys temp) + Node JWT (SECRET_KEY='secretkey123' hardcoded) + bcrypt/bcryptjs
Authorization    : usertype enum('Admin','Owner'); duplikasi alur *1 (index1/create1/edit1/…) = filter per-owner; backend TIDAK validasi role (hanya verifyToken di /api/profile)
External API     : TIDAK ADA pihak ketiga. Yang ada: link marketplace yang dikonstruksi (wa.me, shopee, tokopedia, blibli, lazada, fb/ig/tiktok/x) + QGIS shapefile lokal (QGIS/*.shp per kecamatan)
Upload           : uploads/users/, uploads/umkm/, uploads/produk/ — foto user + foto produk UMKM (jpg|jpeg|png|gif, 2MB, encrypt_name)
Report/Export    : TIDAK ADA (no PDF/Excel/CSV/print khusus). Yang mirip laporan: dashboard counts + peta agregasi + tabel admin
```

## 2. DATABASE (EXISTING — JANGAN DIUBAH)

| Tabel | PK | FK | Kolom kunci | Catatan |
|---|---|---|---|---|
| `users` | `username` varchar(20) | — | fullname, usertype enum('Admin','Owner') default Admin, nomor_hp, email, password(bcrypt), photo default 'default.png' | 14 baris seed. Password hash `$2a$/$2y$` campuran (register vs seed) — verifikasi bcrypt harus toleran |
| `umkm` | `id` int AI (316) | `username` → users.username | nama_usaha, nama_merek_produk, kategori_produk, jenis_usaha, pendapatan, jalan, desa_kelurahan, kecamatan, nib/pirt/bpom/halal/haki/lainnya (nullable), online/offline/agen_reseller, deskripsi_produk, photo, status enum('menunggu','disetujui','ditolak') default 'menunggu', catatan default '-', whatsapp/blibli/lazada/shopee/tokopedia/facebook/instagram/tiktok/twitter | 12 baris seed (11 disetujui + 1 menunggu). JOIN ke users.fullname di semua list |
| `promosi` | `id` int AI (136) | `username` → users.username (UNIQUE secara bisnis: 1 promosi per username) | fasilitasi_promosi, hambatan_memasarkan_produk, bantuan_dibutuhkan, berminat_bazar_ramadhan enum Ya/Tidak, berminat_pelatihan_online enum Ya/Tidak | Seed KOSONG. INSERT ditolak bila username tak ada / umkm belum disetujui / promosi sudah ada |
| `platform` | `id` int AI (147) | `username` → users.username, `id_produk` (tanpa FK formal) | whatsapp, blibli, lazada, shopee, tokopedia, facebook, instagram, tiktok, twitter | Seed KOSONG, **TIDAK ADA endpoint Node.js yang menyentuhnya** → UNKNOWN / NEEDS REVIEW (kemungkinan tabel mati / sisa desain lama; kolom marketplace duplikat dengan kolom di `umkm`) |

Index: PRIMARY KEY tiap tabel + KEY fk_username. Tidak ada view/trigger/procedure di dump.
`application/config/database.php` kosong (hostname localhost, user/pass/db blank) — koneksi AKTIF hanya via `server/api/db.js` + pool inline di `index.js` (host localhost, user root, pass '', db skripsi).

## 3. NODE.JS EXISTING (server/api/) —的可 reuse

```text
POST /api/login                        login (bcrypt.compare + JWT 1h) — PAKAI ULANG (perbaiki secret/env)
POST /api/register                      register owner — PAKAI ULANG (tambah validasi)
GET  /api/profile                       verifyToken — contoh middleware, PAKAI POLA ini
GET  /api/users | GET /api/users/usernames | GET /api/users/:username
POST /api/users | PUT /api/users/:username | DELETE /api/users/:username   — CRUD users, PAKAI ULANG (rapikan: callback→async, hapus blok SQLi komentar)
GET  /api/umkm | GET /api/umkm/:id | GET /api/umkm/detail/:id | GET /api/umkm/user/:username
GET  /api/umkm/status/menunggu|disetujui|ditolak | GET /api/umkm/status/disetujui/count
POST /api/umkm | PUT /api/umkm/:id | DELETE /api/umkm/:id   — PAKAI ULANG (terbesar, ~300 baris)
GET  /api/count-owners | /api/count-admins | /api/count-umkm-disetujui
GET  /api/umkm-per-kategori-disetujui | /api/jumlah-jenis-usaha | /api/jumlah-desa-per-kategori | /api/jumlah-desa-per-kecamatan
GET  /api/promosi | GET /api/promosi/:id | GET /api/promosi/user/:username
POST /api/promosi | PUT /api/promosi/:id | DELETE /api/promosi/:id   — PAKAI ULANG (aturan bisnis unik per username)
GET  /api/count-users | GET /api/count-umkm
```

Keputusan: **REUSE + REFACTOR** (pecah 1035-baris index.js → routes/controllers/services/repositories). **JANGAN rewrite logika bisnis** (aturan cek_username, link marketplace, guard promosi).
Masalah wajib perbaiki saat migrasi: SECRET_KEY hardcoded, `pool` tanpa pool options/env, mixing callback+async, `DELETE users` tanpa cek FK (akan gagal bila user punya umkm/promosi), `verifyToken` hanya dipakai 1 endpoint, blok komentar SQL-injection-demo (baris ~85-135) HARUS DIHAPUS.

## 4. CI3 ROUTE → REACT ROUTE → NEW API MAP

| CI3 Route | Controller::method | React Route (usulan) | New API (usulan, reuse existing) | Status |
|---|---|---|---|---|
| `/` | Welcome::index (4 random disetujui) | `/` Home | GET /api/umkm/status/disetujui | Pending |
| `/all` | Auth::all (filter kategori/nama) | `/umkm` | GET /api/umkm/status/disetujui (+query ?kategori=&nama_usaha=&merek=) | Pending |
| `/cari?...` | Auth::cari | `/cari` (bisa gabung /umkm) | sama (filter server-side — perbaikan dari filter in-PHP) | Pending |
| `/peta` | Auth::peta | `/peta` | GET /api/umkm/status/disetujui/count + agregasi kecamatan | Pending |
| `/detail/:num` | Auth::detail | `/umkm/:id` | GET /api/umkm/detail/:id | Pending |
| `/login`, `/auth/form_login`, `/login/submit` | Auth::form_login/login | `/login` | POST /api/auth/login (dari POST /api/login) | Pending |
| `/register` | Auth::register | `/register` | POST /api/auth/register (dari POST /api/register) | Pending |
| `/logout` | Auth::logout (sess_destroy) | action logout (hapus token) | POST /api/auth/logout (stateless, opsional) | Pending |
| `/dashboard` | Dashboard::index | `/dashboard` (admin layout) | GET /api/count-users, /count-umkm, /count-owners, agregasi | Pending |
| `/api/stats` | Api::stats (proxy counts) | — (diganti TanStack Query langsung ke Node) | GET /api/stats (pertahankan proxy bila CORS dibutuhkan) | Pending |
| `/users`, `/users1` | Users::index/index1 | `/users` (1 page + filter role, ganti users1) | GET /api/users | Pending |
| `/users/create`, `/users/create1` | Users::create/create1 | `/users/new` | — (form) | Pending |
| `/users/store`, `/users/store1` | Users::store/store1 | action | POST /api/users | Pending |
| `/users/edit/*`, `/users/edit1/*` | Users::edit/edit1 | `/users/:username/edit` | GET /api/users/:username | Pending |
| `/users/update/*`, `/users/update1/*` | Users::update/update1 | action | PUT /api/users/:username | Pending |
| `/users/delete/*`, `/users/delete1/*` | Users::delete/delete1 | action | DELETE /api/users/:username | Pending |
| `/profil` | Users::profil | `/profil` | GET /api/users/:username (session user) | Pending |
| `/umkm/menunggu|disetujui|ditolak` | Umkm::menunggu/disetujui/ditolak | `/umkm/menunggu`, `/umkm/disetujui`, `/umkm/ditolak` (atau 1 page + tab status) | GET /api/umkm/status/:status | Pending |
| `/data_umkm` | Umkm::data_umkm (milik owner) | `/umkm-saya` | GET /api/umkm/user/:username | Pending |
| `/umkm/create`, `/umkm/create1`, `/umkm/create_umkm` | Umkm::create/create1/create_umkm | `/umkm/new` | GET /api/users (dropdown username, admin saja) | Pending |
| `/umkm/store`, `/umkm/store1` | Umkm::store/store1 | action | POST /api/umkm | Pending |
| `/umkm/edit/:num`, `/umkm/edit1/:num` | Umkm::edit/edit1 | `/umkm/:id/edit` | GET /api/umkm/:id | Pending |
| `/umkm/update/:num`, `/umkm/update1/:num` | Umkm::update/update1 | action | PUT /api/umkm/:id | Pending |
| `/umkm/delete/:num`, `/umkm/delete1/:num`, `/umkm/disetujui/delete/:num`, `/umkm/ditolak/delete/:num` | Umkm::delete* | action | DELETE /api/umkm/:id | Pending |
| `/promosi`, `/promosi1` | Promosi::index/index1 | `/promosi` (1 page + filter owner) | GET /api/promosi | Pending |
| `/promosi/create`, `/promosi/create1` | Promosi::create/create1 | `/promosi/new` | GET /api/users | Pending |
| `/promosi/store`, `/promosi/store1` | Promosi::store/store1 | action | POST /api/promosi | Pending |
| `/promosi/edit/:num`, edit1 | Promosi::edit/edit1 | `/promosi/:id/edit` | GET /api/promosi/:id | Pending |
| `/promosi/update/:num`, update1 | Promosi::update/update1 | action | PUT /api/promosi/:id | Pending |
| `/promosi/delete/:num`, delete1 | Promosi::delete/delete1 | action | DELETE /api/promosi/:id | Pending |

Catatan: rute `*1` (owner) dilebur — 1 React page + filter `?mine=` / role guard. Jangan port duplikasi view `users1/promosi1/create_*1/edit_*1` 1:1.

## 5. CI3 VIEW → REACT PAGE MAP

| CI3 View | Dipakai oleh | React Page | Komponen reuse (shadcn/ui) |
|---|---|---|---|
| views/index.php (514) | Welcome::index | HomePage.tsx | Card, Button, Badge |
| views/all.php (295) | Auth::all | UmkmListPage.tsx | Table/Input/Select/Pagination |
| views/cari.php (335) | Auth::cari | (gabung UmkmListPage + filter) | Form, Input, Select |
| views/detail.php (320) | Auth::detail | UmkmDetailPage.tsx | Card, Badge, Breadcrumb |
| views/peta.php (9631!) | Auth::peta | PetaPage.tsx | Card + Leaflet (BUKAN shadcn; file terbesar — butuh spike QGIS→GeoJSON) |
| views/auth/form_login.php | Auth | LoginPage.tsx | Form, Input, Button, Alert |
| views/auth/register.php | Auth | RegisterPage.tsx | Form, Input, Button |
| views/error_umkm.php | Auth::detail fail | ErrorState (inline, bukan page) | Alert |
| admin/dashboard.php (633) | Dashboard | DashboardPage.tsx | Card (stats), Chart (agregasi — pilih 1 lib) |
| admin/sidebar.php (223) + layout_footer.php (98) | semua admin | AdminLayout.tsx (Sidebar+Header) | Sidebar, Sheet (mobile), Breadcrumb, DropdownMenu |
| admin/users.php (625) | Users::index | UsersPage.tsx | Table, Pagination, Dialog (delete), Badge |
| admin/users1.php (195) | Users::index1 | (lebur ke UsersPage) | — |
| admin/create_user.php (502) | Users::create/create1 | UserForm.tsx (new+edit) | Form, Input, Select, Button, Toast |
| admin/edit_user.php (453), edit_user1.php (437) | Users::edit/edit1 | (lebur ke UserForm) | — |
| admin/menunggu.php (663), disetujui.php (807), ditolak.php (664) | Umkm::menunggu/disetujui/ditolak | UmkmStatusPage.tsx (tab Menunggu/Disetujui/Ditolak) | Table, Tabs, Badge, Pagination |
| admin/data_umkm.php (680) | Umkm::data_umkm | UmkmSayaPage.tsx (atau filter mine di UmkmStatusPage) | Table, Card |
| admin/create_umkm.php (1003), create_umkm1.php (963) | Umkm::create* | UmkmForm.tsx | Form (besar! ~30 field), Input, Select, Textarea, Checkbox |
| admin/edit_umkm.php (1075), edit_umkm1.php (1086) | Umkm::edit* | (lebur ke UmkmForm) | — |
| admin/promosi.php (650), promosi1.php (657) | Promosi::index/index1 | PromosiPage.tsx | Table, Dialog |
| admin/create_promosi.php (512), create_promosi1.php (470) | Promosi::create* | PromosiForm.tsx | Form, Select, RadioGroup |
| admin/edit_promosi.php (418), edit_promosi1.php (414) | Promosi::edit* | (lebur ke PromosiForm) | — |
| admin/profil.php (168) | Users::profil | ProfilPage.tsx | Card, Avatar |

Business logic yang TIDAK BOLEH hilang saat port form: konstruksi link marketplace (wa 0→62 + prefix per platform), checkbox online/offline/agen_reseller → string|null, validasi CI3 (lihat §7), flashdata success/error → toast.

## 6. FEATURE INVENTORY

| # | Feature | Files (CI3 + Node) | Tables | Dependencies | Complexity | Status |
|---|---|---|---|---|---|---|
| 1 | Auth: login/logout/session+JWT | Auth::login/logout, form_login view, index.js POST /api/login + verifyToken | users | bcrypt, JWT, CI session | Sedang (secret hardcoded, regex-block SQLi di CI3 harus jadi validasi benar) | Pending |
| 2 | Register Owner publik | Auth::register, register view, index.js POST /api/register | users | bcrypt | Rendah–Sedang | Pending |
| 3 | Users CRUD + foto (Admin & Owner) | Users.php (534) full, 5 views user | users | uploads/users/, CI upload lib | Sedang (duplikasi *1, upload encrypt_name) | Pending |
| 4 | UMKM lifecycle: create→menunggu→disetujui/ditolak + catatan | Umkm.php (926!) full, 8 views umkm | umkm (+users untuk dropdown) | uploads/umkm?, link marketplace | Tinggi (form 30+ field, file terbesar ke-2) | Pending |
| 5 | UMKM milik-owner (data_umkm) | Umkm::data_umkm, data_umkm.php | umkm | JWT/session username | Rendah (filter username) | Pending |
| 6 | Promosi: 1 per username, syarat UMKM disetujui | Promosi.php (594) full, 6 views promosi | promosi, users, umkm (cek) | — | Sedang (aturan bisnis unik) | Pending |
| 7 | Dashboard + counts/agregasi | Dashboard.php, dashboard.php, Api.php, 8 endpoint count/* | users, umkm | Chart lib (pilih 1) | Rendah–Sedang | Pending |
| 8 | Publik: home/all/cari/detail | Welcome.php, Auth::all/cari/detail, 4 views | umkm | — | Rendah–Sedang | Pending |
| 9 | Peta QGIS/Leaflet per kecamatan | Auth::peta, peta.php (9631 baris!), QGIS/*.shp, assets/map/ | umkm (agregasi kecamatan) | Leaflet + shapefile→GeoJSON | Tinggi (file terbesar, risiko paling besar) | Pending — spike dulu |
| 10 | Upload foto (user+produk) | Users::store/update (CI upload), Umkm store/update | users.photo, umkm.photo | uploads/, MIME+size validation | Sedang | Pending |
| 11 | Profil user | Users::profil, profil.php | users | — | Rendah | Pending |
| 12 | platform table | HANYA di skripsi.sql, tanpa endpoint/view | platform | — | UNKNOWN — NEEDS REVIEW | Blocked (tanya owner) |

Tidak ada: laporan PDF/Excel/CSV, cron, websocket, integrasi API eksternal, CI3 model/library/hook kustom (libraries/ & hooks/ kosong, helper hanya curl_helper.php tak terpakai di controller).

## 7. QUERY MAP (CI3 → Node → New Repository)

CI3 TIDAK punya `$this->db` sama sekali (0 hasil di controllers). Semua query di `server/api/index.js` (parameterized `?` — AMAN, kecuali blok komentar demo-SQLi yang harus dihapus):

```text
users:  SELECT * (list) | SELECT WHERE username (detail/login/register-cek/update-cek) | INSERT 7 kolom | UPDATE SET fullname,usertype,nomor_hp,email,password,photo | DELETE WHERE username
        ↓  user.repository.ts  ↓  tabel users
umkm:   SELECT umkm.* + users.fullname JOIN (list/status/user/detail) | SELECT WHERE id | INSERT ~30 kolom | UPDATE SET dinamis | DELETE WHERE id
        + SELECT COUNT(*) disetujui | GROUP BY kategori_produk / jenis_usaha / desa-per-kategori / desa-per-kecamatan
        ↓  umkm.repository.ts  ↓  tabel umkm
promosi: SELECT promosi.* + users.fullname JOIN | SELECT WHERE id/username | INSERT 6 kolom (guard: user ada? umkm disetujui? promosi belum ada?) | UPDATE | DELETE
        ↓  promosi.repository.ts  ↓  tabel promosi
```

## 8. URUTAN MIGRASI (berdasar dependency teknis)

```text
0. Baseline: backup DB (mysqldump), .env.example, git init + commit "chore: migration audit"   ← LAKUKAN DULU (repo ini belum git!)
1. Backend foundation: Express+TS skeleton (route→controller→service→repository), pool mysql2 via env, error envelope {success,message,data}, hapus blok SQLi-demo
2. Auth (blokir semua fitur lain): POST /api/auth/login|register + middleware JWT dari verifyToken → proteksi SEMUA /api/* (saat ini terbuka!)
3. Users CRUD + upload (tanpa ini dropdown username di form UMKM/promosi kosong)
4. UMKM core + status workflow (fitur inti skripsi; verifikasi parity form 30-field + link marketplace)
5. Promosi (tergantung 3+4: guard username & status disetujui)
6. Dashboard/stats + AdminLayout (shadcn-admin) — butuh 2–5 untuk angka nyata
7. Publik: home/all/cari/detail (read-only dari 4) + profil
8. Peta (terakhir: butuh spike shapefile→GeoJSON + data agregasi 4; risiko tertinggi)
9. UNKNOWN: platform — minta keputusan owner SEBELUM coding (hapus? migrasikan? tabel mati?)
```

Per fitur: API → test API (curl/http) → React page → test CRUD → parity check vs CI3 → tandai Complete. JANGAN parallel sebelum Auth selesai.
