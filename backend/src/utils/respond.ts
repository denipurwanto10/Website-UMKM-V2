import type { Response } from 'express';
import type { ApiEnvelope } from '../models/types';

export function ok<T>(res: Response, data: T, message = 'Data berhasil diambil', status = 200) {
  const body: ApiEnvelope<T> = { success: true, message, data };
  return res.status(status).json(body);
}

export function fail(res: Response, message: string, status = 400) {
  const body: ApiEnvelope<null> = { success: false, message, data: null };
  return res.status(status).json(body);
}
