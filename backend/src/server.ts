import cors from 'cors';
import dotenv from 'dotenv';
import express from 'express';
import path from 'node:path';
import { env } from './config/env';
import { pool } from './config/db';
import { authRoutes } from './routes/auth.routes';
import { promosiRoutes } from './routes/promosi.routes';
import { umkmRoutes } from './routes/umkm.routes';
import { userRoutes } from './routes/user.routes';
import { stats } from './controllers/stats.controller';

dotenv.config();

const app = express();
// CORS dev: izinkan localhost maupun 127.0.0.1 (port berapa pun), plus FRONTEND_URL.
// Tanpa ini, buka via http://127.0.0.1:5173 diblokir browser padahal backend sehat.
app.use(
  cors({
    origin: (origin, cb) => {
      if (!origin) return cb(null, true);
      try {
        const host = new URL(origin).hostname;
        if (host === 'localhost' || host === '127.0.0.1') return cb(null, true);
      } catch {
        /* abaikan, cek allowlist di bawah */
      }
      if (origin === env.frontendUrl) return cb(null, true);
      return cb(null, false);
    },
  }),
);
app.use(express.json({ limit: '2mb' }));

// Layani file upload existing (CI3 base_url('uploads/...')) lewat API baru juga,
// agar foto lama yang sudah ada tetap bisa ditampilkan React.
app.use('/uploads', express.static(path.resolve(__dirname, '..', env.uploadDir)));

app.get('/api/health', (_req, res) => res.json({ success: true, message: 'OK', data: { db: env.db.database } }));
app.use('/api/auth', authRoutes);
app.use('/api/users', userRoutes);
app.use('/api/umkm', umkmRoutes);
app.use('/api/promosi', promosiRoutes);
app.get('/api/stats', stats);

// 404 JSON konsisten (bukan HTML Express)
app.use('/api', (_req, res) => res.status(404).json({ success: false, message: 'Endpoint tidak ditemukan', data: null }));

const server = app.listen(env.port, () => {
  console.log(`Backend baru jalan di http://localhost:${env.port} (DB: ${env.db.database})`);
});

// Cek koneksi MySQL saat boot — gagal = matikan dengan pesan jelas, bukan jalan setengah
pool.query('SELECT 1').catch((err: Error) => {
  console.error('Gagal konek MySQL:', err.message);
  server.close(() => process.exit(1));
});
