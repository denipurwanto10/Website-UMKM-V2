<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Detail UMKM</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
   <link href="<?php echo base_url('assets/img/logo.png')?>" rel="icon">
  <link href="<?php echo base_url('assets/img/apple-touch-icon.png')?>" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Raleway&family=Nunito+Sans&display=swap" rel="stylesheet">
  
  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/glightbox/css/glightbox.min.css')?>" rel="stylesheet">

  <!-- Main CSS -->
  <link href="<?php echo base_url('assets/css/main.css')?>" rel="stylesheet">
</head>

<style>
  .custom-card {
    background-color: rgb(11, 54, 20);
    color: white;
    border-radius: 8px;
    overflow: hidden;
  }

  .custom-card h4, 
  .custom-card h5, 
  .custom-card h7, 
  .custom-card p, 
  .custom-card span {
    color: #ffffff;
  }

  .custom-card .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
  }

  .custom-card .btn-success:hover {
    background-color: #218838;
  }

  .card-img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 8px 0 0 8px;
  }

  @media (max-width: 768px) {
    .card-img {
      border-radius: 8px 8px 0 0;
    }
  }
</style>

<body class="index-page">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="<?php echo site_url('/')?>" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="<?php echo base_url('assets/img/logo.png')?>" alt="" style="width: 70px;">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?php echo site_url('/')?>" class="active">Home</a></li>
            <li><a href="<?= site_url('/#kategori')?>">Kategori</a></li>
                      <li><a href="<?= site_url('/#produk')?>">UMKM</a></li>
                      <li><a href="<?php echo site_url('peta')?>">Peta</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="<?php echo site_url('auth/form_login')?>">Masuk</a>
    </div>
  </header>

  <!-- Main -->
  <main class="main">
    <section id="hero" class="hero section">
      <div class="container mt-5">
        <div class="container section-title" data-aos="fade-up">
        <h2>Detail</h2>
        <div><span>Detail</span> <span class="description-title">UMKM</span></div><br>
<div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
  <div class="col-12 text-start ps-0">
    <a class="btn" href="<?= site_url('/') ?>" role="button"
       style="background-color: #e3a127; color: white; font-weight: 500;">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>
