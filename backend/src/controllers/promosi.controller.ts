import type { Response } from 'express';
import type { AuthRequest } from '../middleware/auth';
import * as promosiService from '../services/promosi.service';
import { createPromosiSchema, updatePromosiSchema } from '../validators/promosi.validator';
import { fail, ok } from '../utils/respond';

export async function list(_req: AuthRequest, res: Response) {
  return ok(res, await promosiService.findAllPromosi());
}

export async function byUsername(req: AuthRequest, res: Response) {
  const data = await promosiService.findPromosiByUsername(req.params.username);
  if (data.length === 0) return fail(res, 'Belum ada promosi untuk user ini', 404);
  return ok(res, data);
}

export async function detail(req: AuthRequest, res: Response) {
  const data = await promosiService.findPromosiById(Number(req.params.id));
  if (!data) return fail(res, 'Data promosi tidak ditemukan', 404);
  return ok(res, data);
}

export async function create(req: AuthRequest, res: Response) {
  const parsed = createPromosiSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const id = await promosiService.createPromosi(parsed.data, req.user);
    return ok(res, { id }, 'Data promosi berhasil disimpan', 201);
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function update(req: AuthRequest, res: Response) {
  const parsed = updatePromosiSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const data = await promosiService.updatePromosiById(Number(req.params.id), parsed.data, req.user);
    return ok(res, data, 'Data promosi berhasil diperbarui');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function remove(req: AuthRequest, res: Response) {
  try {
    await promosiService.deletePromosiById(Number(req.params.id), req.user);
    return ok(res, null, 'Data promosi berhasil dihapus');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}
