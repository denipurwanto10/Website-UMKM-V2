<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit UMKM</title>
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

        <!-- Form for updating UMKM -->
        <form action="<?php echo site_url('umkm/update/'.$umkm['id']); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="card">
        <div class="card-header">
            <h5 style="color:white;">Edit UMKM</h5>
        </div>
        <div class="card-body">
<div class="mb-3">
    <label style="color:white;" for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" 
        value="<?= isset($umkm['username']) ? $umkm['username'] : 'No username found'; ?>" readonly>
</div>



           <!-- UMKM Name -->
<div class="mb-3">
    <label style="color:white;" for="nama_usaha" class="form-label">Nama Usaha</label>
    <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" 
        value="<?= isset($umkm['nama_usaha']) ? $umkm['nama_usaha'] : 'No name found'; ?>" required>
</div>

           <!-- UMKM Merek -->
<div class="mb-3">
    <label style="color:white;" for="nama_merek_produk" class="form-label">Nama Merek Produk</label>
    <input type="text" class="form-control" id="nama_merek_produk" name="nama_merek_produk" 
        value="<?= isset($umkm['nama_merek_produk']) ? $umkm['nama_merek_produk'] : 'No brand found'; ?>" required>
</div>


           <!-- UMKM Alamat -->
<div class="mb-3">
    <label style="color:white;" for="jalan" class="form-label">Jalan</label>
    <input type="text" class="form-control" id="jalan" name="jalan" 
        value="<?= isset($umkm['jalan']) ? $umkm['jalan'] : 'No address found'; ?>" required>
</div>


<div class="mb-3">
    <label style="color:white;" for="kecamatan" class="form-label">Kecamatan</label>
    <select class="form-control" id="kecamatan" name="kecamatan" required>
        <option value="" disabled selected>Pilih Kecamatan</option>
        <option value="Arjasari" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Arjasari' ? 'selected' : '' ?>>Arjasari</option>
        <option value="Baleendah" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Baleendah' ? 'selected' : '' ?>>Baleendah</option>
        <option value="Banjaran" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Banjaran' ? 'selected' : '' ?>>Banjaran</option>
        <option value="Bojongsoang" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Bojongsoang' ? 'selected' : '' ?>>Bojongsoang</option>
        <option value="Cangkuang" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cangkuang' ? 'selected' : '' ?>>Cangkuang</option>
        <option value="Cicalengka" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cicalengka' ? 'selected' : '' ?>>Cicalengka</option>
        <option value="Cikancung" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cikancung' ? 'selected' : '' ?>>Cikancung</option>
        <option value="Cilengkrang" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cilengkrang' ? 'selected' : '' ?>>Cilengkrang</option>
        <option value="Cileunyi" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cileunyi' ? 'selected' : '' ?>>Cileunyi</option>
        <option value="Cimaung" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cimaung' ? 'selected' : '' ?>>Cimaung</option>
        <option value="Cimenyan" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Cimenyan' ? 'selected' : '' ?>>Cimenyan</option>
        <option value="Ciparay" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Ciparay' ? 'selected' : '' ?>>Ciparay</option>
        <option value="Ciwidey" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Ciwidey' ? 'selected' : '' ?>>Ciwidey</option>
        <option value="Dayeuhkolot" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Dayeuhkolot' ? 'selected' : '' ?>>Dayeuhkolot</option>
        <option value="Ibun" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Ibun' ? 'selected' : '' ?>>Ibun</option>
        <option value="Katapang" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Katapang' ? 'selected' : '' ?>>Katapang</option>
        <option value="Kertasari" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Kertasari' ? 'selected' : '' ?>>Kertasari</option>
        <option value="Kutawaringin" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Kutawaringin' ? 'selected' : '' ?>>Kutawaringin</option>
        <option value="Majalaya" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Majalaya' ? 'selected' : '' ?>>Majalaya</option>
        <option value="Margaasih" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Margaasih' ? 'selected' : '' ?>>Margaasih</option>
        <option value="Margahayu" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Margahayu' ? 'selected' : '' ?>>Margahayu</option>
        <option value="Nagreg" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Nagreg' ? 'selected' : '' ?>>Nagreg</option>
        <option value="Pacet" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Pacet' ? 'selected' : '' ?>>Pacet</option>
        <option value="Pameungpeuk" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Pameungpeuk' ? 'selected' : '' ?>>Pameungpeuk</option>
        <option value="Pangalengan" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Pangalengan' ? 'selected' : '' ?>>Pangalengan</option>
        <option value="Paseh" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Paseh' ? 'selected' : '' ?>>Paseh</option>
        <option value="Pasirjambu" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Pasirjambu' ? 'selected' : '' ?>>Pasirjambu</option>
        <option value="Rancabali" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Rancabali' ? 'selected' : '' ?>>Rancabali</option>
        <option value="Rancaekek" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Rancaekek' ? 'selected' : '' ?>>Rancaekek</option>
        <option value="Solokanjeruk" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Solokanjeruk' ? 'selected' : '' ?>>Solokanjeruk</option>
        <option value="Soreang" <?= isset($umkm['kecamatan']) && $umkm['kecamatan'] == 'Soreang' ? 'selected' : '' ?>>Soreang</option>
    </select>
</div>


<div class="mb-3">
    <label style="color:white;" for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
    <select class="form-control" id="desa_kelurahan" name="desa_kelurahan" required>
        <option value="" disabled selected>Pilih Desa/Kelurahan</option>
       <!-- Desa Arjasari -->
