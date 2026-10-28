<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("<?= base_url() ?>/images/bg/bg-body.jpg");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 20px;
        }

        .login-card-container {
            width: 100%;
            max-width: 960px;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .image-column {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .image-column img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
        }

        .form-column {
            padding: 45px 35px;
        }
    </style>
</head>

<body>
    <div class="login-card-container">
        <div class="row g-0 align-items-stretch">
            <div class="col-lg-6 image-column d-none d-lg-flex">
                <img src="<?= base_url() ?>/images/bg/btp5.png" alt="Bintang Timur Prestasi" class="img-fluid">
            </div>

            <div class="col-lg-6 form-column d-flex flex-column justify-content-center">
                <div class="text-center mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2">PORTAL SISWA</span>
                    <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                    <p class="text-muted small">Silakan login untuk mengakses simulasi CAT</p>
                </div>

                <form action="<?= base_url() ?>/login/checklogin" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold text-secondary small">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" id="username" class="form-control form-control-lg border-start-0 bg-light" name="username" placeholder="Masukkan username" required autofocus autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" class="form-control form-control-lg border-start-0 bg-light" name="password" placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-2 shadow-sm">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk Ujian
                        </button>
                        <a href="<?= base_url() ?>/login/register" class="btn btn-outline-secondary rounded-pill py-2">
                            Pendaftaran Siswa Baru
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">Bintang Timur Prestasi &copy; <?= date('Y') ?></small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
</body>
</html>
