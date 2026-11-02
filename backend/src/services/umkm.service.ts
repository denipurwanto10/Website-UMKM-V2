import {
  countDesaPerKategori,
  countDesaPerKecamatan,
  countDisetujuiPerKategori,
  countDisetujuiPerKecamatan,
  countJenisUsaha,
  countUmkm,
  countUmkmByStatus,
  deleteUmkm,
  findAllUmkm,
  findUmkmById,
  findUmkmByStatus,
  findUmkmByUsername,
  findUmkmDetailById,
  hasActiveUmkm,
  insertUmkm,
  updateUmkm,
  type UpsertUmkmInput,
} from '../repositories/umkm.repository';
import { countUsers, countUsersByType } from '../repositories/user.repository';

export { findAllUmkm, findUmkmById, findUmkmByStatus, findUmkmByUsername, findUmkmDetailById };

import type { Usertype } from '../models/types';

export interface Actor {
  username: string;
  usertype: Usertype;
}

function denyOwnership(): never {
  throw Object.assign(new Error('Akses ditolak: bukan data milik Anda'), { status: 403 });
}

// Prefix per platform — port ensure_https() + konstruksi link Umkm::store()
const PREFIX: Record<string, string> = {
  whatsapp: 'https://wa.me/',
  blibli: 'https://www.blibli.com/user/',
  lazada: 'https://www.lazada.co.id/shop/',
  shopee: 'https://shopee.co.id/',
  tokopedia: 'https://www.tokopedia.com/',
  facebook: 'https://www.facebook.com/',
  instagram: 'https://www.instagram.com/',
  tiktok: 'https://www.tiktok.com/@',
  twitter: 'https://www.x.com/',
};

/**
 * Normalisasi satu link marketplace dari input mentah form.
 * - kosong → null
 * - sudah ada skema http → biarkan (data lama tersimpan sebagai URL jadi)
 * - whatsapp diawali '0' → ganti '62' (port logika Umkm::store)
 * - selain itu → prefix + nilai (port ensure_https Umkm::update)
 */
export function buildLink(field: string, raw: unknown): string | null {
  if (raw === undefined || raw === null) return null;
  const v = String(raw).trim();
  if (v === '') return null;
  if (/^https?:\/\//i.test(v)) return v;
  const prefix = PREFIX[field] ?? '';
  if (field === 'whatsapp') {
    const digits = v.replace(/[^0-9]/g, '');
    const normalized = digits.startsWith('0') ? `62${digits.slice(1)}` : digits;
    return `${prefix}${normalized}`;
  }
  return `${prefix}${v}`;
}

const LINK_FIELDS = Object.keys(PREFIX);

function applyLinks(input: UpsertUmkmInput): UpsertUmkmInput {
  const out = { ...input };
  for (const f of LINK_FIELDS) {
    if (f in out) out[f] = buildLink(f, out[f]);
  }
  return out;
}

export async function createUmkm(input: UpsertUmkmInput, actor?: Actor) {
  const isOwner = actor?.usertype === 'Owner';
  // Owner selalu membuat atas nama dirinya (parity Umkm::store1:
  // username dari session, bukan dari input form yang bisa diubah).
  const username = isOwner ? actor!.username : String(input.username ?? '');
  if (!username) throw Object.assign(new Error('Username wajib diisi'), { status: 400 });
  if (await hasActiveUmkm(username)) {
    throw Object.assign(new Error('Username sudah terdaftar (status menunggu/disetujui)'), { status: 409 });
  }
  const data = applyLinks({
    ...input,
    username,
    photo: input.photo ?? 'default.png',
    // Owner tidak menentukan status/catatan (parity: form owner tanpa field status).
    status: isOwner ? 'menunggu' : (input.status ?? 'menunggu'),
    catatan: isOwner ? '-' : (input.catatan ?? '-'),
    // deskripsi_produk NOT NULL tanpa default di DB — koersi null/absen ke ''.
    deskripsi_produk: input.deskripsi_produk ?? '',
  });
  return insertUmkm(data);
}

export async function updateUmkmById(id: number, input: UpsertUmkmInput, actor?: Actor) {
  const existing = await findUmkmById(id);
  if (!existing) throw Object.assign(new Error('UMKM tidak ditemukan'), { status: 404 });
  if (actor?.usertype === 'Owner' && existing.username !== actor.username) denyOwnership();
  const data = applyLinks(input);
  delete data.username; // username tidak boleh pindah tangan via update
  if (actor?.usertype === 'Owner') {
    // Parity edit_umkm1: status hidden (nilai lama), catatan readonly.
    delete data.status;
    delete data.catatan;
  }
  await updateUmkm(id, data);
  return findUmkmById(id);
}

export async function deleteUmkmById(id: number, actor?: Actor): Promise<void> {
  const existing = await findUmkmById(id);
  if (!existing) throw Object.assign(new Error('UMKM tidak ditemukan'), { status: 404 });
  if (actor?.usertype === 'Owner' && existing.username !== actor.username) denyOwnership();
  await deleteUmkm(id);
}

/** Agregasi dashboard — port 10 endpoint count/* legacy. */
export async function getStats() {
  const [users, owners, admins, umkm, disetujui, perKategori, perKecamatan, jenisUsaha, desaPerKategori, desaPerKecamatan] =
    await Promise.all([
      countUsers(),
      countUsersByType('Owner'),
      countUsersByType('Admin'),
      countUmkm(),
      countUmkmByStatus('disetujui'),
      countDisetujuiPerKategori(),
      countDisetujuiPerKecamatan(),
      countJenisUsaha(),
      countDesaPerKategori(),
      countDesaPerKecamatan(),
    ]);
  return { users, owners, admins, umkm, disetujui, perKategori, perKecamatan, jenisUsaha, desaPerKategori, desaPerKecamatan };
}
