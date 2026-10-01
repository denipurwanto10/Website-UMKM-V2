<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — UMKM Kabupaten Bandung</title>
  <link href="<?php echo base_url('/assets/img/logo.png')?>" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root {
      --green-900: #0a3d1f; --green-800: #0d5128; --green-700: #117a3c;
      --green-600: #16a34a; --green-500: #22c55e; --green-400: #4ade80;
      --gold: #e8a317; --gold-light: #fbbf24;
      --gray-50: #f9fafb; --gray-200: #e5e7eb; --gray-600: #4b5563; --gray-800: #1f2937;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      background: var(--green-900);
      display: flex; align-items: center; justify-content: center;
      overflow-x: hidden; overflow-y: auto;
      position: relative;
      padding: 40px 0;
    }
    /* Animated background */
    body::before {
      content: ''; position: fixed; inset: 0;
      background: 
        radial-gradient(ellipse at 20% 80%, rgba(22,163,74,0.25) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 20%, rgba(232,163,23,0.12) 0%, transparent 50%),
        linear-gradient(135deg, var(--green-900) 0%, #0a3520 100%);
    }
    .decor-circle {
      position: fixed; border-radius: 50%;
      border: 1px solid rgba(255,255,255,0.05);
    }
    .decor-circle:nth-child(1) { width: 500px; height: 500px; top: -180px; right: -140px; }
    .decor-circle:nth-child(2) { width: 300px; height: 300px; bottom: -100px; left: -80px; }

    .register-wrapper { position: relative; z-index: 10; width: 100%; padding: 24px; }

    .register-card {
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 24px;
      padding: 48px 44px;
      max-width: 440px;
      margin: 0 auto;
      backdrop-filter: blur(20px);
    }
    .register-logo { text-align: center; margin-bottom: 32px; }
    .register-logo img { width: 64px; height: 64px; object-fit: contain; }
    .register-logo h2 { font-family: 'DM Serif Display', serif; color: white; font-size: 1.5rem; margin-top: 12px; margin-bottom: 4px; }
    .register-logo p { color: rgba(255,255,255,0.5); font-size: 0.87rem; }

    .form-label-custom { display: block; color: rgba(255,255,255,0.75); font-size: 0.82rem; font-weight: 600; margin-bottom: 8px; letter-spacing: 0.02em; }
    .form-control-custom {
      width: 100%; padding: 12px 16px;
      background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.12);
      border-radius: 12px; color: white; font-size: 0.92rem;
      font-family: 'Plus Jakarta Sans', sans-serif; outline: none;
      transition: all 0.2s;
    }
    .form-control-custom::placeholder { color: rgba(255,255,255,0.3); }
    .form-control-custom:focus { border-color: var(--green-500); background: rgba(255,255,255,0.12); }

    .password-wrapper { position: relative; }
    .password-toggle {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      color: rgba(255,255,255,0.4); cursor: pointer; background: none; border: none;
      font-size: 1rem; padding: 0; transition: color 0.2s;
    }
    .password-toggle:hover { color: rgba(255,255,255,0.8); }

    .btn-register {
      width: 100%; padding: 14px;
      background: var(--gold); color: var(--green-900);
      border: none; border-radius: 12px; font-size: 0.96rem; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
      transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-register:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(232,163,23,0.3); }
    .btn-register:active { transform: none; }

    .form-footer { text-align: center; margin-top: 24px; font-size: 0.87rem; color: rgba(255,255,255,0.55); }
    .form-footer a { color: rgba(255,255,255,0.85); font-weight: 600; text-decoration: none; }
    .form-footer a:hover { color: var(--green-400); }

    .btn-kembali {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      width: 100%; padding: 11px; margin-top: 12px;
      background: transparent; color: rgba(255,255,255,0.6);
      border: 1.5px solid rgba(255,255,255,0.15); border-radius: 12px;
      font-size: 0.88rem; font-weight: 500; cursor: pointer;
      text-decoration: none; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-kembali:hover { background: rgba(255,255,255,0.08); color: white; border-color: rgba(255,255,255,0.3); }

    .divider { display: flex; align-items: center; gap: 14px; margin: 20px 0; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.1); }
    .divider span { color: rgba(255,255,255,0.3); font-size: 0.8rem; }

    @media(max-width:480px) { .register-card { padding: 36px 28px; } }
  </style>
