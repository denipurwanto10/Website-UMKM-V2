# Verifikasi profesional: responsif + bug/error + struktur
$php = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
$fail = 0
Write-Output "===== 1. LINT PHP ====="
foreach ($f in Get-ChildItem application/controllers, application/config, application/views -Recurse -Include *.php) {
  $r = & $php -l $f.FullName 2>&1
  if ($r -notmatch 'No syntax errors') { Write-Output ("FAIL " + $f.FullName + " => " + ($r -join ' ')); $fail++ }
}
Write-Output "lint-failures=$fail"

Write-Output "===== 2. STRUKTUR ADMIN ====="
$nested = (Select-String -Path application/views/admin/*.php -Pattern '<!DOCTYPE html>' | Measure-Object).Count
Write-Output "doctype-count (expect 0, sidebar+footer fragmen): $nested"
$oldInc = (Select-String -Path application/views/admin/*.php -Pattern "include\('sidebar\.php'\)" | Measure-Object).Count
Write-Output "old-include-sidebar (expect 0): $oldInc"
$hack = (Select-String -Path application/views/admin/*.php, assets/css/admin.css -Pattern 'margin-bottom: -380px' | Measure-Object).Count
Write-Output "margin-hack (expect 0): $hack"
$nullSpinner = (Select-String -Path application/views -Pattern 'getElementById\("loading-spinner"\)\.style' -Recurse | Measure-Object).Count
Write-Output "unguarded-spinner (expect 0): $nullSpinner"
Write-Output "--- div balance ---"
foreach ($f in Get-ChildItem application/views/admin/*.php) {
  $t = Get-Content $f.FullName -Raw
  $o = ([regex]::Matches($t,'<div[\s>]')).Count; $c = ([regex]::Matches($t,'</div>')).Count
  if ($o -ne $c) { Write-Output ("UNBALANCED " + $f.Name + " open=$o close=$c") }
}

Write-Output "===== 3. ROUTES vs CONTROLLER ====="
$routes = Get-Content application/config/routes.php -Raw
foreach ($m in [regex]::Matches($routes,"route\['([^']+)'\]\s*=\s*'([^']+)'")) {
  $target = $m.Groups[2].Value
  if ($target -match '^([A-Za-z]+)/(\w+)') {
    $ctrl = $m.Groups[1].Value; $meth = $matches[2]
    $cf = "application/controllers/$ctrl.php"
    if (!(Test-Path $cf)) { Write-Output ("MISSING-CTRL " + $m.Groups[1].Value + " for route " + $m.Groups[1].Value) }
    else {
      $src = Get-Content $cf -Raw
      if ($src -notmatch ("function " + $meth + "\s*\(")) { Write-Output ("MISSING-METHOD $ctrl::$meth (route " + $m.Groups[1].Value + ")") }
    }
  }
}

Write-Output "===== 4. HALAMAN PUBLIK ====="
$badAction = (Select-String -Path application/views/cari.php -Pattern "auth/cari" | Measure-Object).Count
Write-Output "auth/cari refs in cari.php (expect 0): $badAction"
$banner = (Select-String -Path application/views/peta.php -Pattern 'main-banner2|id="preloader"' | Measure-Object).Count
Write-Output "dead-banner/preloader in peta.php (expect 0): $banner"
foreach ($p in @('all.php','detail.php','cari.php','peta.php','index.php')) {
  $t = Get-Content ("application/views/" + $p) -Raw
  $has = if ($t -match 'toggleMobileNav') { 'YES' } else { 'NO' }
  Write-Output "$p toggleMobileNav=$has"
}
Write-Output "===== DONE ====="
