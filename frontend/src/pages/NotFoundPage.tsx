import { Link } from 'react-router-dom';
import { ArrowLeft, Compass } from 'lucide-react';
import { Button } from '../components/ui/button';

export function NotFoundPage() {
  return (
    <div className="flex min-h-[50vh] flex-col items-center justify-center gap-4 text-center">
      <span className="flex h-16 w-16 items-center justify-center rounded-full bg-muted text-muted-foreground">
        <Compass className="h-8 w-8" />
      </span>
      <div>
        <p className="text-5xl font-bold tracking-tight">404</p>
        <p className="mt-2 text-sm text-muted-foreground">
          Halaman yang kamu cari tidak ditemukan atau sudah dipindahkan.
        </p>
      </div>
      <div className="flex gap-2">
        <Link to="/">
          <Button variant="outline" size="sm">
            <ArrowLeft className="h-4 w-4" /> Ke beranda
          </Button>
        </Link>
        <Link to="/peta">
          <Button size="sm">Lihat peta sebaran</Button>
        </Link>
      </div>
    </div>
  );
}