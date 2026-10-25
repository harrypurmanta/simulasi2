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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
                        <div class="col-md-12" style="height: 400px;">
                            <div class="bg-gray col-md-8 text-center" style="top: 50%;left: 50%;transform: translate(-50%, -50%);min-height: 300px; border-radius: 12px; padding: 25px 20px;">
                                <h3 style="padding-top:10px;"><b>Petunjuk Pengerjaan</b></h3>
                                <h3><b><?= $jenis->jenis_nm ?><?= !empty($level_nm) ? " <span class='label label-primary' style='font-size:16px; vertical-align: middle; margin-left: 8px;'>".esc($level_nm)."</span>" : "" ?></b></h3>
                                <p style="margin-top: 15px; margin-bottom: 25px; color: #555;">
                                    Silakan klik tombol mulai di bawah ini untuk memulai latihan soal.
                                </p>
                                <a href="<?= base_url()."/latihan/tryout_kecerdasan/".$jenis_id . (!empty($level_id) ? "/".$level_id : "") ?>" class="btn btn-success" style="font-size:18px; padding: 8px 30px; border-radius: 6px;">Mulai</a>
                            </div>
                        </div>
                    </div>
                </section>
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
</body>
</html>