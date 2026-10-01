import { BrowserRouter, Route, Routes } from 'react-router-dom';
import { AdminLayout } from './layouts/AdminLayout';
import { PublicLayout } from './layouts/PublicLayout';
import { RequireAuth } from './routes/RequireAuth';
import { DashboardPage } from './pages/DashboardPage';
import { HomePage } from './pages/HomePage';
import { LoginPage } from './pages/LoginPage';
import { NotFoundPage } from './pages/NotFoundPage';
import { PetaPage } from './pages/PetaPage';
import { ProfilePage } from './pages/ProfilePage';
import { PromosiPage } from './pages/PromosiPage';
import { RegisterPage } from './pages/RegisterPage';
import { UmkmDetailPage } from './pages/UmkmDetailPage';
import { UmkmPage } from './pages/UmkmPage';
import { UsersPage } from './pages/UsersPage';

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Publik — parity halaman CI3 Auth::all/cari/detail + login/register */}
        <Route element={<PublicLayout />}>
          <Route index element={<HomePage />} />
          <Route path="umkm/:id" element={<UmkmDetailPage />} />
          <Route path="peta" element={<PetaPage />} />
          <Route path="login" element={<LoginPage />} />
          <Route path="register" element={<RegisterPage />} />
          <Route path="*" element={<NotFoundPage />} />
        </Route>

        {/* Area loginwajib */}
        <Route element={<RequireAuth />}>
          <Route element={<AdminLayout />}>
            <Route path="dashboard" element={<DashboardPage />} />
            <Route path="umkm" element={<UmkmPage />} />
            <Route path="usaha/:id" element={<UmkmDetailPage />} />
            <Route path="promosi" element={<PromosiPage />} />
            <Route path="peta" element={<PetaPage />} />
            <Route path="profil" element={<ProfilePage />} />
          </Route>
        </Route>

        {/* Khusus Admin */}
        <Route element={<RequireAuth roles={['Admin']} />}>
          <Route element={<AdminLayout />}>
            <Route path="users" element={<UsersPage />} />
          </Route>
        </Route>

        <Route path="*" element={<NotFoundPage />} />
      </Routes>
    </BrowserRouter>
  );
}
