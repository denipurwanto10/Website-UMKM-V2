<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/avatars/logo.png') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fonts/boxicons.css')?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/core.css')?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/theme-default.css')?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo.css')?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?php echo base_url('assets/vendor/js/helpers.js')?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo base_url('assets/js/config.js')?>"></script>
  </head>

  <body>
     <!-- Layout wrapper -->
     <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Sidebar -->
        <style>
                 body {
  background-image: url('<?php echo base_url('assets/img/background.png')?>');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  background-attachment: fixed;
}
  .menu-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .menu-logout {
    margin-top: auto;  /* Pastikan logout selalu di bawah */
    margin-bottom: -380px;
  }

  /* Responsiveness: Pastikan menu tetap di bawah di layar kecil */
  @media (max-width: 767px) {
    .menu-inner {
      flex-direction: column;  /* Pastikan menu tetap vertikal */
    }

    .menu-logout {
      margin-top: auto; /* Logout tetap di bawah */
    }
  }
  
  /* Desktop view adjustments */
  @media (min-width: 768px) {
    .menu-inner {
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    
    .menu-logout {
      margin-top: auto;
      margin-bottom: -380px;
    }
  }
  /* Sidebar transparan */
  .layout-menu {
    background: rgba(0, 0, 0, 0.5) !important; /* Ubah 0.1 jadi 0.3-0.5 untuk semi-transparan */
    backdrop-filter: blur(10px); /* Tambahkan efek blur background */
    -webkit-backdrop-filter: blur(10px); /* Safari support */
    border-right: 1px solid rgba(255, 255, 255, 0.2); /* opsional */
  }

  /* Navbar transparan */
  .bg-navbar-theme {
    background: rgba(0, 0, 0, 0.5) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }

  /* Untuk memastikan teks tetap terbaca */
  .menu-link, .navbar-nav, .dropdown-menu {
    color: #fff !important;
  }

  .menu-link:hover, .dropdown-menu a:hover {
    background-color: rgba(255, 255, 255, 0.15) !important;
  }
  .navbar-nav .form-control {
  background: rgba(0, 0, 0, 0.5) !important;
  color: white !important;
  border: 1px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-radius: 8px;
}

.navbar-nav .form-control::placeholder {
  color: rgba(255, 255, 255, 0.6);
}

.navbar-nav .form-control:focus {
  outline: none;
  box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
}
/* ===== Glassmorphism untuk dropdown-menu ===== */
.dropdown-menu {
  background: rgba(0, 0, 0, 0.5) ; /* transparan terang */
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  color: #ffffff;
}

/* Warna teks dan ikon */
.dropdown-item {
  color: #ffffff !important;
}

.dropdown-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #ffffff;
}

/* Divider juga transparan */
.dropdown-divider {
  border-color: rgba(255, 255, 255, 0.2);
}

</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="" class="menu-link">
      <span class="app-brand-logo demo">
        <img src="<?php echo base_url('assets/img/avatars/logo.png') ?>" alt="logo" width="50">
      </span>
      <span style="color:white;" class="app-brand-text demo menu-text fw-bolder ms-2">UMKM</span>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item">
      <a href="<?=site_url('dashboard')?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
    
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pages</span>
    </li>
    
    <!-- Menu Items for Admin -->
    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cube-alt"></i>
          <div data-i18n="Account Settings">MSME Data</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?=site_url('menunggu')?>" class="menu-link">
              <div data-i18n="Account">List UMKM Menunggu</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?=site_url('disetujui')?>" class="menu-link">
              <div data-i18n="Notifications">List UMKM Disetujui</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?=site_url('ditolak')?>" class="menu-link">
              <div data-i18n="Notifications">List UMKM Ditolak</div>
            </a>
          </li>
        </ul>
      </li>
    <?php endif; ?>

    <!-- Menu Items for Owner -->
    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Owner'): ?>
      <li class="menu-item">
        <a href="<?=site_url('data_umkm')?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cube-alt"></i>
          <div data-i18n="Basic">Data UMKM</div>
        </a>
      </li>
    <?php endif; ?>
    
    <!-- Promosi Menu for Admin/Owner -->
    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
      <li class="menu-item">
        <a href="<?=site_url('promosi')?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Basic">Promotion</div>
        </a>
      </li>
    <?php endif; ?>
    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Owner'): ?>
      <li class="menu-item">
        <a href="<?=site_url('promosi1')?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Basic">Promosi</div>
        </a>
      </li>
    <?php endif; ?>
    
    <!-- Pengguna Menu for Admin/Owner -->
    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
      <li class="menu-item">
        <a href="<?=site_url('users')?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div data-i18n="Basic">Users</div>
        </a>
      </li>
    <?php endif; ?>
    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Owner'): ?>
      <li class="menu-item">
        <a href="<?=site_url('users1')?>" class="menu-link">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div data-i18n="Basic">Pengguna</div>
        </a>
      </li>
    <?php endif; ?>
  </ul>

  <!-- Logout moved further down -->
  <ul class="menu-inner py-1 menu-logout">
    <li class="menu-item">
      <a href="<?= site_url('logout') ?>" class="menu-link">
        <i class="bx bx-power-off me-2"></i>
        <div data-i18n="Basic">Logout</div>
      </a>
    </li>
  </ul>
</aside>

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
             
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                    <img src="<?= base_url('uploads/users/' . $user['photo']); ?>" alt style="width: 55px; height: 45px;" class="rounded-circle" />

                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?= base_url('uploads/users/' . $user['photo']); ?>" alt style="width: 50px; height: 45px;" class="rounded-circle" />
                            </div>
                          </div>&nbsp;
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?= $user['fullname'] ?></span>  
                            <span class="fw-semibold d-block"><?= $user['usertype'] ?></span>    
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Owner'): ?>
                    <li>
                      <a class="dropdown-item" href="<?=site_url('users1')?>">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
                    <li>
                      <a class="dropdown-item" href="<?=site_url('profil')?>">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <?php endif; ?>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?= site_url('logout') ?>">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
            

              

             

   

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url('assets/vendor/libs/jquery/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="<?php echo base_url('assets/vendor/js/menu.js')?>"></script>
    <!-- endbuild -->
     <script>
      $(document).ready(function() {
  $('.menu-toggle').on('click', function() {
    $(this).next('.menu-sub').slideToggle(); // Untuk membuka/menutup submenu
  });
});

     </script>

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?php echo base_url('assets/js/main.js')?>"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
