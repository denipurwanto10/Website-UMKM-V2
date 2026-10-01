<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            <h5 style="color:white;">Tambah User Baru</h5>
        </div>
        <div class="card-body">
        <!-- Form for creating user -->
        <form action="<?php echo site_url('users/store'); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
            <!-- Username -->
            <div class="mb-3">
                <label style="color:white;" for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username'); ?>" required>
            </div>

            <!-- Full Name -->
            <div class="mb-3">
                <label style="color:white;" for="fullname" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= set_value('fullname'); ?>" required>
            </div>

            <!-- User Type -->
            <div class="mb-3">
                <label style="color:white;" for="usertype" class="form-label">Role</label>
                <select class="form-select" id="usertype" name="usertype" required>
                    <option value="Admin" <?= set_select('usertype', 'Admin'); ?>>Admin</option>
                    <option value="Owner" <?= set_select('usertype', 'Owner'); ?>>Owner</option>
                </select>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label style="color:white;" for="nomor_hp" class="form-label">No HP</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?= set_value('nomor_hp'); ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label style="color:white;" for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label style="color:white;" for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label style="color:white;" for="confpassword" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confpassword" name="confpassword" required>
            </div>

           

            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>  <!-- End Card -->

</div>
    <!-- Optional: Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Password confirmation & validation -->
     <script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = new FormData(form[0]);
        
        // // Tampilkan loading
        // Swal.fire({
        //     title: 'Memproses...',
        //     html: 'Sedang menyimpan data user',
        //     allowOutsideClick: false,
        //     didOpen: () => {
        //         Swal.showLoading();
        //     }
        // });
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= site_url('users') ?>';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                try {
                    var errorResponse = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorResponse.message || 'Terjadi kesalahan pada server',
                        confirmButtonText: 'OK'
                    });
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengirim data',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
    
    
});
</script>
    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confpassword").value;
            var phone = document.getElementById("nomor_hp").value;
            var fileInput = document.getElementById("photo");
            var file = fileInput.files[0];

            // Cek username tidak boleh ada spasi
            if (username.includes(' ')) {
                alert("Username tidak boleh mengandung spasi.");
                document.getElementById("username").focus();
                return false;
            }

            // Cek konfirmasi password
            if (password !== confirmPassword) {
                alert("Password dan Confirm Password tidak sama.");
                document.getElementById("confpassword").focus();
                return false;
            }

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
</body>
</html>