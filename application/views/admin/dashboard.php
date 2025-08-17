<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<title>Dashboard</title>

<body>
<!-- Add these styles to make cards more attractive -->
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px; /* Rounded corners */
    }

    .card:hover {
        transform: translateY(-10px); /* Slight hover effect */
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
    }

    .hover-effect {
        cursor: pointer;
    }

    .card-body {
        padding: 20px;
    }

    .card i {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        padding: 20px;
        display: inline-block;
    }

    .text-xs {
        font-size: 0.85rem;
        font-weight: 500;
    }

    .h5 {
        font-size: 1.5rem;
    }

    .col-auto i {
        color: white;
    }

    /* ===== Dark Glassmorphism Card Style ===== */
.card {
  background: rgba(0, 0, 0, 0.6) !important; /* lebih gelap */
  border: 1px solid rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  color: #ffffff !important;
  border-radius: 12px;
}

/* Header dalam card */
.card-header {
  background: rgba(0, 0, 0, 0.5); /* header juga lebih gelap */
  color: white;
  font-weight: bold;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Warna teks tetap putih */
.card .text-primary,
.card .text-danger,
.card .text-warning,
.card .text-secondary {
  color: #ffffff !important;
}

/* Background ikon transparan tapi gelap */
.card .bg-primary,
.card .bg-danger,
.card .bg-warning,
.card .bg-secondary {
  background-color: rgba(255, 255, 255, 0.2) !important;
  color: #ffffff !important;
  border-radius: 50%;
  padding: 10px;
}

/* Grafik canvas tetap transparan */
canvas {
  background-color: transparent !important;
}

/* Hover efek */
.card.hover-effect:hover {
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.15);
  transform: scale(1.02);
  transition: all 0.3s ease-in-out;
}

</style>
 

  <?php include('sidebar.php'); ?>

  <!-- Content wrapper -->
  <div class="content-wrapper">
    <!-- Content -->
    <div class="container-fluid">
    <div class="row mt-3">

        <!-- Admin Card -->
        <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow-lg h-100 py-2 hover-effect">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Admin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-primary" id="admin-count">Loading...</div>
                        </div>
                        <div class="col-auto">
                            <!-- Reduce font-size for icon -->
                            <i class="menu-icon tf-icons bx bx-user bg-primary" style="font-size: 2em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Owner Card -->
        <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow-lg h-100 py-2 hover-effect">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Data Pemilik UMKM
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-danger" id="owner-count">Loading...</div>
                        </div>
                        <div class="col-auto">
                            <!-- Reduce font-size for icon -->
                            <i class="menu-icon tf-icons bx bx-group bg-danger" style="font-size: 2em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- UMKM Card -->
        <?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Admin'): ?>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow-lg h-100 py-2 hover-effect">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Data UMKM
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-warning" id="umkm-disetujui-count">Loading...</div>
                        </div>
                        <div class="col-auto">
                            <!-- Reduce font-size for icon -->
                            <i class="menu-icon tf-icons bx bx-cube-alt bg-warning" style="font-size: 2em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       

    </div>
</div>




    
    <div class="container-fluid">
    <div class="row">

        <!-- Left Side (Card 1 & Card 3) -->
        <div class="col-xl-6 col-md-8 mb-4">
            <div class="row">

                <!-- Card 1: Jumlah UMKM per Kategori -->
                <div class="col-12 mb-4">
                    <div class="card border-left-secondary shadow py-2">
                        <div class="card-header">
                            Jumlah UMKM per Kategori
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <canvas id="umkmChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Jumlah Desa per Kecamatan -->
                <div class="col-12 mb-4">
                    <div class="card border-left-secondary shadow py-2">
                        <div class="card-header">
                            Jumlah Desa per Kecamatan
                        </div>
                        <div class="card-body">
                            <canvas id="desaChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Side (Card 2) -->
        <div class="col-xl-6 col-md-8 mb-4">
            <div class="card border-left-secondary shadow py-2" style="height: 500px;">
                <div class="card-header">
                    Jumlah Desa per Kategori
                </div>
                <div class="card-body">
                    <canvas id="desasPieChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Card: Jumlah UMKM per Jenis Usaha -->
<div class="col-12 mb-10">
    <div class="card border-left-secondary shadow py-2">
        <div class="card-header">
            Jumlah UMKM per Jenis Usaha
        </div>
        <div class="card-body">
            <div style="width: 100%; height: 300px;"> <!-- Batas tinggi -->
                <canvas id="jenisUsahaChart" style="max-height: 100%; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>







