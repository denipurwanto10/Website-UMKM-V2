import bcrypt from 'bcryptjs';
import type { Usertype } from '../models/types';
import {
  deleteUser as repoDelete,
  findAllUsers,
  findPublicUser,
  findUserByUsername,
  insertUser,
  updateUser as repoUpdate,
} from '../repositories/user.repository';

export { findAllUsers, findPublicUser };

export async function createUser(input: {
  username: string; fullname: string; usertype: Usertype;
  nomor_hp: string; email: string; password: string; photo?: string;
}) {
  const existing = await findUserByUsername(input.username);
  if (existing) throw Object.assign(new Error('Username sudah digunakan'), { status: 409 });
  const passwordHash = await bcrypt.hash(input.password, 10);
  await insertUser({
    username: input.username,
    fullname: input.fullname,
    usertype: input.usertype,
    nomor_hp: input.nomor_hp,
    email: input.email,
    passwordHash,
    photo: input.photo ?? 'default.png',
  });
  const created = await findPublicUser(input.username);
  if (!created) throw Object.assign(new Error('Gagal membuat user'), { status: 500 });
  return created;
}

export async function updateUser(username: string, input: {
  fullname?: string; usertype?: Usertype; nomor_hp?: string;
  email?: string; password?: string; photo?: string;
}, actor?: { username: string; usertype: Usertype }) {
  const existing = await findUserByUsername(username);
  if (!existing) throw Object.assign(new Error('User tidak ditemukan'), { status: 404 });
  // Owner tidak boleh mengubah usertype (miliknya maupun orang lain) —
  // parity CI3: form owner tanpa wewenang role; cegah eskalasi Owner→Admin.
  const safeUsertype = actor?.usertype === 'Owner' ? undefined : input.usertype;
  const passwordHash = input.password ? await bcrypt.hash(input.password, 10) : undefined;
  await repoUpdate(username, {
    fullname: input.fullname,
    usertype: safeUsertype,
    nomor_hp: input.nomor_hp,
    email: input.email,
    passwordHash,
    photo: input.photo,
  });
  return findPublicUser(username);
}

export async function deleteUser(username: string): Promise<void> {
  const existing = await findUserByUsername(username);
  if (!existing) throw Object.assign(new Error('User tidak ditemukan'), { status: 404 });
  try {
    await repoDelete(username);
  } catch (err) {
    // FK users→umkm/promosi: tolak dengan pesan jelas, bukan 500 misterius
    const code = (err as { code?: string }).code;
    if (code === 'ER_ROW_IS_REFERENCED_2' || code === 'ER_ROW_IS_REFERENCED') {
      throw Object.assign(new Error('User tidak dapat dihapus karena masih memiliki data UMKM/promosi'), { status: 409 });
    }
    throw err;
  }
}
