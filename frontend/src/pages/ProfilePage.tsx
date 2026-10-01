import { useRef } from 'react';
import { useMutation, useQueryClient } from '@tanstack/react-query';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { toast } from 'sonner';
import { Save } from 'lucide-react';
import { Button } from '../components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
import { uploadUrl } from '../lib/uploads';
import { useAuth } from '../hooks/useAuth';
import { apiError } from '../services/api';
import { updateUser } from '../services/user.service';

// Profil = subset Users::edit untuk akun sendiri (route /users/:username via requireSelfOrAdmin).
const schema = z.object({
  fullname: z.string().min(1, 'Nama lengkap wajib diisi'),
  nomor_hp: z.string().min(1, 'Nomor HP wajib diisi').regex(/^[0-9+]+$/, 'Hanya angka'),
  email: z.string().min(1, 'Email wajib diisi').email('Format email tidak valid'),
  password: z.string().optional(),
  confpassword: z.string().optional(),
}).refine((v) => !v.password || v.password.length >= 8, { message: 'Password minimal 8 karakter', path: ['password'] })
 .refine((v) => !v.password || v.password === v.confpassword, { message: 'Password dan konfirmasi tidak cocok', path: ['confpassword'] });

type Form = z.infer<typeof schema>;

export function ProfilePage() {
  const { user, logout } = useAuth();
  const qc = useQueryClient();
  const fileRef = useRef<HTMLInputElement>(null);
  const form = useForm<Form>({
    resolver: zodResolver(schema),
    values: user
      ? { fullname: user.fullname, nomor_hp: user.nomor_hp, email: user.email, password: '', confpassword: '' }
      : undefined,
  });

  const save = useMutation({
    mutationFn: (v: Form) => {
      const payload: Record<string, unknown> = { fullname: v.fullname, nomor_hp: v.nomor_hp, email: v.email };
      if (v.password) {
        payload.password = v.password;
        payload.confpassword = v.confpassword;
      }
      return updateUser(user!.username, payload, fileRef.current?.files?.[0]);
    },
    onSuccess: () => {
      toast.success('Profil berhasil diperbarui');
      qc.invalidateQueries({ queryKey: ['stats'] });
      // Paksa refresh user di context agar header ikut berubah
      localStorage.removeItem('user');
      window.location.reload();
    },
    onError: (e) => toast.error(apiError(e)),
  });

  if (!user) return null;

  return (
    <div className="mx-auto flex max-w-2xl flex-col gap-4">
      <div>
        <h1 className="text-2xl font-bold">Profil Saya</h1>
        <p className="text-sm text-muted-foreground">Role: {user.usertype} — username tidak bisa diubah</p>
      </div>
      <Card>
        <CardHeader>
          <CardTitle className="text-base">Data akun</CardTitle>
        </CardHeader>
        <CardContent>
          <form onSubmit={form.handleSubmit((v) => save.mutate(v))} className="flex flex-col gap-4">
            <div className="flex items-center gap-4">
              <img src={uploadUrl('users', user.photo)} alt={user.username} className="h-16 w-16 rounded-full object-cover" />
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-photo">Ganti foto</Label>
                <Input id="p-photo" ref={fileRef} type="file" accept="image/jpeg,image/png,image/gif" />
              </div>
            </div>
            <div className="grid gap-3 sm:grid-cols-2">
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-username">Username</Label>
                <Input id="p-username" value={user.username} disabled />
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-fullname">Nama lengkap</Label>
                <Input id="p-fullname" {...form.register('fullname')} />
                {form.formState.errors.fullname && <p className="text-xs text-destructive">{form.formState.errors.fullname.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-hp">Nomor HP</Label>
                <Input id="p-hp" {...form.register('nomor_hp')} />
                {form.formState.errors.nomor_hp && <p className="text-xs text-destructive">{form.formState.errors.nomor_hp.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-email">Email</Label>
                <Input id="p-email" type="email" {...form.register('email')} />
                {form.formState.errors.email && <p className="text-xs text-destructive">{form.formState.errors.email.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-pass">Password baru (opsional)</Label>
                <Input id="p-pass" type="password" {...form.register('password')} />
                {form.formState.errors.password && <p className="text-xs text-destructive">{form.formState.errors.password.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-conf">Konfirmasi password</Label>
                <Input id="p-conf" type="password" {...form.register('confpassword')} />
                {form.formState.errors.confpassword && <p className="text-xs text-destructive">{form.formState.errors.confpassword.message}</p>}
              </div>
            </div>
            <div className="flex flex-wrap gap-2">
              <Button type="submit" disabled={save.isPending}><Save className="h-4 w-4" /> {save.isPending ? 'Menyimpan…' : 'Simpan'}</Button>
              <Button type="button" variant="outline" onClick={logout}>Keluar</Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  );
}
