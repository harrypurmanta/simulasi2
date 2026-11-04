<?= $this->include('admin/template/head') ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <?= $this->include('admin/navbar') ?>
  <!-- /.navbar -->

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold text-dark d-flex align-items-center">
              <i class="fas fa-tachometer-alt text-primary me-2"></i> Dashboard Admin
            </h1>
            <p class="text-muted small mb-0 mt-1">Sistem Pengelolaan Simulasi Ujian CAT Psikologi Bintang Timur Prestasi</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid px-3 px-lg-4">
        
        <!-- Welcome Hero Banner -->
        <div class="card border-0 rounded-4 overflow-hidden mb-4 text-white shadow-sm" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
          <div class="card-body p-4 p-md-4 position-relative">
            <div class="row align-items-center">
              <div class="col-md-8">
                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">
                  <i class="fas fa-check-circle me-1"></i> Sistem Aktif & Terhubung
                </span>
                <h3 class="fw-bold mb-1">Selamat Datang di Portal Admin BTP</h3>
                <p class="text-white-50 mb-3" style="max-width: 650px;">
                  Kelola paket soal simulasi, bank soal latihan, jadwal token akses peserta, serta rekapitulasi hasil kelulusan siswa secara realtime dan komprehensif.
                </p>
                <div class="d-flex flex-wrap gap-2">
                  <a href="<?= base_url('admin/soal') ?>" class="btn btn-light text-primary fw-bold rounded-pill px-3 py-2 shadow-sm">
                    <i class="fas fa-file-alt me-1"></i> Kelola Soal CAT
                  </a>
                  <a href="<?= base_url('admin/token') ?>" class="btn btn-warning text-dark fw-bold rounded-pill px-3 py-2 shadow-sm">
                    <i class="fas fa-key me-1"></i> Buat / Cek Token
                  </a>
                  <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-light rounded-pill px-3 py-2">
                    <i class="fas fa-users me-1"></i> Data Pengguna
                  </a>
                </div>
              </div>
              <div class="col-md-4 d-none d-md-flex justify-content-end align-items-center pe-4">
                <div class="rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center p-4" style="width: 140px; height: 140px;">
                  <i class="fas fa-shield-alt text-warning" style="font-size: 72px;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-info-gradient text-white rounded-4 h-100">
              <div class="inner">
                <h3>Hasil Ujian</h3>
                <p>Rekapitulasi Nilai Siswa</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line fa-3x"></i>
              </div>
              <a href="<?= base_url('admin/users') ?>" class="small-box-footer text-white text-decoration-none d-block">
                Lihat Data Lengkap <i class="fas fa-arrow-circle-right ms-1"></i>
              </a>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-warning-gradient text-white rounded-4 h-100">
              <div class="inner">
                <h3>Peserta / Users</h3>
                <p>Total Akun Terdaftar</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends fa-3x"></i>
              </div>
              <a href="<?= base_url('admin/users') ?>" class="small-box-footer text-white text-decoration-none d-block">
                Kelola Pengguna <i class="fas fa-arrow-circle-right ms-1"></i>
              </a>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-success-gradient text-white rounded-4 h-100">
              <div class="inner">
                <h3>Kelulusan</h3>
                <p>Peserta Memenuhi Syarat</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-double fa-3x"></i>
              </div>
              <a href="<?= base_url('admin/users') ?>" class="small-box-footer text-white text-decoration-none d-block">
                Status Kelulusan <i class="fas fa-arrow-circle-right ms-1"></i>
              </a>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-danger-gradient text-white rounded-4 h-100">
              <div class="inner">
                <h3>Evaluasi</h3>
                <p>Peserta Perlu Pembinaan</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation-triangle fa-3x"></i>
              </div>
              <a href="<?= base_url('admin/users') ?>" class="small-box-footer text-white text-decoration-none d-block">
                Tinjau Skor Rendah <i class="fas fa-arrow-circle-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Quick Access Navigation Panels -->
        <div class="row g-3">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
              <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                <div>
                  <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                    <i class="fas fa-file-signature fa-2x"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-1">Materi & Soal CAT</h5>
                  <p class="text-muted small mb-0">Kelola paket tes kecerdasan, kepribadian, dan jadwal ujian CAT utama.</p>
                </div>
                <div class="mt-4">
                  <a href="<?= base_url('admin/soal') ?>" class="btn btn-outline-primary rounded-pill w-100 fw-semibold">
                    Buka Modul Soal CAT <i class="fas fa-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
              <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                <div>
                  <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: rgba(217, 119, 6, 0.08); color: #d97706;">
                    <i class="fas fa-stopwatch fa-2x"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-1">Sikap Kerja (Kecermatan)</h5>
                  <p class="text-muted small mb-0">Pengaturan tes kolom angka/huruf hilang dengan timer otomatis.</p>
                </div>
                <div class="mt-4">
                  <a href="<?= base_url('admin/soalsikapkerjamateri') ?>" class="btn btn-outline-warning text-dark rounded-pill w-100 fw-semibold">
                    Buka Sikap Kerja <i class="fas fa-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
              <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                <div>
                  <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: rgba(21, 128, 61, 0.08); color: #15803d;">
                    <i class="fas fa-tasks fa-2x"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-1">Bank Soal Latihan Mandiri</h5>
                  <p class="text-muted small mb-0">Kelola jenis soal latihan bertingkat (level) untuk persiapan siswa.</p>
                </div>
                <div class="mt-4">
                  <a href="<?= base_url('admin/soallatihan') ?>" class="btn btn-outline-success rounded-pill w-100 fw-semibold">
                    Buka Soal Latihan <i class="fas fa-arrow-right ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

<?= $this->include('admin/template/scriptjs') ?>
</body>
</html>
