<?php
$title = 'Petunjuk Pembahasan - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center">
                            <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <span class="badge bg-info bg-opacity-25 text-white px-3 py-1 rounded-pill fw-bold mb-2">REVIEW PEMBAHASAN</span>
                                <h3 class="fw-bold mb-0">Petunjuk Pembahasan Soal</h3>
                                <h5 class="text-warning fw-semibold mt-1 mb-0"><?= esc($group[0]->group_nm ?? '') ?></h5>
                            </div>
                            <div class="card-body p-4 p-md-5 bg-white">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: rgba(2, 132, 199, 0.1); color: #0284c7;">
                                    <i class="fas fa-search-plus fa-3x"></i>
                                </div>
                                <p class="text-muted mb-4" style="line-height: 1.6;">
                                    Saat Anda menekan tombol <strong>Mulai Pembahasan</strong>, Anda akan masuk ke halaman ulasan kunci jawaban dan penjelasan soal. Anda dapat melompat ke nomor berapa saja secara bebas.
                                </p>
                                <?php
                                    if ($group[0]->group_soal_id == 4) {
                                        $url = base_url('pembahasan/sikapkerja/' . $materi_id . '/' . $group[0]->group_soal_id);
                                    } else {
                                        $url = base_url('pembahasan/ujian/' . $materi_id . '/' . $group[0]->group_soal_id);
                                    }
                                ?>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= base_url('pembahasan') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <a href="<?= $url ?>" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
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