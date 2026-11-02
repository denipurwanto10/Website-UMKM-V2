/** URL foto upload existing — dilayani backend baru via /uploads (parity CI3 base_url('uploads/...')). */
export function uploadUrl(sub: 'users' | 'umkm', file?: string | null): string {
  const base = (import.meta.env.VITE_API_URL as string | undefined ?? 'http://localhost:3001/api').replace(/\/api\/?$/, '');
  const name = file && file.trim() !== '' ? file : 'default.png';
  return `${base}/uploads/${sub}/${name}`;
}
