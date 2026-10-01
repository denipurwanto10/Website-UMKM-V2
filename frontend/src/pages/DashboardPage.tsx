import { useQuery } from '@tanstack/react-query';
import { Link } from 'react-router-dom';
import {
  ArrowRight,
  CheckCircle2,
  Clock3,
  Download,
  Megaphone,
  RefreshCw,
  ShieldCheck,
  Store,
  Users,
  XCircle,
} from 'lucide-react';
import {
  Bar,
  BarChart,
  CartesianGrid,
  Cell,
  Legend,
  Pie,
  PieChart,
  ResponsiveContainer,
  Tooltip,
  XAxis,
  YAxis,
} from 'recharts';
import { Badge } from '../components/ui/badge';
import { Button } from '../components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../components/ui/card';
import { ChartContainer, ChartTooltipContent } from '../components/ui/chart';
import { Skeleton } from '../components/ui/skeleton';
import { apiError } from '../services/api';
import { getStats } from '../services/stats.service';
import { listUmkm, umkmByUsername } from '../services/umkm.service';
import { csvFileName, downloadCsv } from '../lib/export';
import { uploadUrl } from '../lib/uploads';
import { useAuth } from '../hooks/useAuth';

// Grayscale pie — hitam-putih, tanpa warna aksen.
const GRAYSCALE = ['#18181b', '#3f3f46', '#63636b', '#8b8b93', '#b5b5bb', '#d4d4d8', '#e9e9ec'];

/** Ringkasan verifikasi Admin: menunggu/disetujui/ditolak + tautan filter per status. */
function VerificationSummary({ menunggu, disetujui, ditolak }: { menunggu: number; disetujui: number; ditolak: number }) {
  const total = menunggu + disetujui + ditolak;
  const rows = [
    { label: 'Menunggu verifikasi', value: menunggu, to: '/umkm?status=menunggu', icon: Clock3 },
    { label: 'Terverifikasi', value: disetujui, to: '/umkm?status=disetujui', icon: CheckCircle2 },
    { label: 'Ditolak', value: ditolak, to: '/umkm?status=ditolak', icon: XCircle },
  ];
  return (
    <Card>
      <CardHeader>
        <CardTitle className="text-base">Status Verifikasi</CardTitle>
        <CardDescription>{total} data usaha masuk — klik baris untuk menindaklanjuti</CardDescription>
      </CardHeader>
      <CardContent className="flex flex-col gap-1">
        {rows.map((r) => (
          <Link key={r.label} to={r.to} className="flex items-center gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-muted">
            <r.icon className="h-4 w-4 shrink-0 text-muted-foreground" />
            <div className="min-w-0 flex-1">
              <div className="flex items-baseline justify-between gap-2">
                <p className="truncate text-sm font-medium">{r.label}</p>
                <p className="text-sm font-bold tabular-nums">{r.value}</p>
              </div>
              <div className="mt-1.5 h-1.5 overflow-hidden rounded-full bg-muted">
                <div className="h-full rounded-full bg-foreground" style={{ width: `${total > 0 ? Math.round((r.value / total) * 100) : 0}%` }} />
              </div>
            </div>
            <ArrowRight className="h-4 w-4 shrink-0 text-muted-foreground" />
          </Link>
        ))}
      </CardContent>
    </Card>
  );
}