<?php endif; ?>
<?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] === 'Owner'): ?>
<h1 style="color:white;">Selamat Datang di Dashboard</h1>
<?php endif; ?>

  <!-- Fetch Statistics -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: 'http://localhost:3000/api/jumlah-jenis-usaha',
        method: 'GET',
        success: function(response) {
            let jenisUsaha = [];
            let jumlah = [];
            let warna = [];

            if (response && response.length > 0) {
                response.forEach(function(row) {
                    jenisUsaha.push(row.jenis_usaha);
                    jumlah.push(row.jumlah);

                    const randomColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
                    warna.push(randomColor);
                });

                var ctx = document.getElementById('jenisUsahaChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: jenisUsaha,
                        datasets: [{
                            label: 'Jumlah UMKM',
                            data: jumlah,
                            backgroundColor: warna,
                            borderColor: warna,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Inilah bagian penting agar grafik horizontal
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        },
        error: function() {
            console.error('Gagal mengambil data');
            $('#jenisUsahaChart').after('<p class="text-danger">Gagal mengambil data untuk chart.</p>');
        }
    });
});
</script>


<script>
$(document).ready(function() {
  $.ajax({
    url: 'http://localhost:3000/api/count-owners',
    method: 'GET',
    success: function(response) {
      $('#owner-count').text(response.count);
    },
    error: function() {
      $('#owner-count').text('Error');
    }
  });
});
</script>
<script>
$(document).ready(function() {
  $.ajax({
    url: 'http://localhost:3000/api/count-admins',
    method: 'GET',
    success: function(response) {
      $('#admin-count').text(response.count);
    },
    error: function() {
      $('#admin-count').text('Error');
    }
  });
});
</script>
<script>
  $(document).ready(function() {
  $.ajax({
    url: 'http://localhost:3000/api/count-umkm-disetujui', // Endpoint untuk menghitung UMKM disetujui
    method: 'GET',
    success: function(response) {
      $('#umkm-disetujui-count').text(response.count); // Tampilkan jumlah UMKM disetujui di elemen dengan ID 'umkm-disetujui-count'
    },
    error: function() {
      $('#umkm-disetujui-count').text('Error'); // Tampilkan 'Error' jika terjadi kesalahan
    }
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: 'http://localhost:3000/api/umkm-per-kategori-disetujui',  // Pastikan URL sesuai dengan API Node.js Anda
        method: 'GET',
        success: function(response) {
            // Memproses data yang diterima dari API
            let kategoriProduk = [];
            let jumlahUmkm = [];
            let warna = []; // Array untuk menyimpan warna yang berbeda untuk setiap bar

            // Jika data ditemukan, ambil kategori dan jumlah UMKM
            if (response && response.length > 0) {
                response.forEach(function(row, index) {
                    kategoriProduk.push(row.kategori_produk);
                    jumlahUmkm.push(row.jumlah_umkm);

                    // Membuat warna acak untuk setiap bar
                    const randomColor = `hsl(${Math.random() * 360}, 100%, 50%)`; // Menghasilkan warna acak
                    warna.push(randomColor);  // Menyimpan warna yang dihasilkan
                });
            }

            // Menampilkan chart menggunakan Chart.js
            var ctx = document.getElementById('umkmChart').getContext('2d');
            var umkmChart = new Chart(ctx, {
                type: 'bar',  // Jenis chart (bar chart)
                data: {
                    labels: kategoriProduk,  // Kategori produk sebagai label
                    datasets: [{
                        label: 'Jumlah UMKM',
                        data: jumlahUmkm,  // Data jumlah UMKM per kategori
                        backgroundColor: warna,  // Warna yang berbeda untuk setiap bar
                        borderColor: warna,  // Warna border yang sesuai dengan bar
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,  // Agar chart responsif pada berbagai ukuran layar
                    scales: {
                        x: {
                            grid: {
                                display: false,  // Menonaktifkan grid pada sumbu X
                            },
                            ticks: {
                                display: true,  // Menampilkan label pada sumbu X
                            }
                        },
                        y: {
                            beginAtZero: true,  // Agar sumbu Y mulai dari angka 0
                            grid: {
                                display: false,  // Menonaktifkan grid pada sumbu Y
                            },
                            ticks: {
                                stepSize: 1,  // Menentukan jarak antara setiap tick di sumbu Y (hanya angka bulat)
                                callback: function(value) {
                                    // Menampilkan nilai bulat tanpa desimal
                                    return value % 1 === 0 ? value : '';  // Menampilkan hanya angka bulat
                                }
                            }
                        }
                    },
                    elements: {
                        line: {
                            borderWidth: 0 // Menonaktifkan garis untuk elemen line (jika ada)
                        }
                    }
                }
            });
        },
        error: function() {
            console.error('Error fetching data');
            // Menampilkan pesan error jika terjadi masalah saat mengambil data
            $('#umkmChart').after('<p>Error mengambil data untuk chart.</p>');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $.ajax({
        url: 'http://localhost:3000/api/jumlah-desa-per-kategori',  // Pastikan URL sesuai dengan API Node.js Anda
        method: 'GET',
        success: function(response) {
            let kategoriProduk = [];
            let jumlahDesa = [];
            let warna = []; // Array untuk warna

            if (response && response.length > 0) {
                response.forEach(function(row) {
                    kategoriProduk.push(row.kategori_produk);
                    jumlahDesa.push(row.jumlah_desa);
                    
                    // Membuat warna acak untuk setiap bagian chart
                    const randomColor = `hsl(${Math.random() * 360}, 100%, 50%)`; // Membuat warna acak
                    warna.push(randomColor);  // Menambahkan warna untuk setiap bagian chart
                });

                // Menampilkan Pie Chart menggunakan Chart.js
                var ctx = document.getElementById('desasPieChart').getContext('2d');
                var desasPieChart = new Chart(ctx, {
                    type: 'pie',  // Jenis chart (Pie chart)
                    data: {
                        labels: kategoriProduk,  // Label untuk setiap kategori produk
                        datasets: [{
                            data: jumlahDesa,  // Data jumlah desa per kategori
                            backgroundColor: warna,  // Menggunakan array warna untuk pie chart
                            borderColor: '#ffffff',  // Warna border di sekitar setiap bagian
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,  // Agar chart responsif pada berbagai ukuran layar
                        plugins: {
                            legend: {
                                position: 'top',  // Posisi legend di atas
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        // Menambahkan teks "Jumlah Desa: " sebelum nilai
                                        return 'Jumlah Desa: ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        },
        error: function() {
            console.error('Error fetching data');
            $('#desasPieChart').after('<p>Error mengambil data untuk chart.</p>');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $.ajax({
        url: 'http://localhost:3000/api/jumlah-desa-per-kecamatan', // Gantilah URL jika berbeda
        method: 'GET',
        success: function(response) {
            let kecamatan = [];
            let jumlahDesa = [];
            let warna = []; // Array untuk warna

            // Proses data dari API
            if (response && response.length > 0) {
                response.forEach(function(row, index) {
                    kecamatan.push(row.kecamatan);
                    jumlahDesa.push(row.jumlah_desa);
                    
                    // Menambahkan warna berbeda untuk setiap bar
                    const randomColor = `hsl(${Math.random() * 360}, 100%, 50%)`; // Membuat warna acak
                    warna.push(randomColor);  // Menambahkan warna untuk setiap bar
                });

                // Menampilkan chart dengan Chart.js
                var ctx = document.getElementById('desaChart').getContext('2d');
                var desaChart = new Chart(ctx, {
                    type: 'bar',  // Jenis chart (Bar Chart)
                    data: {
                        labels: kecamatan,  // Label untuk setiap kecamatan
                        datasets: [{
                            label: 'Jumlah Desa',  // Label dataset
                            data: jumlahDesa,  // Data jumlah desa per kecamatan
                            backgroundColor: warna,  // Menggunakan array warna untuk bar chart
                            borderColor: warna,  // Menggunakan array warna untuk border
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,  // Membuat chart responsif
                        scales: {
                            x: {
                                grid: {
                                    display: false,  // Menonaktifkan grid pada sumbu X
                                },
                                ticks: {
                                    display: true,  // Menampilkan label pada sumbu X
                                    maxRotation: 45,  // Rotasi label sumbu X agar lebih rapi
                                    autoSkip: true,   // Menghindari label tumpang tindih
                                }
                            },
                            y: {
                                beginAtZero: true,  // Mulai sumbu Y dari 0
                                grid: {
                                    display: false,  // Menonaktifkan grid pada sumbu Y
                                },
                                ticks: {
                                    stepSize: 1,  // Menentukan langkah pada sumbu Y agar hanya angka bulat
                                    callback: function(value) {
                                        // Menghapus desimal, hanya menampilkan angka bulat
                                        return value % 1 === 0 ? value : '';
                                    }
                                }
                            }
                        },
                        elements: {
                            line: {
                                borderWidth: 0 // Menonaktifkan garis untuk elemen line (jika ada)
                            }
                        }
                    }
                });
            }
        },
        error: function() {
            console.error('Error fetching data');
            $('#desaChart').after('<p>Error mengambil data untuk chart.</p>');
        }
    });
});
</script>
<script>
    // Show spinner when the DOM content is being loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Ensure the spinner is visible while content is loading
        document.getElementById("loading-spinner").style.display = "flex";
    });

    // Hide spinner when the entire page has loaded (including images, etc.)
    window.addEventListener("load", function() {
        // Delay hiding the spinner by 1 seconds (1000ms)
        setTimeout(function() {
            document.getElementById("loading-spinner").style.display = "none";
        }, 500); // Adjust this value for the desired delay
    });
</script>



</body>
</html>
