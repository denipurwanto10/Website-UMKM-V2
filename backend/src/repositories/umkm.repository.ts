import { pool } from '../config/db';
import type { UmkmRow, UmkmStatus } from '../models/types';

const LIST_COLS = `u.id, u.username, us.fullname, u.nama_usaha, u.nama_merek_produk,
  u.kategori_produk, u.jenis_usaha, u.pendapatan, u.jalan, u.desa_kelurahan, u.kecamatan,
  u.nib, u.pirt, u.bpom, u.halal, u.haki, u.lainnya,
  u.online, u.offline, u.agen_reseller, u.deskripsi_produk,
  u.photo, u.status, u.catatan,
  u.whatsapp, u.blibli, u.lazada, u.shopee, u.tokopedia,
  u.facebook, u.instagram, u.tiktok, u.twitter`;

export async function findAllUmkm(): Promise<UmkmRow[]> {
  const [rows] = await pool.query(
    `SELECT umkm.*, users.fullname FROM umkm JOIN users ON umkm.username = users.username ORDER BY umkm.id DESC`,
  );
  return rows as UmkmRow[];
}

export async function findUmkmById(id: number): Promise<UmkmRow | null> {
  const [rows] = await pool.query('SELECT * FROM umkm WHERE id = ?', [id]);
  const list = rows as UmkmRow[];
  return list.length > 0 ? list[0] : null;
}

export async function findUmkmDetailById(id: number): Promise<UmkmRow | null> {
  const [rows] = await pool.query(
    `SELECT umkm.*, users.fullname FROM umkm JOIN users ON umkm.username = users.username WHERE umkm.id = ?`,
    [id],
  );
  const list = rows as UmkmRow[];
  return list.length > 0 ? list[0] : null;
}

export async function findUmkmByUsername(username: string): Promise<UmkmRow[]> {
  const [rows] = await pool.query(
    `SELECT umkm.*, users.fullname FROM umkm JOIN users ON umkm.username = users.username WHERE umkm.username = ? ORDER BY umkm.id DESC`,
    [username],
  );
  return rows as UmkmRow[];
}

export async function findUmkmByStatus(status: UmkmStatus): Promise<UmkmRow[]> {
  const [rows] = await pool.query(
    `SELECT ${LIST_COLS} FROM umkm u JOIN users us ON u.username = us.username WHERE u.status = ? ORDER BY u.id DESC`,
    [status],
  );
  return rows as UmkmRow[];
}

/** Cek duplikat username aktif — port checkQuery legacy (menunggu/disetujui). */
export async function hasActiveUmkm(username: string): Promise<boolean> {
  const [rows] = await pool.query(
    'SELECT id FROM umkm WHERE username = ? AND (status = "menunggu" OR status = "disetujui") LIMIT 1',
    [username],
  );
  return (rows as unknown[]).length > 0;
}

export type UpsertUmkmInput = Record<string, string | number | null>;

const UMKM_COLUMNS = [
  'username', 'nama_usaha', 'nama_merek_produk', 'kategori_produk', 'jalan',
  'desa_kelurahan', 'kecamatan', 'jenis_usaha', 'pendapatan',
  'nib', 'pirt', 'bpom', 'halal', 'haki', 'lainnya',
  'online', 'offline', 'agen_reseller', 'deskripsi_produk', 'photo',
  'status', 'catatan',
  'whatsapp', 'blibli', 'lazada', 'shopee', 'tokopedia',
  'facebook', 'instagram', 'tiktok', 'twitter',
];

export async function insertUmkm(data: UpsertUmkmInput): Promise<number> {
  const cols = UMKM_COLUMNS.filter((c) => data[c] !== undefined);
  const placeholders = cols.map(() => '?').join(', ');
  const [result] = await pool.query(
    `INSERT INTO umkm (${cols.join(', ')}) VALUES (${placeholders})`,
    cols.map((c) => data[c]),
  );
  return (result as { insertId: number }).insertId;
}

export async function updateUmkm(id: number, data: UpsertUmkmInput): Promise<boolean> {
  const cols = Object.keys(data).filter((c) => UMKM_COLUMNS.includes(c) && c !== 'username');
  if (cols.length === 0) return true;
  const [result] = await pool.query(
    `UPDATE umkm SET ${cols.map((c) => `${c} = ?`).join(', ')} WHERE id = ?`,
    [...cols.map((c) => data[c]), id],
  );
  return (result as { affectedRows: number }).affectedRows > 0;
}

export async function deleteUmkm(id: number): Promise<boolean> {
  const [result] = await pool.query('DELETE FROM umkm WHERE id = ?', [id]);
  return (result as { affectedRows: number }).affectedRows > 0;
}

export async function countUmkm(): Promise<number> {
  const [rows] = await pool.query('SELECT COUNT(*) AS count FROM umkm');
  return (rows as { count: number }[])[0].count;
}

export async function countUmkmByStatus(status: UmkmStatus): Promise<number> {
  const [rows] = await pool.query('SELECT COUNT(*) AS count FROM umkm WHERE status = ?', [status]);
  return (rows as { count: number }[])[0].count;
}

export async function countDisetujuiPerKecamatan(): Promise<unknown[]> {
  const [rows] = await pool.query(
    `SELECT kecamatan, desa_kelurahan, COUNT(*) AS total_desa_kelurahan,
      SUM(LOWER(jenis_usaha) = 'mikro') AS mikro,
      SUM(LOWER(jenis_usaha) = 'kecil') AS kecil,
      SUM(LOWER(jenis_usaha) = 'menengah') AS menengah
    FROM umkm WHERE status = 'disetujui'
    GROUP BY kecamatan, desa_kelurahan ORDER BY kecamatan, desa_kelurahan`,
  );
  return rows as unknown[];
}

export async function countDisetujuiPerKategori(): Promise<unknown[]> {
  const [rows] = await pool.query(
    `SELECT kategori_produk, COUNT(*) AS jumlah_umkm FROM umkm WHERE status = 'disetujui' GROUP BY kategori_produk`,
  );
  return rows as unknown[];
}

export async function countJenisUsaha(): Promise<unknown[]> {
  const [rows] = await pool.query(
    `SELECT jenis_usaha, COUNT(*) AS jumlah FROM umkm WHERE jenis_usaha IN ('Mikro', 'Kecil', 'Menengah') GROUP BY jenis_usaha`,
  );
  return rows as unknown[];
}

/** Port legacy /api/jumlah-desa-per-kategori (tanpa filter status — parity CI3). */
export async function countDesaPerKategori(): Promise<unknown[]> {
  const [rows] = await pool.query(
    `SELECT kategori_produk, COUNT(DISTINCT desa_kelurahan) AS jumlah_desa FROM umkm GROUP BY kategori_produk`,
  );
  return rows as unknown[];
}

/** Port legacy /api/jumlah-desa-per-kecamatan (tanpa filter status — parity CI3). */
export async function countDesaPerKecamatan(): Promise<unknown[]> {
  const [rows] = await pool.query(
    `SELECT kecamatan, COUNT(DISTINCT desa_kelurahan) AS jumlah_desa FROM umkm GROUP BY kecamatan`,
  );
  return rows as unknown[];
}
