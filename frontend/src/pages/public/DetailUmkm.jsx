import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import { PublicNavbar, PublicFooter, Loading } from '../../components/Public';
import { umkmApi, uploadsUrl, apiErrorMessage } from '../../services/api';

const MARKETPLACES = [
  ['whatsapp', 'WhatsApp', 'bi-whatsapp'], ['blibli', 'Blibli', 'bi-bag'],
  ['lazada', 'Lazada', 'bi-cart'], ['shopee', 'Shopee', 'bi-bag-fill'],
  ['tokopedia', 'Tokopedia', 'bi-shop'], ['facebook', 'Facebook', 'bi-facebook'],
  ['instagram', 'Instagram', 'bi-instagram'], ['tiktok', 'TikTok', 'bi-music-note'],
  ['twitter', 'Twitter', 'bi-twitter-x'],
];

export default function DetailUmkm() {
  const { id } = useParams();
  const [umkm, setUmkm] = useState(null);
  const [others, setOthers] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    setError(null);
    setUmkm(null);
    umkmApi
      .detail(id)
      .then((d) => {
        setUmkm(d);
        return umkmApi.byStatus('disetujui');
      })
      .then((list) => {
        const arr = (Array.isArray(list) ? list : []).filter((x) => String(x.id) !== String(id));
        setOthers(arr.sort(() => Math.random() - 0.5).slice(0, 4));
      })
      .catch((err) => setError(apiErrorMessage(err, 'Data UMKM tidak ditemukan.')));
  }, [id]);

  if (!umkm && !error) {
    return (
      <div className="public-page"><PublicNavbar /><div className="container"><Loading /></div></div>
    );
  }

  return (
    <div className="public-page">
      <PublicNavbar />
      <main className="container py-4">
        <nav aria-label="breadcrumb" className="mb-3">
          <ol className="breadcrumb mb-0">
            <li className="breadcrumb-item"><Link to="/">Home</Link></li>
            <li className="breadcrumb-item"><Link to="/semua">Katalog</Link></li>
            <li className="breadcrumb-item active" aria-current="page">{umkm?.nama_usaha || 'Detail'}</li>
          </ol>
        </nav>

        {error && (
          <div className="alert alert-warning">
            {error} <Link to="/semua" className="alert-link">Kembali ke daftar UMKM</Link>
          </div>
        )}
        {umkm && (
          <>
            <div className="card border-0 shadow-sm overflow-hidden mb-4">
              <div className="row g-0">
                <div className="col-md-5">
                  <img
                    src={uploadsUrl('umkm', umkm.photo)}
                    className="img-fluid w-100 h-100"
                    alt={umkm.nama_usaha}
                    style={{ objectFit: 'cover', minHeight: 280 }}
                  />
                </div>
                <div className="col-md-7">
                  <div className="card-body p-4">
                    <span className="badge text-bg-success mb-2">{umkm.kategori_produk}</span>
                    <h2 className="fw-bold mb-0">{umkm.nama_usaha}</h2>
                    <p className="text-muted">{umkm.nama_merek_produk}</p>
                    <dl className="row small mt-3 mb-0">
                      <dt className="col-sm-4">Pemilik</dt>
                      <dd className="col-sm-8">{umkm.fullname || umkm.username}</dd>
                      <dt className="col-sm-4">Alamat</dt>
                      <dd className="col-sm-8">{umkm.jalan}, {umkm.desa_kelurahan}, {umkm.kecamatan}</dd>
                      <dt className="col-sm-4">Jenis Usaha</dt>
                      <dd className="col-sm-8">{umkm.jenis_usaha} <span className="text-muted">({umkm.pendapatan})</span></dd>
                    </dl>
                    <div className="mt-3 d-flex flex-wrap gap-2">
                      {MARKETPLACES.filter(([k]) => umkm[k]).map(([k, label, icon]) => (
                        <a
                          key={k}
                          className="btn btn-outline-success btn-sm"
                          href={umkm[k]}
                          target="_blank"
                          rel="noreferrer"
                        >
                          <i className={`bi ${icon} me-1`} />{label}
                        </a>
                      ))}
                      {MARKETPLACES.every(([k]) => !umkm[k]) && (
                        <span className="text-muted small">Belum ada tautan pemasaran.</span>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="card border-0 shadow-sm mb-4">
              <div className="card-body p-4">
                <h5 className="fw-bold">Deskripsi Produk</h5>
                <p className="mb-0" style={{ whiteSpace: 'pre-line' }}>{umkm.deskripsi_produk || '-'}</p>
              </div>
            </div>

            <div className="d-flex justify-content-between align-items-center mb-3">
              <h4 className="section-title mb-0">UMKM Lainnya</h4>
              <Link className="btn btn-outline-success btn-sm" to="/semua">Lihat Semua</Link>
            </div>
            <div className="row g-3">
              {others.map((item) => (
                <div className="col-md-3 col-sm-6" key={item.id}>
                  <div className="card umkm-card h-100">
                    <img
                      src={uploadsUrl('umkm', item.photo)}
                      className="card-img-top"
                      alt={item.nama_usaha}
                      loading="lazy"
                      style={{ height: 150 }}
                    />
                    <div className="card-body d-flex flex-column">
                      <h5 className="card-title">{item.nama_usaha}</h5>
                      <Link className="btn btn-success btn-sm align-self-start mt-auto" to={`/umkm/${item.id}`}>
                        Detail
                      </Link>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </>
        )}
      </main>
      <PublicFooter />
    </div>
  );
}
