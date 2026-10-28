<?php
$request = service('request');
$title = 'Review Jenis Latihan - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="row align-items-center mb-4">
                    <div class="col-md-auto mb-2 mb-md-0">
                        <a href="<?= base_url('pembahasan') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Kategori
                        </a>
                    </div>
                    <div class="col text-md-center">
                        <h2 class="fw-bold mb-1 text-dark">PEMBAHASAN LATIHAN</h2>
                        <p class="text-muted mb-0 small">Pilih jenis soal untuk melihat ulasan pembahasan dan jawaban</p>
                    </div>
                    <div class="col-md-auto d-none d-md-block" style="width: 150px;"></div>
                </div>

                <div class="row g-4 justify-content-center">
                    <?php
                        $this->session = \Config\Services::session();
                        foreach ($jenis as $key) {
                    ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="small-box-latihan h-100 d-flex flex-column justify-content-between">
                            <div class="inner">
                                <h4><?= esc($key->jenis_nm) ?></h4>
                            </div>
                            <a href="<?= base_url()."/latihan/pembahasan_latihan/".$request->getUri()->getSegment(3)."/".$key->jenis_id ?>" class="small-box-footer bg-info text-white">
                                Buka Pembahasan <i class="fas fa-arrow-circle-right ms-1"></i>
                            </a>
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