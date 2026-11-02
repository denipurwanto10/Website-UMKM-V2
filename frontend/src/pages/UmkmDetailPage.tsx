import { useQuery } from '@tanstack/react-query';
import { Link, useNavigate, useParams } from 'react-router-dom';
import { ArrowLeft, ArrowUpRight, MapPin, Store } from 'lucide-react';
import { Badge } from '../components/ui/badge';
import { Button } from '../components/ui/button';
import { Photo } from '../components/Photo';
import { Skeleton } from '../components/ui/skeleton';
import { apiError } from '../services/api';
import { umkmDetail } from '../services/umkm.service';
import { uploadUrl } from '../lib/uploads';
import { Reveal } from '../lib/motion';

const LINK_LABELS: [string, string][] = [
  ['whatsapp', 'WhatsApp'],
  ['shopee', 'Shopee'],
  ['tokopedia', 'Tokopedia'],
  ['lazada', 'Lazada'],
  ['blibli', 'Blibli'],
  ['facebook', 'Facebook'],
  ['instagram', 'Instagram'],
  ['tiktok', 'TikTok'],
  ['twitter', 'Twitter/X'],
];

export function UmkmDetailPage() {
  const { id } = useParams();
  const nav = useNavigate();
  const detail = useQuery({ queryKey: ['umkm', id], queryFn: () => umkmDetail(Number(id)) });

  const back = (
    <Button variant="ghost" size="sm" className="-ms-2 w-fit" onClick={() => (window.history.length > 1 ? nav(-1) : nav('/'))}>
      <ArrowLeft /> Kembali
    </Button>
  );

  if (detail.isLoading)
    return (
      <div className="mx-auto flex max-w-5xl flex-col gap-6">
        {back}
        <Skeleton className="aspect-[16/8] w-full rounded-3xl" />
        <Skeleton className="h-9 w-2/3" />
        <Skeleton className="h-4 w-1/3" />
      </div>
    );

  if (detail.isError || !detail.data)
    return (
      <div className="mx-auto flex max-w-5xl flex-col items-start gap-4">
        <p className="text-sm text-destructive">{detail.isError ? apiError(detail.error) : 'Data tidak ditemukan'}</p>
        <Link to="/">
          <Button variant="outline" size="sm">
            <ArrowLeft /> Ke beranda
          </Button>
        </Link>
      </div>
    );

  const u = detail.data;
  const rec = u as unknown as Record<string, string | null>;
  const links = LINK_LABELS.filter(([k]) => rec[k]);
  const hasPhoto = u.photo && u.photo.trim() !== '' && u.photo !== 'default.png';
  const legalitas = [
    ['Pendapatan', u.pendapatan],
    ['NIB', u.nib],
    ['PIRT', u.pirt],
    ['BPOM', u.bpom],
    ['Halal', u.halal],
    ['HAKI', u.haki],
  ].filter(([, v]) => v && String(v).trim() !== '') as [string, string][];

  return (
    <div className="mx-auto flex max-w-5xl flex-col gap-6">
      {back}

      <div className="hero-rise">
        <Photo
          src={hasPhoto ? uploadUrl('umkm', u.photo) : undefined}
          alt={u.nama_usaha}
          loading="eager"
          className="aspect-[16/10] w-full rounded-3xl sm:aspect-[16/8]"
          fallback={
            <div className="flex flex-col items-center gap-2">
              <Store className="h-10 w-10" />
              <p className="text-xs">Belum ada foto usaha</p>
            </div>
          }
        />
      </div>

      <div className="grid gap-10 lg:grid-cols-[1fr_20rem] lg:gap-14">
        <div className="hero-rise" style={{ ['--d' as string]: '120ms' }}>
          <div className="flex flex-wrap items-center gap-2">
            <Badge variant="secondary">{u.kategori_produk}</Badge>
            <Badge variant={u.status === 'disetujui' ? 'success' : u.status === 'ditolak' ? 'destructive' : 'warning'}>{u.status}</Badge>
          </div>
          <h1 className="mt-4 text-4xl font-normal leading-tight sm:text-5xl">{u.nama_usaha}</h1>
          <p className="mt-2 text-muted-foreground">
            {u.nama_merek_produk}, usaha {u.jenis_usaha.toLowerCase()}
          </p>
          <p className="mt-5 flex items-start gap-2.5 text-sm text-muted-foreground">
            <MapPin className="mt-0.5 h-4 w-4 shrink-0" />
            {u.jalan}, {u.desa_kelurahan}, {u.kecamatan}
          </p>
          {u.deskripsi_produk && <p className="mt-8 max-w-prose text-[15px] leading-[1.8]">{u.deskripsi_produk}</p>}
        </div>

        <aside className="flex flex-col gap-8 lg:sticky lg:top-24 lg:self-start">
          {legalitas.length > 0 && (
            <Reveal>
              <h2 className="mb-3 text-lg">Legalitas</h2>
              <dl className="divide-y divide-border border-y border-border text-sm">
                {legalitas.map(([k, v]) => (
                  <div key={k} className="flex items-baseline justify-between gap-4 py-3">
                    <dt className="text-muted-foreground">{k}</dt>
                    <dd className="break-all text-right font-medium">{v}</dd>
                  </div>
                ))}
              </dl>
            </Reveal>
          )}
          {links.length > 0 && (
            <Reveal delay={100}>
              <h2 className="mb-3 text-lg">Tersedia di</h2>
              <div className="flex flex-wrap gap-2">
                {links.map(([k, label]) => (
                  <a key={k} href={rec[k] as string} target="_blank" rel="noreferrer">
                    <Button variant="outline" size="sm">
                      {label} <ArrowUpRight />
                    </Button>
                  </a>
                ))}
              </div>
            </Reveal>
          )}
        </aside>
      </div>
    </div>
  );
}
