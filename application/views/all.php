<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Semua UMKM</title>
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

    /* Custom styles for the select box */
    #category-filter {
      background-color: rgb(11, 54, 20);
      color: white;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }

    #category-filter:focus {
      border-color: rgb(11, 54, 20);
      outline: none;
    }

    /* Ensure responsiveness */
    .category-filter-container {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .category-filter-container input,
    .category-filter-container select {
      max-width: 100%;
      width: 100%;
    }
    /* Update spacing between filter items */
#portfolio .row.g-2 > [class^="col-"] {
  margin-bottom: 10px;
}

/* Adjust form control for better appearance */
#portfolio .form-control {
  height: 42px;
  font-size: 14px;
  padding: 6px 12px;
}

/* Remove large vertical gaps on small screen */
@media (max-width: 768px) {
  #portfolio .form-control {
    margin-bottom: 10px;
  }
}

  </style>
</head>

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
<br><br>
  <!-- Main -->
  <main class="main">
 

   <!-- UMKM Portfolio Section -->
<section id="portfolio" class="portfolio section">
  <div class="container mt-5">
    <div class="container section-title" data-aos="fade-up">
      <h2>All</h2>
      <div><span>Lihat Semua</span> <span class="description-title">UMKM</span></div><br>
      <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
        <div class="col-12 text-start ps-0">
          <a class="btn" href="<?= site_url('/') ?>" role="button" style="background-color: #e3a127; color: white; font-weight: 500;">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
<br><br>
      <!-- Filter Section -->
      <div class="container">
        <div class="row g-2">
  <div class="col-md-4">
    <select id="category-filter" class="form-control">
      <option value="">Pilih Kategori</option>
      <option value="kuliner">Kuliner</option>
      <option value="fashion">Fashion</option>
      <option value="kerajinan">Kerajinan</option>
    </select>
  </div>
  <div class="col-md-4">
    <input type="text" id="business-name-filter" class="form-control" placeholder="Cari Nama Usaha">
  </div>
  <div class="col-md-4">
    <input type="text" id="brand-name-filter" class="form-control" placeholder="Cari Merek Produk">
  </div>
</div>

      </div>
    </div>
  </div>

  <!-- Grid Layout for UMKM -->
  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
    <div class="row gx-2 gy-4" id="umkm-container">
      <?php if (isset($umkm) && !empty($umkm)): ?>
        <?php foreach ($umkm as $index => $umkm_item): ?>
          <div class="col-md-6 col-lg-4 col-xl-3 portfolio-item filter-ui" data-kategori="<?php echo strtolower($umkm_item['kategori_produk']); ?>">
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
        <p class="text-center">Data UMKM tidak ditemukan.</p>
      <?php endif; ?>
    </div><!-- End Grid -->
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
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const categoryFilter = document.getElementById("category-filter");
    const businessNameFilter = document.getElementById("business-name-filter");
    const brandNameFilter = document.getElementById("brand-name-filter");
    const umkmItems = document.querySelectorAll(".portfolio-item");

    function filterUMKM() {
      const selectedCategory = categoryFilter.value.trim().toLowerCase();
      const businessName = businessNameFilter.value.trim().toLowerCase();
      const brandName = brandNameFilter.value.trim().toLowerCase();

      umkmItems.forEach(function (item) {
        const itemCategory = item.getAttribute("data-kategori")?.toLowerCase() || "";
        const itemBusinessName = item.querySelector(".entry-title")?.textContent.toLowerCase() || "";
        const itemBrandName = item.querySelector(".entry-meta")?.textContent.toLowerCase() || "";

        const matchCategory = !selectedCategory || itemCategory === selectedCategory;
        const matchBusiness = !businessName || itemBusinessName.includes(businessName);
        const matchBrand = !brandName || itemBrandName.includes(brandName);

        if (matchCategory && matchBusiness && matchBrand) {
          item.style.display = "block";
        } else {
          item.style.display = "none";
        }
      });
    }

    // Attach event listeners
    categoryFilter.addEventListener("change", filterUMKM);
    businessNameFilter.addEventListener("input", filterUMKM);
    brandNameFilter.addEventListener("input", filterUMKM);
  });
</script>

</body>
</html>
