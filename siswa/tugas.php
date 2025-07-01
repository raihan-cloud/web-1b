<?php
session_start();
include '../config/db.php';

// Cek login dan role siswa
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$inisial  = strtoupper(substr($username, 0, 1));

// Ambil semua tugas dari admin
$tugas = mysqli_query($conn, "SELECT * FROM tugas ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Tugas Siswa | 1B-TRKJ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #2ec4b6;
            --light: #f8f9fa;
            --dark: #1b1b1b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 1rem 2rem;
            color: white;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: white;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        .dashboard-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .task-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 500;
        }

        .btn-download {
            background: var(--success);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
        }

        .btn-download:hover {
            background: #25a898;
        }

        .btn-kumpul {
            background: var(--primary);
            color: white;
            border-radius: 8px;
            padding: 6px 16px;
        }

        .btn-kumpul:hover {
            background: var(--secondary);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <div class="avatar"><?= $inisial; ?></div>
        <strong>Halo, <?= $username; ?></strong>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="profil.php" class="btn btn-outline-light">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
        <a href="kumpul.php" class="btn btn-kumpul">
            <i class="bi bi-upload"></i> Kumpul Tugas
        </a>
        <a href="../logout.php" class="btn btn-light text-dark">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</nav>


<!-- Content -->
<div class="container my-4">
    <div class="dashboard-header" data-aos="fade-up">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h3 class="mb-1">Portal Tugas Siswa</h3>
                <p class="text-muted mb-0">Lihat & unduh semua tugas dari admin</p>
            </div>
            <div>
                <i class="bi bi-calendar3"></i> <?= date('d F Y'); ?>
            </div>
        </div>
    </div>

    <div class="task-card" data-aos="fade-up" data-aos-delay="100">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Tugas</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($tugas) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($tugas)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($row['judul']); ?></strong></td>
                            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                            <td>
                                <a href="../uploads/<?= htmlspecialchars($row['file']); ?>" 
                                   class="btn btn-download btn-sm" 
                                   target="_blank">
                                   <i class="bi bi-download"></i> Download
                                </a>
                            </td>
                            <td>
                                <?= !empty($row['created_at']) 
                                    ? date('d M Y - H:i', strtotime($row['created_at'])) 
                                    : 'Tidak ada'; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>Belum Ada Tugas</h5>
                                    <p>Tugas dari admin akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>

</body>
</html>
