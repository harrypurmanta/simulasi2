<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Latihan Kecerdasan - Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .d-none { display: none !important; }
        #loader-wrapper {
            display: flex;
            position: fixed;
            z-index: 1060;
            top: 0; right: 0; bottom: 0; left: 0;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.65);
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3c8dbc;
            border-bottom: 8px solid #00a65a;
            width: 50px;
            height: 50px;
            animation: spin 1.5s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .jawaban_dv:hover {
            background-color: #e2e8f0 !important;
            transform: translateX(4px);
        }
        #dv_boxnosoal {
            display: grid !important;
            grid-template-columns: repeat(5, 1fr) !important;
            gap: 6px !important;
        }
        #dv_boxnosoal div {
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            user-select: none;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        #dv_boxnosoal div:hover {
            transform: scale(1.08);
            z-index: 2;
        }
    </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <div class="content-wrapper">
            <div class="container" style="max-width: 1200px;">
                <section class="content">
                    <!-- Top Bar Info & Timer -->
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-8 col-sm-7">
                            <div class="bg-gray" style="border-radius: 8px; padding: 12px 18px; min-height: 85px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                                <div>
                                    <label style="font-size: 13px; color: #475569; margin-bottom: 4px; display: block;">Tahapan Ujian (Kecerdasan)</label>
                                    <span class="label label-success" style="font-size: 16px; padding: 6px 14px; border-radius: 6px; display: inline-block;">
                                        <?= esc($jenis_nm->jenis_nm ?? 'Kecerdasan') ?>
                                    </span>
                                    <?php if (!empty($level_nm)): ?>
                                        <span class="label label-primary" style="font-size: 16px; padding: 6px 14px; border-radius: 6px; display: inline-block; margin-left: 6px;">
                                            <?= esc($level_nm) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span id="answered_stat" style="font-weight: 600; font-size: 14px; color: #1e293b;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-5">
                            <div class="bg-gray text-center" style="border-radius: 8px; height: 85px; padding-top: 8px; margin-bottom: 10px;">
                                <span style="font-size: 12px; font-weight: 600; color: #475569;">Sisa Waktu</span><br>
                                <label style="font-size: 32px; font-weight: 700; color: #dc2626; margin: 0; line-height: 1.1;" id="countdown">00:00</label>
                            </div>
                        </div>
                    </div>

                    <!-- Main Exam Area -->
                    <div class="row" style="margin-top: 10px;">
                        <!-- Left Area: Question & Choices (col-md-8) -->
                        <div class="col-md-8 col-sm-7">
                            <div class="bg-gray" style="border-radius: 8px; padding: 18px; margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <label for="pertanyaan" style="font-size: 15px; margin: 0; color: #1e293b;">Pertanyaan</label>
                                    <span id="progress_text" style="font-size: 13px; font-weight: 600; color: #64748b;"></span>
                                </div>
                                <div class="col-md-12" style="min-height: 120px; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 18px; margin-bottom: 15px;">
                                    <b><p id="p_no_soal" style="margin: 0 0 10px 0; font-size: 16px; color: #1e3c72;">Soal no. 1</p></b>
                                    <p id="inp_soal_nm" style="margin: 0; font-size: 16px; line-height: 1.6; color: #1e293b;"></p>
                                    <div id="dv_img_soal"></div>
                                    <input type="hidden" id="inp_soal_id">
                                    <input type="hidden" value="1" id="inp_no_soal">
                                    <input type="hidden" id="used" value="">
                                </div>

                                <!-- Choices -->
                                <div id="dv_main_jawaban" class="row" style="margin: 0;">
                                    <!-- Options injected here -->
                                </div>
                                <input type="hidden" value="" id="inp_jawaban_id">
                                <input type="hidden" value="" id="inp_pilihan_nm">

                                <!-- Buttons -->
                                <div class="row" style="margin-top: 20px; margin-bottom: 10px;">
                                    <div class="col-md-12" id="dv_button" style="display: flex; justify-content: space-between; align-items: center;">
                                        <!-- Buttons injected here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Area: Box Nomor Soal (col-md-4) -->
                        <div class="col-md-4 col-sm-5">
                            <div class="bg-gray" style="border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                                <div style="border-bottom: 1px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 12px; text-align: center;">
                                    <strong style="font-size: 14px; color: #1e293b;"><i class="fa fa-th"></i> Daftar Nomor Soal</strong>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">5 kotak per baris &bull; Klik nomor untuk lompat ke soal</div>
                                </div>
                                <div>
                                    <div id="dv_boxnosoal" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; max-height: 480px; overflow-y: auto; padding: 4px;">
                                        <!-- 5 Box per baris injected here -->
                                    </div>
                                </div>
                                <div style="margin-top: 14px; border-top: 1px solid #cbd5e1; padding-top: 8px; font-size: 11px; display: flex; justify-content: space-around;">
                                    <span><span style="display:inline-block; width:12px; height:12px; background:#e8f8e8; border:2px solid #3cce3c; border-radius:2px; vertical-align:middle;"></span> Dijawab</span>
                                    <span><span style="display:inline-block; width:12px; height:12px; background:#fff; border:2px solid #f87171; border-radius:2px; vertical-align:middle;"></span> Belum</span>
                                    <span><span style="display:inline-block; width:12px; height:12px; background:#d0e2ff; border:2px solid #2a5298; border-radius:2px; vertical-align:middle;"></span> Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="d-none" id='loader-wrapper'>
            <div class="loader"></div>
        </div>
        <?= $this->include('front/footer') ?>
    </div>

    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>

    <script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
            wrapping: false
        });
    });

    var timers;
    var jenis_id = <?= (int)$jenis_id ?>;
    var level_id = <?= (int)$level_id ?>;
    var total_soal_count = 0;

    $(document).ready(function() {
        startujian("start");
    });

    function selectJawaban(jawaban_id, pilihan_nm) {
        if (jawaban_id != "") {
            let dv = document.getElementsByClassName("jawaban_dv");
            for (let index = 0; index < dv.length; index++) {
                dv[index].style.border = "1px solid #d2d6de";
                dv[index].style.backgroundColor = "#f4f6f9";
            }
            $("#inp_jawaban_id").val(jawaban_id);
            $("#inp_pilihan_nm").val(pilihan_nm);
            let activeElem = document.getElementById("dv_jawaban_" + jawaban_id);
            if (activeElem) {
                activeElem.style.border = "2px solid #00a65a";
                activeElem.style.backgroundColor = "#d7f0db";
            }
        }
    }

    function setboxsoal(no_soal) {
        $("#inp_no_soal").val(no_soal);
        $("#p_no_soal").text("Soal no. " + no_soal);
        startujian("jump");
    }

    function startujian(proc) {
        let soal_id    = $("#inp_soal_id").val();
        let jawaban_id = $("#inp_jawaban_id").val();
        let no_soal    = $("#inp_no_soal").val();
        let pilihan_nm = $("#inp_pilihan_nm").val();
        let waktu      = document.getElementById('countdown').textContent;
        let used       = $("#used").val();

        $.ajax({
            url: "<?= base_url('latihan/startujian_kecerdasan') ?>",
            type: "post",
            dataType: "json",
            data: {
                "soal_id": soal_id,
                "jawaban_id": jawaban_id,
                "jenis_id": jenis_id,
                "level_id": level_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "proc": proc,
                "used": used,
                "waktu": waktu
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none");
            },
            success: function(data) {
                $("#loader-wrapper").addClass("d-none");

                if (data.proc == "selesai") {
                    selesaiUjian(data.used);
                    return;
                }

                if (data == "jawaban_kosong") {
                    Swal.fire({
                        title: "Peringatan",
                        text: "Silakan pilih salah satu jawaban terlebih dahulu sebelum lanjut.",
                        icon: "warning"
                    });
                    return;
                }

                // Inisialisasi timer di awal
                if (proc == "start") {
                    window.clearInterval(timers);
                    countdown(2700); // 45 menit untuk kecerdasan
                }

                total_soal_count = data.total_soal;
                $("#inp_soal_id").val(data.soal_id);
                $("#inp_soal_nm").text(data.soal_nm);
                $("#p_no_soal").text("Soal no. " + data.no_soal + " dari " + data.total_soal);
                $("#progress_text").text(data.jumlah_jawab + " dari " + data.total_soal + " terjawab");
                $("#answered_stat").html("<i class='fa fa-check-circle text-success'></i> Terjawab: " + data.jumlah_jawab + "/" + data.total_soal);
                $("#inp_no_soal").val(data.no_soal);
                $("#used").val(data.used);
                $("#dv_main_jawaban").html(data.jawaban_nm);
                $("#dv_boxnosoal").html(data.boxnomorsoal);
                $("#dv_button").html(data.button);
                $("#inp_jawaban_id").val(data.jawaban_idx || "");
                $("#inp_pilihan_nm").val(data.pilihan_nms || "");
                $("#dv_img_soal").html(data.img_soal || "");

                // Auto highlight jawaban jika sudah pernah dipilih
                if (data.jawaban_idx) {
                    setTimeout(() => {
                        selectJawaban(data.jawaban_idx, data.pilihan_nms);
                    }, 10);
                }
            },
            error: function(xhr, status, error) {
                $("#loader-wrapper").addClass("d-none");
                Swal.fire({
                    title: "Terjadi Kendala",
                    text: "Gagal memuat soal, silakan coba lagi.",
                    icon: "error"
                });
            }
        });
    }

    function konfirmasiSelesai() {
        Swal.fire({
            title: "Konfirmasi Selesai",
            text: "Apakah Anda yakin ingin menyelesaikan latihan soal ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#00a65a",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Selesai!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                startujian("selesai");
            }
        });
    }

    function selesaiUjian(used) {
        Swal.fire({
            title: "Latihan Selesai!",
            text: "Terima kasih, Anda telah menyelesaikan latihan soal kecerdasan ini.",
            icon: "success",
            confirmButtonText: "Lihat Hasil"
        }).then(() => {
            window.location.href = "<?= base_url() ?>/latihan/hasillatihan_kecerdasan/99/" + jenis_id + "/" + level_id + "/" + used;
        });
    }

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        if (sec < 10) sec = "0" + sec;
        if (min < 10) min = "0" + min;
        return min + ":" + sec;
    }

    function countdown(detik) {
        var seconds = detik;
        timers = window.setInterval(function() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds <= 0) {
                window.clearInterval(timers);
                Swal.fire({
                    title: "Waktu Habis!",
                    text: "Waktu latihan telah berakhir.",
                    icon: "info"
                }).then(() => {
                    startujian("selesai");
                });
            }
        }, 1000);
    }
    </script>
</body>
</html>
