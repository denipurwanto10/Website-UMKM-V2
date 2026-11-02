import { useEffect, useState } from 'react';
import { Link, Outlet, useLocation, useNavigate, useSearchParams } from 'react-router-dom';
import { LayoutDashboard, Store, Users, Megaphone, Map as MapIcon, LogOut, Menu, X, Home, ChevronDown, User as UserIcon } from 'lucide-react';
import { Button } from '../components/ui/button';
import { ThemeToggle } from '../components/ThemeToggle';
import { Avatar, AvatarFallback, AvatarImage } from '../components/ui/avatar';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '../components/ui/collapsible';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '../components/ui/dropdown-menu';
import { cn } from '../lib/utils';
import { uploadUrl } from '../lib/uploads';
import { useAuth } from '../hooks/useAuth';
import { PageTransition } from '../lib/motion';

function initials(name?: string): string {
  if (!name) return 'U';
  return name.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
}

function pageTitle(path: string): string {
  if (path.startsWith('/usaha/')) return 'Detail usaha';
  const map: Record<string, string> = {
    '/dashboard': 'Dashboard',
    '/umkm': 'Data UMKM',
    '/promosi': 'Promosi & bantuan',
    '/peta': 'Peta sebaran',
    '/profil': 'Profil',
    '/users': 'Pengguna',
  };
  return map[path] ?? '';
}

const subStatuses = [
  { value: 'menunggu', label: 'Menunggu verifikasi' },
  { value: 'disetujui', label: 'Terverifikasi' },
  { value: 'ditolak', label: 'Ditolak' },
] as const;

