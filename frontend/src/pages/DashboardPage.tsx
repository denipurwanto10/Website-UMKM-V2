import { useQuery } from '@tanstack/react-query';
import { Megaphone, Store, Users } from 'lucide-react';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { apiError } from '../services/api';
import { getStats } from '../services/stats.service';
import { useAuth } from '../hooks/useAuth';

// Parity Dashboard CI3: counts users/UMKM + agregasi kategori & kecamatan.
export function DashboardPage() {
  const { user } = useAuth();
  const stats = useQuery({ queryKey: ['stats'], queryFn: getStats });

  if (stats.isLoading) return <p className="text-sm text-muted-foreground">Memuat statistik…</p>;
  if (stats.isError) return <p className="text-sm text-destructive">{apiError(stats.error)}</p>;

  const s = stats.data!;
  const cards = [
    { label: 'Total Users', value: s.users, icon: Users },
    { label: 'Total UMKM', value: s.umkm, icon: Store },
    { label: 'UMKM Disetujui', value: s.disetujui, icon: Megaphone },
  ];

  return (
    <div className="flex flex-col gap-6">
      <div>
        <h1 className="text-2xl font-bold">Dashboard</h1>
        <p className="text-sm text-muted-foreground">Selamat datang, {user?.fullname}</p>
      </div>
      <div className="grid gap-4 sm:grid-cols-3">
        {cards.map((c) => (
          <Card key={c.label}>
            <CardHeader className="flex flex-row items-center justify-between pb-2">
              <CardTitle className="text-sm font-medium text-muted-foreground">{c.label}</CardTitle>
              <c.icon className="h-4 w-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <p className="text-3xl font-bold">{c.value}</p>
            </CardContent>
          </Card>
        ))}
      </div>
      {s.perKategori.length > 0 && (
        <Card>
          <CardHeader>
            <CardTitle className="text-base">UMKM per Kategori</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="flex flex-col gap-2">
              {s.perKategori.map((r) => {
                const max = Math.max(...s.perKategori.map((x) => x.jumlah_umkm), 1);
                return (
                  <div key={r.kategori_produk} className="flex items-center gap-3 text-sm">
                    <span className="w-40 truncate">{r.kategori_produk}</span>
                    <div className="h-2 flex-1 overflow-hidden rounded bg-secondary">
                      <div className="h-full rounded bg-primary" style={{ width: `${(r.jumlah_umkm / max) * 100}%` }} />
                    </div>
                    <span className="w-8 text-right font-medium">{r.jumlah_umkm}</span>
                  </div>
                );
              })}
            </div>
          </CardContent>
        </Card>
      )}
    </div>
  );
}
