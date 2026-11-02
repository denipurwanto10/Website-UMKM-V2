import type { Response } from 'express';
import type { AuthRequest } from '../middleware/auth';
import { getStats } from '../services/umkm.service';
import { ok } from '../utils/respond';

/** GET /api/stats — agregasi dashboard (pengganti 8 endpoint count/* + Api::stats). */
export async function stats(_req: AuthRequest, res: Response) {
  return ok(res, await getStats(), 'Statistik berhasil diambil');
}
