<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Tidak Ditemukan — UMKM Kabupaten Bandung</title>
  <link href="<?php echo base_url('assets/img/logo.png'); ?>" rel="icon">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f9fafb; min-height: 100vh; display: flex; align-items: center; }
    .error-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(0,0,0,.08); padding: 48px 40px; max-width: 520px; margin: 0 auto; text-align: center; }
    .error-icon { width: 72px; height: 72px; border-radius: 50%; background: #fef2f2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 20px; }
    h1 { font-size: 1.35rem; font-weight: 700; color: #1f2937; margin-bottom: 10px; }
    p { color: #4b5563; font-size: .93rem; }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="error-card">
      <div class="error-icon"><i class="bi bi-exclamation-triangle"></i></div>
      <h1>Data UMKM Tidak Dapat Ditampilkan</h1>
      <p><?php echo isset($message) ? htmlspecialchars($message) : 'Data yang diminta tidak ditemukan.'; ?></p>
      <div class="d-flex gap-2 justify-content-center mt-4 flex-wrap">
        <a href="javascript:history.back()" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        <a href="<?php echo site_url('/'); ?>" class="btn btn-success"><i class="bi bi-house"></i> Beranda</a>
      </div>
    </div>
  </div>
</body>
</html>
