<?php
session_start();
include '../config/db.php';

// Cek login dan role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Pastikan ada parameter ID
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

// Ambil nama file dari database
$get = mysqli_query($conn, "SELECT file FROM tugas WHERE id = $id");
$data = mysqli_fetch_assoc($get);

if ($data) {
    $file = $data['file'];
    $filePath = "../uploads/" . $file;

    // Hapus file dari folder
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM tugas WHERE id = $id");
}

// Redirect kembali ke dashboard
header("Location: dashboard.php");
exit;
