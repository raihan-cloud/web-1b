<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>2B-TRKJ Portal Kelas Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #4cc9f0;
            --success: #2ec4b6;
            --warning: #ff9f1c;
            --danger: #ef233c;
            --dark: #2b2d42;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark);
            margin: 0 1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: url('https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=2000') no-repeat center center;
            background-size: cover;
            position: relative;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.95), rgba(58, 12, 163, 0.95));
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            position: relative;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            top: 0;
            left: 0;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card:hover::before {
            opacity: 0.05;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 2rem;
            transform: rotate(-5deg);
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(0deg) scale(1.1);
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 6rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-card {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff, #f8f9fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            background: var(--light);
            position: relative;
            overflow: hidden;
        }

        .cta-box {
            background: white;
            padding: 4rem;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            top: -50%;
            left: -50%;
            transform: rotate(45deg);
            opacity: 0.1;
            z-index: 0;
        }

        /* Button Styles */
        .btn-custom {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-custom::after {
            content: '';
            position: absolute;
            width: 0;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn-custom:hover::after {
            width: 100%;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 6rem 0 2rem;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .stats-number {
                font-size: 2rem;
            }

            .cta-box {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">2B-TRKJ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content" data-aos="fade-right">
                <h1>Portal Digital Kelas 2B-TRKJ</h1>
                <p>Tingkatkan pengalaman belajarmu dengan akses materi dan tugas secara digital. Bergabunglah sekarang untuk memulai perjalanan pembelajaranmu!</p>
                <div class="d-flex gap-3">
                    <a href="login.php" class="btn btn-light btn-custom">Masuk</a>
                    <a href="register.php" class="btn btn-outline-light btn-custom">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" data-aos="fade-up">Fitur Unggulan</h2>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="100">Nikmati berbagai fitur yang memudahkan proses pembelajaran</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h4>Akses Digital</h4>
                    <p>Akses materi pembelajaran kapan saja dan di mana saja melalui platform digital kami.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4>Kolaborasi Tim</h4>
                    <p>Berkolaborasi dengan teman sekelas dalam mengerjakan tugas dan projek.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h4>Tracking Progress</h4>
                    <p>Pantau perkembangan belajar dengan mudah melalui dashboard interaktif.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="stats-card">
                    <div class="stats-number">100+</div>
                    <h5>Siswa Aktif</h5>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stats-card">
                    <div class="stats-number">50+</div>
                    <h5>Materi Digital</h5>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stats-card">
                    <div class="stats-number">24/7</div>
                    <h5>Akses Platform</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-box text-center" data-aos="zoom-in">
            <h2 class="mb-4">Siap Untuk Bergabung?</h2>
            <p class="lead mb-4">Daftar sekarang dan mulai perjalanan pembelajaranmu bersama kami!</p>
            <a href="register.php" class="btn btn-primary btn-custom btn-lg">Daftar Sekarang</a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="mb-4">Tentang Kami</h5>
                <p>Portal pembelajaran digital untuk siswa kelas 1B-TRKJ yang memudahkan proses belajar mengajar.</p>
            </div>
            <div class="col-md-4">
                <h5 class="mb-4">Link Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Beranda</a></li>
                    <li><a href="#" class="footer-link">Fitur</a></li>
                    <li><a href="#" class="footer-link">Kontak</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="mb-4">Kontak</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@1btrkj.sch.id</li>
                    <li><i class="bi bi-telephone me-2"></i> (021) 1234567</li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p>&copy; <?= date('Y') ?> Kelas 1B-TRKJ. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

</body>
</html>
