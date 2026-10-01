import { useEffect, useMemo, useState } from 'react';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { useForm } from 'react-hook-form';
import { z } from 'zod';
import { zodResolver } from '@hookform/resolvers/zod';
import { Link, useSearchParams } from 'react-router-dom';
import { toast } from 'sonner';
import { Check, ChevronLeft, ChevronRight, Download, Eye, Pencil, Plus, Trash2, X } from 'lucide-react';
import { Badge } from '../components/ui/badge';
import { Button } from '../components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '../components/ui/dialog';
import { Input } from '../components/ui/input';
import { Label } from '../components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../components/ui/table';
import { Textarea } from '../components/ui/textarea';
import { useAuth } from '../hooks/useAuth';
import { uploadUrl } from '../lib/uploads';
import { csvFileName, downloadCsv } from '../lib/export';
import { apiError } from '../services/api';
import { createUmkm, deleteUmkm, listUmkm, umkmByStatus, umkmByUsername, updateUmkm } from '../services/umkm.service';
import type { Umkm, UmkmStatus } from '../types';

const schema = z.object({
  username: z.string().optional(),
  nama_usaha: z.string().min(1, 'Nama usaha wajib diisi'),
  nama_merek_produk: z.string().min(1, 'Merek produk wajib diisi'),
  kategori_produk: z.string().min(1, 'Kategori wajib diisi'),
  jenis_usaha: z.string().min(1, 'Jenis usaha wajib diisi'),
  pendapatan: z.string().min(1, 'Pendapatan wajib diisi'),
  jalan: z.string().min(1, 'Jalan wajib diisi'),
  desa_kelurahan: z.string().min(1, 'Desa/kelurahan wajib diisi'),
  kecamatan: z.string().min(1, 'Kecamatan wajib diisi'),
  deskripsi_produk: z.string().optional(),
  nib: z.string().optional(),
  pirt: z.string().optional(),
  bpom: z.string().optional(),
  halal: z.string().optional(),
  haki: z.string().optional(),
  lainnya: z.string().optional(),
  online: z.string().optional(),
  offline: z.string().optional(),
  agen_reseller: z.string().optional(),
  whatsapp: z.string().optional(),
  shopee: z.string().optional(),
  tokopedia: z.string().optional(),
  lazada: z.string().optional(),
  blibli: z.string().optional(),
  facebook: z.string().optional(),
  instagram: z.string().optional(),
  tiktok: z.string().optional(),
  twitter: z.string().optional(),
  status: z.enum(['menunggu', 'disetujui', 'ditolak']).optional(),
  catatan: z.string().optional(),
});

type Form = z.infer<typeof schema>;

const STATUS_VARIANT: Record<UmkmStatus, 'warning' | 'success' | 'destructive'> = {
  menunggu: 'warning',
  disetujui: 'success',
  ditolak: 'destructive',
};

