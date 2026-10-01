<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promosi</title>
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
        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="card">
        <div class="card-header">
            <h5 style="color:white;">Edit Promosi</h5>
        </div>
        <div class="card-body">
        <form action="<?= site_url('promosi/update1/' . $promosi['id']) ?>" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required class="form-control" value="<?= $promosi['username']; ?>" readonly>
            </div>
            <br>
            <div class="form-group">
                <label for="fasilitasi_promosi">1. Apakah selama setahun yang lalu pernah mendapatkan fasilitasi promosi pemasaran?</label>
                <div class="form-check">
                    <input type="radio" id="fasilitasi_ya" name="fasilitasi_promosi_radio" value="Ya" class="form-check-input" <?= $promosi['fasilitasi_promosi'] == 'Ya' ? 'checked' : '' ?> onclick="toggleAdditionalText(false)">
                    <label for="fasilitasi_ya" class="form-check-label">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="fasilitasi_tidak" name="fasilitasi_promosi_radio" value="Tidak" class="form-check-input" <?= $promosi['fasilitasi_promosi'] != 'Ya' ? 'checked' : '' ?> onclick="toggleAdditionalText(true)">
                    <label for="fasilitasi_tidak" class="form-check-label">Tidak</label>
                </div>
                <div class="form-group" id="additionalTextWrapper" style="display: <?= $promosi['fasilitasi_promosi'] != 'Ya' ? 'block' : 'none' ?>;">
                    <label for="additionalText">Alasan fasilitasi promosi pemasaran:</label>
                    <textarea class="form-control" id="additionalText" name="fasilitasi_promosi" rows="3" <?= $promosi['fasilitasi_promosi'] != 'Ya' ? 'required' : '' ?>><?= $promosi['fasilitasi_promosi'] != 'Ya' ? $promosi['fasilitasi_promosi'] : '' ?></textarea>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="hambatan_memasarkan_produk">2. Hambatan dalam memasarkan produk:</label>
                <textarea class="form-control" id="hambatan_memasarkan_produk" name="hambatan_memasarkan_produk" rows="3"><?= $promosi['hambatan_memasarkan_produk']; ?></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="bantuan_dibutuhkan">3. Bantuan yang dibutuhkan:</label>
                <textarea class="form-control" id="bantuan_dibutuhkan" name="bantuan_dibutuhkan" rows="3"><?= $promosi['bantuan_dibutuhkan']; ?></textarea>
            </div>
            <br>
            <div class="form-group">
                <label>4. Apakah berminat mengikuti Bazar Ramadhan 2024?</label>
                <div class="form-check">
                    <input type="radio" id="bazar_ya" name="berminat_bazar_ramadhan" value="Ya" class="form-check-input" <?= $promosi['berminat_bazar_ramadhan'] == 'Ya' ? 'checked' : '' ?> required>
                    <label for="bazar_ya" class="form-check-label">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="bazar_tidak" name="berminat_bazar_ramadhan" value="Tidak" class="form-check-input" <?= $promosi['berminat_bazar_ramadhan'] == 'Tidak' ? 'checked' : '' ?> required>
                    <label for="bazar_tidak" class="form-check-label">Tidak</label>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label>5. Apakah berminat mengikuti pelatihan pemasaran online?</label>
                <div class="form-check">
                    <input type="radio" id="pelatihan_ya" name="berminat_pelatihan_online" value="Ya" class="form-check-input" <?= $promosi['berminat_pelatihan_online'] == 'Ya' ? 'checked' : '' ?> required>
                    <label for="pelatihan_ya" class="form-check-label">Ya</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="pelatihan_tidak" name="berminat_pelatihan_online" value="Tidak" class="form-check-input" <?= $promosi['berminat_pelatihan_online'] == 'Tidak' ? 'checked' : '' ?> required>
                    <label for="pelatihan_tidak" class="form-check-label">Tidak</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleAdditionalText(show) {
            const additionalTextWrapper = document.getElementById('additionalTextWrapper');
            const additionalText = document.getElementById('additionalText');

            if (show) {
                additionalTextWrapper.style.display = 'block';
                additionalText.setAttribute('required', 'required');
            } else {
                additionalTextWrapper.style.display = 'none';
                additionalText.value = '';
                additionalText.removeAttribute('required');
            }
        }

        function validateForm() {
            const fasilitasiTidak = document.getElementById('fasilitasi_tidak').checked;
            const additionalText = document.getElementById('additionalText').value.trim();
            const fasilitasiYa = document.getElementById('fasilitasi_ya').checked;

            if (fasilitasiTidak && additionalText === '') {
                alert('Silakan isi alasan fasilitasi promosi pemasaran.');
                return false;
            }

            if (fasilitasiYa) {
                document.getElementById('additionalText').value = 'Ya';
            }

            return true;
        }

        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("loading-spinner").style.display = "none";
            }, 500);
        });
    </script>
</body>
</html>
