import { useMemo, useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import { Link } from 'react-router-dom';
import { ArrowRight, Map as MapIcon, Palette, Search, Shirt, Store, UtensilsCrossed } from 'lucide-react';
import { Button } from '../components/ui/button';
import { Photo } from '../components/Photo';
import { Skeleton } from '../components/ui/skeleton';
import { apiError } from '../services/api';
import { getStats } from '../services/stats.service';
import { listUmkm } from '../services/umkm.service';
import { uploadUrl } from '../lib/uploads';
import { useAuth } from '../hooks/useAuth';
import { CountUp, Reveal } from '../lib/motion';
import { cn } from '../lib/utils';
import type { Umkm } from '../types';

const KATEGORI = [
  { key: 'Kuliner', icon: UtensilsCrossed, desc: 'Makanan dan minuman.' },
  { key: 'Fashion', icon: Shirt, desc: 'Pakaian, tas, dan aksesori.' },
  { key: 'Kerajinan', icon: Palette, desc: 'Anyaman, ukiran, dan barang buatan tangan lainnya.' },
];

const hasPhoto = (p?: string) => !!p && p.trim() !== '' && p !== 'default.png';

function scrollToId(id: string) {
  document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function UmkmCard({ u }: { u: Umkm }) {
  return (
    <Link to={`/umkm/${u.id}`} className="group block h-full rounded-2xl">
      <Photo
        src={hasPhoto(u.photo) ? uploadUrl('umkm', u.photo) : undefined}
        alt={u.nama_usaha}
        className="aspect-[4/3] rounded-2xl"
        fallback={<span className="font-display text-5xl text-muted-foreground/50">{u.nama_usaha.charAt(0)}</span>}
      />
      <div className="px-0.5 pt-3.5">
        <p className="text-xs text-muted-foreground">{u.kategori_produk}</p>
        <h3 className="mt-0.5 font-medium leading-snug transition-colors duration-200 group-hover:text-primary">{u.nama_usaha}</h3>
        <p className="mt-0.5 truncate text-sm text-muted-foreground">
          {u.nama_merek_produk} · {u.kecamatan}
        </p>
      </div>
    </Link>
  );
}

export function HomePage() {
  const { user } = useAuth();
  const [q, setQ] = useState('');
  const [heroQ, setHeroQ] = useState('');
  const [cat, setCat] = useState('');
  const [showAll, setShowAll] = useState(false);

  const stats = useQuery({ queryKey: ['stats-publik'], queryFn: getStats, retry: 1 });
  const umkm = useQuery({ queryKey: ['umkm-publik'], queryFn: listUmkm });

  const approved = useMemo(() => (umkm.data ?? []).filter((u) => u.status === 'disetujui'), [umkm.data]);

  const catCount = useMemo(() => {
    const fromStats = new Map((stats.data?.perKategori ?? []).map((r) => [r.kategori_produk.toLowerCase(), Number(r.jumlah_umkm)]));
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
        [u.nama_usaha, u.nama_merek_produk, u.kategori_produk, u.kecamatan, u.desa_kelurahan].join(' ').toLowerCase().includes(kw),
      );
    }
    return list;
  }, [approved, cat, q]);

  // Acak seperti shuffle($umkm) di CI3 — 8 kartu, "Lihat semua" = semua.
  const visible = useMemo(() => {
    if (showAll || q || cat) return filtered;
    const arr = [...filtered];
    for (let i = arr.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr.slice(0, 8);
  }, [filtered, showAll, q, cat]);

  // Mosaik hero: usaha yang benar-benar punya foto (stabil, tidak diacak ulang).
  const mosaic = useMemo(() => approved.filter((u) => hasPhoto(u.photo)).slice(0, 4), [approved]);

  function pickCategory(k: string) {
    setCat(k);
    setShowAll(false);
    scrollToId('umkm');
  }

  const figures = [
    { value: stats.data?.users ?? 0, label: 'Pengguna' },
    { value: stats.data?.owners ?? 0, label: 'Pemilik usaha' },
    { value: stats.data?.umkm ?? 0, label: 'Usaha terdata' },
  ];

  return (
    <div className="flex w-full flex-col">
      {/* HERO */}
      <section className="relative overflow-hidden">
        <div
          aria-hidden
          className="pointer-events-none absolute inset-x-0 top-0 h-[36rem] [background:radial-gradient(52rem_26rem_at_90%_-10%,color-mix(in_oklab,var(--primary)_18%,transparent),transparent_70%),radial-gradient(34rem_20rem_at_-5%_0%,color-mix(in_oklab,var(--primary)_8%,transparent),transparent_70%)]"
        />
        <div className="relative mx-auto grid max-w-6xl gap-12 px-4 pb-16 pt-10 sm:pt-16 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:gap-16 lg:pb-24 lg:pt-20">
          <div>
            <h1
              className="hero-rise text-[2.6rem] font-normal leading-[1.04] sm:text-6xl"
              style={{ ['--d' as string]: '60ms' }}
            >
              Cari UMKM di Kabupaten Bandung.
            </h1>
            <p
              className="hero-rise mt-5 max-w-md text-base leading-relaxed text-muted-foreground"
              style={{ ['--d' as string]: '180ms' }}
            >
              Data usaha lokal yang sudah diverifikasi Disdagin.
            </p>

            <form
              onSubmit={(e) => {
                e.preventDefault();
                setQ(heroQ);
                setCat('');
                scrollToId('umkm');
              }}
              className="hero-rise mt-8 flex max-w-lg items-center gap-2 rounded-2xl border border-input bg-card p-1.5 transition-[box-shadow,border-color] duration-300 focus-within:border-ring focus-within:shadow-[0_0_0_4px_color-mix(in_oklab,var(--ring)_14%,transparent)]"
              style={{ ['--d' as string]: '300ms' }}
            >
              <Search className="ms-3 h-4 w-4 shrink-0 text-muted-foreground" />
              <input
                value={heroQ}
                onChange={(e) => setHeroQ(e.target.value)}
                placeholder="Nama usaha, produk, atau kecamatan"
                aria-label="Cari UMKM"
                className="h-11 min-w-0 flex-1 bg-transparent px-1 text-[15px] outline-none placeholder:text-muted-foreground/80"
              />
              <Button type="submit" size="lg" className="h-11 rounded-xl px-5">
                Cari
              </Button>
            </form>

            <div
              className="hero-rise mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm"
              style={{ ['--d' as string]: '400ms' }}
            >
              <Link to="/peta" className="inline-flex items-center gap-2 text-muted-foreground transition-colors hover:text-foreground">
                <MapIcon className="h-4 w-4" /> Buka peta
              </Link>
              {!user && (
                <Link to="/register" className="text-muted-foreground transition-colors hover:text-foreground">
                  Daftarkan usaha
                </Link>
              )}
            </div>

            <dl
              className="hero-rise mt-12 grid max-w-lg grid-cols-3 divide-x divide-border"
              style={{ ['--d' as string]: '520ms' }}
            >
              {figures.map((f) => (
                <div key={f.label} className="flex flex-col-reverse gap-1 px-4 first:ps-0 sm:px-6 sm:first:ps-0">
                  <dt className="text-xs leading-snug text-muted-foreground sm:text-sm">{f.label}</dt>
                  <dd className="font-display text-3xl sm:text-4xl">
                    <CountUp value={f.value} />
                  </dd>
                </div>
              ))}
            </dl>
          </div>

          {/* Mosaik foto usaha nyata; fallback logo bila belum ada foto */}
          {mosaic.length >= 2 ? (
            <div className="grid grid-cols-2 gap-3 sm:gap-4">
              {[mosaic.filter((_, i) => i % 2 === 0), mosaic.filter((_, i) => i % 2 === 1)].map((col, ci) => (
                <div key={ci} className={cn('flex flex-col gap-3 sm:gap-4', ci === 1 && 'pt-8 sm:pt-14')}>
                  {col.map((u, ri) => {
                    const idx = ri * 2 + ci;
                    const ratio = (ri + ci) % 2 === 0 ? '4 / 5' : '1 / 1';
                    return (
                      <Link
                        key={u.id}
                        to={`/umkm/${u.id}`}
                        className="mosaic-tile group relative block overflow-hidden rounded-2xl bg-muted"
                        style={{ aspectRatio: ratio, ['--d' as string]: `${260 + idx * 130}ms` }}
                      >
                        <img
                          src={uploadUrl('umkm', u.photo)}
                          alt={u.nama_usaha}
                          loading="eager"
                          className="h-full w-full object-cover transition-transform duration-[1200ms] ease-smooth group-hover:scale-[1.05]"
                        />
                        <span className="absolute inset-x-0 bottom-0 translate-y-1 bg-gradient-to-t from-black/60 to-transparent p-3 pt-8 text-xs font-medium text-white opacity-0 transition-[opacity,transform] duration-500 ease-smooth group-hover:translate-y-0 group-hover:opacity-100 [@media(hover:none)]:translate-y-0 [@media(hover:none)]:opacity-100">
                          {u.nama_usaha}
                        </span>
                      </Link>
                    );
                  })}
                </div>
              ))}
            </div>
          ) : (
            <div className="hero-rise hidden justify-center lg:flex" style={{ ['--d' as string]: '400ms' }}>
              <div className="grid aspect-square w-full max-w-sm place-items-center rounded-3xl border border-border bg-card">
                <div className="text-center">
                  <img src="/logo.png" alt="Logo UMKM" className="mx-auto w-28 object-contain" />
                  <p className="mt-4 font-display text-xl">UMKM Kab. Bandung</p>
                  <p className="mt-1 text-xs text-muted-foreground">Dinas Perdagangan &amp; Perindustrian</p>
                </div>
              </div>
            </div>
          )}
        </div>
      </section>

      {/* KATEGORI */}
      <section id="kategori" className="scroll-mt-20 border-t border-border">
        <div className="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:py-24 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
          <Reveal>
            <h2 className="text-3xl leading-tight sm:text-4xl">Kategori</h2>
            <p className="mt-3 max-w-sm text-muted-foreground">Pilih satu untuk menyaring daftar.</p>
          </Reveal>
          <div className="divide-y divide-border border-y border-border">
            {KATEGORI.map((k, i) => (
              <Reveal key={k.key} delay={i * 90}>
                <button
                  type="button"
                  onClick={() => pickCategory(k.key)}
                  className="group flex w-full items-center gap-4 py-6 text-left sm:gap-6 sm:py-7"
                >
                  <k.icon className="h-5 w-5 shrink-0 text-muted-foreground transition-colors duration-300 group-hover:text-primary" />
                  <span className="min-w-0 flex-1 transition-transform duration-500 ease-smooth group-hover:translate-x-1">
                    <span className="flex items-baseline gap-3">
                      <span className="font-display text-2xl sm:text-[1.7rem]">{k.key}</span>
                      <span className="text-sm tabular-nums text-muted-foreground">{catCount(k.key)} usaha</span>
                    </span>
                    <span className="mt-1 block max-w-md text-sm leading-relaxed text-muted-foreground">{k.desc}</span>
                  </span>
                  <ArrowRight className="h-5 w-5 shrink-0 -translate-x-2 text-primary opacity-0 transition-[opacity,transform] duration-500 ease-smooth group-hover:translate-x-0 group-hover:opacity-100 [@media(hover:none)]:translate-x-0 [@media(hover:none)]:opacity-50" />
                </button>
              </Reveal>
            ))}
          </div>
        </div>
      </section>

      {/* DAFTAR */}
      <section id="umkm" className="scroll-mt-20 border-t border-border">
        <div className="mx-auto max-w-6xl px-4 py-16 sm:py-24">
          <Reveal className="flex flex-wrap items-end justify-between gap-4">
            <div>
              <h2 className="text-3xl leading-tight sm:text-4xl">Daftar UMKM</h2>
              <p className="mt-2 text-sm text-muted-foreground">
                {umkm.isSuccess ? `${filtered.length} usaha terverifikasi` : 'Usaha terverifikasi'}
              </p>
            </div>
            <div className="relative w-full sm:w-72">
              <Search className="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              <input
                value={q}
                onChange={(e) => setQ(e.target.value)}
                placeholder="Cari di daftar ini"
                aria-label="Cari di daftar"
                className="h-10 w-full rounded-xl border border-input bg-card ps-10 pe-3 text-sm transition-[border-color,box-shadow] duration-200 placeholder:text-muted-foreground/80 hover:border-ring/40 focus-visible:border-ring focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-ring/15"
              />
            </div>
          </Reveal>

          <div className="no-scrollbar -mx-4 mt-6 flex gap-2 overflow-x-auto px-4 pb-1">
            {['', ...KATEGORI.map((k) => k.key)].map((k) => (
              <button
                key={k || 'semua'}
                type="button"
                onClick={() => {
                  setCat(k);
                  setShowAll(false);
                }}
                aria-pressed={cat === k}
                className={cn(
                  'shrink-0 rounded-full border px-4 py-1.5 text-sm transition-[background-color,color,border-color,transform] duration-300 ease-smooth active:scale-95',
                  cat === k
                    ? 'border-primary bg-primary text-primary-foreground'
                    : 'border-border bg-card text-muted-foreground hover:border-ring/40 hover:text-foreground',
                )}
              >
                {k || 'Semua'}
              </button>
            ))}
          </div>

          {umkm.isLoading && (
            <div className="mt-8 grid gap-x-5 gap-y-9 sm:grid-cols-2 lg:grid-cols-4">
              {Array.from({ length: 8 }).map((_, i) => (
                <div key={i}>
                  <Skeleton className="aspect-[4/3] rounded-2xl" />
                  <Skeleton className="mt-3.5 h-3 w-16" />
                  <Skeleton className="mt-2 h-4 w-3/4" />
                  <Skeleton className="mt-2 h-3 w-1/2" />
                </div>
              ))}
            </div>
          )}

          {umkm.isError && (
            <div className="mt-8 flex flex-col items-start gap-3">
              <p className="text-sm text-destructive">{apiError(umkm.error)}</p>
              <Button size="sm" variant="outline" onClick={() => umkm.refetch()}>
                Coba lagi
              </Button>
            </div>
          )}

          {umkm.isSuccess && filtered.length === 0 && (
            <div className="page-enter mt-12 flex flex-col items-center gap-3 py-12 text-center">
              <span className="grid h-12 w-12 place-items-center rounded-full bg-muted text-muted-foreground">
                <Store className="h-5 w-5" />
              </span>
              <p className="text-sm text-muted-foreground">
                {q || cat ? 'Tidak ada usaha yang cocok.' : 'Belum ada usaha yang tampil.'}
              </p>
              {(q || cat) && (
                <Button
                  size="sm"
                  variant="outline"
                  onClick={() => {
                    setQ('');
                    setHeroQ('');
                    setCat('');
                  }}
                >
                  Hapus filter
                </Button>
              )}
            </div>
          )}

          <div key={`${cat}-${showAll}`} className="mt-8 grid gap-x-5 gap-y-9 sm:grid-cols-2 lg:grid-cols-4">
            {visible.map((u, i) => (
              <Reveal key={u.id} delay={(i % 4) * 70} className="h-full">
                <UmkmCard u={u} />
              </Reveal>
            ))}
          </div>

          {umkm.isSuccess && !q && !cat && filtered.length > 8 && (
            <div className="mt-12 text-center">
              <Button
                size="lg"
                variant="outline"
                onClick={() => {
                  setShowAll((v) => !v);
                  if (showAll) scrollToId('umkm');
                }}
              >
                {showAll ? 'Lebih sedikit' : `Lihat semua (${filtered.length})`}
                {!showAll && <ArrowRight />}
              </Button>
            </div>
          )}
        </div>
      </section>

      {/* AJAKAN DAFTAR */}
      {!user && (
        <section className="px-4 pb-16 sm:pb-24">
          <Reveal className="relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-[linear-gradient(150deg,#0d8a65_0%,#065a42_50%,#04271d_100%)] p-8 text-white sm:p-14">
            <svg viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" fill="none" stroke="currentColor" aria-hidden className="pointer-events-none absolute inset-0 h-full w-full opacity-[0.12]">
              {[0, 1, 2, 3, 4, 5].map((i) => (
                <path key={i} d={`M-20 ${40 + i * 52} C 60 ${i * 52}, 120 ${110 + i * 52}, 200 ${60 + i * 52} S 340 ${i * 52}, 420 ${50 + i * 52}`} />
              ))}
            </svg>
            <div className="relative flex flex-col gap-8 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h2 className="text-3xl leading-tight sm:text-4xl">Usaha Anda belum terdaftar?</h2>
                <p className="mt-3 max-w-md text-white/75">Buat akun, isi data usaha, lalu tunggu verifikasi admin.</p>
              </div>
              <div className="flex gap-2">
                <Link to="/register">
                  <Button size="lg" className="bg-white text-[#05261c] shadow-none hover:bg-white/90 hover:brightness-100">
                    Buat akun
                  </Button>
                </Link>
                <Link to="/login">
                  <Button size="lg" variant="outline" className="border-white/30 bg-transparent text-white shadow-none hover:border-white/50 hover:bg-white/10 hover:text-white">
                    Masuk
                  </Button>
                </Link>
              </div>
            </div>
          </Reveal>
        </section>
      )}
    </div>
  );
}
