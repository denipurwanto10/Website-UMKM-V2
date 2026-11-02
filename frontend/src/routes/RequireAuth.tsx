import { Navigate, Outlet, useLocation } from 'react-router-dom';
import { useAuth } from '../hooks/useAuth';

export function RequireAuth({ roles }: { roles?: ('Admin' | 'Owner')[] }) {
  const { user, ready } = useAuth();
  const loc = useLocation();

  if (!ready) return <p className="p-8 text-center text-sm text-muted-foreground">Memuat…</p>;
  if (!user) return <Navigate to="/login" state={{ from: loc.pathname }} replace />;
  if (roles && !roles.includes(user.usertype)) return <Navigate to="/dashboard" replace />;
  return <Outlet />;
}
