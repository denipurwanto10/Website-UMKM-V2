<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UMKM Kabupaten Bandung</title>
  <link href="<?php echo base_url('assets/img/logo.png')?>" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/glightbox/css/glightbox.min.css')?>" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --green-900: #0a3d1f;
      --green-800: #0d5128;
      --green-700: #117a3c;
      --green-600: #16a34a;
      --green-500: #22c55e;
      --green-400: #4ade80;
      --green-100: #dcfce7;
      --gold: #e8a317;
      --gold-light: #fbbf24;
      --white: #ffffff;
      --gray-50: #f9fafb;
      --gray-100: #f3f4f6;
      --gray-200: #e5e7eb;
      --gray-600: #4b5563;
      --gray-800: #1f2937;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); overflow-x: hidden; }

    /* NAVBAR */
    .navbar-custom {
      position: fixed; top: 0; width: 100%; z-index: 1000;
      background: rgba(10,61,31,0.96); backdrop-filter: blur(12px);
      padding: 14px 0; transition: all 0.3s;
    }
    .navbar-custom.scrolled { padding: 10px 0; box-shadow: 0 4px 24px rgba(0,0,0,0.18); }
    .navbar-brand img { width: 52px; height: 52px; object-fit: contain; }
    .nav-link-custom {
      color: rgba(255,255,255,0.82) !important; font-weight: 500;
      font-size: 0.92rem; letter-spacing: 0.01em; padding: 6px 16px !important;
      border-radius: 6px; transition: all 0.2s;
    }
    .nav-link-custom:hover, .nav-link-custom.active { color: #fff !important; background: rgba(255,255,255,0.12); }
    .btn-masuk {
      background: var(--gold); color: var(--green-900) !important;
      font-weight: 700; padding: 8px 22px !important; border-radius: 8px;
      font-size: 0.88rem; transition: all 0.2s;
    }
    .btn-masuk:hover { background: var(--gold-light); transform: translateY(-1px); }
    .navbar-toggler { border: none; color: white; }
    .navbar-toggler:focus { box-shadow: none; }

    /* HERO */
    .hero-section {
      min-height: 100vh;
      background: linear-gradient(135deg, var(--green-900) 0%, var(--green-800) 55%, #0f5c30 100%);
      display: flex; align-items: center; position: relative; overflow: hidden;
      padding-top: 80px;
    }
    .hero-section::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(ellipse at 70% 50%, rgba(22,163,74,0.18) 0%, transparent 65%);
    }
    .hero-section::after {
      content: ''; position: absolute;
      width: 600px; height: 600px; border-radius: 50%;
      background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);
      top: -120px; right: -100px;
    }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
      color: var(--green-400); font-size: 0.82rem; font-weight: 600;
      padding: 6px 14px; border-radius: 20px; letter-spacing: 0.04em;
      text-transform: uppercase; margin-bottom: 20px;
    }
    .hero-badge span { width: 6px; height: 6px; background: var(--green-500); border-radius: 50%; display: inline-block; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1}50%{opacity:0.4} }
    .hero-title {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2.4rem, 5vw, 3.8rem);
      color: #fff; line-height: 1.12; margin-bottom: 20px;
    }
    .hero-title span { color: var(--green-400); }
    .hero-desc { color: rgba(255,255,255,0.72); font-size: 1.02rem; line-height: 1.75; max-width: 520px; margin-bottom: 36px; }
    .btn-hero-primary {
      background: var(--gold); color: var(--green-900); font-weight: 700;
      padding: 14px 32px; border-radius: 10px; font-size: 0.96rem;
      text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
      transition: all 0.2s; border: none;
    }
    .btn-hero-primary:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(232,163,23,0.35); color: var(--green-900); }
    .btn-hero-secondary {
      background: transparent; color: white; font-weight: 600;
      padding: 14px 28px; border-radius: 10px; font-size: 0.96rem;
      text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
      border: 1.5px solid rgba(255,255,255,0.3); transition: all 0.2s;
    }
    .btn-hero-secondary:hover { background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.6); }
    .hero-logo-card {
      background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
      border-radius: 24px; padding: 40px; text-align: center; backdrop-filter: blur(8px);
      position: relative; z-index: 2;
    }
    .hero-logo-card img { width: 160px; animation: float 4s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-14px)} }
    .stats-strip {
      background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
      border-radius: 16px; padding: 20px 30px; margin-top: 40px;
      display: flex; gap: 36px; flex-wrap: wrap;
    }
    .stat-item { text-align: center; }
    .stat-number { font-size: 1.7rem; font-weight: 800; color: var(--green-400); font-family: 'DM Serif Display', serif; }
    .stat-label { font-size: 0.76rem; color: rgba(255,255,255,0.55); font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }

    /* SECTION COMMON */
    .section-label {
      font-size: 0.76rem; font-weight: 700; letter-spacing: 0.1em;
      text-transform: uppercase; color: var(--green-600); margin-bottom: 10px;
    }
    .section-title {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.6rem); color: var(--gray-800);
      line-height: 1.2; margin-bottom: 14px;
    }
    .section-desc { color: var(--gray-600); font-size: 1rem; line-height: 1.7; max-width: 560px; }

    /* KATEGORI */
    .kategori-section { padding: 96px 0; background: white; }
    .kategori-card {
      border-radius: 20px; padding: 36px 28px; border: 1.5px solid var(--gray-200);
      transition: all 0.3s; cursor: pointer; background: white; height: 100%; position: relative; overflow: hidden;
    }
    .kategori-card::before {
      content: ''; position: absolute; inset: 0; border-radius: 20px;
      background: linear-gradient(135deg, var(--green-900), var(--green-700));
      opacity: 0; transition: opacity 0.3s;
    }
    .kategori-card:hover::before { opacity: 1; }
    .kategori-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(10,61,31,0.2); border-color: transparent; }
    .kategori-card:hover .kategori-icon, .kategori-card:hover .kategori-title, .kategori-card:hover .kategori-desc, .kategori-card:hover .kategori-arrow { color: white !important; }
    .kategori-card:hover .kategori-icon-bg { background: rgba(255,255,255,0.15); }
    .kategori-card > * { position: relative; z-index: 1; }
    .kategori-icon-bg {
      width: 56px; height: 56px; border-radius: 14px;
      background: var(--green-100); display: flex; align-items: center; justify-content: center;
      margin-bottom: 20px; transition: all 0.3s;
    }
    .kategori-icon { font-size: 1.5rem; color: var(--green-700); transition: all 0.3s; }
    .kategori-title { font-size: 1.2rem; font-weight: 700; color: var(--gray-800); margin-bottom: 10px; transition: all 0.3s; }
    .kategori-desc { font-size: 0.9rem; color: var(--gray-600); line-height: 1.65; transition: all 0.3s; }
    .kategori-arrow { color: var(--green-600); font-size: 1.1rem; margin-top: 20px; display: block; transition: all 0.3s; }

    /* STATISTIK */
    .stats-section {
      padding: 72px 0;
      background: linear-gradient(135deg, var(--green-900), var(--green-800));
    }
    .stat-card {
      text-align: center; padding: 28px 20px;
      border-right: 1px solid rgba(255,255,255,0.1);
    }
    .stat-card:last-child { border-right: none; }
    .stat-card .number { font-family: 'DM Serif Display', serif; font-size: 2.8rem; color: var(--green-400); line-height: 1; }
    .stat-card .label { font-size: 0.85rem; color: rgba(255,255,255,0.65); font-weight: 500; margin-top: 6px; }
    .stat-card .icon { font-size: 1.6rem; color: rgba(255,255,255,0.3); margin-bottom: 10px; }

    /* PORTFOLIO / UMKM GRID */
    .umkm-section { padding: 96px 0; background: var(--gray-50); }
    .umkm-card {
      border-radius: 16px; overflow: hidden; background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      transition: all 0.3s; height: 100%;
    }
    .umkm-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.12); }
    .umkm-card img { width: 100%; height: 220px; object-fit: cover; }
    .umkm-card-body { padding: 18px 20px 20px; }
    .umkm-badge {
      display: inline-block; background: var(--green-100); color: var(--green-700);
      font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;
      text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;
    }
    .umkm-card-title { font-size: 1rem; font-weight: 700; color: var(--gray-800); margin-bottom: 0; }
    .umkm-card-link { text-decoration: none; display: block; color: inherit; }
    .btn-lihat-semua {
      background: var(--green-900); color: white; font-weight: 600;
      padding: 12px 28px; border-radius: 10px; font-size: 0.92rem;
      text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
      transition: all 0.2s; border: none;
    }
    .btn-lihat-semua:hover { background: var(--green-700); color: white; transform: translateY(-2px); }

    /* FOOTER */
    footer {
      background: var(--green-900); color: rgba(255,255,255,0.7);
      padding: 64px 0 32px;
    }
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

    /* SCROLL TOP */
    #scroll-top {
      position: fixed; bottom: 28px; right: 28px; width: 44px; height: 44px;
      background: var(--green-700); color: white; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      text-decoration: none; box-shadow: 0 4px 16px rgba(0,0,0,0.2);
      opacity: 0; transition: all 0.3s; font-size: 1.1rem;
    }
    #scroll-top.show { opacity: 1; }
    #scroll-top:hover { background: var(--green-600); color: white; transform: translateY(-2px); }

    @media(max-width:768px) {
      .hero-section { min-height: auto; padding: 100px 0 64px; }
      .hero-logo-card { display: none; }
      .stats-strip { gap: 20px; justify-content: center; }
      .stat-card { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 20px; }
      .stat-card:last-child { border-bottom: none; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom" id="mainNav">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="<?php echo site_url('/')?>" class="d-flex align-items-center gap-3 text-decoration-none">
      <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo" class="navbar-brand-img" style="width:48px;height:48px;object-fit:contain;">
      <span style="color:white;font-weight:700;font-size:0.95rem;line-height:1.2;">UMKM<br><span style="color:rgba(255,255,255,0.65);font-weight:400;font-size:0.8rem;">Kabupaten Bandung</span></span>
    </a>
    <button class="navbar-toggler d-xl-none" type="button" onclick="toggleMobileNav()">
      <i class="bi bi-list" style="color:white;font-size:1.5rem;"></i>
    </button>
    <div class="d-none d-xl-flex align-items-center gap-1" id="navLinks">
      <a href="<?php echo site_url('/')?>" class="nav-link-custom active">Home</a>
      <a href="<?= site_url('/#kategori')?>" class="nav-link-custom">Kategori</a>
      <a href="<?= site_url('/#produk')?>" class="nav-link-custom">UMKM</a>
      <a href="<?php echo site_url('peta')?>" class="nav-link-custom">Peta</a>
      <a href="<?php echo site_url('auth/form_login')?>" class="nav-link-custom btn-masuk ms-2">Masuk</a>
    </div>
  </div>
  <!-- Mobile menu -->
  <div id="mobileNav" style="display:none; background:rgba(10,61,31,0.98); padding:12px 16px; border-top:1px solid rgba(255,255,255,0.08);">
    <a href="<?php echo site_url('/')?>" class="nav-link-custom d-block py-2">Home</a>
    <a href="<?= site_url('/#kategori')?>" class="nav-link-custom d-block py-2">Kategori</a>
    <a href="<?= site_url('/#produk')?>" class="nav-link-custom d-block py-2">UMKM</a>
    <a href="<?php echo site_url('peta')?>" class="nav-link-custom d-block py-2">Peta</a>
    <a href="<?php echo site_url('auth/form_login')?>" class="btn-masuk d-inline-block mt-2">Masuk</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero-section">
  <div class="container position-relative" style="z-index:2;">
    <div class="row align-items-center gy-5">
      <div class="col-lg-7" data-aos="fade-right">
        <div class="hero-badge"><span></span> Portal Resmi Disdagin Kab. Bandung</div>
        <h1 class="hero-title">Selamat Datang di <span>UMKM Kabupaten Bandung</span></h1>
        <p class="hero-desc">Pusat informasi dan layanan digital yang dirancang untuk mendukung pengembangan Usaha Mikro, Kecil, dan Menengah di wilayah Kabupaten Bandung.</p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="#kategori" class="btn-hero-primary"><i class="bi bi-grid-3x3-gap-fill"></i> Jelajahi UMKM</a>
          <a href="<?php echo site_url('peta')?>" class="btn-hero-secondary"><i class="bi bi-geo-alt"></i> Lihat Peta</a>
        </div>
        <div class="stats-strip">
          <div class="stat-item"><div class="stat-number" id="total-users">0</div><div class="stat-label">Pengguna</div></div>
          <div class="stat-item"><div class="stat-number" id="total-owners">0</div><div class="stat-label">Pemilik Usaha</div></div>
          <div class="stat-item"><div class="stat-number" id="total-umkm">0</div><div class="stat-label">Data Usaha</div></div>
        </div>
      </div>
      <div class="col-lg-5" data-aos="fade-left" data-aos-delay="150">
        <div class="hero-logo-card">
          <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo UMKM">
          <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;margin-top:16px;">Dinas Perdagangan & Perindustrian</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- KATEGORI -->
<section class="kategori-section" id="kategori">
  <div class="container">
    <div class="text-center mb-60" data-aos="fade-up" style="margin-bottom:56px;">
      <div class="section-label">Kategori UMKM</div>
      <h2 class="section-title">Temukan Produk Unggulan</h2>
      <p class="section-desc mx-auto">Jelajahi berbagai kategori UMKM berkualitas dari seluruh penjuru Kabupaten Bandung.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="kategori-card" onclick="window.location='#produk'">
          <div class="kategori-icon-bg"><i class="bi bi-cup-straw kategori-icon"></i></div>
          <h3 class="kategori-title">Kuliner</h3>
          <p class="kategori-desc">Dari cita rasa tradisional khas Sunda hingga inovasi kuliner modern yang menggugah selera.</p>
          <i class="bi bi-arrow-up-right kategori-arrow"></i>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="kategori-card" onclick="window.location='#produk'">
          <div class="kategori-icon-bg"><i class="bi bi-bag-heart kategori-icon"></i></div>
          <h3 class="kategori-title">Fashion</h3>
          <p class="kategori-desc">Karya busana dan aksesori yang memadukan unsur tradisional dan tren modern nan elegan.</p>
          <i class="bi bi-arrow-up-right kategori-arrow"></i>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="kategori-card" onclick="window.location='#produk'">
          <div class="kategori-icon-bg"><i class="bi bi-brush kategori-icon"></i></div>
          <h3 class="kategori-title">Kerajinan</h3>
          <p class="kategori-desc">Produk hasil tangan kreatif dari anyaman, ukiran, hingga daur ulang bernilai seni tinggi.</p>
          <i class="bi bi-arrow-up-right kategori-arrow"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATISTIK -->
<section class="stats-section" id="produk">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card">
          <div class="icon"><i class="bi bi-people-fill"></i></div>
          <div class="number" id="stat-users">0</div>
          <div class="label">Pengguna Sistem</div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card">
          <div class="icon"><i class="bi bi-shop"></i></div>
          <div class="number" id="stat-owners">0</div>
          <div class="label">Pengelola Usaha</div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card">
          <div class="icon"><i class="bi bi-list-check"></i></div>
          <div class="number" id="stat-umkm">0</div>
          <div class="label">Total Data Usaha</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- UMKM GRID -->
<section class="umkm-section">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
      <div>
        <div class="section-label">Daftar UMKM</div>
        <h2 class="section-title mb-0">UMKM Berkualitas</h2>
      </div>
      <a href="<?php echo site_url('all')?>" class="btn-lihat-semua">Lihat Semua <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
      <?php if (isset($umkm) && !empty($umkm)):
        shuffle($umkm);
        $umkm_limited = array_slice($umkm, 0, 8);
        foreach ($umkm_limited as $index => $umkm_item): ?>
        <div class="col-sm-6 col-lg-3">
          <a href="<?php echo site_url('detail/' . $umkm_item['id'])?>" class="umkm-card-link">
            <div class="umkm-card">
              <img src="<?php echo base_url('uploads/umkm/' . $umkm_item['photo']); ?>" alt="<?php echo htmlspecialchars($umkm_item['nama_usaha']); ?>" loading="lazy">
              <div class="umkm-card-body">
                <span class="umkm-badge"><?php echo htmlspecialchars($umkm_item['kategori_produk']); ?></span>
                <h5 class="umkm-card-title"><?php echo htmlspecialchars($umkm_item['nama_usaha']); ?></h5>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; else: ?>
        <div class="col-12 text-center py-5"><p class="text-muted">Tidak ada data UMKM yang ditemukan.</p></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <div class="d-flex align-items-center gap-3 mb-3">
          <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo" style="width:44px;height:44px;object-fit:contain;">
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
      © <?php echo date('Y'); ?> UMKM Kabupaten Bandung — Dinas Perdagangan & Perindustrian
    </div>
  </div>
</footer>

<a href="#" id="scroll-top"><i class="bi bi-arrow-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  AOS.init({ duration: 700, once: true, offset: 60 });

  // Navbar scroll
  window.addEventListener('scroll', () => {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 30);
    document.getElementById('scroll-top').classList.toggle('show', window.scrollY > 400);
  });

  // Scroll top
  document.getElementById('scroll-top').addEventListener('click', e => {
    e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // Mobile nav
  function toggleMobileNav() {
    const nav = document.getElementById('mobileNav');
    nav.style.display = nav.style.display === 'none' ? 'block' : 'none';
  }

  // Counter animation
  function animateCounter(el, target) {
    let current = 0;
    const step = Math.ceil(target / 60);
    const timer = setInterval(() => {
      current += step;
      if (current >= target) { current = target; clearInterval(timer); }
      el.textContent = current.toLocaleString();
    }, 25);
  }

  // Fetch stats
  $(document).ready(function() {
    $.ajax({ url: '<?php echo site_url("api/stats")?>',method:'GET',
      success: function(r) {
        if(r.users) animateCounter(document.getElementById('total-users'), r.users);
        if(r.owners) animateCounter(document.getElementById('total-owners'), r.owners);
        if(r.umkm) animateCounter(document.getElementById('total-umkm'), r.umkm);
        if(r.users) animateCounter(document.getElementById('stat-users'), r.users);
        if(r.owners) animateCounter(document.getElementById('stat-owners'), r.owners);
        if(r.umkm) animateCounter(document.getElementById('stat-umkm'), r.umkm);
      }
    });
    // Fallback legacy endpoints
    $.ajax({ url: 'http://localhost:3000/api/count-users', method:'GET',
      success: function(r) {
        if(r.count) { animateCounter(document.getElementById('total-users'), r.count); animateCounter(document.getElementById('stat-users'), r.count); }
      }
    });
    $.ajax({ url: 'http://localhost:3000/api/count-owners', method:'GET',
      success: function(r) {
        let v = r.count || (Array.isArray(r) ? r.length : 0);
        if(v) { animateCounter(document.getElementById('total-owners'), v); animateCounter(document.getElementById('stat-owners'), v); }
      }
    });
    $.ajax({ url: 'http://localhost:3000/api/count-umkm', method:'GET',
      success: function(r) {
        if(r.count) { animateCounter(document.getElementById('total-umkm'), r.count); animateCounter(document.getElementById('stat-umkm'), r.count); }
      }
    });
  });
</script>
</body>
</html>