<option value="Ancolmekar" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ancolmekar' ? 'selected' : '' ?>>Ancolmekar</option>
<option value="Arjasari" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Arjasari' ? 'selected' : '' ?>>Arjasari</option>
<option value="Baros" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Baros' ? 'selected' : '' ?>>Baros</option>
<option value="Batukarut" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Batukarut' ? 'selected' : '' ?>>Batukarut</option>
<option value="Lebakwangi" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Lebakwangi' ? 'selected' : '' ?>>Lebakwangi</option>
<option value="Mangunjaya" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mangunjaya' ? 'selected' : '' ?>>Mangunjaya</option>
<option value="Mekarjaya" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarjaya' ? 'selected' : '' ?>>Mekarjaya</option>
<option value="Patrolsari" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Patrolsari' ? 'selected' : '' ?>>Patrolsari</option>
<option value="Pinggirsari" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pinggirsari' ? 'selected' : '' ?>>Pinggirsari</option>
<option value="Rancakole" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Rancakole' ? 'selected' : '' ?>>Rancakole</option>
<option value="Wargaluyu" class="desa arjasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Wargaluyu' ? 'selected' : '' ?>>Wargaluyu</option>

<!-- Desa Baleendah -->
<option value="Bojongmalaka" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojongmalaka' ? 'selected' : '' ?>>Bojongmalaka</option>
<option value="Malakasari" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Malakasari' ? 'selected' : '' ?>>Malakasari</option>
<option value="Rancamanyar" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Rancamanyar' ? 'selected' : '' ?>>Rancamanyar</option>
<option value="Andir" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Andir' ? 'selected' : '' ?>>Andir</option>
<option value="Baleendah" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Baleendah' ? 'selected' : '' ?>>Baleendah</option>
<option value="Jelekong" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Jelekong' ? 'selected' : '' ?>>Jelekong</option>
<option value="Manggahang" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Manggahang' ? 'selected' : '' ?>>Manggahang</option>
<option value="Wargamekar" class="desa baleendah" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Wargamekar' ? 'selected' : '' ?>>Wargamekar</option>

<!-- Desa Banjaran -->
<option value="Banjaran" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Banjaran' ? 'selected' : '' ?>>Banjaran</option>
<option value="Banjaran Wetan" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Banjaran Wetan' ? 'selected' : '' ?>>Banjaran Wetan</option>
<option value="Ciapus" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciapus' ? 'selected' : '' ?>>Ciapus</option>
<option value="Kamasan" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Kamasan' ? 'selected' : '' ?>>Kamasan</option>
<option value="Kiangroke" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Kiangroke' ? 'selected' : '' ?>>Kiangroke</option>
<option value="Margahurip" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Margahurip' ? 'selected' : '' ?>>Margahurip</option>
<option value="Mekarjaya" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarjaya' ? 'selected' : '' ?>>Mekarjaya</option>
<option value="Neglasari" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Neglasari' ? 'selected' : '' ?>>Neglasari</option>
<option value="Pasirmulya" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pasirmulya' ? 'selected' : '' ?>>Pasirmulya</option>
<option value="Sindangpanon" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sindangpanon' ? 'selected' : '' ?>>Sindangpanon</option>
<option value="Tarajusari" class="desa banjaran" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Tarajusari' ? 'selected' : '' ?>>Tarajusari</option>

<!-- Desa Bojongsoang -->
<option value="Bojongsari" class="desa bojongsoang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojongsari' ? 'selected' : '' ?>>Bojongsari</option>
<option value="Bojongsoang" class="desa bojongsoang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojongsoang' ? 'selected' : '' ?>>Bojongsoang</option>
<option value="Buahbatu" class="desa bojongsoang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Buahbatu' ? 'selected' : '' ?>>Buahbatu</option>
<option value="Cipagalo" class="desa bojongsoang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cipagalo' ? 'selected' : '' ?>>Cipagalo</option>
<option value="Lengkong" class="desa bojongsoang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Lengkong' ? 'selected' : '' ?>>Lengkong</option>
<option value="Tegalluar" class="desa bojongsoang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Tegalluar' ? 'selected' : '' ?>>Tegalluar</option>

<!-- Desa Cangkuang -->
<option value="Bandasari" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Bandasari' ? 'selected' : '' ?>>Bandasari</option>
<option value="Cangkuang" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cangkuang' ? 'selected' : '' ?>>Cangkuang</option>
<option value="Ciluncat" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Ciluncat' ? 'selected' : '' ?>>Ciluncat</option>
<option value="Jatisari" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Jatisari' ? 'selected' : '' ?>>Jatisari</option>
<option value="Nagrak" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Nagrak' ? 'selected' : '' ?>>Nagrak</option>
<option value="Pananjung" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Pananjung' ? 'selected' : '' ?>>Pananjung</option>
<option value="Tanjungsari" class="desa cangkuang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Tanjungsari' ? 'selected' : '' ?>>Tanjungsari</option>

<!-- Desa Cicalengka -->
<option value="Babakan Peuteuy" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Babakan Peuteuy' ? 'selected' : '' ?>>Babakan Peuteuy</option>
<option value="Cicalengka Kulon" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cicalengka Kulon' ? 'selected' : '' ?>>Cicalengka Kulon</option>
<option value="Cicalengka Wetan" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cicalengka Wetan' ? 'selected' : '' ?>>Cicalengka Wetan</option>
<option value="Cikuya" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cikuya' ? 'selected' : '' ?>>Cikuya</option>
<option value="Dampit" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Dampit' ? 'selected' : '' ?>>Dampit</option>
<option value="Margaasih" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Margaasih' ? 'selected' : '' ?>>Margaasih</option>
<option value="Nagrog" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Nagrog' ? 'selected' : '' ?>>Nagrog</option>
<option value="Narawita" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Narawita' ? 'selected' : '' ?>>Narawita</option>
<option value="Panenjoan" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Panenjoan' ? 'selected' : '' ?>>Panenjoan</option>
<option value="Tanjungwangi" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Tanjungwangi' ? 'selected' : '' ?>>Tanjungwangi</option>
<option value="Tenjolaya" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Tenjolaya' ? 'selected' : '' ?>>Tenjolaya</option>
<option value="Waluya" class="desa cicalengka" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Waluya' ? 'selected' : '' ?>>Waluya</option>

