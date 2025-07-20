# 🌍 Website UMKM V2

Pengembangan Perangkat Lunak Pengolahan Data Geospatial UMKM di Kabupaten Bandung dengan Integrasi Web Service dan Pencegahan SQL Injection 
📍 Studi Kasus: Dinas Perdagangan dan Perindustrian Kabupaten Bandung

![CodeIgniter](https://img.shields.io/badge/frontend-CodeIgniter%203-red.svg)
![Node.js](https://img.shields.io/badge/backend-Node.js-green.svg)
![MySQL](https://img.shields.io/badge/database-MySQL-yellow.svg)
![Leaflet.js](https://img.shields.io/badge/maps-Leaflet.js-brightgreen.svg)
![License](https://img.shields.io/badge/license-MIT-blue.svg)

---

## 📌 Deskripsi Proyek

Website UMKM V2 merupakan pengembangan dari versi sebelumnya dengan penambahan fitur keamanan dan pemetaan lokasi UMKM.  
Sistem ini dibangun menggunakan **CodeIgniter 3** sebagai frontend dan **Node.js (Express)** sebagai backend web service, serta mengintegrasikan **Leaflet.js** untuk menampilkan data UMKM dalam bentuk peta interaktif.  
Semua operasi database menggunakan **parameterized queries** untuk mencegah **SQL Injection**.

---

## ✨ Fitur Baru & Peningkatan

- 🔐 **Pencegahan SQL Injection**: Semua operasi CRUD di-backend menggunakan query parameter
- 🧭 **Web Service (API)**: Backend terpisah dengan Node.js + JWT Auth
- 🗺️ **Peta Interaktif**: Menampilkan data UMKM dalam bentuk polygon menggunakan Leaflet.js
- 📄 **Ekspor PDF**: Cetak laporan UMKM menggunakan jsPDF dan AutoTable
- 🔍 **Search & Pagination**: Navigasi data yang cepat dan efisien
- ⚙️ **Integrasi Sistem**: Frontend (CI3) terhubung ke backend Node.js via HTTP request

---

## 🛠️ Teknologi yang Digunakan

| Komponen        | Teknologi                            |
|------------------|----------------------------------------|
| Frontend         | CodeIgniter 3 (PHP)                   |
| Backend API      | Node.js + Express                     |
| Auth API         | JWT (JSON Web Token)                  |
| Database         | MySQL (Relasional)                    |
| Peta Interaktif  | Leaflet.js + Data Polygon (QGIS)      |
| Ekspor PDF       | jsPDF + AutoTable                     |
| UI               | Bootstrap 5                           |

---


## 📥 Download Source Code

🔗 **[Unduh Source Code Website UMKM V2 (Google Drive)](https://drive.google.com/drive/folders/1_N-wJFxykzO_3pF_PcC8zImsKEWU0__w?usp=sharing)**  
> *Ganti dengan link Google Drive asli kamu.*

---

## 📦 Instalasi

### 1. **Frontend (CodeIgniter 3)**

- Ekstrak folder frontend di `htdocs/Website-UMKM-V2/`
- Import file `.sql` ke MySQL
- Konfigurasi:
  - `application/config/config.php`
  - `application/config/database.php`
  - URL API web service

### 2. **Backend Web Service (Node.js)**

```bash
cd server
npm install
node index.js
