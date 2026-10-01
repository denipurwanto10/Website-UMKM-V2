import { z } from 'zod';

// Aturan port dari form_validation CI3 (Users::store/update):
// username required|alpha_numeric, fullname required, usertype required,
// nomor_hp required|numeric, email required|valid_email,
// password required|min_length[8], confpassword matches[password]
const baseUserSchema = z.object({
  username: z.string().min(1, 'Username wajib diisi').regex(/^[a-zA-Z0-9]+$/, 'Username hanya huruf dan angka'),
  fullname: z.string().min(1, 'Nama lengkap wajib diisi'),
  usertype: z.enum(['Admin', 'Owner']),
  nomor_hp: z.string().min(1, 'Nomor HP wajib diisi').regex(/^[0-9+]+$/, 'Nomor HP hanya angka'),
  email: z.string().min(1, 'Email wajib diisi').email('Format email tidak valid'),
  password: z.string().min(8, 'Password minimal 8 karakter'),
  confpassword: z.string().min(1, 'Konfirmasi password wajib diisi'),
});

function withPasswordMatch<T extends z.ZodRawShape>(schema: z.ZodObject<T>) {
  return schema.refine(
    (v) => (v as { password: string; confpassword: string }).password === (v as { password: string; confpassword: string }).confpassword,
    { message: 'Password dan konfirmasi password tidak cocok', path: ['confpassword'] },
  );
}

export const createUserSchema = withPasswordMatch(baseUserSchema);

export const updateUserSchema = z.object({
  fullname: z.string().min(1).optional(),
  usertype: z.enum(['Admin', 'Owner']).optional(),
  nomor_hp: z.string().regex(/^[0-9+]+$/, 'Nomor HP hanya angka').optional(),
  email: z.string().email('Format email tidak valid').optional(),
  password: z.string().min(8, 'Password minimal 8 karakter').optional(),
  confpassword: z.string().optional(),
}).refine((v) => v.password === undefined || v.password === v.confpassword, {
  message: 'Password dan konfirmasi password tidak cocok',
  path: ['confpassword'],
});

// Register publik: sama seperti create, tapi usertype dikunci Owner di service
export const registerSchema = withPasswordMatch(baseUserSchema.omit({ usertype: true }));

export const loginSchema = z.object({
  username: z.string().min(1, 'Username wajib diisi'),
  password: z.string().min(1, 'Password wajib diisi'),
});
