import { useEffect, useMemo, useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import { Link } from 'react-router-dom';
import {
  ArrowRight,
  ClipboardList,
  Map as MapIcon,
  Palette,
  Search,
  Shirt,
  Store,
  Users,
  UtensilsCrossed,
  X,
} from 'lucide-react';
import { Badge } from '../components/ui/badge';
import { Button } from '../components/ui/button';
import { Card, CardContent } from '../components/ui/card';
import { Input } from '../components/ui/input';
import { apiError } from '../services/api';
import { getStats } from '../services/stats.service';
import { listUmkm } from '../services/umkm.service';
import { uploadUrl } from '../lib/uploads';

// Layout parity halaman utama CI3 (index.php 514 baris) — versi hitam-putih:
// hero + stats-strip live → 3 kartu kategori → strip statistik → grid UMKM + Lihat Semua.
const KATEGORI = [
  {
    key: 'Kuliner',
    icon: UtensilsCrossed,
    desc: 'Dari cita rasa tradisional khas Sunda hingga inovasi kuliner modern yang menggugah selera.',
  },
  {
    key: 'Fashion',
    icon: Shirt,
    desc: 'Karya busana dan aksesori yang memadukan unsur tradisional dan tren modern nan elegan.',
  },
  {
    key: 'Kerajinan',
    icon: Palette,
    desc: 'Produk hasil tangan kreatif dari anyaman, ukiran, hingga daur ulang bernilai seni tinggi.',
  },
];

/** Angka naik animasi — parity animateCounter di CI3. */
function CountUp({ value }: { value: number }) {
  const [n, setN] = useState(0);
  useEffect(() => {
    if (!value || value <= 0) {
      setN(0);
      return;
    }
    let cur = 0;
    const step = Math.max(1, Math.ceil(value / 60));
    const t = setInterval(() => {
      cur += step;
      if (cur >= value) {
        cur = value;
        clearInterval(t);
      }
      setN(cur);
    }, 25);
    return () => clearInterval(t);
  }, [value]);
  return <>{n.toLocaleString('id-ID')}</>;
}

function scrollTo(id: string) {
  document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
}

// Parity halaman publik CI3: Auth::all (list disetujui) + Auth::cari (keyword).
export function HomePage() {
  const [q, setQ] = useState('');
  const [cat, setCat] = useState('');
  const [showAll, setShowAll] = useState(false);

  // Statistik publik — parity $.ajax api/stats di CI3 (sekarang tanpa login).
  const stats = useQuery({ queryKey: ['stats-publik'], queryFn: getStats, retry: 1 });
  const umkm = useQuery({ queryKey: ['umkm-publik'], queryFn: listUmkm });

  const approved = useMemo(
    () => (umkm.data ?? []).filter((u) => u.status === 'disetujui'),
    [umkm.data],
  );

  const catCount = useMemo(() => {
    const fromStats = new Map(
      (stats.data?.perKategori ?? []).map((r) => [r.kategori_produk.toLowerCase(), Number(r.jumlah_umkm)]),
    );
    const out = new Map<string, number>();
    for (const u of approved) {
      const k = u.kategori_produk.toLowerCase();
      out.set(k, (out.get(k) ?? 0) + 1);
    }
    return (key: string) => fromStats.get(key.toLowerCase()) ?? out.get(key.toLowerCase()) ?? 0;
  }, [stats.data, approved]);

  const filtered = useMemo(() => {
    let list = approved;
    if (cat) list = list.filter((u) => u.kategori_produk.toLowerCase() === cat.toLowerCase());
    const kw = q.trim().toLowerCase();
    if (kw) {
      list = list.filter((u) =>
        [u.nama_usaha, u.nama_merek_produk, u.kategori_produk, u.kecamatan, u.desa_kelurahan]
          .join(' ')
          .toLowerCase()
          .includes(kw),
      );
    }
    return list;
  }, [approved, cat, q]);

  // Acak seperti shuffle($umkm) di CI3 — 8 kartu, Lihat Semua = semua.
  const visible = useMemo(() => {
    if (showAll || q || cat) return filtered;
    const arr = [...filtered];
    for (let i = arr.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr.slice(0, 8);
  }, [filtered, showAll, q, cat]);

  const totalUsers = stats.data?.users ?? 0;
  const totalOwners = stats.data?.owners ?? 0;
  const totalUmkm = stats.data?.umkm ?? 0;

  return (
    <div className="flex w-full flex-col">
      {/* HERO — parity .hero-section CI3, hitam-putih */}
      <section className="relative w-full overflow-hidden bg-foreground text-background">
        {/* pola garis halus biar hitamnya nggak flat */}
        <div
          aria-hidden
          className="pointer-events-none absolute inset-0 opacity-[0.35]"
          style={{
            backgroundImage:
              'linear-gradient(to right, rgba(255,255,255,0.07) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.07) 1px, transparent 1px)',
            backgroundSize: '44px 44px',
            maskImage: 'radial-gradient(ellipse 90% 90% at 20% 20%, black 30%, transparent 75%)',
            WebkitMaskImage: 'radial-gradient(ellipse 90% 90% at 20% 20%, black 30%, transparent 75%)',
          }}
        />
        <div className="relative mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:py-16 lg:grid-cols-[1fr_320px] lg:items-center">
          <div>
            <p className="inline-flex items-center gap-2 rounded-full border border-background/25 bg-background/5 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-background/80">
              <span className="h-1.5 w-1.5 rounded-full bg-background" />
              Portal Resmi Disdagin Kab. Bandung
            </p>
            <h1 className="mt-4 max-w-2xl text-3xl font-bold leading-[1.1] tracking-tight sm:text-5xl">
              Selamat Datang di UMKM Kabupaten Bandung
            </h1>
            <p className="mt-4 max-w-xl text-sm leading-relaxed text-background/70 sm:text-base">
              Pusat informasi dan layanan digital yang dirancang untuk mendukung pengembangan Usaha
              Mikro, Kecil, dan Menengah di wilayah Kabupaten Bandung.
            </p>
            <div className="mt-6 flex flex-wrap gap-3">
              <Button size="lg" variant="secondary" onClick={() => scrollTo('umkm')}>
                Jelajahi UMKM
              </Button>
              <Link to="/peta">
                <Button size="lg" variant="outline" className="border-background/40 bg-background/5 text-background hover:bg-background/15 hover:text-background">
                  <MapIcon className="h-4 w-4" /> Lihat Peta
                </Button>
              </Link>
            </div>
          </div>
          <div className="hidden justify-center lg:flex">
            <div className="w-full rounded-3xl border border-background/20 bg-background/[0.04] px-8 py-10 text-center">
              <img src="/logo.png" alt="Logo UMKM" className="mx-auto w-32 object-contain" />
              <p className="mt-4 text-sm font-semibold">UMKM Kab. Bandung</p>
              <p className="mt-1 text-xs text-background/55">Dinas Perdagangan &amp; Perindustrian</p>
            </div>
          </div>
        </div>
      </section>

      {/* KATEGORI — parity 3 .kategori-card CI3 */}
      <section id="kategori" className="w-full scroll-mt-16 bg-background">
        <div className="mx-auto max-w-6xl px-4 py-14 sm:py-20">
          <div className="mx-auto mb-10 max-w-xl text-center">
            <p className="text-xs font-bold uppercase tracking-widest text-muted-foreground">Kategori UMKM</p>
            <h2 className="mt-2 text-2xl font-bold sm:text-3xl">Temukan Produk Unggulan</h2>
            <p className="mt-2 text-sm text-muted-foreground">
              Jelajahi berbagai kategori UMKM berkualitas dari seluruh penjuru Kabupaten Bandung.
            </p>
          </div>
          <div className="grid gap-4 md:grid-cols-3">
            {KATEGORI.map((k) => (
              <button
                key={k.key}
                type="button"
                onClick={() => {
                  setCat(k.key);
                  setShowAll(false);
                  scrollTo('umkm');
                }}
                className="group rounded-2xl border border-border bg-card p-7 text-left transition-all hover:-translate-y-1 hover:border-foreground hover:bg-foreground hover:text-background"
              >
                <span className="flex h-12 w-12 items-center justify-center rounded-xl bg-muted group-hover:bg-background/15">
                  <k.icon className="h-6 w-6" />
                </span>
                <span className="mt-4 flex items-center justify-between">
                  <span className="text-lg font-bold">{k.key}</span>
                  <span className="text-xs tabular-nums text-muted-foreground group-hover:text-background/70">
                    {catCount(k.key)} usaha
                  </span>
                </span>
                <span className="mt-2 block text-sm leading-relaxed text-muted-foreground group-hover:text-background/75">
                  {k.desc}
                </span>
                <span className="mt-4 inline-flex items-center gap-1 text-sm font-semibold">
                  Lihat UMKM <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </span>
              </button>
            ))}
          </div>
        </div>
      </section>

      {/* STATISTIK — parity .stats-section 3 kolom CI3 */}
      <section className="w-full scroll-mt-16 border-y border-border bg-muted/60">
        <div className="mx-auto grid max-w-6xl gap-4 px-4 py-12 sm:grid-cols-3">
          {[
            { icon: Users, value: totalUsers, label: 'Pengguna Sistem' },
            { icon: Store, value: totalOwners, label: 'Pengelola Usaha' },
            { icon: ClipboardList, value: totalUmkm, label: 'Total Data Usaha' },
          ].map((s) => (
            <Card key={s.label} className="text-center">
              <CardContent className="flex flex-col items-center gap-1 py-7">
                <s.icon className="h-6 w-6 text-muted-foreground" />
                <p className="mt-2 text-4xl font-bold tabular-nums">
                  <CountUp value={s.value} />
                </p>
                <p className="text-sm text-muted-foreground">{s.label}</p>
              </CardContent>
            </Card>
          ))}
        </div>
      </section>

      {/* GRID UMKM — parity .umkm-section + shuffle + Lihat Semua CI3 */}
      <section id="umkm" className="w-full scroll-mt-16 bg-background">
        <div className="mx-auto max-w-6xl px-4 py-14 sm:py-20">
          <div className="mb-6 flex flex-wrap items-end justify-between gap-3">
            <div>
              <p className="text-xs font-bold uppercase tracking-widest text-muted-foreground">Daftar UMKM</p>
              <h2 className="mt-1 text-2xl font-bold sm:text-3xl">UMKM Berkualitas</h2>
            </div>
            {!q && !cat && (
              <Button variant="outline" onClick={() => setShowAll((v) => !v)}>
                {showAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua'}
                {!showAll && <ArrowRight className="h-4 w-4" />}
              </Button>
            )}
          </div>

          <div className="mb-6 flex flex-wrap items-center gap-2">
            <div className="relative min-w-52 flex-1">
              <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              <Input
                className="ps-9"
                placeholder="Cari usaha, produk, kategori, kecamatan…"
                value={q}
                onChange={(e) => setQ(e.target.value)}
              />
            </div>
            {cat && (
              <Button variant="secondary" size="sm" onClick={() => setCat('')}>
                {cat} <X className="h-3.5 w-3.5" />
              </Button>
            )}
          </div>

          {umkm.isLoading && <p className="text-sm text-muted-foreground">Memuat data…</p>}
          {umkm.isError && (
            <div className="flex flex-col items-start gap-2">
              <p className="text-sm text-destructive">{apiError(umkm.error)}</p>
              <Button size="sm" variant="outline" onClick={() => umkm.refetch()}>
                Coba lagi
              </Button>
            </div>
          )}
          {umkm.isSuccess && filtered.length === 0 && (
            <p className="py-8 text-center text-sm text-muted-foreground">
              {q || cat ? 'Tidak ada hasil untuk pencarian tersebut.' : 'Tidak ada data UMKM yang ditemukan.'}
            </p>
          )}

          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {visible.map((u) => {
              const hasPhoto = u.photo && u.photo.trim() !== '' && u.photo !== 'default.png';
              return (
              <Link key={u.id} to={`/umkm/${u.id}`} className="h-full">
                <Card className="h-full overflow-hidden pt-0 transition-all hover:-translate-y-1 hover:shadow-lg">
                  {hasPhoto ? (
                    <img
                      src={uploadUrl('umkm', u.photo)}
                      alt={u.nama_usaha}
                      loading="lazy"
                      onError={(e) => {
                        e.currentTarget.style.display = 'none';
                        e.currentTarget.nextElementSibling?.classList.remove('hidden');
                        (e.currentTarget.nextElementSibling as HTMLElement | null)?.classList.add('flex');
                      }}
                      className="aspect-[16/10] w-full bg-muted object-cover"
                    />
                  ) : null}
                  <div
                    className={`${hasPhoto ? 'hidden' : 'flex'} aspect-[16/10] w-full flex-col items-center justify-center gap-1 bg-muted text-muted-foreground`}
                    aria-label={`Belum ada foto ${u.nama_usaha}`}
                  >
                    <span className="text-3xl font-bold uppercase">{u.nama_usaha.charAt(0)}</span>
                    <span className="flex items-center gap-1 text-[11px]">
                      <Store className="h-3 w-3" /> Belum ada foto
                    </span>
                  </div>
                  <CardContent className="flex flex-col gap-2 p-4">
                    <Badge variant="secondary" className="w-fit text-[11px] uppercase tracking-wide">
                      {u.kategori_produk}
                    </Badge>
                    <p className="font-bold leading-snug">{u.nama_usaha}</p>
                    <p className="text-xs text-muted-foreground">
                      {u.nama_merek_produk} · {u.kecamatan}
                    </p>
                  </CardContent>
                </Card>
              </Link>
              );
            })}
          </div>

          {umkm.isSuccess && !showAll && !q && !cat && filtered.length > 8 && (
            <div className="mt-8 text-center">
              <Button size="lg" onClick={() => setShowAll(true)}>
                Lihat Semua UMKM ({filtered.length}) <ArrowRight className="h-4 w-4" />
              </Button>
            </div>
          )}
        </div>
      </section>
    </div>
  );
}
