<?php
$request = service('request');
$title = 'Hasil Latihan - Bintang Timur Prestasi';
$total = ($benar ?? 0) + ($salah ?? 0);
$persen = $total > 0 ? round((($benar ?? 0) / $total) * 100, 1) : 0;
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper min-vh-100 d-flex flex-column">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper flex-grow-1 d-flex align-items-center justify-content-center py-2" style="background-color: #f4f6f9;">
            <div class="container px-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center">
                            <div class="card-header text-white py-2 px-3" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <h4 class="fw-bold mb-0">SKOR LATIHAN ANDA</h4>
                            </div>
                            <div class="card-body p-3 bg-white">
                                <div class="mb-2">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 border border-3 border-primary shadow-xs" style="width: 76px; height: 76px; background-color: rgba(30, 60, 114, 0.05);">
                                        <div>
                                            <span class="fs-3 fw-bold text-primary d-block lh-1"><?= $persen ?>%</span>
                                            <small class="text-muted" style="font-size: 10px;">Akurasi</small>
                                        </div>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-0">Hasil Pengerjaan</h5>
                                    <p class="text-muted small mb-0" style="font-size: 12px;">Total soal dikerjakan: <strong><?= $total ?></strong> butir</p>
                                </div>

                                <div class="row g-2 my-2">
                                    <div class="col-6">
                                        <div class="p-2 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                                            <div class="fw-bold text-success mb-0" style="font-size: 13px;">
                                                <i class="fas fa-check-circle me-1"></i> Benar
                                            </div>
                                            <div class="fs-3 fw-bold text-success lh-1 mt-1"><?= $benar ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3">
                                            <div class="fw-bold text-danger mb-0" style="font-size: 13px;">
                                                <i class="fas fa-times-circle me-1"></i> Salah
                                            </div>
                                            <div class="fs-3 fw-bold text-danger lh-1 mt-1"><?= $salah ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="<?= base_url('latihan') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1 btn-sm fw-semibold">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Menu Latihan
                                    </a>
                                    <a href="<?= base_url('latihan/pembahasan_latihan/' . $request->getUri()->getSegment(3) . '/' . $request->getUri()->getSegment(4)) ?>" class="btn btn-primary rounded-pill px-4 py-1 btn-sm fw-bold shadow-sm">
                                        Lihat Pembahasan <i class="fas fa-arrow-circle-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>
</body>
</html>
