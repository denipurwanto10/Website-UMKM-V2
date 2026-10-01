<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semua UMKM — Kabupaten Bandung</title>
  <link href="<?php echo base_url('assets/img/logo.png')?>" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/glightbox/css/glightbox.min.css')?>" rel="stylesheet">
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
      background: rgba(10,61,31,0.97); backdrop-filter: blur(12px);
      padding: 14px 0; transition: all 0.3s;
    }
    .navbar-custom.scrolled { padding: 10px 0; box-shadow: 0 4px 24px rgba(0,0,0,0.18); }
    .nav-link-custom { color: rgba(255,255,255,0.82) !important; font-weight: 500; font-size: 0.92rem; padding: 6px 14px !important; border-radius: 6px; transition: all 0.2s; text-decoration: none; }
    .nav-link-custom:hover { color: #fff !important; background: rgba(255,255,255,0.12); }
    .btn-masuk { background: var(--gold); color: var(--green-900) !important; font-weight: 700; padding: 8px 20px !important; border-radius: 8px; font-size: 0.88rem; }
    .btn-masuk:hover { background: var(--gold-light); }

    /* PAGE HEADER */
    .page-header {
      background: linear-gradient(135deg, var(--green-900) 0%, var(--green-800) 100%);
      padding: 120px 0 60px; position: relative; overflow: hidden;
    }
    .page-header::after {
      content: ''; position: absolute; width: 400px; height: 400px;
      border-radius: 50%; border: 1px solid rgba(255,255,255,0.06);
      top: -120px; right: -80px;
    }
    .page-header h1 { font-family: 'DM Serif Display', serif; color: white; font-size: clamp(2rem, 4vw, 3rem); }
    .page-header .breadcrumb-custom { color: rgba(255,255,255,0.55); font-size: 0.87rem; }
    .page-header .breadcrumb-custom a { color: rgba(255,255,255,0.7); text-decoration: none; }
    .page-header .breadcrumb-custom a:hover { color: var(--green-400); }
    .btn-back {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,0.12); color: white; border: 1px solid rgba(255,255,255,0.18);
      padding: 8px 18px; border-radius: 8px; font-size: 0.88rem; font-weight: 500;
      text-decoration: none; transition: all 0.2s;
    }
    .btn-back:hover { background: rgba(255,255,255,0.2); color: white; }

    /* FILTER BAR */
    .filter-bar {
      background: white; border-radius: 16px; padding: 24px;
      box-shadow: 0 2px 16px rgba(0,0,0,0.07); margin-bottom: 32px;
    }
    .filter-bar label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--gray-600); margin-bottom: 6px; display: block; }
    .filter-input {
      width: 100%; padding: 10px 14px; border: 1.5px solid var(--gray-200);
      border-radius: 10px; font-size: 0.9rem; font-family: 'Plus Jakarta Sans', sans-serif;
      transition: border 0.2s; outline: none; background: var(--gray-50);
    }
    .filter-input:focus { border-color: var(--green-600); background: white; }
    .filter-select {
      width: 100%; padding: 10px 14px; border: 1.5px solid var(--gray-200);
      border-radius: 10px; font-size: 0.9rem; font-family: 'Plus Jakarta Sans', sans-serif;
      transition: border 0.2s; outline: none; background: var(--gray-50);
      appearance: none; cursor: pointer;
    }
    .filter-select:focus { border-color: var(--green-600); background: white; }

    /* UMKM CARDS */
    .umkm-card {
      border-radius: 16px; overflow: hidden; background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.3s; height: 100%;
    }
    .umkm-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.12); }
    .umkm-card img { width: 100%; height: 220px; object-fit: cover; }
    .umkm-card-body { padding: 16px 18px 20px; }
    .umkm-badge {
      display: inline-block; background: var(--green-100); color: var(--green-700);
      font-size: 0.71rem; font-weight: 700; padding: 3px 10px; border-radius: 20px;
      text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 9px;
    }
    .umkm-card-title { font-size: 0.98rem; font-weight: 700; color: var(--gray-800); margin-bottom: 0; }
    .umkm-card-link { text-decoration: none; display: block; color: inherit; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 80px 20px; }
    .empty-state i { font-size: 3.5rem; color: var(--gray-200); }
    .empty-state p { color: var(--gray-600); margin-top: 16px; font-size: 0.95rem; }

    /* FOOTER */
    footer { background: var(--green-900); color: rgba(255,255,255,0.65); padding: 48px 0 24px; }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 32px; padding-top: 20px; font-size: 0.82rem; text-align: center; }

    @media(max-width:768px) { .filter-bar > .row { gap: 12px; } }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom" id="mainNav">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="<?php echo site_url('/')?>" class="d-flex align-items-center gap-3 text-decoration-none">
      <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo" style="width:44px;height:44px;object-fit:contain;">
      <span style="color:white;font-weight:700;font-size:0.92rem;">UMKM Kab. Bandung</span>
    </a>
    <div class="d-flex align-items-center gap-1 flex-wrap">
      <a href="<?php echo site_url('/')?>" class="nav-link-custom">Home</a>
      <a href="<?= site_url('/#kategori')?>" class="nav-link-custom">Kategori</a>
      <a href="<?= site_url('/#produk')?>" class="nav-link-custom">UMKM</a>
      <a href="<?php echo site_url('peta')?>" class="nav-link-custom">Peta</a>
      <a href="<?php echo site_url('auth/form_login')?>" class="nav-link-custom btn-masuk ms-2">Masuk</a>
    </div>
  </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="container" style="position:relative;z-index:2;">
    <div class="breadcrumb-custom mb-3">
      <a href="<?= site_url('/')?>">Home</a> <span class="mx-2">›</span> Semua UMKM
    </div>
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h1 class="mb-0">Semua UMKM</h1>
      <a href="<?= site_url('/')?>" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

