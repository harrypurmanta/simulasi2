<?php
$title = 'Materi & Tryout - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container pt-2 pb-4">
                <div class="text-center mb-3">
                    <h2 class="fw-bold text-dark mb-1">Daftar Materi Soal</h2>
                    <p class="text-muted small mb-0">Pilih paket materi untuk mengikuti simulasi ujian CAT terjadwal</p>
                </div>

                <div class="row g-3">
                    <?php
                        $this->session = \Config\Services::session();
                        $user_id = $this->session->user_id;
                        $db = db_connect();
                        foreach ($materi as $key) {
                            if ($key->materi_id == 1) {
                                $group_id = 1;
                            } else {
                                $group_id = 2;
                            }

                            $query = $db->query("SELECT * FROM respon WHERE materi = $key->materi_id AND created_user_id = $user_id AND status_cd = 'normal'")->getResultArray();
                            $isDone = (count($query) > 0);
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-hover <?= $isDone ? 'text-white' : 'bg-white' ?>" 
                             style="<?= $isDone ? 'background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;' : '' ?>">
                            <div class="card-body p-3 text-center d-flex flex-column justify-content-between">
                                <div class="my-2">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                                         style="width: 46px; height: 46px; <?= $isDone ? 'background-color: rgba(255, 255, 255, 0.2); color: #ffffff;' : 'background-color: rgba(30, 60, 114, 0.08); color: #1e3c72;' ?>">
                                        <i class="fas <?= $isDone ? 'fa-check-circle' : 'fa-file-alt' ?> fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0 <?= $isDone ? 'text-white' : 'text-dark' ?>"><?= esc($key->materi_nm) ?></h5>
                                </div>

                                <div class="mt-2">
                                    <?php if ($isDone): ?>
                                        <a href="<?= base_url('materi/hasiltryout/' . $key->materi_id) ?>" class="btn btn-light text-success fw-bold w-100 rounded-pill py-2 shadow-sm">
                                            Lihat Hasil <i class="fas fa-chart-bar ms-1"></i>
                                        </a>
                                    <?php else: ?>
                                        <button type="button" onclick="showtoken(<?= $group_id ?>, <?= $key->materi_id ?>, '<?= esc($key->materi_nm, 'js') ?>')" class="btn btn-primary w-100 rounded-pill fw-semibold py-2">
                                            Mulai <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Modal Token -->
        <div class="modal fade" id="modal-token" tabindex="-1" aria-labelledby="modalTokenLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header border-0 text-white" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 18px 24px;">
                        <h5 class="modal-title fw-bold" id="modalTokenLabel">
                            <i class="fas fa-key me-2 text-warning"></i> Masukkan Token: <span id="materiNmDisplay" class="text-warning"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <input type="hidden" name="group_idx" id="group_idx">
                        <input type="hidden" name="materi_id" id="materi_id">

                        <div class="mb-3">
                            <label for="token" class="form-label fw-semibold text-dark">Token Materi</label>
                            <input class="form-control form-control-lg rounded-3" type="text" name="token" id="token" placeholder="Masukkan 6 Digit Token Materi" maxlength="6" minlength="6" autocomplete="off">
                            <small class="text-muted">Dapatkan token dari instruktur/admin.</small>
                        </div>
                        <div class="mb-4">
                            <label for="tokenuser" class="form-label fw-semibold text-dark">Token User</label>
                            <input class="form-control form-control-lg rounded-3" type="text" name="tokenuser" id="tokenuser" placeholder="Masukkan Token User" maxlength="6" minlength="6" autocomplete="off">
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg rounded-pill fw-semibold" type="button" onclick="checktoken()">
                                Verifikasi & Mulai Ujian <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>
    <script>
        function showtoken(group_id, materi_id, materi_nm) {
            $("#token").val("");
            $("#tokenuser").val("");
            $("#group_idx").val(group_id);
            $("#materi_id").val(materi_id);
            $("#materiNmDisplay").text(materi_nm || '');
            $("#modal-token").modal("show");
        }

        function checktoken() {
            var token = $("#token").val();
            var group_id = $("#group_idx").val();
            var materi_id = $("#materi_id").val();
            var tokenuser = $("#tokenuser").val();

            if (!token) {
                alert("Silakan masukkan token materi terlebih dahulu");
                return;
            }

            $.ajax({
                url: "<?= base_url('token/checktoken') ?>",
                type: "post",
                dataType: "json",
                data: {
                    "token": token,
                    "group_id": group_id,
                    "materi_id": materi_id,
                    "tokenuser": tokenuser
                },
                success: function(data) {
                    if (data == "sukses") {
                        $("#modal-token").modal("hide");
                        window.location.href = "<?= rtrim(base_url(), '/') ?>/tryout/ujian/" + materi_id + "/" + group_id;
                    } else {
                        alert("Token salah atau tidak aktif. Silakan hubungi administrator.");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat verifikasi token.");
                }
            });
        }
    </script>
</body>
</html>