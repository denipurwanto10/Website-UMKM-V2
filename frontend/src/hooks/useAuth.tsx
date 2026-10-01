import { createContext, useContext, useEffect, useMemo, useState } from 'react';
import type { ReactNode } from 'react';
import * as authService from '../services/auth.service';
import type { User } from '../types';

interface AuthCtx {
  user: User | null;
  token: string | null;
  ready: boolean;
  login: (u: string, p: string) => Promise<void>;
  logout: () => void;
}

const Ctx = createContext<AuthCtx | null>(null);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(() => {
    const raw = localStorage.getItem('user');
    return raw ? (JSON.parse(raw) as User) : null;
  });
  const [token, setToken] = useState<string | null>(() => localStorage.getItem('token'));
  const [ready, setReady] = useState(false);

  // Validasi token masih hidup saat app mount (backend yang jadi otoritas)
  useEffect(() => {
    if (!token) {
      setReady(true);
      return;
    }
    authService
      .me()
      .then((u) => setUser(u))
      .catch(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        setToken(null);
        setUser(null);
      })
      .finally(() => setReady(true));
  }, [token]);

  const value = useMemo<AuthCtx>(
    () => ({
      user,
      token,
      ready,
      login: async (u, p) => {
        const data = await authService.login(u, p);
        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        setToken(data.token);
        setUser(data.user);
      },
      logout: () => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        setToken(null);
        setUser(null);
      },
    }),
    [user, token, ready],
  );

  return <Ctx.Provider value={value}>{children}</Ctx.Provider>;
}

export function useAuth(): AuthCtx {
  const ctx = useContext(Ctx);
  if (!ctx) throw new Error('useAuth harus dipakai di dalam AuthProvider');
  return ctx;
}
