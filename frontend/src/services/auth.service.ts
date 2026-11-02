import api from './api';
import type { AuthResponse, User } from '../types';
import type { Envelope } from './api';

export async function login(username: string, password: string) {
  const res = await api.post<Envelope<AuthResponse>>('/auth/login', { username, password });
  return res.data.data;
}

export async function register(payload: {
  username: string;
  fullname: string;
  nomor_hp: string;
  email: string;
  password: string;
  confpassword: string;
}) {
  const res = await api.post<Envelope<User>>('/auth/register', payload);
  return res.data.data;
}

export async function me() {
  const res = await api.get<Envelope<User>>('/auth/me');
  return res.data.data;
}
