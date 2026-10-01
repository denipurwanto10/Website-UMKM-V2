import { useState } from 'react';
import { Link, Outlet, useLocation, useNavigate, useSearchParams } from 'react-router-dom';
import {
  LayoutDashboard,
  Store,
  Users,
  Megaphone,
  LogOut,
  Menu,
  X,
  Home,
  ChevronDown,
  User as UserIcon,
} from 'lucide-react';
import { Button } from '../components/ui/button';
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

function initials(name?: string): string {
  if (!name) return 'U';
  return name
    .split(' ')
    .map((w) => w[0])
    .slice(0, 2)
    .join('')
    .toUpperCase();
}

export function AdminLayout() {
  const { user, logout } = useAuth();
  const loc = useLocation();
  const nav = useNavigate();
  const [open, setOpen] = useState(false);
  const [msmeOpen, setMsmeOpen] = useState(true);
  const [params] = useSearchParams();
  const isAdmin = user?.usertype === 'Admin';
  const statusParam = params.get('status');
  const photo = uploadUrl('users', user?.photo);

  function doLogout() {
    logout();
    nav('/login');
  }

  const itemCls = (active: boolean) =>
    cn(
      'flex items-center gap-3 rounded-md px-3 py-2 text-sm transition-colors hover:bg-accent hover:text-accent-foreground',
      active ? 'bg-accent font-medium text-accent-foreground' : 'text-muted-foreground',
    );

  const subStatuses = [
    { value: 'menunggu', label: 'List UMKM Menunggu' },
    { value: 'disetujui', label: 'List UMKM Disetujui' },
    { value: 'ditolak', label: 'List UMKM Ditolak' },
  ] as const;

  const sidebar = (
    <div className="flex h-full flex-col p-4">
      {/* Brand — parity sidebar.php app-brand */}
      <Link to="/dashboard" onClick={() => setOpen(false)} className="mb-4 flex items-center gap-2 px-2">
        <img src="/logo.png" alt="Logo UMKM" className="h-10 w-10 rounded-md object-contain" />
        <span className="text-lg font-bold tracking-tight">UMKM</span>
      </Link>

      <nav className="flex flex-col gap-1">
        <Link to="/dashboard" onClick={() => setOpen(false)} className={itemCls(loc.pathname === '/dashboard')}>
          <LayoutDashboard className="h-4 w-4" /> Dashboard
        </Link>

        <p className="px-3 pb-1 pt-4 text-[11px] font-semibold uppercase tracking-wider text-muted-foreground">
          Menu
        </p>

        {isAdmin ? (
          <>
            <Collapsible open={msmeOpen} onOpenChange={setMsmeOpen}>
              <CollapsibleTrigger className={cn(itemCls(loc.pathname === '/umkm'), 'w-full')}>
                <Store className="h-4 w-4" />
                <span className="flex-1 text-left">MSME Data</span>
                <ChevronDown className={cn('h-4 w-4 transition-transform', msmeOpen && 'rotate-180')} />
              </CollapsibleTrigger>
              <CollapsibleContent className="ms-4 flex flex-col gap-1 border-s border-border ps-2 pt-1">
                {subStatuses.map((s) => (
                  <Link
                    key={s.value}
                    to={`/umkm?status=${s.value}`}
                    onClick={() => setOpen(false)}
                    className={itemCls(loc.pathname === '/umkm' && statusParam === s.value)}
                  >
                    {s.label}
                  </Link>
                ))}
              </CollapsibleContent>
            </Collapsible>

            <Link to="/promosi" onClick={() => setOpen(false)} className={itemCls(loc.pathname === '/promosi')}>
              <Megaphone className="h-4 w-4" /> Promotion
            </Link>
            <Link to="/users" onClick={() => setOpen(false)} className={itemCls(loc.pathname === '/users')}>
              <Users className="h-4 w-4" /> Users
            </Link>
          </>
        ) : (
          <>
            <Link to="/umkm" onClick={() => setOpen(false)} className={itemCls(loc.pathname === '/umkm')}>
              <Store className="h-4 w-4" /> Data UMKM
            </Link>
            <Link to="/promosi" onClick={() => setOpen(false)} className={itemCls(loc.pathname === '/promosi')}>
              <Megaphone className="h-4 w-4" /> Promosi
            </Link>
            <Link to="/profil" onClick={() => setOpen(false)} className={itemCls(loc.pathname === '/profil')}>
              <Users className="h-4 w-4" /> Pengguna
            </Link>
          </>
        )}
      </nav>

      {/* Bawah — parity menu-logout sidebar.php */}
      <div className="mt-auto flex flex-col gap-1 border-t border-border pt-4">
        <Link to="/" className={itemCls(false)}>
          <Home className="h-4 w-4" /> Halaman Publik
        </Link>
        <button type="button" onClick={doLogout} className={itemCls(false)}>
          <LogOut className="h-4 w-4" /> Logout
        </button>
        <p className="px-3 pt-2 text-[11px] text-muted-foreground">
          &copy; {new Date().getFullYear()} UMKM Kabupaten Bandung
        </p>
      </div>
    </div>
  );

  return (
    <div className="min-h-screen bg-background text-foreground">
      {/* Desktop sidebar */}
      <aside className="fixed inset-y-0 left-0 hidden w-60 border-e border-border md:block">
        {sidebar}
      </aside>
      {/* Mobile drawer */}
      {open && (
        <div className="fixed inset-0 z-50 md:hidden">
          <div className="absolute inset-0 bg-black/60" onClick={() => setOpen(false)} />
          <aside className="absolute inset-y-0 left-0 w-64 bg-background">{sidebar}</aside>
        </div>
      )}
      <div className="md:ps-60">
        {/* Navbar — parity sidebar.php navbar: hamburger + avatar dropdown */}
        <header className="sticky top-0 z-40 flex h-14 items-center gap-2 border-b border-border bg-background/95 px-4 backdrop-blur">
          <Button variant="ghost" size="icon" className="md:hidden" onClick={() => setOpen(!open)} aria-label="Menu">
            {open ? <X className="h-5 w-5" /> : <Menu className="h-5 w-5" />}
          </Button>
          <div className="ms-auto">
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <button
                  type="button"
                  className="rounded-full outline-none focus-visible:ring-1 focus-visible:ring-ring"
                  aria-label="Menu pengguna"
                >
                  <Avatar className="h-9 w-9">
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
                  <UserIcon className="h-4 w-4" /> My Profile
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem onClick={doLogout}>
                  <LogOut className="h-4 w-4" /> Log Out
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </header>
        <main className="p-4 md:p-6">
          <Outlet />
        </main>
        <p className="px-4 pb-6 text-center text-xs text-muted-foreground md:px-6">
          &copy; {new Date().getFullYear()} UMKM Kabupaten Bandung &mdash; Dinas Perdagangan &amp; Perindustrian
        </p>
      </div>
    </div>
  );
}
