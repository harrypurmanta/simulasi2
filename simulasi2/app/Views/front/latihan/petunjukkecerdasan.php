<?php
$title = 'Petunjuk Latihan Kecerdasan - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">LATIHAN MANDIRI</span>
                                <h3 class="fw-bold mb-0">Petunjuk Pengerjaan</h3>
                                <h5 class="text-warning fw-semibold mt-1 mb-0">
                                    <?= esc($jenis->jenis_nm) ?>
                                    <?php if (!empty($level_nm)): ?>
                                        <span class="badge bg-light text-primary ms-2 fs-6"><?= esc($level_nm) ?></span>
                                    <?php endif; ?>
                                </h5>
                            </div>
                            <div class="card-body p-4 p-md-5 text-center bg-white">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                                    <i class="fas fa-brain fa-3x"></i>
                                </div>
                                <div class="px-md-4 py-3 bg-light rounded-3 text-secondary my-3" style="font-size: 1.1rem; line-height: 1.6;">
                                    <p class="mb-0">
                                        Jawablah pertanyaan-pertanyaan berikut dengan memilih opsi jawaban yang paling tepat. Anda dapat memeriksa hasil dan skor latihan setelah menyelesaikan seluruh soal.
                                    </p>
                                </div>
                                <p class="text-muted small mb-4">
                                    <i class="fas fa-info-circle text-primary me-1"></i> Klik tombol <strong>Mulai Sekarang</strong> di bawah untuk membuka paket soal.
                                </p>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?= base_url('latihan/jenis/'.$group_id) ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <a href="<?= base_url('latihan/tryout_kecerdasan/' . $jenis_id . (!empty($level_id) ? '/' . $level_id : '')) ?>" class="btn btn-success rounded-pill px-5 py-2 fw-bold shadow-sm">
                                        Mulai Sekarang <i class="fas fa-play ms-1"></i>
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