import { Router } from 'express';
import * as umkmController from '../controllers/umkm.controller';
import { requireAuth, requireRole } from '../middleware/auth';
import { upload } from '../middleware/upload';

export const umkmRoutes = Router();

// Baca: publik (tanpa login) agar halaman home/all/cari/detail tetap terbuka
// seperti CI3 — parity dengan Auth::all/cari/detail yang tidak butuh session.
umkmRoutes.get('/', umkmController.list);
umkmRoutes.get('/status/disetujui/count', umkmController.mapCounts);
umkmRoutes.get('/status/:status', umkmController.byStatus);
umkmRoutes.get('/user/:username', umkmController.byUsername);
umkmRoutes.get('/:id', umkmController.detail);

// Tulis: wajib login. Owner membuat miliknya; ubah/hapus minimal Owner, Admin semua.
umkmRoutes.post('/', requireAuth, upload.any(), umkmController.create);
umkmRoutes.put('/:id', requireAuth, upload.any(), umkmController.update);
umkmRoutes.delete('/:id', requireAuth, requireRole('Admin', 'Owner'), umkmController.remove);
