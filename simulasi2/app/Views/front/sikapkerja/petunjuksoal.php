<?php
$request = \Config\Services::request();
$title = 'Petunjuk Tes Sikap Kerja - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">TES KECERMATAN</span>
                                <h3 class="fw-bold mb-0">Petunjuk Pengerjaan Tes Sikap Kerja</h3>
                            </div>
                            <div class="card-body p-4 p-md-5 bg-white">
                                <div class="alert alert-info border-0 rounded-3 mb-4">
                                    <h5 class="fw-bold mb-1"><i class="fas fa-info-circle me-2"></i> Perhatian:</h5>
                                    <p class="mb-0">Sebelum mengerjakan tes, bacalah petunjuk pengerjaan ini dengan seksama.</p>
                                </div>

                                <p class="lead" style="font-size: 1.05rem; line-height: 1.7; text-align: justify;">
                                    Pada tes sikap kerja ini, Anda akan dihadapkan pada lima deret (angka/huruf/simbol) yang dipasangkan dengan huruf <strong>A, B, C, D, dan E</strong>. Soal terbagi dalam 10 kolom dimana masing-masing kolom memiliki pola deret yang berbeda-beda.
                                </p>

                                <div class="card bg-light border-0 rounded-3 p-4 my-4 text-center">
                                    <h6 class="fw-bold text-dark mb-3">Tabel Acuan Kolom:</h6>
                                    <div class="table-responsive d-flex justify-content-center">
                                        <table class="table table-bordered table-sm text-center fw-bold bg-white shadow-sm mb-0" style="max-width: 450px;">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th colspan="5">Kolom Acuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="fs-5 text-primary">
                                                    <td>∑</td>
                                                    <td>4</td>
                                                    <td>7</td>
                                                    <td>V</td>
                                                    <td>X</td>
                                                </tr>
                                                <tr class="bg-light">
                                                    <td>A</td>
                                                    <td>B</td>
                                                    <td>C</td>
                                                    <td>D</td>
                                                    <td>E</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-start mt-3 small text-muted px-md-4">
                                        <ul class="mb-0">
                                            <li>Pilihan <strong>A</strong> dipasangkan dengan simbol <strong>∑</strong></li>
                                            <li>Pilihan <strong>B</strong> dipasangkan dengan angka <strong>4</strong></li>
                                            <li>Pilihan <strong>C</strong> dipasangkan dengan angka <strong>7</strong></li>
                                            <li>Pilihan <strong>D</strong> dipasangkan dengan huruf <strong>V</strong></li>
                                            <li>Pilihan <strong>E</strong> dipasangkan dengan huruf <strong>X</strong></li>
                                        </ul>
                                    </div>
                                </div>

                                <p style="font-size: 1.05rem; line-height: 1.7; text-align: justify;">
                                    Pada setiap soal, Anda akan diberikan 4 deret (angka/huruf/simbol). Tugas Anda adalah menemukan <strong>karakter yang hilang</strong> dari 5 karakter acuan, kemudian pilihlah huruf pilihan jawaban yang sesuai dengan karakter yang hilang tersebut.
                                </p>

                                <div class="card border border-warning bg-warning bg-opacity-10 rounded-3 p-4 my-4 text-center">
                                    <h6 class="fw-bold text-dark mb-3">Contoh Soal:</h6>
                                    <div class="table-responsive d-flex justify-content-center mb-3">
                                        <table class="table table-bordered text-center fw-bold bg-white shadow-sm mb-0" style="max-width: 350px;">
                                            <tbody>
                                                <tr class="fs-5 text-dark">
                                                    <td>4</td>
                                                    <td>∑</td>
                                                    <td>7</td>
                                                    <td>V</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-start small text-dark mb-0 px-md-4">
                                        Dari 4 karakter di atas, karakter <strong>X</strong> tidak ada pada soal. Karena karakter <strong>X</strong> berpasangan dengan pilihan <strong>E</strong> pada tabel acuan, maka jawaban yang benar adalah <strong>E</strong>.
                                    </p>
                                </div>

                                <div class="callout callout-warning border-start border-4 border-warning bg-white shadow-sm rounded-3 p-4 my-4">
                                    <h6 class="fw-bold text-dark mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Ketentuan Pengerjaan:</h6>
                                    <ul class="mb-0 text-muted small">
                                        <li class="mb-1">Setiap kolom memiliki batas waktu pengerjaan otomatis. Jika waktu habis, sistem akan berpindah otomatis ke kolom berikutnya.</li>
                                        <li class="mb-1">Kerjakan dengan cepat, tepat, dan cermat tanpa berhenti sebelum tes berakhir.</li>
                                    </ul>
                                </div>

                                <div class="text-center mt-5">
                                    <a class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow" href="<?= base_url() ?>/sikapkerja/ujian/<?= $request->getUri()->getSegment(3) ?>">
                                        Mulai Tes Sekarang <i class="fas fa-play ms-2"></i>
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