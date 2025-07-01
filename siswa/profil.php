<?php
session_start();
include '../config/db.php';

// Cek login & role
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id'];
$username = $_SESSION['username'];

// Ambil data user
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $id_user"));

// Handle update
$success = $error = '';
if (isset($_POST['update'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $newpass = $_POST['password'];

    if (!empty($nama)) {
        mysqli_query($conn, "UPDATE users SET nama_lengkap='$nama' WHERE id=$id_user");
        $success = "Profil berhasil diperbarui.";
        $user['nama_lengkap'] = $nama;
    }

    if (!empty($newpass)) {
        $hashed = password_hash($newpass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE id=$id_user");
        $success = "Password berhasil diganti.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Siswa | 1B-TRKJ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f2f4f8;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      margin-top: 60px;
      max-width: 600px;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="card p-4">
    <h4 class="mb-3">Profil Saya</h4>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" disabled>
      </div>

      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($user['nama_lengkap'] ?? ''); ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Ganti Password (Opsional)</label>
        <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak diganti">
      </div>

      <div class="d-grid">
        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <a href="tugas.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
