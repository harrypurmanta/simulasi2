<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Siswa - Bintang Timur Prestasi</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/bootstrap.min.css">
    <!-- AdminLTE v4 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/adminlte.min.css">

    <style>
        :root {
            --btp-primary: #1e3c72;
            --btp-secondary: #2a5298;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #0f172a;
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), url("<?= base_url() ?>/images/bg/bg-body.jpg");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            overflow-x: hidden;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
        }

        /* Image Showcase Card */
        .image-showcase-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .image-showcase-card img {
            width: 100%;
            height: auto;
            max-height: calc(85vh - 40px);
            object-fit: contain;
            border-radius: 16px;
        }

        /* Login Card */
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            padding: 36px 32px;
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 15px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .input-group-text {
            border-radius: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }

        .btn-submit {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.3px;
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(30, 60, 114, 0.3);
            transition: all 0.25s ease;
        }

        .btn-submit:hover {
            opacity: 0.93;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(30, 60, 114, 0.4);
            color: #ffffff;
        }

        .btn-register {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 14px;
            border: 1.5px solid #cbd5e1;
            color: #334155;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .btn-register:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }

        @media (max-width: 991.98px) {
            .main-container {
                padding: 30px 15px;
            }
            .image-showcase-card {
                padding: 12px;
                margin-bottom: 20px;
                border-radius: 20px;
            }
            .image-showcase-card img {
                max-height: 50vh;
            }
            .login-card {
                padding: 30px 24px;
                border-radius: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="container-fluid px-lg-5" style="max-width: 1480px;">
            <div class="row g-4 align-items-center justify-content-center">
                <!-- Kolom 1: Gambar Banner Terpisah (Besar, Jelas, & Terbaca) -->
                <div class="col-12 col-lg-7 col-xl-7">
                    <div class="image-showcase-card">
                        <img src="<?= base_url() ?>/images/bg/btp5.png" alt="Bintang Timur Prestasi - Simulasi Psikologi" class="img-fluid">
                    </div>
                </div>

                <!-- Kolom 2: Form Login Terpisah (Fit, Bersih, & Responsif) -->
                <div class="col-12 col-md-9 col-lg-5 col-xl-4">
                    <div class="login-card">
                        <div class="text-center mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2">
                                <i class="fas fa-graduation-cap me-1"></i> PORTAL SISWA
                            </span>
                            <h3 class="fw-bold text-dark mb-1">Masuk Akun</h3>
                            <p class="text-muted small mb-0">Silakan login untuk mengikuti simulasi CAT</p>
                        </div>

                        <form action="<?= base_url() ?>/login/checklogin" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold text-secondary small">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" id="username" class="form-control border-start-0" name="username" placeholder="Masukkan username Anda" required autofocus autocomplete="off">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="password" class="form-control border-start-0 border-end-0" name="password" placeholder="Masukkan password" required>
                                    <button class="btn btn-outline-light border border-start-0 text-muted" type="button" id="togglePassword" style="border-color: #e2e8f0 !important; background-color: #f8fafc;">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-sign-in-alt me-1"></i> Masuk Ujian
                                </button>
                                <a href="<?= base_url() ?>/login/register" class="btn btn-register text-center text-decoration-none">
                                    <i class="fas fa-user-plus me-1"></i> Pendaftaran Siswa Baru
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                <small class="text-muted">Bintang Timur Prestasi &copy; <?= date('Y') ?></small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passwordInput && eyeIcon) {
            toggleBtn.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>
