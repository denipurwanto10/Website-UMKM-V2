import { Link, Outlet, useLocation, useNavigate } from 'react-router-dom';
import { LayoutDashboard, LogOut, Map as MapIcon, User as UserIcon } from 'lucide-react';
import { Button } from '../components/ui/button';
import { ThemeToggle } from '../components/ThemeToggle';
import { useAuth } from '../hooks/useAuth';

export function PublicLayout() {
  const { user, logout } = useAuth();
  const nav = useNavigate();
  const { pathname } = useLocation();
  // Home full-bleed (hero/statistik selebar layar ala CI3); halaman publik lain tetap di container.
  const isHome = pathname === '/';
  const year = new Date().getFullYear();

  return (
    <div className="min-h-screen bg-background text-foreground">
      <header className="sticky top-0 z-40 border-b border-border bg-background/95 backdrop-blur">
        <div className="mx-auto flex h-16 max-w-6xl items-center gap-2 px-4">
          <Link to="/" className="flex items-center gap-3">
            <img src="/logo.png" alt="Logo UMKM" className="h-10 w-10 object-contain" />
            <span className="text-sm font-bold leading-tight">
              UMKM
              <span className="block text-xs font-normal text-muted-foreground">Kabupaten Bandung</span>
            </span>
          </Link>
          {/* Parity navbar CI3: Home / Kategori / UMKM / Peta */}
          <nav className="ms-6 hidden items-center gap-1 lg:flex">
            <Link to="/" className="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground">
              Home
            </Link>
            <a href="/#kategori" className="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground">
              Kategori
            </a>
            <a href="/#umkm" className="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground">
              UMKM
            </a>
            <Link to="/peta" className="rounded-md px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground">
              Peta
            </Link>
          </nav>
          <nav className="ms-auto flex items-center gap-2">
            <ThemeToggle />
            <Link to="/peta" className="flex items-center gap-1.5 text-sm text-muted-foreground hover:text-foreground lg:hidden">
              <MapIcon className="h-4 w-4" /> Peta
            </Link>
            {user ? (
              <>
                <Button variant="ghost" size="sm" onClick={() => nav('/dashboard')}>
                  <LayoutDashboard className="h-4 w-4" /> Dashboard
                </Button>
                <span className="hidden text-sm text-muted-foreground sm:inline">
                  {user.fullname}
                </span>
                <Button
                  variant="outline"
                  size="sm"
                  onClick={() => {
                    logout();
                    nav('/');
                  }}
                >
                  <LogOut className="h-4 w-4" /> Keluar
                </Button>
              </>
            ) : (
              <>
                <Button variant="ghost" size="sm" onClick={() => nav('/login')}>
                  <UserIcon className="h-4 w-4" /> Masuk
                </Button>
                <Button size="sm" onClick={() => nav('/register')}>
                  Daftar
                </Button>
              </>
            )}
          </nav>
        </div>
      </header>
      {/* Home full-bleed (hero/statistik selebar layar ala CI3); halaman lain tetap container */}
      <main className={isHome ? 'w-full' : 'mx-auto w-full max-w-6xl px-4 py-8'}>
        <Outlet />
      </main>
      {/* FOOTER — parity footer CI3: brand + Navigasi + Layanan + Kontak */}
      <footer className="w-full bg-foreground text-background">
        <div className="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:grid-cols-2 lg:grid-cols-4">
          <div>
            <div className="flex items-center gap-3">
              <img src="/logo.png" alt="Logo UMKM" className="h-11 w-11 object-contain" />
              <span className="text-lg font-bold">UMKM Kab. Bandung</span>
            </div>
            <p className="mt-3 max-w-xs text-sm leading-relaxed text-background/65">
              Portal resmi UMKM Kabupaten Bandung — mendorong pertumbuhan ekonomi lokal yang
              mandiri, inovatif, dan berdaya saing tinggi.
            </p>
          </div>
          <nav>
            <h6 className="mb-3 text-xs font-bold uppercase tracking-widest text-background/50">Navigasi</h6>
            <div className="flex flex-col gap-2 text-sm">
              <Link to="/" className="text-background/70 hover:text-background">Home</Link>
              <a href="/#kategori" className="text-background/70 hover:text-background">Kategori</a>
              <a href="/#umkm" className="text-background/70 hover:text-background">UMKM</a>
              <Link to="/peta" className="text-background/70 hover:text-background">Peta</Link>
            </div>
          </nav>
          <nav>
            <h6 className="mb-3 text-xs font-bold uppercase tracking-widest text-background/50">Layanan</h6>
            <div className="flex flex-col gap-2 text-sm">
              <Link to="/register" className="text-background/70 hover:text-background">Pendaftaran</Link>
              <a href="/#umkm" className="text-background/70 hover:text-background">Data UMKM</a>
              <Link to="/peta" className="text-background/70 hover:text-background">Peta Sebaran</Link>
              {user ? (
                <Link to="/dashboard" className="text-background/70 hover:text-background">Profil Usaha</Link>
              ) : (
                <Link to="/login" className="text-background/70 hover:text-background">Profil Usaha</Link>
              )}
            </div>
          </nav>
          <div>
            <h6 className="mb-3 text-xs font-bold uppercase tracking-widest text-background/50">Kontak</h6>
            <p className="text-sm leading-relaxed text-background/70">
              Dinas Perdagangan dan Perindustrian
              <br />
              Kabupaten Bandung, Jawa Barat
            </p>
            <a href="mailto:info@bandungkab.go.id" className="mt-2 inline-block text-sm text-background/70 hover:text-background">
              info@bandungkab.go.id
            </a>
          </div>
        </div>
        <div className="border-t border-background/10">
          <p className="mx-auto max-w-6xl px-4 py-5 text-center text-xs text-background/55">
            © {year} UMKM Kabupaten Bandung — Dinas Perdagangan &amp; Perindustrian
          </p>
        </div>
      </footer>
    </div>
  );
}
