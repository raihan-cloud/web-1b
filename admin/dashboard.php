<?php
session_start();
include '../config/db.php';

// Cek login admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil statistik
$totalTugas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tugas"));
$totalSiswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='siswa'"));
$tugasHariIni = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tugas WHERE DATE(created_at) = CURDATE()"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | 1B-TRKJ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #2ec4b6;
            --info: #4cc9f0;
        }

        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .top-nav {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 1rem;
            color: white;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .activity-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            padding: 1rem;
            border-left: 3px solid var(--primary);
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>

<!-- Top Navigation -->
<div class="top-nav mb-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📊 Admin Dashboard</h4>
            <div class="d-flex align-items-center gap-3">
                <a href="upload.php" class="btn btn-light">
                    <i class="bi bi-cloud-upload"></i> Upload
                </a>
                <a href="data_siswa.php" class="btn btn-light">
                    <i class="bi bi-people"></i> Siswa
                </a>
                <a href="../logout.php" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <h2>Selamat Datang, <?= $_SESSION['username'] ?>! 👋</h2>
        <p class="mb-0">Panel admin untuk mengelola tugas dan data siswa kelas 1B-TRKJ</p>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-file-text"></i>
                </div>
                <h3><?= $totalTugas ?></h3>
                <p class="text-muted mb-0">Total Tugas</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-people"></i>
                </div>
                <h3><?= $totalSiswa ?></h3>
                <p class="text-muted mb-0">Total Siswa</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h3><?= $tugasHariIni ?></h3>
                <p class="text-muted mb-0">Tugas Hari Ini</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h3>24/7</h3>
                <p class="text-muted mb-0">Sistem Aktif</p>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-md-8">
            <h5 class="mb-3">Tugas Terbaru</h5>
            <div class="activity-card">
                <?php
                $recentTugas = mysqli_query($conn, "SELECT * FROM tugas ORDER BY created_at DESC LIMIT 5");
                while($row = mysqli_fetch_assoc($recentTugas)):
                ?>
                <div class="activity-item">
                    <h6><?= htmlspecialchars($row['judul']) ?></h6>
                    <p class="text-muted mb-1"><?= htmlspecialchars($row['deskripsi']) ?></p>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> 
                        <?= date('d M Y H:i', strtotime($row['created_at'])) ?>
                    </small>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="col-md-4">
            <h5 class="mb-3">Quick Actions</h5>
            <div class="dashboard-card">
                <div class="d-grid gap-2">
                    <a href="upload.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-cloud-upload"></i> Upload Tugas Baru
                    </a>
                    <a href="tambahsiswa.php" class="btn btn-info btn-lg text-white">
                        <i class="bi bi-person-plus"></i> Tambah Siswa
                    </a>
                    <a href="laporan_kumpul.php" class="btn btn-success btn-lg">
                        <i class="bi bi-file-earmark-text"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>