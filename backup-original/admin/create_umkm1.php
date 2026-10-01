<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create UMKM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
       <style>
           /* Update the existing CSS or add these new rules */
.card {
  background: rgba(0, 0, 0, 0.5) !important;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: none; /* Remove border */
  color: #fff;
}



/* Table Styling */
.table {
  color: #fff !important;
  border-collapse: collapse; /* Remove space between borders */
}

.table thead th {
   background: rgba(0, 0, 0, 0.5) !important;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: none; /* Remove border */
  color: #fff;
}

.table tbody tr {
  background-color: rgba(0, 0, 0, 0.3) !important;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Subtle border for row separation */
}

.table tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.4) !important;
}

.table td, .table th {
  padding: 12px 15px;
}

/* Make the table more responsive */
.table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch; /* Smooth scrolling on mobile */
}

@media (max-width: 768px) {
  .table td, .table th {
    font-size: 12px;
    padding: 8px 10px; /* Smaller padding for mobile */
  }

  .table img {
    width: 40px;
    height: 40px;
  }

  .action-buttons {
    display: block;
    margin-top: 5px;
  }

  .table-container {
    max-height: 400px; /* Adjust for mobile view */
    overflow-y: auto;
  }
}

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

.form-select {
  background-color: rgba(0, 0, 0, 0.3) !important;
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #fff !important;
}

.form-select-focus {
   background-color: rgba(0, 0, 0, 0.4) !important;
  border-color: rgba(255, 255, 255, 0.3);
  box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

/* Button Styling */
.btn-primary {
  background-color: rgba(41, 128, 185, 0.8) !important;
  border-color: rgba(41, 128, 185, 0.9);
}

.btn-warning {
  background-color: rgba(255, 193, 7, 0.8) !important;
  border-color: rgba(255, 193, 7, 0.9);
}

.btn-danger {
  background-color: rgba(220, 53, 69, 0.8) !important;
  border-color: rgba(220, 53, 69, 0.9);
}

/* Badge Styling */
.badge-admin {
  background-color: rgba(23, 162, 184, 0.8) !important;
}

.badge-owner {
  background-color: rgba(108, 117, 125, 0.8) !important;
}

/* Flexbox for Edit & Delete buttons */
.action-buttons {
  display: flex;
  gap: 5px;
}

        /* Table container with fixed height and scroll */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }

        /* Entry selector and search row styles */
        .entries-search-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .entries-selector {
            display: flex;
            align-items: center;
        }
        
        .entries-selector label {
            margin-right: 10px;
            margin-bottom: 0;
        }
        
        .entries-selector select {
            width: 70px;
            margin-right: 10px;
        }
        
        /* Search input styles */
        .search-container {
            display: flex;
            align-items: center;
        }
        
        .search-container label {
            margin-right: 10px;
            margin-bottom: 0;
        }
        
        .search-container input {
            min-width: 250px;
        }
        
        /* Pagination styles */
        .pagination-info {
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .custom-pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }
        
        .custom-pagination .page-item .page-link {
            border-radius: 0;
            margin: 0 2px;
            color: #6c757d;
        }
        
        .custom-pagination .page-item.active .page-link {
            background-color: #6366f1;
            border-color: #6366f1;
            color: white;
        }
        
        .custom-pagination .page-item .page-link:hover {
            background-color: #e9ecef;
        }
        
       /* Sortable Headers */
th.sortable {
  cursor: pointer;
}

th.sortable::after {
  content: '\f0dc';
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  margin-left: 5px;
  color: #ccc;
}

th.sortable.asc::after {
  content: '\f0de';
  color: #007bff;
}

th.sortable.desc::after {
  content: '\f0dd';
  color: #007bff;
}
      /* Pagination Container */
.pagination-info {
  color: rgba(255, 255, 255, 0.8) !important; /* Warna teks lebih terang di background gelap */
}

/* Pagination Items */
.custom-pagination .page-item .page-link {
  background-color: rgba(0, 0, 0, 0.4) !important;
  border-color: rgba(255, 255, 255, 0.15) !important;
  color: rgba(255, 255, 255, 0.8) !important;
}

.custom-pagination .page-item.active .page-link {
  background-color: rgba(99, 102, 241, 0.8) !important;
  border-color: rgba(99, 102, 241, 0.9) !important;
  color: white !important;
}

.custom-pagination .page-item.disabled .page-link {
  background-color: rgba(0, 0, 0, 0.2) !important;
  color: rgba(255, 255, 255, 0.5) !important;
}

.custom-pagination .page-item:hover:not(.active):not(.disabled) .page-link {
  background-color: rgba(255, 255, 255, 0.1) !important;
}

