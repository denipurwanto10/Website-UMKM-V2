import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';
import type { JwtPayload, PublicUser, UserRow } from '../models/types';
import { findUserByUsername, insertUser } from '../repositories/user.repository';

function toPublic(row: UserRow): PublicUser {
  const { password: _pw, ...pub } = row;
  return pub;
}

export async function login(username: string, password: string): Promise<{ token: string; user: PublicUser }> {
  const user = await findUserByUsername(username);
  // Pesan generik — jangan bocorkan apakah username atau password yang salah
  if (!user) throw Object.assign(new Error('Username atau password salah'), { status: 401 });
  const match = await bcrypt.compare(password, user.password);
  if (!match) throw Object.assign(new Error('Username atau password salah'), { status: 401 });

  const payload: JwtPayload = { username: user.username, usertype: user.usertype };
  const token = jwt.sign(payload, env.authSecret, { expiresIn: env.authExpiresSeconds });
  return { token, user: toPublic(user) };
}

export async function register(input: {
  username: string; fullname: string; nomor_hp: string; email: string; password: string; photo?: string;
}): Promise<PublicUser> {
  const existing = await findUserByUsername(input.username);
  if (existing) throw Object.assign(new Error('Username sudah digunakan'), { status: 409 });

  const passwordHash = await bcrypt.hash(input.password, 10);
  await insertUser({
    username: input.username,
    fullname: input.fullname,
    usertype: 'Owner', // Register publik selalu Owner — port POST /api/register legacy
    nomor_hp: input.nomor_hp,
    email: input.email,
    passwordHash,
    photo: input.photo ?? 'default.png',
  });
  const created = await findUserByUsername(input.username);
  if (!created) throw Object.assign(new Error('Registrasi gagal'), { status: 500 });
  return toPublic(created);
}
