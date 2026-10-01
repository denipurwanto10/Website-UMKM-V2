import { pool } from '../config/db';
import type { PromosiRow } from '../models/types';

export async function findAllPromosi(): Promise<PromosiRow[]> {
  const [rows] = await pool.query(
    `SELECT promosi.*, users.fullname FROM promosi
     JOIN umkm ON promosi.username = umkm.username
     JOIN users ON umkm.username = users.username
     WHERE umkm.status = 'disetujui' ORDER BY promosi.id DESC`,
  );
  return rows as PromosiRow[];
}

export async function findPromosiById(id: number): Promise<PromosiRow | null> {
  const [rows] = await pool.query('SELECT * FROM promosi WHERE id = ?', [id]);
  const list = rows as PromosiRow[];
  return list.length > 0 ? list[0] : null;
}

export async function findPromosiByUsername(username: string): Promise<PromosiRow[]> {
  const [rows] = await pool.query('SELECT * FROM promosi WHERE username = ?', [username]);
  return rows as PromosiRow[];
}

export interface CreatePromosiInput {
  username: string;
  fasilitasi_promosi: string;
  hambatan_memasarkan_produk: string;
  bantuan_dibutuhkan: string;
  berminat_bazar_ramadhan: string;
  berminat_pelatihan_online: string;
}

export async function insertPromosi(input: CreatePromosiInput): Promise<number> {
  const [result] = await pool.query(
    `INSERT INTO promosi (username, fasilitasi_promosi, hambatan_memasarkan_produk, bantuan_dibutuhkan, berminat_bazar_ramadhan, berminat_pelatihan_online)
     VALUES (?, ?, ?, ?, ?, ?)`,
    [input.username, input.fasilitasi_promosi, input.hambatan_memasarkan_produk, input.bantuan_dibutuhkan, input.berminat_bazar_ramadhan, input.berminat_pelatihan_online],
  );
  return (result as { insertId: number }).insertId;
}

export async function updatePromosi(id: number, input: Partial<Omit<CreatePromosiInput, 'username'>>): Promise<boolean> {
  // Allowlist kolom — nama kolom TIDAK boleh diinterpolasi dari input mentah user
  const ALLOWED = new Set(['fasilitasi_promosi', 'hambatan_memasarkan_produk', 'bantuan_dibutuhkan', 'berminat_bazar_ramadhan', 'berminat_pelatihan_online']);
  const cols = (Object.keys(input) as (keyof typeof input)[]).filter((c) => ALLOWED.has(c));
  if (cols.length === 0) return true;
  const [result] = await pool.query(
    `UPDATE promosi SET ${cols.map((c) => `${c} = ?`).join(', ')} WHERE id = ?`,
    [...cols.map((c) => input[c]), id],
  );
  return (result as { affectedRows: number }).affectedRows > 0;
}

export async function deletePromosi(id: number): Promise<boolean> {
  const [result] = await pool.query('DELETE FROM promosi WHERE id = ?', [id]);
  return (result as { affectedRows: number }).affectedRows > 0;
}
