<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Users</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo.css')?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Flexbox untuk tombol Edit & Delete bersebelahan */
        .action-buttons {
            display: flex;
            gap: 5px; /* Spasi antar tombol */
        }

      
        /* Card Design */
.card {
  background: rgba(0, 0, 0, 0.5) !important;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: none; /* Remove border */
  color: #fff;
}
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .card-body {
            padding: 2rem;
        }
        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }


        /* Flexbox untuk layout profile dan data dalam satu card */
        .profile-data-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .profile-data-container .profile-card {
            flex: 1 1 45%; /* Membuat dua kolom responsif */
            min-width: 300px;
        }
        .profile-card img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .card-img {
            width: 300px; /* Lebar gambar */
            height: 200px; /* Tinggi gambar */
            object-fit: cover; /* Menjaga proporsi gambar */
            border-radius: 0; /* Pastikan sudut gambar tidak melengkung */
            transition: transform 0.3s ease; /* Efek transisi saat zoom */
            pointer-events: none; /* Mencegah zoom dengan pointer */
        }

        .card-img:hover {
            transform: scale(1.05); /* Memperbesar gambar sedikit saat hover */
        }

        /* Menghapus zoom melalui scroll pada gambar */
        img {
            user-select: none; /* Mencegah pemilihan gambar */
            pointer-events: none; /* Mencegah zoom dengan klik pada gambar */
        }

    </style>
</head>
<body>
<?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] !== 'Owner'): ?>
    <script type="text/javascript">
        alert('Access Denied: You do not have permission to access this page.');
        window.location.href = '<?php echo site_url('dashboard'); ?>'; // Redirect to another page (e.g., dashboard)
    </script>
<?php else: ?>

<?php include('sidebar.php'); ?>
    <div class="container mt-3">

        <!-- Card Wrapper -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 style="color:white;" class="mb-0">Profil Pengguna</h5>
            </div>
            <div class="card-body">

                <div class="profile-data-container">
                    <!-- Card Profile (User Info) -->
                    <div class="profile-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="<?= base_url('uploads/users/' . $user['photo']) ?>" alt="User Photo" class="card-img mb-3" style="width: 300px; height: 200px; object-fit: cover; border-radius: 0;">
                            </div>
                        </div>
                    </div>

                    <!-- Card Data (User Information) -->
                    <div class="profile-card">
                        <div class="card">
                            <div class="card-header">
                                <h5 style="color:white;" class="mb-0">Informasi Pengguna</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                                <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
                                <p><strong>Peran:</strong> <?= htmlspecialchars($user['usertype']) ?></p>

                                <!-- Action buttons for Edit -->
                                <div class="action-buttons">
                                    <a href="<?php echo site_url('users/edit1/' . $user['username']); ?>" 
                                       class="btn btn-sm btn-warning" 
                                       id="editBtn<?php echo $user['username']; ?>">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- End Card Wrapper -->

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"></script>

    <script>
    $(document).ready(function() {
        // If there's a flash message (success), show a success alert
        <?php if ($this->session->flashdata('message')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $this->session->flashdata('message'); ?>'
            });
        <?php endif; ?>

        // Add password validation for the form if needed
        $('#passwordChangeForm').on('submit', function(event) {
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();

            // Check if password and confirm password match
            if (password !== confirmPassword) {
                // Show SweetAlert error message
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Password dan Konfirmasi Password tidak cocok.',
                    confirmButtonText: 'OK'
                });
                event.preventDefault(); // Prevent form submission if passwords don't match
            }
        });
    });
</script>


</body>
</html>
<?php endif; ?>
