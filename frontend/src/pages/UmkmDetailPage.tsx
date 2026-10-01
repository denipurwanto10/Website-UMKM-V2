import { useQuery } from '@tanstack/react-query';
import { Link, useParams } from 'react-router-dom';
import { ArrowLeft, ExternalLink, MapPin, Store } from 'lucide-react';
import { Badge } from '../components/ui/badge';
import { Button } from '../components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { apiError } from '../services/api';
import { umkmDetail } from '../services/umkm.service';
import { uploadUrl } from '../lib/uploads';

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
  const detail = useQuery({ queryKey: ['umkm', id], queryFn: () => umkmDetail(Number(id)) });

  if (detail.isLoading) return <p className="text-sm text-muted-foreground">Memuat…</p>;
  if (detail.isError || !detail.data)
    return (
      <div className="flex flex-col gap-4">
        <p className="text-sm text-destructive">{detail.isError ? apiError(detail.error) : 'Data tidak ditemukan'}</p>
        <Link to="/"><Button variant="outline" size="sm"><ArrowLeft className="h-4 w-4" /> Kembali</Button></Link>
      </div>
    );

  const u = detail.data;
  const links = LINK_LABELS.filter(([k]) => (u as unknown as Record<string, string | null>)[k]);
  const hasPhoto = u.photo && u.photo.trim() !== '' && u.photo !== 'default.png';
  // Data legalitas yang benar-benar terisi saja yang ditampilkan (kosong = sembunyikan).
  const legalitas = [
    ['Pendapatan', u.pendapatan],
    ['NIB', u.nib],
    ['PIRT', u.pirt],
    ['BPOM', u.bpom],
    ['Halal', u.halal],
    ['HAKI', u.haki],
  ].filter(([, v]) => v && String(v).trim() !== '') as [string, string][];

  return (
    <div className="mx-auto flex max-w-3xl flex-col gap-4">
      <Link to="/"><Button variant="ghost" size="sm"><ArrowLeft className="h-4 w-4" /> Kembali</Button></Link>
      <Card className="overflow-hidden pt-0">
        {hasPhoto ? (
          <img
            src={uploadUrl('umkm', u.photo)}
            alt={u.nama_usaha}
            onError={(e) => {
              e.currentTarget.style.display = 'none';
              (e.currentTarget.nextElementSibling as HTMLElement | null)?.classList.remove('hidden');
            }}
            className="max-h-[300px] w-full bg-muted object-contain"
          />
        ) : null}
        <div
          className={`${hasPhoto ? 'hidden' : ''} flex min-h-[180px] w-full flex-col items-center justify-center gap-1 bg-muted text-muted-foreground`}
        >
          <Store className="h-10 w-10" />
          <p className="text-xs">Belum ada foto usaha</p>
        </div>
        <CardHeader>
          <CardTitle className="text-xl">{u.nama_usaha}</CardTitle>
          <p className="text-sm text-muted-foreground">{u.nama_merek_produk} — {u.jenis_usaha}</p>
          <div className="flex flex-wrap gap-2 pt-1">
            <Badge variant="secondary">{u.kategori_produk}</Badge>
            <Badge variant={u.status === 'disetujui' ? 'success' : u.status === 'ditolak' ? 'destructive' : 'warning'}>
              {u.status}
            </Badge>
          </div>
        </CardHeader>
        <CardContent className="flex flex-col gap-4 text-sm">
          <p className="flex items-start gap-2">
            <MapPin className="mt-0.5 h-4 w-4 shrink-0 text-muted-foreground" />
            {u.jalan}, {u.desa_kelurahan}, {u.kecamatan}
          </p>
          {u.deskripsi_produk && <p className="text-muted-foreground">{u.deskripsi_produk}</p>}
          {legalitas.length > 0 && (
            <dl className="grid grid-cols-2 gap-2 sm:grid-cols-3">
              {legalitas.map(([k, v]) => (
                <div key={k} className="rounded-md border border-border p-2">
                  <dt className="text-xs text-muted-foreground">{k}</dt>
                  <dd className="break-all font-medium">{v}</dd>
                </div>
              ))}
            </dl>
          )}
          {links.length > 0 && (
            <div className="flex flex-col gap-2">
              <p className="font-medium">Tautan pemasaran</p>
              <div className="flex flex-wrap gap-2">
                {links.map(([k, label]) => (
                  <a
                    key={k}
                    href={(u as unknown as Record<string, string>)[k]}
                    target="_blank"
                    rel="noreferrer"
                  >
                    <Button variant="outline" size="sm">
                      {label} <ExternalLink className="h-3 w-3" />
                    </Button>
                  </a>
                ))}
              </div>
            </div>
          )}
        </CardContent>
      </Card>
    </div>
  );
}
