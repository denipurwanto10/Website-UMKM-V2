<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fragmen pembuka layout area admin.
 *
 * File ini BUKAN dokumen HTML penuh: ia hanya membuka elemen layout
 * (wrapper, sidebar, navbar, content-wrapper) sehingga halaman admin
 * dapat menentukan <head> dan gaya khususnya sendiri.
 * Penutup layout, spinner, dan seluruh pustaka JS berada di layout_footer.php.
 *
 * @var array|null $session_user User yang login (dipass controller edit_user).
 * @var array|null $user         Di halaman edit user = record API; di halaman
 *                               lain = user login dari session.
 * Blok navbar memakai $nav_user efektif agar foto/nama/usertype yang tampil
 * selalu milik user yang login, bukan record yang sedang diedit.
 */
$nav_user = isset($session_user) && is_array($session_user) && !empty($session_user)
    ? $session_user
    : (isset($user) && is_array($user) ? $user : []);
$currentUser  = $nav_user;
$usertype     = isset($currentUser['usertype']) ? $currentUser['usertype'] : '';
$isAdmin      = ($usertype === 'Admin');
$isOwner      = ($usertype === 'Owner');

// Foto profil selalu aman: fallback ke avatar bawaan bila tidak ada / kosong.
if (!empty($currentUser['photo'])) {
    $userPhoto = base_url('uploads/users/' . $currentUser['photo']);
} else {
    $userPhoto = base_url('assets/img/avatars/1.png');
}

$navUsername = !empty($currentUser['username'])
    ? htmlspecialchars($currentUser['username'], ENT_QUOTES, 'UTF-8')
    : '';
$navFullname = !empty($currentUser['fullname'])
    ? htmlspecialchars($currentUser['fullname'], ENT_QUOTES, 'UTF-8')
    : $navUsername;
$userFullname = ($navFullname !== '') ? $navFullname : 'Pengguna';
?>
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">

    <!-- ===================== Sidebar ===================== -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="<?= site_url('dashboard'); ?>" class="menu-link d-block">
          <span class="app-brand-logo demo">
            <img src="<?= base_url('assets/img/avatars/logo.png'); ?>" alt="Logo UMKM" width="50" height="50">
          </span>
          <span class="app-brand-text demo menu-text fw-bolder ms-2 text-white">UMKM</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none" aria-label="Tutup menu">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">
        <li class="menu-item">
          <a href="<?= site_url('dashboard'); ?>" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
          </a>
        </li>

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Menu</span>
        </li>

        <?php if ($isAdmin): ?>
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-cube-alt"></i>
              <div data-i18n="Account Settings">MSME Data</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="<?= site_url('menunggu'); ?>" class="menu-link">
                  <div data-i18n="Account">List UMKM Menunggu</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="<?= site_url('disetujui'); ?>" class="menu-link">
                  <div data-i18n="Notifications">List UMKM Disetujui</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="<?= site_url('ditolak'); ?>" class="menu-link">
                  <div data-i18n="Notifications">List UMKM Ditolak</div>
                </a>
              </li>
            </ul>
          </li>

          <li class="menu-item">
            <a href="<?= site_url('promosi'); ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-layout"></i>
              <div data-i18n="Basic">Promotion</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="<?= site_url('users'); ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-group"></i>
              <div data-i18n="Basic">Users</div>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($isOwner): ?>
          <li class="menu-item">
            <a href="<?= site_url('data_umkm'); ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-cube-alt"></i>
              <div data-i18n="Basic">Data UMKM</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="<?= site_url('promosi1'); ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-layout"></i>
              <div data-i18n="Basic">Promosi</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="<?= site_url('users1'); ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-group"></i>
              <div data-i18n="Basic">Pengguna</div>
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Logout: ditempel di bawah lewat margin-top:auto dari admin.css -->
      <ul class="menu-inner py-1 menu-logout">
        <li class="menu-item">
          <a href="<?= site_url('logout'); ?>" class="menu-link">
            <i class="bx bx-power-off me-2"></i>
            <div data-i18n="Basic">Logout</div>
          </a>
        </li>
      </ul>
    </aside>
    <!-- / Sidebar -->

    <div class="layout-page">

      <!-- ===================== Navbar ===================== -->
      <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar"
      >
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" aria-label="Buka menu">
            <i class="bx bx-menu bx-sm"></i>
          </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-label="Menu pengguna">
                <span class="avatar avatar-online">
                  <img src="<?= $userPhoto; ?>" alt="Foto profil" class="rounded-circle" style="width: 55px; height: 45px; object-fit: cover;">
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <div class="dropdown-item d-flex">
                    <div class="flex-shrink-0 me-3">
                      <span class="avatar avatar-online">
                        <img src="<?= $userPhoto; ?>" alt="Foto profil" class="rounded-circle" style="width: 50px; height: 45px; object-fit: cover;">
                      </span>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block"><?= $userFullname; ?></span>
                      <span class="fw-semibold d-block text-white-50"><?= $usertype !== '' ? htmlspecialchars($usertype, ENT_QUOTES, 'UTF-8') : 'Pengguna'; ?></span>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                </li>

                <?php if ($isOwner): ?>
                  <li>
                    <a class="dropdown-item" href="<?= site_url('users1'); ?>">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">My Profile</span>
                    </a>
                  </li>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                  <li>
                    <a class="dropdown-item" href="<?= site_url('profil'); ?>">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">My Profile</span>
                    </a>
                  </li>
                <?php endif; ?>

                <li>
                  <div class="dropdown-divider"></div>
                </li>
                <li>
                  <a class="dropdown-item" href="<?= site_url('logout'); ?>">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!-- / Navbar -->

      <!-- ===================== Konten ===================== -->
      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