// Layout parity dashboard CI3 (Sneat): 3 kartu ringkas atas,
// kiri = bar kategori + bar desa-per-kecamatan, kanan = pie desa-per-kategori,
// bawah = bar horizontal jenis usaha. Owner tetap sapaan saja (parity CI3).
export function DashboardPage() {
  const { user } = useAuth();
  const isAdmin = user?.usertype === 'Admin';
  const stats = useQuery({ queryKey: ['stats'], queryFn: getStats, enabled: isAdmin });
  // Seluruh UMKM — ringkasan verifikasi + daftar terbaru (12 baris, ringan).
  const allUmkm = useQuery({ queryKey: ['umkm'], queryFn: listUmkm, enabled: isAdmin });
  const mine = useQuery({
    queryKey: ['umkm-mine', user?.username],
    queryFn: () => umkmByUsername(user!.username),
    enabled: !isAdmin && !!user,
  });

  if (!isAdmin) {
    const items = mine.data ?? [];
    const first = items[0];
    return (
      <div className="flex flex-col gap-4">
        <div>
          <h1 className="text-xl font-bold sm:text-2xl">Selamat datang, {user?.fullname}</h1>
          <p className="text-sm text-muted-foreground">Pantau status verifikasi usaha Anda dan lengkapi kebutuhan promosi.</p>
        </div>
        {mine.isLoading ? (
          <div className="grid gap-3 sm:grid-cols-3 sm:gap-4">
            {[0, 1, 2].map((i) => (
              <Card key={i}>
                <CardContent className="pt-6">
                  <Skeleton className="h-9 w-20" />
                  <Skeleton className="mt-2 h-4 w-32" />
                </CardContent>
              </Card>
            ))}
          </div>
        ) : mine.isError ? (
          <Card>
            <CardContent className="flex flex-col items-start gap-2 pt-6">
              <p className="text-sm text-destructive">{apiError(mine.error)}</p>
              <Button size="sm" variant="outline" onClick={() => mine.refetch()}>Coba lagi</Button>
            </CardContent>
          </Card>
        ) : (
          <div className="grid gap-3 sm:grid-cols-3 sm:gap-4">
            <Card className="border-l-4 border-l-foreground">
              <CardHeader className="pb-2">
                <CardTitle className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Usaha Saya</CardTitle>
                <p className="mt-1 text-3xl font-bold tabular-nums">{items.length}</p>
              </CardHeader>
              <CardContent className="pt-0">
                {first ? (
                  <Badge variant={first.status === 'disetujui' ? 'success' : first.status === 'ditolak' ? 'destructive' : 'warning'}>
                    {first.nama_usaha} — {first.status}
                  </Badge>
                ) : (
                  <p className="text-xs text-muted-foreground">Belum ada data usaha</p>
                )}
              </CardContent>
            </Card>
            <Card className="flex flex-col justify-between gap-3 p-6 sm:col-span-2">
              <div>
                <CardTitle className="text-base">Langkah berikutnya</CardTitle>
                <CardDescription>
                  {items.length === 0
                    ? 'Daftarkan usaha Anda agar terdata di sistem Disdagin.'
                    : first?.status === 'menunggu'
                      ? 'Data Anda sedang diverifikasi admin — pastikan nomor HP aktif.'
                      : 'Lengkapi kebutuhan promosi agar usaha Anda ikut difasilitasi.'}
                </CardDescription>
              </div>
              <div className="flex flex-wrap gap-2">
                <Link to="/umkm">
                  <Button size="sm">
                    <Store className="h-4 w-4" /> {items.length === 0 ? 'Daftarkan usaha' : 'Kelola usaha'}
                  </Button>
                </Link>
                <Link to="/promosi">
                  <Button size="sm" variant="outline">
                    <Megaphone className="h-4 w-4" /> Isi data promosi
                  </Button>
                </Link>
              </div>
            </Card>
          </div>
        )}
      </div>
    );
  }

  if (stats.isLoading) {
    return (
      <div className="flex flex-col gap-4">
        <div>
          <h1 className="text-2xl font-bold">Dashboard</h1>
          <p className="text-sm text-muted-foreground">Memuat statistik…</p>
        </div>
        <div className="grid gap-4 sm:grid-cols-3">
          {[0, 1, 2].map((i) => (
            <Card key={i} className="animate-pulse">
              <CardHeader className="pb-2">
                <div className="h-4 w-32 rounded bg-muted" />
              </CardHeader>
              <CardContent>
                <div className="h-9 w-16 rounded bg-muted" />
              </CardContent>
            </Card>
          ))}
        </div>
        <Card className="animate-pulse">
          <CardContent className="h-64" />
        </Card>
      </div>
    );
  }

  if (stats.isError) {
    return (
      <div className="flex flex-col items-start gap-2">
        <h1 className="text-2xl font-bold">Dashboard</h1>
        <p className="text-sm text-destructive">{apiError(stats.error)}</p>
        <Button size="sm" variant="outline" onClick={() => stats.refetch()}>
          Coba lagi
        </Button>
      </div>
    );
  }

  const s = stats.data!;
  const menunggu = (allUmkm.data ?? []).filter((u) => u.status === 'menunggu').length;
  const ditolak = (allUmkm.data ?? []).filter((u) => u.status === 'ditolak').length;
  const latest = (allUmkm.data ?? []).slice(0, 5);
  const updatedAt = stats.dataUpdatedAt ? new Date(stats.dataUpdatedAt).toLocaleTimeString('id-ID') : '';

  const cards = [
    { label: 'Data Admin', value: s.admins, icon: ShieldCheck, desc: `${s.users} total pengguna`, to: '/users' },
    { label: 'Data Pemilik UMKM', value: s.owners, icon: Users, desc: 'Akun Owner terdaftar', to: '/users' },
    { label: 'Data UMKM', value: s.disetujui, icon: Store, desc: `${s.umkm} total UMKM masuk`, to: '/umkm' },
  ];

  const perKategori = (s.perKategori ?? []).map((r) => ({
    kategori: r.kategori_produk,
    jumlah: Number(r.jumlah_umkm),
  }));
  const desaPerKecamatan = (s.desaPerKecamatan ?? []).map((r) => ({
    kecamatan: r.kecamatan,
    jumlah: Number(r.jumlah_desa),
  }));
  const desaPerKategori = (s.desaPerKategori ?? []).map((r) => ({
    kategori: r.kategori_produk,
    jumlah: Number(r.jumlah_desa),
  }));
  const jenisUsaha = (s.jenisUsaha ?? []).map((r) => ({
    jenis: r.jenis_usaha,
    jumlah: Number(r.jumlah),
  }));

  function exportStats() {
    downloadCsv(
      csvFileName('statistik_umkm'),
      ['Kelompok', 'Nama', 'Jumlah'],
      [
        ...perKategori.map((r): (string | number)[] => ['UMKM per kategori', r.kategori, r.jumlah]),
        ...jenisUsaha.map((r): (string | number)[] => ['UMKM per jenis usaha', r.jenis, r.jumlah]),
        ...desaPerKecamatan.map((r): (string | number)[] => ['Desa per kecamatan', r.kecamatan, r.jumlah]),
        ...desaPerKategori.map((r): (string | number)[] => ['Desa per kategori', r.kategori, r.jumlah]),
      ],
    );
  }

  return (
    <div className="flex flex-col gap-4">
      <div className="flex flex-wrap items-end justify-between gap-2">
        <div>
          <h1 className="text-xl font-bold sm:text-2xl">Dashboard</h1>
          <p className="text-sm text-muted-foreground">
            Selamat datang, {user?.fullname}
            {updatedAt && ` · diperbarui pukul ${updatedAt}`}
          </p>
        </div>
        <div className="flex gap-2">
          <Button
            size="sm"
            variant="outline"
            onClick={() => {
              stats.refetch();
              allUmkm.refetch();
            }}
            disabled={stats.isFetching}
          >
            <RefreshCw className={`h-4 w-4 ${stats.isFetching ? 'animate-spin' : ''}`} />
            <span className="hidden sm:inline">Perbarui</span>
          </Button>
          <Button size="sm" variant="outline" onClick={exportStats}>
            <Download className="h-4 w-4" />
            <span className="hidden sm:inline">Unduh CSV</span>
          </Button>
        </div>
      </div>

      {/* 3 kartu ringkas — klik menuju halaman terkait */}
      <div className="grid gap-3 sm:grid-cols-3 sm:gap-4">
        {cards.map((c) => (
          <Link key={c.label} to={c.to} className="h-full">
            <Card className="h-full border-l-4 border-l-foreground transition-colors hover:bg-muted/50">
              <CardHeader className="flex flex-row items-center justify-between pb-2">
                <div>
                  <CardTitle className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                    {c.label}
                  </CardTitle>
                  <p className="mt-1 text-3xl font-bold tabular-nums">{c.value}</p>
                </div>
                <span className="flex h-12 w-12 items-center justify-center rounded-full bg-muted">
                  <c.icon className="h-6 w-6" />
                </span>
              </CardHeader>
              <CardContent className="flex items-center justify-between pt-0">
                <p className="text-xs text-muted-foreground">{c.desc}</p>
                <ArrowRight className="h-4 w-4 text-muted-foreground" />
              </CardContent>
            </Card>
          </Link>
        ))}
      </div>

      {/* Verifikasi + usaha terbaru masuk */}
      <div className="grid gap-4 xl:grid-cols-2">
        <VerificationSummary menunggu={menunggu} disetujui={s.disetujui} ditolak={ditolak} />
        <Card>
          <CardHeader className="flex flex-row items-center justify-between">
            <div>
              <CardTitle className="text-base">Usaha Terbaru Masuk</CardTitle>
              <CardDescription>5 data terakhir yang didaftarkan pemilik usaha</CardDescription>
            </div>
            <Link to="/umkm">
              <Button variant="ghost" size="sm">
                Semua <ArrowRight className="h-4 w-4" />
              </Button>
            </Link>
          </CardHeader>
          <CardContent className="flex flex-col gap-1 pt-0">
            {allUmkm.isLoading ? (
              <div className="flex flex-col gap-3 py-2">
                {[0, 1, 2].map((i) => (
                  <Skeleton key={i} className="h-11 w-full" />
                ))}
              </div>
            ) : latest.length === 0 ? (
              <p className="py-6 text-center text-sm text-muted-foreground">Belum ada data usaha.</p>
            ) : (
              latest.map((u) => (
                <Link key={u.id} to={`/usaha/${u.id}`} className="flex items-center gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-muted">
                  <img
                    src={uploadUrl('umkm', u.photo)}
                    alt={u.nama_usaha}
                    loading="lazy"
                    className="h-9 w-9 shrink-0 rounded-md bg-muted object-cover"
                  />
                  <div className="min-w-0 flex-1">
                    <p className="truncate text-sm font-medium">{u.nama_usaha}</p>
                    <p className="truncate text-xs text-muted-foreground">{u.kecamatan}</p>
                  </div>
                  <Badge variant={u.status === 'disetujui' ? 'success' : u.status === 'ditolak' ? 'destructive' : 'warning'}>
                    {u.status}
                  </Badge>
                </Link>
              ))
            )}
          </CardContent>
        </Card>
      </div>

      {/* Kiri: 2 bar — Kanan: pie */}
      <div className="grid gap-4 xl:grid-cols-2">
        <div className="flex flex-col gap-4">
          <Card>
            <CardHeader>
              <CardTitle className="text-base">Jumlah UMKM per Kategori</CardTitle>
              <CardDescription>UMKM disetujui, dikelompokkan per kategori produk</CardDescription>
            </CardHeader>
            <CardContent>
              <ChartContainer>
                <ResponsiveContainer width="100%" height="100%">
                  <BarChart data={perKategori} margin={{ top: 8, right: 8, bottom: 0, left: -12 }}>
                    <CartesianGrid strokeDasharray="3 3" className="stroke-border" />
                    <XAxis dataKey="kategori" tick={{ fontSize: 11 }} interval={0} angle={-12} dy={8} height={52} />
                    <YAxis allowDecimals={false} tick={{ fontSize: 11 }} />
                    <Tooltip content={<ChartTooltipContent />} cursor={{ fill: 'var(--muted)' }} />
                    <Bar dataKey="jumlah" name="UMKM" fill="currentColor" radius={[4, 4, 0, 0]} className="text-foreground" />
                  </BarChart>
                </ResponsiveContainer>
              </ChartContainer>
            </CardContent>
          </Card>

          <Card>
            <CardHeader>
              <CardTitle className="text-base">Jumlah Desa per Kecamatan</CardTitle>
              <CardDescription>Desa/kelurahan unik yang memiliki UMKM</CardDescription>
            </CardHeader>
            <CardContent>
              <ChartContainer>
                <ResponsiveContainer width="100%" height="100%">
                  <BarChart data={desaPerKecamatan} margin={{ top: 8, right: 8, bottom: 0, left: -12 }}>
                    <CartesianGrid strokeDasharray="3 3" className="stroke-border" />
                    <XAxis dataKey="kecamatan" tick={{ fontSize: 11 }} interval={0} angle={-12} dy={8} height={52} />
                    <YAxis allowDecimals={false} tick={{ fontSize: 11 }} />
                    <Tooltip content={<ChartTooltipContent />} cursor={{ fill: 'var(--muted)' }} />
                    <Bar dataKey="jumlah" name="Desa" fill="currentColor" radius={[4, 4, 0, 0]} className="text-foreground" />
                  </BarChart>
                </ResponsiveContainer>
              </ChartContainer>
            </CardContent>
          </Card>
        </div>

        <Card className="xl:h-full">
          <CardHeader>
            <CardTitle className="text-base">Jumlah Desa per Kategori</CardTitle>
            <CardDescription>Sebaran desa unik antar kategori produk</CardDescription>
          </CardHeader>
          <CardContent>
            <ChartContainer className="h-80 sm:h-96 xl:h-[32rem]">
              <ResponsiveContainer width="100%" height="100%">
                <PieChart>
                  <Pie data={desaPerKategori} dataKey="jumlah" nameKey="kategori" outerRadius="80%" label={{ fontSize: 11 }}>
                    {desaPerKategori.map((_, i) => (
                      <Cell key={i} fill={GRAYSCALE[i % GRAYSCALE.length]} stroke="var(--background)" strokeWidth={2} />
                    ))}
                  </Pie>
                  <Tooltip content={<ChartTooltipContent />} />
                  <Legend wrapperStyle={{ fontSize: 12 }} />
                </PieChart>
              </ResponsiveContainer>
            </ChartContainer>
          </CardContent>
        </Card>
      </div>

      {/* Bawah penuh: jenis usaha horizontal */}
      <Card>
        <CardHeader>
          <CardTitle className="text-base">Jumlah UMKM per Jenis Usaha</CardTitle>
          <CardDescription>Mikro, Kecil, dan Menengah</CardDescription>
        </CardHeader>
        <CardContent>
          <ChartContainer className="h-56">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={jenisUsaha} layout="vertical" margin={{ top: 8, right: 16, bottom: 0, left: 16 }}>
                <CartesianGrid strokeDasharray="3 3" className="stroke-border" horizontal={false} />
                <XAxis type="number" allowDecimals={false} tick={{ fontSize: 11 }} />
                <YAxis type="category" dataKey="jenis" tick={{ fontSize: 12 }} width={90} />
                <Tooltip content={<ChartTooltipContent />} cursor={{ fill: 'var(--muted)' }} />
                <Bar dataKey="jumlah" name="UMKM" fill="currentColor" radius={[0, 4, 4, 0]} className="text-foreground" />
              </BarChart>
            </ResponsiveContainer>
          </ChartContainer>
        </CardContent>
      </Card>
    </div>
  );
}
