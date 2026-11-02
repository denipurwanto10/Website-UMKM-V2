import { Link } from 'react-router-dom';
import Swal from 'sweetalert2';
import { jsPDF } from 'jspdf';
import 'jspdf-autotable';
import { useFetch } from '../../hooks/useFetch';
import { AdminTable, confirmDelete, statusBadge } from '../../components/AdminTable';
import { umkmApi, uploadsUrl, apiErrorMessage } from '../../services/api';

function useUmkmList(status) {
  return useFetch(() => umkmApi.byStatus(status));
}

async function handleDelete(id, reload, status) {
  if (!(await confirmDelete())) return;
  try {
    await umkmApi.remove(id);
    await Swal.fire({ icon: 'success', title: 'UMKM berhasil dihapus.' });
    reload();
  } catch (err) {
    Swal.fire({ icon: 'error', title: 'Gagal menghapus UMKM', text: apiErrorMessage(err) });
  }
}

const COLUMNS = [
  { key: 'photo', label: 'Photo', render: (r) => <img src={uploadsUrl('umkm', r.photo)} alt="" style={{ width: 50, height: 50, objectFit: 'cover', borderRadius: '50%' }} /> },
  { key: 'fullname', label: 'Nama Pemilik' },
  { key: 'nama_usaha', label: 'Nama Usaha' },
  { key: 'nama_merek_produk', label: 'Merek' },
  { key: 'kategori_produk', label: 'Kategori' },
  { key: 'jenis_usaha', label: 'Jenis Usaha' },
  { key: 'pendapatan', label: 'Pendapatan' },
  { key: 'jalan', label: 'Jalan' },
  { key: 'kecamatan', label: 'Kecamatan' },
  { key: 'desa_kelurahan', label: 'Desa/Kelurahan' },
  { key: 'status', label: 'Status', render: (r) => statusBadge(r.status) },
];

function actionsFor(reload) {
  return (row) => (
    <>
      <Link className="btn btn-sm btn-warning" to={`/umkm/${row.id}/edit`} title="Edit">
        <i className="bi bi-pencil me-1 d-none d-sm-inline" />Edit
      </Link>
      <button className="btn btn-sm btn-danger" onClick={() => handleDelete(row.id, reload)} title="Hapus">
        <i className="bi bi-trash me-1 d-none d-sm-inline" />Hapus
      </button>
    </>
  );
}

export function Menunggu() {
  const { data, loading, error, reload } = useUmkmList('menunggu');
  return (
    <AdminTable
      title="UMKM Menunggu" subtitle="Verifikasi data yang masuk dari pemilik usaha"
      rows={data} loading={loading} error={error && apiErrorMessage(error)} onRetry={reload}
      columns={COLUMNS} actions={actionsFor(reload)}
      addButton={<Link className="btn btn-sm btn-success" to="/umkm/tambah"><i className="bi bi-plus-lg me-1" />Tambah Data</Link>}
    />
  );
}

function exportPdf(rows) {
  const doc = new jsPDF();
  doc.setFontSize(14);
  doc.text('PEMERINTAH KABUPATEN BANDUNG', 105, 14, { align: 'center' });
  doc.setFontSize(11);
  doc.text('Data UMKM Disetujui', 105, 21, { align: 'center' });
  doc.setFontSize(9);
  doc.text(`Tanggal: ${new Date().toLocaleDateString('id-ID')}`, 14, 28);
  doc.autoTable({
    startY: 32,
    head: [['Pemilik', 'Usaha', 'Merek', 'Kategori', 'Alamat', 'Perijinan']],
    body: (rows || []).map((r) => [
      r.fullname || r.username,
      r.nama_usaha,
      r.nama_merek_produk,
      r.kategori_produk,
      [r.jalan, r.desa_kelurahan, r.kecamatan].filter(Boolean).join(', '),
      ['NIB', 'PIRT', 'BPOM', 'Halal', 'HAKI'].filter((k) => r[k.toLowerCase()]).join(', ') || '-',
    ]),
  });
  doc.save('umkm-disetujui.pdf');
}

export function Disetujui() {
  const { data, loading, error, reload } = useUmkmList('disetujui');
  return (
    <AdminTable
      title="UMKM Disetujui" subtitle="Data yang tampil di katalog publik dan peta"
      rows={data} loading={loading} error={error && apiErrorMessage(error)} onRetry={reload}
      columns={COLUMNS} actions={actionsFor(reload)}
      addButton={
        <button className="btn btn-sm btn-light" onClick={() => exportPdf(data)} disabled={!data?.length}>
          <i className="bi bi-file-earmark-pdf me-1" />Unduh PDF
        </button>
      }
    />
  );
}

export function Ditolak() {
  const { data, loading, error, reload } = useUmkmList('ditolak');
  const columns = [
    ...COLUMNS,
    { key: 'catatan', label: 'Catatan', render: (r) => r.catatan || '-' },
  ];
  return (
    <AdminTable
      title="UMKM Ditolak" rows={data} loading={loading} error={error && apiErrorMessage(error)} onRetry={reload}
      columns={columns}
      actions={(row) => (
        <button className="btn btn-sm btn-danger" onClick={() => handleDelete(row.id, reload)}>Hapus</button>
      )}
    />
  );
}
