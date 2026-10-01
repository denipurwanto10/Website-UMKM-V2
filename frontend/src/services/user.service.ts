import api from './api';
import type { User } from '../types';
import type { Envelope } from './api';

export async function listUsers() {
  const res = await api.get<Envelope<User[]>>('/users');
  return res.data.data;
}

export async function userDetail(username: string) {
  const res = await api.get<Envelope<User>>(`/users/${username}`);
  return res.data.data;
}

export async function createUser(payload: Record<string, unknown>, photo?: File) {
  const form = new FormData();
  Object.entries(payload).forEach(([k, v]) => {
    if (v !== undefined && v !== null && v !== '') form.append(k, String(v));
  });
  if (photo) form.append('photo', photo);
  const res = await api.post<Envelope<User>>('/users', form);
  return res.data.data;
}

export async function updateUser(username: string, payload: Record<string, unknown>, photo?: File) {
  const form = new FormData();
  Object.entries(payload).forEach(([k, v]) => {
    if (v !== undefined && v !== null && v !== '') form.append(k, String(v));
  });
  if (photo) form.append('photo', photo);
  const res = await api.put<Envelope<User>>(`/users/${username}`, form);
  return res.data.data;
}

export async function deleteUser(username: string) {
  const res = await api.delete<Envelope<null>>(`/users/${username}`);
  return res.data;
}
