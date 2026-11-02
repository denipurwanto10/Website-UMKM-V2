import { createContext, useContext, useEffect, useMemo, useState } from 'react';
import { authApi } from '../services/api';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(() => {
    try {
      return JSON.parse(localStorage.getItem('umkm_user') || 'null');
    } catch {
      return null;
    }
  });
  const [ready, setReady] = useState(false);

  // Sinkronkan profil saat aplikasi dimuat bila token masih tersimpan.
  useEffect(() => {
    const token = localStorage.getItem('umkm_token');
    if (!token) {
      setReady(true);
      return;
    }
    authApi
      .profile()
      .then((res) => {
        if (res?.user) {
          setUser(res.user);
          localStorage.setItem('umkm_user', JSON.stringify(res.user));
        }
      })
      .catch(() => {
        localStorage.removeItem('umkm_token');
        localStorage.removeItem('umkm_user');
        setUser(null);
      })
      .finally(() => setReady(true));
  }, []);

  const value = useMemo(
    () => ({
      user,
      ready,
      isAdmin: user?.usertype === 'Admin',
      isOwner: user?.usertype === 'Owner',
      async login(username, password) {
        const res = await authApi.login(username, password);
        localStorage.setItem('umkm_token', res.token);
        localStorage.setItem('umkm_user', JSON.stringify(res.user));
        setUser(res.user);
        return res.user;
      },
      logout() {
        localStorage.removeItem('umkm_token');
        localStorage.removeItem('umkm_user');
        setUser(null);
      },
    }),
    [user, ready]
  );

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth() {
  return useContext(AuthContext);
}