<!-- Desa Cikancung -->
<option value="Cihanyir" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cihanyir' ? 'selected' : '' ?>>Cihanyir</option>
<option value="Cikancung" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikancung' ? 'selected' : '' ?>>Cikancung</option>
<option value="Cikasungka" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikasungka' ? 'selected' : '' ?>>Cikasungka</option>
<option value="Ciluluk" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciluluk' ? 'selected' : '' ?>>Ciluluk</option>
<option value="Hegarmanah" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Hegarmanah' ? 'selected' : '' ?>>Hegarmanah</option>
<option value="Mandalasari" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mandalasari' ? 'selected' : '' ?>>Mandalasari</option>
<option value="Mekarlaksana" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarlaksana' ? 'selected' : '' ?>>Mekarlaksana</option>
<option value="Srirahayu" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Srirahayu' ? 'selected' : '' ?>>Srirahayu</option>
<option value="Tanjunglaya" class="desa cikancung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Tanjunglaya' ? 'selected' : '' ?>>Tanjunglaya</option>

<!-- Desa Cilengkrang -->
<option value="Cilengkrang" class="desa cilengkrang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cilengkrang' ? 'selected' : '' ?>>Cilengkrang</option>
<option value="Cipanjalu" class="desa cilengkrang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cipanjalu' ? 'selected' : '' ?>>Cipanjalu</option>
<option value="Ciporeat" class="desa cilengkrang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciporeat' ? 'selected' : '' ?>>Ciporeat</option>
<option value="Girimekar" class="desa cilengkrang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Girimekar' ? 'selected' : '' ?>>Girimekar</option>
<option value="Jatiendah" class="desa cilengkrang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Jatiendah' ? 'selected' : '' ?>>Jatiendah</option>
<option value="Melatiwangi" class="desa cilengkrang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Melatiwangi' ? 'selected' : '' ?>>Melatiwangi</option>

<!-- Desa Cileunyi -->
<option value="Cibiru Hilir" class="desa cileunyi" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cibiru Hilir' ? 'selected' : '' ?>>Cibiru Hilir</option>
<option value="Cibiru Wetan" class="desa cileunyi" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cibiru Wetan' ? 'selected' : '' ?>>Cibiru Wetan</option>
<option value="Cileunyi Kulon" class="desa cileunyi" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cileunyi Kulon' ? 'selected' : '' ?>>Cileunyi Kulon</option>
<option value="Cileunyi Wetan" class="desa cileunyi" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cileunyi Wetan' ? 'selected' : '' ?>>Cileunyi Wetan</option>
<option value="Cimekar" class="desa cileunyi" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cimekar' ? 'selected' : '' ?>>Cimekar</option>
<option value="Cinunuk" class="desa cileunyi" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cinunuk' ? 'selected' : '' ?>>Cinunuk</option>

<!-- Desa Cimaung -->
<option value="Campakamulya" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Campakamulya' ? 'selected' : '' ?>>Campakamulya</option>
<option value="Cikalong" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikalong' ? 'selected' : '' ?>>Cikalong</option>
<option value="Cimaung" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cimaung' ? 'selected' : '' ?>>Cimaung</option>
<option value="Cipinang" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cipinang' ? 'selected' : '' ?>>Cipinang</option>
<option value="Jagabaya" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Jagabaya' ? 'selected' : '' ?>>Jagabaya</option>
<option value="Malasari" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Malasari' ? 'selected' : '' ?>>Malasari</option>
<option value="Mekarsari" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Pasirhuni" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pasirhuni' ? 'selected' : '' ?>>Pasirhuni</option>
<option value="Sukamaju" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukamaju' ? 'selected' : '' ?>>Sukamaju</option>
<option value="Warjabakti" class="desa cimaung" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Warjabakti' ? 'selected' : '' ?>>Warjabakti</option>

<!-- Desa Cimenyan -->
<option value="Ciburial" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciburial' ? 'selected' : '' ?>>Ciburial</option>
<option value="Cikadut" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikadut' ? 'selected' : '' ?>>Cikadut</option>
<option value="Cimenyan" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cimenyan' ? 'selected' : '' ?>>Cimenyan</option>
<option value="Mandalamekar" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mandalamekar' ? 'selected' : '' ?>>Mandalamekar</option>
<option value="Mekarmanik" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarmanik' ? 'selected' : '' ?>>Mekarmanik</option>
<option value="Mekarsaluyu" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarsaluyu' ? 'selected' : '' ?>>Mekarsaluyu</option>
<option value="Sindanglaya" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sindanglaya' ? 'selected' : '' ?>>Sindanglaya</option>
<option value="Cibeunying" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cibeunying' ? 'selected' : '' ?>>Cibeunying</option>
<option value="Padasuka" class="desa cimenyan" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Padasuka' ? 'selected' : '' ?>>Padasuka</option>
<!-- Desa Ciparay -->
<option value="Babakan" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Babakan' ? 'selected' : '' ?>>Babakan</option>
<option value="Bumiwangi" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bumiwangi' ? 'selected' : '' ?>>Bumiwangi</option>
<option value="Ciheulang" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciheulang' ? 'selected' : '' ?>>Ciheulang</option>
<option value="Cikoneng" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikoneng' ? 'selected' : '' ?>>Cikoneng</option>
<option value="Ciparay" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciparay' ? 'selected' : '' ?>>Ciparay</option>
<option value="Gunungleutik" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Gunungleutik' ? 'selected' : '' ?>>Gunungleutik</option>
<option value="Manggungharja" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Manggungharja' ? 'selected' : '' ?>>Manggungharja</option>
<option value="Mekarlaksana" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarlaksana' ? 'selected' : '' ?>>Mekarlaksana</option>
<option value="Mekarsari" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Pakutandang" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pakutandang' ? 'selected' : '' ?>>Pakutandang</option>
<option value="Sagaracipta" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sagaracipta' ? 'selected' : '' ?>>Sagaracipta</option>
<option value="Sarimahi" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sarimahi' ? 'selected' : '' ?>>Sarimahi</option>
<option value="Serangmekar" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Serangmekar' ? 'selected' : '' ?>>Serangmekar</option>
<option value="Sumbersari" class="desa ciparay" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sumbersari' ? 'selected' : '' ?>>Sumbersari</option>

