import 'dotenv/config';

function required(name: string, fallback?: string): string {
  const v = process.env[name] ?? fallback;
  if (v === undefined || v === '') throw new Error(`ENV ${name} belum diisi (lihat backend/.env.example)`);
  return v;
}

export const env = {
  nodeEnv: process.env.NODE_ENV ?? 'development',
  port: Number(process.env.PORT ?? 3001),
  authSecret: required('AUTH_SECRET'),
  authExpiresSeconds: Number(process.env.AUTH_EXPIRES_SECONDS ?? 3600),
  db: {
    host: process.env.DB_HOST ?? 'localhost',
    port: Number(process.env.DB_PORT ?? 3306),
    database: process.env.DB_NAME ?? 'skripsi',
    user: process.env.DB_USER ?? 'root',
    password: process.env.DB_PASSWORD ?? '',
  },
  frontendUrl: process.env.FRONTEND_URL ?? 'http://localhost:5173',
  uploadDir: process.env.UPLOAD_DIR ?? '../uploads',
};
