const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: { width: 1440, height: 900 },
    deviceScaleFactor: 1,
  });
  const page = await context.newPage();

  const urls = {
    'home': 'http://localhost:5173',
    'login': 'http://localhost:5173/login',
    'peta': 'http://localhost:5173/peta',
  };

  const captures = [];

  for (const [name, url] of Object.entries(urls)) {
    console.log(`Navigating to ${name}...`);
    await page.goto(url, { waitUntil: 'networkidle' });
    await page.waitForLoadState('networkidle');
    
    // Take screenshot
    const filename = `/tmp/umkm_${name}.png`;
    await page.screenshot({ path: filename, viewport: { width: 1440, height: 900 } });
    console.log(`Saved ${filename}`);
    captures.push({ name, filename });
  }

  await browser.close();
  console.log('Done! Screenshots captured:');
  for (const c of captures) {
    console.log(`  - ${c.name}: ${c.filename}`);
  }
})().catch(err => {
  console.error('Error:', err);
  process.exit(1);
});