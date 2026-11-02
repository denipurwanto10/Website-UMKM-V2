import api from './api';
import type { Promosi } from '../types';
import type { Envelope } from './api';

export async function listPromosi() {
  const res = await api.get<Envelope<Promosi[]>>('/promosi');
  return res.data.data;
}

export async function promosiByUsername(username: string) {
  const res = await api.get<Envelope<Promosi[]>>(`/promosi/user/${username}`);
  return res.data.data;
}

export async function createPromosi(payload: Record<string, unknown>) {
  const res = await api.post<Envelope<{ id: number }>>('/promosi', payload);
  return res.data.data;
}

export async function updatePromosi(id: number, payload: Record<string, unknown>) {
  const res = await api.put<Envelope<unknown>>(`/promosi/${id}`, payload);
  return res.data.data;
}

export async function deletePromosi(id: number) {
  const res = await api.delete<Envelope<null>>(`/promosi/${id}`);
  return res.data;
}