export function UmkmPage() {
  const { user } = useAuth();
  const isAdmin = user?.usertype === 'Admin';
  const qc = useQueryClient();
  const [params, setParams] = useSearchParams();
  // Sidebar mengarah ke /umkm?status=menunggu|disetujui|ditolak (parity CI3 admin/dis*). Selaras dengan URL.
  const validStatuses = ['menunggu', 'disetujui', 'ditolak'] as const;
  const fromUrl = params.get('status');
  const [status, setStatus] = useState<'semua' | UmkmStatus>(
    isAdmin && fromUrl && (validStatuses as readonly string[]).includes(fromUrl)
      ? (fromUrl as UmkmStatus)
      : 'semua',
  );
  useEffect(() => {
    if (!isAdmin) return;
    if (fromUrl && (validStatuses as readonly string[]).includes(fromUrl)) {
      setStatus(fromUrl as UmkmStatus);
    } else if (!fromUrl) {
      setStatus('semua');
    }
  }, [fromUrl, isAdmin]);

  function changeStatus(v: 'semua' | UmkmStatus) {
    setStatus(v);
    if (v === 'semua') {
      params.delete('status');
    } else {
      params.set('status', v);
    }
    setParams(params, { replace: true });
  }
  const [q, setQ] = useState('');
  const [page, setPage] = useState(1);
  const [dialog, setDialog] = useState<null | { mode: 'create' } | { mode: 'edit'; umkm: Umkm }>(null);
  const [del, setDel] = useState<Umkm | null>(null);
  const [photo, setPhoto] = useState<File | null>(null);
  const [photoPreview, setPhotoPreview] = useState<string | null>(null);
  const [reject, setReject] = useState<Umkm | null>(null);
  const [rejectNote, setRejectNote] = useState('');

  const query = useQuery({
    queryKey: isAdmin ? ['umkm', status] : ['umkm-mine', user?.username],
    queryFn: () => {
      if (!isAdmin) return umkmByUsername(user!.username);
      if (status === 'semua') return listUmkm();
      return umkmByStatus(status);
    },
  });

  const items = useMemo(() => {
    const kw = q.trim().toLowerCase();
    const all = query.data ?? [];
    if (!kw) return all;
    return all.filter((u) =>
      [u.nama_usaha, u.nama_merek_produk, u.kategori_produk, u.kecamatan, u.username].join(' ').toLowerCase().includes(kw),
    );
  }, [query.data, q]);

  // Paginasi client-side — konsisten dengan filter status dari URL.
  const PAGE_SIZE = 10;
  const pages = Math.max(1, Math.ceil(items.length / PAGE_SIZE));
  const safePage = Math.min(page, pages);
  const paged = items.slice((safePage - 1) * PAGE_SIZE, safePage * PAGE_SIZE);
  useEffect(() => setPage(1), [q, status]);

  function exportCsv() {
    downloadCsv(
      csvFileName(`data_umkm_${status}`),
      ['ID', 'Nama Usaha', 'Merek', 'Kategori', 'Jenis', 'Kecamatan', 'Desa', 'Pemilik', 'Status'],
      items.map((u): (string | number)[] => [
        u.id, u.nama_usaha, u.nama_merek_produk, u.kategori_produk, u.jenis_usaha,
        u.kecamatan, u.desa_kelurahan, u.fullname ?? u.username, u.status,
      ]),
    );
  }

  const form = useForm<Form>({ resolver: zodResolver(schema) });
  const editingUmkm = dialog?.mode === 'edit' ? dialog.umkm : null;

  function openCreate() {
    form.reset({ status: 'menunggu' });
    setPhoto(null);
    setPhotoPreview(null);
    setDialog({ mode: 'create' });
  }

  function openEdit(u: Umkm) {
    form.reset({
      nama_usaha: u.nama_usaha,
      nama_merek_produk: u.nama_merek_produk,
      kategori_produk: u.kategori_produk,
      jenis_usaha: u.jenis_usaha,
      pendapatan: u.pendapatan,
      jalan: u.jalan,
      desa_kelurahan: u.desa_kelurahan,
      kecamatan: u.kecamatan,
      deskripsi_produk: u.deskripsi_produk ?? '',
      nib: u.nib ?? '', pirt: u.pirt ?? '', bpom: u.bpom ?? '', halal: u.halal ?? '', haki: u.haki ?? '',
      lainnya: u.lainnya ?? '', online: u.online ?? '', offline: u.offline ?? '', agen_reseller: u.agen_reseller ?? '',
      whatsapp: u.whatsapp ?? '', shopee: u.shopee ?? '', tokopedia: u.tokopedia ?? '', lazada: u.lazada ?? '',
      blibli: u.blibli ?? '', facebook: u.facebook ?? '', instagram: u.instagram ?? '', tiktok: u.tiktok ?? '',
      twitter: u.twitter ?? '', status: u.status, catatan: u.catatan ?? '',
    });
    setPhoto(null);
    setPhotoPreview(null);
    setDialog({ mode: 'edit', umkm: u });
  }

  const save = useMutation({
    mutationFn: async (v: Form) => {
      const payload: Record<string, unknown> = { ...v };
      // Owner: username dikunci ke dirinya sendiri; Admin boleh isi / biarkan milik record lama
      if (!isAdmin) payload.username = user!.username;
      if (dialog?.mode === 'create') {
        if (isAdmin && !payload.username) payload.username = user!.username;
        if (!isAdmin) payload.status = 'menunggu';
        return createUmkm(payload, photo ?? undefined);
      }
      const id = (dialog as { umkm: Umkm }).umkm.id;
      if (!isAdmin) {
        delete payload.status;
        delete payload.username;
      }
      return updateUmkm(id, payload, photo ?? undefined);
    },
    onSuccess: () => {
      toast.success(dialog?.mode === 'create' ? 'UMKM berhasil ditambahkan' : 'UMKM berhasil diperbarui');
      setDialog(null);
      if (photoPreview) URL.revokeObjectURL(photoPreview);
      setPhotoPreview(null);
      qc.invalidateQueries({ queryKey: ['umkm'] });
      qc.invalidateQueries({ queryKey: ['umkm-mine'] });
      qc.invalidateQueries({ queryKey: ['stats'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  // Aksi cepat Admin: setujui/tolak langsung dari baris (pakai endpoint update).
  const setStatusFast = useMutation({
    mutationFn: ({ u, next, catatan }: { u: Umkm; next: UmkmStatus; catatan?: string }) =>
      updateUmkm(u.id, { status: next, catatan: catatan ?? (next === 'disetujui' ? 'Terverifikasi' : 'Ditolak') }),
    onSuccess: (_d, v) => {
      toast.success(`${v.u.nama_usaha} ${v.next === 'disetujui' ? 'disetujui' : 'ditolak'}`);
      setReject(null);
      setRejectNote('');
      qc.invalidateQueries({ queryKey: ['umkm'] });
      qc.invalidateQueries({ queryKey: ['umkm-mine'] });
      qc.invalidateQueries({ queryKey: ['stats'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  const remove = useMutation({
    mutationFn: (u: Umkm) => deleteUmkm(u.id),
    onSuccess: () => {
      toast.success('UMKM berhasil dihapus');
      setDel(null);
      qc.invalidateQueries({ queryKey: ['umkm'] });
      qc.invalidateQueries({ queryKey: ['umkm-mine'] });
    },
    onError: (e) => toast.error(apiError(e)),
  });

  const req: { name: keyof Form; label: string }[] = [
    { name: 'nama_usaha', label: 'Nama usaha' },
    { name: 'nama_merek_produk', label: 'Merek produk' },
    { name: 'kategori_produk', label: 'Kategori' },
    { name: 'jenis_usaha', label: 'Jenis usaha' },
    { name: 'pendapatan', label: 'Pendapatan' },
    { name: 'jalan', label: 'Jalan' },
    { name: 'desa_kelurahan', label: 'Desa/Kelurahan' },
    { name: 'kecamatan', label: 'Kecamatan' },
  ];
  const opt: { name: keyof Form; label: string }[] = [
    { name: 'nib', label: 'NIB' }, { name: 'pirt', label: 'PIRT' }, { name: 'bpom', label: 'BPOM' },
    { name: 'halal', label: 'Halal' }, { name: 'haki', label: 'HAKI' }, { name: 'lainnya', label: 'Lainnya' },
    { name: 'online', label: 'Online' }, { name: 'offline', label: 'Offline' }, { name: 'agen_reseller', label: 'Agen/Reseller' },
  ];
  const links: { name: keyof Form; label: string }[] = [
    { name: 'whatsapp', label: 'WhatsApp' }, { name: 'shopee', label: 'Shopee' },
    { name: 'tokopedia', label: 'Tokopedia' }, { name: 'lazada', label: 'Lazada' },
    { name: 'blibli', label: 'Blibli' }, { name: 'facebook', label: 'Facebook' },
    { name: 'instagram', label: 'Instagram' }, { name: 'tiktok', label: 'TikTok' },
    { name: 'twitter', label: 'Twitter/X' },
  ];

  return (
    <div className="flex flex-col gap-4">
      <div className="flex flex-wrap items-end justify-between gap-2">
        <div>
          <h1 className="text-2xl font-bold">
            {isAdmin
              ? status === 'semua'
                ? 'UMKM'
                : `UMKM ${status[0].toUpperCase()}${status.slice(1)}`
              : 'UMKM Saya'}
          </h1>
          <p className="text-sm text-muted-foreground">
            {isAdmin ? 'Verifikasi & kelola seluruh UMKM' : 'Kelola data usaha milik Anda'}
          </p>
        </div>
        <div className="flex gap-2">
          <Button size="sm" variant="outline" onClick={exportCsv} disabled={items.length === 0}>
            <Download className="h-4 w-4" /> <span className="hidden sm:inline">Ekspor</span> CSV
          </Button>
          <Button size="sm" onClick={openCreate}><Plus className="h-4 w-4" /> Tambah</Button>
        </div>
      </div>

      <div className="flex flex-col gap-2 sm:flex-row sm:items-center">
        <Input className="w-full sm:max-w-xs" placeholder="Cari usaha / merek / kategori…" value={q} onChange={(e) => setQ(e.target.value)} />
        {isAdmin && (
          <Select value={status} onValueChange={(v) => changeStatus(v as typeof status)}>
            <SelectTrigger className="w-full sm:w-44"><SelectValue /></SelectTrigger>
            <SelectContent>
              <SelectItem value="semua">Semua status</SelectItem>
              <SelectItem value="menunggu">Menunggu</SelectItem>
              <SelectItem value="disetujui">Disetujui</SelectItem>
              <SelectItem value="ditolak">Ditolak</SelectItem>
            </SelectContent>
          </Select>
        )}
      </div>

      <Card>
        <CardHeader className="flex flex-row items-center justify-between">
          <CardTitle className="text-base">Daftar UMKM ({items.length})</CardTitle>
          {items.length > 0 && (
            <p className="text-xs text-muted-foreground">
              Hal. {safePage} dari {pages} · {paged.length} baris
            </p>
          )}
        </CardHeader>
        <CardContent className="p-0 sm:p-6 sm:pt-0">
          {query.isLoading && <p className="p-4 text-sm text-muted-foreground">Memuat…</p>}
          {query.isError && <p className="p-4 text-sm text-destructive">{apiError(query.error)}</p>}
          {query.data && (
            <Table className="min-w-[560px]">
              <TableHeader>
                <TableRow>
                  <TableHead>Usaha</TableHead>
                  <TableHead className="hidden lg:table-cell">Pemilik</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead className="text-right">Aksi</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {items.length === 0 && (
                  <TableRow>
                    <TableCell colSpan={isAdmin ? 4 : 3} className="py-10 text-center text-sm text-muted-foreground">
                      {q ? 'Tidak ada hasil untuk pencarian tersebut.' : 'Belum ada data usaha di daftar ini.'}
                    </TableCell>
                  </TableRow>
                )}
                {paged.map((u) => (
                  <TableRow key={u.id}>
                    <TableCell>
                      <div className="flex items-center gap-3">
                        <img src={uploadUrl('umkm', u.photo)} alt={u.nama_usaha} className="h-10 w-10 shrink-0 rounded-md object-cover" loading="lazy" />
                        <div>
                          <p className="font-medium">{u.nama_usaha}</p>
                          <p className="text-xs text-muted-foreground">{u.nama_merek_produk} · {u.kecamatan}</p>
                        </div>
                      </div>
                    </TableCell>
                    <TableCell className="hidden lg:table-cell text-xs">{u.fullname ?? u.username}</TableCell>
                    <TableCell><Badge variant={STATUS_VARIANT[u.status]}>{u.status}</Badge></TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-1">
                        <Link to={`/usaha/${u.id}`}><Button variant="ghost" size="icon" aria-label="Lihat"><Eye className="h-4 w-4" /></Button></Link>
                        {isAdmin && u.status === 'menunggu' && (
                          <>
                            <Button
                              variant="ghost" size="icon" aria-label="Setujui"
                              disabled={setStatusFast.isPending}
                              onClick={() => setStatusFast.mutate({ u, next: 'disetujui' })}
                            >
                              <Check className="h-4 w-4 text-green-700 dark:text-green-400" />
                            </Button>
                            <Button
                              variant="ghost" size="icon" aria-label="Tolak"
                              disabled={setStatusFast.isPending}
                              onClick={() => { setReject(u); setRejectNote(''); }}
                            >
                              <X className="h-4 w-4 text-destructive" />
                            </Button>
                          </>
                        )}
                        <Button variant="ghost" size="icon" onClick={() => openEdit(u)} aria-label="Ubah"><Pencil className="h-4 w-4" /></Button>
                        <Button variant="ghost" size="icon" onClick={() => setDel(u)} aria-label="Hapus"><Trash2 className="h-4 w-4 text-destructive" /></Button>
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          )}
        </CardContent>
        {pages > 1 && (
          <div className="flex items-center justify-between gap-2 border-t border-border px-4 py-3 sm:px-6">
            <p className="text-xs text-muted-foreground">
              {(safePage - 1) * PAGE_SIZE + 1}–{Math.min(safePage * PAGE_SIZE, items.length)} dari {items.length}
            </p>
            <div className="flex items-center gap-1">
              <Button variant="outline" size="icon" disabled={safePage <= 1} onClick={() => setPage(safePage - 1)} aria-label="Halaman sebelumnya">
                <ChevronLeft className="h-4 w-4" />
              </Button>
              <span className="min-w-16 text-center text-sm tabular-nums">
                {safePage} / {pages}
              </span>
              <Button variant="outline" size="icon" disabled={safePage >= pages} onClick={() => setPage(safePage + 1)} aria-label="Halaman berikutnya">
                <ChevronRight className="h-4 w-4" />
              </Button>
            </div>
          </div>
        )}
      </Card>

      <Dialog open={dialog !== null} onOpenChange={(o) => !o && setDialog(null)}>
        <DialogContent className="max-w-2xl">
          <DialogHeader className="pb-1">
            <DialogTitle className="text-lg sm:text-xl">{dialog?.mode === 'create' ? 'Tambah Data UMKM' : 'Ubah Data UMKM'}</DialogTitle>
            <DialogDescription>Isi data usaha dengan lengkap — tanda * wajib diisi.</DialogDescription>
          </DialogHeader>
          <form onSubmit={form.handleSubmit((v) => save.mutate(v))} className="flex flex-col gap-3 sm:gap-4">
            {isAdmin && dialog?.mode === 'create' && (
              <div className="flex flex-col gap-1.5">
                <Label htmlFor="m-username">Username pemilik</Label>
                <Input id="m-username" placeholder="Default: akun sendiri" {...form.register('username')} />
              </div>
            )}
            <div className="grid gap-3 sm:grid-cols-2">
              {req.map((f) => (
                <div key={f.name} className="flex flex-col gap-1.5">
                  <Label htmlFor={`m-${f.name}`}>{f.label} *</Label>
                  <Input id={`m-${f.name}`} {...form.register(f.name)} />
                  {form.formState.errors[f.name] && <p className="text-xs text-destructive">{form.formState.errors[f.name]?.message as string}</p>}
                </div>
              ))}
            </div>
            <div className="flex flex-col gap-1.5">
              <Label htmlFor="m-deskripsi">Deskripsi produk</Label>
              <Textarea id="m-deskripsi" {...form.register('deskripsi_produk')} />
            </div>
            <div className="grid gap-3 sm:grid-cols-3">
              {opt.map((f) => (
                <div key={f.name} className="flex flex-col gap-1.5">
                  <Label htmlFor={`m-${f.name}`}>{f.label}</Label>
                  <Input id={`m-${f.name}`} {...form.register(f.name)} />
                </div>
              ))}
            </div>
            <div className="flex flex-col gap-2">
              <p className="text-sm font-medium">Tautan pemasaran (isi username/nomor saja, URL dibangun otomatis)</p>
              <div className="grid gap-3 sm:grid-cols-3">
                {links.map((f) => (
                  <div key={f.name} className="flex flex-col gap-1.5">
                    <Label htmlFor={`m-${f.name}`}>{f.label}</Label>
                    <Input id={`m-${f.name}`} {...form.register(f.name)} />
                  </div>
                ))}
              </div>
            </div>
            {isAdmin && (
              <div className="grid gap-3 sm:grid-cols-2">
                <div className="flex flex-col gap-1.5">
                  <Label>Status</Label>
                  <Select value={form.watch('status') ?? 'menunggu'} onValueChange={(v) => form.setValue('status', v as UmkmStatus)}>
                    <SelectTrigger><SelectValue /></SelectTrigger>
                    <SelectContent>
                      <SelectItem value="menunggu">Menunggu</SelectItem>
                      <SelectItem value="disetujui">Disetujui</SelectItem>
                      <SelectItem value="ditolak">Ditolak</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                <div className="flex flex-col gap-1.5">
                  <Label htmlFor="m-catatan">Catatan verifikasi</Label>
                  <Input id="m-catatan" {...form.register('catatan')} />
                </div>
              </div>
            )}
            <div className="flex flex-col gap-1.5">
              <Label htmlFor="m-photo">Foto (jpg/png/gif, maks 2MB)</Label>
              <Input
                id="m-photo" type="file" accept="image/jpeg,image/png,image/gif"
                onChange={(e) => {
                  const f = e.target.files?.[0] ?? null;
                  setPhoto(f);
                  if (photoPreview) URL.revokeObjectURL(photoPreview);
                  setPhotoPreview(f ? URL.createObjectURL(f) : null);
                }}
              />
              {(photoPreview || editingUmkm?.photo) && (
                <img
                  src={photoPreview ?? uploadUrl('umkm', editingUmkm!.photo)}
                  alt="Pratinjau foto usaha"
                  className="mt-1 max-h-40 w-full rounded-md border border-border bg-muted object-contain"
                />
              )}
              {!photoPreview && editingUmkm?.photo === 'default.png' && (
                <p className="text-xs text-muted-foreground">Belum ada foto — pilih file untuk menambahkan.</p>
              )}
            </div>
            <DialogFooter>
              <Button
                type="button" variant="outline"
                onClick={() => {
                  setDialog(null);
                  if (photoPreview) URL.revokeObjectURL(photoPreview);
                  setPhotoPreview(null);
                }}
              >
                Batal
              </Button>
              <Button type="submit" disabled={save.isPending}>{save.isPending ? 'Menyimpan…' : 'Simpan'}</Button>
            </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>

      <Dialog open={reject !== null} onOpenChange={(o) => { if (!o) { setReject(null); setRejectNote(''); } }}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Tolak {reject?.nama_usaha}?</DialogTitle>
            <DialogDescription>
              Catatan ini dikirim ke pemilik usaha sebagai alasan penolakan — opsional, tapi disarankan diisi.
            </DialogDescription>
          </DialogHeader>
          <div className="flex flex-col gap-1.5">
            <Label htmlFor="reject-note">Catatan verifikasi</Label>
            <Textarea
              id="reject-note"
              rows={3}
              placeholder="Contoh: foto produk belum jelas, mohon lengkapi dokumen NIB."
              value={rejectNote}
              onChange={(e) => setRejectNote(e.target.value)}
            />
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => { setReject(null); setRejectNote(''); }}>Batal</Button>
            <Button
              variant="destructive"
              disabled={setStatusFast.isPending}
              onClick={() => reject && setStatusFast.mutate({ u: reject, next: 'ditolak', catatan: rejectNote.trim() || 'Ditolak' })}
            >
              {setStatusFast.isPending ? 'Menyimpan…' : 'Tolak UMKM'}
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      <Dialog open={del !== null} onOpenChange={(o) => !o && setDel(null)}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Hapus {del?.nama_usaha}?</DialogTitle>
            <DialogDescription>Tindakan ini tidak bisa dibatalkan.</DialogDescription>
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
