<?php
$title = 'Hasil Tryout CAT - Bintang Timur Prestasi';
$isMS = ($total_skor >= 61);
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper min-vh-100 d-flex flex-column">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper flex-grow-1 d-flex flex-column justify-content-start pt-2 pb-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-center">
                            <div class="card-header text-white py-2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <h5 class="fw-bold mb-0">SKOR TRYOUT ANDA</h5>
                            </div>
                            <div class="card-body p-2 p-md-3 bg-white">
                                <div class="mb-2 mt-1">
                                    <div class="fw-bold mb-0 lh-1 <?= $isMS ? 'text-success' : 'text-danger' ?>" style="font-size: 4.6rem; letter-spacing: -1px;">
                                        <?= $total_skor ?>
                                    </div>
                                    <span class="badge <?= $isMS ? 'bg-success' : 'bg-danger' ?> px-3 py-1 rounded-pill mt-1 fw-bold" style="font-size: 0.85rem;">
                                        <?= $isMS ? 'MEMENUHI SYARAT (MS)' : 'TIDAK MEMENUHI SYARAT (TMS)' ?>
                                    </span>
                                </div>

                                <div class="card bg-light border-0 rounded-3 p-1 mb-2">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered bg-white text-center align-middle mb-0" style="font-size: 15.5px;">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-start py-1">Bidang Tes</th>
                                                    <th style="width: 35%;" class="py-1">Skor / Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-start py-1 fw-semibold">Passhand</td>
                                                    <td class="py-1 fw-semibold">-</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start py-1 fw-semibold">Kecerdasan</td>
                                                    <td class="py-1 fw-bold text-primary"><?= $persen_kec ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start py-1 fw-semibold">Kepribadian</td>
                                                    <td class="py-1 fw-bold text-primary"><?= $persen_kep ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-start py-1 fw-semibold">Sikap Kerja</td>
                                                    <td class="py-1 fw-bold text-primary"><?= $persen_sk ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2 mt-2">
                                    <a href="<?= base_url('materi') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold">
                                        <i class="fas fa-home me-1"></i> Kembali ke Menu
                                    </a>
                                    <a href="<?= base_url('pembahasan/ujian/' . ($materi_id ?? 1) . '/2') ?>" class="btn btn-sm btn-primary rounded-pill px-4 py-1 fw-bold shadow-sm">
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