export function AdminLayout() {
  const { user, logout } = useAuth();
  const loc = useLocation();
  const nav = useNavigate();
  const [open, setOpen] = useState(false);
  const [msmeOpen, setMsmeOpen] = useState(true);
  const [scrolled, setScrolled] = useState(false);
  const [params] = useSearchParams();
  const isAdmin = user?.usertype === 'Admin';
  const statusParam = params.get('status');
  const photo = uploadUrl('users', user?.photo);

  function doLogout() {
    logout();
    nav('/login');
  }

  useEffect(() => setOpen(false), [loc.pathname, loc.search]);
  useEffect(() => {
    const on = () => setScrolled(window.scrollY > 4);
    on();
    window.addEventListener('scroll', on, { passive: true });
    return () => window.removeEventListener('scroll', on);
  }, []);
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

  const itemCls = (active: boolean) =>
    cn(
      'group relative flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm transition-colors duration-200',
      'before:absolute before:left-0 before:top-1/2 before:h-4 before:w-0.5 before:-translate-y-1/2 before:rounded-full before:bg-primary before:opacity-0 before:transition-opacity before:duration-300',
      active
        ? 'bg-accent font-medium text-foreground before:opacity-100'
        : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground',
    );

  const sidebar = (
    <div className="flex h-full flex-col p-4">
      <Link to="/dashboard" className="mb-5 flex h-10 items-center gap-2.5 px-2">
        <img src="/logo.png" alt="Logo UMKM" className="h-8 w-8 rounded-md object-contain" />
        <span className="font-display text-xl">UMKM</span>
      </Link>

      <nav className="flex flex-1 flex-col gap-0.5 overflow-y-auto">
        <Link to="/dashboard" className={itemCls(loc.pathname === '/dashboard')}>
          <LayoutDashboard className="h-4 w-4" /> Dashboard
        </Link>

        <p className="px-3 pb-1.5 pt-5 text-xs text-muted-foreground/80">Data</p>

        {isAdmin ? (
          <>
            <Collapsible open={msmeOpen} onOpenChange={setMsmeOpen}>
              <CollapsibleTrigger className={itemCls(loc.pathname === '/umkm' && !statusParam)}>
                <Store className="h-4 w-4" />
                <span className="flex-1 text-left">Data UMKM</span>
                <ChevronDown className={cn('h-4 w-4 transition-transform duration-300 ease-smooth', msmeOpen && 'rotate-180')} />
              </CollapsibleTrigger>
              <CollapsibleContent className="ms-5 border-s border-border ps-2">
                <div className="flex flex-col gap-0.5 pt-1">
                  {subStatuses.map((s) => (
                    <Link key={s.value} to={`/umkm?status=${s.value}`} className={itemCls(loc.pathname === '/umkm' && statusParam === s.value)}>
                      {s.label}
                    </Link>
                  ))}
                </div>
              </CollapsibleContent>
            </Collapsible>
            <Link to="/promosi" className={itemCls(loc.pathname === '/promosi')}>
              <Megaphone className="h-4 w-4" /> Promosi & bantuan
            </Link>
            <Link to="/users" className={itemCls(loc.pathname === '/users')}>
              <Users className="h-4 w-4" /> Pengguna
            </Link>
          </>
        ) : (
          <>
            <Link to="/umkm" className={itemCls(loc.pathname === '/umkm')}>
              <Store className="h-4 w-4" /> Data UMKM
            </Link>
            <Link to="/promosi" className={itemCls(loc.pathname === '/promosi')}>
              <Megaphone className="h-4 w-4" /> Promosi
            </Link>
            <Link to="/profil" className={itemCls(loc.pathname === '/profil')}>
              <Users className="h-4 w-4" /> Pengguna
            </Link>
          </>
        )}
        <Link to="/peta" className={itemCls(loc.pathname === '/peta')}>
          <MapIcon className="h-4 w-4" /> Peta sebaran
        </Link>
      </nav>

      <div className="mt-4 flex flex-col gap-0.5 border-t border-border pt-4">
        <Link to="/" className={itemCls(false)}>
          <Home className="h-4 w-4" /> Lihat situs
        </Link>
        <button type="button" onClick={doLogout} className={itemCls(false)}>
          <LogOut className="h-4 w-4" /> Keluar
        </button>
        <p className="px-3 pt-3 text-[11px] text-muted-foreground">&copy; {new Date().getFullYear()} UMKM Kabupaten Bandung</p>
      </div>
    </div>
  );

  return (
    <div className="min-h-dvh bg-background text-foreground">
      <aside className="fixed inset-y-0 left-0 z-30 hidden w-64 border-e border-border bg-background md:block">{sidebar}</aside>

      {/* Drawer mobile — selalu ter-mount agar geser buka/tutup halus */}
      <div
        className={cn('fixed inset-0 z-50 md:hidden', open ? 'visible' : 'invisible [transition:visibility_0s_linear_450ms]')}
        aria-hidden={!open}
      >
        <div
          onClick={() => setOpen(false)}
          className={cn('absolute inset-0 bg-black/45 backdrop-blur-[2px] transition-opacity duration-[400ms]', open ? 'opacity-100' : 'opacity-0')}
        />
        <aside
          className={cn(
            'absolute inset-y-0 left-0 w-[18rem] max-w-[86vw] border-e border-border bg-background pt-[env(safe-area-inset-top)] pb-[env(safe-area-inset-bottom)] shadow-2xl transition-transform duration-[450ms] ease-smooth',
            open ? 'translate-x-0' : '-translate-x-full',
          )}
        >
          {sidebar}
        </aside>
      </div>

      <div className="md:ps-64">
        <header
          className={cn(
            'sticky top-0 z-20 flex h-14 items-center gap-2 border-b px-4 backdrop-blur-xl transition-[border-color,background-color] duration-300 md:px-8',
            scrolled ? 'border-border bg-background/85' : 'border-transparent bg-background/50',
          )}
        >
          <Button variant="ghost" size="icon" className="md:hidden" onClick={() => setOpen((v) => !v)} aria-label="Menu" aria-expanded={open}>
            <span key={String(open)} className="icon-swap grid place-items-center">
              {open ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
            </span>
          </Button>
          <p key={loc.pathname} className="page-enter text-sm font-medium">
            {pageTitle(loc.pathname)}
          </p>
          <div className="ms-auto flex items-center gap-1">
            <ThemeToggle />
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <button type="button" className="rounded-full transition-transform duration-200 active:scale-95" aria-label="Menu pengguna">
                  <Avatar className="h-9 w-9 ring-1 ring-border">
                    <AvatarImage src={photo} alt="Foto profil" />
                    <AvatarFallback>{initials(user?.fullname)}</AvatarFallback>
                  </Avatar>
                </button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end" className="w-56">
                <DropdownMenuLabel>
                  <span className="block truncate">{user?.fullname ?? user?.username}</span>
                  <span className="block text-xs font-normal text-muted-foreground">{user?.usertype}</span>
                </DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem onClick={() => nav('/profil')}>
                  <UserIcon className="h-4 w-4" /> Profil saya
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem onClick={doLogout}>
                  <LogOut className="h-4 w-4" /> Keluar
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </header>
        <main className="mx-auto w-full max-w-[1400px] p-4 md:p-8">
          <PageTransition>
            <Outlet />
          </PageTransition>
        </main>
        <p className="px-4 pb-8 text-center text-xs text-muted-foreground md:px-8">
          &copy; {new Date().getFullYear()} Dinas Perdagangan dan Perindustrian Kabupaten Bandung
        </p>
      </div>
    </div>
  );
}