/* Alert Warning */
.alert-warning {
  background-color: rgba(255, 193, 7, 0.15) !important;
  border-color: rgba(255, 193, 7, 0.25) !important;
  color: rgba(255, 255, 255, 0.9) !important;
  backdrop-filter: blur(5px);
  -webkit-backdrop-filter: blur(5px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .entries-search-row {
    flex-direction: column;
    gap: 15px;
  }
  
  .entries-selector, .search-container {
    width: 100%;
  }
  
  .search-container input {
    min-width: 100% !important;
  }
  
  .custom-pagination {
    justify-content: center !important;
  }
}  
    </style>
 
    <?php include('sidebar.php'); ?>
    <div class="container mt-3">

        <!-- Flash message for success or error -->
        <?php if($this->session->flashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('message'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="card">
        <div class="card-header">
            <h5 style="color:white;">Tambah UMKM</h5>
        </div>
        <div class="card-body">
        <!-- Form for creating UMKM -->
        <form action="<?php echo site_url('umkm/store1'); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
             <!-- Owner Name -->
             <div class="mb-3">
                <label style="color:white;" for="pemilik" class="form-label">Nama Pemilik</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required readonly>
            </div>

            <!-- UMKM Name -->
            <div class="mb-3">
                <label style="color:white;" for="nama_umkm" class="form-label">Nama Usaha</label>
                <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" value="<?= set_value('nama_usaha'); ?>" required>
            </div>

            <!-- UMKM Merek -->
            <div class="mb-3">
                <label style="color:white;" for="nama_umkm" class="form-label">Nama Merek Produk</label>
                <input type="text" class="form-control" id="nama_merek_produk" name="nama_merek_produk" value="<?= set_value('nama_merek_produk'); ?>" required>
            </div>

            <!-- UMKM Alamat -->
<div class="mb-3">
    <label style="color:white;" for="jalan" class="form-label">Jalan</label>
    <input type="text" class="form-control" id="jalan" name="jalan" value="<?= set_value('jalan'); ?>" required>
</div>

<div class="mb-3">
    <label style="color:white;" for="kecamatan" class="form-label">Kecamatan</label>
    <select class="form-control" id="kecamatan" name="kecamatan" required>
        <option value="" disabled selected>Pilih Kecamatan</option>
        <option value="Arjasari" <?= set_value('kecamatan') == 'Arjasari' ? 'selected' : '' ?>>Arjasari</option>
        <option value="Baleendah" <?= set_value('kecamatan') == 'Baleendah' ? 'selected' : '' ?>>Baleendah</option>
        <option value="Banjaran" <?= set_value('kecamatan') == 'Banjaran' ? 'selected' : '' ?>>Banjaran</option>
        <option value="Bojongsoang" <?= set_value('kecamatan') == 'Bojongsoang' ? 'selected' : '' ?>>Bojongsoang</option>
        <option value="Cangkuang" <?= set_value('kecamatan') == 'Cangkuang' ? 'selected' : '' ?>>Cangkuang</option>
        <option value="Cicalengka" <?= set_value('kecamatan') == 'Cicalengka' ? 'selected' : '' ?>>Cicalengka</option>
        <option value="Cikancung" <?= set_value('kecamatan') == 'Cikancung' ? 'selected' : '' ?>>Cikancung</option>
        <option value="Cilengkrang" <?= set_value('kecamatan') == 'Cilengkrang' ? 'selected' : '' ?>>Cilengkrang</option>
        <option value="Cileunyi" <?= set_value('kecamatan') == 'Cileunyi' ? 'selected' : '' ?>>Cileunyi</option>
        <option value="Cimaung" <?= set_value('kecamatan') == 'Cimaung' ? 'selected' : '' ?>>Cimaung</option>
        <option value="Cimenyan" <?= set_value('kecamatan') == 'Cimenyan' ? 'selected' : '' ?>>Cimenyan</option>
        <option value="Ciparay" <?= set_value('kecamatan') == 'Ciparay' ? 'selected' : '' ?>>Ciparay</option>
        <option value="Ciwidey" <?= set_value('kecamatan') == 'Ciwidey' ? 'selected' : '' ?>>Ciwidey</option>
        <option value="Dayeuhkolot" <?= set_value('kecamatan') == 'Dayeuhkolot' ? 'selected' : '' ?>>Dayeuhkolot</option>
        <option value="Ibun" <?= set_value('kecamatan') == 'Ibun' ? 'selected' : '' ?>>Ibun</option>
        <option value="Katapang" <?= set_value('kecamatan') == 'Katapang' ? 'selected' : '' ?>>Katapang</option>
        <option value="Kertasari" <?= set_value('kecamatan') == 'Kertasari' ? 'selected' : '' ?>>Kertasari</option>
        <option value="Kutawaringin" <?= set_value('kecamatan') == 'Kutawaringin' ? 'selected' : '' ?>>Kutawaringin</option>
        <option value="Majalaya" <?= set_value('kecamatan') == 'Majalaya' ? 'selected' : '' ?>>Majalaya</option>
        <option value="Margaasih" <?= set_value('kecamatan') == 'Margaasih' ? 'selected' : '' ?>>Margaasih</option>
        <option value="Margahayu" <?= set_value('kecamatan') == 'Margahayu' ? 'selected' : '' ?>>Margahayu</option>
        <option value="Nagreg" <?= set_value('kecamatan') == 'Nagreg' ? 'selected' : '' ?>>Nagreg</option>
        <option value="Pacet" <?= set_value('kecamatan') == 'Pacet' ? 'selected' : '' ?>>Pacet</option>
        <option value="Pameungpeuk" <?= set_value('kecamatan') == 'Pameungpeuk' ? 'selected' : '' ?>>Pameungpeuk</option>
        <option value="Pangalengan" <?= set_value('kecamatan') == 'Pangalengan' ? 'selected' : '' ?>>Pangalengan</option>
        <option value="Paseh" <?= set_value('kecamatan') == 'Paseh' ? 'selected' : '' ?>>Paseh</option>
        <option value="Pasirjambu" <?= set_value('kecamatan') == 'Pasirjambu' ? 'selected' : '' ?>>Pasirjambu</option>
        <option value="Rancabali" <?= set_value('kecamatan') == 'Rancabali' ? 'selected' : '' ?>>Rancabali</option>
        <option value="Rancaekek" <?= set_value('kecamatan') == 'Rancaekek' ? 'selected' : '' ?>>Rancaekek</option>
        <option value="Solokanjeruk" <?= set_value('kecamatan') == 'Solokanjeruk' ? 'selected' : '' ?>>Solokanjeruk</option>
        <option value="Soreang" <?= set_value('kecamatan') == 'Soreang' ? 'selected' : '' ?>>Soreang</option>
    </select>
</div>

<div class="mb-3">
    <label style="color:white;" for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
    <select class="form-control" id="desa_kelurahan" name="desa_kelurahan" required>
        <option value="" disabled selected>Pilih Desa/Kelurahan</option>
        <!-- Desa Arjasari -->
        <option value="Ancolmekar" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Ancolmekar' ? 'selected' : '' ?>>Ancolmekar</option>
        <option value="Arjasari" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Arjasari' ? 'selected' : '' ?>>Arjasari</option>
        <option value="Baros" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Baros' ? 'selected' : '' ?>>Baros</option>
        <option value="Batukarut" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Batukarut' ? 'selected' : '' ?>>Batukarut</option>
        <option value="Lebakwangi" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Lebakwangi' ? 'selected' : '' ?>>Lebakwangi</option>
        <option value="Mangunjaya" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Mangunjaya' ? 'selected' : '' ?>>Mangunjaya</option>
        <option value="Mekarjaya" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Mekarjaya' ? 'selected' : '' ?>>Mekarjaya</option>
        <option value="Patrolsari" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Patrolsari' ? 'selected' : '' ?>>Patrolsari</option>
        <option value="Pinggirsari" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Pinggirsari' ? 'selected' : '' ?>>Pinggirsari</option>
        <option value="Rancakole" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Rancakole' ? 'selected' : '' ?>>Rancakole</option>
        <option value="Wargaluyu" class="desa arjasari" <?= set_value('desa_kelurahan') == 'Wargaluyu' ? 'selected' : '' ?>>Wargaluyu</option>
         <!-- Desa Baleendah -->
         <option value="Bojongmalaka" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Bojongmalaka' ? 'selected' : '' ?>>Bojongmalaka</option>
        <option value="Malakasari" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Malakasari' ? 'selected' : '' ?>>Malakasari</option>
        <option value="Rancamanyar" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Rancamanyar' ? 'selected' : '' ?>>Rancamanyar</option>
        <option value="Andir" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Andir' ? 'selected' : '' ?>>Andir</option>
        <option value="Baleendah" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Baleendah' ? 'selected' : '' ?>>Baleendah</option>
        <option value="Jelekong" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Jelekong' ? 'selected' : '' ?>>Jelekong</option>
        <option value="Manggahang" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Manggahang' ? 'selected' : '' ?>>Manggahang</option>
        <option value="Wargamekar" class="desa baleendah" <?= set_value('desa_kelurahan') == 'Wargamekar' ? 'selected' : '' ?>>Wargamekar</option>
        <!-- Desa Banjaran -->
<option value="Banjaran" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Banjaran' ? 'selected' : '' ?>>Banjaran</option>
<option value="Banjaran Wetan" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Banjaran Wetan' ? 'selected' : '' ?>>Banjaran Wetan</option>
<option value="Ciapus" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Ciapus' ? 'selected' : '' ?>>Ciapus</option>
<option value="Kamasan" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Kamasan' ? 'selected' : '' ?>>Kamasan</option>
<option value="Kiangroke" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Kiangroke' ? 'selected' : '' ?>>Kiangroke</option>
<option value="Margahurip" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Margahurip' ? 'selected' : '' ?>>Margahurip</option>
<option value="Mekarjaya" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Mekarjaya' ? 'selected' : '' ?>>Mekarjaya</option>
<option value="Neglasari" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Neglasari' ? 'selected' : '' ?>>Neglasari</option>
<option value="Pasirmulya" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Pasirmulya' ? 'selected' : '' ?>>Pasirmulya</option>
<option value="Sindangpanon" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Sindangpanon' ? 'selected' : '' ?>>Sindangpanon</option>
<option value="Tarajusari" class="desa banjaran" <?= set_value('desa_kelurahan') == 'Tarajusari' ? 'selected' : '' ?>>Tarajusari</option>
<!-- Desa Bojongsoang -->
<option value="Bojongsari" class="desa bojongsoang" <?= set_value('desa_kelurahan') == 'Bojongsari' ? 'selected' : '' ?>>Bojongsari</option>
<option value="Bojongsoang" class="desa bojongsoang" <?= set_value('desa_kelurahan') == 'Bojongsoang' ? 'selected' : '' ?>>Bojongsoang</option>
<option value="Buahbatu" class="desa bojongsoang" <?= set_value('desa_kelurahan') == 'Buahbatu' ? 'selected' : '' ?>>Buahbatu</option>
<option value="Cipagalo" class="desa bojongsoang" <?= set_value('desa_kelurahan') == 'Cipagalo' ? 'selected' : '' ?>>Cipagalo</option>
<option value="Lengkong" class="desa bojongsoang" <?= set_value('desa_kelurahan') == 'Lengkong' ? 'selected' : '' ?>>Lengkong</option>
<option value="Tegalluar" class="desa bojongsoang" <?= set_value('desa_kelurahan') == 'Tegalluar' ? 'selected' : '' ?>>Tegalluar</option>
<!-- Desa Cangkuang -->
<option value="Bandasari" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Bandasari' ? 'selected' : '' ?>>Bandasari</option>
<option value="Cangkuang" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Cangkuang' ? 'selected' : '' ?>>Cangkuang</option>
<option value="Ciluncat" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Ciluncat' ? 'selected' : '' ?>>Ciluncat</option>
<option value="Jatisari" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Jatisari' ? 'selected' : '' ?>>Jatisari</option>
<option value="Nagrak" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Nagrak' ? 'selected' : '' ?>>Nagrak</option>
<option value="Pananjung" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Pananjung' ? 'selected' : '' ?>>Pananjung</option>
<option value="Tanjungsari" class="desa cangkuang" <?= set_value('desa_kelurahan') == 'Tanjungsari' ? 'selected' : '' ?>>Tanjungsari</option>
<!-- Desa Cicalengka -->
<option value="Babakan Peuteuy" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Babakan Peuteuy' ? 'selected' : '' ?>>Babakan Peuteuy</option>
<option value="Cicalengka Kulon" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Cicalengka Kulon' ? 'selected' : '' ?>>Cicalengka Kulon</option>
<option value="Cicalengka Wetan" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Cicalengka Wetan' ? 'selected' : '' ?>>Cicalengka Wetan</option>
<option value="Cikuya" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Cikuya' ? 'selected' : '' ?>>Cikuya</option>
<option value="Dampit" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Dampit' ? 'selected' : '' ?>>Dampit</option>
<option value="Margaasih" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Margaasih' ? 'selected' : '' ?>>Margaasih</option>
<option value="Nagrog" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Nagrog' ? 'selected' : '' ?>>Nagrog</option>
<option value="Narawita" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Narawita' ? 'selected' : '' ?>>Narawita</option>
<option value="Panenjoan" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Panenjoan' ? 'selected' : '' ?>>Panenjoan</option>
<option value="Tanjungwangi" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Tanjungwangi' ? 'selected' : '' ?>>Tanjungwangi</option>
<option value="Tenjolaya" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Tenjolaya' ? 'selected' : '' ?>>Tenjolaya</option>
<option value="Waluya" class="desa cicalengka" <?= set_value('desa_kelurahan') == 'Waluya' ? 'selected' : '' ?>>Waluya</option>
<!-- Desa Cikancung -->
<option value="Cihanyir" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Cihanyir' ? 'selected' : '' ?>>Cihanyir</option>
<option value="Cikancung" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Cikancung' ? 'selected' : '' ?>>Cikancung</option>
<option value="Cikasungka" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Cikasungka' ? 'selected' : '' ?>>Cikasungka</option>
<option value="Ciluluk" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Ciluluk' ? 'selected' : '' ?>>Ciluluk</option>
<option value="Hegarmanah" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Hegarmanah' ? 'selected' : '' ?>>Hegarmanah</option>
<option value="Mandalasari" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Mandalasari' ? 'selected' : '' ?>>Mandalasari</option>
<option value="Mekarlaksana" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Mekarlaksana' ? 'selected' : '' ?>>Mekarlaksana</option>
<option value="Srirahayu" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Srirahayu' ? 'selected' : '' ?>>Srirahayu</option>
<option value="Tanjunglaya" class="desa cikancung" <?= set_value('desa_kelurahan') == 'Tanjunglaya' ? 'selected' : '' ?>>Tanjunglaya</option>
<!-- Desa Cilengkrang -->
<option value="Cilengkrang" class="desa cilengkrang" <?= set_value('desa_kelurahan') == 'Cilengkrang' ? 'selected' : '' ?>>Cilengkrang</option>
<option value="Cipanjalu" class="desa cilengkrang" <?= set_value('desa_kelurahan') == 'Cipanjalu' ? 'selected' : '' ?>>Cipanjalu</option>
<option value="Ciporeat" class="desa cilengkrang" <?= set_value('desa_kelurahan') == 'Ciporeat' ? 'selected' : '' ?>>Ciporeat</option>
<option value="Girimekar" class="desa cilengkrang" <?= set_value('desa_kelurahan') == 'Girimekar' ? 'selected' : '' ?>>Girimekar</option>
<option value="Jatiendah" class="desa cilengkrang" <?= set_value('desa_kelurahan') == 'Jatiendah' ? 'selected' : '' ?>>Jatiendah</option>
<option value="Melatiwangi" class="desa cilengkrang" <?= set_value('desa_kelurahan') == 'Melatiwangi' ? 'selected' : '' ?>>Melatiwangi</option>
<!-- Desa Cileunyi -->
<option value="Cibiru Hilir" class="desa cileunyi" <?= set_value('desa_kelurahan') == 'Cibiru Hilir' ? 'selected' : '' ?>>Cibiru Hilir</option>
<option value="Cibiru Wetan" class="desa cileunyi" <?= set_value('desa_kelurahan') == 'Cibiru Wetan' ? 'selected' : '' ?>>Cibiru Wetan</option>
<option value="Cileunyi Kulon" class="desa cileunyi" <?= set_value('desa_kelurahan') == 'Cileunyi Kulon' ? 'selected' : '' ?>>Cileunyi Kulon</option>
<option value="Cileunyi Wetan" class="desa cileunyi" <?= set_value('desa_kelurahan') == 'Cileunyi Wetan' ? 'selected' : '' ?>>Cileunyi Wetan</option>
<option value="Cimekar" class="desa cileunyi" <?= set_value('desa_kelurahan') == 'Cimekar' ? 'selected' : '' ?>>Cimekar</option>
<option value="Cinunuk" class="desa cileunyi" <?= set_value('desa_kelurahan') == 'Cinunuk' ? 'selected' : '' ?>>Cinunuk</option>
<!-- Desa Cimaung -->
<option value="Campakamulya" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Campakamulya' ? 'selected' : '' ?>>Campakamulya</option>
<option value="Cikalong" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Cikalong' ? 'selected' : '' ?>>Cikalong</option>
<option value="Cimaung" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Cimaung' ? 'selected' : '' ?>>Cimaung</option>
<option value="Cipinang" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Cipinang' ? 'selected' : '' ?>>Cipinang</option>
<option value="Jagabaya" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Jagabaya' ? 'selected' : '' ?>>Jagabaya</option>
<option value="Malasari" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Malasari' ? 'selected' : '' ?>>Malasari</option>
<option value="Mekarsari" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Pasirhuni" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Pasirhuni' ? 'selected' : '' ?>>Pasirhuni</option>
<option value="Sukamaju" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Sukamaju' ? 'selected' : '' ?>>Sukamaju</option>
<option value="Warjabakti" class="desa cimaung" <?= set_value('desa_kelurahan') == 'Warjabakti' ? 'selected' : '' ?>>Warjabakti</option>
<!-- Desa Cimenyan -->
<option value="Ciburial" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Ciburial' ? 'selected' : '' ?>>Ciburial</option>
<option value="Cikadut" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Cikadut' ? 'selected' : '' ?>>Cikadut</option>
<option value="Cimenyan" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Cimenyan' ? 'selected' : '' ?>>Cimenyan</option>
<option value="Mandalamekar" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Mandalamekar' ? 'selected' : '' ?>>Mandalamekar</option>
<option value="Mekarmanik" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Mekarmanik' ? 'selected' : '' ?>>Mekarmanik</option>
<option value="Mekarsaluyu" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Mekarsaluyu' ? 'selected' : '' ?>>Mekarsaluyu</option>
<option value="Sindanglaya" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Sindanglaya' ? 'selected' : '' ?>>Sindanglaya</option>
<option value="Cibeunying" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Cibeunying' ? 'selected' : '' ?>>Cibeunying</option>
<option value="Padasuka" class="desa cimenyan" <?= set_value('desa_kelurahan') == 'Padasuka' ? 'selected' : '' ?>>Padasuka</option>
<!-- Desa Ciparay -->
<option value="Babakan" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Babakan' ? 'selected' : '' ?>>Babakan</option>
<option value="Bumiwangi" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Bumiwangi' ? 'selected' : '' ?>>Bumiwangi</option>
<option value="Ciheulang" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Ciheulang' ? 'selected' : '' ?>>Ciheulang</option>
<option value="Cikoneng" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Cikoneng' ? 'selected' : '' ?>>Cikoneng</option>
<option value="Ciparay" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Ciparay' ? 'selected' : '' ?>>Ciparay</option>
<option value="Gunungleutik" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Gunungleutik' ? 'selected' : '' ?>>Gunungleutik</option>
<option value="Manggungharja" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Manggungharja' ? 'selected' : '' ?>>Manggungharja</option>
<option value="Mekarlaksana" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Mekarlaksana' ? 'selected' : '' ?>>Mekarlaksana</option>
<option value="Mekarsari" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Pakutandang" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Pakutandang' ? 'selected' : '' ?>>Pakutandang</option>
<option value="Sagaracipta" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Sagaracipta' ? 'selected' : '' ?>>Sagaracipta</option>
<option value="Sarimahi" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Sarimahi' ? 'selected' : '' ?>>Sarimahi</option>
<option value="Serangmekar" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Serangmekar' ? 'selected' : '' ?>>Serangmekar</option>
<option value="Sumbersari" class="desa ciparay" <?= set_value('desa_kelurahan') == 'Sumbersari' ? 'selected' : '' ?>>Sumbersari</option>
<!-- Desa Ciwidey -->
<option value="Ciwidey" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Ciwidey' ? 'selected' : '' ?>>Ciwidey</option>
<option value="Lebakmuncang" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Lebakmuncang' ? 'selected' : '' ?>>Lebakmuncang</option>
<option value="Nengkelan" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Nengkelan' ? 'selected' : '' ?>>Nengkelan</option>
<option value="Panundaan" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Panundaan' ? 'selected' : '' ?>>Panundaan</option>
<option value="Panyocokan" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Panyocokan' ? 'selected' : '' ?>>Panyocokan</option>
<option value="Rawabogo" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Rawabogo' ? 'selected' : '' ?>>Rawabogo</option>
<option value="Sukawening" class="desa ciwidey" <?= set_value('desa_kelurahan') == 'Sukawening' ? 'selected' : '' ?>>Sukawening</option>
<!-- Desa Dayeuhkolot -->
<option value="Cangkuang Kulon" class="desa dayeuhkolot" <?= set_value('desa_kelurahan') == 'Cangkuang Kulon' ? 'selected' : '' ?>>Cangkuang Kulon</option>
<option value="Cangkuang Wetan" class="desa dayeuhkolot" <?= set_value('desa_kelurahan') == 'Cangkuang Wetan' ? 'selected' : '' ?>>Cangkuang Wetan</option>
<option value="Citeureup" class="desa dayeuhkolot" <?= set_value('desa_kelurahan') == 'Citeureup' ? 'selected' : '' ?>>Citeureup</option>
<option value="Dayeuhkolot" class="desa dayeuhkolot" <?= set_value('desa_kelurahan') == 'Dayeuhkolot' ? 'selected' : '' ?>>Dayeuhkolot</option>
<option value="Sukapura" class="desa dayeuhkolot" <?= set_value('desa_kelurahan') == 'Sukapura' ? 'selected' : '' ?>>Sukapura</option>
<option value="Pasawahan" class="desa dayeuhkolot" <?= set_value('desa_kelurahan') == 'Pasawahan' ? 'selected' : '' ?>>Pasawahan</option>
<!-- Desa Ibun -->
<option value="Cibeet" class="desa ibun" <?= set_value('desa_kelurahan') == 'Cibeet' ? 'selected' : '' ?>>Cibeet</option>
<option value="Dukuh" class="desa ibun" <?= set_value('desa_kelurahan') == 'Dukuh' ? 'selected' : '' ?>>Dukuh</option>
<option value="Ibun" class="desa ibun" <?= set_value('desa_kelurahan') == 'Ibun' ? 'selected' : '' ?>>Ibun</option>
<option value="Karyalaksana" class="desa ibun" <?= set_value('desa_kelurahan') == 'Karyalaksana' ? 'selected' : '' ?>>Karyalaksana</option>
<option value="Laksana" class="desa ibun" <?= set_value('desa_kelurahan') == 'Laksana' ? 'selected' : '' ?>>Laksana</option>
<option value="Lampegan" class="desa ibun" <?= set_value('desa_kelurahan') == 'Lampegan' ? 'selected' : '' ?>>Lampegan</option>
<option value="Mekarwangi" class="desa ibun" <?= set_value('desa_kelurahan') == 'Mekarwangi' ? 'selected' : '' ?>>Mekarwangi</option>
<option value="Neglasari" class="desa ibun" <?= set_value('desa_kelurahan') == 'Neglasari' ? 'selected' : '' ?>>Neglasari</option>
<option value="Pangguh" class="desa ibun" <?= set_value('desa_kelurahan') == 'Pangguh' ? 'selected' : '' ?>>Pangguh</option>
<option value="Sudi" class="desa ibun" <?= set_value('desa_kelurahan') == 'Sudi' ? 'selected' : '' ?>>Sudi</option>
<option value="Talun" class="desa ibun" <?= set_value('desa_kelurahan') == 'Talun' ? 'selected' : '' ?>>Talun</option>
<option value="Tanggulun" class="desa ibun" <?= set_value('desa_kelurahan') == 'Tanggulun' ? 'selected' : '' ?>>Tanggulun</option>
<!-- Desa Katapang -->
<option value="Banyusari" class="desa katapang" <?= set_value('desa_kelurahan') == 'Banyusari' ? 'selected' : '' ?>>Banyusari</option>
<option value="Cilampeni" class="desa katapang" <?= set_value('desa_kelurahan') == 'Cilampeni' ? 'selected' : '' ?>>Cilampeni</option>
<option value="Gandasari" class="desa katapang" <?= set_value('desa_kelurahan') == 'Gandasari' ? 'selected' : '' ?>>Gandasari</option>
<option value="Katapang" class="desa katapang" <?= set_value('desa_kelurahan') == 'Katapang' ? 'selected' : '' ?>>Katapang</option>
<option value="Pangauban" class="desa katapang" <?= set_value('desa_kelurahan') == 'Pangauban' ? 'selected' : '' ?>>Pangauban</option>
<option value="Sangkanhurip" class="desa katapang" <?= set_value('desa_kelurahan') == 'Sangkanhurip' ? 'selected' : '' ?>>Sangkanhurip</option>
<option value="Sukamukti" class="desa katapang" <?= set_value('desa_kelurahan') == 'Sukamukti' ? 'selected' : '' ?>>Sukamukti</option>
<!-- Desa Kertasari -->
<option value="Cibeureum" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Cibeureum' ? 'selected' : '' ?>>Cibeureum</option>
<option value="Cihawuk" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Cihawuk' ? 'selected' : '' ?>>Cihawuk</option>
<option value="Cikembang" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Cikembang' ? 'selected' : '' ?>>Cikembang</option>
<option value="Neglawangi" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Neglawangi' ? 'selected' : '' ?>>Neglawangi</option>
<option value="Resmitingal" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Resmitingal' ? 'selected' : '' ?>>Resmitingal</option>
<option value="Santosa" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Santosa' ? 'selected' : '' ?>>Santosa</option>
<option value="Sukapura" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Sukapura' ? 'selected' : '' ?>>Sukapura</option>
<option value="Tarumajaya" class="desa kertasari" <?= set_value('desa_kelurahan') == 'Tarumajaya' ? 'selected' : '' ?>>Tarumajaya</option>
<!-- Desa Kutawaringin -->
<option value="Buninagara" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Buninagara' ? 'selected' : '' ?>>Buninagara</option>
<option value="Cibodas" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Cibodas' ? 'selected' : '' ?>>Cibodas</option>
<option value="Cilame" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Cilame' ? 'selected' : '' ?>>Cilame</option>
<option value="Gajahmekar" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Gajahmekar' ? 'selected' : '' ?>>Gajahmekar</option>
<option value="Jatisari" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Jatisari' ? 'selected' : '' ?>>Jatisari</option>
<option value="Jelegong" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Jelegong' ? 'selected' : '' ?>>Jelegong</option>
<option value="Kopo" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Kopo' ? 'selected' : '' ?>>Kopo</option>
<option value="Kutawaringin" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Kutawaringin' ? 'selected' : '' ?>>Kutawaringin</option>
<option value="Padasuka" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Padasuka' ? 'selected' : '' ?>>Padasuka</option>
<option value="Pameuntasan" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Pameuntasan' ? 'selected' : '' ?>>Pameuntasan</option>
<option value="Sukamulya" class="desa kutawaringin" <?= set_value('desa_kelurahan') == 'Sukamulya' ? 'selected' : '' ?>>Sukamulya</option>
<!-- Desa Majalaya -->
<option value="Biru" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Biru' ? 'selected' : '' ?>>Biru</option>
<option value="Bojong" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Bojong' ? 'selected' : '' ?>>Bojong</option>
<option value="Majakerta" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Majakerta' ? 'selected' : '' ?>>Majakerta</option>
<option value="Majalaya" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Majalaya' ? 'selected' : '' ?>>Majalaya</option>
<option value="Majasetra" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Majasetra' ? 'selected' : '' ?>>Majasetra</option>
<option value="Neglasari" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Neglasari' ? 'selected' : '' ?>>Neglasari</option>
<option value="Padamulya" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Padamulya' ? 'selected' : '' ?>>Padamulya</option>
<option value="Padaulun" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Padaulun' ? 'selected' : '' ?>>Padaulun</option>
<option value="Sukamaju" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Sukamaju' ? 'selected' : '' ?>>Sukamaju</option>
<option value="Sukamukti" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Sukamukti' ? 'selected' : '' ?>>Sukamukti</option>
<option value="Wangisagara" class="desa majalaya" <?= set_value('desa_kelurahan') == 'Wangisagara' ? 'selected' : '' ?>>Wangisagara</option>
<!-- Desa Margaasih -->
<option value="Cigondewah Hilir" class="desa margaasih" <?= set_value('desa_kelurahan') == 'Cigondewah Hilir' ? 'selected' : '' ?>>Cigondewah Hilir</option>
<option value="Lagadar" class="desa margaasih" <?= set_value('desa_kelurahan') == 'Lagadar' ? 'selected' : '' ?>>Lagadar</option>
<option value="Margaasih" class="desa margaasih" <?= set_value('desa_kelurahan') == 'Margaasih' ? 'selected' : '' ?>>Margaasih</option>
<option value="Mekar Rahayu" class="desa margaasih" <?= set_value('desa_kelurahan') == 'Mekar Rahayu' ? 'selected' : '' ?>>Mekar Rahayu</option>
<option value="Nanjung" class="desa margaasih" <?= set_value('desa_kelurahan') == 'Nanjung' ? 'selected' : '' ?>>Nanjung</option>
<option value="Rahayu" class="desa margaasih" <?= set_value('desa_kelurahan') == 'Rahayu' ? 'selected' : '' ?>>Rahayu</option>
<!-- Desa Margahayu -->
<option value="Margahayu Selatan" class="desa margahayu" <?= set_value('desa_kelurahan') == 'Margahayu Selatan' ? 'selected' : '' ?>>Margahayu Selatan</option>
<option value="Margahayu Tengah" class="desa margahayu" <?= set_value('desa_kelurahan') == 'Margahayu Tengah' ? 'selected' : '' ?>>Margahayu Tengah</option>
<option value="Sayati" class="desa margahayu" <?= set_value('desa_kelurahan') == 'Sayati' ? 'selected' : '' ?>>Sayati</option>
<option value="Sukamenak" class="desa margahayu" <?= set_value('desa_kelurahan') == 'Sukamenak' ? 'selected' : '' ?>>Sukamenak</option>
<option value="Sulaeman" class="desa margahayu" <?= set_value('desa_kelurahan') == 'Sulaeman' ? 'selected' : '' ?>>Sulaeman</option>
<!-- Desa Nagreg -->
<option value="Bojong" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Bojong' ? 'selected' : '' ?>>Bojong</option>
<option value="Ciaro" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Ciaro' ? 'selected' : '' ?>>Ciaro</option>
<option value="Ciherang" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Ciherang' ? 'selected' : '' ?>>Ciherang</option>
<option value="Citaman" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Citaman' ? 'selected' : '' ?>>Citaman</option>
<option value="Ganjarsabar" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Ganjarsabar' ? 'selected' : '' ?>>Ganjarsabar</option>
<option value="Mandalawangi" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Mandalawangi' ? 'selected' : '' ?>>Mandalawangi</option>
<option value="Nagreg" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Nagreg' ? 'selected' : '' ?>>Nagreg</option>
<option value="Nagreg Kendan" class="desa nagreg" <?= set_value('desa_kelurahan') == 'Nagreg Kendan' ? 'selected' : '' ?>>Nagreg Kendan</option>
<!-- Desa Pacet -->
<option value="Cikawao" class="desa pacet" <?= set_value('desa_kelurahan') == 'Cikawao' ? 'selected' : '' ?>>Cikawao</option>
<option value="Cikitu" class="desa pacet" <?= set_value('desa_kelurahan') == 'Cikitu' ? 'selected' : '' ?>>Cikitu</option>
<option value="Cinanggela" class="desa pacet" <?= set_value('desa_kelurahan') == 'Cinanggela' ? 'selected' : '' ?>>Cinanggela</option>
<option value="Cipeujeuh" class="desa pacet" <?= set_value('desa_kelurahan') == 'Cipeujeuh' ? 'selected' : '' ?>>Cipeujeuh</option>
<option value="Girimulya" class="desa pacet" <?= set_value('desa_kelurahan') == 'Girimulya' ? 'selected' : '' ?>>Girimulya</option>
<option value="Mandalahaji" class="desa pacet" <?= set_value('desa_kelurahan') == 'Mandalahaji' ? 'selected' : '' ?>>Mandalahaji</option>
<option value="Maruyung" class="desa pacet" <?= set_value('desa_kelurahan') == 'Maruyung' ? 'selected' : '' ?>>Maruyung</option>
<option value="Mekarjaya" class="desa pacet" <?= set_value('desa_kelurahan') == 'Mekarjaya' ? 'selected' : '' ?>>Mekarjaya</option>
<option value="Mekarsari" class="desa pacet" <?= set_value('desa_kelurahan') == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Nagrak" class="desa pacet" <?= set_value('desa_kelurahan') == 'Nagrak' ? 'selected' : '' ?>>Nagrak</option>
<option value="Pangauban" class="desa pacet" <?= set_value('desa_kelurahan') == 'Pangauban' ? 'selected' : '' ?>>Pangauban</option>
<option value="Sukarame" class="desa pacet" <?= set_value('desa_kelurahan') == 'Sukarame' ? 'selected' : '' ?>>Sukarame</option>
<option value="Tanjungwangi" class="desa pacet" <?= set_value('desa_kelurahan') == 'Tanjungwangi' ? 'selected' : '' ?>>Tanjungwangi</option>
<!-- Desa Pameungpeuk -->
<option value="Bojongkunci" class="desa pameungpeuk" <?= set_value('desa_kelurahan') == 'Bojongkunci' ? 'selected' : '' ?>>Bojongkunci</option>
<option value="Bojongmanggu" class="desa pameungpeuk" <?= set_value('desa_kelurahan') == 'Bojongmanggu' ? 'selected' : '' ?>>Bojongmanggu</option>
<option value="Langonsari" class="desa pameungpeuk" <?= set_value('desa_kelurahan') == 'Langonsari' ? 'selected' : '' ?>>Langonsari</option>
<option value="Rancamulya" class="desa pameungpeuk" <?= set_value('desa_kelurahan') == 'Rancamulya' ? 'selected' : '' ?>>Rancamulya</option>
<option value="Rancatungku" class="desa pameungpeuk" <?= set_value('desa_kelurahan') == 'Rancatungku' ? 'selected' : '' ?>>Rancatungku</option>
<option value="Sukasari" class="desa pameungpeuk" <?= set_value('desa_kelurahan') == 'Sukasari' ? 'selected' : '' ?>>Sukasari</option>
<!-- Desa Pangalengan -->
<option value="Banjarsari" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Banjarsari' ? 'selected' : '' ?>>Banjarsari</option>
<option value="Lamajang" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Lamajang' ? 'selected' : '' ?>>Lamajang</option>
<option value="Margaluyu" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Margaluyu' ? 'selected' : '' ?>>Margaluyu</option>
<option value="Margamekar" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Margamekar' ? 'selected' : '' ?>>Margamekar</option>
<option value="Margamukti" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Margamukti' ? 'selected' : '' ?>>Margamukti</option>
<option value="Margamulya" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Margamulya' ? 'selected' : '' ?>>Margamulya</option>
<option value="Pangalengan" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Pangalengan' ? 'selected' : '' ?>>Pangalengan</option>
<option value="Pulosari" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Pulosari' ? 'selected' : '' ?>>Pulosari</option>
<option value="Sukaluyu" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Sukaluyu' ? 'selected' : '' ?>>Sukaluyu</option>
<option value="Sukamanah" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Sukamanah' ? 'selected' : '' ?>>Sukamanah</option>
<option value="Tribaktimulya" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Tribaktimulya' ? 'selected' : '' ?>>Tribaktimulya</option>
<option value="Wanasuka" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Wanasuka' ? 'selected' : '' ?>>Wanasuka</option>
<option value="Warnasari" class="desa pangalengan" <?= set_value('desa_kelurahan') == 'Warnasari' ? 'selected' : '' ?>>Warnasari</option>
<!-- Desa Paseh -->
<option value="Cigentur" class="desa paseh" <?= set_value('desa_kelurahan') == 'Cigentur' ? 'selected' : '' ?>>Cigentur</option>
<option value="Cijagra" class="desa paseh" <?= set_value('desa_kelurahan') == 'Cijagra' ? 'selected' : '' ?>>Cijagra</option>
<option value="Cipaku" class="desa paseh" <?= set_value('desa_kelurahan') == 'Cipaku' ? 'selected' : '' ?>>Cipaku</option>
<option value="Cipedes" class="desa paseh" <?= set_value('desa_kelurahan') == 'Cipedes' ? 'selected' : '' ?>>Cipedes</option>
<option value="Drawati" class="desa paseh" <?= set_value('desa_kelurahan') == 'Drawati' ? 'selected' : '' ?>>Drawati</option>
<option value="Karangtunggal" class="desa paseh" <?= set_value('desa_kelurahan') == 'Karangtunggal' ? 'selected' : '' ?>>Karangtunggal</option>
<option value="Loa" class="desa paseh" <?= set_value('desa_kelurahan') == 'Loa' ? 'selected' : '' ?>>Loa</option>
<option value="Mekarpawitan" class="desa paseh" <?= set_value('desa_kelurahan') == 'Mekarpawitan' ? 'selected' : '' ?>>Mekarpawitan</option>
<!-- Desa Pasirjambu -->
<option value="Cibodas" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Cibodas' ? 'selected' : '' ?>>Cibodas</option>
<option value="Cikoneng" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Cikoneng' ? 'selected' : '' ?>>Cikoneng</option>
<option value="Cisondari" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Cisondari' ? 'selected' : '' ?>>Cisondari</option>
<option value="Cukanggenteng" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Cukanggenteng' ? 'selected' : '' ?>>Cukanggenteng</option>
<option value="Margamulya" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Margamulya' ? 'selected' : '' ?>>Margamulya</option>
<option value="Mekarmaju" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Mekarmaju' ? 'selected' : '' ?>>Mekarmaju</option>
<option value="Mekarsari" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Pasirjambu" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Pasirjambu' ? 'selected' : '' ?>>Pasirjambu</option>
<option value="Sugihmukti" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Sugihmukti' ? 'selected' : '' ?>>Sugihmukti</option>
<option value="Tenjolaya" class="desa pasirjambu" <?= set_value('desa_kelurahan') == 'Tenjolaya' ? 'selected' : '' ?>>Tenjolaya</option>
<!-- Desa Rancabali -->
<option value="Alamendah" class="desa rancabali" <?= set_value('desa_kelurahan') == 'Alamendah' ? 'selected' : '' ?>>Alamendah</option>
<option value="Cipelah" class="desa rancabali" <?= set_value('desa_kelurahan') == 'Cipelah' ? 'selected' : '' ?>>Cipelah</option>
<option value="Indragiri" class="desa rancabali" <?= set_value('desa_kelurahan') == 'Indragiri' ? 'selected' : '' ?>>Indragiri</option>
<option value="Patengan" class="desa rancabali" <?= set_value('desa_kelurahan') == 'Patengan' ? 'selected' : '' ?>>Patengan</option>
<option value="Sukaresmi" class="desa rancabali" <?= set_value('desa_kelurahan') == 'Sukaresmi' ? 'selected' : '' ?>>Sukaresmi</option>
<!-- Desa Rancaekek -->
<option value="Bojongloa" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Bojongloa' ? 'selected' : '' ?>>Bojongloa</option>
<option value="Bojongsalam" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Bojongsalam' ? 'selected' : '' ?>>Bojongsalam</option>
<option value="Cangkuang" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Cangkuang' ? 'selected' : '' ?>>Cangkuang</option>
<option value="Haurpugur" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Haurpugur' ? 'selected' : '' ?>>Haurpugur</option>
<option value="Jelegong" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Jelegong' ? 'selected' : '' ?>>Jelegong</option>
<option value="Linggar" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Linggar' ? 'selected' : '' ?>>Linggar</option>
<option value="Nanjungmekar" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Nanjungmekar' ? 'selected' : '' ?>>Nanjungmekar</option>
<option value="Rancaekek Kulon" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Rancaekek Kulon' ? 'selected' : '' ?>>Rancaekek Kulon</option>
<option value="Rancaekek Wetan" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Rancaekek Wetan' ? 'selected' : '' ?>>Rancaekek Wetan</option>
<option value="Sangiang" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Sangiang' ? 'selected' : '' ?>>Sangiang</option>
<option value="Sukamanah" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Sukamanah' ? 'selected' : '' ?>>Sukamanah</option>
<option value="Sukamulya" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Sukamulya' ? 'selected' : '' ?>>Sukamulya</option>
<option value="Tegalsumedang" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Tegalsumedang' ? 'selected' : '' ?>>Tegalsumedang</option>
<option value="Rancaekek Kencana" class="desa rancaekek" <?= set_value('desa_kelurahan') == 'Rancaekek Kencana' ? 'selected' : '' ?>>Rancaekek Kencana</option>
<!-- Desa Solokanjeruk -->
<option value="Bojongemas" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Bojongemas' ? 'selected' : '' ?>>Bojongemas</option>
<option value="Cibodas" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Cibodas' ? 'selected' : '' ?>>Cibodas</option>
<option value="Langensari" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Langensari' ? 'selected' : '' ?>>Langensari</option>
<option value="Padamukti" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Padamukti' ? 'selected' : '' ?>>Padamukti</option>
<option value="Panyadap" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Panyadap' ? 'selected' : '' ?>>Panyadap</option>
<option value="Rancakasumba" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Rancakasumba' ? 'selected' : '' ?>>Rancakasumba</option>
<option value="Solokanjeruk" class="desa solokanjeruk" <?= set_value('desa_kelurahan') == 'Solokanjeruk' ? 'selected' : '' ?>>Solokanjeruk</option>
<!-- Desa Soreang -->
<option value="Cingcin" class="desa soreang" <?= set_value('desa_kelurahan') == 'Cingcin' ? 'selected' : '' ?>>Cingcin</option>
<option value="Karamatmulya" class="desa soreang" <?= set_value('desa_kelurahan') == 'Karamatmulya' ? 'selected' : '' ?>>Karamatmulya</option>
<option value="Pamekaran" class="desa soreang" <?= set_value('desa_kelurahan') == 'Pamekaran' ? 'selected' : '' ?>>Pamekaran</option>
<option value="Panyirapan" class="desa soreang" <?= set_value('desa_kelurahan') == 'Panyirapan' ? 'selected' : '' ?>>Panyirapan</option>
<option value="Parungserab" class="desa soreang" <?= set_value('desa_kelurahan') == 'Parungserab' ? 'selected' : '' ?>>Parungserab</option>
<option value="Sadu" class="desa soreang" <?= set_value('desa_kelurahan') == 'Sadu' ? 'selected' : '' ?>>Sadu</option>

    </select>
</div>
<label for="jenis_usaha">Jenis Usaha:</label>
  <select name="jenis_usaha" id="jenis_usaha" class="form-control" required onchange="updatePendapatan()">
    <option value="">-- Pilih Jenis Usaha --</option>
    <option value="Mikro">Mikro</option>
    <option value="Kecil">Kecil</option>
    <option value="Menengah">Menengah</option>
  </select>

  <br>

  <label for="pendapatan">Pendapatan per Tahun (Rp):</label>
  <input type="text" name="pendapatan" id="pendapatan" class="form-control" readonly>
  <br>
 <!-- UMKM Latitude -->
 <!-- <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?= set_value('latitude'); ?>" readonly>
            </div> -->

             <!-- UMKM Longtitude -->
 <!-- <div class="mb-3">
                <label for="longtitude" class="form-label">Longtitude</label>
                <input type="text" class="form-control" id="longtitude" name="longtitude" value="<?= set_value('longtitude'); ?>" readonly>
            </div> -->

           <!-- UMKM Kategori -->
<div class="mb-3">
    <label style="color:white;" for="kategori_produk" class="form-label">Kategori Produk</label>
    <select class="form-control" id="kategori_produk" name="kategori_produk" required>
        <option value="" disabled selected>Pilih Kategori</option>
        <option value="Kuliner" <?= set_value('kategori_produk') == 'Kuliner' ? 'selected' : '' ?>>Kuliner</option>
        <option value="Kerajinan" <?= set_value('kategori_produk') == 'Kerajinan' ? 'selected' : '' ?>>Kerajinan</option>
        <option value="Fashion" <?= set_value('kategori_produk') == 'Fashion' ? 'selected' : '' ?>>Fashion</option>
    </select>
</div>


             <!-- UMKM NIB -->
             <div class="mb-3">
                <label style="color:white;" for="jenis_umkm" class="form-label">NIB</label>
                <input type="text" class="form-control" id="nib" name="nib" value="<?= set_value('nib'); ?>" >
            </div>

             <!-- UMKM PIRT -->
             <div class="mb-3">
                <label style="color:white;" for="jenis_umkm" class="form-label">PIRT</label>
                <input type="text" class="form-control" id="pirt" name="pirt" value="<?= set_value('pirt'); ?>" >
            </div>

             <!-- UMKM BPOM -->
             <div class="mb-3">
                <label style="color:white;" for="jenis_umkm" class="form-label">BPOM</label>
                <input type="text" class="form-control" id="bpom" name="bpom" value="<?= set_value('bpom'); ?>" >
            </div>

             <!-- UMKM HALAL -->
             <div class="mb-3">
                <label style="color:white;" for="jenis_umkm" class="form-label">Halal</label>
                <input type="text" class="form-control" id="halal" name="halal" value="<?= set_value('halal'); ?>" >
            </div>

             <!-- UMKM HAKI -->
             <div class="mb-3">
                <label style="color:white;" for="jenis_umkm" class="form-label">HAKI</label>
                <input type="text" class="form-control" id="haki" name="haki" value="<?= set_value('haki'); ?>" >
            </div>

             <!-- UMKM Lainnya -->
             <div class="mb-3">
                <label style="color:white;" for="jenis_umkm" class="form-label">Lainnya</label>
                <input type="text" class="form-control" id="lainnya" name="lainnya" value="<?= set_value('lainnya'); ?>" >
            </div>

            <!-- UMKM Deskripsi -->
<div class="mb-3">
    <label style="color:white;" for="lainnya" class="form-label">Deskripsi Produk</label>
    <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3"><?= set_value('deskripsi_produk'); ?></textarea>
</div>

<!-- UMKM Deskripsi -->
<div class="mb-3">
    <label  style="color:white;" class="form-label">Deskripsi Produk</label>
    <div style="color:white;" class="form-check">
        <input class="form-check-input" type="checkbox" id="online" name="online" value="Online" 
        <?= set_value('online') ? 'checked' : '' ?>>
        <label class="form-check-label" for="online">Online</label>
    </div>
    <div style="color:white;" class="form-check">
        <input class="form-check-input" type="checkbox" id="offline" name="offline" value="Offline" 
        <?= set_value('offline') ? 'checked' : '' ?>>
        <label class="form-check-label" for="offline">Offline</label>
    </div>
    <div style="color:white;" class="form-check">
        <input class="form-check-input" type="checkbox" id="agen_reseller" name="agen_reseller" value="Agen / Reseller" 
        <?= set_value('agen_reseller') ? 'checked' : '' ?>>
        <label class="form-check-label" for="agen_reseller">Agen / Reseller</label>
    </div>
</div>

<?php
// Daftar platform dengan label yang lebih jelas
$platforms = [
    'whatsapp'  => 'WhatsApp',
    'blibli'    => 'Blibli',
    'lazada'    => 'Lazada',
    'shopee'    => 'Shopee',
    'tokopedia' => 'Tokopedia',
    'facebook'  => 'Facebook',
    'instagram' => 'Instagram',
    'tiktok'    => 'TikTok',
    'twitter'   => 'Twitter'
];
?>

<?php foreach ($platforms as $name => $label) : ?>
    <div class="mb-3">
        <label style="color:white;" for="<?= $name; ?>" class="form-label"><?= $label; ?></label>
        <input type="text" class="form-control" id="<?= $name; ?>" name="<?= $name; ?>"
               value="<?= set_value($name); ?>" placeholder="Masukkan link <?= $label; ?>">
    </div>
<?php endforeach; ?>


<!-- UMKM Status -->
<div class="mb-3">
    <label style="color:white;" for="status" class="form-label">Status</label>
    <input type="text" class="form-control" id="status" name="status" value="<?= set_value('status', 'Menunggu'); ?>" readonly>
</div>

            <input type="hidden" name="status" value="Menunggu"> <!-- Status diatur otomatis ke "Menunggu" -->

            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>

    <!-- Optional: Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validation -->
    <script>
        function validateForm() {
            var phone = document.getElementById("nomor_hp").value;
            var fileInput = document.getElementById("photo");
            var file = fileInput.files[0];

            // Validasi nomor HP (hanya angka)
            if (!/^\d+$/.test(phone)) {
                alert("Nomor HP hanya boleh berisi angka.");
                document.getElementById("nomor_hp").focus();
                return false;
            }

            // Validasi file (optional)
            if (file) {
                var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert("Hanya gambar (jpg, jpeg, png, gif) yang diperbolehkan.");
                    fileInput.value = '';
                    return false;
                }
                if (file.size > 2048 * 1024) { // Maksimal 2MB
                    alert("Ukuran file tidak boleh melebihi 2MB.");
                    fileInput.value = '';
                    return false;
                }
            }

            return true;  // Form valid, lanjut submit
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const kecamatanSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa_kelurahan');
        
        function updateDesaOptions() {
            const selectedKecamatan = kecamatanSelect.value.toLowerCase();
            const desaOptions = desaSelect.querySelectorAll('option.desa');
            
            desaOptions.forEach(option => {
                option.style.display = 'none'; // Sembunyikan semua desa terlebih dahulu
                if (option.classList.contains(selectedKecamatan)) {
                    option.style.display = 'block';
                }
            });

            // Reset pilihan desa jika tidak sesuai dengan kecamatan yang dipilih
            if (desaSelect.querySelector('option:checked').style.display === 'none') {
                desaSelect.value = '';
            }
        }

        kecamatanSelect.addEventListener('change', updateDesaOptions);

        // Jalankan sekali saat halaman dimuat untuk sinkronisasi pilihan sebelumnya
        updateDesaOptions();
    });
</script>
<script>
    // Data koordinat untuk desa di Margahayu dan Katapang
    const koordinatDesa = {
        // Margahayu
        "Margahayu Selatan": { latitude: "-6.960254", longtitude: "107.570369" },
        "Margahayu Tengah": { latitude: "-6.960110", longtitude: "107.565750" },
        "Sayati": { latitude: "-6.950276", longtitude: "107.575764" },
        "Sukamenak": { latitude: "-6.955795", longtitude: "107.581375" },
        "Sulaeman": { latitude: "-6.951419", longtitude: "107.566612" },
        
        // Katapang
        "Banyusari": { latitude: "-6.965130", longtitude: "107.589210" },
        "Cilampeni": { latitude: "-6.963678", longtitude: "107.595320" },
        "Gandasari": { latitude: "-6.969523", longtitude: "107.578945" },
        "Katapang": { latitude: "-6.974510", longtitude: "107.582147" },
        "Pangauban": { latitude: "-6.970888", longtitude: "107.599344" },
        "Sangkanhurip": { latitude: "-6.968712", longtitude: "107.586750" },
        "Sukamukti": { latitude: "-6.971233", longtitude: "107.594125" }
    };

    // Event listener untuk mengisi latitude dan longtitude otomatis
    document.getElementById('desa_kelurahan').addEventListener('change', function() {
        const desaTerpilih = this.value;
        if (koordinatDesa[desaTerpilih]) {
            document.getElementById('latitude').value = koordinatDesa[desaTerpilih].latitude;
            document.getElementById('longtitude').value = koordinatDesa[desaTerpilih].longtitude;
        } else {
            document.getElementById('latitude').value = '';
            document.getElementById('longtitude').value = '';
        }
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
<!-- JavaScript -->
<script>
function updatePendapatan() {
  const jenisUsaha = document.getElementById("jenis_usaha").value;
  const pendapatan = document.getElementById("pendapatan");

  switch (jenisUsaha) {
    case "Mikro":
      pendapatan.value = "Rp 2.000.000.000";
      break;
    case "Kecil":
      pendapatan.value = "Rp 2.000.000.000 - Rp 15.000.000.000";
      break;
    case "Menengah":
      pendapatan.value = "Rp 15.000.000.000 - Rp 50.000.000.000";
      break;
    default:
      pendapatan.value = "";
  }
}
</script>
</body>
</html>
