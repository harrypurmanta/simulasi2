<?php
$title = 'Pembahasan Soal - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container pt-2 pb-4">
                <div class="text-center mb-3">
                    <h2 class="fw-bold text-dark mb-1">Pilih Paket Pembahasan</h2>
                    <p class="text-muted small mb-0">Pelajari kunci jawaban dan penjelasan rinci dari setiap paket soal yang telah diujikan</p>
                </div>

                <div class="row g-3">
                    <?php
                        foreach ($materi as $key) {
                            $group_id = 2;
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-hover bg-white">
                            <div class="card-body p-3 text-center d-flex flex-column justify-content-between">
                                <div class="my-2">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                         style="width: 46px; height: 46px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                                        <i class="fas fa-file-invoice fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0 text-dark">
                                        <?= esc(str_replace("Materi", "Pembahasan", $key->materi_nm)) ?>
                                    </h5>
                                </div>
                                <div class="mt-2">
                                    <a href="<?= base_url('pembahasan/pilihanmateri/' . $key->materi_id . '/' . $group_id) ?>" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                                        Buka Pembahasan <i class="fas fa-arrow-right ms-1"></i>
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