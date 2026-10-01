import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { Link, useNavigate } from 'react-router-dom';
import { toast } from 'sonner';
import { Button } from '../components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../components/ui/card';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
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
      toast.success('Registrasi berhasil, silakan login');
      nav('/login');
    } catch (e) {
      toast.error(apiError(e));
    } finally {
      setBusy(false);
    }
  }

  const fields: { name: keyof Form; label: string; type?: string }[] = [
    { name: 'username', label: 'Username' },
    { name: 'fullname', label: 'Nama lengkap' },
    { name: 'nomor_hp', label: 'Nomor HP' },
    { name: 'email', label: 'Email', type: 'email' },
    { name: 'password', label: 'Password', type: 'password' },
    { name: 'confpassword', label: 'Konfirmasi password', type: 'password' },
  ];

  return (
    <div className="mx-auto max-w-md">
      <Card>
        <CardHeader>
          <CardTitle>Daftar Akun Owner</CardTitle>
          <CardDescription>Akun baru otomatis bertipe Owner</CardDescription>
        </CardHeader>
        <CardContent>
          <form onSubmit={form.handleSubmit(onSubmit)} className="flex flex-col gap-4">
            {fields.map((f) => (
              <div key={f.name} className="flex flex-col gap-1.5">
                <Label htmlFor={f.name}>{f.label}</Label>
                <Input id={f.name} type={f.type ?? 'text'} {...form.register(f.name)} />
                {err(f.name) && <p className="text-xs text-destructive">{err(f.name)}</p>}
              </div>
            ))}
            <Button type="submit" disabled={busy}>
              {busy ? 'Memproses…' : 'Daftar'}
            </Button>
            <p className="text-center text-sm text-muted-foreground">
              Sudah punya akun?{' '}
              <Link to="/login" className="text-primary underline-offset-4 hover:underline">
                Masuk
              </Link>
            </p>
          </form>
        </CardContent>
      </Card>
    </div>
  );
}
