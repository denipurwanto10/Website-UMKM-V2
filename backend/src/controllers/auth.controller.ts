import type { Response } from 'express';
import type { AuthRequest } from '../middleware/auth';
import * as authService from '../services/auth.service';
import { loginSchema, registerSchema } from '../validators/user.validator';
import { fail, ok } from '../utils/respond';

export async function login(req: AuthRequest, res: Response) {
  const parsed = loginSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const data = await authService.login(parsed.data.username, parsed.data.password);
    return ok(res, data, 'Login berhasil');
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

export async function register(req: AuthRequest, res: Response) {
  const parsed = registerSchema.safeParse(req.body);
  if (!parsed.success) return fail(res, parsed.error.issues[0].message, 400);
  try {
    const data = await authService.register(parsed.data);
    return ok(res, data, 'Registrasi berhasil, silakan login', 201);
  } catch (err) {
    return fail(res, (err as Error).message, (err as { status?: number }).status ?? 500);
  }
}

/** JWT stateless — logout cukup buang token di klien. */
export function logout(_req: AuthRequest, res: Response) {
  return ok(res, null, 'Logout berhasil');
}

/** GET /api/auth/me — profil user dari token (pengganti CI3 session user). */
export async function me(req: AuthRequest, res: Response) {
  const username = req.user!.username;
  const { findPublicUser } = await import('../services/user.service');
  const user = await findPublicUser(username);
  if (!user) return fail(res, 'User tidak ditemukan', 404);
  return ok(res, user, 'Profil berhasil diambil');
}
