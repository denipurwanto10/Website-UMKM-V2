<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data UMKM - Ditolak</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo.css'); ?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        .status-disetujui {
            background-color: rgba(255, 0, 0, 0.3);
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
            padding-bottom: 1rem;
        }

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
</head>
<body>
<?php if ($this->session->userdata('user') && $this->session->userdata('user')['usertype'] !== 'Admin'): ?>
    <script type="text/javascript">
        alert('Access Denied: You do not have permission to access this page.');
        window.location.href = '<?php echo site_url('dashboard'); ?>'; // Redirect to another page (e.g., dashboard)
    </script>
<?php else: ?>

<?php include('sidebar.php'); ?>

<div class="container mt-3">
   <!-- Menampilkan pesan error jika tidak ada data -->
   <?php if ($this->session->flashdata('message')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '<?php echo $this->session->flashdata('message'); ?>',
            });
        </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: '<?php echo $this->session->flashdata('error'); ?>',
            });
        </script>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 style="color:white;" class="mb-0">UMKM Ditolak</h5>
        </div>
        <div class="card-body">
            <!-- Entry Selector and Search Input -->
            <div class="entries-search-row">
                <div class="entries-selector">
                    <label for="entriesPerPage">Tampilkan</label>
                    <select id="entriesPerPage" class="form-control">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label>entri</label>
                </div>
                <div class="search-container">
                    <label for="searchInput">Cari:</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="">
                </div>
            </div>
            
            <?php if (isset($umkm) && is_array($umkm) && count($umkm) > 0): ?>
                <div class="table-container">
                    <table class="table table-bordered table-hover" id="umkmTable">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align:center; color:white;" rowspan="3">Photo</th>
                                <th style="text-align:center; color:white;" rowspan="3" class="sortable" data-sort="fullname">Nama Pemilik</th>
                                <th style="text-align:center; color:white;" rowspan="3" class="sortable" data-sort="nama_usaha">Nama Usaha</th>
                                <th style="text-align:center; color:white;" rowspan="3" class="sortable" data-sort="nama_merek_produk">Merek</th>
                                <th style="text-align:center; color:white;" rowspan="3" class="sortable" data-sort="kategori_produk">Kategori</th>
                                 <th style="text-align:center; color:white;" rowspan="2">Jenis Usaha</th> <!-- Alamat sub-column -->
          <th style="text-align:center; color:white;" rowspan="2">Pendapatan</th> <!-- Alamat sub-column -->
                                <th style="text-align:center; color:white;" colspan="3">Alamat</th>
                                <th style="text-align:center; color:white;" colspan="6">Perijinan</th>
                                <th style="text-align:center; color:white;" rowspan="3" class="sortable" data-sort="status">Status</th>
                                <th style="text-align:center; color:white;" rowspan="3">Catatan</th>
                                <th style="text-align:center; color:white;" rowspan="3">Aksi</th>
                            </tr>
                            <tr>
                                <th style="text-align:center; color:white;" rowspan="2">Jalan</th>
                                <th style="text-align:center; color:white;" rowspan="2">Kecamatan</th>
                                <th style="text-align:center; color:white;" rowspan="2">Desa</th>
                                <th style="text-align:center; color:white;" rowspan="3">NIB</th>
                                <th style="text-align:center; color:white;" rowspan="2">PIRT</th>
                                <th style="text-align:center; color:white;" rowspan="2">BPOM</th>
                                <th style="text-align:center; color:white;" rowspan="2">Halal</th>
                                <th style="text-align:center; color:white;" rowspan="2">HAKI</th>
                                <th style="text-align:center; color:white;" rowspan="2">Lainnya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($umkm as $user): ?>
                                <tr>
                                    <td>
                                        <?php if (isset($user['photo']) && !empty($user['photo'])): ?>
                                            <img src="<?php echo base_url('uploads/umkm/' . $user['photo']); ?>" alt="User Photo" style="width:50px; height:50px; object-fit:cover; border-radius: 50%;">
                                        <?php else: ?>
                                            <img src="<?php echo base_url('uploads/umkm/default.png'); ?>" alt="Default Photo" style="width:50px; height:50px; object-fit:cover; border-radius: 50%;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['fullname'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['nama_usaha'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['nama_merek_produk'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['kategori_produk'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['jenis_usaha'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['pendapatan'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['jalan'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['kecamatan'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['desa_kelurahan'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['nib'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['pirt'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['bpom'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['halal'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['haki'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($user['lainnya'] ?? '-'); ?></td>
                                    <td class="status-disetujui">
                                        <span class="badge bg-label-danger">
                                            <?php echo htmlspecialchars($user['status'] ?? '-'); ?>
                                        </span>
                                    </td>
                                    <td style="text-align: center; width: 150px; padding-left: 10px; padding-right: 10px;"><?php echo htmlspecialchars($user['catatan'] ?? '-'); ?></td>
                                    <td>
                                        <div class="action-buttons" style="display: flex; gap: 10px;">
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="<?= $user['id']; ?>">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Info and Controls -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="pagination-info">
                            <span id="showing-entries">Menampilkan 1 sampai <?php echo min(5, count($umkm)); ?> dari <?php echo count($umkm); ?> entri</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation">
                            <ul class="pagination custom-pagination justify-content-end" id="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#" id="prev-page">Sebelumnya</a></li>
                                <?php 
                                $totalPages = ceil(count($umkm) / 5);
                                for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo ($i === 1) ? 'active' : ''; ?>">
                                        <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo ($totalPages <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="#" id="next-page">Berikutnya</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center" role="alert">
                    Tidak ada data UMKM dengan status ditolak untuk ditampilkan.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // SweetAlert for Deletion confirmation
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault(); // Prevent default action
            var userId = $(this).data('id'); // Get UMKM ID

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus dari daftar UMKM Ditolak!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= site_url('umkm/ditolak/delete/'); ?>' + userId;
                }
            });
        });

        // Table functionality with search, pagination, sorting
        $(document).ready(function() {
            var $rows = $('#umkmTable tbody tr');
            var totalRows = $rows.length;
            var rowsPerPage = 5; // Default value
            var currentPage = 1;
            var currentSort = { column: '', direction: '' };
            
            // Initialize table on page load
            updateTable();
            
            // Function to update the table based on search, pagination, and sorting
            function updateTable() {
                // Apply search filter
                var query = $('#searchInput').val().toLowerCase();
                var $filteredRows = $rows.filter(function() {
                    var rowText = $(this).text().toLowerCase();
                    return rowText.indexOf(query) > -1;
                });
                
                // Apply sorting if active
                if (currentSort.column && currentSort.direction) {
                    $filteredRows = sortRows($filteredRows);
                }
                
                var totalFilteredRows = $filteredRows.length;
                var totalPages = Math.max(1, Math.ceil(totalFilteredRows / rowsPerPage));
                
                // Ensure current page is valid
                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }
                
                // Hide all rows
                $rows.hide();
                
                // Show only rows for current page that match the search
                $filteredRows.each(function(index) {
                    if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                        $(this).show();
                    }
                });
                
                // Update pagination
                updatePagination(totalPages, totalFilteredRows);
            }
            
            // Function to sort rows
            function sortRows($filteredRows) {
                var column = currentSort.column;
                var direction = currentSort.direction;
                
                var sortedRows = $filteredRows.toArray().sort(function(a, b) {
                    var aValue = $(a).find('td').eq(getColumnIndex(column)).text().trim();
                    var bValue = $(b).find('td').eq(getColumnIndex(column)).text().trim();
                    
                    // Check if values are numbers
                    var aNum = parseFloat(aValue);
                    var bNum = parseFloat(bValue);
                    
                    if (!isNaN(aNum) && !isNaN(bNum)) {
                        return direction === 'asc' ? aNum - bNum : bNum - aNum;
                    }
                    
                    // Default string comparison
                    if (direction === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                });
                
                return $(sortedRows);
            }
            
            // Function to get column index based on data-sort attribute
            function getColumnIndex(columnName) {
                var index = 0;
                $('#umkmTable thead th').each(function(i) {
                    if ($(this).data('sort') === columnName) {
                        index = i;
                        return false;
                    }
                });
                return index;
            }
            
            // Function to update pagination controls
            function updatePagination(totalPages, totalFilteredRows) {
                var $pagination = $('#pagination');
                $pagination.empty();
                
                // Previous button
                $pagination.append('<li class="page-item' + (currentPage === 1 ? ' disabled' : '') + '"><a class="page-link" href="#" id="prev-page">Sebelumnya</a></li>');
                
                // Page numbers
                for (var i = 1; i <= totalPages; i++) {
                    $pagination.append('<li class="page-item' + (i === currentPage ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
                }
                
                // Next button
                $pagination.append('<li class="page-item' + (currentPage === totalPages ? ' disabled' : '') + '"><a class="page-link" href="#" id="next-page">Berikutnya</a></li>');
                
                // Update showing entries text
                var start = totalFilteredRows === 0 ? 0 : ((currentPage - 1) * rowsPerPage) + 1;
                var end = Math.min(start + rowsPerPage - 1, totalFilteredRows);
                $('#showing-entries').text('Menampilkan ' + start + ' sampai ' + end + ' dari ' + totalFilteredRows + ' entri');
            }
            
            // Handle search input
            $('#searchInput').on('keyup', function() {
                currentPage = 1; // Reset to first page on search
                updateTable();
            });
            
            // Handle entries per page change
            $('#entriesPerPage').on('change', function() {
                rowsPerPage = parseInt($(this).val());
                currentPage = 1; // Reset to first page when changing entries per page
                updateTable();
            });
            
            // Handle pagination clicks
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                
                if ($(this).attr('id') === 'prev-page') {
                    if (currentPage > 1) currentPage--;
                } else if ($(this).attr('id') === 'next-page') {
                    var query = $('#searchInput').val().toLowerCase();
                    var $filteredRows = $rows.filter(function() {
                        var rowText = $(this).text().toLowerCase();
                        return rowText.indexOf(query) > -1;
                    });
                    var totalPages = Math.ceil($filteredRows.length / rowsPerPage);
                    
                    if (currentPage < totalPages) currentPage++;
                } else {
                    currentPage = parseInt($(this).data('page'));
                }
                
                updateTable();
            });
            
            // Handle column sorting
            $(document).on('click', 'th.sortable', function() {
                var column = $(this).data('sort');
                
                // Update sort direction
                if (currentSort.column === column) {
                    // Toggle direction if same column clicked
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    // Default to ascending for new column
                    currentSort.column = column;
                    currentSort.direction = 'asc';
                }
                
                // Update visual indicators
                $('th.sortable').removeClass('asc desc');
                $(this).addClass(currentSort.direction);
                
                updateTable();
            });
        });
    </script>
</div>
</body>
</html>
<?php endif; ?>