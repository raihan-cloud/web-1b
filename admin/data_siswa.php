<?php
session_start();
include '../config/db.php';

// Cek login & role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil data semua siswa
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'siswa' ORDER BY id DESC");
$totalSiswa = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - Admin | 1B-TRKJ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #2ec4b6;
            --info: #4cc9f0;
            --warning: #ff9f1c;
            --danger: #ef233c;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* Header Styles */
        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 500;
            border: none;
            padding: 1rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
        }

        /* Custom Buttons */
        .btn-custom {
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
        }

        /* Search Box */
        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box input {
            padding: 1rem 1.5rem;
            padding-left: 3rem;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.1);
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
                border-radius: 0;
                margin: -1rem -1rem 2rem -1rem;
            }
        }
    </style>
</head>
<body>

<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header" data-aos="fade-down">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-1">Data Siswa</h2>
                <p class="mb-0">Kelola data siswa kelas 1B-TRKJ</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="dashboard.php" class="btn btn-light btn-custom">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3><?= $totalSiswa ?></h3>
                <p class="text-muted mb-0">Total Siswa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <h3><?= date('Y') ?></h3>
                <p class="text-muted mb-0">Angkatan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h3>Active</h3>
                <p class="text-muted mb-0">Status Kelas</p>
            </div>
        </div>
    </div>

    <!-- Search & Actions -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari siswa...">
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <button class="btn btn-primary btn-custom" onclick="exportToExcel()">
                <i class="bi bi-download"></i> Export Data
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table" id="siswaTable">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Username</th>
                        <th width="35%">Nama Lengkap</th>
                        <th width="20%">Status</th>
                        <th width="15%">Tanggal Daftar</th>
                    </tr>
                </thead>
              <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php $no = 1; while ($siswa = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2">
                            <?= strtoupper(substr($siswa['username'], 0, 1)); ?>
                        </div>
                        <?= htmlspecialchars($siswa['username']); ?>
                    </div>
                </td>
                <td><?= isset($siswa['nama_lengkap']) ? htmlspecialchars($siswa['nama_lengkap']) : '-'; ?></td>
                <td>
                    <span class="status-badge bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i> Aktif
                    </span>
                </td>
                <td>
                    <i class="bi bi-calendar2"></i>
                    <?= isset($siswa['created_at']) ? date('d M Y', strtotime($siswa['created_at'])) : '-'; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">
                <div class="text-center py-4">
                    <i class="bi bi-people display-4 text-muted"></i>
                    <p class="mt-2 mb-0">Belum ada siswa terdaftar</p>
                </div>
            </td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchText = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchText) ? '' : 'none';
    });
});

// Export to Excel function
function exportToExcel() {
    const table = document.getElementById('siswaTable');
    const html = table.outerHTML;
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const link = document.createElement('a');
    link.download = 'data_siswa.xls';
    link.href = url;
    link.click();
}
</script>

</body>
</html>