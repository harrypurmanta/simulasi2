<?php
$title = 'Petunjuk Latihan Passhand - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper d-flex flex-column min-vh-100">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper flex-grow-1 d-flex align-items-center justify-content-center py-2" style="background-color: #f4f6f9;">
            <div class="container px-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <h4 class="fw-bold mb-1">Petunjuk Pengerjaan Soal</h4>
                                <h6 class="text-warning fw-semibold mb-0"><?= esc($jenis->jenis_nm) ?></h6>
                            </div>
                            <div class="card-body px-4 py-3 text-center bg-white">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 58px; height: 58px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                                    <i class="fas fa-hand-paper fa-2x"></i>
                                </div>
                                <div class="px-3 py-2 bg-light rounded-3 text-secondary my-2" style="font-size: 0.98rem; line-height: 1.55; text-align: justify;">
                                    <p class="mb-1">
                                        Tes ini terdiri dari serangkaian soal berupa pernyataan diri. Anda diminta untuk membaca setiap pernyataan yang ada, lalu pilihlah jawaban yang Anda anggap paling sesuai dengan kondisi diri Anda yang sebenarnya.
                                    </p>
                                    <p class="mb-0 fw-semibold text-dark">
                                        Tidak ada jawaban yang benar atau salah dalam tes ini. Kerjakan seluruhnya dan jangan ada soal yang terlewati.
                                    </p>
                                </div>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-info-circle text-primary me-1"></i> Klik tombol <strong>Mulai Sekarang</strong> di bawah untuk membuka paket soal.
                                </p>

                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= base_url('latihan/jenis/'.$group_id) ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 btn-sm fw-semibold">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <a href="<?= base_url('latihan/tryout/' . $group_id . '/' . $jenis_id) ?>" class="btn btn-success rounded-pill px-4 px-md-5 py-2 btn-sm fw-bold shadow-sm">
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
