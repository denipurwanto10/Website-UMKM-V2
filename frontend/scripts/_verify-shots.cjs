const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1440, height: 900 }, deviceScaleFactor: 1, locale: 'id-ID' });
  const page = await context.newPage();

  await page.goto('http://localhost:5173/', { waitUntil: 'networkidle' });
  await page.waitForTimeout(1800);
  console.log('HOME', await page.evaluate(() => {
    const imgs = [...document.images];
    return {
      images: imgs.length,
      loaded: imgs.filter((i) => i.complete && i.naturalWidth > 0).length,
      broken: imgs.filter((i) => i.complete && i.naturalWidth === 0).map((i) => i.src),
      mosaic: imgs.filter((i) => i.closest('.mosaic-tile')).map((i) => ({ src: i.src.split('/').pop(), w: i.naturalWidth, h: i.naturalHeight })),
    };
  }));

  await page.goto('http://localhost:5173/login', { waitUntil: 'networkidle' });
  await page.waitForTimeout(1000);
  console.log('LOGIN', await page.evaluate(() => ({
    form: !!document.querySelector('form'),
    inputs: [...document.querySelectorAll('input')].map((i) => ({ id: i.id, type: i.type })),
    h1: document.querySelector('h1')?.textContent,
  })));

  await page.goto('http://localhost:5173/peta', { waitUntil: 'networkidle' });
  await page.waitForTimeout(3000);
  console.log('PETA', await page.evaluate(() => ({
    map: !!document.querySelector('.leaflet-container'),
    mapSize: (() => { const r = document.querySelector('.leaflet-container')?.getBoundingClientRect(); return r ? [Math.round(r.width), Math.round(r.height)] : null; })(),
    tilesLoaded: document.querySelectorAll('.leaflet-tile-loaded').length,
    polygons: document.querySelectorAll('.leaflet-overlay-pane path').length,
    title: document.querySelector('h1')?.textContent,
  })));

  await browser.close();
})();
