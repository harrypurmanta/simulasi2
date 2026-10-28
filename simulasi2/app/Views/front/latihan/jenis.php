<?php
$request = service('request');
$group_id = $group_id ?? $request->getUri()->getSegment(3);
$title = ($group_id == 2) ? 'Latihan Kecerdasan - Bintang Timur Prestasi' : 'Pilihan Jenis Latihan - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<style>
    .level-btn-item {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 12px;
        text-align: center;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        text-decoration: none !important;
        display: block;
        margin-bottom: 15px;
    }
    .level-btn-item:hover {
        border-color: #2563eb;
        background: #f0f7fd;
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.15);
    }
    .level-btn-item .level-icon {
        font-size: 28px;
        color: #2563eb;
        margin-bottom: 8px;
    }
    .level-btn-item .level-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .level-btn-item .level-action {
        font-size: 12px;
        font-weight: 600;
        color: #2563eb;
    }
</style>

<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="row align-items-center mb-4">
                    <div class="col-md-auto mb-2 mb-md-0">
                        <a href="<?= base_url('latihan') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Kategori
                        </a>
                    </div>
                    <div class="col text-md-center">
                        <h2 class="fw-bold mb-1 text-dark">
                            <?= ($group_id == 2) ? 'LATIHAN KECERDASAN' : 'LATIHAN SOAL' ?>
                        </h2>
                        <p class="text-muted mb-0 small">
                            <?= ($group_id == 2) ? 'Pilih jenis soal kecerdasan di bawah ini untuk memilih level latihan' : 'Pilih jenis materi soal untuk memulai latihan' ?>
                        </p>
                    </div>
                    <div class="col-md-auto d-none d-md-block" style="width: 150px;"></div>
                </div>

                <div class="row g-4">
                    <?php
                        $this->session = \Config\Services::session();
                        foreach ($jenis as $key) {
                    ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="small-box-latihan h-100 d-flex flex-column justify-content-between">
                            <div class="inner">
                                <h4><?= esc($key->jenis_nm) ?></h4>
                            </div>
                            <?php if ($group_id == 2): ?>
                                <a href="javascript:void(0)" onclick="pilihLevel(<?= $key->jenis_id ?>, '<?= esc($key->jenis_nm, 'js') ?>')" class="small-box-footer">
                                    Pilih Level <i class="fas fa-arrow-circle-right ms-1"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url()."/latihan/petunjuk/".$group_id."/".$key->jenis_id ?>" class="small-box-footer">
                                    Mulai Latihan <i class="fas fa-arrow-circle-right ms-1"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Modal Pilih Level (Khusus Group Kecerdasan) -->
        <div class="modal fade" id="modalLevel" tabindex="-1" aria-labelledby="modalLevelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                    <div class="modal-header border-0 text-white" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 18px 24px;">
                        <h5 class="modal-title fw-bold" id="modalLevelLabel">
                            <i class="fas fa-layer-group me-2 text-warning"></i> Pilih Level Soal: <span id="modalJenisNm" class="text-warning"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-light min-vh-25">
                        <div id="modalLoading" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted fw-semibold">Memuat daftar level soal...</p>
                        </div>
                        <div id="modalLevelContainer" class="row g-3">
                            <!-- Daftar level dimuat secara dinamis -->
                        </div>
                        <div id="modalLevelEmpty" class="text-center py-5" style="display: none;">
                            <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                            <h6 class="fw-bold text-dark mb-2">Belum ada tingkatan level khusus</h6>
                            <p class="text-muted small mb-4">Anda dapat langsung mengerjakan paket soal materi ini secara menyeluruh.</p>
                            <a id="btnDirectMulai" href="#" class="btn btn-primary rounded-pill px-4">
                                Mulai Latihan Langsung <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer bg-white border-top py-2 px-4">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>
    <script>
        var baseUrl = "<?= base_url() ?>";
        var groupId = "<?= $group_id ?>";
        var preloadedLevels = <?= json_encode($levels ?? []) ?>;

        function pilihLevel(jenisId, jenisNm) {
            $("#modalJenisNm").text(jenisNm);
            $("#modalLevelContainer").empty().hide();
            $("#modalLevelEmpty").hide();
            $("#modalLoading").show();
            $("#modalLevel").modal("show");

            if (preloadedLevels && preloadedLevels[jenisId] !== undefined) {
                renderLevels(jenisId, preloadedLevels[jenisId]);
            } else {
                $.ajax({
                    url: baseUrl + "/latihan/getlevel",
                    type: "POST",
                    dataType: "json",
                    data: { jenis_id: jenisId },
                    success: function(levels) {
                        renderLevels(jenisId, levels);
                    },
                    error: function() {
                        $("#modalLoading").hide();
                        $("#btnDirectMulai").attr("href", baseUrl + "/latihan/petunjuk/" + groupId + "/" + jenisId);
                        $("#modalLevelEmpty").show();
                    }
                });
            }
        }

        function renderLevels(jenisId, levels) {
            $("#modalLoading").hide();
            if (levels && levels.length > 0) {
                var html = "";
                levels.forEach(function(item) {
                    var petunjukUrl = baseUrl + "/latihan/petunjuk/" + groupId + "/" + jenisId + "/" + item.level_id;
                    html += '<div class="col-6 col-md-4">';
                    html += '  <a href="' + petunjukUrl + '" class="level-btn-item">';
                    html += '    <div class="level-icon"><i class="fas fa-cubes"></i></div>';
                    html += '    <div class="level-title">' + (item.level_nm || ('Level ' + item.level_id)) + '</div>';
                    html += '    <div class="level-action">Mulai <i class="fas fa-arrow-right ms-1"></i></div>';
                    html += '  </a>';
                    html += '</div>';
                });
                $("#modalLevelContainer").html(html).show();
            } else {
                $("#btnDirectMulai").attr("href", baseUrl + "/latihan/petunjuk/" + groupId + "/" + jenisId);
                $("#modalLevelEmpty").show();
            }
        }
    </script>
</body>
</html>