</div>


      </div><!-- End Section Title -->
        <?php if (isset($umkm) && !empty($umkm)): ?>
          <div class="row mt-n2" data-aos="fade-up">
            <div class="col-md-12">
              <div class="card custom-card mb-4" data-aos="fade-right" data-aos-delay="100">
                <div class="row no-gutters flex-md-row flex-column">
                  <div class="col-md-5">
                    <?php if (!empty($umkm['photo'])): ?>
                      <img src="<?php echo base_url('uploads/umkm/' . $umkm['photo']); ?>" class="card-img img-fluid" alt="Product Image">
                    <?php else: ?>
                      <img src="default-image.jpg" class="card-img img-fluid" alt="Default Image">
                    <?php endif; ?>
                  </div>
                  <div class="col-md-7">
                    <div class="card-body" data-aos="fade-left" data-aos-delay="200">
                      <h4 class="card-title text-uppercase mb-4">
                        <i class="bi bi-shop">&nbsp;&nbsp;</i><?php echo htmlspecialchars($umkm['nama_usaha']); ?>
                      </h4>
                      <hr style="border-color: white;">
                      <h5>Nama Merek Produk: <?php echo htmlspecialchars($umkm['nama_merek_produk']); ?></h5>
                      <?php if (isset($umkm['kategori_produk'])): ?>
                        <h7>Kategori: <?php echo htmlspecialchars($umkm['kategori_produk']); ?></h7><br><br>
                      <?php endif; ?>
                      <div class="d-flex flex-wrap gap-2" data-aos="zoom-in" data-aos-delay="300">
                        <?php foreach (['whatsapp','blibli','lazada','shopee','tokopedia','facebook','instagram','tiktok','twitter'] as $platform): ?>
                          <?php if (!empty($umkm[$platform])): ?>
                            <a href="<?php echo htmlspecialchars($umkm[$platform]); ?>" class="btn btn-success mb-2 text-capitalize"><?php echo $platform; ?></a>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card custom-card mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header">
                  <h4 class="card-title">Deskripsi Produk</h4>
                </div>
                <div class="card-body">
                  <?php if (!empty($umkm['deskripsi_produk'])): ?>
                    <p><?php echo nl2br(htmlspecialchars($umkm['deskripsi_produk'])); ?></p>
                  <?php else: ?>
                    <p>Deskripsi produk belum tersedia.</p>
                  <?php endif; ?>
                </div>
              </div>

              <div class="card custom-card mb-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header">
                  <h4 class="card-title">Nama Pemilik</h4>
                </div>
                <div class="card-body">
                  <?php if (!empty($umkm['fullname'])): ?>
                    <p>Nama Pemilik: <?php echo htmlspecialchars($umkm['fullname']); ?></p>
                  <?php else: ?>
                    <p>Nama Pemilik belum tersedia.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="alert alert-warning mt-4" role="alert" data-aos="fade-down">
            Data UMKM tidak ditemukan atau terjadi kesalahan dalam pengambilan data.
          </div>
        <?php endif; ?>
      </div>
    </section>
  <section id="portfolio" class="portfolio section">

  <!-- Section Title -->
  <div class="container section-title d-flex justify-content-between align-items-center flex-wrap" data-aos="fade-up">
    <div>
      <h2>Lainnya</h2>
      <div>
        <span>Lihat Daftar</span> 
        <span class="description-title">Lainnya</span>
      </div>
    </div>
    <div>
      <a class="btn btn-warning text-white fw-semibold" href="<?php echo site_url('all') ?>">
        <i class="bi bi-grid-3x3-gap-fill"></i> Lihat Semua
      </a>
    </div>
  </div>
  <!-- End Section Title -->

  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

      <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="300">
 <?php if (isset($umkm1) && !empty($umkm1)): ?>
  <?php
    shuffle($umkm1); // Mengacak urutan array
    $umkm_limited = array_slice($umkm1, 0, 4); // Ambil 4 data acak
  ?>
  <?php foreach ($umkm_limited as $index => $umkm_item): ?>
    <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item filter-ui">
      <article class="portfolio-entry" data-aos="fade-up" data-aos-delay="<?php echo ($index % 4) * 100 ?>">
        <figure class="entry-image">
          <a href="<?php echo site_url('detail/' . $umkm_item['id']) ?>">
            <img src="<?php echo base_url('uploads/umkm/' . $umkm_item['photo']); ?>" class="img-fluid" alt="" loading="lazy" style="height:250px; object-fit:cover;">
          </a>
          <div class="entry-overlay">
            <div class="overlay-content">
              <div class="entry-meta" style="color:rgb(11, 54, 20)">Kategori: <?php echo $umkm_item['kategori_produk']; ?></div>
              <h3 class="entry-title"><?php echo $umkm_item['nama_usaha']; ?></h3>
              <div class="entry-links">
                <a href="<?php echo base_url('uploads/umkm/' . $umkm_item['photo']); ?>" class="glightbox" data-gallery="portfolio-gallery-ui">
                  <i class="bi bi-arrows-angle-expand"></i>
                </a>
                <a href="<?php echo site_url('detail/' . $umkm_item['id']) ?>">
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </figure>
      </article>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No UMKM data found.</p>
<?php endif; ?>

      </div><!-- End Portfolio Container -->

    </div>

  </div>

</section>

  </main>

  <!-- Footer -->
  <footer id="footer" class="footer">
    <div class="container footer-top" data-aos="fade-up">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Strategy</span>
          </a>
          <p>Cras fermentum odio eu feugiat lide par naso tierra.</p>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <p>A108 Adam Street</p>
          <p>New York, NY 535022</p>
          <p>United States</p>
          <p class="mt-4"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
          <p><strong>Email:</strong> <span>info@example.com</span></p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Strategy</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Scripts -->
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/php-email-form/validate.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/glightbox/js/glightbox.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/main.js')?>"></script>

  <!-- AOS Init -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });
  </script>
</body>
</html>
