<?php
session_start();
include '../config/db.php';

// Cek login dan role admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil data berdasarkan ID
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$tugas = mysqli_query($conn, "SELECT * FROM tugas WHERE id = $id");
$data = mysqli_fetch_assoc($tugas);

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $fileBaru = $_FILES['file']['name'];
    $fileTmp  = $_FILES['file']['tmp_name'];
    $allowed  = ['pdf', 'docx', 'doc', 'pptx', 'xlsx', 'zip'];

    // Jika user upload file baru
    if (!empty($fileBaru)) {
        $fileExt = strtolower(pathinfo($fileBaru, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowed)) {
            $error = "Format file tidak diizinkan!";
        } else {
            $newName = time() . '-' . $fileBaru;
            $uploadPath = "../uploads/" . $newName;

            // Hapus file lama
            if (file_exists("../uploads/" . $data['file'])) {
                unlink("../uploads/" . $data['file']);
            }

            // Pindahkan file baru
            move_uploaded_file($fileTmp, $uploadPath);

            // Update semua data termasuk file
            $query = "UPDATE tugas SET judul='$judul', deskripsi='$deskripsi', file='$newName' WHERE id=$id";
        }
    } else {
        // Update tanpa ubah file
        $query = "UPDATE tugas SET judul='$judul', deskripsi='$deskripsi' WHERE id=$id";
    }

    // Jalankan query
    if (isset($query) && mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal menyimpan perubahan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Edit Tugas</h3>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= $data['judul']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required><?= $data['deskripsi']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">File Saat Ini:</label><br>
            <a href="../uploads/<?= $data['file']; ?>" target="_blank"><?= $data['file']; ?></a>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Ganti File (opsional)</label>
            <input type="file" name="file" class="form-control">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>
