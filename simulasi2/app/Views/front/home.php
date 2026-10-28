<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <!-- Welcome Banner -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                    <div class="card-body p-4 p-md-5 text-white">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                                    <i class="fas fa-star me-1"></i> BIMBEL CAT 100% FULL KOMPUTER
                                </span>
                                <h1 class="display-6 fw-bold mb-3">Selamat Datang di Bintang Timur Prestasi</h1>
                                <p class="lead mb-2 opacity-90" style="font-size: 1.05rem; line-height: 1.6;">
                                    Pusat Bimbingan Belajar dan Simulasi CAT Terbaik untuk Persiapan Seleksi TNI, POLRI, dan Kedinasan. Hadir di kota Palembang, Sekayu, Lahat, Lubuk Linggau, dan Metro Lampung.
                                </p>
                                <p class="small opacity-75 mb-0">
                                    Metode pembelajaran langsung praktik simulasi CAT dengan ribuan bank soal terstandar dan pembahasan terarah.
                                </p>
                            </div>
                            <div class="col-lg-4 text-center mt-4 mt-lg-0 d-none d-lg-block">
                                <i class="fas fa-laptop-code text-white-50" style="font-size: 110px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Menu Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                        <i class="fas fa-book-open fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">Materi & Tryout</h5>
                                        <small class="text-muted">Simulasi Ujian Utama</small>
                                    </div>
                                </div>
                                <p class="card-text text-muted small mb-3">Ikuti simulasi tes tryout terjadwal dengan sistem penilaian standar.</p>
                                <a href="<?= base_url() ?>/materi" class="btn btn-primary w-100 rounded-pill">
                                    Mulai Tryout <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                                        <i class="fas fa-tasks fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">Latihan Soal</h5>
                                        <small class="text-muted">Mandiri & Berjenjang</small>
                                    </div>
                                </div>
                                <p class="card-text text-muted small mb-3">Latihan soal mandiri per kategori dengan tingkatan level bertahap.</p>
                                <a href="<?= base_url() ?>/latihan" class="btn btn-success w-100 rounded-pill">
                                    Pilih Latihan <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3">
                                        <i class="fas fa-stopwatch fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">Sikap Kerja</h5>
                                        <small class="text-muted">Tes Kecermatan</small>
                                    </div>
                                </div>
                                <p class="card-text text-muted small mb-3">Latih kecepatan & ketelitian dengan simulasi tes angka/huruf hilang per kolom.</p>
                                <a href="<?= base_url() ?>/sikapkerja" class="btn btn-warning text-dark w-100 rounded-pill fw-semibold">
                                    Tes Kecermatan <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-3 h-100 transition-hover">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3">
                                        <i class="fas fa-search fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title fw-bold mb-0">Pembahasan</h5>
                                        <small class="text-muted">Review Hasil</small>
                                    </div>
                                </div>
                                <p class="card-text text-muted small mb-3">Pelajari kunci jawaban serta gambar penjelasan untuk evaluasi belajar.</p>
                                <a href="<?= base_url() ?>/pembahasan" class="btn btn-info text-white w-100 rounded-pill">
                                    Lihat Pembahasan <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Callout -->
                <div class="callout callout-info border-start border-4 border-info bg-white shadow-sm rounded-3 p-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle text-info me-2"></i> Petunjuk Pelaksanaan Simulasi</h5>
                    <p class="text-muted mb-2">
                        Pastikan koneksi internet stabil saat menjalankan ujian dan perhatikan alokasi waktu pada masing-masing sub-tes. Jawaban Anda tersimpan otomatis secara berkala ke dalam server.
                    </p>
                    <small class="text-muted">Bila mengalami kendala teknis atau membutuhkan token ujian baru, silakan menghubungi admin/instruktur bimbel di kelas Anda.</small>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>
</body>
</html>