<!-- Desa Ciwidey -->
<option value="Ciwidey" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciwidey' ? 'selected' : '' ?>>Ciwidey</option>
<option value="Lebakmuncang" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Lebakmuncang' ? 'selected' : '' ?>>Lebakmuncang</option>
<option value="Nengkelan" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Nengkelan' ? 'selected' : '' ?>>Nengkelan</option>
<option value="Panundaan" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Panundaan' ? 'selected' : '' ?>>Panundaan</option>
<option value="Panyocokan" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Panyocokan' ? 'selected' : '' ?>>Panyocokan</option>
<option value="Rawabogo" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Rawabogo' ? 'selected' : '' ?>>Rawabogo</option>
<option value="Sukawening" class="desa ciwidey" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukawening' ? 'selected' : '' ?>>Sukawening</option>

<!-- Desa Dayeuhkolot -->
<option value="Cangkuang Kulon" class="desa dayeuhkolot" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cangkuang Kulon' ? 'selected' : '' ?>>Cangkuang Kulon</option>
<option value="Cangkuang Wetan" class="desa dayeuhkolot" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cangkuang Wetan' ? 'selected' : '' ?>>Cangkuang Wetan</option>
<option value="Citeureup" class="desa dayeuhkolot" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Citeureup' ? 'selected' : '' ?>>Citeureup</option>
<option value="Dayeuhkolot" class="desa dayeuhkolot" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Dayeuhkolot' ? 'selected' : '' ?>>Dayeuhkolot</option>
<option value="Sukapura" class="desa dayeuhkolot" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukapura' ? 'selected' : '' ?>>Sukapura</option>
<option value="Pasawahan" class="desa dayeuhkolot" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pasawahan' ? 'selected' : '' ?>>Pasawahan</option>

<!-- Desa Ibun -->
<option value="Cibeet" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cibeet' ? 'selected' : '' ?>>Cibeet</option>
<option value="Dukuh" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Dukuh' ? 'selected' : '' ?>>Dukuh</option>
<option value="Ibun" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ibun' ? 'selected' : '' ?>>Ibun</option>
<option value="Karyalaksana" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Karyalaksana' ? 'selected' : '' ?>>Karyalaksana</option>
<option value="Laksana" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Laksana' ? 'selected' : '' ?>>Laksana</option>
<option value="Lampegan" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Lampegan' ? 'selected' : '' ?>>Lampegan</option>
<option value="Mekarwangi" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarwangi' ? 'selected' : '' ?>>Mekarwangi</option>
<option value="Neglasari" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Neglasari' ? 'selected' : '' ?>>Neglasari</option>
<option value="Pangguh" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pangguh' ? 'selected' : '' ?>>Pangguh</option>
<option value="Sudi" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sudi' ? 'selected' : '' ?>>Sudi</option>
<option value="Talun" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Talun' ? 'selected' : '' ?>>Talun</option>
<option value="Tanggulun" class="desa ibun" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Tanggulun' ? 'selected' : '' ?>>Tanggulun</option>

<!-- Desa Katapang -->
<option value="Banyusari" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Banyusari' ? 'selected' : '' ?>>Banyusari</option>
<option value="Cilampeni" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cilampeni' ? 'selected' : '' ?>>Cilampeni</option>
<option value="Gandasari" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Gandasari' ? 'selected' : '' ?>>Gandasari</option>
<option value="Katapang" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Katapang' ? 'selected' : '' ?>>Katapang</option>
<option value="Pangauban" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pangauban' ? 'selected' : '' ?>>Pangauban</option>
<option value="Sangkanhurip" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sangkanhurip' ? 'selected' : '' ?>>Sangkanhurip</option>
<option value="Sukamukti" class="desa katapang" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukamukti' ? 'selected' : '' ?>>Sukamukti</option>

<!-- Desa Kertasari -->
<option value="Cibeureum" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cibeureum' ? 'selected' : '' ?>>Cibeureum</option>
<option value="Cihawuk" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cihawuk' ? 'selected' : '' ?>>Cihawuk</option>
<option value="Cikembang" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikembang' ? 'selected' : '' ?>>Cikembang</option>
<option value="Neglawangi" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Neglawangi' ? 'selected' : '' ?>>Neglawangi</option>
<option value="Resmitingal" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Resmitingal' ? 'selected' : '' ?>>Resmitingal</option>
<option value="Santosa" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Santosa' ? 'selected' : '' ?>>Santosa</option>
<option value="Sukapura" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukapura' ? 'selected' : '' ?>>Sukapura</option>
<option value="Tarumajaya" class="desa kertasari" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Tarumajaya' ? 'selected' : '' ?>>Tarumajaya</option>

<!-- Desa Kutawaringin -->
<option value="Buninagara" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Buninagara' ? 'selected' : '' ?>>Buninagara</option>
<option value="Cibodas" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cibodas' ? 'selected' : '' ?>>Cibodas</option>
<option value="Cilame" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cilame' ? 'selected' : '' ?>>Cilame</option>
<option value="Gajahmekar" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Gajahmekar' ? 'selected' : '' ?>>Gajahmekar</option>
<option value="Jatisari" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Jatisari' ? 'selected' : '' ?>>Jatisari</option>
<option value="Jelegong" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Jelegong' ? 'selected' : '' ?>>Jelegong</option>
<option value="Kopo" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Kopo' ? 'selected' : '' ?>>Kopo</option>
<option value="Kutawaringin" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Kutawaringin' ? 'selected' : '' ?>>Kutawaringin</option>
<option value="Padasuka" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Padasuka' ? 'selected' : '' ?>>Padasuka</option>
<option value="Pameuntasan" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pameuntasan' ? 'selected' : '' ?>>Pameuntasan</option>
<option value="Sukamulya" class="desa kutawaringin" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukamulya' ? 'selected' : '' ?>>Sukamulya</option>

