import { useEffect, useMemo, useState } from 'react';
import { Link, useSearchParams } from 'react-router-dom';
import { PublicNavbar, PublicFooter, Loading, ErrorBox } from '../../components/Public';
import { umkmApi, uploadsUrl, apiErrorMessage } from '../../services/api';

export default function SemuaUmkm() {
  const [params] = useSearchParams();
  const [rows, setRows] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [kategori, setKategori] = useState(params.get('kategori') || '');
  const [namaUsaha, setNamaUsaha] = useState('');
  const [merek, setMerek] = useState('');

  useEffect(() => {
    umkmApi
      .byStatus('disetujui')
      .then((list) => setRows(Array.isArray(list) ? list : []))
      .catch((err) => setError(apiErrorMessage(err, 'Gagal memuat data UMKM.')))
      .finally(() => setLoading(false));
  }, []);

  // Filter client-side seperti halaman all.php lama.
  const filtered = useMemo(
    () =>
      rows.filter((r) => {
        if (kategori && (r.kategori_produk || '').toLowerCase() !== kategori.toLowerCase())
          return false;
        if (namaUsaha && !(r.nama_usaha || '').toLowerCase().includes(namaUsaha.toLowerCase()))
          return false;
        if (merek && !(r.nama_merek_produk || '').toLowerCase().includes(merek.toLowerCase()))
          return false;
        return true;
      }),
    [rows, kategori, namaUsaha, merek]
  );

  return (
    <div className="public-page">
      <PublicNavbar />
      <div className="container py-4">
        <h2 className="section-title mb-1">Katalog UMKM</h2>
        <p className="text-muted">Saring berdasarkan kategori, nama usaha, atau merek.</p>
        <div className="filter-bar row g-2 my-3">
          <div className="col-md-3">
            <select className="form-select" value={kategori} onChange={(e) => setKategori(e.target.value)} aria-label="Filter kategori">
              <option value="">Semua Kategori</option>
              <option value="Kuliner">Kuliner</option>
              <option value="Fashion">Fashion</option>
              <option value="Kerajinan">Kerajinan</option>
            </select>
          </div>
          <div className="col-md-4">
            <div className="input-group">
              <span className="input-group-text"><i className="bi bi-search" /></span>
              <input
                className="form-control"
                placeholder="Cari nama usaha..."
                value={namaUsaha}
                onChange={(e) => setNamaUsaha(e.target.value)}
              />
            </div>
          </div>
          <div className="col-md-4">
            <input
              className="form-control"
              placeholder="Cari merek produk..."
              value={merek}
              onChange={(e) => setMerek(e.target.value)}
            />
          </div>
          {(kategori || namaUsaha || merek) && (
            <div className="col-md-1 d-grid">
              <button className="btn btn-outline-secondary" onClick={() => { setKategori(''); setNamaUsaha(''); setMerek(''); }}>
                Reset
              </button>
            </div>
          )}
        </div>

        {loading && <Loading />}
        {error && <ErrorBox error={error} />}
        {!loading && !error && (
          <>
            <p className="text-muted">{filtered.length} UMKM ditemukan</p>
            <div className="row g-3">
              {filtered.map((item) => (
                <div className="col-xl-3 col-md-4 col-sm-6" key={item.id}>
                  <div className="card umkm-card h-100">
                    <img
                      src={uploadsUrl('umkm', item.photo)}
                      className="card-img-top"
                      alt={item.nama_usaha}
                      loading="lazy"
                    />
                    <div className="card-body d-flex flex-column">
                      <span className="badge text-bg-success align-self-start mb-2">{item.kategori_produk}</span>
                      <h5 className="card-title">{item.nama_usaha}</h5>
                      <p className="card-text small text-muted flex-grow-1">{item.nama_merek_produk}</p>
                      <Link className="btn btn-success btn-sm align-self-start" to={`/umkm/${item.id}`}>
                        Lihat Detail <i className="bi bi-arrow-right ms-1" />
                      </Link>
                    </div>
                  </div>
                </div>
              ))}
              {filtered.length === 0 && (
                <div className="col-12">
                  <div className="alert alert-light border text-center">
                    Tidak ada UMKM yang cocok dengan filter. Coba ubah kata kunci.
                  </div>
                </div>
              )}
            </div>
          </>
        )}
      </div>
      <PublicFooter />
    </div>
  );
}
