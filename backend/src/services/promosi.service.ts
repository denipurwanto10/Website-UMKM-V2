import {
  deletePromosi,
  findAllPromosi,
  findPromosiById,
  findPromosiByUsername,
  insertPromosi,
  updatePromosi,
} from '../repositories/promosi.repository';
import { findUserByUsername } from '../repositories/user.repository';
import { findUmkmByUsername } from '../repositories/umkm.repository';

import type { Usertype } from '../models/types';

export interface Actor {
  username: string;
  usertype: Usertype;
}

function denyOwnership(): never {
  throw Object.assign(new Error('Akses ditolak: bukan data milik Anda'), { status: 403 });
}

export { findAllPromosi, findPromosiById, findPromosiByUsername };

export async function createPromosi(input: {
  username: string; fasilitasi_promosi: string; hambatan_memasarkan_produk: string;
  bantuan_dibutuhkan: string; berminat_bazar_ramadhan: string; berminat_pelatihan_online: string;
}, actor?: Actor) {
  // Owner selalu membuat atas nama dirinya (parity Promosi::store1).
  const username = actor?.usertype === 'Owner' ? actor.username : input.username;
  // Guard bisnis — port POST /api/promosi legacy (pesan disamakan agar CI3 flash tetap cocok)
  const user = await findUserByUsername(username);
  if (!user) throw Object.assign(new Error('Username tidak terdaftar di sistem'), { status: 404 });
  const owned = await findUmkmByUsername(username);
  if (!owned.some((u) => u.status === 'disetujui')) {
    throw Object.assign(new Error('Status UMKM tidak disetujui'), { status: 400 });
  }
  const existing = await findPromosiByUsername(username);
  if (existing.length > 0) {
    throw Object.assign(new Error('Promosi untuk username ini sudah ada'), { status: 409 });
  }
  return insertPromosi({ ...input, username });
}

export async function updatePromosiById(id: number, input: {
  fasilitasi_promosi?: string; hambatan_memasarkan_produk?: string;
  bantuan_dibutuhkan?: string; berminat_bazar_ramadhan?: string; berminat_pelatihan_online?: string;
}, actor?: Actor) {
  const existing = await findPromosiById(id);
  if (!existing) throw Object.assign(new Error('Data promosi tidak ditemukan'), { status: 404 });
  if (actor?.usertype === 'Owner' && existing.username !== actor.username) denyOwnership();
  await updatePromosi(id, input);
  return findPromosiById(id);
}

export async function deletePromosiById(id: number, actor?: Actor): Promise<void> {
  const existing = await findPromosiById(id);
  if (!existing) throw Object.assign(new Error('Data promosi tidak ditemukan'), { status: 404 });
  if (actor?.usertype === 'Owner' && existing.username !== actor.username) denyOwnership();
  await deletePromosi(id);
}
