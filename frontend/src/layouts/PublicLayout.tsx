import { Link, Outlet, useNavigate } from 'react-router-dom';
import { Store, LayoutDashboard, LogOut, Map as MapIcon, User as UserIcon } from 'lucide-react';
import { Button } from '../components/ui/button';
import { useAuth } from '../hooks/useAuth';

export function PublicLayout() {
  const { user, logout } = useAuth();
  const nav = useNavigate();

  return (
    <div className="min-h-screen bg-background text-foreground">
      <header className="sticky top-0 z-40 border-b border-border bg-background/95 backdrop-blur">
        <div className="mx-auto flex h-14 max-w-6xl items-center gap-4 px-4">
          <Link to="/" className="flex items-center gap-2 font-semibold">
            <Store className="h-5 w-5" />
            UMKM
          </Link>
          <Link to="/peta" className="hidden items-center gap-1.5 text-sm text-muted-foreground hover:text-foreground sm:flex">
            <MapIcon className="h-4 w-4" /> Peta
          </Link>
          <nav className="ms-auto flex items-center gap-2">
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
      <main className="mx-auto max-w-6xl px-4 py-8">
        <Outlet />
      </main>
      <footer className="border-t border-border py-6 text-center text-sm text-muted-foreground">
        Sistem Informasi UMKM — migrasi CI3 → React + Node.js
      </footer>
    </div>
  );
}