<!-- Desa Majalaya -->
<option value="Biru" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Biru' ? 'selected' : '' ?>>Biru</option>
<option value="Bojong" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojong' ? 'selected' : '' ?>>Bojong</option>
<option value="Majakerta" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Majakerta' ? 'selected' : '' ?>>Majakerta</option>
<option value="Majalaya" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Majalaya' ? 'selected' : '' ?>>Majalaya</option>
<option value="Majasetra" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Majasetra' ? 'selected' : '' ?>>Majasetra</option>
<option value="Neglasari" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Neglasari' ? 'selected' : '' ?>>Neglasari</option>
<option value="Padamulya" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Padamulya' ? 'selected' : '' ?>>Padamulya</option>
<option value="Padaulun" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Padaulun' ? 'selected' : '' ?>>Padaulun</option>
<option value="Sukamaju" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukamaju' ? 'selected' : '' ?>>Sukamaju</option>
<option value="Sukamukti" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukamukti' ? 'selected' : '' ?>>Sukamukti</option>
<option value="Wangisagara" class="desa majalaya" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Wangisagara' ? 'selected' : '' ?>>Wangisagara</option>

<!-- Desa Margaasih -->
<option value="Cigondewah Hilir" class="desa margaasih" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cigondewah Hilir' ? 'selected' : '' ?>>Cigondewah Hilir</option>
<option value="Lagadar" class="desa margaasih" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Lagadar' ? 'selected' : '' ?>>Lagadar</option>
<option value="Margaasih" class="desa margaasih" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Margaasih' ? 'selected' : '' ?>>Margaasih</option>
<option value="Mekar Rahayu" class="desa margaasih" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekar Rahayu' ? 'selected' : '' ?>>Mekar Rahayu</option>
<option value="Nanjung" class="desa margaasih" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Nanjung' ? 'selected' : '' ?>>Nanjung</option>
<option value="Rahayu" class="desa margaasih" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Rahayu' ? 'selected' : '' ?>>Rahayu</option>

<!-- Desa Margahayu -->
<option value="Margahayu Selatan" class="desa margahayu" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Margahayu Selatan' ? 'selected' : '' ?>>Margahayu Selatan</option>
<option value="Margahayu Tengah" class="desa margahayu" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Margahayu Tengah' ? 'selected' : '' ?>>Margahayu Tengah</option>
<option value="Sayati" class="desa margahayu" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sayati' ? 'selected' : '' ?>>Sayati</option>
<option value="Sukamenak" class="desa margahayu" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukamenak' ? 'selected' : '' ?>>Sukamenak</option>
<option value="Sulaeman" class="desa margahayu" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sulaeman' ? 'selected' : '' ?>>Sulaeman</option>

<!-- Desa Nagreg -->
<option value="Bojong" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojong' ? 'selected' : '' ?>>Bojong</option>
<option value="Ciaro" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciaro' ? 'selected' : '' ?>>Ciaro</option>
<option value="Ciherang" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ciherang' ? 'selected' : '' ?>>Ciherang</option>
<option value="Citaman" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Citaman' ? 'selected' : '' ?>>Citaman</option>
<option value="Ganjarsabar" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Ganjarsabar' ? 'selected' : '' ?>>Ganjarsabar</option>
<option value="Mandalawangi" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mandalawangi' ? 'selected' : '' ?>>Mandalawangi</option>
<option value="Nagreg" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Nagreg' ? 'selected' : '' ?>>Nagreg</option>
<option value="Nagreg Kendan" class="desa nagreg" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Nagreg Kendan' ? 'selected' : '' ?>>Nagreg Kendan</option>

<!-- Desa Pacet -->
<option value="Cikawao" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikawao' ? 'selected' : '' ?>>Cikawao</option>
<option value="Cikitu" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cikitu' ? 'selected' : '' ?>>Cikitu</option>
<option value="Cinanggela" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cinanggela' ? 'selected' : '' ?>>Cinanggela</option>
<option value="Cipeujeuh" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Cipeujeuh' ? 'selected' : '' ?>>Cipeujeuh</option>
<option value="Girimulya" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Girimulya' ? 'selected' : '' ?>>Girimulya</option>
<option value="Mandalahaji" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mandalahaji' ? 'selected' : '' ?>>Mandalahaji</option>
<option value="Maruyung" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Maruyung' ? 'selected' : '' ?>>Maruyung</option>
<option value="Mekarjaya" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarjaya' ? 'selected' : '' ?>>Mekarjaya</option>
<option value="Mekarsari" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Nagrak" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Nagrak' ? 'selected' : '' ?>>Nagrak</option>
<option value="Pangauban" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Pangauban' ? 'selected' : '' ?>>Pangauban</option>
<option value="Sukarame" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukarame' ? 'selected' : '' ?>>Sukarame</option>
<option value="Tanjungwangi" class="desa pacet" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Tanjungwangi' ? 'selected' : '' ?>>Tanjungwangi</option>

<!-- Desa Pameungpeuk -->
<option value="Bojongkunci" class="desa pameungpeuk" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojongkunci' ? 'selected' : '' ?>>Bojongkunci</option>
<option value="Bojongmanggu" class="desa pameungpeuk" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Bojongmanggu' ? 'selected' : '' ?>>Bojongmanggu</option>
<option value="Langonsari" class="desa pameungpeuk" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Langonsari' ? 'selected' : '' ?>>Langonsari</option>
<option value="Rancamulya" class="desa pameungpeuk" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Rancamulya' ? 'selected' : '' ?>>Rancamulya</option>
<option value="Rancatungku" class="desa pameungpeuk" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Rancatungku' ? 'selected' : '' ?>>Rancatungku</option>
<option value="Sukasari" class="desa pameungpeuk" <?= isset($umkm['desa_kelurahan']) && $umkm['desa_kelurahan'] == 'Sukasari' ? 'selected' : '' ?>>Sukasari</option>

