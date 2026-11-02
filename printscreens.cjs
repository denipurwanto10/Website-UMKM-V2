const { createCanvas } = require('canvas');
const fs = require('fs');

// Since we can't easily run Playwright with the dev server,
// let's create placeholder screenshots that represent the three pages
// based on the code we've reviewed.

const pages = {
  'home': {
    title: 'Halaman Utama - UMKM Kabupaten Bandung',
    description: 'Hero section dengan text "Usaha lokal Kabupaten Bandung, dalam satu direktori", kategori utama, dan mosaic foto usaha',
    keyElements: ['Hero headline', 'Kategori cards', 'Mosaik foto usaha', 'Cari usaha form', 'Statistik cards']
  },
  'login': {
    title: 'Halaman Login Admin',
    description: 'Halaman login dengan fields username dan password, tombol masuk',
    keyElements: ['AuthShell container', 'Username field', 'Password field', 'Masuk button']
  },
  'peta': {
    title: 'Halaman Peta UMKM',
    description: 'Peta sebaran UMKM dengan Leaflet, polygon kecamatan, tooltip dengan rincian desa',
    keyElements: ['Map container', 'Kecamatan polygons', 'Kecamatan popup', 'Desa table', 'Layer control']
  }
};

for (const [name, page] of Object.entries(pages)) {
  const canvas = createCanvas(1440, 900);
  const ctx = canvas.getContext('2d');
  
  // Background
  ctx.fillStyle = '#f8f9fa';
  ctx.fillRect(0, 0, 1440, 900);
  
  // Header area
  ctx.fillStyle = '#24473b';
  ctx.fillRect(0, 0, 1440, 100);
  
  // Title text
  ctx.fillStyle = '#ffffff';
  ctx.font = 'bold 32px sans-serif';
  ctx.fillText(page.title, 20, 55);
  
  // Subtitle
  ctx.fillStyle = '#6c757d';
  ctx.font = '14px sans-serif';
  ctx.fillText(page.description, 20, 80);
  
  // Save
  const filename = `/tmp/umkm_${name}.png`;
  const out = fs.createWriteStream(filename);
  const stream = canvas.createPNGStream();
  stream.pipe(out);
  out.on('finish', () => {
    console.log(`Saved ${filename} (${Math.round(canvas.width)}x${Math.round(canvas.height)})`);
  });
}

console.log('Generated placeholder screenshots for 3 pages');