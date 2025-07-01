<?php
include 'config/db.php';

if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Kelas 1B-TRKJ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .register-container {
      margin-top: 80px;
    }

    .card {
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .btn-custom {
      padding: 10px 30px;
      border-radius: 30px;
    }

    .form-label {
      font-weight: 500;
    }
  </style>
</head>
<body>

<div class="container register-container">
  <div class="row justify-content-center">
    <div class="col-md-6" data-aos="zoom-in">
      <div class="card p-4">
        <div class="card-body">
          <h3 class="text-center mb-4">Daftar Akun Baru</h3>

          <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error; ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Daftar Sebagai</label>
              <select name="role" id="role" class="form-select" required>
                <option value="siswa">Siswa</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" name="register" class="btn btn-success btn-custom">Daftar</button>
            </div>
            <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login disini</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
