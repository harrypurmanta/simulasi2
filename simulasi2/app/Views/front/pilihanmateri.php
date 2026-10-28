<?php
$title = 'Petunjuk Pengerjaan Soal - Bintang Timur Prestasi';
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
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">SIMULASI UJIAN</span>
                                <h3 class="fw-bold mb-0">Petunjuk Pengerjaan Soal</h3>
                                <h5 class="text-warning fw-semibold mt-1 mb-0"><?= esc($group[0]->group_nm ?? '') ?></h5>
                            </div>
                            <div class="card-body p-4 p-md-5 text-center bg-white">
                                <div class="mb-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;">
                                        <i class="fas fa-clipboard-list fa-3x"></i>
                                    </div>
                                    <div class="px-md-4 py-3 bg-light rounded-3 text-secondary my-3" style="font-size: 1.1rem; line-height: 1.6;">
                                        <?php
                                            if ($group[0]->group_soal_id == 1) {
                                                echo "<p class='mb-0'>Jawablah setiap pertanyaan dengan jujur, sesuai dengan kenyataan yang ada pada diri Anda sendiri.</p>";
                                            } else if ($group[0]->group_soal_id == 2) {
                                                echo "<p class='mb-0'>Jawablah pertanyaan di bawah ini dengan memilih pilihan jawaban yang paling tepat!</p>";
                                            } else if ($group[0]->group_soal_id == 3) {
                                                echo "<p class='mb-0'>Perhatikan gambar di bawah ini, kemudian pilihlah karakter jawaban yang paling tepat dari beberapa pilihan jawaban yang tersedia.</p>";
                                            } else if ($group[0]->group_soal_id == 4) {
                                                echo "<p class='mb-0'>Soal terdiri dari 10 kolom, dimana setiap kolom memiliki batas waktu 1 menit. Pilihlah angka, huruf, atau simbol yang hilang dari soal. Gunakan waktu sebaik mungkin.</p>";
                                            }
                                        ?>
                                    </div>
                                    <p class="text-muted small">
                                        <i class="fas fa-info-circle text-primary me-1"></i> Saat Anda menekan tombol <strong>Mulai Sekarang</strong>, timer pengerjaan akan langsung berjalan otomatis.
                                    </p>
                                </div>

                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?= base_url('materi') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <?php
                                        if ($group[0]->group_soal_id == 4) {
                                            $url = base_url('tryout/sikapkerja/' . $materi_id . '/' . $group[0]->group_soal_id);
                                        } else {
                                            $url = base_url('tryout/ujian/' . $materi_id . '/' . $group[0]->group_soal_id);
                                        }
                                    ?>
                                    <a href="<?= $url ?>" class="btn btn-success rounded-pill px-5 py-2 fw-bold shadow-sm">
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