<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>DISDAGIN</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="<?php echo base_url('assets/img/logo.png')?>" rel="icon">
  <link href="<?php echo base_url('assets/img/apple-touch-icon.png')?>" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/aos/aos.css" rel="stylesheet')?>">
  <link href="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.css')?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/vendor/glightbox/css/glightbox.min.css')?>" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?php echo base_url('assets/css/main.css" rel="stylesheet')?>">

  <!-- =======================================================
  * Template Name: Strategy
  * Template URL: https://bootstrapmade.com/strategy-bootstrap-agency-template/
  * Updated: May 09 2025 with Bootstrap v5.3.6
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
  
<style>
  
  .floating {
  animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(0px);
  }
}

</style>
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="<?php echo site_url('/')?>" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
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
<br><br><br>
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 content-col" data-aos="fade-up">
            <div class="content">
              <div class="agency-name">
                <h5>Selamat Datang di</h5>
              </div>

              <div class="main-heading">
  <h1><span id="typed-text"></span></h1>
</div>


              <div class="divider"></div>

              <div class="description">
                <p>Selamat datang di Portal UMKM Kabupaten Bandung, pusat informasi dan layanan digital yang dirancang untuk mendukung pengembangan Usaha Mikro, Kecil, dan Menengah di wilayah Kabupaten Bandung. Melalui platform ini, pelaku UMKM dapat mengakses data profil, memanfaatkan berbagai fitur pendukung usaha, serta memperoleh informasi terkini dari Dinas Perdagangan dan Perindustrian. Kami hadir untuk mendorong pertumbuhan ekonomi lokal yang mandiri, inovatif, dan berdaya saing tinggi.</p>
              </div>

              <div class="cta-button">
                <a href="#services" class="btn">
                  <span>EXPLORE SERVICES</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

        <div class="col-lg-5">
  <div
    class="card shadow-lg border-0 rounded-4"
    style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="card-body text-center">
      <div class="right-image">
        <img
          src="<?php echo base_url('assets/img/logo.png')?>"
          class="img-fluid floating"
          alt="Logo">
      </div>
    </div>
  </div>
</div>

          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->
