<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming Shop HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet')?>">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/templatemo-lugx-gaming.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/owl.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
<!--

TemplateMo 589 lugx gaming

https://templatemo.com/tm-589-lugx-gaming

-->
  </head>

<body>
<style>
  .header-area {
    background-color: #27ae60; /* Hijau cerah */
    color: #fff;
}

.header-area .nav li a {
    color: #fff;
}

.header-area .nav li a.active,
.header-area .nav li a:hover {
    color: #fff; /* Hijau yang lebih gelap saat aktif atau hover */
}

.menu-trigger span {
    color: #fff;
}

.main-banner {
    background-color: #27ae60; /* Hijau */
    color: #fff;
    width: 100%; /* Sesuaikan dengan lebar kontainer */
  height: auto; /* Membuat tinggi elemen mengikuti konten di dalamnya */
  padding: 100px; /* Jarak di dalam elemen */
  box-sizing: border-box; /* Agar padding tidak menambah lebar */
  text-align: center; /* Mengatur teks agar rata tengah */
}

.main-banner h6,
.main-banner h2,
.main-banner p {
    color: #fff;
}

.search-input input[type="text"] {
    border: 1px solid #27ae60;
    color: #333;
}

.search-input button {
    background-color: #27ae60;
    color: #fff;
    border: none;
}

.search-input button:hover {
    background-color: #27ae60;
}
.header-area.header-sticky {
    background-color: #27ae60 !important; /* Hijau cerah tetap saat di-scroll */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan agar lebih elegan */
}
.right-image img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}
button {
    background-color:rgb(11, 54, 20); /* Green background color */
    color: white; /* White text color */
    border: none; /* Remove border */
    padding: 10px 20px; /* Add some padding */
    font-size: 16px; /* Set font size */
    font-weight: bold; /* Make text bold */
    border-radius: 25px; /* Rounded corners */
    cursor: pointer; /* Add pointer cursor on hover */
    transition: all 0.3s ease; /* Smooth transition for hover effect */
    margin-top: -20px; /* Space from other content */
}

/* Hover effect */
button:hover {
    background-color:rgb(14, 45, 21); /* Darker green on hover */
    transform: scale(1.05); /* Slightly increase the size */
}
.image:hover {
  background-color: rgba(2, 148, 46, 0.1); /* Change background color on hover */
  transform: scale(1.1); /* Slightly scale the icon */
  cursor: pointer; /* Change cursor to pointer on hover */
}
.down-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.down-content .text-left {
    text-align: left;
}

.shopping-bag-icon {
    display: inline-block;
    font-size: 24px;
    color: #000;
}

.shopping-bag-icon:hover {
    color: #007bff; /* You can adjust the hover color to match your design */
}

</style>
<script>window.addEventListener('scroll', function() {
    var header = document.querySelector('.header-area');
    header.classList.toggle('header-sticky', window.scrollY > 0);
});
</script>
  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="<?php echo site_url('/')?>" class="logo">
                        <img src="<?php echo base_url('assets/img/logo.png')?>" alt="" style="width: 70px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li><a href="<?php echo site_url('/')?>" class="active">Home</a></li>
                      <li><a href="<?= site_url('/#kategori')?>">Kategori</a></li>
                      <li><a href="<?= site_url('/#produk')?>">Produk</a></li>
                      <!-- <li><a href="<?php echo site_url('cari')?>">Cari</a></li> -->
                      <li><a href="<?php echo site_url('peta')?>">Peta</a></li>
                      <li><a href="<?php echo site_url('auth/form_login')?>">Masuk</a></li>
                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="main-banner">
    <div class="container">
        <div class="row">
                <div class="caption header-text"><br><br>
                    <h2>Cari UMKM</h2>
                </div>
        </div>
    </div>
