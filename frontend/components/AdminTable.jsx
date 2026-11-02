import Swal from 'sweetalert2';
import { useClientTable } from '../hooks/useFetch';
import { Pagination, Loading } from './Public';

export function confirmDelete(text = 'Data yang dihapus tidak dapat dikembalikan.') {
  return Swal.fire({
    title: 'Yakin ingin menghapus?',
    text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#dc3545',
  }).then((r) => r.isConfirmed);
}

export function AdminTable({
  title, subtitle, rows, loading, error, onRetry,
  columns, actions, addButton, perPageOptions = [5, 10, 25, 50],
}) {
  const t = useClientTable(rows, { initialPerPage: 10 });

  return (
    <div className="card glass-card">
      <div className="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <div>
          <h5 className="mb-0">{title}</h5>
          {subtitle && <small className="opacity-75">{subtitle}</small>}
        </div>
        {addButton}
      </div>
      <div className="card-body">
        {error && (
          <div className="alert alert-danger d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <span>{String(error?.message || error)}</span>
            {onRetry && <button className="btn btn-sm btn-outline-danger" onClick={onRetry}>Coba lagi</button>}
          </div>
        )}
        <div className="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
          <label className="small d-flex align-items-center gap-2 mb-0">
            Tampilkan
            <select
              className="form-select form-select-sm" style={{ width: 'auto' }}
              value={t.perPage} onChange={(e) => t.setPerPage(Number(e.target.value))}
            >
              {perPageOptions.map((n) => <option key={n} value={n}>{n}</option>)}
            </select>
            data
          </label>
          <div className="input-group input-group-sm" style={{ maxWidth: 280 }}>
            <span className="input-group-text"><i className="bi bi-search" /></span>
            <input
              className="form-control" placeholder="Cari..."
              value={t.query} onChange={(e) => t.setQuery(e.target.value)}
            />
            {t.query && (
              <button className="btn btn-outline-secondary" onClick={() => t.setQuery('')} title="Bersihkan">
                <i className="bi bi-x" />
              </button>
            )}
          </div>
        </div>

        {loading ? (
          <Loading />
        ) : (
          <>
            {/* Tabel desktop */}
            <div className="table-responsive d-none d-md-block">
              <table className="table table-sm align-middle table-hover">
                <thead>
                  <tr>
                    {columns.map((c) => <th key={c.key}>{c.label}</th>)}
                    {actions && <th className="text-end">Aksi</th>}
                  </tr>
                </thead>
                <tbody>
                  {t.pageRows.map((row, i) => (
                    <tr key={row.id ?? row.username ?? i}>
                      {columns.map((c) => (
                        <td key={c.key}>{c.render ? c.render(row) : (row[c.key] ?? '-')}</td>
                      ))}
                      {actions && (
                        <td><div className="d-flex gap-1 justify-content-end flex-nowrap">{actions(row)}</div></td>
                      )}
                    </tr>
                  ))}
                  {t.pageRows.length === 0 && (
                    <tr>
                      <td colSpan={columns.length + 1} className="text-center py-4 opacity-75">
                        <i className="bi bi-inbox fs-4 d-block mb-1" />
                        {t.query ? 'Tidak ada hasil untuk pencarian ini.' : 'Belum ada data.'}
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>

            {/* Kartu mobile */}
            <div className="d-md-none d-flex flex-column gap-2">
              {t.pageRows.map((row, i) => (
                <div className="card mobile-row-card" key={row.id ?? row.username ?? i}>
                  <div className="card-body p-3">
                    {columns.slice(0, 4).map((c) => (
                      <div className="d-flex justify-content-between gap-2 small mb-1" key={c.key}>
                        <span className="opacity-75">{c.label}</span>
                        <span className="text-end fw-semibold text-break">
                          {c.render ? c.render(row) : (row[c.key] ?? '-')}
                        </span>
                      </div>
                    ))}
                    {actions && <div className="d-flex gap-2 mt-2">{actions(row)}</div>}
                  </div>
                </div>
              ))}
              {t.pageRows.length === 0 && (
                <div className="text-center py-4 opacity-75">
                  <i className="bi bi-inbox fs-4 d-block mb-1" />
                  {t.query ? 'Tidak ada hasil untuk pencarian ini.' : 'Belum ada data.'}
                </div>
              )}
            </div>
          </>
        )}

        <div className="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3">
          <small className="opacity-75">
            Menampilkan {t.pageRows.length} dari {t.total} data
          </small>
          <Pagination page={t.page} totalPages={t.totalPages} onChange={t.setPage} />
        </div>
      </div>
    </div>
  );
}

export function statusBadge(status) {
  const map = {
    menunggu: 'text-bg-warning',
    disetujui: 'text-bg-success',
    ditolak: 'text-bg-danger',
  };
  const icon = { menunggu: 'bi-hourglass-split', disetujui: 'bi-check-circle', ditolak: 'bi-x-circle' }[status];
  return (
    <span className={`badge ${map[status] || 'text-bg-secondary'}`}>
      {icon && <i className={`bi ${icon} me-1`} />}{status}
    </span>
  );
}
