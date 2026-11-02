import { Link } from 'react-router-dom';
import { ArrowLeft } from 'lucide-react';
import { Button } from '../components/ui/button';

export function NotFoundPage() {
  return (
    <div className="flex min-h-[55vh] flex-col items-center justify-center gap-6 text-center">
      <p className="hero-rise font-display text-[7rem] font-normal leading-none text-muted-foreground/40 sm:text-[10rem]">404</p>
      <div className="hero-rise" style={{ ['--d' as string]: '120ms' }}>
        <h1 className="text-2xl sm:text-3xl">Halaman tidak ditemukan</h1>
        <p className="mx-auto mt-2 max-w-sm text-sm text-muted-foreground">
          Tautan ini salah atau halamannya sudah dihapus.
        </p>
      </div>
      <div className="hero-rise flex gap-2" style={{ ['--d' as string]: '240ms' }}>
        <Link to="/">
          <Button variant="outline">
            <ArrowLeft /> Ke beranda
          </Button>
        </Link>
        <Link to="/peta">
          <Button>Buka peta</Button>
        </Link>
      </div>
    </div>
  );
}
