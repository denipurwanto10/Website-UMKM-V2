import { useEffect, useMemo, useState } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useAuth } from '../../context/AuthContext';
import { umkmApi, usersApi, uploadsUrl, apiErrorMessage } from '../../services/api';
import kecamatanList from '../../data/kecamatanList.json';
import desaByKecamatan from '../../data/desaByKecamatan.json';

const PENDAPATAN = {
  Mikro: 'Rp 2.000.000.000',
  Kecil: 'Rp 2.000.000.000 - Rp 15.000.000.000',
  Menengah: 'Rp 15.000.000.000 - Rp 50.000.000.000',
};

const PLATFORMS = [
  ['whatsapp', 'WhatsApp', 'https://wa.me/'],
  ['blibli', 'Blibli', 'https://www.blibli.com/user/'],
  ['lazada', 'Lazada', 'https://www.lazada.co.id/shop/'],
  ['shopee', 'Shopee', 'https://shopee.co.id/'],
  ['tokopedia', 'Tokopedia', 'https://www.tokopedia.com/'],
  ['facebook', 'Facebook', 'https://www.facebook.com/'],
  ['instagram', 'Instagram', 'https://www.instagram.com/'],
  ['tiktok', 'TikTok', 'https://www.tiktok.com/@'],
  ['twitter', 'Twitter', 'https://www.x.com/'],
];

function withPrefix(value, prefix) {
  const v = (value || '').trim();
  if (!v) return '';
  return /^https?:\/\//i.test(v) ? v : prefix + v;
}

const EMPTY = {
  username: '', nama_usaha: '', nama_merek_produk: '', kategori_produk: '',
  jalan: '', desa_kelurahan: '', kecamatan: '', jenis_usaha: '', pendapatan: '',
  nib: '', pirt: '', bpom: '', halal: '', haki: '', lainnya: '',
  online: false, offline: false, agen_reseller: false, deskripsi_produk: '',
  status: 'menunggu', catatan: '-',
  whatsapp: '', blibli: '', lazada: '', shopee: '', tokopedia: '',
  facebook: '', instagram: '', tiktok: '', twitter: '',
};