<!-- Desa Pangalengan -->
<option value="Banjarsari" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Banjarsari' ? 'selected' : '' ?>>Banjarsari</option>
<option value="Lamajang" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Lamajang' ? 'selected' : '' ?>>Lamajang</option>
<option value="Margaluyu" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Margaluyu' ? 'selected' : '' ?>>Margaluyu</option>
<option value="Margamekar" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Margamekar' ? 'selected' : '' ?>>Margamekar</option>
<option value="Margamukti" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Margamukti' ? 'selected' : '' ?>>Margamukti</option>
<option value="Margamulya" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Margamulya' ? 'selected' : '' ?>>Margamulya</option>
<option value="Pangalengan" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Pangalengan' ? 'selected' : '' ?>>Pangalengan</option>
<option value="Pulosari" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Pulosari' ? 'selected' : '' ?>>Pulosari</option>
<option value="Sukaluyu" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sukaluyu' ? 'selected' : '' ?>>Sukaluyu</option>
<option value="Sukamanah" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sukamanah' ? 'selected' : '' ?>>Sukamanah</option>
<option value="Tribaktimulya" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Tribaktimulya' ? 'selected' : '' ?>>Tribaktimulya</option>
<option value="Wanasuka" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Wanasuka' ? 'selected' : '' ?>>Wanasuka</option>
<option value="Warnasari" class="desa pangalengan" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Warnasari' ? 'selected' : '' ?>>Warnasari</option>

<!-- Desa Paseh -->
<option value="Cigentur" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cigentur' ? 'selected' : '' ?>>Cigentur</option>
<option value="Cijagra" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cijagra' ? 'selected' : '' ?>>Cijagra</option>
<option value="Cipaku" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cipaku' ? 'selected' : '' ?>>Cipaku</option>
<option value="Cipedes" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cipedes' ? 'selected' : '' ?>>Cipedes</option>
<option value="Drawati" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Drawati' ? 'selected' : '' ?>>Drawati</option>
<option value="Karangtunggal" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Karangtunggal' ? 'selected' : '' ?>>Karangtunggal</option>
<option value="Loa" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Loa' ? 'selected' : '' ?>>Loa</option>
<option value="Mekarpawitan" class="desa paseh" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Mekarpawitan' ? 'selected' : '' ?>>Mekarpawitan</option>

<!-- Desa Pasirjambu -->
<option value="Cibodas" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cibodas' ? 'selected' : '' ?>>Cibodas</option>
<option value="Cikoneng" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cikoneng' ? 'selected' : '' ?>>Cikoneng</option>
<option value="Cisondari" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cisondari' ? 'selected' : '' ?>>Cisondari</option>
<option value="Cukanggenteng" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cukanggenteng' ? 'selected' : '' ?>>Cukanggenteng</option>
<option value="Margamulya" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Margamulya' ? 'selected' : '' ?>>Margamulya</option>
<option value="Mekarmaju" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Mekarmaju' ? 'selected' : '' ?>>Mekarmaju</option>
<option value="Mekarsari" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Mekarsari' ? 'selected' : '' ?>>Mekarsari</option>
<option value="Pasirjambu" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Pasirjambu' ? 'selected' : '' ?>>Pasirjambu</option>
<option value="Sugihmukti" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sugihmukti' ? 'selected' : '' ?>>Sugihmukti</option>
<option value="Tenjolaya" class="desa pasirjambu" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Tenjolaya' ? 'selected' : '' ?>>Tenjolaya</option>

<!-- Desa Rancabali -->
<option value="Alamendah" class="desa rancabali" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Alamendah' ? 'selected' : '' ?>>Alamendah</option>
<option value="Cipelah" class="desa rancabali" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cipelah' ? 'selected' : '' ?>>Cipelah</option>
<option value="Indragiri" class="desa rancabali" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Indragiri' ? 'selected' : '' ?>>Indragiri</option>
<option value="Patengan" class="desa rancabali" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Patengan' ? 'selected' : '' ?>>Patengan</option>
<option value="Sukaresmi" class="desa rancabali" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sukaresmi' ? 'selected' : '' ?>>Sukaresmi</option>

<!-- Desa Rancaekek -->
<option value="Bojongloa" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Bojongloa' ? 'selected' : '' ?>>Bojongloa</option>
<option value="Bojongsalam" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Bojongsalam' ? 'selected' : '' ?>>Bojongsalam</option>
<option value="Cangkuang" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cangkuang' ? 'selected' : '' ?>>Cangkuang</option>
<option value="Haurpugur" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Haurpugur' ? 'selected' : '' ?>>Haurpugur</option>
<option value="Jelegong" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Jelegong' ? 'selected' : '' ?>>Jelegong</option>
<option value="Linggar" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Linggar' ? 'selected' : '' ?>>Linggar</option>
<option value="Nanjungmekar" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Nanjungmekar' ? 'selected' : '' ?>>Nanjungmekar</option>
<option value="Rancaekek Kulon" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Rancaekek Kulon' ? 'selected' : '' ?>>Rancaekek Kulon</option>
<option value="Rancaekek Wetan" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Rancaekek Wetan' ? 'selected' : '' ?>>Rancaekek Wetan</option>
<option value="Sangiang" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sangiang' ? 'selected' : '' ?>>Sangiang</option>
<option value="Sukamanah" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sukamanah' ? 'selected' : '' ?>>Sukamanah</option>
<option value="Sukamulya" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sukamulya' ? 'selected' : '' ?>>Sukamulya</option>
<option value="Tegalsumedang" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Tegalsumedang' ? 'selected' : '' ?>>Tegalsumedang</option>
<option value="Rancaekek Kencana" class="desa rancaekek" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Rancaekek Kencana' ? 'selected' : '' ?>>Rancaekek Kencana</option>

<!-- Desa Solokanjeruk -->
<option value="Bojongemas" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Bojongemas' ? 'selected' : '' ?>>Bojongemas</option>
<option value="Cibodas" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cibodas' ? 'selected' : '' ?>>Cibodas</option>
<option value="Langensari" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Langensari' ? 'selected' : '' ?>>Langensari</option>
<option value="Padamukti" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Padamukti' ? 'selected' : '' ?>>Padamukti</option>
<option value="Panyadap" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Panyadap' ? 'selected' : '' ?>>Panyadap</option>
<option value="Rancakasumba" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Rancakasumba' ? 'selected' : '' ?>>Rancakasumba</option>
<option value="Solokanjeruk" class="desa solokanjeruk" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Solokanjeruk' ? 'selected' : '' ?>>Solokanjeruk</option>