</head>
<body>
  <div class="decor-circle"></div>
  <div class="decor-circle"></div>

  <div class="register-wrapper">
    <div class="register-card">
      <div class="register-logo">
        <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo">
        <h2>Buat Akun Baru</h2>
        <p>Daftar sebagai Owner UMKM Kabupaten Bandung</p>
      </div>

      <!-- Flash messages via SweetAlert -->
      <?php if ($this->session->flashdata('success')): ?>
        <script>
          Swal.fire({ 
            icon:'success', 
            title:'Registrasi Berhasil!', 
            text:'<?php echo $this->session->flashdata('success'); ?>', 
            confirmButtonColor:'#16a34a' 
          }).then(r => { 
            if(r.isConfirmed) location.href='<?= site_url('auth/login') ?>'; 
          });
        </script>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <script>
          Swal.fire({ 
            icon:'error', 
            title:'Registrasi Gagal', 
            text:'<?php echo $this->session->flashdata('error'); ?>', 
            confirmButtonColor:'#16a34a' 
          });
        </script>
      <?php endif; ?>
      <?php if (validation_errors()): ?>
        <script>
          Swal.fire({ 
            icon:'error', 
            title:'Periksa Form', 
            text:'<?php echo addslashes(strip_tags(validation_errors())); ?>', 
            confirmButtonColor:'#16a34a' 
          });
        </script>
      <?php endif; ?>

      <form id="formRegistration" method="POST" action="<?= site_url('register') ?>" enctype="multipart/form-data">
        <div style="margin-bottom:20px;">
          <label class="form-label-custom" for="username">Username</label>
          <input type="text" class="form-control-custom" id="username" name="username" placeholder="Masukkan username" value="<?= set_value('username') ?>" required>
        </div>

        <div style="margin-bottom:20px;">
          <label class="form-label-custom" for="fullname">Nama Lengkap</label>
          <input type="text" class="form-control-custom" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" value="<?= set_value('fullname') ?>" required>
        </div>

        <div style="margin-bottom:20px;">
          <label class="form-label-custom" for="email">Email</label>
          <input type="email" class="form-control-custom" id="email" name="email" placeholder="Masukkan email" value="<?= set_value('email') ?>" required>
        </div>

        <div style="margin-bottom:20px;">
          <label class="form-label-custom" for="nomor_hp">Nomor HP</label>
          <input type="text" class="form-control-custom" id="nomor_hp" name="nomor_hp" placeholder="Masukkan nomor HP" value="<?= set_value('nomor_hp') ?>" required>
        </div>

        <div style="margin-bottom:20px;">
          <label class="form-label-custom" for="password">Password</label>
          <div class="password-wrapper">
            <input type="password" class="form-control-custom" id="password" name="password" placeholder="••••••••" required style="padding-right:44px;">
            <button type="button" class="password-toggle" id="togglePwd1" onclick="togglePassword('password', 'eyeIcon1')">
              <i class="bi bi-eye-slash" id="eyeIcon1"></i>
            </button>
          </div>
        </div>

        <div style="margin-bottom:28px;">
          <label class="form-label-custom" for="confpassword">Konfirmasi Password</label>
          <div class="password-wrapper">
            <input type="password" class="form-control-custom" id="confpassword" name="confpassword" placeholder="••••••••" required style="padding-right:44px;">
            <button type="button" class="password-toggle" id="togglePwd2" onclick="togglePassword('confpassword', 'eyeIcon2')">
              <i class="bi bi-eye-slash" id="eyeIcon2"></i>
            </button>
          </div>
        </div>

        <!-- Hidden Usertype -->
        <input type="hidden" name="usertype" value="Owner">

        <button type="submit" class="btn-register">
          <i class="bi bi-person-plus"></i> Daftar Sekarang
        </button>
      </form>

      <div class="divider"><span>atau</span></div>

      <a href="<?= site_url('/')?>" class="btn-kembali">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      <div class="form-footer" style="margin-top:28px;">
        Sudah punya akun? <a href="<?= site_url('auth/login')?>">Masuk sekarang</a>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(fieldId, iconId) {
      const pwd = document.getElementById(fieldId);
      const icon = document.getElementById(iconId);
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.className = 'bi bi-eye';
      } else {
        pwd.type = 'password';
        icon.className = 'bi bi-eye-slash';
      }
    }

    // Frontend validation
    document.getElementById('formRegistration').addEventListener('submit', function(event) {
      var password = document.getElementById('password').value;
      var confpassword = document.getElementById('confpassword').value;
      var email = document.getElementById('email').value;
      var username = document.getElementById('username').value;
      var fullname = document.getElementById('fullname').value;
      var nomor_hp = document.getElementById('nomor_hp').value;

      // Email Validation
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        Swal.fire({
          icon: 'error',
          title: 'Email tidak valid!',
          text: 'Format email tidak valid.',
          confirmButtonColor: '#16a34a'
        });
        event.preventDefault();
        return false;
      }

      // Username validation (min 3 characters)
      if (username.length < 3) {
        Swal.fire({
          icon: 'error',
          title: 'Username terlalu pendek!',
          text: 'Username minimal 3 karakter.',
          confirmButtonColor: '#16a34a'
        });
        event.preventDefault();
        return false;
      }

      // Fullname validation
      if (fullname.length < 3) {
        Swal.fire({
          icon: 'error',
          title: 'Nama lengkap terlalu pendek!',
          text: 'Nama lengkap minimal 3 karakter.',
          confirmButtonColor: '#16a34a'
        });
        event.preventDefault();
        return false;
      }

      // Phone number validation (min 10 digits)
      var phonePattern = /^[0-9]{10,13}$/;
      if (!phonePattern.test(nomor_hp.replace(/\s/g, ''))) {
        Swal.fire({
          icon: 'error',
          title: 'Nomor HP tidak valid!',
          text: 'Masukkan nomor HP yang valid (10-13 digit angka).',
          confirmButtonColor: '#16a34a'
        });
        event.preventDefault();
        return false;
      }

      // Check if Password and Confirm Password match
      if (password !== confpassword) {
        Swal.fire({
          icon: 'error',
          title: 'Password Tidak Cocok!',
          text: 'Password dan Konfirmasi Password tidak cocok.',
          confirmButtonColor: '#16a34a'
        });
        event.preventDefault();
        return false;
      }

      // Password strength (min 6 characters)
      if (password.length < 6) {
        Swal.fire({
          icon: 'error',
          title: 'Password terlalu lemah!',
          text: 'Password minimal 6 karakter.',
          confirmButtonColor: '#16a34a'
        });
        event.preventDefault();
        return false;
      }
    });
  </script>
</body>
</html>