import path from 'node:path';
import multer from 'multer';
import { env } from '../config/env';

const ALLOWED = new Set(['image/jpeg', 'image/png', 'image/gif']);

function destFor(field: string): string {
  // Samakan dengan folder existing: uploads/users, uploads/umkm
  const sub = field === 'photo_umkm' ? 'umkm' : 'users';
  return path.resolve(__dirname, '..', '..', env.uploadDir, sub);
}

const storage = multer.diskStorage({
  destination: (_req, file, cb) => cb(null, destFor(file.fieldname)),
  filename: (_req, file, cb) => {
    const ext = path.extname(file.originalname).toLowerCase();
    cb(null, `${Date.now()}-${Math.round(Math.random() * 1e9)}${ext}`);
  },
});

function fileFilter(_req: Express.Request, file: Express.Multer.File, cb: multer.FileFilterCallback) {
  if (!ALLOWED.has(file.mimetype)) return cb(new Error('Tipe file tidak diizinkan (jpg/png/gif)'));
  cb(null, true);
}

// Batas 2MB — sama seperti config upload CI3 (max_size 2048)
export const upload = multer({ storage, fileFilter, limits: { fileSize: 2 * 1024 * 1024 } });
