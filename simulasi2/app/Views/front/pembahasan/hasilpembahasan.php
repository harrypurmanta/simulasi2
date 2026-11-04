<?php
$title = 'Hasil Pembahasan Tryout - Bintang Timur Prestasi';
$isMS = ($total_skor >= 61);
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper min-vh-100 d-flex flex-column">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper flex-grow-1 d-flex align-items-center justify-content-center py-2" style="background-color: #f4f6f9;">
            <div class="container px-3">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center">
                            <div class="card-header text-white py-2" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <h5 class="fw-bold mb-0">SKOR TRYOUT ANDA</h5>
                            </div>
                            <div class="card-body p-2 p-md-3 bg-white">
                                <div class="mb-2">
                                    <h1 class="fw-bold mb-0 lh-1 <?= $isMS ? 'text-success' : 'text-danger' ?>">
                                        <?= $total_skor ?>
                                    </h1>
                                    <span class="badge <?= $isMS ? 'bg-success' : 'bg-danger' ?> px-4 py-2 fs-6 rounded-pill mt-2">
                                        <?= $isMS ? 'MEMENUHI SYARAT (MS)' : 'TIDAK MEMENUHI SYARAT (TMS)' ?>
                                    </span>
                                </div>

                                <div class="card bg-light border-0 rounded-3 p-2 mb-2">
                                    <h6 class="fw-bold text-dark mb-3 text-start px-2">Rincian Skor Per Bidang:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered bg-white text-center align-middle mb-0">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-start">Bidang Tes</th>
                                                    <th style="width: 35%;">Skor</th>
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
                                                    <td>-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?= base_url('pembahasan') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Pembahasan
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