import api from './api';
import type { Umkm } from '../types';
import type { Envelope } from './api';

export async function listUmkm() {
  const res = await api.get<Envelope<Umkm[]>>('/umkm');
  return res.data.data;
}

export async function umkmByStatus(status: string) {
  const res = await api.get<Envelope<Umkm[]>>(`/umkm/status/${status}`);
  return res.data.data;
}

export async function umkmByUsername(username: string) {
  const res = await api.get<Envelope<Umkm[]>>(`/umkm/user/${username}`);
  return res.data.data;
}

export async function umkmDetail(id: number) {
  const res = await api.get<Envelope<Umkm>>(`/umkm/${id}`);
  return res.data.data;
}

export async function createUmkm(payload: Record<string, unknown>, photo?: File) {
  const form = new FormData();
  Object.entries(payload).forEach(([k, v]) => {
    if (v !== undefined && v !== null && v !== '') form.append(k, String(v));
  });
  if (photo) form.append('photo_umkm', photo);
  const res = await api.post<Envelope<{ id: number }>>('/umkm', form);
  return res.data.data;
}

export async function updateUmkm(id: number, payload: Record<string, unknown>, photo?: File) {
  const form = new FormData();
  Object.entries(payload).forEach(([k, v]) => {
    if (v !== undefined && v !== null && v !== '') form.append(k, String(v));
  });
  if (photo) form.append('photo_umkm', photo);
  const res = await api.put<Envelope<unknown>>(`/umkm/${id}`, form);
  return res.data.data;
}

export async function deleteUmkm(id: number) {
  const res = await api.delete<Envelope<null>>(`/umkm/${id}`);
  return res.data;
}

export async function mapCounts() {
  const res = await api.get<Envelope<{ kecamatan: string; jumlah: number }[]>>('/umkm/status/disetujui/count');
  return res.data.data;
}
