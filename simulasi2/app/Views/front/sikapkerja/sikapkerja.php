<?php
$title = 'Sikap Kerja (Kecermatan) - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container pt-2 pb-4">
                <div class="text-center mb-3">
                    <h2 class="fw-bold text-dark mb-1">Pilih Jenis Sikap Kerja</h2>
                    <p class="text-muted small mb-0">Pilih paket kolom kecermatan di bawah ini untuk memulai tes berbatas waktu</p>
                </div>

                <div class="row g-3 justify-content-center">
                    <?php
                        foreach ($group as $key) {
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-hover bg-white">
                            <div class="card-body p-3 text-center d-flex flex-column justify-content-between">
                                <div class="my-2">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                         style="width: 46px; height: 46px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                                        <i class="fas fa-stopwatch fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0 text-dark"><?= esc($key->sk_group_nm) ?></h5>
                                </div>
                                <div class="mt-2">
                                    <a href="<?= base_url('sikapkerja/pilihansk/' . $key->sk_group_id) ?>" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                                        Mulai <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
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