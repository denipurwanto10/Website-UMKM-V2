<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk — UMKM Kabupaten Bandung</title>
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
      overflow: hidden; position: relative;
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

    .login-wrapper { position: relative; z-index: 10; width: 100%; padding: 24px; }

    .login-card {
      background: rgba(255,255,255,0.07);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 24px;
      padding: 48px 44px;
      max-width: 440px;
      margin: 0 auto;
      backdrop-filter: blur(20px);
    }
    .login-logo { text-align: center; margin-bottom: 32px; }
    .login-logo img { width: 64px; height: 64px; object-fit: contain; }
    .login-logo h2 { font-family: 'DM Serif Display', serif; color: white; font-size: 1.5rem; margin-top: 12px; margin-bottom: 4px; }
    .login-logo p { color: rgba(255,255,255,0.5); font-size: 0.87rem; }

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

    .btn-login {
      width: 100%; padding: 14px;
      background: var(--gold); color: var(--green-900);
      border: none; border-radius: 12px; font-size: 0.96rem; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
      transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-login:hover { background: var(--gold-light); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(232,163,23,0.3); }
    .btn-login:active { transform: none; }

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

    @media(max-width:480px) { .login-card { padding: 36px 28px; } }
  </style>
</head>
<body>
  <div class="decor-circle"></div>
  <div class="decor-circle"></div>

  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-logo">
        <img src="<?php echo base_url('assets/img/logo.png')?>" alt="Logo">
        <h2>Selamat Datang</h2>
        <p>Masuk ke akun UMKM Kabupaten Bandung</p>
      </div>

      <!-- Flash messages via SweetAlert -->
      <?php if ($this->session->flashdata('success')): ?>
        <script>
          Swal.fire({ icon:'success', title:'Login Berhasil', text:'<?php echo $this->session->flashdata('success'); ?>', confirmButtonColor:'#16a34a' })
          .then(r => { if(r.isConfirmed) location.href='<?= site_url('dashboard') ?>'; });
        </script>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <script>
          Swal.fire({ icon:'error', title:'Login Gagal', text:'<?php echo $this->session->flashdata('error'); ?>', confirmButtonColor:'#16a34a' });
        </script>
      <?php endif; ?>
      <?php if (validation_errors()): ?>
        <script>
          Swal.fire({ icon:'error', title:'Periksa Form', text:'<?php echo addslashes(strip_tags(validation_errors())); ?>', confirmButtonColor:'#16a34a' });
        </script>
      <?php endif; ?>

      <form id="formLogin" method="POST" action="<?= site_url('auth/login')?>" enctype="multipart/form-data">
        <div style="margin-bottom:20px;">
          <label class="form-label-custom" for="username">Username</label>
          <input type="text" class="form-control-custom" id="username" name="username" placeholder="Masukkan username" autocomplete="username" required>
        </div>
        <div style="margin-bottom:28px;">
          <label class="form-label-custom" for="password">Password</label>
          <div class="password-wrapper">
            <input type="password" class="form-control-custom" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required style="padding-right:44px;">
            <button type="button" class="password-toggle" id="togglePwd" onclick="togglePassword()">
              <i class="bi bi-eye-slash" id="eyeIcon"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn-login">
          <i class="bi bi-box-arrow-in-right"></i> Masuk
        </button>
      </form>

      <div class="divider"><span>atau</span></div>

      <a href="<?= site_url('/')?>" class="btn-kembali">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      <div class="form-footer" style="margin-top:28px;">
        Belum punya akun? <a href="<?= site_url('auth/register')?>">Daftar sekarang</a>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      const icon = document.getElementById('eyeIcon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.className = 'bi bi-eye';
      } else {
        pwd.type = 'password';
        icon.className = 'bi bi-eye-slash';
      }
    }
  </script>
</body>
</html>