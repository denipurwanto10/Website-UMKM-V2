import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'http://localhost:3001/api',
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

api.interceptors.response.use(
  (res) => res,
  (err) => {
    if (err.response?.status === 401) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      if (window.location.pathname !== '/login') window.location.href = '/login';
    }
    return Promise.reject(err);
  },
);

export interface Envelope<T> {
  success: boolean;
  message: string;
  data: T;
}

export function apiError(err: unknown): string {
  if (axios.isAxiosError(err)) {
    // Ada respons dari server (4xx/5xx) — pakai pesan server.
    if (err.response?.data && typeof err.response.data === 'object' && 'message' in err.response.data) {
      return String((err.response.data as { message: unknown }).message);
    }
    // Tidak ada respons sama sekali — backend mati / URL salah / jaringan putus.
    if (err.request && !err.response) {
      return 'Tidak dapat terhubung ke server (http://localhost:3001). Pastikan backend jalan via `npm run dev` di folder backend.';
    }
    return 'Terjadi kesalahan server';
  }
  return err instanceof Error ? err.message : 'Terjadi kesalahan';
}

export default api;
