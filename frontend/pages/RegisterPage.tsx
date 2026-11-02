import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'sonner';
import { Loader2 } from 'lucide-react';
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import { Field } from '../components/Field';
import { PasswordInput } from '../components/PasswordInput';
import { AuthShell } from '../components/AuthShell';
import { apiError } from '../services/api';
import { register } from '../services/auth.service';

// Port form_validation Auth::register CI3: username alpha_numeric, nomor_hp numeric,
// email valid, password min 8 + confpassword cocok.
const schema = z
  .object({
    username: z.string().min(1, 'Username wajib diisi').regex(/^[a-zA-Z0-9]+$/, 'Hanya huruf dan angka'),
    fullname: z.string().min(1, 'Nama lengkap wajib diisi'),
    nomor_hp: z.string().min(1, 'Nomor HP wajib diisi').regex(/^[0-9+]+$/, 'Hanya angka'),
    email: z.string().min(1, 'Email wajib diisi').email('Format email tidak valid'),
    password: z.string().min(8, 'Password minimal 8 karakter'),
    confpassword: z.string().min(1, 'Konfirmasi password wajib diisi'),
  })
  .refine((v) => v.password === v.confpassword, {
    message: 'Password dan konfirmasi tidak cocok',
    path: ['confpassword'],
  });

type Form = z.infer<typeof schema>;

export function RegisterPage() {
  const nav = useNavigate();
  const [busy, setBusy] = useState(false);
  const form = useForm<Form>({ resolver: zodResolver(schema) });
  const err = (n: keyof Form) => form.formState.errors[n]?.message as string | undefined;

  async function onSubmit(v: Form) {
    setBusy(true);
    try {
      await register(v);
      toast.success('Akun dibuat. Silakan masuk.');
      nav('/login');
    } catch (e) {
      toast.error(apiError(e));
    } finally {
      setBusy(false);
    }
  }

  return (
    <AuthShell
      title="Buat akun"
      description="Akun baru otomatis menjadi pemilik usaha."
      footer={
        <>
          Sudah punya akun?{' '}
          <Link to="/login" className="font-medium text-foreground underline-offset-4 hover:underline">
            Masuk
          </Link>
        </>
      }
    >
      <form onSubmit={form.handleSubmit(onSubmit)} className="grid gap-5 sm:grid-cols-2">
        <Field label="Username" htmlFor="username" error={err('username')}>
          <Input id="username" autoComplete="username" {...form.register('username')} />
        </Field>
        <Field label="Nama lengkap" htmlFor="fullname" error={err('fullname')}>
          <Input id="fullname" autoComplete="name" {...form.register('fullname')} />
        </Field>
        <Field label="Nomor HP" htmlFor="nomor_hp" error={err('nomor_hp')}>
          <Input id="nomor_hp" inputMode="tel" autoComplete="tel" {...form.register('nomor_hp')} />
        </Field>
        <Field label="Email" htmlFor="email" error={err('email')}>
          <Input id="email" type="email" autoComplete="email" {...form.register('email')} />
        </Field>
        <Field label="Password" htmlFor="password" error={err('password')}>
          <PasswordInput id="password" autoComplete="new-password" {...form.register('password')} />
        </Field>
        <Field label="Konfirmasi password" htmlFor="confpassword" error={err('confpassword')}>
          <PasswordInput id="confpassword" autoComplete="new-password" {...form.register('confpassword')} />
        </Field>
        <Button type="submit" size="lg" disabled={busy} className="mt-1 sm:col-span-2">
          {busy ? (
            <>
              <Loader2 className="animate-spin" /> Membuat akun…
            </>
          ) : (
            'Buat akun'
          )}
        </Button>
      </form>
    </AuthShell>
  );
}