<!-- MAIN -->
<main style="padding: 48px 0 80px;">
  <div class="container">
    <!-- Filter -->
    <div class="filter-bar" data-aos="fade-up">
      <div class="row g-3">
        <div class="col-md-4">
          <label>Kategori</label>
          <select id="category-filter" class="filter-select">
            <option value="">Semua Kategori</option>
            <option value="kuliner">Kuliner</option>
            <option value="fashion">Fashion</option>
            <option value="kerajinan">Kerajinan</option>
          </select>
        </div>
        <div class="col-md-4">
          <label>Nama Usaha</label>
          <input type="text" id="business-name-filter" class="filter-input" placeholder="Cari nama usaha...">
        </div>
        <div class="col-md-4">
          <label>Merek Produk</label>
          <input type="text" id="brand-name-filter" class="filter-input" placeholder="Cari merek produk...">
        </div>
      </div>
    </div>

    <!-- Result count -->
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
      <p class="mb-0" style="color:var(--gray-600);font-size:0.9rem;">
        Menampilkan <strong id="result-count">0</strong> UMKM
      </p>
    </div>

    <!-- Grid -->
    <div class="row g-4" id="umkm-container" data-aos="fade-up" data-aos-delay="100">
      <?php if (isset($umkm) && !empty($umkm)): ?>
        <?php foreach ($umkm as $index => $umkm_item): ?>
          <div class="col-sm-6 col-lg-4 col-xl-3 portfolio-item" data-kategori="<?php echo strtolower($umkm_item['kategori_produk']); ?>">
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
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="empty-state">
            <i class="bi bi-shop-window"></i>
            <p>Data UMKM tidak ditemukan.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Empty filtered state -->
    <div id="no-results" style="display:none;">
      <div class="empty-state">
        <i class="bi bi-search"></i>
        <p>Tidak ada UMKM yang sesuai dengan pencarian Anda.</p>
      </div>
    </div>
  </div>
</main>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5">
        <div style="font-family:'DM Serif Display',serif;color:white;font-size:1.2rem;margin-bottom:10px;">UMKM Kab. Bandung</div>
        <p style="font-size:0.87rem;line-height:1.75;">Portal resmi UMKM Kabupaten Bandung.</p>
      </div>
      <div class="col-md-3">
        <h6 style="color:rgba(255,255,255,0.5);font-size:0.72rem;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:14px;">Navigasi</h6>
        <a href="<?= site_url('/')?>" style="color:rgba(255,255,255,0.65);text-decoration:none;font-size:0.87rem;display:block;margin-bottom:8px;">Home</a>
        <a href="<?= site_url('/all')?>" style="color:rgba(255,255,255,0.65);text-decoration:none;font-size:0.87rem;display:block;margin-bottom:8px;">Semua UMKM</a>
        <a href="<?= site_url('/peta')?>" style="color:rgba(255,255,255,0.65);text-decoration:none;font-size:0.87rem;display:block;margin-bottom:8px;">Peta</a>
      </div>
    </div>
    <div class="footer-bottom">© <?php echo date('Y'); ?> UMKM Kabupaten Bandung</div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/vendor/glightbox/js/glightbox.min.js')?>"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 700, once: true });
  window.addEventListener('scroll', () => {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 30);
  });

  // GLightbox init
  GLightbox({ selector: '.glightbox' });

  // Filter logic
  const categoryFilter = document.getElementById('category-filter');
  const businessNameFilter = document.getElementById('business-name-filter');
  const brandNameFilter = document.getElementById('brand-name-filter');
  const items = document.querySelectorAll('.portfolio-item');
  const resultCount = document.getElementById('result-count');
  const noResults = document.getElementById('no-results');

  function filterUMKM() {
    const cat = categoryFilter.value.trim().toLowerCase();
    const biz = businessNameFilter.value.trim().toLowerCase();
    const brand = brandNameFilter.value.trim().toLowerCase();
    let count = 0;
    items.forEach(item => {
      const itemCat = item.getAttribute('data-kategori') || '';
      const title = item.querySelector('.umkm-card-title')?.textContent.toLowerCase() || '';
      const badge = item.querySelector('.umkm-badge')?.textContent.toLowerCase() || '';
      const ok = (!cat || itemCat === cat) && (!biz || title.includes(biz)) && (!brand || badge.includes(brand) || title.includes(brand));
      item.style.display = ok ? '' : 'none';
      if (ok) count++;
    });
    resultCount.textContent = count;
    noResults.style.display = count === 0 ? 'block' : 'none';
  }

  categoryFilter.addEventListener('change', filterUMKM);
  businessNameFilter.addEventListener('input', filterUMKM);
  brandNameFilter.addEventListener('input', filterUMKM);

  // Initial count
  document.addEventListener('DOMContentLoaded', () => {
    resultCount.textContent = items.length;
  });
</script>
</body>
</html>