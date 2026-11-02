$error.Clear()
# Kill any existing node processes on port 5173
Get-ChildItem -Path 'C:\laragon\www\umkm_re\frontend' -Filter '*.ps1' -Recurse | Remove-Item -Force -ErrorAction SilentlyContinue

# Start Vite dev server in the background
Start-Process powershell -ArgumentList "-NoProfile, -ExecutionPolicy Bypass, -Command `\"cd `\"C:\laragon\www\umkm_re\frontend`\" && `npx vite --port 5173 --force`\"" -Wait -RedirectStandardOutput "C:\laragon\www\umkm_re\frontend_vite.log" -RedirectStandardError "C:\laragon\www\umkm_re\frontend_vite_err.log"

# Wait for server to start
Start-Sleep -Seconds 5

# Check if server is running
$maxAttempts = 10
for ($i = 1; $i -le $maxAttempts; $i++) {
    try {
        $response = Invoke-WebRequest -Uri "http://localhost:5173" -Method Get -TimeoutSec 3
        if ($response.StatusCode -eq 200) {
            Write-Host "Server is running on port 5173"
            break
        }
    } catch {
        # Server not ready yet
    }
    Start-Sleep -Seconds 3
}

# Run Playwright to take screenshots
Write-Host "Running Playwright..."

$script = @"
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

  for (const [name, url] of Object.entries(urls)) {
    console.log(`Navigating to ${name}...`);
    await page.goto(url, { waitUntil: 'networkidle' });
    await page.waitForLoadState('networkidle');
    
    const filename = `/tmp/umkm_${name}.png`;
    await page.screenshot({ path: filename, viewport: { width: 1440, height: 900 } });
    console.log(`Saved ${filename}`);
  }

  await browser.close();
})();
"@

$scriptPath = "C:\laragon\www\umkm_re\playwright_screenshot.cjs"
$script | Out-File -FilePath $scriptPath -Encoding utf8

$nodeResult = node $scriptPath 2>&1
Write-Host "Node result: $nodeResult"

Write-Host "Done!"