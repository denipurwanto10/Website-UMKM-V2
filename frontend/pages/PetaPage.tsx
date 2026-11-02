import { useQuery } from '@tanstack/react-query';
import { useMemo, useState } from 'react';
import { LayersControl, MapContainer, Polygon, Popup, TileLayer, Tooltip } from 'react-leaflet';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { apiError } from '../services/api';
import { mapCounts } from '../services/umkm.service';
import { cn } from '../lib/utils';

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
  const navBtn = 'grid h-7 w-7 place-items-center rounded-full border border-border transition-colors hover:bg-accent disabled:opacity-40 disabled:hover:bg-transparent';
  return (
    <div className="w-[17rem] text-xs sm:w-[21rem]">
      <p className="font-display text-lg leading-tight">{name}</p>
      <p className="mt-0.5 text-muted-foreground">Kecamatan</p>
      {rows.length === 0 ? (
        <p className="mt-3 text-muted-foreground">Data tidak tersedia</p>
      ) : (
        <>
          <table className="mt-3 w-full border-collapse">
            <thead>
              <tr className="border-b border-border text-left text-muted-foreground">
                <th className="py-1.5 pe-2 font-medium">Desa</th>
                {['Total', 'Mikro', 'Kecil', 'Menengah'].map((h) => (
                  <th key={h} className="px-1 py-1.5 text-center font-medium">
                    {h}
                  </th>
                ))}
              </tr>
            </thead>
            <tbody>
              {slice.map((v) => (
                <tr key={v.desa_kelurahan} className="border-b border-border/60 last:border-0">
                  <td className="py-2 pe-2">{v.desa_kelurahan}</td>
                  <td className="px-1 text-center tabular-nums">{v.total_desa_kelurahan}</td>
                  <td className="px-1 text-center tabular-nums">{v.mikro}</td>
                  <td className="px-1 text-center tabular-nums">{v.kecil}</td>
                  <td className="px-1 text-center tabular-nums">{v.menengah}</td>
                </tr>
              ))}
            </tbody>
          </table>
          {pages > 1 && (
            <div className="mt-3 flex items-center justify-between">
              <button type="button" aria-label="Sebelumnya" className={navBtn} disabled={safe === 0} onClick={(e) => { e.stopPropagation(); setCur(safe - 1); }}>
                <ChevronLeft className="h-3.5 w-3.5" />
              </button>
              <span className="text-muted-foreground tabular-nums">
                {safe + 1} / {pages}
              </span>
              <button type="button" aria-label="Berikutnya" className={navBtn} disabled={safe >= pages - 1} onClick={(e) => { e.stopPropagation(); setCur(safe + 1); }}>
                <ChevronRight className="h-3.5 w-3.5" />
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
  const ready = polys.isSuccess;

  return (
    <div className="flex flex-col gap-6">
      <div className="hero-rise">
        <h1 className="text-3xl font-normal sm:text-4xl">Peta sebaran UMKM</h1>
        <p className="mt-2 max-w-xl text-sm text-muted-foreground">
          Klik sebuah kecamatan untuk melihat jumlah usaha di tiap desa.
        </p>
      </div>

      <div className="hero-rise relative isolate z-0" style={{ ['--d' as string]: '140ms' }}>
        <div className="h-[68dvh] min-h-[420px] w-full overflow-hidden rounded-3xl border border-border bg-muted">
          <MapContainer center={CENTER} zoom={10} maxBounds={MAX_BOUNDS} style={{ height: '100%', width: '100%' }}>
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
                  eventHandlers={{
                    mouseover: (e) => {
                      e.target.setStyle({ weight: 3.5 });
                      e.target.bringToFront();
                    },
                    mouseout: (e) => e.target.setStyle({ weight: 1.5 }),
                  }}
                >
                  <Tooltip direction="top" offset={[0, -8]} opacity={1} sticky>
                    {name}
                    {total > 0 ? `: ${total} usaha` : ''}
                  </Tooltip>
                  <Popup maxWidth={360}>
                    <KecamatanPopup name={name} rows={rows} />
                  </Popup>
                </Polygon>
              );
            })}
          </MapContainer>
        </div>

        {/* Lapisan memuat — memudar saat poligon siap */}
        <div
          aria-hidden={ready}
          className={cn(
            'skeleton pointer-events-none absolute inset-0 z-[500] grid place-items-center rounded-3xl transition-opacity duration-700 ease-smooth',
            ready ? 'opacity-0' : 'opacity-100',
          )}
        >
          <span className="text-sm text-muted-foreground">Memuat peta…</span>
        </div>

        <div className="pointer-events-none absolute bottom-4 left-4 z-[400] max-w-[calc(100%-2rem)] rounded-full border border-border bg-card/90 px-4 py-2 text-xs shadow-sm backdrop-blur">
          {counts.isSuccess ? `${counts.data.length} desa/kelurahan punya UMKM terverifikasi` : 'Memuat data…'}
        </div>
      </div>
    </div>
  );
}
