<?php
session_start();
include '../config/db.php';

// Cek apakah user admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Proses form upload
if (isset($_POST['upload'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // Validasi input
    if (empty($judul) || empty($deskripsi) || $_FILES['file']['error'] === 4) {
        $error = "Semua field harus diisi!";
    } else {
        $fileName = $_FILES['file']['name'];
        $fileTmp  = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];

        $uploadDir = "../uploads/";
        $allowed = ['pdf', 'docx', 'doc', 'pptx', 'xlsx', 'zip'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowed)) {
            $error = "Format file tidak diizinkan!";
        } elseif ($fileSize > 5 * 1024 * 1024) {
            $error = "Ukuran file maksimal 5MB!";
        } else {
            $newName = time() . '-' . $fileName;
            move_uploaded_file($fileTmp, $uploadDir . $newName);

            $query = "INSERT INTO tugas (judul, deskripsi, file) VALUES ('$judul', '$deskripsi', '$newName')";
            if (mysqli_query($conn, $query)) {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Gagal menyimpan tugas!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Tugas - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/filepond@4.30.4/dist/filepond.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }
        .navbar { background: linear-gradient(135deg, #4361ee, #3f37c9); padding: 1rem 2rem; }
        .page-header, .upload-form { background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .form-label { font-weight: 500; color: #444; }
        .form-control { border-radius: 8px; }
        .btn-custom { padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; }
        .alert-custom { border-radius: 8px; padding: 1rem; border: none; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</nav>

<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Upload Tugas Baru</h3>
                <p class="text-muted">Tambahkan tugas baru untuk siswa</p>
            </div>
            <div class="col-md-4 text-end text-muted">
                <i class="bi bi-calendar2"></i> <?= date('d F Y'); ?>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="upload-form">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-custom">
                <i class="bi bi-exclamation-circle me-2"></i><?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Tugas</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Tugas</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label for="file" class="form-label">Upload File</label>
                <input type="file" class="filepond" name="file" id="file" required>
                <div class="text-muted mt-2">
                    <small>Format yang diizinkan: PDF, DOC, DOCX, PPTX, XLSX, ZIP (max 5MB)</small>
                </div>
            </div>

            <button type="submit" name="upload" class="btn btn-primary btn-custom">
                <i class="bi bi-cloud-upload"></i> Upload Tugas
            </button>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/filepond@4.30.4/dist/filepond.js"></script>
<script>
    FilePond.create(document.querySelector('input[type="file"]'), {
        labelIdle: `Drag & Drop file atau <span class="filepond--label-action">Browse</span>`,
        acceptedFileTypes: [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/zip'
        ],
        maxFileSize: '5MB'
    });

    // Validasi JS agar aman
    document.querySelector('form').addEventListener('submit', function(e) {
        const judul = document.getElementById('judul').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();
        const file = document.querySelector('input[type="file"]').files[0];

        if (!judul || !deskripsi || !file) {
            e.preventDefault();
            alert('Semua field harus diisi!');
        }
    });
</script>

</body>
</html>