<!-- Services Section -->
    <section id="services" class="services section" >

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up" id="kategori">
        <h2>Kategori</h2>
        <div><span>Kategori</span> <span class="description-title">UMKM</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        

        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-card position-relative z-1">
              <div class="service-icon">
                <i class="bi-egg-friedbi bi-cup-straw"></i>
              </div>
              <a href="#produk" class="card-action d-flex align-items-center justify-content-center rounded-circle">
                <i class="bi bi-arrow-up-right"></i>
              </a>
              <h3>
                <a href="#produk">
                  Kuliner
                </a>
              </h3>
              <p>
                Kategori kuliner menampilkan berbagai produk makanan dan minuman unggulan dari pelaku UMKM Kabupaten Bandung. Dari cita rasa tradisional khas Sunda hingga inovasi kuliner modern. 
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-card position-relative z-1">
              <div class="service-icon">
                <i class="bi bi-bag"></i>
              </div>
              <a href="#produk" class="card-action d-flex align-items-center justify-content-center rounded-circle">
                <i class="bi bi-arrow-up-right"></i>
              </a>
              <h3>
                <a href="#produk">
                  Fashion
                </a>
              </h3>
              <p>
               UMKM fashion Kabupaten Bandung menghadirkan beragam karya busana dan aksesori yang mencerminkan kreativitas serta kearifan lokal. Dengan memadukan unsur tradisional dan tren modern.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-card position-relative z-1">
              <div class="service-icon">
                <i class="bi bi-brush"></i>
              </div>
              <a href="#produk" class="card-action d-flex align-items-center justify-content-center rounded-circle">
                <i class="bi bi-arrow-up-right"></i>
              </a>
              <h3>
                <a href="#produk">
                  Kerajinan >
                </a>
              </h3>
              <p>
               Kategori kerajinan menampung berbagai produk hasil tangan kreatif dari para pengrajin UMKM di Kabupaten Bandung. Mulai dari anyaman, ukiran, hingga produk daur ulang bernilai seni tinggi.
              </p>
            </div>
          </div>
         

      </div>

    </section><!-- /Services Section -->
       <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up" id="produk">

      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Contact Info Boxes -->
        <div class="row gy-4 mb-5">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="contact-info-box">
              <div class="icon-box">
                <i class="bi bi-people"></i>
              </div>
              <div class="info-content">
                <h4 >Pengguna Sistem</h4>
                <p style="color:white;" id="total-users" data-toggle="counter-up">0</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="contact-info-box">
              <div class="icon-box">
                <i class="bi bi-shop"></i>
              </div>
              <div class="info-content">
                <h4>Pengelola Usaha</h4>
                 <p style="color:white;" id="total-owners" data-toggle="counter-up">0</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="contact-info-box">
              <div class="icon-box">
                <i class="bi bi-list"></i>
              </div>
              <div class="info-content">
                <h4>Data Usaha</h4>
                 <p style="color:white;" id="total-umkm" data-toggle="counter-up">0</p>
              </div>
            </div>
          </div>
        </div>

      </div>

     

      </div>


    

   
  

    <!-- Portfolio Section -->
 <section id="portfolio" class="portfolio section">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>UMKM</h2>
    <div><span>Daftar UMKM</span> <span class="description-title">Berkualitas</span></div>
  </div><!-- End Section Title -->

  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
      <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
        <li data-filter="*" class="filter-active">
          <i class="bi bi-grid-3x3"></i>  
          <a style="color:white;" href="<?php echo site_url('all') ?>">Lihat Semua</a>
        </li>
      </ul>

      <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="300">
        <?php if (isset($umkm) && !empty($umkm)): ?>
          <?php 
            // Mengambil 8 data UMKM secara acak
            shuffle($umkm);
            $umkm_limited = array_slice($umkm, 0, 8);
          ?>
          <?php foreach ($umkm_limited as $index => $umkm_item): ?>
            <!-- Menggunakan col-lg-3 untuk membuat 4 kolom per baris di layar besar -->
            <div class="col-lg-3 col-md-6 portfolio-item isotope-item filter-ui">
              <article class="portfolio-entry" data-aos="fade-up" data-aos-delay="<?php echo ($index % 6) * 100 ?>">
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
          <div class="col-12">
            <p>Tidak ada data UMKM yang ditemukan.</p>
          </div>
        <?php endif; ?>
      </div><!-- End Portfolio Container -->
    </div>
  </div>
</section>
<!-- /Portfolio Section -->

 

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Strategy</span>
          </a>
          <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
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

  <!-- Vendor JS Files -->
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/php-email-form/validate.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/aos/aos.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/swiper/swiper-bundle.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/glightbox/js/glightbox.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js')?>"></script>

  <!-- Main JS File -->
  <script src="<?php echo base_url('assets/js/main.js')?>"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>


    <script>
   $(document).ready(function() {

// Fetch Total Users
$.ajax({
  url: 'http://localhost:3000/api/count-users', // Ganti sesuai endpoint API-mu
  method: 'GET',
  success: function(response) {
    $('#total-users').text(response.count);
  },
  error: function() {
    $('#total-users').text('Error');
  }
});

// Fetch Total Pemilik UMKM (usertype = "Owner")
$.ajax({
  url: 'http://localhost:3000/api/count-owners', // Endpoint untuk owner
  method: 'GET',
  success: function(response) {
    $('#total-owners').text(response.length); // Menghitung jumlah owner dari array
  },
  error: function() {
    $('#total-owners').text('Error');
  }
});

// Fetch Total UMKM
$.ajax({
  url: 'http://localhost:3000/api/count-owners', // Endpoint untuk total UMKM
  method: 'GET',
  success: function(response) {
    $('#total-owners').text(response.count);
  },
  error: function() {
    $('#total-owners').text('Error');
  }
});

// Fetch Total UMKM
$.ajax({
  url: 'http://localhost:3000/api/count-umkm', // Endpoint untuk total UMKM
  method: 'GET',
  success: function(response) {
    $('#total-umkm').text(response.count);
  },
  error: function() {
    $('#total-umkm').text('Error');
  }
});


});
</script>
<script>
  var typed = new Typed("#typed-text", {
    strings: ["UMKM Kabupaten Bandung"],
    typeSpeed: 50,
    backSpeed: 30,
    backDelay: 2000,
    loop: true,
    showCursor: true,
    cursorChar: '|',
  });
</script>


</body>

</html>