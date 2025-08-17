<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" type="image/png" href="<?php echo base_url('/assets/img/logo.png') ?>">

    <title>Disperindag Kab Bandung</title>
    <meta name="description" content="" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<style>
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
.form-control::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

/* Style untuk input group (password) */
.input-group-text {
  background-color: rgba(255, 255, 255, 0.25);
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: rgba(255, 255, 255, 0.7);
}
</style>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="<?= site_url('/') ?>" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="logo" width="50">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 style="color:white;" class="mb-2">Buat Akun Baru 🚀</h4>
                        <p style="color:white;" class="mb-4">Isi data di bawah untuk mendaftar sebagai Owner</p>

                        <!-- Display success or error messages using SweetAlert -->
                        <?php if ($this->session->flashdata('success')): ?>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registrasi Berhasil!',
                                    text: '<?= $this->session->flashdata('success'); ?>',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '<?= site_url('auth/login') ?>'; // Redirect to login page
                                    }
                                });
                            </script>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registrasi Gagal!',
                                    text: '<?= $this->session->flashdata('error'); ?>',
                                    confirmButtonText: 'OK'
                                });
                            </script>
                        <?php endif; ?>

                        <form id="formRegistration" class="mb-3" method="POST" action="<?= site_url('register') ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label style="color:white;" for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= set_value('username') ?>" required />
                            </div>
                            <div class="mb-3">
                                <label style="color:white;" for="fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" value="<?= set_value('fullname') ?>" required />
                            </div>
                            <div class="mb-3">
                                <label style="color:white;" for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" value="<?= set_value('email') ?>" required />
                            </div>
                            <div class="mb-3">
                                <label style="color:white;" for="nomor_hp" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Masukkan nomor HP" value="<?= set_value('nomor_hp') ?>" required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label style="color:white;" class="form-label" for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="••••••••" required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label style="color:white;" class="form-label" for="confpassword">Konfirmasi Password</label>
                                <input type="password" id="confpassword" class="form-control" name="confpassword" placeholder="••••••••" required />
                            </div>

                            <!-- Hidden Usertype -->
                            <input type="hidden" name="usertype" value="Owner" />

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span style="color:yellow;">Sudah punya akun?</span>
                            <a href="<?= site_url('auth/login') ?>">
                                <span style="color:white;">Masuk sekarang</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>

    <!-- Frontend Validation with JavaScript -->
    <script>
        $(document).ready(function() {
            $('#formRegistration').on('submit', function(event) {
                var password = $('#password').val();
                var confpassword = $('#confpassword').val();
                var email = $('#email').val();

                // Email Validation
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email tidak valid!',
                        text: 'Format email tidak valid.',
                        confirmButtonText: 'OK'
                    });
                    event.preventDefault();
                }

                // Check if Password and Confirm Password match
                if (password !== confpassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok!',
                        text: 'Password dan Konfirmasi Password tidak cocok.',
                        confirmButtonText: 'OK'
                    });
                    event.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
