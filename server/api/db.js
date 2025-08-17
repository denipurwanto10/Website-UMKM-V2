// db.js
const mysql = require('mysql2');

// Membuat pool koneksi ke database MySQL
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',  // Masukkan password MySQL Anda jika diperlukan
  database: 'skripsi',  // Nama database Anda
});

module.exports = pool.promise();
