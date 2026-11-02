import { Link } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useFetch } from '../../hooks/useFetch';
import { AdminTable, confirmDelete } from '../../components/AdminTable';
import { useAuth } from '../../context/AuthContext';
import { promosiApi, apiErrorMessage } from '../../services/api';

const COLUMNS = [
  { key: 'username', label: 'Username', render: (r) => `${r.username}${r.fullname ? ` (${r.fullname})` : ''}` },
  { key: 'fasilitasi_promosi', label: 'Fasilitasi Promosi' },
  { key: 'hambatan_memasarkan_produk', label: 'Hambatan' },
  { key: 'bantuan_dibutuhkan', label: 'Bantuan Dibutuhkan' },
  { key: 'berminat_bazar_ramadhan', label: 'Berminat Bazar Ramadhan' },
  { key: 'berminat_pelatihan_online', label: 'Berminat Pelatihan Online' },
];

function PromosiTable({ fetchAll, addTo, editBase, ownerOnly }) {
  const { user } = useAuth();
  const { data, loading, error, reload } = useFetch(fetchAll, [user.username]);

  async function handleDelete(id) {
    if (!(await confirmDelete())) return;
    try {
      await promosiApi.remove(id);
      await Swal.fire({ icon: 'success', title: 'Data promosi berhasil dihapus.' });
      reload();
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Gagal menghapus data promosi', text: apiErrorMessage(err) });
    }
  }

  const rows = Array.isArray(data) ? data : [];
  // Owner dibatasi 1 promosi — tombol tambah disabled bila sudah ada.
  const disableAdd = ownerOnly && rows.length > 0;

  return (
    <AdminTable
      title={ownerOnly ? 'Promosi Saya' : 'List Promosi'}
      rows={rows} loading={loading} error={error && apiErrorMessage(error)} onRetry={reload}
      columns={COLUMNS}
      actions={(row) => (
        <>
          <Link className="btn btn-sm btn-warning" to={`${editBase}/${row.id}/edit`}>
            <i className="bi bi-pencil me-1 d-none d-sm-inline" />Edit
          </Link>
          <button className="btn btn-sm btn-danger" onClick={() => handleDelete(row.id)}>
            <i className="bi bi-trash me-1 d-none d-sm-inline" />Hapus
          </button>
        </>
      )}
      addButton={
        <Link className={`btn btn-sm btn-success ${disableAdd ? 'disabled' : ''}`} to={disableAdd ? '#' : addTo}>
          <i className="bi bi-plus-lg me-1" />{ownerOnly ? 'Tambah Promosi' : 'Tambah Data'}
        </Link>
      }
    />
  );
}

export function PromosiAdmin() {
  return <PromosiTable fetchAll={() => promosiApi.list()} addTo="/promosi/tambah" editBase="/promosi" ownerOnly={false} />;
}

export function PromosiOwner() {
  const { user } = useAuth();
  return (
    <PromosiTable
      fetchAll={async () => {
        try {
          return await promosiApi.byUser(user.username);
        } catch (err) {
          if (err?.response?.status === 404) return [];
          throw err;
        }
      }}
      addTo="/promosi-saya/tambah"
      editBase="/promosi-saya"
      ownerOnly
    />
  );
}