</div><br><br>
  <!-- ***** Header Area End ***** -->
   <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
    <div class="col-12 text-start">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success"  href="<?=site_url('/')?>" role="button">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" id="tentang">
    <div class="container py-5 px-lg-5">
        <div class="wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="section-title justify-content-center" style="color:darkcyan;">
                <span></span>Filter Data<span></span>
            </h1>
            <br>
            <p>Filter data UMKM berdasarkan kriteria berikut:</p>

            <!-- Form Filter UMKM -->
            <form action="<?php echo site_url('auth/cari'); ?>#hasil-pencarian" method="get">
                <!-- Filter Nama UMKM -->
                <div class="mb-3">
                    <label class="form-check-label" for="nama_usaha">Nama UMKM</label>
                    <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" placeholder="Masukkan Nama UMKM" value="<?php echo set_value('nama_usaha'); ?>">
                </div>

                <!-- Filter Nama Merek Produk -->
                <div class="mb-3">
                    <label class="form-check-label" for="nama_merek_produk">Merek</label>
                    <input type="text" class="form-control" id="nama_merek_produk" name="nama_merek_produk" placeholder="Masukkan Nama Merek Produk" value="<?php echo set_value('nama_merek_produk'); ?>">
                </div>

                <!-- Filter Kategori Produk -->
                <div class="mb-3">
                    <label for="kategori_produk" class="form-label">Kategori Produk</label>
                    <select class="form-select" id="kategori_produk" name="kategori_produk">
                        <option value="">Pilih Kategori</option>
                        <option value="Kuliner" <?php echo set_select('kategori_produk', 'Kuliner'); ?>>Kuliner</option>
                        <option value="Fashion" <?php echo set_select('kategori_produk', 'Fashion'); ?>>Fashion</option>
                        <option value="Kerajinan" <?php echo set_select('kategori_produk', 'Kerajinan'); ?>>Kerajinan</option>
                    </select>
                </div>

                <br>
                <!-- Tombol Cari -->
                <button type="submit" class="btn" style="background-color:darkcyan; color:white;">
                    <i class="fa fa-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Hasil Pencarian -->
    <?php if (isset($approvedProducts) && !empty($approvedProducts)): ?>
    <div id="hasil-pencarian" class="container-xxl py-5">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="section-title text-center mb-4" style="color:darkcyan;">Hasil Pencarian UMKM</h2>
                <br>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Usaha</th>
                                <th scope="col">Merek</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Online</th>
                                <th scope="col">Offline</th>
                                <th scope="col">Agen/Reseller</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($approvedProducts as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    <td><?php echo htmlspecialchars($product['nama_usaha']); ?></td>
                                    <td><?php echo htmlspecialchars($product['nama_merek_produk']); ?></td>
                                    <td><?php echo htmlspecialchars($product['kategori_produk']); ?></td>
                                    <td><?php echo htmlspecialchars($product['online']); ?></td>
                                    <td><?php echo htmlspecialchars($product['offline']); ?></td>
                                    <td><?php echo htmlspecialchars($product['agen_reseller']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div id="hasil-pencarian" class="container-xxl py-5">
        <div class="container py-5 px-lg-5">
            <div class="wow fadeInUp" data-wow-delay="0.1s">
                <h2 class="section-title text-center mb-4" style="color:darkcyan;">Hasil Pencarian UMKM</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Usaha</th>
                                <th scope="col">Merek</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Online</th>
                                <th scope="col">Offline</th>
                                <th scope="col">Agen/Reseller</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada UMKM yang sesuai dengan kriteria pencarian</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>


        

  
  <footer style="background-color: #27ae60;">
  <div class="container">
    <div class="col-lg-12">
      <p>Copyright © 2048 LUGX Gaming Company. All rights reserved. &nbsp;&nbsp; <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: TemplateMo</a></p>
    </div>
  </div>
</footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/isotope.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/owl-carousel.js')?>"></script>
  <script src="<?php echo base_url('assets/js/counter.js')?>"></script>
  <script src="<?php echo base_url('assets/js/custom.js')?>"></script>

  </body>
</html>