import { useEffect, useState } from 'react';
import { Link, Outlet, useLocation, useNavigate } from 'react-router-dom';
import { LayoutDashboard, LogOut, Menu, X } from 'lucide-react';
import { Button } from '../components/ui/button';
import { ThemeToggle } from '../components/ThemeToggle';
import { useAuth } from '../hooks/useAuth';
import { PageTransition } from '../lib/motion';
import { cn } from '../lib/utils';

const NAV = [
  { to: '/', label: 'Beranda' },
  { to: '/#kategori', label: 'Kategori' },
  { to: '/#umkm', label: 'UMKM' },
  { to: '/peta', label: 'Peta' },
];

export function PublicLayout() {
  const { user, logout } = useAuth();
  const nav = useNavigate();
  const { pathname, hash } = useLocation();
  const isHome = pathname === '/';
  const year = new Date().getFullYear();
  const [scrolled, setScrolled] = useState(false);
  const [open, setOpen] = useState(false);

  useEffect(() => {
    const on = () => setScrolled(window.scrollY > 8);
    on();
    window.addEventListener('scroll', on, { passive: true });
    return () => window.removeEventListener('scroll', on);
  }, []);

  // Tutup menu saat pindah halaman; kunci scroll body selama menu terbuka.
  useEffect(() => setOpen(false), [pathname, hash]);
  useEffect(() => {
    document.body.style.overflow = open ? 'hidden' : '';
    return () => {
      document.body.style.overflow = '';
    };
  }, [open]);
  useEffect(() => {
    if (!open) return;
    const onKey = (e: KeyboardEvent) => e.key === 'Escape' && setOpen(false);
    window.addEventListener('keydown', onKey);
    return () => window.removeEventListener('keydown', onKey);
  }, [open]);

  const isActive = (to: string) => (to === '/' ? isHome && !hash : to === '/peta' ? pathname === '/peta' : isHome && hash === to.slice(1));

  function doLogout() {
    logout();
    nav('/');
  }

  return (
    <div className="min-h-dvh bg-background text-foreground">
      <header
        className={cn(
          'sticky top-0 z-40 border-b backdrop-blur-xl transition-[background-color,border-color] duration-300',
          scrolled || open ? 'border-border bg-background/85' : 'border-transparent bg-background/40',
        )}
      >
        <div className="mx-auto flex h-16 max-w-6xl items-center gap-2 px-4">
          <Link to="/" className="flex items-center gap-3">
            <img src="/logo.png" alt="Logo UMKM" className="h-9 w-9 object-contain" />
            <span className="text-sm font-semibold leading-tight">
              UMKM
              <span className="block text-xs font-normal text-muted-foreground">Kabupaten Bandung</span>
            </span>
          </Link>

          <nav className="ms-8 hidden items-center gap-0.5 lg:flex">
            {NAV.map((n) => (
              <Link
                key={n.to}
                to={n.to}
                className={cn(
                  'rounded-lg px-3 py-2 text-sm transition-colors duration-200',
                  isActive(n.to) ? 'bg-accent text-foreground' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground',
                )}
              >
                {n.label}
              </Link>
            ))}
          </nav>

          <div className="ms-auto flex items-center gap-1.5">
            <ThemeToggle />
            <div className="hidden items-center gap-1.5 lg:flex">
              {user ? (
                <>
                  <Button variant="ghost" size="sm" onClick={() => nav('/dashboard')}>
                    <LayoutDashboard /> Dashboard
                  </Button>
                  <Button variant="outline" size="sm" onClick={doLogout}>
                    <LogOut /> Keluar
                  </Button>
                </>
              ) : (
                <>
                  <Button variant="ghost" size="sm" onClick={() => nav('/login')}>
                    Masuk
                  </Button>
                  <Button size="sm" onClick={() => nav('/register')}>
                    Daftar
                  </Button>
                </>
              )}
            </div>
            <Button
              variant="ghost"
              size="icon"
              className="lg:hidden"
              onClick={() => setOpen((v) => !v)}
              aria-label={open ? 'Tutup menu' : 'Buka menu'}
              aria-expanded={open}
            >
              <span key={String(open)} className="icon-swap grid place-items-center">
                {open ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
              </span>
            </Button>
          </div>
        </div>
      </header>

      {/* Menu mobile — selalu ter-mount supaya buka/tutup bisa beranimasi */}
      <div
        className={cn(
          'fixed inset-x-0 bottom-0 top-16 z-30 lg:hidden',
          open ? 'visible' : 'invisible [transition:visibility_0s_linear_350ms]',
        )}
        aria-hidden={!open}
      >
        <div
          onClick={() => setOpen(false)}
          className={cn('absolute inset-0 bg-background/70 backdrop-blur-sm transition-opacity duration-300', open ? 'opacity-100' : 'opacity-0')}
        />
        <div
          className={cn(
            'relative border-b border-border bg-background px-4 pb-6 pt-3 shadow-[0_24px_40px_-24px_rgb(0_0_0/0.3)] transition-[transform,opacity] duration-[450ms] ease-smooth',
            open ? 'translate-y-0 opacity-100' : '-translate-y-4 opacity-0',
          )}
        >
          <nav className="flex flex-col">
            {NAV.map((n, i) => (
              <Link
                key={n.to}
                to={n.to}
                tabIndex={open ? 0 : -1}
                style={{ transitionDelay: open ? `${70 + i * 55}ms` : '0ms' }}
                className={cn(
                  'border-b border-border/70 py-4 font-display text-2xl transition-[opacity,transform] duration-500 ease-smooth',
                  open ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0',
                  isActive(n.to) ? 'text-foreground' : 'text-muted-foreground',
                )}
              >
                {n.label}
              </Link>
            ))}
          </nav>
          <div
            style={{ transitionDelay: open ? '330ms' : '0ms' }}
            className={cn(
              'mt-6 flex gap-2 transition-[opacity,transform] duration-500 ease-smooth',
              open ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0',
            )}
          >
            {user ? (
              <>
                <Button className="flex-1" onClick={() => nav('/dashboard')}>
                  <LayoutDashboard /> Dashboard
                </Button>
                <Button className="flex-1" variant="outline" onClick={doLogout}>
                  <LogOut /> Keluar
                </Button>
              </>
            ) : (
              <>
                <Button className="flex-1" variant="outline" onClick={() => nav('/login')}>
                  Masuk
                </Button>
                <Button className="flex-1" onClick={() => nav('/register')}>
                  Daftar
                </Button>
              </>
            )}
          </div>
        </div>
      </div>

      <main className={isHome ? 'w-full' : 'mx-auto w-full max-w-6xl px-4 py-8 sm:py-12'}>
        <PageTransition>
          <Outlet />
        </PageTransition>
      </main>

      <footer className="border-t border-border bg-card/60">
        <div className="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
          <div>
            <div className="flex items-center gap-3">
              <img src="/logo.png" alt="Logo UMKM" className="h-10 w-10 object-contain" />
              <span className="font-display text-xl">UMKM Kab. Bandung</span>
            </div>
            <p className="mt-4 max-w-xs text-sm leading-relaxed text-muted-foreground">
              Data usaha mikro, kecil, dan menengah di Kabupaten Bandung.
            </p>
          </div>
          <FooterCol title="Navigasi">
            <Link to="/">Beranda</Link>
            <Link to="/#kategori">Kategori</Link>
            <Link to="/#umkm">UMKM</Link>
            <Link to="/peta">Peta</Link>
          </FooterCol>
          <FooterCol title="Layanan">
            <Link to="/register">Buat akun</Link>
            <Link to="/#umkm">Daftar UMKM</Link>
            <Link to="/peta">Peta</Link>
            <Link to={user ? '/dashboard' : '/login'}>Usaha saya</Link>
          </FooterCol>
          <div>
            <h6 className="mb-4 text-sm font-medium">Kontak</h6>
            <p className="text-sm leading-relaxed text-muted-foreground">
              Dinas Perdagangan dan Perindustrian
              <br />
              Kabupaten Bandung, Jawa Barat
            </p>
            <a href="mailto:info@bandungkab.go.id" className="mt-3 inline-block text-sm text-muted-foreground transition-colors hover:text-foreground">
              info@bandungkab.go.id
            </a>
          </div>
        </div>
        <div className="border-t border-border">
          <p className="mx-auto max-w-6xl px-4 py-5 text-xs text-muted-foreground">
            © {year} Dinas Perdagangan dan Perindustrian Kabupaten Bandung
          </p>
        </div>
      </footer>
    </div>
  );
}

function FooterCol({ title, children }: { title: string; children: React.ReactNode }) {
  return (
    <nav>
      <h6 className="mb-4 text-sm font-medium">{title}</h6>
      <div className="flex flex-col gap-2.5 text-sm text-muted-foreground [&_a]:w-fit [&_a]:transition-colors [&_a:hover]:text-foreground">
        {children}
      </div>
    </nav>
  );
}
