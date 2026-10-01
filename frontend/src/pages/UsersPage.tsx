import { useState } from 'react';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { toast } from 'sonner';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import { Badge } from '../components/ui/badge';
import { Button } from '../components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '../components/ui/dialog';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../components/ui/table';
import { TableEmpty } from '../components/TableEmpty';
import { apiError } from '../services/api';
import { createUser, deleteUser, listUsers, updateUser } from '../services/user.service';
import type { User } from '../types';
import { uploadUrl } from '../lib/uploads';

const schema = z
  .object({
    username: z.string().min(1, 'Username wajib diisi').regex(/^[a-zA-Z0-9]+$/, 'Hanya huruf dan angka'),
    fullname: z.string().min(1, 'Nama lengkap wajib diisi'),
    usertype: z.enum(['Admin', 'Owner']),
    nomor_hp: z.string().min(1, 'Nomor HP wajib diisi').regex(/^[0-9+]+$/, 'Hanya angka'),
    email: z.string().min(1, 'Email wajib diisi').email('Format email tidak valid'),
    password: z.string().optional(),
    confpassword: z.string().optional(),
  })
  .refine((v) => !v.password || v.password.length >= 8, {
    message: 'Password minimal 8 karakter',
    path: ['password'],
  })
  .refine((v) => !v.password || v.password === v.confpassword, {
    message: 'Password dan konfirmasi tidak cocok',
    path: ['confpassword'],
  });

type Form = z.infer<typeof schema>;

