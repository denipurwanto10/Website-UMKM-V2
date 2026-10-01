<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail UMKM — <?php echo isset($umkm) ? htmlspecialchars($umkm['nama_usaha']) : 'Kabupaten Bandung'; ?></title>
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
      --green-100: #dcfce7; --gold: #e8a317;
      --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb;
      --gray-600: #4b5563; --gray-800: #1f2937;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); }
    .navbar-custom { position: fixed; top: 0; width: 100%; z-index: 1000; background: rgba(10,61,31,0.97); backdrop-filter: blur(12px); padding: 14px 0; }
    .navbar-custom.scrolled { padding: 10px 0; box-shadow: 0 4px 24px rgba(0,0,0,0.18); }
    .nav-link-custom { color: rgba(255,255,255,0.82) !important; font-weight: 500; font-size: 0.92rem; padding: 6px 14px !important; border-radius: 6px; transition: all 0.2s; text-decoration: none; }
    .nav-link-custom:hover { color: #fff !important; background: rgba(255,255,255,0.12); }
    .btn-masuk { background: var(--gold); color: var(--green-900) !important; font-weight: 700; padding: 8px 20px !important; border-radius: 8px; font-size: 0.88rem; }
    .btn-masuk:hover { background: var(--gold-light); }
    .navbar-toggler { border: none; background: transparent; cursor: pointer; }
    .navbar-toggler:focus { box-shadow: none; }
    #mobileNav { display: none; background: rgba(10,61,31,0.98); padding: 12px 16px; border-top: 1px solid rgba(255,255,255,0.08); }

    .page-header {
      background: linear-gradient(135deg, var(--green-900) 0%, var(--green-800) 100%);
      padding: 120px 0 56px; position: relative; overflow: hidden;
    }
    .page-header::after { content:''; position:absolute; width:350px; height:350px; border-radius:50%; border:1px solid rgba(255,255,255,0.06); top:-100px; right:-60px; }
    .page-header h1 { font-family:'DM Serif Display',serif; color:white; font-size:clamp(1.8rem,4vw,2.8rem); }
    .breadcrumb-nav { color:rgba(255,255,255,0.55); font-size:0.87rem; }
    .breadcrumb-nav a { color:rgba(255,255,255,0.7); text-decoration:none; }
    .breadcrumb-nav a:hover { color:var(--green-400); }
    .btn-back { display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.12); color:white; border:1px solid rgba(255,255,255,0.18); padding:8px 18px; border-radius:8px; font-size:0.88rem; font-weight:500; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { background:rgba(255,255,255,0.2); color:white; }

    /* DETAIL CARD */
    .detail-main { padding: 56px 0 80px; }
    .detail-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    .detail-image { width: 100%; height: 100%; min-height: 380px; object-fit: cover; display: block; }
    .detail-body { padding: 36px 36px 40px; }
    .detail-badge {
      display: inline-flex; align-items: center; gap: 6px;
      background: var(--green-100); color: var(--green-700);
      font-size: 0.78rem; font-weight: 700; padding: 5px 14px; border-radius: 20px;
      text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px;
    }
    .detail-title { font-family: 'DM Serif Display', serif; font-size: clamp(1.6rem, 3vw, 2.2rem); color: var(--gray-800); margin-bottom: 6px; }
    .detail-brand { color: var(--gray-600); font-size: 1rem; margin-bottom: 24px; }
    .detail-brand strong { color: var(--gray-800); }
    .detail-divider { border: none; border-top: 1.5px solid var(--gray-100); margin: 24px 0; }
    .detail-section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-600); margin-bottom: 16px; }

    /* Platform buttons */
    .platform-btn {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 9px 18px; border-radius: 10px; font-size: 0.85rem; font-weight: 600;
      text-decoration: none; transition: all 0.2s; border: 1.5px solid transparent;
    }
    .platform-btn.whatsapp { background: #25d366; color: white; }
    .platform-btn.whatsapp:hover { background: #1ebe5d; }
    .platform-btn.shopee { background: #ee4d2d; color: white; }
    .platform-btn.shopee:hover { background: #d4441f; }
    .platform-btn.tokopedia { background: #03ac0e; color: white; }
    .platform-btn.tokopedia:hover { background: #028b0b; }
    .platform-btn.instagram { background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: white; }
    .platform-btn.lazada { background: #0f146b; color: white; }
    .platform-btn.blibli { background: #0095da; color: white; }
    .platform-btn.facebook { background: #1877f2; color: white; }
    .platform-btn.tiktok { background: #010101; color: white; }
    .platform-btn.twitter { background: #1da1f2; color: white; }
    .platform-btn.default { background: var(--gray-100); color: var(--gray-800); border-color: var(--gray-200); }
    .platform-btn.default:hover { background: var(--gray-200); }

    /* Info card */
    .info-card { background: var(--gray-50); border-radius: 14px; padding: 20px 24px; margin-bottom: 20px; border: 1px solid var(--gray-100); }
    .info-card p { margin: 0; color: var(--gray-600); font-size: 0.94rem; line-height: 1.7; }
    .info-card .owner { display: flex; align-items: center; gap: 12px; }
    .owner-avatar { width: 44px; height: 44px; border-radius: 12px; background: var(--green-100); display: flex; align-items: center; justify-content: center; color: var(--green-700); font-size: 1.2rem; flex-shrink: 0; }

    /* Lainnya section */
    .lainnya-section { padding: 64px 0; background: white; }
    .lainnya-section .section-title { font-family: 'DM Serif Display', serif; font-size: clamp(1.5rem,3vw,2rem); color: var(--gray-800); margin-bottom: 0; }
    .umkm-card { border-radius: 16px; overflow: hidden; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.07); transition: all 0.3s; height: 100%; }
    .umkm-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.12); }
    .umkm-card img { width: 100%; height: 200px; object-fit: cover; }
    .umkm-card-body { padding: 14px 16px 18px; }
    .umkm-badge { display: inline-block; background: var(--green-100); color: var(--green-700); font-size: 0.7rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px; }
    .umkm-card-title { font-size: 0.94rem; font-weight: 700; color: var(--gray-800); margin: 0; }
    .umkm-card-link { text-decoration: none; color: inherit; display: block; }
    .btn-lihat-semua { background: var(--green-900); color: white; font-weight: 600; padding: 10px 24px; border-radius: 10px; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .btn-lihat-semua:hover { background: var(--green-700); color: white; }

    footer { background: var(--green-900); color: rgba(255,255,255,0.65); padding: 48px 0 24px; }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 32px; padding-top: 20px; font-size: 0.82rem; text-align: center; }

    @media(max-width:768px) { .detail-image { min-height: 260px; } .detail-body { padding: 24px 20px; } }
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
      <a href="<?php echo site_url('cari')?>" class="nav-link-custom">Cari</a>
      <a href="<?php echo site_url('auth/form_login')?>" class="nav-link-custom btn-masuk ms-2">Masuk</a>
    </div>
  </div>
  <div id="mobileNav">
    <a href="<?php echo site_url('/')?>" class="nav-link-custom d-block py-2">Home</a>
    <a href="<?= site_url('/#kategori')?>" class="nav-link-custom d-block py-2">Kategori</a>
    <a href="<?= site_url('/#produk')?>" class="nav-link-custom d-block py-2">UMKM</a>
    <a href="<?php echo site_url('peta')?>" class="nav-link-custom d-block py-2">Peta</a>
    <a href="<?php echo site_url('cari')?>" class="nav-link-custom d-block py-2">Cari</a>
    <a href="<?php echo site_url('auth/form_login')?>" class="btn-masuk d-inline-block mt-2">Masuk</a>
  </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="container" style="position:relative;z-index:2;">
    <div class="breadcrumb-nav mb-3">
      <a href="<?= site_url('/')?>">Home</a> <span class="mx-2">›</span>
      <a href="<?= site_url('/all')?>">UMKM</a> <span class="mx-2">›</span>
      <span style="color:rgba(255,255,255,0.85);"><?php echo isset($umkm) ? htmlspecialchars($umkm['nama_usaha']) : 'Detail'; ?></span>
    </div>
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h1 class="mb-0">Detail UMKM</h1>
      <a href="<?= site_url('/')?>" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

<!-- MAIN DETAIL -->
<section class="detail-main">
  <div class="container">
    <?php if (isset($umkm) && !empty($umkm)): ?>
    <div class="detail-card" data-aos="fade-up">
      <div class="row g-0">
        <div class="col-md-5">
          <?php if (!empty($umkm['photo'])): ?>
            <a href="<?php echo base_url('uploads/umkm/' . $umkm['photo']); ?>" class="glightbox" data-gallery="detail">
              <img src="<?php echo base_url('uploads/umkm/' . $umkm['photo']); ?>" class="detail-image" alt="<?php echo htmlspecialchars($umkm['nama_usaha']); ?>" loading="lazy" onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/logo.png'); ?>'">
            </a>
          <?php else: ?>
            <div class="detail-image d-flex align-items-center justify-content-center" style="background:var(--gray-100);">
              <i class="bi bi-image" style="font-size:4rem;color:var(--gray-200);"></i>
            </div>
          <?php endif; ?>
        </div>
        <div class="col-md-7">
          <div class="detail-body">
            <?php if (!empty($umkm['kategori_produk'])): ?>
              <span class="detail-badge"><i class="bi bi-tag-fill"></i><?php echo htmlspecialchars($umkm['kategori_produk']); ?></span>
            <?php endif; ?>
            <h1 class="detail-title"><?php echo htmlspecialchars($umkm['nama_usaha']); ?></h1>
            <?php if (!empty($umkm['nama_merek_produk'])): ?>
              <p class="detail-brand">Merek Produk: <strong><?php echo htmlspecialchars($umkm['nama_merek_produk']); ?></strong></p>
            <?php endif; ?>

            <hr class="detail-divider">

            <!-- Platform links -->
            <?php
              $platforms = [
                'whatsapp' => ['icon' => 'bi-whatsapp', 'label' => 'WhatsApp'],
                'shopee'   => ['icon' => 'bi-bag-fill', 'label' => 'Shopee'],
                'tokopedia'=> ['icon' => 'bi-cart-fill', 'label' => 'Tokopedia'],
                'lazada'   => ['icon' => 'bi-bag', 'label' => 'Lazada'],
                'blibli'   => ['icon' => 'bi-bag-dash', 'label' => 'Blibli'],
                'instagram'=> ['icon' => 'bi-instagram', 'label' => 'Instagram'],
                'facebook' => ['icon' => 'bi-facebook', 'label' => 'Facebook'],
                'tiktok'   => ['icon' => 'bi-tiktok', 'label' => 'TikTok'],
                'twitter'  => ['icon' => 'bi-twitter-x', 'label' => 'Twitter'],
              ];
              $hasAny = false;
              foreach ($platforms as $key => $info) {
                if (!empty($umkm[$key])) { $hasAny = true; break; }
              }
            ?>
            <?php if ($hasAny): ?>
              <div class="detail-section-title">Temukan Kami Di</div>
              <div class="d-flex flex-wrap gap-2 mb-4">
                <?php foreach ($platforms as $key => $info): ?>
                  <?php if (!empty($umkm[$key])): ?>
                    <a href="<?php echo htmlspecialchars($umkm[$key]); ?>" class="platform-btn <?php echo $key; ?>" target="_blank" rel="noopener">
                      <i class="bi <?php echo $info['icon']; ?>"></i> <?php echo $info['label']; ?>
                    </a>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <hr class="detail-divider">
            <?php endif; ?>

            <!-- Deskripsi -->
            <?php if (!empty($umkm['deskripsi_produk'])): ?>
              <div class="detail-section-title">Deskripsi Produk</div>
              <div class="info-card"><p><?php echo nl2br(htmlspecialchars($umkm['deskripsi_produk'])); ?></p></div>
            <?php endif; ?>

            <!-- Pemilik -->
            <?php if (!empty($umkm['fullname'])): ?>
              <div class="detail-section-title mt-3">Pemilik Usaha</div>
              <div class="info-card">
                <div class="owner">
                  <div class="owner-avatar"><i class="bi bi-person-fill"></i></div>
                  <div>
                    <div style="font-weight:700;color:var(--gray-800);"><?php echo htmlspecialchars($umkm['fullname']); ?></div>
                    <div style="font-size:0.82rem;color:var(--gray-600);">Pemilik / Pengelola Usaha</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="text-center py-5" data-aos="fade-up">
      <i class="bi bi-exclamation-circle" style="font-size:3rem;color:var(--gray-200);"></i>
      <p class="mt-3 text-muted">Data UMKM tidak ditemukan.</p>
      <a href="<?= site_url('/')?>" class="btn-lihat-semua mt-2">Kembali ke Beranda</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- LAINNYA -->
<section class="lainnya-section">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3" data-aos="fade-up">
      <div>
        <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--green-600);margin-bottom:6px;">Rekomendasi</div>
        <h2 class="section-title">UMKM Lainnya</h2>
      </div>
      <a href="<?php echo site_url('all')?>" class="btn-lihat-semua"><i class="bi bi-grid-3x3-gap-fill"></i> Lihat Semua</a>
    </div>
    <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
      <?php
        $rel = (isset($umkm1) && is_array($umkm1)) ? array_values($umkm1) : [];
        if (!empty($rel)) { shuffle($rel); }
        $umkm_limited = array_slice($rel, 0, 4);
        if (!empty($umkm_limited)):
        foreach ($umkm_limited as $index => $umkm_item):
          if (!is_array($umkm_item)) { continue; }
      ?>
        <div class="col-sm-6 col-lg-3">
          <a href="<?php echo site_url('detail/' . (int)($umkm_item['id'] ?? 0))?>" class="umkm-card-link">
            <div class="umkm-card">
              <img src="<?php echo !empty($umkm_item['photo']) ? base_url('uploads/umkm/' . $umkm_item['photo']) : base_url('assets/img/logo.png'); ?>" alt="<?php echo htmlspecialchars($umkm_item['nama_usaha'] ?? 'UMKM'); ?>" loading="lazy" onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/logo.png'); ?>'">
              <div class="umkm-card-body">
                <span class="umkm-badge"><?php echo htmlspecialchars($umkm_item['kategori_produk'] ?? '-'); ?></span>
                <h5 class="umkm-card-title"><?php echo htmlspecialchars($umkm_item['nama_usaha'] ?? 'UMKM'); ?></h5>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; else: ?>
        <div class="col-12 text-center py-4"><p class="text-muted">Tidak ada data lainnya.</p></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-md-6">
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
  if (window.AOS) { AOS.init({ duration: 700, once: true }); }
  if (window.GLightbox) { GLightbox({ selector: '.glightbox' }); }
  window.addEventListener('scroll', () => {
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