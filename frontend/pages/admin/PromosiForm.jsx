import { useEffect, useState } from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useAuth } from '../../context/AuthContext';
import { promosiApi, usersApi, apiErrorMessage } from '../../services/api';

export default function PromosiForm({ ownerMode = false }) {
  const { id } = useParams();
  const isEdit = Boolean(id);
  const { user, isAdmin } = useAuth();
  const navigate = useNavigate();
  const [users, setUsers] = useState([]);
  const [form, setForm] = useState({
    username: ownerMode ? user.username : '',
    fasilitasi_promosi: '', fasilitasi_alasan: '',
    hambatan_memasarkan_produk: '', bantuan_dibutuhkan: '',
    berminat_bazar_ramadhan: '', berminat_pelatihan_online: '',
  });
  const [busy, setBusy] = useState(false);

  useEffect(() => {
    if (isAdmin && !ownerMode) usersApi.list().then(setUsers).catch(() => {});
    if (isEdit) {
      promosiApi.byId(id).then((d) => setForm((f) => ({ ...f, ...d, fasilitasi_alasan: '' })));
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [id]);

  function set(key, value) {
    setForm((f) => ({ ...f, [key]: value }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    // Wajib isi alasan bila menjawab "Tidak" pada fasilitasi (validateForm lama).
    if (form.fasilitasi_promosi === 'Tidak' && !form.fasilitasi_alasan.trim()) {
      Swal.fire({ icon: 'error', title: 'Validasi gagal', text: 'Silakan isi alasan fasilitasi promosi pemasaran.' });
      return;
    }
    setBusy(true);
    try {
      const payload = {
        username: form.username,
        // Nilai "Ya" murni; "Tidak" disertai alasan seperti perilaku form lama.
        fasilitasi_promosi:
          form.fasilitasi_promosi === 'Tidak' && form.fasilitasi_alasan
            ? `Tidak - ${form.fasilitasi_alasan}`
            : form.fasilitasi_promosi,
        hambatan_memasarkan_produk: form.hambatan_memasarkan_produk,
        bantuan_dibutuhkan: form.bantuan_dibutuhkan,
        berminat_bazar_ramadhan: form.berminat_bazar_ramadhan,
        berminat_pelatihan_online: form.berminat_pelatihan_online,
      };
      if (isEdit) await promosiApi.update(id, payload);
      else await promosiApi.create(payload);
      await Swal.fire({ icon: 'success', title: isEdit ? 'Data promosi berhasil diperbarui.' : 'Data promosi berhasil disimpan.' });
      navigate(ownerMode ? '/promosi-saya' : '/promosi');
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Gagal menyimpan data promosi', text: apiErrorMessage(err) });
    } finally {
      setBusy(false);
    }
  }

  function radio(name, label) {
    return (
      <div className="mb-3">
        <label className="form-label">{label}</label>
        <div className="d-flex gap-3">
          {['Ya', 'Tidak'].map((v) => (
            <div className="form-check" key={v}>
              <input
                type="radio" className="form-check-input" name={name} value={v}
                checked={form[name] === v} onChange={(e) => set(name, e.target.value)} required
              />
              <label className="form-check-label">{v}</label>
            </div>
          ))}
        </div>
      </div>
    );
  }

  return (
    <div className="card glass-card mx-auto" style={{ maxWidth: 820 }}>
      <div className="card-header d-flex justify-content-between align-items-center">
        <h5 className="mb-0">
          <i className="bi bi-megaphone me-2" />{isEdit ? 'Edit Promosi' : 'Tambah Promosi'}
        </h5>
        <Link className="btn btn-sm btn-ghost" to={ownerMode ? '/promosi-saya' : '/promosi'}>
          <i className="bi bi-arrow-left me-1" /> Kembali
        </Link>
      </div>
      <div className="card-body">
        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label className="form-label">Nama Pemilik (Username)</label>
            {isAdmin && !ownerMode && !isEdit ? (
              <select className="form-select" value={form.username} onChange={(e) => set('username', e.target.value)} required>
                <option value="">Pilih user</option>
                {users.map((u) => <option key={u.username} value={u.username}>{u.username} - {u.fullname}</option>)}
              </select>
            ) : (
              <input className="form-control" value={form.username} readOnly={ownerMode || isEdit} onChange={(e) => set('username', e.target.value)} required />
            )}
          </div>

          {radio('fasilitasi_promosi', '1. Apakah selama setahun terakhir pernah mendapatkan fasilitasi promosi (pameran/bazar) dari Disperindag Kab. Bandung?')}
          {form.fasilitasi_promosi === 'Tidak' && (
            <div className="mb-3">
              <label className="form-label" htmlFor="alasan">Alasan fasilitasi promosi pemasaran:</label>
              <textarea id="alasan" className="form-control" rows={3} value={form.fasilitasi_alasan} onChange={(e) => set('fasilitasi_alasan', e.target.value)} />
            </div>
          )}

          <div className="mb-3">
            <label className="form-label" htmlFor="hambatan">2. Hambatan dalam memasarkan produk (online maupun offline):</label>
            <textarea id="hambatan" className="form-control" rows={3} value={form.hambatan_memasarkan_produk} onChange={(e) => set('hambatan_memasarkan_produk', e.target.value)} required />
          </div>
          <div className="mb-3">
            <label className="form-label" htmlFor="bantuan">3. Bantuan yang dibutuhkan untuk meningkatkan promosi pemasaran produk:</label>
            <textarea id="bantuan" className="form-control" rows={3} value={form.bantuan_dibutuhkan} onChange={(e) => set('bantuan_dibutuhkan', e.target.value)} required />
          </div>
          {radio('berminat_bazar_ramadhan', '4. Apakah berminat mengikuti Bazar Ramadhan?')}
          {radio('berminat_pelatihan_online', '5. Apakah berminat mengikuti pelatihan pemasaran online?')}

          <div className="d-flex flex-wrap gap-2 mt-2">
            <button className="btn btn-success" type="submit" disabled={busy}>
              <i className="bi bi-check-lg me-1" />
              {busy ? 'Menyimpan...' : isEdit ? 'Simpan Perubahan' : 'Tambah'}
            </button>
            <Link className="btn btn-ghost" to={ownerMode ? '/promosi-saya' : '/promosi'}>Batal</Link>
          </div>
        </form>
      </div>
    </div>
  );
}