export function UsersPage() {
  const qc = useQueryClient();
  const users = useQuery({ queryKey: ['users'], queryFn: listUsers });
  const [dialog, setDialog] = useState<null | { mode: 'create' } | { mode: 'edit'; user: User }>(null);
  const [del, setDel] = useState<User | null>(null);
  const [photo, setPhoto] = useState<File | null>(null);

  const form = useForm<Form>({
    resolver: zodResolver(schema),
    defaultValues: { username: '', fullname: '', usertype: 'Owner', nomor_hp: '', email: '', password: '', confpassword: '' },
  });

  function openCreate() {
    form.reset({ username: '', fullname: '', usertype: 'Owner', nomor_hp: '', email: '', password: '', confpassword: '' });
    setPhoto(null);
    setDialog({ mode: 'create' });
  }

  function openEdit(u: User) {
    form.reset({ username: u.username, fullname: u.fullname, usertype: u.usertype, nomor_hp: u.nomor_hp, email: u.email, password: '', confpassword: '' });
    setPhoto(null);
    setDialog({ mode: 'edit', user: u });
  }

  const save = useMutation({
    mutationFn: async (v: Form) => {
      const payload: Record<string, unknown> = {
        fullname: v.fullname,
        usertype: v.usertype,
        nomor_hp: v.nomor_hp,
        email: v.email,
      };
      if (dialog?.mode === 'create') {
        payload.username = v.username;
        payload.password = v.password;
        payload.confpassword = v.confpassword;
        return createUser(payload, photo ?? undefined);
      }
      if (v.password) {
        payload.password = v.password;
        payload.confpassword = v.confpassword;
      }
      return updateUser((dialog as { user: User }).user.username, payload, photo ?? undefined);
    },
    onSuccess: () => {
      toast.success(dialog?.mode === 'create' ? 'User berhasil ditambahkan' : 'User berhasil diperbarui');
      setDialog(null);
      qc.invalidateQueries({ queryKey: ['users'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  const remove = useMutation({
    mutationFn: (u: User) => deleteUser(u.username),
    onSuccess: () => {
      toast.success('User berhasil dihapus');
      setDel(null);
      qc.invalidateQueries({ queryKey: ['users'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  return (
    <div className="flex flex-col gap-4">
      <div className="flex flex-wrap items-end justify-between gap-2">
        <div>
          <h1 className="text-xl font-bold sm:text-2xl">Pengguna</h1>
          <p className="text-sm text-muted-foreground">Kelola akun Admin & Owner</p>
        </div>
        <Button size="sm" onClick={openCreate}>
          <Plus className="h-4 w-4" /> Tambah Pengguna
        </Button>
      </div>

      <Card>
        <CardHeader><CardTitle className="text-base">Daftar Pengguna</CardTitle></CardHeader>
        <CardContent className="p-0 sm:p-6 sm:pt-0">
          <Table className="min-w-[600px]">
              <TableHeader>
                <TableRow>
                  <TableHead>Foto</TableHead>
                  <TableHead>Username</TableHead>
                  <TableHead>Nama</TableHead>
                  <TableHead className="hidden md:table-cell">Kontak</TableHead>
                  <TableHead>Role</TableHead>
                  <TableHead className="text-right">Aksi</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {users.isLoading && <TableEmpty colSpan={6} state="loading" />}
                {users.isError && (
                  <TableEmpty
                    colSpan={6}
                    state="error"
                    message={apiError(users.error)}
                    action={
                      <Button size="sm" variant="outline" onClick={() => users.refetch()}>
                        Coba lagi
                      </Button>
                    }
                  />
                )}
                {users.data?.length === 0 && <TableEmpty colSpan={6} state="empty" message="Belum ada pengguna terdaftar." />}
                {users.data?.map((u) => (
                  <TableRow key={u.username}>
                    <TableCell>
                      <img src={uploadUrl('users', u.photo)} alt={u.username} className="h-9 w-9 rounded-full object-cover" loading="lazy" />
                    </TableCell>
                    <TableCell className="font-medium">{u.username}</TableCell>
                    <TableCell>{u.fullname}</TableCell>
                    <TableCell className="hidden md:table-cell">
                      <span className="block text-xs">{u.nomor_hp}</span>
                      <span className="block text-xs text-muted-foreground">{u.email}</span>
                    </TableCell>
                    <TableCell>
                      <Badge variant={u.usertype === 'Admin' ? 'default' : 'secondary'}>{u.usertype}</Badge>
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-1">
                        <Button variant="ghost" size="icon" onClick={() => openEdit(u)} aria-label="Ubah">
                          <Pencil className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="icon" onClick={() => setDel(u)} aria-label="Hapus">
                          <Trash2 className="h-4 w-4 text-destructive" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
          </Table>
        </CardContent>
      </Card>

      {/* Dialog tambah/ubah */}
      <Dialog open={dialog !== null} onOpenChange={(o) => !o && setDialog(null)}>
        <DialogContent>
          <DialogHeader className="pb-1">
            <DialogTitle className="text-lg sm:text-xl">{dialog?.mode === 'create' ? 'Tambah Pengguna' : 'Ubah Pengguna'}</DialogTitle>
            <DialogDescription>
              {dialog?.mode === 'create' ? 'Buat akun baru — password minimal 8 karakter.' : 'Kosongkan password bila tidak diubah.'}
            </DialogDescription>
          </DialogHeader>
          <form onSubmit={form.handleSubmit((v) => save.mutate(v))} className="flex flex-col gap-3">
            <div className="grid gap-3 sm:grid-cols-2">
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="u-username">Username</Label>
                <Input id="u-username" disabled={dialog?.mode === 'edit'} {...form.register('username')} />
                {form.formState.errors.username && <p className="text-xs text-destructive">{form.formState.errors.username.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="u-fullname">Nama lengkap</Label>
                <Input id="u-fullname" {...form.register('fullname')} />
                {form.formState.errors.fullname && <p className="text-xs text-destructive">{form.formState.errors.fullname.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label>Role</Label>
                <Select value={form.watch('usertype')} onValueChange={(v) => form.setValue('usertype', v as 'Admin' | 'Owner')}>
                  <SelectTrigger><SelectValue /></SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Admin">Admin</SelectItem>
                    <SelectItem value="Owner">Owner</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="u-hp">Nomor HP</Label>
                <Input id="u-hp" {...form.register('nomor_hp')} />
                {form.formState.errors.nomor_hp && <p className="text-xs text-destructive">{form.formState.errors.nomor_hp.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5 sm:col-span-2">
                <Label htmlFor="u-email">Email</Label>
                <Input id="u-email" type="email" {...form.register('email')} />
                {form.formState.errors.email && <p className="text-xs text-destructive">{form.formState.errors.email.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="u-pass">Password{dialog?.mode === 'edit' && ' (opsional)'}</Label>
                <Input id="u-pass" type="password" {...form.register('password')} />
                {form.formState.errors.password && <p className="text-xs text-destructive">{form.formState.errors.password.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="u-conf">Konfirmasi password</Label>
                <Input id="u-conf" type="password" {...form.register('confpassword')} />
                {form.formState.errors.confpassword && <p className="text-xs text-destructive">{form.formState.errors.confpassword.message}</p>}
              </div>
              <div className="flex flex-col gap-1.5 sm:col-span-2">
                <Label htmlFor="u-photo">Foto (jpg/png/gif, maks 2MB)</Label>
                <Input id="u-photo" type="file" accept="image/jpeg,image/png,image/gif" onChange={(e) => setPhoto(e.target.files?.[0] ?? null)} />
              </div>
            </div>
            <DialogFooter>
              <Button type="button" variant="outline" onClick={() => setDialog(null)}>Batal</Button>
              <Button type="submit" disabled={save.isPending}>{save.isPending ? 'Menyimpan…' : 'Simpan'}</Button>
            </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>

      {/* Konfirmasi hapus */}
      <Dialog open={del !== null} onOpenChange={(o) => !o && setDel(null)}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Hapus user {del?.username}?</DialogTitle>
            <DialogDescription>Data UMKM & promosi miliknya ikut terhapus (CASCADE). Tindakan ini tidak bisa dibatalkan.</DialogDescription>
          </DialogHeader>
          <DialogFooter>
            <Button variant="outline" onClick={() => setDel(null)}>Batal</Button>
            <Button variant="destructive" disabled={remove.isPending} onClick={() => del && remove.mutate(del)}>
              {remove.isPending ? 'Menghapus…' : 'Hapus'}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  );
}
