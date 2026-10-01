<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fragmen penutup layout area admin — pasangan dari sidebar.php.
 *
 * Menutup div yang dibuka sidebar: container-xxl, content-wrapper,
 * layout-page, dan layout-container.
 * Lihat sidebar.php untuk urutan pembukaannya.
 *
 * jQuery/SweetAlert2 dimuat dengan guard global sehingga tetap SATU
 * per halaman meski sebuah view sudah memuatnya lebih dulu di <head>.
 */
?>
        </div><!-- /.container-xxl flex-grow-1 container-p-y -->
      </div><!-- /.content-wrapper -->
    </div><!-- /.layout-page -->
  </div><!-- /.layout-container -->
</div><!-- /.layout-wrapper -->

<!-- Spinner overlay global -->
<div id="loading-spinner">
  <div class="spinner-border" role="status" aria-label="Memuat"></div>
</div>

<p class="admin-footer-note">&copy; <?= date('Y'); ?> UMKM Kabupaten Bandung &mdash; Dinas Perdagangan &amp; Perindustrian</p>

<?php if (empty($GLOBALS['__admin_vendor_js'])): $GLOBALS['__admin_vendor_js'] = true; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php endif; ?>
<script src="<?= base_url('assets/vendor/libs/popper/popper.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/js/bootstrap.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/js/menu.js'); ?>"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>
<script>
(function () {
  'use strict';

  // Menampilkan/menyembunyikan spinner harus tetap bekerja baik untuk halaman
  // yang memakai kelas .show maupun yang menyetel style.display langsung.
  function showSpinner() {
    var s = document.getElementById('loading-spinner');
    if (s) {
      s.classList.add('show');
      s.style.display = 'flex';
    }
  }
  function hideSpinner() {
    var s = document.getElementById('loading-spinner');
    if (s) {
      s.classList.remove('show');
      s.style.display = 'none';
    }
  }
  window.adminShowSpinner = showSpinner;
  window.adminHideSpinner = hideSpinner;

  // (a) Sembunyikan spinner global begitu seluruh halaman selesai dimuat.
  window.addEventListener('load', function () {
    setTimeout(hideSpinner, 200);
  });

  // Tampilkan spinner saat user mengirim form admin.
  document.addEventListener('submit', function () {
    showSpinner();
  }, true);

  // (b) Flashdata CodeIgniter -> SweetAlert2. Teks di-escape lewat
  // json_encode sehingga tanda kutip pada pesan tidak merusak sintaks JS.
  window.adminFlash = function (kind, text) {
    if (!text || typeof Swal === 'undefined') {
      return;
    }
    Swal.fire({
      icon: kind === 'error' ? 'error' : 'success',
      title: kind === 'error' ? 'Terjadi Kesalahan' : 'Sukses',
      text: String(text)
    });
  };

  // (c) Submenu .menu-toggle — vanilla JS, tanpa jQuery ganda.
  document.querySelectorAll('.menu-toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      var item = toggle.closest('.menu-item');
      if (item) {
        item.classList.toggle('open');
      }
      var sub = toggle.nextElementSibling;
      if (sub && sub.classList.contains('menu-sub')) {
        sub.style.display = (sub.style.display === 'block') ? '' : 'block';
      }
    });
  });
})();
</script>
