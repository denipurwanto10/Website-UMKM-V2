import { useEffect, useState } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import Swal from 'sweetalert2';
import { usersApi, uploadsUrl, apiErrorMessage } from '../../services/api';

export default function UserForm() {
  const { username } = useParams();
  const isEdit = Boolean(username);
  const navigate = useNavigate();
  const [form, setForm] = useState({
    username: '', fullname: '', usertype: 'Owner', nomor_hp: '', email: '',
    password: '', confpassword: '', photo: 'default.png',
  });
  const [photoFile, setPhotoFile] = useState(null);
  const [busy, setBusy] = useState(false);

  useEffect(() => {
    if (isEdit) {
      usersApi.byUsername(username).then((d) =>
        setForm({ ...d, password: '', confpassword: '' })
      );
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [username]);

  function set(key, value) {
    setForm((f) => ({ ...f, [key]: value }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    if (!/^\d+$/.test(form.nomor_hp)) {
      Swal.fire({ icon: 'error', title: 'Validasi gagal', text: 'Nomor HP hanya boleh berisi angka.' });
      return;
    }
    if (!isEdit || form.password) {
      if (form.password !== form.confpassword) {
        Swal.fire({ icon: 'error', title: 'Password dan Konfirmasi Password tidak cocok.' });
        return;
      }
      if ((form.password || '').length < 8) {
        Swal.fire({ icon: 'error', title: 'Validasi gagal', text: 'Password minimal 8 karakter.' });
        return;
      }
    }
    setBusy(true);
    try {
      const fd = new FormData();
      ['username', 'fullname', 'usertype', 'nomor_hp', 'email'].forEach((k) => fd.append(k, form[k] ?? ''));
      if (form.password) {
        fd.append('password', form.password);
        fd.append('confpassword', form.confpassword);
      }
      if (!isEdit) {
        fd.append('password', form.password);
        fd.append('confpassword', form.confpassword);
      }
      if (photoFile) fd.append('photo', photoFile);
      const payload = photoFile ? fd : Object.fromEntries(fd.entries());
      if (isEdit) await usersApi.update(username, payload);
      else await usersApi.create(payload);
      await Swal.fire({ icon: 'success', title: isEdit ? 'Pengguna berhasil diperbarui.' : 'User berhasil ditambahkan!' });
      navigate('/users');
    } catch (err) {
      Swal.fire({ icon: 'error', title: isEdit ? 'Gagal memperbarui pengguna' : 'Gagal menambahkan user', text: apiErrorMessage(err) });
    } finally {
      setBusy(false);
    }
  }

  return (
    <div className="card glass-card mx-auto" style={{ maxWidth: 760 }}>
      <div className="card-header d-flex justify-content-between align-items-center">
        <h5 className="mb-0">
          <i className="bi bi-person me-2" />{isEdit ? 'Edit Pengguna' : 'Tambah Pengguna'}
        </h5>
        <Link className="btn btn-sm btn-ghost" to="/users">
          <i className="bi bi-arrow-left me-1" /> Kembali
        </Link>
      </div>
      <div className="card-body">
        <form onSubmit={handleSubmit}>
          <div className="row g-3">
            {!isEdit && (
              <div className="col-md-6">
                <label className="form-label">Username</label>
                <input className="form-control" value={form.username} onChange={(e) => set('username', e.target.value)} required />
              </div>
            )}
            <div className="col-md-6">
              <label className="form-label">Nama Lengkap</label>
              <input className="form-control" value={form.fullname || ''} onChange={(e) => set('fullname', e.target.value)} required />
            </div>
            <div className="col-md-6">
              <label className="form-label">Jenis Pengguna</label>
              <select className="form-select" value={form.usertype} onChange={(e) => set('usertype', e.target.value)} required>
                <option value="Admin">Admin</option>
                <option value="Owner">Owner</option>
              </select>
            </div>
            <div className="col-md-6">
              <label className="form-label">Nomor HP</label>
              <input className="form-control" value={form.nomor_hp || ''} onChange={(e) => set('nomor_hp', e.target.value)} required />
            </div>
            <div className="col-md-6">
              <label className="form-label">Email</label>
              <input type="email" className="form-control" value={form.email || ''} onChange={(e) => set('email', e.target.value)} required />
            </div>
            <div className="col-md-6">
              <label className="form-label">Password {isEdit && '(kosongkan bila tidak diubah)'}</label>
              <input type="password" className="form-control" value={form.password} onChange={(e) => set('password', e.target.value)} required={!isEdit} placeholder="••••••••" />
            </div>
            <div className="col-md-6">
              <label className="form-label">Konfirmasi Password</label>
              <input type="password" className="form-control" value={form.confpassword} onChange={(e) => set('confpassword', e.target.value)} required={!isEdit} placeholder="••••••••" />
            </div>
            {isEdit && (
              <div className="col-md-6">
                <label className="form-label">Foto (JPG/PNG/GIF ≤ 2MB)</label>
                <input
                  type="file" className="form-control" accept="image/jpeg,image/png,image/gif"
                  onChange={(e) => {
                    const f = e.target.files?.[0];
                    if (!f) return setPhotoFile(null);
                    if (!['image/jpeg', 'image/png', 'image/gif'].includes(f.type) || f.size > 2 * 1024 * 1024) {
                      Swal.fire({ icon: 'error', title: 'File harus gambar JPG/PNG/GIF maksimal 2MB.' });
                      e.target.value = '';
                      return;
                    }
                    setPhotoFile(f);
                  }}
                />
                {form.photo && (
                  <img src={uploadsUrl('users', form.photo)} alt="foto saat ini" className="mt-2" style={{ width: 100, height: 100, objectFit: 'cover' }} />
                )}
              </div>
            )}
          </div>
          <div className="d-flex flex-wrap gap-2 mt-4">
            <button className="btn btn-success" type="submit" disabled={busy}>
              <i className="bi bi-check-lg me-1" />
              {busy ? 'Menyimpan...' : isEdit ? 'Simpan Perubahan' : 'Tambah'}
            </button>
            <Link className="btn btn-ghost" to="/users">Batal</Link>
          </div>
        </form>
      </div>
    </div>
  );
}
