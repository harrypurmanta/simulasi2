<?php
$title = 'Hasil Tryout CAT - Bintang Timur Prestasi';
$isMS = ($total_skor >= 61);
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center">
                            <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">HASIL AKHIR SIMULASI</span>
                                <h3 class="fw-bold mb-0">SKOR TRYOUT ANDA</h3>
                            </div>
                            <div class="card-body p-4 p-md-5 bg-white">
                                <div class="mb-4">
                                    <h1 class="display-1 fw-bold mb-0 <?= $isMS ? 'text-success' : 'text-danger' ?>">
                                        <?= $total_skor ?>
                                    </h1>
                                    <span class="badge <?= $isMS ? 'bg-success' : 'bg-danger' ?> px-4 py-2 fs-6 rounded-pill mt-2">
                                        <?= $isMS ? 'MEMENUHI SYARAT (MS)' : 'TIDAK MEMENUHI SYARAT (TMS)' ?>
                                    </span>
                                </div>

                                <div class="card bg-light border-0 rounded-3 p-3 mb-4">
                                    <h6 class="fw-bold text-dark mb-3 text-start px-2">Rincian Nilai per Bidang:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered bg-white text-center align-middle mb-0">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-start">Bidang Tes</th>
                                                    <th style="width: 35%;">Skor / Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-start fw-semibold">Passhand</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-semibold">Kecerdasan</td>
                                                    <td class="fw-bold text-primary"><?= $persen_kec ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-semibold">Kepribadian</td>
                                                    <td class="fw-bold text-primary"><?= $persen_kep ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start fw-semibold">Sikap Kerja</td>
                                                    <td class="fw-bold text-primary"><?= $persen_sk ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?= base_url('materi') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-home me-1"></i> Kembali ke Menu
                                    </a>
                                    <a href="<?= base_url() ?>/pembahasan/ujian/<?= $materi_id ?>/2" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                        Mulai Pembahasan <i class="fas fa-arrow-right ms-1"></i>
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