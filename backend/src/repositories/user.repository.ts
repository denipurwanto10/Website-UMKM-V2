import { pool } from '../config/db';
import type { PublicUser, UserRow, Usertype } from '../models/types';

const PUBLIC_COLS = 'username, fullname, usertype, nomor_hp, email, photo';

function toPublic(row: UserRow): PublicUser {
  const { password: _password, ...pub } = row;
  return pub;
}

export async function findAllUsers(): Promise<PublicUser[]> {
  const [rows] = await pool.query(`SELECT ${PUBLIC_COLS} FROM users ORDER BY username`);
  return (rows as UserRow[]).map(toPublic);
}

export async function findUserByUsername(username: string): Promise<UserRow | null> {
  const [rows] = await pool.query('SELECT * FROM users WHERE username = ?', [username]);
  const list = rows as UserRow[];
  return list.length > 0 ? list[0] : null;
}

export async function findPublicUser(username: string): Promise<PublicUser | null> {
  const [rows] = await pool.query(`SELECT ${PUBLIC_COLS} FROM users WHERE username = ?`, [username]);
  const list = rows as PublicUser[];
  return list.length > 0 ? list[0] : null;
}

export interface CreateUserInput {
  username: string;
  fullname: string;
  usertype: Usertype;
  nomor_hp: string;
  email: string;
  passwordHash: string;
  photo: string;
}

export async function insertUser(input: CreateUserInput): Promise<void> {
  await pool.query(
    'INSERT INTO users (username, fullname, usertype, nomor_hp, email, password, photo) VALUES (?, ?, ?, ?, ?, ?, ?)',
    [input.username, input.fullname, input.usertype, input.nomor_hp, input.email, input.passwordHash, input.photo],
  );
}

export interface UpdateUserInput {
  fullname?: string;
  usertype?: Usertype;
  nomor_hp?: string;
  email?: string;
  passwordHash?: string;
  photo?: string;
}

export async function updateUser(username: string, input: UpdateUserInput): Promise<boolean> {
  const sets: string[] = [];
  const values: unknown[] = [];
  if (input.fullname !== undefined) { sets.push('fullname = ?'); values.push(input.fullname); }
  if (input.usertype !== undefined) { sets.push('usertype = ?'); values.push(input.usertype); }
  if (input.nomor_hp !== undefined) { sets.push('nomor_hp = ?'); values.push(input.nomor_hp); }
  if (input.email !== undefined) { sets.push('email = ?'); values.push(input.email); }
  if (input.passwordHash !== undefined) { sets.push('password = ?'); values.push(input.passwordHash); }
  if (input.photo !== undefined) { sets.push('photo = ?'); values.push(input.photo); }
  if (sets.length === 0) return true;
  const [result] = await pool.query(`UPDATE users SET ${sets.join(', ')} WHERE username = ?`, [...values, username]);
  return (result as { affectedRows: number }).affectedRows > 0;
}

export async function deleteUser(username: string): Promise<boolean> {
  const [result] = await pool.query('DELETE FROM users WHERE username = ?', [username]);
  return (result as { affectedRows: number }).affectedRows > 0;
}

export async function countUsers(): Promise<number> {
  const [rows] = await pool.query('SELECT COUNT(*) AS count FROM users');
  return (rows as { count: number }[])[0].count;
}

export async function countUsersByType(usertype: Usertype): Promise<number> {
  const [rows] = await pool.query('SELECT COUNT(*) AS count FROM users WHERE usertype = ?', [usertype]);
  return (rows as { count: number }[])[0].count;
}
