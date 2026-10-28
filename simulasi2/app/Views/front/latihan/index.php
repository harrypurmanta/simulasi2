<?php
$title = 'Kategori Latihan Soal - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2">
                        <i class="fas fa-tasks me-1"></i> MODUL LATIHAN MANDIRI
                    </span>
                    <h2 class="fw-bold text-dark">Pilih Kategori Latihan</h2>
                    <p class="text-muted small">Pilih salah satu kategori di bawah ini untuk memulai latihan bertahap</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <?php
                        $this->session = \Config\Services::session();
                        $colors = ['#1e3c72', '#0d9488', '#d97706', '#4f46e5'];
                        $icons = ['fa-hand-paper', 'fa-brain', 'fa-user-check', 'fa-book'];
                        $i = 0;
                        foreach ($group as $key) {
                            $currentColor = $colors[$i % count($colors)];
                            $currentIcon = $icons[$i % count($icons)];
                            $i++;
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-hover" style="border-top: 4px solid <?= $currentColor ?> !important;">
                            <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                                <div class="mb-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background-color: rgba(30, 60, 114, 0.08); color: <?= $currentColor ?>;">
                                        <i class="fas <?= $currentIcon ?> fa-2x"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-2"><?= esc($key->group_nm) ?></h4>
                                    <p class="text-muted small mb-0">Latihan materi soal terarah sesuai bidang seleksi</p>
                                </div>
                                <a href="<?= base_url('latihan/jenis/' . $key->group_soal_id) ?>" class="btn w-100 rounded-pill text-white fw-semibold py-2" style="background: <?= $currentColor ?>;">
                                    Pilih Jenis Soal <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>
</body>
</html>