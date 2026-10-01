import type { Response } from 'express';
import type { AuthRequest } from '../middleware/auth';
import * as userService from '../services/user.service';
import { createUserSchema, updateUserSchema } from '../validators/user.validator';
import { fail, ok } from '../utils/respond';

function photoName(req: AuthRequest): string | undefined {
  const file = (req.files as Express.Multer.File[] | undefined)?.[0];
  return file?.filename;
}

export async function list(_req: AuthRequest, res: Response) {
  return ok(res, await userService.findAllUsers());
}

export async function detail(req: AuthRequest, res: Response) {
  const data = await userService.findPublicUser(req.params.username);
  if (!data) return fail(res, 'User tidak ditemukan', 404);
  return ok(res, data);
}

export async function create(req: AuthRequest, res: Response) {
  const parsed = createUserSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const data = await userService.createUser({ ...parsed.data, photo: photoName(req) ?? 'default.png' });
    return ok(res, data, 'User berhasil ditambahkan', 201);
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function update(req: AuthRequest, res: Response) {
  const parsed = updateUserSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const data = await userService.updateUser(req.params.username, { ...parsed.data, photo: photoName(req) }, req.user);
    return ok(res, data, 'User berhasil diperbarui');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function remove(req: AuthRequest, res: Response) {
  try {
    await userService.deleteUser(req.params.username);
    return ok(res, null, 'User berhasil dihapus');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}