<!-- Desa Soreang -->
<option value="Cingcin" class="desa soreang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Cingcin' ? 'selected' : '' ?>>Cingcin</option>
<option value="Karamatmulya" class="desa soreang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Karamatmulya' ? 'selected' : '' ?>>Karamatmulya</option>
<option value="Pamekaran" class="desa soreang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Pamekaran' ? 'selected' : '' ?>>Pamekaran</option>
<option value="Panyirapan" class="desa soreang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Panyirapan' ? 'selected' : '' ?>>Panyirapan</option>
<option value="Parungserab" class="desa soreang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Parungserab' ? 'selected' : '' ?>>Parungserab</option>
<option value="Sadu" class="desa soreang" <?= isset($desa_kelurahan) && $desa_kelurahan == 'Sadu' ? 'selected' : '' ?>>Sadu</option>


    </select>
</div>
<label for="jenis_usaha">Jenis Usaha:</label>
  <select name="jenis_usaha" id="jenis_usaha" class="form-control" onchange="updatePendapatan()" required>
    <option value="">-- Pilih Jenis Usaha --</option>
    <option value="Mikro" <?= $umkm['jenis_usaha'] == 'Mikro' ? 'selected' : '' ?>>Mikro</option>
    <option value="Kecil" <?= $umkm['jenis_usaha'] == 'Kecil' ? 'selected' : '' ?>>Kecil</option>
    <option value="Menengah" <?= $umkm['jenis_usaha'] == 'Menengah' ? 'selected' : '' ?>>Menengah</option>
  </select>

  <br>

  <label for="pendapatan">Pendapatan per Tahun (Rp):</label>
  <input type="text" name="pendapatan" id="pendapatan" class="form-control" readonly
         value="<?= $umkm['pendapatan'] ?>">

  <br>

<!-- UMKM Kategori -->
<div class="mb-3">
    <label style="color:white;" for="kategori_produk" class="form-label">Kategori Produk</label>
    <select class="form-control" id="kategori_produk" name="kategori_produk" required>
        <option value="" disabled <?= empty($umkm['kategori_produk']) ? 'selected' : '' ?>>Pilih Kategori</option>
        <option value="Kuliner" <?= isset($umkm['kategori_produk']) && $umkm['kategori_produk'] == 'Kuliner' ? 'selected' : '' ?>>Kuliner</option>
        <option value="Kerajinan" <?= isset($umkm['kategori_produk']) && $umkm['kategori_produk'] == 'Kerajinan' ? 'selected' : '' ?>>Kerajinan</option>
        <option value="Fashion" <?= isset($umkm['kategori_produk']) && $umkm['kategori_produk'] == 'Fashion' ? 'selected' : '' ?>>Fashion</option>
    </select>
</div>



          <!-- UMKM NIB -->
<div class="mb-3">
    <label style="color:white;" for="nib" class="form-label">NIB</label>
    <input type="text" class="form-control" id="nib" name="nib" 
        value="<?= isset($umkm['nib']) ? $umkm['nib'] : ''; ?>">
</div>

<!-- UMKM PIRT -->
<div class="mb-3">
    <label style="color:white;" for="pirt" class="form-label">PIRT</label>
    <input type="text" class="form-control" id="pirt" name="pirt" 
        value="<?= isset($umkm['pirt']) ? $umkm['pirt'] : ''; ?>">
</div>

<!-- UMKM BPOM -->
<div class="mb-3">
    <label style="color:white;" for="bpom" class="form-label">BPOM</label>
    <input type="text" class="form-control" id="bpom" name="bpom" 
        value="<?= isset($umkm['bpom']) ? $umkm['bpom'] : ''; ?>">
</div>

<!-- UMKM HALAL -->
<div class="mb-3">
    <label style="color:white;" for="halal" class="form-label">Halal</label>
    <input type="text" class="form-control" id="halal" name="halal" 
        value="<?= isset($umkm['halal']) ? $umkm['halal'] : ''; ?>">
</div>

<!-- UMKM HAKI -->
<div class="mb-3">
    <label style="color:white;" for="haki" class="form-label">HAKI</label>
    <input type="text" class="form-control" id="haki" name="haki" 
        value="<?= isset($umkm['haki']) ? $umkm['haki'] : ''; ?>">
</div>

<!-- UMKM Lainnya -->
<div class="mb-3">
    <label style="color:white;" for="lainnya" class="form-label">Lainnya</label>
    <input type="text" class="form-control" id="lainnya" name="lainnya" 
        value="<?= isset($umkm['lainnya']) ? $umkm['lainnya'] : ''; ?>">
</div>

<!-- UMKM Deskripsi Produk -->
<div class="mb-3">
    <label style="color:white;" for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
    <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3"><?= isset($umkm['deskripsi_produk']) ? $umkm['deskripsi_produk'] : ''; ?></textarea>
</div>

