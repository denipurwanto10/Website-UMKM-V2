// Sekali pakai: ekstrak villagePolygons dari application/views/peta.php
// menjadi JSON statis agar identik dengan tampilan CI3.
import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const src = readFileSync(join(root, 'application/views/peta.php'), 'utf8');

const nameRe = /"([A-Za-z'\- ]+)":\s*\{/g;
const starts = [];
let nm;
while ((nm = nameRe.exec(src)) !== null) {
  starts.push({ name: nm[1], index: nm.index + nm[0].length });
}

const out = {};
const seen = {};
for (let i = 0; i < starts.length; i++) {
  const seg = src.slice(starts[i].index, i + 1 < starts.length ? starts[i + 1].index : starts[i].index + 300000);
  // Batasi segmen sampai penutup blok kecamatan: pola "\n    }," atau "\n     },"
  const end = seg.search(/\n\s{4,5}\},/);
  const block = end === -1 ? seg.slice(0, 200000) : seg.slice(0, end);
  const color = (block.match(/color:\s*'([^']*)'/) || [])[1] ?? '';
  const fillColor = (block.match(/fillColor:\s*'([^']*)'/) || [])[1] ?? '';
  const coords = [];
  const pairRe = /\[\s*(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)\s*\]/g;
  let p;
  while ((p = pairRe.exec(block)) !== null) {
    coords.push([parseFloat(p[1]), parseFloat(p[2])]);
  }
  if (coords.length > 0) {
    // Nama kecamatan bisa ganda (typo/duplikat di view) — simpan semua, jangan timpa
    seen[starts[i].name] = (seen[starts[i].name] ?? 0) + 1;
    const key = seen[starts[i].name] > 1 ? `${starts[i].name} (${seen[starts[i].name]})` : starts[i].name;
    out[key] = { coordinates: coords, color, fillColor };
  }
}
const count = Object.keys(out).length;

const dest = join(root, 'frontend/public/data/kecamatan-polygons.json');
mkdirSync(dirname(dest), { recursive: true });
writeFileSync(dest, JSON.stringify(out));
const kb = Math.round(Buffer.byteLength(JSON.stringify(out)) / 1024);
console.log(`OK: ${count} kecamatan -> ${dest} (${kb} KB)`);
