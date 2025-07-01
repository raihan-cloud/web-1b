<?php
session_start();
include '../config/db.php';

// Cek login dan role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil data pengumpulan tugas (join dengan users dan tugas)
$result = mysqli_query($conn, "
    SELECT 
        p.id,
        u.username AS nama_siswa,
        t.judul AS nama_tugas,
        p.file,
        p.tanggal_kumpul
    FROM pengumpulan p
    JOIN users u ON p.id_user = u.id
    JOIN tugas t ON p.id_tugas = t.id
    ORDER BY p.tanggal_kumpul DESC
");

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pengumpulan Tugas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">📥 Laporan Pengumpulan Tugas</h3>

  <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Kembali ke Dashboard</a>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nama Siswa</th>
          <th>Tugas</th>
          <th>File</th>
          <th>Waktu Kumpul</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama']); ?> (<?= $row['username']; ?>)</td>
              <td><?= htmlspecialchars($row['judul']); ?></td>
              <td>
                <a href="../uploads/<?= htmlspecialchars($row['nama_file']); ?>" target="_blank">
                  <?= $row['nama_file']; ?>
                </a>
              </td>
              <td><?= date('d M Y H:i', strtotime($row['tanggal_kumpul'])); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" class="text-center text-muted">Belum ada pengumpulan tugas</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
