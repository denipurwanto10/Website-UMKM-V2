import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useAuth } from '../../context/AuthContext';
import { apiErrorMessage } from '../../services/api';

export default function Login() {
  const { login } = useAuth();
  const navigate = useNavigate();
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [busy, setBusy] = useState(false);

  async function handleSubmit(e) {
    e.preventDefault();
    if (!username || !password) {
      Swal.fire({ icon: 'error', title: 'Form Error', text: 'Harap isi Username dan Password.' });
      return;
    }
    setBusy(true);
    try {
      const user = await login(username, password);
      await Swal.fire({ icon: 'success', title: 'Login Berhasil', text: 'Selamat datang!' });
      navigate(user?.usertype === 'Admin' || user?.usertype === 'Owner' ? '/dashboard' : '/');
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Login Gagal', text: apiErrorMessage(err, 'Login gagal. Silakan coba lagi.') });
    } finally {
      setBusy(false);
    }
  }

  return (
    <div className="auth-page d-flex align-items-center py-5">
      <div className="container" style={{ maxWidth: 460 }}>
        <div className="card auth-card">
          <div className="card-body p-4 p-md-5">
            <div className="text-center mb-4">
              <img src="/logo.png" alt="logo" width={60} className="rounded mb-2" />
              <h4 className="mb-1 fw-bold">Selamat Datang! 👋</h4>
              <p className="opacity-75 mb-0">Masuk ke Portal UMKM Kab. Bandung</p>
            </div>
            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label className="form-label" htmlFor="username">Username</label>
                <input
                  id="username" className="form-control" autoFocus
                  placeholder="Enter your username"
                  value={username} onChange={(e) => setUsername(e.target.value)}
                />
              </div>
              <div className="mb-3">
                <label className="form-label" htmlFor="password">Password</label>
                <input
                  id="password" type="password" className="form-control"
                  placeholder="••••••••"
                  value={password} onChange={(e) => setPassword(e.target.value)}
                />
              </div>
              <button className="btn btn-success w-100" type="submit" disabled={busy}>
                {busy ? (
                  <><span className="spinner-border spinner-border-sm me-2" />Memproses...</>
                ) : 'Masuk'}
              </button>
            </form>
            <p className="text-center mt-3 mb-2">
              <span className="opacity-75">Tidak punya akun? </span>
              <Link className="auth-alt" to="/register">Buat akun</Link>
            </p>
            <div className="text-center">
              <Link className="btn btn-sm btn-ghost" to="/">
                <i className="bi bi-arrow-left me-1" />Kembali ke beranda
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
