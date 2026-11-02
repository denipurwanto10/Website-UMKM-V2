/* Capture halaman publik + dashboard setelah login 1440x900 untuk dokumentasi.
 * Jalankan dari folder frontend: node scripts/capture-screenshots.cjs
 * 
 * Catatan: 
 * - Halaman utama dan peta tidak membutuhkan login.
 * - Dashboard membutuhkan autentikasi. Script akan login dengan akun admin
   menggunakan password "admin123" (sudah di-set di database skripsi), baru
   mengarahkan ke /dashboard untuk screenshot.
 */
const path = require('path');
const fs = require('fs');
const { chromium } = require('playwright');

const OUT_DIR = path.resolve(__dirname, '../../screenshots');
const BASE = process.env.SCREENSHOT_BASE ?? 'http://localhost:5173';

const PAGES = [
  { file: '01-halaman-utama-1440x900.png', path: '/', label: 'Halaman utama' },
  // Dashboard membutuhkan login — gunakan akun admin dengan password admin123
  { file: '02-dashboard-admin-1440x900.png', path: '/dashboard', label: 'Dashboard admin (post-login)' },
  { file: '03-peta-1440x900.png', path: '/peta', label: 'Peta sebaran' },
];

async function settle(page) {
  await page.evaluate(() => document.fonts?.ready);
  await page.waitForFunction(
    () => Array.from(document.images).every((img) => img.complete),
    undefined,
    { timeout: 30_000 },
  ).catch(() => {});
  await page.waitForTimeout(1_800);
}

// Login ke aplikasi dengan akun admin
async function doLogin(page, base) {
  await page.goto(`${base}/login`, { waitUntil: 'networkidle', timeout: 30_000 });
  await page.fill('input[id="username"]', 'admin');
  await page.fill('input[id="password"]', 'admin123');
  await page.click('button[type="submit"]');
  await page.waitForNavigation({ url: '/dashboard', waitUntil: 'networkidle', timeout: 15_000 }).catch(() => {
    // Arahannya bisa ke halaman lain jika login gagal, tapi kita lanjutkan saja
  });
  await page.waitForTimeout(1_000);
  // Verifikasi login sukses
  const url = page.url();
  if (!url.includes('/dashboard')) {
    console.log(`  ⚠  Login gagal, URL: ${url} — tetap lanjut capture dashboard state apa adanya`);
  }
}

(async () => {
  fs.mkdirSync(OUT_DIR, { recursive: true });
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 1440, height: 900 },
    deviceScaleFactor: 1,
    locale: 'id-ID',
    timezoneId: 'Asia/Jakarta',
    colorScheme: 'light',
  });
  const page = await context.newPage();
  page.on('console', (msg) => {
    if (msg.type() === 'error') console.log(`  [browser] ${msg.text()}`);
  });

  // 1. Login terlebih dahulu
  console.log('=> Melakukan login sebagai admin...');
  await doLogin(page, BASE);
  await page.waitForTimeout(2_000);

  for (const target of PAGES) {
    console.log(`→ ${target.label}: ${BASE}${target.path}`);

    if (target.path === '/dashboard') {
      // Pastikan sudah di dashboard
      await page.goto(`${BASE}/dashboard`, { waitUntil: 'networkidle', timeout: 60_000 });
      await settle(page);
      await page.waitForTimeout(2_000);
    } else if (target.path === '/peta') {
      await page.goto(`${BASE}${target.path}`, { waitUntil: 'networkidle', timeout: 60_000 });
      await settle(page);
      await page.waitForFunction(
        () => document.querySelectorAll('.leaflet-tile-loaded').length > 0,
        undefined,
        { timeout: 12_000 },
      ).catch(() => console.log('  (tile peta belum termuat, lanjutkan)'));
      await page.waitForTimeout(1_200);
      await page.evaluate(() => window.scrollTo(0, 0));
      await page.waitForTimeout(250);
    } else {
      // Halaman publik (home) — tidak perlu login
      await page.goto(`${BASE}${target.path}`, { waitUntil: 'networkidle', timeout: 60_000 });
      await settle(page);
    }

    // Scroll ke atas dan capture
    await page.evaluate(() => window.scrollTo(0, 0));
    await page.waitForTimeout(250);
    const out = path.join(OUT_DIR, target.file);
    await page.screenshot({ path: out, fullPage: false });
    console.log(`  saved ${path.relative(process.cwd(), out)}`);
  }

  await browser.close();
  console.log('Selesai.');
})().catch((err) => {
  console.error(err);
  process.exit(1);
});