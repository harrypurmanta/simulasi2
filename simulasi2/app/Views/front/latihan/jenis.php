<?php
$request = service('request');
$group_id = $group_id ?? $request->getUri()->getSegment(3);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .small-box-latihan {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: all 0.25s ease-in-out;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }
        .small-box-latihan:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
            border-color: #3c8dbc;
        }
        .small-box-latihan .inner {
            padding: 20px 15px;
            min-height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .small-box-latihan .inner h4 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
            line-height: 1.4;
            word-wrap: break-word;
        }
        .small-box-latihan .small-box-footer {
            display: block;
            padding: 10px 15px;
            color: #ffffff;
            background-color: #3c8dbc;
            text-align: center;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
            cursor: pointer;
        }
        .small-box-latihan .small-box-footer:hover {
            background-color: #286090;
            color: #ffffff;
        }
        .level-btn-item {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 12px;
            text-align: center;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            text-decoration: none !important;
            display: block;
            margin-bottom: 15px;
        }
        .level-btn-item:hover {
            border-color: #3c8dbc;
            background: #f0f7fd;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(60, 141, 188, 0.15);
        }
        .level-btn-item .level-icon {
            font-size: 26px;
            color: #3c8dbc;
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
            color: #3c8dbc;
        }
    </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 15px; margin-bottom: 10px;">
                            <a href="<?= base_url('latihan') ?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600;">
                                <i class="fa fa-arrow-left"></i> Kembali ke Kategori Latihan
                            </a>
                        </div>
                        <div class="col-md-12 text-center" style="margin-bottom: 25px;">
                            <h2 style="font-weight: 700; margin-top: 5px; color: #1e293b;">
                                <?= ($group_id == 2) ? 'LATIHAN KECERDASAN' : 'LATIHAN' ?>
                            </h2>
                            <p style="color: #64748b; font-size: 15px;">
                                <?= ($group_id == 2) ? 'Pilih jenis soal kecerdasan di bawah ini untuk memilih level latihan' : 'Pilih jenis materi soal untuk memulai latihan' ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <?php
                                $this->session = \Config\Services::session();
                                foreach ($jenis as $key) {
                            ?>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="small-box-latihan">
                                    <div class="inner">
                                        <h4><?= esc($key->jenis_nm) ?></h4>
                                    </div>
                                    <?php if ($group_id == 2): ?>
                                        <a href="javascript:void(0)" onclick="pilihLevel(<?= $key->jenis_id ?>, '<?= esc($key->jenis_nm, 'js') ?>')" class="small-box-footer">
                                            Mulai <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url()."/latihan/petunjuk/".$group_id."/".$key->jenis_id ?>" class="small-box-footer">
                                            Mulai <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal Pilih Level (Khusus Group Kecerdasan) -->
        <div class="modal fade" id="modalLevel" tabindex="-1" role="dialog" aria-labelledby="modalLevelLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.25);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 16px 20px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.85; text-shadow: none; font-size: 24px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="modalLevelLabel" style="font-weight: 700; font-size: 18px;">
                            <i class="fa fa-cubes"></i> Pilih Level Soal: <span id="modalJenisNm" style="color: #ffd166;"></span>
                        </h4>
                    </div>
                    <div class="modal-body" style="padding: 25px 20px; background: #f8fafc; min-height: 180px;">
                        <div id="modalLoading" class="text-center" style="display: none; padding: 30px 0;">
                            <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                            <p style="margin-top: 10px; color: #64748b; font-weight: 600;">Memuat daftar level...</p>
                        </div>
                        <div id="modalLevelContainer" class="row">
                            <!-- Daftar level dimuat di sini -->
                        </div>
                        <div id="modalLevelEmpty" class="text-center" style="display: none; padding: 25px 15px;">
                            <i class="fa fa-info-circle fa-3x text-warning" style="margin-bottom: 12px;"></i>
                            <p style="font-size: 15px; color: #475569; margin-bottom: 20px;">
                                Belum ada level khusus untuk jenis materi ini.
                            </p>
                            <a id="btnDirectMulai" href="#" class="btn btn-primary" style="border-radius: 6px; padding: 8px 24px; font-weight: 600;">
                                Mulai Latihan Langsung <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f1f5f9; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/dist/js/demo.js"></script>
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

            // Cek preloaded data terlebih dahulu
            if (preloadedLevels && preloadedLevels[jenisId] !== undefined) {
                renderLevels(jenisId, preloadedLevels[jenisId]);
            } else {
                // Fallback AJAX
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
                    html += '<div class="col-xs-6 col-sm-4">';
                    html += '  <a href="' + petunjukUrl + '" class="level-btn-item">';
                    html += '    <div class="level-icon"><i class="fa fa-cubes"></i></div>';
                    html += '    <div class="level-title">' + (item.level_nm || ('Level ' + item.level_id)) + '</div>';
                    html += '    <div class="level-action">Mulai <i class="fa fa-arrow-right"></i></div>';
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