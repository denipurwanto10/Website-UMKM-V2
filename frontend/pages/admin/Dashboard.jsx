import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { Chart as ChartJS, CategoryScale, LinearScale, BarElement, ArcElement, Tooltip, Legend } from 'chart.js';
import { Bar, Pie } from 'react-chartjs-2';
import { useAuth } from '../../context/AuthContext';
import { useTheme } from '../../context/ThemeContext';
import { statsApi, apiErrorMessage } from '../../services/api';
import { Loading, ErrorBox } from '../../components/Public';

ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Tooltip, Legend);

const PALETTE = ['#16a34a', '#f59e0b', '#0ea5e9', '#8b5cf6', '#ef4444', '#14b8a6', '#f97316', '#64748b'];

function palette(n) {
  return Array.from({ length: n }, (_, i) => PALETTE[i % PALETTE.length]);
}

// Warna chart mengikuti tema aktif (dibaca dari CSS variables).
function chartColors(dark) {
  return {
    grid: dark ? 'rgba(255,255,255,0.12)' : 'rgba(20,45,30,0.1)',
    tick: dark ? 'rgba(255,255,255,0.75)' : '#5f7167',
  };
}

function makeBarOpts(dark) {
  const { grid, tick } = chartColors(dark);
  return {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { labels: { color: tick } } },
    scales: {
      x: { ticks: { color: tick }, grid: { color: grid } },
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1, color: tick, callback: (v) => (Number.isInteger(v) ? v : '') },
        grid: { color: grid },
      },
    },
  };
}

function StatCard({ icon, label, value, to }) {
  const inner = (
    <>
      <div
        className="d-inline-flex align-items-center justify-content-center rounded-3 mb-2 text-white"
        style={{ width: 44, height: 44, background: 'linear-gradient(135deg,#16a34a,#0b3614)' }}
      >
        <i className={`bi ${icon} fs-5`} />
      </div>
      <div className="h3 fw-bold mb-0">{value}</div>
      <div className="small opacity-75">{label}</div>
    </>
  );
  return (
    <div className="col-xl-4 col-md-6">
      <div className="card glass-card h-100">
        <div className="card-body">
          {to ? <Link to={to} className="text-decoration-none stretched-link admin-ink">{inner}</Link> : inner}
        </div>
      </div>
    </div>
  );
}

export default function Dashboard() {
  const { isAdmin, user } = useAuth();
  const { dark } = useTheme();
  const barOpts = makeBarOpts(dark);
  const { tick } = chartColors(dark);
  const [counts, setCounts] = useState(null);
  const [kategori, setKategori] = useState([]);
  const [desaKec, setDesaKec] = useState([]);
  const [desaKat, setDesaKat] = useState([]);
  const [jenis, setJenis] = useState([]);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (!isAdmin) return;
    setError(null);
    Promise.all([
      statsApi.countAdmins(), statsApi.countOwners(), statsApi.countUmkmDisetujui(),
      statsApi.umkmPerKategori(), statsApi.desaPerKecamatan(),
      statsApi.desaPerKategori(), statsApi.jumlahJenisUsaha(),
    ])
      .then(([a, o, u, k, dk, dkat, j]) => {
        setCounts({ admins: a.count ?? 0, owners: o.count ?? 0, umkm: u.count ?? 0 });
        setKategori(Array.isArray(k) ? k : []);
        setDesaKec(Array.isArray(dk) ? dk : []);
        setDesaKat(Array.isArray(dkat) ? dkat : []);
        setJenis(Array.isArray(j) ? j : []);
      })
      .catch((err) => setError(apiErrorMessage(err, 'Gagal memuat statistik.')));
  }, [isAdmin]);

  if (!isAdmin) {
    return (
      <div className="card glass-card">
        <div className="card-body p-4">
          <h4 className="fw-bold">Halo, {user?.fullname || user?.username}! 👋</h4>
          <p className="opacity-75 mb-3">
            Kelola data UMKM dan promosi Anda lewat menu di samping.
          </p>
          <div className="d-flex flex-wrap gap-2">
            <Link className="btn btn-success btn-sm" to="/data-umkm">
              <i className="bi bi-shop me-1" /> Data UMKM Saya
            </Link>
            <Link className="btn btn-ghost btn-sm" to="/promosi-saya">
              <i className="bi bi-megaphone me-1" /> Promosi Saya
            </Link>
          </div>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div>
        <h4 className="admin-ink mb-3">Dashboard</h4>
        <ErrorBox error={error} onRetry={() => window.location.reload()} />
      </div>
    );
  }

  if (!counts) return <Loading text="Memuat statistik..." />;

  return (
    <div>
      <h4 className="admin-ink mb-3">Dashboard</h4>
      <div className="row g-3 mb-4">
        <StatCard icon="bi-shield-check" label="Data Admin" value={counts.admins} to="/users" />
        <StatCard icon="bi-people" label="Pemilik UMKM" value={counts.owners} to="/users" />
        <StatCard icon="bi-shop" label="UMKM Disetujui" value={counts.umkm} to="/disetujui" />
      </div>

      <div className="row g-3">
        <div className="col-xl-6">
          <div className="card glass-card mb-3">
            <div className="card-header">Jumlah UMKM per Kategori</div>
            <div className="card-body" style={{ height: 300 }}>
              <Bar
                data={{
                  labels: kategori.map((r) => r.kategori_produk),
                  datasets: [{ label: 'Jumlah UMKM', data: kategori.map((r) => r.jumlah_umkm), backgroundColor: palette(kategori.length), borderRadius: 6 }],
                }}
                options={barOpts}
              />
            </div>
          </div>
          <div className="card glass-card mb-3">
            <div className="card-header">Jumlah Desa per Kecamatan</div>
            <div className="card-body" style={{ height: 320 }}>
              <Bar
                data={{
                  labels: desaKec.map((r) => r.kecamatan),
                  datasets: [{ label: 'Jumlah Desa', data: desaKec.map((r) => r.jumlah_desa), backgroundColor: palette(desaKec.length), borderRadius: 6 }],
                }}
                options={barOpts}
              />
            </div>
          </div>
        </div>
        <div className="col-xl-6">
          <div className="card glass-card mb-3">
            <div className="card-header">Jumlah Desa per Kategori</div>
            <div className="card-body" style={{ height: 300 }}>
              <Pie
                data={{
                  labels: desaKat.map((r) => r.kategori_produk),
                  datasets: [{ data: desaKat.map((r) => r.jumlah_desa), backgroundColor: palette(desaKat.length) }],
                }}
                options={{ responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { color: tick } } } }}
              />
            </div>
          </div>
          <div className="card glass-card mb-3">
            <div className="card-header">Jumlah UMKM per Jenis Usaha</div>
            <div className="card-body" style={{ height: 320 }}>
              <Bar
                data={{
                  labels: jenis.map((r) => r.jenis_usaha),
                  datasets: [{ label: 'Jumlah UMKM', data: jenis.map((r) => r.jumlah), backgroundColor: palette(jenis.length), borderRadius: 6 }],
                }}
                options={{ ...barOpts, indexAxis: 'y' }}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
