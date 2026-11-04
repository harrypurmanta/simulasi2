<?php
$title = 'Petunjuk Latihan Passhand - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper" style="padding-top: 8px !important; padding-bottom: 20px !important;">
            <div class="container pt-1 pb-3">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="card-header text-white text-center py-3" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <h3 class="fw-bold mb-0">Petunjuk Pengerjaan Soal</h3>
                                <h5 class="text-warning fw-semibold mt-1 mb-0"><?= esc($jenis->jenis_nm) ?></h5>
                            </div>
                            <div class="card-body px-4 pt-3 pb-4 text-center bg-white">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 68px; height: 68px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                                    <i class="fas fa-hand-paper fa-2x"></i>
                                </div>
                                <div class="px-md-4 py-3 bg-light rounded-3 text-secondary my-3" style="font-size: 1.05rem; line-height: 1.7; text-align: justify;">
                                    <p class="mb-2">
                                        Tes ini terdiri dari serangkaian soal berupa pernyataan diri. Anda diminta untuk membaca setiap pernyataan yang ada, lalu pilihlah jawaban yang Anda anggap paling sesuai dengan kondisi diri Anda yang sebenarnya.
                                    </p>
                                    <p class="mb-0 fw-semibold text-dark">
                                        Tidak ada jawaban yang benar atau salah dalam tes ini. Kerjakan seluruhnya dan jangan ada soal yang terlewati.
                                    </p>
                                </div>
                                <p class="text-muted small mb-4">
                                    <i class="fas fa-info-circle text-primary me-1"></i> Klik tombol <strong>Mulai Sekarang</strong> di bawah untuk membuka paket soal.
                                </p>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?= base_url('latihan/jenis/'.$group_id) ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <a href="<?= base_url('latihan/tryout/' . $group_id . '/' . $jenis_id) ?>" class="btn btn-success rounded-pill px-5 py-2 fw-bold shadow-sm">
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