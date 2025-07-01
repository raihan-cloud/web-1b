<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Inisialisasi variabel notifikasi
$success = '';
$error = '';

// Proses submit form
if (isset($_POST['submit'])) {
    $username = strtolower(trim($_POST['username']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validasi username panjang minimal
    if (strlen($username) < 5) {
        $error = "Username harus minimal 5 karakter!";
    } elseif ($password !== $confirm) {
        $error = "Password dan konfirmasi tidak cocok!";
    } else {
        // Cek apakah username sudah digunakan
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Enkripsi password dan masukkan ke database
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'siswa')");

            if ($insert) {
                $success = "Siswa berhasil ditambahkan!";
            } else {
                $error = "Gagal menambahkan siswa: " . mysqli_error($conn);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
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

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .form-header::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            top: -50%;
            left: -50%;
        }

        .form-body {
            padding: 2rem;
        }

        /* Form Controls */
        .form-control {
            border-radius: 10px;
            padding: 0.8rem 1rem;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }

        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 0.5rem;
        }

        /* Custom Buttons */
        .btn-custom {
            padding: 0.8rem 2rem;
            border-radius: 10px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
        }

        /* Password Strength */
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
        }

        /* Alert Styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: rgba(46, 196, 182, 0.1);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 35, 60, 0.1);
            color: var(--danger);
        }

        /* Animations */
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease forwards;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Page Header -->
    <div class="page-header animate-slide-up">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-1">Tambah Siswa Baru</h2>
                <p class="mb-0">Tambahkan akun siswa baru ke sistem</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="data_siswa.php" class="btn btn-light btn-custom">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card animate-slide-up">
        <div class="form-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="bg-white rounded-circle p-3">
                        <i class="bi bi-person-plus-fill text-primary fs-4"></i>
                    </div>
                </div>
                <div class="col">
                    <h4 class="mb-1">Form Pendaftaran Siswa</h4>
                    <p class="mb-0">Isi semua field dengan benar</p>
                </div>
            </div>
        </div>

        <div class="form-body">
            <?php if ($success): ?>
                <div class="alert alert-success d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= $success; ?>
                </div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="addStudentForm">
                <div class="mb-4">
                    <label for="username" class="form-label">
                        <i class="bi bi-person me-2"></i>Username Siswa
                    </label>
                    <input type="text" 
                           name="username" 
                           id="username" 
                           class="form-control" 
                           required 
                           autofocus
                           placeholder="Masukkan username">
                    <small class="text-muted">Username harus unik dan minimal 5 karakter</small>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-2"></i>Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control" 
                               required
                               placeholder="Masukkan password">
                        <button type="button" 
                                class="btn btn-outline-secondary" 
                                onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="mb-4">
                    <label for="confirm" class="form-label">
                        <i class="bi bi-shield-lock me-2"></i>Konfirmasi Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               name="confirm" 
                               id="confirm" 
                               class="form-control" 
                               required
                               placeholder="Konfirmasi password">
                        <button type="button" 
                                class="btn btn-outline-secondary" 
                                onclick="togglePassword('confirm')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" name="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-person-plus"></i> Tambah Siswa
                    </button>
                    <a href="data_siswa.php" class="btn btn-light btn-custom">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
    
    const icon = event.currentTarget.querySelector('i');
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
}

// Password Strength Checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = document.getElementById('passwordStrength');
    
    // Reset
    strength.style.width = '0%';
    
    if (password.length === 0) {
        strength.style.background = '#e0e0e0';
        return;
    }
    
    let strengthValue = 0;
    
    // Add strength for length
    if (password.length >= 8) strengthValue += 25;
    
    // Add strength for numbers
    if (/\d/.test(password)) strengthValue += 25;
    
    // Add strength for special characters
    if (/[!@#$%^&*]/.test(password)) strengthValue += 25;
    
    // Add strength for mixed case
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strengthValue += 25;
    
    // Update strength indicator
    strength.style.width = strengthValue + '%';
    
    if (strengthValue <= 25) {
        strength.style.background = '#ef233c';
    } else if (strengthValue <= 50) {
        strength.style.background = '#ff9f1c';
    } else if (strengthValue <= 75) {
        strength.style.background = '#4361ee';
    } else {
        strength.style.background = '#2ec4b6';
    }
});

// Form Validation
document.getElementById('addStudentForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm').value;
    
    if (username.length < 5) {
        e.preventDefault();
        alert('Username harus minimal 5 karakter!');
        return;
    }
    
    if (password !== confirm) {
        e.preventDefault();
        alert('Password dan konfirmasi tidak cocok!');
        return;
    }
});
</script>

</body>
</html>