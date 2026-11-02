import { useEffect, useRef, useState } from 'react';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { Link } from 'react-router-dom';
import { umkmApi, apiErrorMessage } from '../../services/api';
import { useAuth } from '../../context/AuthContext';
import ThemeToggle from '../../components/ThemeToggle';
import polygons from '../../data/kecamatanPolygons.json';

const CENTER = [-7.098789834990307, 107.55676310606337];
const MAX_BOUNDS = [
  [-7.323590394907745, 107.54577677846918],
  [-6.787976204215563, 107.59246867074448],
];
const PAGE_SIZE = 3;

function popupHtml(kecamatan, rows, page) {
  const totalPages = Math.max(1, Math.ceil(rows.length / PAGE_SIZE));
  const current = Math.min(Math.max(page, 1), totalPages);
  const slice = rows.slice((current - 1) * PAGE_SIZE, current * PAGE_SIZE);
  const body = slice
    .map(
      (v) => `<tr>
        <td style="padding:4px;border:1px solid #ccc;">${v.desa_kelurahan ?? ''}</td>
        <td style="padding:4px;text-align:center;border:1px solid #ccc;">${v.total_desa_kelurahan ?? 0}</td>
        <td style="padding:4px;text-align:center;border:1px solid #ccc;">${v.mikro ?? 0}</td>
        <td style="padding:4px;text-align:center;border:1px solid #ccc;">${v.kecil ?? 0}</td>
        <td style="padding:4px;text-align:center;border:1px solid #ccc;">${v.menengah ?? 0}</td>
      </tr>`
    )
    .join('');
  return `<div style="font-size:12px;min-width:280px;">
    <strong>Kecamatan:</strong> ${kecamatan}<br><br>
    <table style="width:100%;border:1px solid #ccc;border-collapse:collapse;font-size:12px;">
      <tr>
        <th style="padding:4px;text-align:left;border:1px solid #ccc;">Desa / Kelurahan</th>
        <th style="padding:4px;border:1px solid #ccc;">Total</th>
        <th style="padding:4px;border:1px solid #ccc;">Mikro</th>
        <th style="padding:4px;border:1px solid #ccc;">Kecil</th>
        <th style="padding:4px;border:1px solid #ccc;">Menengah</th>
      </tr>${body}
    </table><br>
    <div style="text-align:center;font-size:12px;">
      <button data-nav="-1" style="padding:4px 8px;margin:0 3px;border:none;border-radius:3px;background-color:${
        current === 1 ? '#cccccc' : '#4CAF50'
      };color:white;">Prev</button>
      <span style="font-weight:bold;"> Page ${current} of ${totalPages} </span>
      <button data-nav="1" style="padding:4px 8px;margin:0 3px;border:none;border-radius:3px;background-color:${
        current === totalPages ? '#cccccc' : '#4CAF50'
      };color:white;">Next</button>
    </div>
  </div>`;
}

export default function Peta() {
  const mapEl = useRef(null);
  const [error, setError] = useState(null);
  const { user } = useAuth();

  useEffect(() => {
    // Basemap mengikuti tema: gelap (CartoDB dark) saat dark mode.
    const darkTiles = L.tileLayer(
      'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
      { maxZoom: 19, subdomains: 'abcd' }
    );
    const map = L.map(mapEl.current, {
      center: CENTER, zoom: 10, maxBounds: MAX_BOUNDS,
    });
    const light = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { maxZoom: 19 });
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 });
    const sat = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { maxZoom: 19 });
    L.control.layers({
      'Mode Gelap': darkTiles,
      'Google Maps': light,
      OpenStreetMap: osm,
      Satelit: sat,
    }).addTo(map);
    // Default = dark mode → basemap gelap; light mode → Google Maps.
    (document.documentElement.getAttribute('data-theme') === 'dark' ? darkTiles : light).addTo(map);

    let alive = true;
    umkmApi
      .countDisetujui()
      .then((kecamatanData) => {
        if (!alive) return;
        polygons.forEach(({ name, coordinates, color, fillColor }) => {
          const polygon = L.polygon(coordinates, {
            color, weight: 1.0, fillColor, fillOpacity: 1,
          }).addTo(map);
          const rows = (kecamatanData || []).filter((d) => d.kecamatan === name);
          if (rows.length === 0) {
            polygon.bindPopup(`Kecamatan: ${name} - Data tidak tersedia`);
            return;
          }
          let page = 1;
          polygon.bindPopup(popupHtml(name, rows, page));
          // Pasang ulang listener setiap popup dibuka / konten diganti,
          // karena setContent mengganti elemen tombol (seperti updateButtons() lama).
          const bindNav = () => {
            popup.getElement()?.querySelectorAll('button[data-nav]').forEach((btn) => {
              btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const totalPages = Math.ceil(rows.length / PAGE_SIZE);
                page = Math.min(Math.max(page + Number(btn.dataset.nav), 1), totalPages);
                popup.setContent(popupHtml(name, rows, page));
                bindNav();
              });
            });
          };
          polygon.on('popupopen', bindNav);
        });
      })
      .catch((err) => alive && setError(apiErrorMessage(err, 'Gagal memuat data peta.')));

    return () => {
      alive = false;
      map.remove();
    };
  }, []);

  return (
    <div>
      <nav className="navbar navbar-dark px-3 public-nav">
        <Link className="navbar-brand d-flex align-items-center gap-2" to="/">
          <i className="bi bi-arrow-left" />
          <img src="/logo.png" alt="logo" height={30} className="rounded d-none d-sm-inline" />
          <span className="fs-6">Peta UMKM Kab. Bandung</span>
        </Link>
        <div className="d-flex align-items-center gap-2">
          <ThemeToggle className="btn btn-sm btn-outline-light" label={false} />
          {user ? (
            <Link className="btn btn-sm btn-success" to="/dashboard">Dashboard</Link>
          ) : (
            <Link className="btn btn-sm btn-success" to="/login">Masuk</Link>
          )}
        </div>
      </nav>
      {error && <div className="alert alert-warning m-0 rounded-0">{error}</div>}
      <div ref={mapEl} className="leaflet-map" />
    </div>
  );
}
