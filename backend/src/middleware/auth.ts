import type { NextFunction, Request, Response } from 'express';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';
import type { JwtPayload, Usertype } from '../models/types';
import { fail } from '../utils/respond';

export interface AuthRequest extends Request {
  user?: JwtPayload;
}

/** Wajib JWT Bearer — pengganti verifyToken legacy (dulu hanya dipakai 1 endpoint). */
export function requireAuth(req: AuthRequest, res: Response, next: NextFunction) {
  const header = req.headers.authorization ?? '';
  const [scheme, token] = header.split(' ');
  if (scheme !== 'Bearer' || !token) return fail(res, 'Token tidak ditemukan', 401);
  try {
    req.user = jwt.verify(token, env.authSecret) as JwtPayload;
    return next();
  } catch {
    return fail(res, 'Token tidak valid atau kedaluwarsa', 401);
  }
}

/** Batasi role. Pakai setelah requireAuth. */
export function requireRole(...roles: Usertype[]) {
  return (req: AuthRequest, res: Response, next: NextFunction) => {
    if (!req.user) return fail(res, 'Token tidak ditemukan', 401);
    if (!roles.includes(req.user.usertype)) return fail(res, 'Akses ditolak', 403);
    return next();
  };
}

/**
 * Owner hanya boleh akses datanya sendiri (param :username miliknya),
 * Admin boleh semua. Pakai untuk endpoint per-username milik owner.
 */
export function requireSelfOrAdmin(paramName = 'username') {
  return (req: AuthRequest, res: Response, next: NextFunction) => {
    if (!req.user) return fail(res, 'Token tidak ditemukan', 401);
    if (req.user.usertype === 'Admin') return next();
    if (req.params[paramName] === req.user.username) return next();
    return fail(res, 'Akses ditolak', 403);
  };
}