export default function UmkmForm() {
  const { id } = useParams();
  const isEdit = Boolean(id);
  const { user, isAdmin } = useAuth();
  const navigate = useNavigate();
  const [form, setForm] = useState(EMPTY);
  const [users, setUsers] = useState([]);
  const [photoFile, setPhotoFile] = useState(null);
  const [busy, setBusy] = useState(false);

  useEffect(() => {
    if (isAdmin) usersApi.list().then(setUsers).catch(() => {});
    else setForm((f) => ({ ...f, username: user.username }));
    if (isEdit) {
      umkmApi.byId(id).then((d) => {
        setForm({
          ...EMPTY, ...d,
          online: d.online === 'online' || d.online === true,
          offline: d.offline === 'offline' || d.offline === true,
          agen_reseller: d.agen_reseller === 'agen_reseller' || d.agen_reseller === true,
        });
      });
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [id]);

  const desaOptions = useMemo(
    () => (form.kecamatan ? desaByKecamatan[form.kecamatan] || [] : []),
    [form.kecamatan]
  );

  function set(key, value) {
    setForm((f) => {
      const next = { ...f, [key]: value };
      // Pendapatan otomatis mengikuti jenis usaha (seperti updatePendapatan() lama).
      if (key === 'jenis_usaha') next.pendapatan = PENDAPATAN[value] || '';
      // Ganti kecamatan → reset desa bila tidak termasuk.
      if (key === 'kecamatan' && value && !(desaByKecamatan[value] || []).includes(f.desa_kelurahan)) {
        next.desa_kelurahan = '';
      }
      return next;
    });
  }

  async function handleSubmit(e) {
    e.preventDefault();
    const required = ['username', 'nama_usaha', 'nama_merek_produk', 'kategori_produk', 'jalan', 'desa_kelurahan', 'kecamatan', 'jenis_usaha', 'pendapatan'];
    for (const k of required) {
      if (!form[k]) {
        Swal.fire({ icon: 'error', title: 'Form belum lengkap', text: `Harap isi ${k}.` });
        return;
      }
    }
    setBusy(true);
    try {
      const fd = new FormData();
      Object.entries(form).forEach(([k, v]) => {
        if (['online', 'offline', 'agen_reseller'].includes(k)) {
          if (v) fd.append(k, k); // nilai string sesuai kolom DB lama
        } else if (PLATFORMS.some(([pk]) => pk === k)) {
          const prefix = PLATFORMS.find(([pk]) => pk === k)[2];
          fd.append(k, withPrefix(k === 'whatsapp' ? normalizeWa(v) : v, prefix));
        } else {
          fd.append(k, v ?? '');
        }
      });
      if (photoFile) fd.append('photo', photoFile);

      const payload = photoFile ? fd : Object.fromEntries(fd.entries());
      if (isEdit) await umkmApi.update(id, payload);
      else await umkmApi.create(payload);
      await Swal.fire({ icon: 'success', title: isEdit ? 'UMKM berhasil diperbarui.' : 'UMKM berhasil ditambahkan.' });
      navigate(isAdmin ? '/menunggu' : '/data-umkm');
    } catch (err) {
      Swal.fire({ icon: 'error', title: isEdit ? 'Gagal memperbarui UMKM' : 'Gagal menambahkan UMKM', text: apiErrorMessage(err) });
    } finally {
      setBusy(false);
    }
  }

  function normalizeWa(v) {
    const digits = (v || '').trim();
    if (/^0/.test(digits)) return digits.replace(/^0/, '62');
    return digits;
  }

  return (
    <div className="card glass-card mx-auto" style={{ maxWidth: 960 }}>
      <div className="card-header d-flex justify-content-between align-items-center">
        <h5 className="mb-0">
          <i className="bi bi-shop me-2" />{isEdit ? 'Edit UMKM' : 'Tambah UMKM'}
        </h5>
        <Link className="btn btn-sm btn-ghost" to={isAdmin ? '/menunggu' : '/data-umkm'}>
          <i className="bi bi-arrow-left me-1" /> Kembali
        </Link>
      </div>
      <div className="card-body">
        <form onSubmit={handleSubmit}>
          <h6 className="text-uppercase small opacity-75 mt-1">Data Usaha</h6>
          <div className="row g-3">
            <div className="col-md-6">
              <label className="form-label">Username</label>
              {isAdmin && !isEdit ? (
                <select className="form-select" value={form.username} onChange={(e) => set('username', e.target.value)} required>
                  <option value="">Pilih user</option>
                  {users.map((u) => <option key={u.username} value={u.username}>{u.username} — {u.fullname}</option>)}
                </select>
              ) : (
                <input className="form-control" value={form.username} readOnly={isEdit || !isAdmin} onChange={(e) => set('username', e.target.value)} required />
              )}
            </div>
            <div className="col-md-6">
              <label className="form-label">Nama Usaha</label>
              <input className="form-control" value={form.nama_usaha} onChange={(e) => set('nama_usaha', e.target.value)} required />
            </div>
            <div className="col-md-6">
              <label className="form-label">Nama Merek Produk</label>
              <input className="form-control" value={form.nama_merek_produk} onChange={(e) => set('nama_merek_produk', e.target.value)} required />
            </div>
            <div className="col-md-6">
              <label className="form-label">Kategori Produk</label>
              <select className="form-select" value={form.kategori_produk} onChange={(e) => set('kategori_produk', e.target.value)} required>
                <option value="">Pilih Kategori</option>
                <option value="Kuliner">Kuliner</option>
                <option value="Kerajinan">Kerajinan</option>
                <option value="Fashion">Fashion</option>
              </select>
            </div>
            <div className="col-md-6">
              <label className="form-label">Jalan</label>
              <input className="form-control" value={form.jalan} onChange={(e) => set('jalan', e.target.value)} required />
            </div>
            <div className="col-md-3">
              <label className="form-label">Kecamatan</label>
              <select className="form-select" value={form.kecamatan} onChange={(e) => set('kecamatan', e.target.value)} required>
                <option value="">Pilih Kecamatan</option>
                {kecamatanList.map((k) => <option key={k} value={k}>{k}</option>)}
              </select>
            </div>
            <div className="col-md-3">
              <label className="form-label">Desa/Kelurahan</label>
              <select className="form-select" value={form.desa_kelurahan} onChange={(e) => set('desa_kelurahan', e.target.value)} required>
                <option value="">Pilih Desa</option>
                {desaOptions.map((d) => <option key={d} value={d}>{d}</option>)}
              </select>
            </div>
            <div className="col-md-6">
              <label className="form-label">Jenis Usaha</label>
              <select className="form-select" value={form.jenis_usaha} onChange={(e) => set('jenis_usaha', e.target.value)} required>
                <option value="">-- Pilih Jenis Usaha --</option>
                <option value="Mikro">Mikro</option>
                <option value="Kecil">Kecil</option>
                <option value="Menengah">Menengah</option>
              </select>
            </div>
            <div className="col-md-6">
              <label className="form-label">Pendapatan per Tahun (Rp)</label>
              <input className="form-control" value={form.pendapatan} readOnly required />
            </div>
            {['nib', 'pirt', 'bpom', 'halal', 'haki', 'lainnya'].map((k) => (
              <div className="col-md-4" key={k}>
                <label className="form-label text-uppercase">{k}</label>
                <input className="form-control" value={form[k] || ''} onChange={(e) => set(k, e.target.value)} />
              </div>
            ))}
            <div className="col-12">
              <label className="form-label">Deskripsi Produk</label>
              <textarea className="form-control" rows={3} value={form.deskripsi_produk || ''} onChange={(e) => set('deskripsi_produk', e.target.value)} placeholder="Ceritakan produk unggulan usaha ini..." />
            </div>
            <div className="col-12">
              <h6 className="text-uppercase small opacity-75 mt-2 mb-2">Saluran Penjualan</h6>
              <div className="d-flex gap-3 flex-wrap">
              {[
                ['online', 'Online'], ['offline', 'Offline'], ['agen_reseller', 'Agen / Reseller'],
              ].map(([k, label]) => (
                <div className="form-check" key={k}>
                  <input id={k} type="checkbox" className="form-check-input" checked={!!form[k]} onChange={(e) => set(k, e.target.checked)} />
                  <label className="form-check-label" htmlFor={k}>{label}</label>
                </div>
              ))}
              </div>
            </div>
            <div className="col-12">
              <h6 className="text-uppercase small opacity-75 mt-2 mb-2">Tautan Pemasaran</h6>
            </div>
            {PLATFORMS.map(([key, label]) => (
              <div className="col-md-4" key={key}>
                <label className="form-label">{label}</label>
                <input className="form-control" value={form[key] || ''} onChange={(e) => set(key, e.target.value)} placeholder={`Masukkan link ${label}`} />
              </div>
            ))}
            {isAdmin && isEdit && (
              <>
                <div className="col-md-6">
                  <label className="form-label">Status</label>
                  <select className="form-select" value={form.status} onChange={(e) => set('status', e.target.value)} required>
                    <option value="menunggu">menunggu</option>
                    <option value="disetujui">disetujui</option>
                    <option value="ditolak">ditolak</option>
                  </select>
                </div>
                <div className="col-md-6">
                  <label className="form-label">Catatan</label>
                  <input className="form-control" value={form.catatan || ''} onChange={(e) => set('catatan', e.target.value)} />
                </div>
              </>
            )}
            <div className="col-md-6">
              <label className="form-label">Foto (JPG/PNG/GIF ≤ 2MB)</label>
              <input
                type="file" className="form-control" accept="image/jpeg,image/png,image/gif"
                onChange={(e) => {
                  const f = e.target.files?.[0];
                  if (!f) return setPhotoFile(null);
                  if (!['image/jpeg', 'image/png', 'image/gif'].includes(f.type)) {
                    Swal.fire({ icon: 'error', title: 'Hanya gambar (jpg, jpeg, png, gif) yang diperbolehkan.' });
                    e.target.value = '';
                    return;
                  }
                  if (f.size > 2 * 1024 * 1024) {
                    Swal.fire({ icon: 'error', title: 'Ukuran file tidak boleh melebihi 2MB.' });
                    e.target.value = '';
                    return;
                  }
                  setPhotoFile(f);
                }}
              />
              {isEdit && form.photo && (
                <img src={uploadsUrl('umkm', form.photo)} alt="foto saat ini" className="mt-2" style={{ width: 100, height: 100, objectFit: 'cover' }} />
              )}
            </div>
          </div>
          <div className="d-flex flex-wrap gap-2 mt-4">
            <button className="btn btn-success" type="submit" disabled={busy}>
              <i className="bi bi-check-lg me-1" />
              {busy ? 'Menyimpan...' : isEdit ? 'Simpan Perubahan' : 'Tambah'}
            </button>
            <Link className="btn btn-ghost" to={isAdmin ? '/menunggu' : '/data-umkm'}>Batal</Link>
          </div>
        </form>
      </div>
    </div>
  );
}
