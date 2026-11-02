import { Link } from 'react-router-dom';
import Swal from 'sweetalert2';
import { useFetch } from '../../hooks/useFetch';
import { AdminTable, confirmDelete } from '../../components/AdminTable';
import { usersApi, uploadsUrl, apiErrorMessage } from '../../services/api';

export function UsersList() {
  const { data, loading, error, reload } = useFetch(() => usersApi.list());

  async function handleDelete(username) {
    if (!(await confirmDelete())) return;
    try {
      await usersApi.remove(username);
      await Swal.fire({ icon: 'success', title: 'Pengguna berhasil dihapus.' });
      reload();
    } catch (err) {
      Swal.fire({ icon: 'error', title: 'Gagal menghapus pengguna', text: apiErrorMessage(err) });
    }
  }

  return (
    <AdminTable
      title="Data Pengguna" rows={data} loading={loading} error={error && apiErrorMessage(error)} onRetry={reload}
      columns={[
        { key: 'photo', label: 'Photo', render: (r) => <img src={uploadsUrl('users', r.photo)} alt="" style={{ width: 50, height: 50, objectFit: 'cover', borderRadius: '50%' }} /> },
        { key: 'username', label: 'Username' },
        { key: 'fullname', label: 'Fullname' },
        { key: 'usertype', label: 'Role', render: (r) => <span className="badge bg-info text-dark">{r.usertype}</span> },
        { key: 'email', label: 'Email' },
        { key: 'nomor_hp', label: 'Nomor HP' },
      ]}
      actions={(row) => (
        <>
          <Link className="btn btn-sm btn-warning" to={`/users/${row.username}/edit`}>
            <i className="bi bi-pencil me-1 d-none d-sm-inline" />Edit
          </Link>
          <button className="btn btn-sm btn-danger" onClick={() => handleDelete(row.username)}>
            <i className="bi bi-trash me-1 d-none d-sm-inline" />Hapus
          </button>
        </>
      )}
      addButton={<Link className="btn btn-sm btn-success" to="/users/tambah"><i className="bi bi-plus-lg me-1" />Tambah User</Link>}
    />
  );
}

export function Profil({ ownerMode = false }) {
  const { data, loading, error } = useFetch(() =>
    usersApi.byUsername(JSON.parse(localStorage.getItem('umkm_user') || '{}').username)
  );
  const user = data;

  if (loading) return <div className="text-center py-5"><div className="spinner-border" role="status" /></div>;
  if (error || !user) return <div className="alert alert-danger">{apiErrorMessage(error, 'Gagal memuat profil.')}</div>;

  return (
    <div className="card glass-card mx-auto" style={{ maxWidth: 640 }}>
      <div className="card-header">
        <h5 className="mb-0"><i className="bi bi-person-circle me-2" />Profil Pengguna</h5>
      </div>
      <div className="card-body text-center p-4">
        <img
          src={uploadsUrl('users', user.photo)} alt="Foto profil"
          style={{ width: 140, height: 140, objectFit: 'cover' }} className="rounded-circle mb-3 avatar-ring"
        />
        <h4 className="mb-1">{user.fullname}</h4>
        <p className="mb-3"><span className="badge text-bg-success">{user.usertype}</span></p>
        <dl className="row small text-start mb-0">
          <dt className="col-sm-4 opacity-75">Username</dt><dd className="col-sm-8">{user.username}</dd>
          <dt className="col-sm-4 opacity-75">Email</dt><dd className="col-sm-8 text-break">{user.email}</dd>
          <dt className="col-sm-4 opacity-75">Nomor HP</dt><dd className="col-sm-8">{user.nomor_hp}</dd>
        </dl>
        {ownerMode && (
          <Link className="btn btn-warning btn-sm mt-3" to={`/users/${user.username}/edit`}>
            <i className="bi bi-pencil me-1" />Edit Profil
          </Link>
        )}
      </div>
    </div>
  );
}
