<?php
$request = \Config\Services::request();
$title = 'Hasil Latihan - Bintang Timur Prestasi';
$total = ($benar ?? 0) + ($salah ?? 0);
$persen = $total > 0 ? round((($benar ?? 0) / $total) * 100, 1) : 0;
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center">
                            <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">HASIL LATIHAN</span>
                                <h3 class="fw-bold mb-0">Selamat! Latihan Selesai</h3>
                            </div>
                            <div class="card-body p-4 p-md-5 bg-white">
                                <div class="mb-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 border border-4 border-primary" style="width: 100px; height: 100px; background-color: rgba(30, 60, 114, 0.05);">
                                        <div>
                                            <span class="fs-2 fw-bold text-primary d-block lh-1"><?= $persen ?>%</span>
                                            <small class="text-muted" style="font-size: 11px;">Akurasi</small>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-1">Ringkasan Nilai Anda</h4>
                                    <p class="text-muted small">Total soal dikerjakan: <?= $total ?> butir</p>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                                            <div class="fs-6 fw-bold text-success mb-1">
                                                <i class="fas fa-check-circle me-1"></i> Jawaban Benar
                                            </div>
                                            <div class="fs-2 fw-bold text-success"><?= $benar ?></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3">
                                            <div class="fs-6 fw-bold text-danger mb-1">
                                                <i class="fas fa-times-circle me-1"></i> Jawaban Salah
                                            </div>
                                            <div class="fs-2 fw-bold text-danger"><?= $salah ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?= base_url('latihan/jenis/2') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Level
                                    </a>
                                    <a href="<?= base_url() ?>/latihan/pembahasan_latihan/<?= $request->getUri()->getSegment(3) ?>/<?= $request->getUri()->getSegment(4) ?>/<?= $request->getUri()->getSegment(5) ?>/<?= $request->getUri()->getSegment(6) ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                        Lihat Pembahasan <i class="fas fa-search ms-1"></i>
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