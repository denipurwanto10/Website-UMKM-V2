<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" type="image/png" href="<?php echo base_url('/assets/img/logo.png') ?>">

    <title>Disperindag Kab Bandung</title>
    <meta name="description" content="" />

    <!-- Favicon -->
     <link href="<?php echo base_url('assets/img/logo.png')?>" rel="icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fonts/boxicons.css')?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/core.css" class="template-customizer-core-css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/theme-default.css')?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo.css')?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/pages/page-auth.css')?>" />
    
    <!-- Helpers -->
    <script src="<?php echo base_url('assets/vendor/js/helpers.js')?>"></script>

    <!-- Template customizer -->
    <script src="<?php echo base_url('assets/js/config.js')?>"></script>
    
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body>
    <style>
       /* Include the updated CSS here */
       #loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background-color: #27ae60; /* Adjust opacity as needed */
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .loader,
        .loader:before,
        .loader:after {
            background: #fff; /* Adjust color as needed */
            -webkit-animation: load1 1s infinite ease-in-out;
            animation: load1 1s infinite ease-in-out;
            width: 1em;
            height: 4em;
        }
        .loader:before,
        .loader:after {
            position: absolute;
            top: 0;
            content: '';
        }
        .loader:before {
            left: -1.5em;
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }
        .loader {
            text-indent: -9999em;
            margin: 288px auto;
            position: relative;
            font-size: 11px;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }
        .loader:after {
            left: 1.5em;
        }
        @-webkit-keyframes load1 {
            0%, 80%, 100% {
                box-shadow: 0 0 #fff;
                height: 4em;
            }
            40% {
                box-shadow: 0 -2em #fff;
                height: 5em;
            }
        }
        @keyframes load1 {
            0%, 80%, 100% {
                box-shadow: 0 0 #fff;
                height: 4em;
            }
            40% {
                box-shadow: 0 -2em #fff;
                height: 5em;
            }
        }
        body {
  background-image: url('<?php echo base_url('assets/img/background.png')?>');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  background-attachment: fixed;
}
.card {
  background: rgba(255, 255, 255, 0.15); /* transparan putih */
  border-radius: 15px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  backdrop-filter: blur(10px); /* efek blur di belakang */
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.18);
}
/* Style untuk form input */
.form-control {
  background-color: rgba(255, 255, 255, 0.25) !important; /* lebih gelap dari card */
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: #fff;
}

.form-control:focus {
  background-color: rgba(255, 255, 255, 0.35) !important;
  border-color: rgba(255, 255, 255, 0.5);
  color: #fff;
  box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

/* Style untuk button */
button.btn-primary {
  background-color: rgba(0, 0, 0, 0.5); /* Lebih gelap dari card */
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: white;
}

button.btn-primary:hover {
  background-color: rgba(0, 0, 0, 0.7);
  border-color: rgba(255, 255, 255, 0.5);
  color: #fff;
}

/* Style untuk secondary button */
.btn-secondary {
  background-color: rgba(0, 0, 0, 0.5); /* Lebih gelap dari card */
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: white;
}

.btn-secondary:hover {
  background-color: rgba(0, 0, 0, 0.7);
  border-color: rgba(255, 255, 255, 0.5);
  color: #fff;
}

/* Placeholder text color */
.form-control {
  background-color: rgba(0, 0, 0, 0.3) !important;
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #fff !important;
}

.form-control:focus {
  background-color: rgba(0, 0, 0, 0.4) !important;
  border-color: rgba(255, 255, 255, 0.3);
  box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

/* Style untuk input group (password) */
.input-group-text {
  background-color: rgba(0, 0, 0, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
    </style>



    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="<?php echo base_url('assets/img/logo.png') ?>" alt="logo" width="50">
                  </span>
                </a>
              </div>

              <!-- Display error or success messages -->
              <?php if($this->session->flashdata('success')): ?>
                <script>
                  Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: '<?php echo $this->session->flashdata('success'); ?>',
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // Redirect to dashboard after SweetAlert is closed
                      location.href = "<?= site_url('dashboard') ?>";
                    }
                  });
                </script>
              <?php endif; ?>

              <?php if($this->session->flashdata('error')): ?>
                <script>
                  Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '<?php echo $this->session->flashdata('error'); ?>',
                  }).then((result) => {
                    // Do nothing, stay on login page
                  });
                </script>
              <?php endif; ?>

              <?php if(validation_errors()): ?>
                <script>
                  Swal.fire({
                    icon: 'error',
                    title: 'Form Error',
                    text: '<?php echo validation_errors(); ?>',
                  }).then((result) => {
                    // Do nothing, stay on login page
                  });
                </script>
              <?php endif; ?>

              <h4 style="color:white;" class="mb-2">Selamat Datang di UMKM Kab Bandung! 👋</h4>
              <p style="color:white;" class="mb-4">Silakan masuk ke akun Anda</p>

              <form id="formLogin" class="mb-3" method="POST" action="<?= site_url('auth/login') ?>" enctype="multipart/form-data">
                <div class="mb-3">
                  <label style="color:white;" for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label style="color:white;" class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                </div>
              </form>

              <p class="text-center">
                <span style="color:yellow;">Tidak punya akun?</span>
                <a href="<?=site_url('auth/register')?>">
                  <span style="color:white;">Buat akun</span>
                </a>
              </p>
              <div style="text-align: center;">
    <a href="<?=site_url('/')?>" class="btn btn-secondary btn-sm">
        Kembali
    </a>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="<?php echo base_url('assets/vendor/libs/jquery/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/js/menu.js')?>"></script>
    <script src="<?php echo base_url('assets/js/main.js')?>"></script>

    <script>
      // Show spinner when the DOM content is being loaded
      document.addEventListener("DOMContentLoaded", function() {
        // Ensure the spinner is visible while content is loading
        document.getElementById("loading-spinner").style.display = "flex";
      });

      // Hide spinner when the entire page has loaded (including images, etc.)
      window.addEventListener("load", function() {
        setTimeout(function() {
          document.getElementById("loading-spinner").style.display = "none";
        }, 500);
      });
    </script>
  </body>
</html>
