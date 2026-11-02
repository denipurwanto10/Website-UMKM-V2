import { Link } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useFetch } from '../../hooks/useFetch';
import { AdminTable, confirmDelete, statusBadge } from '../../components/AdminTable';
import { useAuth } from '../../context/AuthContext';
import { umkmApi, uploadsUrl, apiErrorMessage } from '../../services/api';

export default function DataUmkm() {
  const { user } = useAuth();
  const { data, loading, error, reload } = useFetch(() => umkmApi.byUser(user.username), [user.username]);
  const rows = Array.isArray(data) ? data : [];
  // Jatah 1 UMKM per owner — tombol tambah disabled bila sudah ada yang menunggu/disetujui.
  const hasActive = rows.some((r) => r.status === 'menunggu' || r.status === 'disetujui');

  async function handleDelete(id) {
    if (!(await confirmDelete())) return;
    try {
      await umkmApi.remove(id);
      await Swal.fire({ icon: 'success', title: 'UMKM berhasil dihapus.' });
      reload();
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Gagal menghapus UMKM', text: apiErrorMessage(err) });
    }
  }

  return (
    <AdminTable
      title="Data UMKM Saya"
      rows={rows} loading={loading} error={error && apiErrorMessage(error)} onRetry={reload}
      columns={[
        { key: 'photo', label: 'Photo', render: (r) => <img src={uploadsUrl('umkm', r.photo)} alt="" style={{ width: 50, height: 50, objectFit: 'cover', borderRadius: '50%' }} /> },
        { key: 'nama_usaha', label: 'Nama Usaha' },
        { key: 'nama_merek_produk', label: 'Merek' },
        { key: 'kategori_produk', label: 'Kategori' },
        { key: 'kecamatan', label: 'Kecamatan' },
        { key: 'desa_kelurahan', label: 'Desa/Kelurahan' },
        { key: 'status', label: 'Status', render: (r) => statusBadge(r.status) },
        { key: 'catatan', label: 'Catatan', render: (r) => r.catatan || '-' },
      ]}
      actions={(row) => (
        <>
          <Link
            className={`btn btn-sm btn-warning ${row.status !== 'disetujui' ? 'disabled' : ''}`}
            to={row.status === 'disetujui' ? `/umkm/${row.id}/edit` : '#'}
            title={row.status === 'disetujui' ? 'Edit' : 'Hanya UMKM yang disetujui yang bisa diedit'}
          >
            <i className="bi bi-pencil me-1 d-none d-sm-inline" />Edit
          </Link>
          <button className="btn btn-sm btn-danger" onClick={() => handleDelete(row.id)}>
            <i className="bi bi-trash me-1 d-none d-sm-inline" />Hapus
          </button>
        </>
      )}
      addButton={
        <Link className={`btn btn-sm btn-success ${hasActive ? 'disabled' : ''}`} to={hasActive ? '#' : '/umkm/tambah'} title={hasActive ? 'Anda sudah memiliki data UMKM aktif' : 'Tambah data UMKM'}>
          <i className="bi bi-plus-lg me-1" />Tambah Data
        </Link>
      }
    />
  );
}
