import { useMemo, useState } from 'react';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { toast } from 'sonner';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import { Button } from '../components/ui/button';
import { TableEmpty } from '../components/TableEmpty';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '../components/ui/dialog';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../components/ui/table';
import { Textarea } from '../components/ui/textarea';
import { useAuth } from '../hooks/useAuth';
import { apiError } from '../services/api';
import { createPromosi, deletePromosi, listPromosi, promosiByUsername, updatePromosi } from '../services/promosi.service';

// Port createPromosiSchema backend: 6 field wajib, 2 enum Ya/Tidak.
const schema = z.object({
  username: z.string().optional(),
  fasilitasi_promosi: z.string().min(1, 'Fasilitasi promosi wajib diisi'),
  hambatan_memasarkan_produk: z.string().min(1, 'Wajib diisi'),
  bantuan_dibutuhkan: z.string().min(1, 'Wajib diisi'),
  berminat_bazar_ramadhan: z.enum(['Ya', 'Tidak']),
  berminat_pelatihan_online: z.enum(['Ya', 'Tidak']),
});

type Form = z.infer<typeof schema>;

export function PromosiPage() {
  const { user } = useAuth();
  const isAdmin = user?.usertype === 'Admin';
  const qc = useQueryClient();
  const [q, setQ] = useState('');
  const [dialog, setDialog] = useState<null | { mode: 'create' } | { mode: 'edit'; id: number; row: Record<string, unknown> }>(null);
  const [del, setDel] = useState<{ id: number } | null>(null);

  const query = useQuery({
    queryKey: isAdmin ? ['promosi'] : ['promosi-mine', user?.username],
    queryFn: () => (isAdmin ? listPromosi() : promosiByUsername(user!.username).catch(() => [])),
  });

  const items = useMemo(() => {
    const kw = q.trim().toLowerCase();
    const all = query.data ?? [];
    if (!kw) return all;
    return all.filter((p) => [p.username, p.fullname, p.fasilitasi_promosi].join(' ').toLowerCase().includes(kw));
  }, [query.data, q]);

  const form = useForm<Form>({
    resolver: zodResolver(schema),
    defaultValues: { berminat_bazar_ramadhan: 'Tidak', berminat_pelatihan_online: 'Tidak' },
  });

  const save = useMutation({
    mutationFn: async (v: Form) => {
      const payload: Record<string, unknown> = { ...v };
      if (!isAdmin) payload.username = user!.username;
      if (dialog?.mode === 'create') {
        if (isAdmin && !payload.username) payload.username = user!.username;
        return createPromosi(payload);
      }
      return updatePromosi((dialog as { id: number }).id, payload);
    },
    onSuccess: () => {
      toast.success(dialog?.mode === 'create' ? 'Data promosi disimpan' : 'Data promosi diperbarui');
      setDialog(null);
      qc.invalidateQueries({ queryKey: ['promosi'] });
      qc.invalidateQueries({ queryKey: ['promosi-mine'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  const remove = useMutation({
    mutationFn: (id: number) => deletePromosi(id),
    onSuccess: () => {
      toast.success('Data promosi dihapus');
      setDel(null);
      qc.invalidateQueries({ queryKey: ['promosi'] });
      qc.invalidateQueries({ queryKey: ['promosi-mine'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  return (
    <div className="flex flex-col gap-4">
      <div className="flex flex-wrap items-end justify-between gap-2">
        <div>
          <h1 className="text-2xl font-bold">Promosi</h1>
          <p className="text-sm text-muted-foreground">Data minat promosi & bantuan yang dibutuhkan UMKM</p>
        </div>
        <Button size="sm" onClick={() => { form.reset({ berminat_bazar_ramadhan: 'Tidak', berminat_pelatihan_online: 'Tidak' }); setDialog({ mode: 'create' }); }}>
          <Plus className="h-4 w-4" /> Tambah
        </Button>
      </div>

      <Input className="w-full sm:max-w-xs" placeholder="Cari username / fasilitasi…" value={q} onChange={(e) => setQ(e.target.value)} />

      <Card>
        <CardHeader><CardTitle className="text-base">Daftar Promosi ({items.length})</CardTitle></CardHeader>
        <CardContent className="p-0 sm:p-6 sm:pt-0">
                  <Table className="min-w-[520px]">
                    <TableHeader>
                      <TableRow>
                        <TableHead>Pemilik</TableHead>
                        <TableHead className="hidden md:table-cell">Fasilitasi</TableHead>
                        <TableHead className="hidden lg:table-cell">Bantuan</TableHead>
                        <TableHead className="text-right">Aksi</TableHead>
                      </TableRow>
                    </TableHeader>
                    <TableBody>
                      {query.isLoading && <TableEmpty colSpan={4} state="loading" />}
                      {query.isError && (
                        <TableEmpty
                          colSpan={4}
                          state="error"
                          message={apiError(query.error)}
                          action={
                            <Button size="sm" variant="outline" onClick={() => query.refetch()}>
                              Coba lagi
                            </Button>
                          }
                        />
                      )}
                      {query.data && items.length === 0 && (
                        <TableEmpty
                          colSpan={4}
                          state="empty"
                          message={q ? 'Tidak ada hasil untuk pencarian tersebut.' : 'Belum ada data promosi.'}
                        />
                      )}
                      {items.map((p) => (
                  <TableRow key={p.id}>
                    <TableCell>
                      <p className="font-medium">{p.fullname ?? p.username}</p>
                      <p className="text-xs text-muted-foreground">{p.username}</p>
                    </TableCell>
                    <TableCell className="hidden max-w-xs truncate md:table-cell text-xs">{p.fasilitasi_promosi}</TableCell>
                    <TableCell className="hidden max-w-xs truncate lg:table-cell text-xs">{p.bantuan_dibutuhkan}</TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-1">
                        <Button variant="ghost" size="icon" aria-label="Ubah" onClick={() => {
                          form.reset({
                            fasilitasi_promosi: p.fasilitasi_promosi,
                            hambatan_memasarkan_produk: p.hambatan_memasarkan_produk,
                            bantuan_dibutuhkan: p.bantuan_dibutuhkan,
                            berminat_bazar_ramadhan: p.berminat_bazar_ramadhan,
                            berminat_pelatihan_online: p.berminat_pelatihan_online,
                          });
                          setDialog({ mode: 'edit', id: p.id, row: p as unknown as Record<string, unknown> });
                        }}>
                          <Pencil className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="icon" aria-label="Hapus" onClick={() => setDel({ id: p.id })}>
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

      <Dialog open={dialog !== null} onOpenChange={(o) => !o && setDialog(null)}>
        <DialogContent>
          <DialogHeader className="pb-1">
            <DialogTitle className="text-lg sm:text-xl">{dialog?.mode === 'create' ? 'Tambah Data Promosi' : 'Ubah Data Promosi'}</DialogTitle>
            <DialogDescription>Isi kebutuhan promosi & bantuan — satu data per pemilik usaha.</DialogDescription>
          </DialogHeader>
          <form onSubmit={form.handleSubmit((v) => save.mutate(v))} className="flex flex-col gap-3">
            {isAdmin && dialog?.mode === 'create' && (
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="p-username">Username</Label>
                <Input id="p-username" placeholder="Default: akun sendiri" {...form.register('username')} />
              </div>
            )}
            <div className="flex flex-col gap-1.5">
              <Label htmlFor="p-fas">Fasilitasi promosi *</Label>
              <Textarea id="p-fas" {...form.register('fasilitasi_promosi')} />
              {form.formState.errors.fasilitasi_promosi && <p className="text-xs text-destructive">{form.formState.errors.fasilitasi_promosi.message}</p>}
            </div>
            <div className="flex flex-col gap-1.5">
              <Label htmlFor="p-ham">Hambatan memasarkan produk *</Label>
              <Textarea id="p-ham" {...form.register('hambatan_memasarkan_produk')} />
              {form.formState.errors.hambatan_memasarkan_produk && <p className="text-xs text-destructive">{form.formState.errors.hambatan_memasarkan_produk.message}</p>}
            </div>
            <div className="flex flex-col gap-1.5">
              <Label htmlFor="p-ban">Bantuan dibutuhkan *</Label>
              <Textarea id="p-ban" {...form.register('bantuan_dibutuhkan')} />
              {form.formState.errors.bantuan_dibutuhkan && <p className="text-xs text-destructive">{form.formState.errors.bantuan_dibutuhkan.message}</p>}
            </div>
            <div className="grid gap-3 sm:grid-cols-2">
              <div className="flex flex-col gap-1.5">
                <Label>Berminat bazar Ramadhan</Label>
                <Select value={form.watch('berminat_bazar_ramadhan')} onValueChange={(v) => form.setValue('berminat_bazar_ramadhan', v as 'Ya' | 'Tidak')}>
                  <SelectTrigger><SelectValue /></SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Ya">Ya</SelectItem>
                    <SelectItem value="Tidak">Tidak</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div className="flex flex-col gap-1.5">
                <Label>Berminat pelatihan online</Label>
                <Select value={form.watch('berminat_pelatihan_online')} onValueChange={(v) => form.setValue('berminat_pelatihan_online', v as 'Ya' | 'Tidak')}>
                  <SelectTrigger><SelectValue /></SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Ya">Ya</SelectItem>
                    <SelectItem value="Tidak">Tidak</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>
            <DialogFooter>
              <Button type="button" variant="outline" onClick={() => setDialog(null)}>Batal</Button>
              <Button type="submit" disabled={save.isPending}>{save.isPending ? 'Menyimpan…' : 'Simpan'}</Button>
            </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>

      <Dialog open={del !== null} onOpenChange={(o) => !o && setDel(null)}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Hapus data promosi?</DialogTitle>
            <DialogDescription>Tindakan ini tidak bisa dibatalkan.</DialogDescription>
          </DialogHeader>
          <DialogFooter>
            <Button variant="outline" onClick={() => setDel(null)}>Batal</Button>
            <Button variant="destructive" disabled={remove.isPending} onClick={() => del && remove.mutate(del.id)}>
              {remove.isPending ? 'Menghapus…' : 'Hapus'}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </div>
  );
}
