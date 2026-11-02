import { useEffect, useMemo, useState } from 'react';
import { Link } from 'react-router-dom';
import { PublicNavbar, PublicFooter, Loading, ErrorBox } from '../../components/Public';
import { umkmApi, statsApi, uploadsUrl, apiErrorMessage } from '../../services/api';

const KATEGORI_CARDS = [
  { name: 'Kuliner', icon: 'bi-egg-fried', desc: 'Makanan, minuman, dan olahan khas Kabupaten Bandung.' },
  { name: 'Fashion', icon: 'bi-bag-heart', desc: 'Pakaian, tekstil, dan aksesori karya pelaku lokal.' },
  { name: 'Kerajinan', icon: 'bi-palette', desc: 'Kerajinan tangan dan produk kreatif unggulan.' },
];

function UmkmCard({ item }) {
  return (
    <div className="col-md-3 col-sm-6">
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
  );
}

export default function Home() {
  const [umkm, setUmkm] = useState([]);
  const [counts, setCounts] = useState({ users: 0, owners: 0, umkm: 0 });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    Promise.all([
      umkmApi.byStatus('disetujui'),
      statsApi.countUsers(),
      statsApi.countOwners(),
      statsApi.countUmkm(),
    ])
      .then(([list, u, o, m]) => {
        setUmkm(Array.isArray(list) ? list : []);
        setCounts({ users: u.count ?? 0, owners: o.count ?? 0, umkm: m.count ?? 0 });
      })
      .catch((err) => setError(apiErrorMessage(err, 'Gagal memuat data beranda.')))
      .finally(() => setLoading(false));
  }, []);

  // 8 UMKM acak seperti halaman index.php lama (shuffle + slice).
  const showcase = useMemo(() => {
    const shuffled = [...umkm].sort(() => Math.random() - 0.5);
    return shuffled.slice(0, 8);
  }, [umkm]);

  return (
    <div className="public-page">
      <PublicNavbar />

      <header className="hero-modern">
        <div className="container py-5">
          <div className="row align-items-center g-4">
            <div className="col-lg-7">
              <span className="badge rounded-pill text-bg-warning mb-3">
                <i className="bi bi-geo-alt-fill me-1" /> Kabupaten Bandung
              </span>
              <h1 className="display-hero fw-bold mb-3">
                Portal UMKM Kabupaten Bandung
              </h1>
              <p className="lead opacity-75 mb-4">
                Pusat informasi dan layanan digital untuk mendukung pengembangan
                Usaha Mikro, Kecil, dan Menengah — dari Dinas Perdagangan dan
                Perindustrian.
              </p>
              <div className="d-flex flex-wrap gap-2">
                <Link className="btn btn-light" to="/semua">
                  <i className="bi bi-grid me-1" /> Jelajahi UMKM
                </Link>
                <Link className="btn btn-outline-light" to="/peta">
                  <i className="bi bi-map me-1" /> Lihat Peta
                </Link>
              </div>
            </div>
            <div className="col-lg-5">
              <div className="d-flex flex-wrap gap-2">
                {[
                  [counts.umkm, 'Total UMKM'],
                  [counts.owners, 'Pemilik Usaha'],
                  [counts.users, 'Pengguna'],
                ].map(([num, lbl]) => (
                  <div className="stat-pill" key={lbl}>
                    <div className="num">{num}</div>
                    <div className="lbl">{lbl}</div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </header>

      <section className="container py-5" id="kategori">
        <h2 className="section-title mb-1">Kategori Unggulan</h2>
        <p className="text-muted mb-4">Telusuri UMKM berdasarkan kategori produk.</p>
        <div className="row g-3">
          {KATEGORI_CARDS.map((k) => (
            <div className="col-md-4" key={k.name}>
              <div className="card kategori-card h-100">
                <div className="card-body">
                  <div
                    className="d-inline-flex align-items-center justify-content-center rounded-3 mb-3 text-white"
                    style={{ width: 48, height: 48, background: 'linear-gradient(135deg,#16a34a,#0b3614)' }}
                  >
                    <i className={`bi ${k.icon} fs-4`} />
                  </div>
                  <h5 className="card-title">{k.name}</h5>
                  <p className="card-text text-muted">{k.desc}</p>
                  <Link className="btn btn-outline-success btn-sm stretched-link" to={`/semua?kategori=${k.name}`}>
                    Lihat UMKM {k.name}
                  </Link>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      <section className="container pb-5" id="produk">
        <div className="d-flex justify-content-between align-items-end mb-3">
          <div>
            <h2 className="section-title mb-1">UMKM Unggulan</h2>
            <p className="text-muted mb-0">Pilihan acak dari UMKM yang telah terverifikasi.</p>
          </div>
          <Link className="btn btn-outline-success btn-sm flex-shrink-0" to="/semua">Lihat Semua</Link>
        </div>
        {loading && <Loading />}
        {error && <ErrorBox error={error} />}
        {!loading && !error && (
          <div className="row g-3">
            {showcase.map((item) => <UmkmCard key={item.id} item={item} />)}
            {showcase.length === 0 && <p>Belum ada data UMKM yang disetujui.</p>}
          </div>
        )}
      </section>

      <PublicFooter />
    </div>
  );
}
