import type { Response } from 'express';
import type { AuthRequest } from '../middleware/auth';
import * as umkmService from '../services/umkm.service';
import { createUmkmSchema, updateUmkmSchema } from '../validators/umkm.validator';
import { fail, ok } from '../utils/respond';
import type { UmkmStatus } from '../models/types';

const STATUSES: UmkmStatus[] = ['menunggu', 'disetujui', 'ditolak'];

function photoName(req: AuthRequest): string | undefined {
  const file = (req.files as Express.Multer.File[] | undefined)?.[0];
  return file?.filename;
}

export async function list(_req: AuthRequest, res: Response) {
  return ok(res, await umkmService.findAllUmkm());
}

export async function byUsername(req: AuthRequest, res: Response) {
  return ok(res, await umkmService.findUmkmByUsername(req.params.username));
}

export async function byStatus(req: AuthRequest, res: Response) {
  const status = req.params.status as UmkmStatus;
  if (!STATUSES.includes(status)) return fail(res, 'Status tidak valid', 400);
  return ok(res, await umkmService.findUmkmByStatus(status));
}

export async function detail(req: AuthRequest, res: Response) {
  const data = await umkmService.findUmkmDetailById(Number(req.params.id));
  if (!data) return fail(res, 'UMKM tidak ditemukan', 404);
  return ok(res, data);
}

export async function create(req: AuthRequest, res: Response) {
  const parsed = createUmkmSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const id = await umkmService.createUmkm(
      { ...(parsed.data as Record<string, string | number | null>), photo: photoName(req) ?? 'default.png' },
      req.user,
    );
    return ok(res, { id }, 'UMKM berhasil ditambahkan', 201);
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function update(req: AuthRequest, res: Response) {
  const parsed = updateUmkmSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const photo = photoName(req);
    const data = await umkmService.updateUmkmById(
      Number(req.params.id),
      { ...parsed.data, ...(photo ? { photo } : {}) },
      req.user,
    );
    return ok(res, data, 'UMKM berhasil diperbarui');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function remove(req: AuthRequest, res: Response) {
  try {
    await umkmService.deleteUmkmById(Number(req.params.id), req.user);
    return ok(res, null, 'UMKM berhasil dihapus');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

/** Peta: agregasi per kecamatan/desa (port /api/umkm/status/disetujui/count). */
export async function mapCounts(_req: AuthRequest, res: Response) {
  const { countDisetujuiPerKecamatan } = await import('../repositories/umkm.repository');
  return ok(res, await countDisetujuiPerKecamatan());
}
