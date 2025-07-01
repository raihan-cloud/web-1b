<?php
session_start();
include '../config/db.php';

// Cek login siswa
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id']; // Pastikan $_SESSION['id'] di-set saat login

// Ambil semua tugas dari admin
$tugas = mysqli_query($conn, "SELECT * FROM tugas ORDER BY created_at DESC");

// Proses upload tugas siswa
if (isset($_POST['submit'])) {
    $id_tugas = $_POST['id_tugas'];
    $fileName = $_FILES['file']['name'];
    $fileTmp  = $_FILES['file']['tmp_name'];
    $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed  = ['pdf', 'doc', 'docx', 'pptx', 'xlsx', 'zip'];

    if (!in_array($fileExt, $allowed)) {
        $error = "Format file tidak diizinkan.";
    } else {
        $newName = time() . '-' . $fileName;
        move_uploaded_file($fileTmp, "../uploads/" . $newName);

        // Simpan ke database
        $insert = mysqli_query($conn, "INSERT INTO pengumpulan (id_user, id_tugas, file) VALUES ($id_user, $id_tugas, '$newName')");
        if ($insert) {
            $success = "Tugas berhasil dikumpulkan!";
        } else {
            $error = "Gagal menyimpan ke database.";
        }
    }
}

// Ambil tugas yang sudah dikumpulkan siswa
$kumpulan = mysqli_query($conn, "
    SELECT p.*, t.judul 
    FROM pengumpulan p 
    JOIN tugas t ON p.id_tugas = t.id 
    WHERE p.id_user = $id_user 
    ORDER BY p.tanggal_kumpul DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kumpul Tugas - Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-primary px-4">
    <span class="navbar-brand">Kumpul Tugas</span>
    <a href="tugas.php" class="btn btn-outline-light btn-sm">Kembali</a>
</nav>

<div class="container mt-4">
    <h3 class="mb-4">Form Pengumpulan Tugas</h3>

    <?php if (isset($success)) : ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php elseif (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm mb-5">
        <div class="mb-3">
            <label for="id_tugas" class="form-label">Pilih Tugas</label>
            <select name="id_tugas" id="id_tugas" class="form-select" required>
                <option value="">-- Pilih Tugas --</option>
                <?php while ($row = mysqli_fetch_assoc($tugas)) : ?>
                    <option value="<?= $row['id']; ?>"><?= $row['judul']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Upload File</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <small class="text-muted">Format: pdf, doc, pptx, zip (maks 5MB)</small>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Kumpulkan</button>
    </form>

    <h4 class="mb-3">Riwayat Tugas yang Sudah Dikumpulkan</h4>
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th
