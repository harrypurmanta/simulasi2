<?php
$title = 'Review Pembahasan Latihan - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-bold mb-2">
                        <i class="fas fa-search me-1"></i> PEMBAHASAN LATIHAN
                    </span>
                    <h2 class="fw-bold text-dark">Pilih Kategori Pembahasan</h2>
                    <p class="text-muted small">Pilih kategori latihan di bawah ini untuk melihat pembahasan soal</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <?php
                        $this->session = \Config\Services::session();
                        foreach ($group as $key) {
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-hover" style="border-top: 4px solid #0284c7 !important;">
                            <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                                <div class="mb-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background-color: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                        <i class="fas fa-book-reader fa-2x"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-2"><?= esc($key->group_nm) ?></h4>
                                    <p class="text-muted small mb-0">Ulasan pembahasan materi per jenis soal</p>
                                </div>
                                <a href="<?= base_url()."/latihan/pembahasan_latihan_jenis/".$key->group_soal_id ?>" class="btn btn-info text-white w-100 rounded-pill fw-semibold py-2">
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