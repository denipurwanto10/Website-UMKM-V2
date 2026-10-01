<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cari UMKM — Kabupaten Bandung</title>
  <link href="<?php echo base_url('assets/img/logo.png')?>" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --green-900: #0a3d1f; --green-800: #0d5128; --green-700: #117a3c;
      --green-600: #16a34a; --green-500: #22c55e; --green-400: #4ade80;
      --green-100: #dcfce7; --gold: #e8a317; --gold-light: #fbbf24;
      --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb;
      --gray-600: #4b5563; --gray-800: #1f2937;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); }

    .navbar-custom {
      position: fixed; top: 0; width: 100%; z-index: 1000;
      background: rgba(10,61,31,0.96); backdrop-filter: blur(12px);
      padding: 14px 0; transition: all 0.3s;
    }
    .navbar-custom.scrolled { padding: 10px 0; box-shadow: 0 4px 24px rgba(0,0,0,0.18); }
    .nav-link-custom {
      color: rgba(255,255,255,0.82) !important; font-weight: 500; font-size: 0.92rem;
      letter-spacing: 0.01em; padding: 6px 16px !important;
      border-radius: 6px; transition: all 0.2s; text-decoration: none; display: inline-block;
    }
    .nav-link-custom:hover, .nav-link-custom.active { color: #fff !important; background: rgba(255,255,255,0.12); }
    .btn-masuk {
      background: var(--gold); color: var(--green-900) !important;
      font-weight: 700; padding: 8px 22px !important; border-radius: 8px; font-size: 0.88rem;
      transition: all 0.2s; text-decoration: none; display: inline-block;
    }
    .btn-masuk:hover { background: var(--gold-light); transform: translateY(-1px); }
    .navbar-toggler { border: none; background: transparent; cursor: pointer; }
    .navbar-toggler:focus { box-shadow: none; }
    #mobileNav { display: none; background: rgba(10,61,31,0.98); padding: 12px 16px; border-top: 1px solid rgba(255,255,255,0.08); }

    /* PAGE HEADER */
    .page-header {
      background: linear-gradient(135deg, var(--green-900) 0%, var(--green-800) 100%);
      padding: 120px 0 56px; position: relative; overflow: hidden;
    }
    .page-header::after {
      content: ''; position: absolute; width: 400px; height: 400px;
      border-radius: 50%; border: 1px solid rgba(255,255,255,0.06);
      top: -120px; right: -80px;
    }
    .page-header h1 { font-family: 'DM Serif Display', serif; color: white; font-size: clamp(1.8rem,4vw,2.6rem); margin-bottom: 8px; }
    .page-header p { color: rgba(255,255,255,0.65); font-size: 0.95rem; margin-bottom: 0; }
    .breadcrumb-custom { color: rgba(255,255,255,0.55); font-size: 0.87rem; }
    .breadcrumb-custom a { color: rgba(255,255,255,0.7); text-decoration: none; }
    .breadcrumb-custom a:hover { color: var(--green-400); }
    .btn-back {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,0.12); color: white; border: 1px solid rgba(255,255,255,0.18);
      padding: 8px 18px; border-radius: 8px; font-size: 0.88rem; font-weight: 500;
      text-decoration: none; transition: all 0.2s; white-space: nowrap;
    }
    .btn-back:hover { background: rgba(255,255,255,0.2); color: white; }

    /* FILTER BAR */
    .filter-bar {
      background: white; border-radius: 16px; padding: 24px;
      box-shadow: 0 2px 16px rgba(0,0,0,0.07); margin-bottom: 32px;
    }
    .filter-bar label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--gray-600); margin-bottom: 6px; display: block; }
    .filter-input, .filter-select {
      width: 100%; padding: 10px 14px; border: 1.5px solid var(--gray-200);
      border-radius: 10px; font-size: 0.9rem; font-family: 'Plus Jakarta Sans', sans-serif;
      transition: border 0.2s; outline: none; background: var(--gray-50); color: var(--gray-800);
    }
    .filter-input:focus, .filter-select:focus { border-color: var(--green-600); background: white; }
    .filter-select { appearance: none; cursor: pointer; }
    .btn-cari {
      background: var(--green-900); color: white; font-weight: 600;
      padding: 10px 26px; border-radius: 10px; font-size: 0.9rem; border: none;
      display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; cursor: pointer;
    }
    .btn-cari:hover { background: var(--green-700); color: white; transform: translateY(-1px); }
    .btn-reset {
      background: white; color: var(--gray-600); font-weight: 600;
      padding: 10px 26px; border-radius: 10px; font-size: 0.9rem;
      border: 1.5px solid var(--gray-200); text-decoration: none;
      display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;
    }
    .btn-reset:hover { border-color: var(--green-600); color: var(--green-700); }

    /* UMKM CARDS */
    .umkm-card {
      border-radius: 16px; overflow: hidden; background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.3s; height: 100%;
    }
    .umkm-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.12); }
    .umkm-card img { width: 100%; height: 220px; object-fit: cover; background: var(--gray-100); }
    .umkm-card-body { padding: 16px 18px 20px; }
    .umkm-badge {
      display: inline-block; background: var(--green-100); color: var(--green-700);
      font-size: 0.71rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;
      text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 9px;
    }
    .umkm-card-title { font-size: 0.98rem; font-weight: 700; color: var(--gray-800); margin-bottom: 4px; }
    .umkm-card-brand { font-size: 0.83rem; color: var(--gray-600); margin-bottom: 0; }
    .umkm-card-link { text-decoration: none; display: block; color: inherit; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 72px 20px; background: white; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.06); }
    .empty-state i { font-size: 3rem; color: var(--gray-200); }
    .empty-state h5 { font-weight: 700; color: var(--gray-800); margin-top: 16px; }
    .empty-state p { color: var(--gray-600); margin: 8px auto 0; font-size: 0.92rem; max-width: 420px; }

    /* FOOTER (sama seperti index.php) */
    footer { background: var(--green-900); color: rgba(255,255,255,0.7); padding: 64px 0 32px; }
    footer .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: white; }
    footer .footer-desc { font-size: 0.88rem; line-height: 1.75; margin-top: 12px; max-width: 300px; }
    footer h6 { color: rgba(255,255,255,0.5); font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px; }
    footer a { color: rgba(255,255,255,0.65); text-decoration: none; font-size: 0.88rem; transition: color 0.2s; display: block; margin-bottom: 8px; }
    footer a:hover { color: var(--green-400); }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 48px; padding-top: 24px; font-size: 0.82rem; text-align: center; }
    .social-link {
      width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,0.08);
      display: inline-flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.65);
      text-decoration: none; transition: all 0.2s; margin-right: 6px;
    }
    .social-link:hover { background: var(--green-700); color: white; }

    @media(max-width:768px) {
      .page-header { padding: 108px 0 44px; }
      .filter-bar { padding: 20px 16px; }
      .umkm-card img { height: 190px; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom" id="mainNav">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="<?php echo site_url('/')?>" class="d-flex align-items-center gap-3 text-decoration-none">
      <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo UMKM Kabupaten Bandung" style="width:48px;height:48px;object-fit:contain;" loading="lazy" onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/logo.png'); ?>'">
      <span style="color:white;font-weight:700;font-size:0.95rem;line-height:1.2;">UMKM<br><span style="color:rgba(255,255,255,0.65);font-weight:400;font-size:0.8rem;">Kabupaten Bandung</span></span>
    </a>
    <button class="navbar-toggler d-xl-none" type="button" onclick="toggleMobileNav()" aria-label="Buka menu navigasi">
      <i class="bi bi-list" style="color:white;font-size:1.5rem;"></i>
    </button>
    <div class="d-none d-xl-flex align-items-center gap-1" id="navLinks">
      <a href="<?php echo site_url('/')?>" class="nav-link-custom">Home</a>
      <a href="<?= site_url('/#kategori')?>" class="nav-link-custom">Kategori</a>
      <a href="<?= site_url('/#produk')?>" class="nav-link-custom">UMKM</a>
      <a href="<?php echo site_url('peta')?>" class="nav-link-custom">Peta</a>
      <a href="<?php echo site_url('cari')?>" class="nav-link-custom active">Cari</a>
      <a href="<?php echo site_url('auth/form_login')?>" class="nav-link-custom btn-masuk ms-2">Masuk</a>
    </div>
  </div>
  <div id="mobileNav">
    <a href="<?php echo site_url('/')?>" class="nav-link-custom d-block py-2">Home</a>
    <a href="<?= site_url('/#kategori')?>" class="nav-link-custom d-block py-2">Kategori</a>
    <a href="<?= site_url('/#produk')?>" class="nav-link-custom d-block py-2">UMKM</a>
    <a href="<?php echo site_url('peta')?>" class="nav-link-custom d-block py-2">Peta</a>
    <a href="<?php echo site_url('cari')?>" class="nav-link-custom d-block py-2 active">Cari</a>
    <a href="<?php echo site_url('auth/form_login')?>" class="btn-masuk d-inline-block mt-2">Masuk</a>
  </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="container" style="position:relative;z-index:2;">
    <div class="breadcrumb-custom mb-3">
      <a href="<?= site_url('/')?>">Home</a> <span class="mx-2">›</span> Cari UMKM
    </div>
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <h1 class="mb-0">Cari UMKM</h1>
        <p class="mt-2">Temukan usaha berdasarkan nama, merek, atau kategori produk.</p>
      </div>
      <a href="<?= site_url('/')?>" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

<!-- MAIN -->
<main style="padding: 48px 0 80px;">
  <div class="container">
    <?php
      $q_nama  = isset($_GET['nama_usaha']) ? trim($_GET['nama_usaha']) : '';
      $q_merek = isset($_GET['nama_merek_produk']) ? trim($_GET['nama_merek_produk']) : '';
      $q_kat   = isset($_GET['kategori_produk']) ? trim($_GET['kategori_produk']) : '';
      $hasil   = (isset($umkm) && is_array($umkm)) ? $umkm : [];
    ?>

    <!-- Filter -->
    <div class="filter-bar" data-aos="fade-up">
      <form action="<?php echo site_url('cari'); ?>" method="get">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="nama_usaha">Nama Usaha</label>
            <input type="text" id="nama_usaha" name="nama_usaha" class="filter-input" placeholder="Cari nama usaha..." value="<?php echo htmlspecialchars($q_nama, ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div class="col-md-4">
            <label for="nama_merek_produk">Merek Produk</label>
            <input type="text" id="nama_merek_produk" name="nama_merek_produk" class="filter-input" placeholder="Cari merek produk..." value="<?php echo htmlspecialchars($q_merek, ENT_QUOTES, 'UTF-8'); ?>">
          </div>
          <div class="col-md-4">
            <label for="kategori_produk">Kategori Produk</label>
            <select id="kategori_produk" name="kategori_produk" class="filter-select">
              <option value="" <?php echo ($q_kat === '') ? 'selected' : ''; ?>>Semua Kategori</option>
              <option value="Kuliner" <?php echo (strcasecmp($q_kat, 'Kuliner') === 0) ? 'selected' : ''; ?>>Kuliner</option>
              <option value="Fashion" <?php echo (strcasecmp($q_kat, 'Fashion') === 0) ? 'selected' : ''; ?>>Fashion</option>
              <option value="Kerajinan" <?php echo (strcasecmp($q_kat, 'Kerajinan') === 0) ? 'selected' : ''; ?>>Kerajinan</option>
            </select>
          </div>
        </div>
        <div class="d-flex gap-2 flex-wrap mt-4">
          <button type="submit" class="btn-cari"><i class="bi bi-search"></i> Cari</button>
          <a href="<?php echo site_url('cari'); ?>" class="btn-reset"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
      </form>
    </div>

    <!-- Result count -->
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
      <p class="mb-0" style="color:var(--gray-600);font-size:0.9rem;">
        Menampilkan <strong><?php echo count($hasil); ?></strong> UMKM
        <?php if ($q_nama !== '' || $q_merek !== '' || $q_kat !== ''): ?>
          <span class="text-muted">untuk pencarian aktif</span>
        <?php endif; ?>
      </p>
    </div>

    <!-- Grid -->
    <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
      <?php if (!empty($hasil)): ?>
        <?php foreach ($hasil as $umkm_item):
          if (!is_array($umkm_item)) { continue; }
          $nama  = isset($umkm_item['nama_usaha']) ? $umkm_item['nama_usaha'] : 'UMKM';
          $merek = isset($umkm_item['nama_merek_produk']) ? $umkm_item['nama_merek_produk'] : '';
          $kat   = isset($umkm_item['kategori_produk']) ? $umkm_item['kategori_produk'] : '-';
          $id    = isset($umkm_item['id']) ? $umkm_item['id'] : '';
          $img   = !empty($umkm_item['photo'])
                   ? base_url('uploads/umkm/' . $umkm_item['photo'])
                   : base_url('assets/img/logo.png');
        ?>
          <div class="col-sm-6 col-lg-4 col-xl-3">
            <a href="<?php echo ($id !== '') ? site_url('detail/' . $id) : site_url('all'); ?>" class="umkm-card-link">
              <div class="umkm-card">
                <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/logo.png'); ?>'">
                <div class="umkm-card-body">
                  <span class="umkm-badge"><?php echo htmlspecialchars($kat, ENT_QUOTES, 'UTF-8'); ?></span>
                  <h5 class="umkm-card-title"><?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></h5>
                  <?php if ($merek !== ''): ?>
                    <p class="umkm-card-brand"><?php echo htmlspecialchars($merek, ENT_QUOTES, 'UTF-8'); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="empty-state">
            <i class="bi bi-search"></i>
            <h5>Tidak ada UMKM yang sesuai dengan pencarian Anda</h5>
            <p>Coba gunakan kata kunci lain, pilih kategori berbeda, atau <a href="<?php echo site_url('cari'); ?>" style="display:inline;color:var(--green-700);font-weight:700;">atur ulang filter</a> untuk melihat semua data.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <div class="d-flex align-items-center gap-3 mb-3">
          <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo" style="width:44px;height:44px;object-fit:contain;" loading="lazy" onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/logo.png'); ?>'">
          <span class="brand-name">UMKM Kab. Bandung</span>
        </div>
        <p class="footer-desc">Portal resmi UMKM Kabupaten Bandung — mendorong pertumbuhan ekonomi lokal yang mandiri, inovatif, dan berdaya saing tinggi.</p>
        <div class="mt-4">
          <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
          <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
          <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h6>Navigasi</h6>
        <a href="<?php echo site_url('/')?>">Home</a>
        <a href="<?= site_url('/#kategori')?>">Kategori</a>
        <a href="<?= site_url('/#produk')?>">UMKM</a>
        <a href="<?php echo site_url('peta')?>">Peta</a>
        <a href="<?php echo site_url('all')?>">Semua UMKM</a>
      </div>
      <div class="col-6 col-lg-2">
        <h6>Layanan</h6>
        <a href="#">Pendaftaran</a>
        <a href="#">Profil Usaha</a>
        <a href="#">Data UMKM</a>
        <a href="#">Peta Sebaran</a>
      </div>
      <div class="col-lg-3">
        <h6>Kontak</h6>
        <p style="font-size:0.88rem;line-height:1.75;">Dinas Perdagangan dan Perindustrian<br>Kabupaten Bandung, Jawa Barat</p>
        <a href="mailto:info@bandungkab.go.id" style="display:inline-block;margin-top:8px;"><i class="bi bi-envelope me-2"></i>info@bandungkab.go.id</a>
      </div>
    </div>
    <div class="footer-bottom">
      © <?php echo date('Y'); ?> UMKM Kabupaten Bandung — Dinas Perdagangan &amp; Perindustrian
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  if (window.AOS) { AOS.init({ duration: 700, once: true, offset: 60 }); }
  window.addEventListener('scroll', function() {
    var nav = document.getElementById('mainNav');
    if (nav) { nav.classList.toggle('scrolled', window.scrollY > 30); }
  });
  function toggleMobileNav() {
    var nav = document.getElementById('mobileNav');
    if (!nav) { return; }
    nav.style.display = (nav.style.display === 'none' || nav.style.display === '') ? 'block' : 'none';
  }
</script>
</body>
</html>
