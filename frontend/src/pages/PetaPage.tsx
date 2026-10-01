import { useQuery } from '@tanstack/react-query';
import { useMemo, useState } from 'react';
import { LayersControl, MapContainer, Polygon, Popup, TileLayer, Tooltip } from 'react-leaflet';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { Card, CardContent, CardHeader, CardTitle } from '../components/ui/card';
import { apiError } from '../services/api';
import { mapCounts } from '../services/umkm.service';

interface PolygonData {
  coordinates: [number, number][];
  color: string;
  fillColor: string;
}

interface DesaRow {
  kecamatan: string;
  desa_kelurahan: string;
  total_desa_kelurahan: number;
  mikro: string | number;
  kecil: string | number;
  menengah: string | number;
}

async function loadPolygons(): Promise<Record<string, PolygonData>> {
  const res = await fetch('/data/kecamatan-polygons.json');
  if (!res.ok) throw new Error('Gagal memuat poligon kecamatan');
  return res.json();
}

const CENTER: [number, number] = [-7.098789834990307, 107.55676310606337];
const MAX_BOUNDS: L.LatLngBoundsExpression = [
  [-7.323590394907745, 107.54577677846918],
  [-6.787976204215563, 107.59246867074448],
];

/** Nama "Arjasari (2)" di JSON -> kunci data "Arjasari" (parity popup CI3). */
function baseName(key: string): string {
  return key.replace(/\s*\(\d+\)$/, '');
}

/** Popup per kecamatan dengan pagination lokal (3 desa/halaman, parity CI3). */
function KecamatanPopup({ name, rows }: { name: string; rows: DesaRow[] }) {
  const [cur, setCur] = useState(0);
  const pages = Math.max(1, Math.ceil(rows.length / 3));
  const safe = Math.min(cur, pages - 1);
  const slice = rows.slice(safe * 3, safe * 3 + 3);
  return (
    <div style={{ fontSize: 12 }}>
      <strong>Kecamatan: {name}</strong>
      {rows.length === 0 ? (
        <p>Data tidak tersedia</p>
      ) : (
        <>
          <table style={{ width: '100%', borderCollapse: 'collapse', marginTop: 8 }}>
            <thead>
              <tr>
                {['Desa', 'Total', 'Mikro', 'Kecil', 'Menengah'].map((h) => (
                  <th key={h} style={{ border: '1px solid #ccc', padding: 4, textAlign: 'left' }}>{h}</th>
                ))}
              </tr>
            </thead>
            <tbody>
              {slice.map((v) => (
                <tr key={v.desa_kelurahan}>
                  <td style={{ border: '1px solid #ccc', padding: 4 }}>{v.desa_kelurahan}</td>
                  <td style={{ border: '1px solid #ccc', padding: 4, textAlign: 'center' }}>{v.total_desa_kelurahan}</td>
                  <td style={{ border: '1px solid #ccc', padding: 4, textAlign: 'center' }}>{v.mikro}</td>
                  <td style={{ border: '1px solid #ccc', padding: 4, textAlign: 'center' }}>{v.kecil}</td>
                  <td style={{ border: '1px solid #ccc', padding: 4, textAlign: 'center' }}>{v.menengah}</td>
                </tr>
              ))}
            </tbody>
          </table>
          {pages > 1 && (
            <div style={{ marginTop: 8, textAlign: 'center' }}>
              <button disabled={safe === 0} onClick={(e) => { e.stopPropagation(); setCur(safe - 1); }} style={{ marginRight: 8 }}>
                Prev
              </button>
              <span>Halaman {safe + 1} dari {pages}</span>
              <button disabled={safe >= pages - 1} onClick={(e) => { e.stopPropagation(); setCur(safe + 1); }} style={{ marginLeft: 8 }}>
                Next
              </button>
            </div>
          )}
        </>
      )}
    </div>
  );
}

export function PetaPage() {
  const polys = useQuery({ queryKey: ['polygons'], queryFn: loadPolygons, staleTime: Infinity });
  const counts = useQuery({ queryKey: ['map-counts'], queryFn: mapCounts });

  const rowsByKec = useMemo(() => {
    const map = new Map<string, DesaRow[]>();
    for (const r of (counts.data as unknown as DesaRow[] | undefined) ?? []) {
      const list = map.get(r.kecamatan) ?? [];
      list.push(r);
      map.set(r.kecamatan, list);
    }
    return map;
  }, [counts.data]);

  if (polys.isError) return <p className="text-sm text-destructive">{apiError(polys.error)}</p>;

  const entries = Object.entries(polys.data ?? {});

  return (
    <div className="flex flex-col gap-4">
      <div>
        <h1 className="text-2xl font-bold">Peta Sebaran UMKM</h1>
        <p className="text-sm text-muted-foreground">
          Kabupaten Bandung — klik poligon kecamatan untuk melihat rincian desa.
        </p>
      </div>
      <Card>
        <CardHeader>
          <CardTitle className="text-base">
            {counts.isSuccess ? `${counts.data.length} desa/kelurahan dengan UMKM disetujui` : 'Memuat data…'}
          </CardTitle>
        </CardHeader>
        <CardContent className="flex flex-col gap-3 p-0 sm:p-6 sm:pt-0">
          <div className="relative isolate z-0 h-[60vh] min-h-[400px] w-full overflow-hidden rounded-md border border-border sm:mx-0">
            <MapContainer
              center={CENTER}
              zoom={10}
              maxBounds={MAX_BOUNDS}
              style={{ height: '100%', width: '100%' }}
            >
              <LayersControl position="topright">
                <LayersControl.BaseLayer checked name="Google Maps">
                  <TileLayer url="https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}" maxZoom={19} />
                </LayersControl.BaseLayer>
                <LayersControl.BaseLayer name="OpenStreetMap">
                  <TileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" maxZoom={19} />
                </LayersControl.BaseLayer>
                <LayersControl.BaseLayer name="Satelit">
                  <TileLayer url="https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}" maxZoom={19} />
                </LayersControl.BaseLayer>
              </LayersControl>
              {entries.map(([key, poly]) => {
                const name = baseName(key);
                const rows = rowsByKec.get(name) ?? [];
                const total = rows.reduce((a, r) => a + Number(r.total_desa_kelurahan ?? 0), 0);
                return (
                  <Polygon
                    key={key}
                    positions={poly.coordinates}
                    // Warna asli tiap kecamatan (parity CI3), solid penuh tanpa transparan.
                    pathOptions={{ color: poly.color, weight: 1.5, fillColor: poly.fillColor, fillOpacity: 1 }}
                  >
                    <Tooltip direction="top" offset={[0, -8]} opacity={1} sticky>
                      <strong>{name}</strong>{total > 0 ? ` — ${total} UMKM` : ''}
                    </Tooltip>
                    <Popup maxWidth={360}>
                      <KecamatanPopup name={name} rows={rows} />
                    </Popup>
                  </Polygon>
                );
              })}
            </MapContainer>
          </div>
          {/* Keterangan peta */}
          <div className="flex flex-wrap items-center gap-x-4 gap-y-1 px-1 text-xs text-muted-foreground sm:px-0">
            <span>Arahkan kursor ke kecamatan untuk melihat namanya — klik untuk rincian desa/kelurahan</span>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
