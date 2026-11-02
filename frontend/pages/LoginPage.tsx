import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { toast } from 'sonner';
import { Loader2 } from 'lucide-react';
import { Button } from '../components/ui/button';
import { Input } from '../components/ui/input';
import { Field } from '../components/Field';
import { PasswordInput } from '../components/PasswordInput';
import { AuthShell } from '../components/AuthShell';
import { useAuth } from '../hooks/useAuth';
import { apiError } from '../services/api';

const schema = z.object({
  username: z.string().min(1, 'Username wajib diisi'),
  password: z.string().min(1, 'Password wajib diisi'),
});

type Form = z.infer<typeof schema>;

export function LoginPage() {
  const { login } = useAuth();
  const nav = useNavigate();
  const loc = useLocation() as { state?: { from?: string } };
  const [busy, setBusy] = useState(false);
  const form = useForm<Form>({ resolver: zodResolver(schema) });
  const errors = form.formState.errors;

  async function onSubmit(v: Form) {
    setBusy(true);
    try {
      await login(v.username, v.password);
      toast.success('Berhasil masuk');
      nav(loc.state?.from ?? '/dashboard', { replace: true });
    } catch (err) {
      toast.error(apiError(err));
    } finally {
      setBusy(false);
    }
  }

  return (
    <AuthShell
      title="Masuk"
      description="Masuk ke akun UMKM Anda."
      footer={
        <>
          Belum punya akun?{' '}
          <Link to="/register" className="font-medium text-foreground underline-offset-4 hover:underline">
            Daftar
          </Link>
        </>
      }
    >
      <form onSubmit={form.handleSubmit(onSubmit)} className="flex flex-col gap-5">
        <Field label="Username" htmlFor="username" error={errors.username?.message}>
          <Input id="username" autoComplete="username" {...form.register('username')} />
        </Field>
        <Field label="Password" htmlFor="password" error={errors.password?.message}>
          <PasswordInput id="password" autoComplete="current-password" {...form.register('password')} />
        </Field>
        <Button type="submit" size="lg" disabled={busy} className="mt-1">
          {busy ? (
            <>
              <Loader2 className="animate-spin" /> Masuk…
            </>
          ) : (
            'Masuk'
          )}
        </Button>
      </form>
    </AuthShell>
  );
}
