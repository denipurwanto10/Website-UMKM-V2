import { useMemo, useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import { Link } from 'react-router-dom';
import { Search, Store } from 'lucide-react';
import { Badge } from '../components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../components/ui/card';
import { Input } from '../components/ui/input';
import { apiError } from '../services/api';
import { listUmkm } from '../services/umkm.service';

// Parity halaman publik CI3: Auth::all (list disetujui) + Auth::cari (keyword).
export function HomePage() {
  const [q, setQ] = useState('');
  const umkm = useQuery({ queryKey: ['umkm-publik'], queryFn: listUmkm });

  const items = useMemo(() => {
    const all = (umkm.data ?? []).filter((u) => u.status === 'disetujui');
    const kw = q.trim().toLowerCase();
    if (!kw) return all;
    return all.filter((u) =>
      [u.nama_usaha, u.nama_merek_produk, u.kategori_produk, u.kecamatan, u.desa_kelurahan]
        .join(' ')
        .toLowerCase()
        .includes(kw),
    );
  }, [umkm.data, q]);

  return (
    <div className="flex flex-col gap-6">
      <div className="flex flex-col gap-3">
        <h1 className="text-2xl font-bold">Direktori UMKM</h1>
        <p className="text-sm text-muted-foreground">
          Daftar usaha mikro, kecil, dan menengah yang telah terverifikasi.
        </p>
        <div className="relative max-w-md">
          <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
          <Input
            className="ps-9"
            placeholder="Cari usaha, produk, kategori, kecamatan…"
            value={q}
            onChange={(e) => setQ(e.target.value)}
          />
        </div>
      </div>

      {umkm.isLoading && <p className="text-sm text-muted-foreground">Memuat data…</p>}
      {umkm.isError && <p className="text-sm text-destructive">{apiError(umkm.error)}</p>}
      {umkm.isSuccess && items.length === 0 && (
        <p className="text-sm text-muted-foreground">
          {q ? 'Tidak ada hasil untuk pencarian tersebut.' : 'Belum ada UMKM yang disetujui.'}
        </p>
      )}

      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {items.map((u) => (
          <Link key={u.id} to={`/umkm/${u.id}`}>
            <Card className="h-full transition-colors hover:border-primary">
              <CardHeader>
                <CardTitle className="flex items-center gap-2 text-base">
                  <Store className="h-4 w-4 shrink-0" /> {u.nama_usaha}
                </CardTitle>
                <CardDescription>{u.nama_merek_produk}</CardDescription>
              </CardHeader>
              <CardContent className="flex flex-wrap gap-2">
                <Badge variant="secondary">{u.kategori_produk}</Badge>
                <Badge variant="outline">{u.kecamatan}</Badge>
              </CardContent>
            </Card>
          </Link>
        ))}
      </div>
    </div>
  );
}
