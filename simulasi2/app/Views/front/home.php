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
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>
</body>
</html>