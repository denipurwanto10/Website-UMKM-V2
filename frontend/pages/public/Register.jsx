import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';
import { authApi, apiErrorMessage } from '../../services/api';

export default function Register() {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    username: '', fullname: '', email: '', nomor_hp: '', password: '', confpassword: '',
  });
  const [busy, setBusy] = useState(false);

  function set(key, value) {
    setForm((f) => ({ ...f, [key]: value }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
      Swal.fire({ icon: 'error', title: 'Email tidak valid!', text: 'Format email tidak valid.' });
      return;
    }
    if (form.password !== form.confpassword) {
      Swal.fire({ icon: 'error', title: 'Password Tidak Cocok!', text: 'Password dan Konfirmasi Password tidak cocok.' });
      return;
    }
    setBusy(true);
    try {
      await authApi.register(form);
      await Swal.fire({ icon: 'success', title: 'Registrasi Berhasil!', text: 'Silakan login.' });
      navigate('/login');
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Registrasi Gagal!', text: apiErrorMessage(err, 'Registrasi gagal. Silakan coba lagi.') });
    } finally {
      setBusy(false);
    }
  }

  return (
    <div className="auth-page d-flex align-items-center py-5">
      <div className="container" style={{ maxWidth: 560 }}>
        <div className="card auth-card">
          <div className="card-body p-4 p-md-5">
            <div className="text-center mb-4">
              <img src="/logo.png" alt="logo" width={60} className="rounded mb-2" />
              <h4 className="mb-1 fw-bold">Buat Akun Baru 🚀</h4>
              <p className="opacity-75 mb-0">Daftar sebagai pemilik UMKM</p>
            </div>
            <form onSubmit={handleSubmit}>
              {[
                ['username', 'Username', 'text', 'Masukkan username'],
                ['fullname', 'Full Name', 'text', 'Masukkan nama lengkap'],
                ['email', 'Email', 'email', 'Masukkan email'],
                ['nomor_hp', 'Nomor HP', 'text', 'Masukkan nomor HP'],
              ].map(([key, label, type, ph]) => (
                <div className="mb-3" key={key}>
                  <label className="form-label" htmlFor={key}>{label}</label>
                  <input
                    id={key} type={type} className="form-control" required
                    placeholder={ph} value={form[key]} onChange={(e) => set(key, e.target.value)}
                  />
                </div>
              ))}
              <div className="mb-3">
                <label className="form-label" htmlFor="password">Password</label>
                <input id="password" type="password" className="form-control" required placeholder="••••••••" value={form.password} onChange={(e) => set('password', e.target.value)} />
              </div>
              <div className="mb-3">
                <label className="form-label" htmlFor="confpassword">Konfirmasi Password</label>
                <input id="confpassword" type="password" className="form-control" required placeholder="••••••••" value={form.confpassword} onChange={(e) => set('confpassword', e.target.value)} />
              </div>
              <button className="btn btn-success w-100" type="submit" disabled={busy}>
                {busy ? (
                  <><span className="spinner-border spinner-border-sm me-2" />Memproses...</>
                ) : 'Daftar'}
              </button>
            </form>
            <p className="text-center mt-3 mb-2">
              <span className="opacity-75">Sudah punya akun? </span>
              <Link className="auth-alt" to="/login">Masuk sekarang</Link>
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
