<?php
$title = 'Sikap Kerja (Kecermatan) - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-2 rounded-pill fw-bold mb-2">
                        <i class="fas fa-stopwatch me-1"></i> SIMULASI TES KECERMATAN
                    </span>
                    <h2 class="fw-bold text-dark">Pilih Jenis Sikap Kerja</h2>
                    <p class="text-muted small">Pilih paket kolom kecermatan di bawah ini untuk memulai tes berbatas waktu</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <?php
                        foreach ($group as $key) {
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-hover" style="border-top: 4px solid #f59e0b !important;">
                            <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                                <div class="mb-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background-color: rgba(245, 158, 11, 0.12); color: #d97706;">
                                        <i class="fas fa-stopwatch-20 fa-2x"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-2"><?= esc($key->sk_group_nm) ?></h4>
                                    <p class="text-muted small mb-0">Simulasi kolom angka / huruf / simbol hilang</p>
                                </div>
                                <a href="<?= base_url('sikapkerja/pilihansk/' . $key->sk_group_id) ?>" class="btn btn-warning text-dark w-100 rounded-pill fw-bold py-2">
                                    Mulai Ujian <i class="fas fa-arrow-right ms-1"></i>
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