<!-- UMKM Deskripsi (Checkboxes) -->
<div class="mb-3">
    <label style="color:white;" class="form-label">Deskripsi Produk</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="online" name="online" value="Online" 
        <?= isset($umkm['online']) && $umkm['online'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="online">Online</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="offline" name="offline" value="Offline" 
        <?= isset($umkm['offline']) && $umkm['offline'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="offline">Offline</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="agen_reseller" name="agen_reseller" value="Agen / Reseller" 
        <?= isset($umkm['agen_reseller']) && $umkm['agen_reseller'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="agen_reseller">Agen / Reseller</label>
    </div>
</div>

<!-- UMKM WhatsApp -->
<div class="mb-3">
    <label style="color:white;" for="whatsapp" class="form-label">WhatsApp</label>
    <input type="text" class="form-control" id="whatsapp" name="whatsapp" 
        value="<?= isset($umkm['whatsapp']) ? $umkm['whatsapp'] : ''; ?>">
</div>

<!-- UMKM Blibli -->
<div class="mb-3">
    <label style="color:white;" for="blibli" class="form-label">Blibli</label>
    <input type="text" class="form-control" id="blibli" name="blibli" 
        value="<?= isset($umkm['blibli']) ? $umkm['blibli'] : ''; ?>">
</div>

<!-- UMKM Lazada -->
<div class="mb-3">
    <label style="color:white;" for="lazada" class="form-label">Lazada</label>
    <input type="text" class="form-control" id="lazada" name="lazada" 
        value="<?= isset($umkm['lazada']) ? $umkm['lazada'] : ''; ?>">
</div>

<!-- UMKM Shopee -->
<div class="mb-3">
    <label style="color:white;" for="shopee" class="form-label">Shopee</label>
    <input type="text" class="form-control" id="shopee" name="shopee" 
        value="<?= isset($umkm['shopee']) ? $umkm['shopee'] : ''; ?>">
</div>

<!-- UMKM Tokopedia -->
<div class="mb-3">
    <label style="color:white;" for="tokopedia" class="form-label">Tokopedia</label>
    <input type="text" class="form-control" id="tokopedia" name="tokopedia" 
        value="<?= isset($umkm['tokopedia']) ? $umkm['tokopedia'] : ''; ?>">
</div>

<!-- UMKM Facebook -->
<div class="mb-3">
    <label style="color:white;" for="facebook" class="form-label">Facebook</label>
    <input type="text" class="form-control" id="facebook" name="facebook" 
        value="<?= isset($umkm['facebook']) ? $umkm['facebook'] : ''; ?>">
</div>

<!-- UMKM Instagram -->
<div class="mb-3">
    <label style="color:white;" for="instagram" class="form-label">Instagram</label>
    <input type="text" class="form-control" id="instagram" name="instagram" 
        value="<?= isset($umkm['instagram']) ? $umkm['instagram'] : ''; ?>">
</div>

<!-- UMKM Tiktok -->
<div class="mb-3">
    <label style="color:white;" for="tiktok" class="form-label">Tiktok</label>
    <input type="text" class="form-control" id="tiktok" name="tiktok" 
        value="<?= isset($umkm['tiktok']) ? $umkm['tiktok'] : ''; ?>">
</div>

<!-- UMKM Twitter -->
<div class="mb-3">
    <label style="color:white;" for="twitter" class="form-label">Twitter</label>
    <input type="text" class="form-control" id="twitter" name="twitter" 
        value="<?= isset($umkm['twitter']) ? $umkm['twitter'] : ''; ?>">
</div>


<!-- UMKM Status -->
<div class="mb-3">
    <label style="color:white;" for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-control" onchange="toggleCatatan();" required>
        <option value="menunggu" <?= isset($umkm['status']) && $umkm['status'] == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
        <option value="disetujui" <?= isset($umkm['status']) && $umkm['status'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
        <option value="ditolak" <?= isset($umkm['status']) && $umkm['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
    </select>
</div>

<!-- Catatan Section (only visible when status is 'ditolak') -->
<div class="mb-3" id="catatanSection" style="display: none;">
    <label style="color:white;" for="catatan" class="form-label">Catatan</label>
    <textarea class="form-control" id="catatan" name="catatan" rows="4"><?= isset($umkm['catatan']) ? $umkm['catatan'] : ''; ?></textarea>
</div>

            <input type="hidden" name="old_photo" value="<?php echo $umkm['photo']; ?>">

<!-- Photo -->
<div class="mb-3">
<label style="color:white;" for="photo">Photo (opsional)</label>
<input type="file" class="form-control" id="photo" name="photo">
<?php if (!empty($umkm['photo'])): ?>
<img src="<?php echo base_url('uploads/umkm/' . $umkm['photo']); ?>" 
 alt="Current Photo" 
 style="width:100px; height:100px; object-fit:cover; margin-top:10px;">
<?php endif; ?>
</div>
            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
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
        "Margahayu Selatan": { latitude: "-6.960254", longitude: "107.570369" },
        "Margahayu Tengah": { latitude: "-6.960110", longitude: "107.565750" },
        "Sayati": { latitude: "-6.950276", longitude: "107.575764" },
        "Sukamenak": { latitude: "-6.955795", longitude: "107.581375" },
        "Sulaeman": { latitude: "-6.951419", longitude: "107.566612" },
        
        // Katapang
        "Banyusari": { latitude: "-6.965130", longitude: "107.589210" },
        "Cilampeni": { latitude: "-6.963678", longitude: "107.595320" },
        "Gandasari": { latitude: "-6.969523", longitude: "107.578945" },
        "Katapang": { latitude: "-6.974510", longitude: "107.582147" },
        "Pangauban": { latitude: "-6.970888", longitude: "107.599344" },
        "Sangkanhurip": { latitude: "-6.968712", longitude: "107.586750" },
        "Sukamukti": { latitude: "-6.971233", longitude: "107.594125" }
    };

    // Event listener untuk mengisi latitude dan longitude otomatis
    document.getElementById('desa_kelurahan').addEventListener('change', function() {
        const desaTerpilih = this.value;
        if (koordinatDesa[desaTerpilih]) {
            document.getElementById('latitude').value = koordinatDesa[desaTerpilih].latitude;
            document.getElementById('longtitude').value = koordinatDesa[desaTerpilih].longitude;
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
<script>
    // Function to toggle visibility of the 'Catatan' section
    function toggleCatatan() {
        var status = document.getElementById('status').value;
        var catatanSection = document.getElementById('catatanSection');
        
        if (status === 'ditolak') {
            catatanSection.style.display = 'block'; // Show the section
        } else {
            catatanSection.style.display = 'none'; // Hide the section
        }
    }

    // Run the function on page load to set the initial state
    window.onload = function() {
        toggleCatatan();
    }
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
