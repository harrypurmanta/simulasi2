<?php
$request = \Config\Services::request();
$title = 'Pembahasan Soal Tryout - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<head>
    <style>
        #p_no_soal {
            font-size: 15.5px !important;
            font-weight: 600 !important;
            padding: 6px 16px !important;
            letter-spacing: 0.3px;
        }
        #inp_soal_nm {
            font-size: 1.15rem !important;
            line-height: 1.7 !important;
            font-weight: 500;
        }
        .jawaban_dv {
            margin-top: 4px !important;
            margin-bottom: 4px !important;
            padding: 9px 42px 9px 14px !important;
            background-color: #f8fafc !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 8px !important;
            text-align: left !important;
            transition: all 0.15s ease-in-out !important;
            position: relative !important;
            color: #1e293b !important;
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .jawaban_dv.selected-jawaban {
            background-color: #d1fae5 !important;
            border: 2.5px solid #059669 !important;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2) !important;
            color: #064e3b !important;
            font-weight: 600 !important;
        }
        .jawaban_dv.selected-jawaban::after {
            content: "\f058";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #059669;
            font-size: 1.25rem;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</head>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>
        <div class="content-wrapper" style="padding-top: 8px !important; padding-bottom: 20px !important;">
            <div class="container pt-0 pb-3">
                <!-- Tahapan Ujian -->
                <div class="row g-2 mb-2">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-2 px-3 bg-white h-100">
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill fw-bold mb-1 align-self-start">
                                <i class="fas fa-search me-1"></i> REVIEW TAHAPAN
                            </span>
                            <input type="hidden" id="inp_group_id">
                            <div class="row g-2">
                                <?php foreach ($group as $key) {
                                    $active = ($request->getUri()->getSegment(4) == $key->group_soal_id);
                                    echo "<div class='col-6 col-sm-4 col-md-3'>
                                            <div class='card text-center py-1 px-2 rounded-3 border " . ($active ? 'bg-success text-white border-success shadow-sm' : 'bg-light text-muted border-light-subtle') . "'>
                                                <div class='small fw-bold'>" . esc($key->group_nm) . "</div>
                                            </div>
                                          </div>";
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-2 px-3 text-center bg-white h-100 d-flex flex-column justify-content-center">
                            <span class="text-muted small fw-semibold mb-1">
                                <i class="fas fa-info-circle text-primary me-1"></i> Mode Pembahasan
                            </span>
                            <span class="badge bg-info fs-6 px-3 py-2 rounded-pill">Tanpa Batas Waktu</span>
                        </div>
                    </div>
                </div>

                <!-- Soal & Pilihan Jawaban + Pembahasan -->
                <div class="row g-2">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                            <div class="p-3 mb-3" style="background-color: #f8fafc; border: 2px solid #cbd5e1; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary rounded-pill px-3 py-1" id="p_no_soal" style="font-size: 15.5px; font-weight: 600; padding: 6px 16px;">Soal no. <?= $soal[0]->no_soal ?></span>
                                </div>
                                <div id="inp_soal_nm" class="text-dark mb-2" style="font-size: 1.15rem; line-height: 1.7; font-weight: 500;"></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" value="<?= $soal[0]->soal_id ?>" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                                <input type="hidden" value="<?= $used ?>" id="inp_used">
                                <input type="hidden" value="<?= $soal[0]->kolom_id ?>" id="inp_kolom_id">
                            </div>

                            <div id="dv_main_jawaban" class="mb-3">
                                <!-- Jawaban dimuat via AJAX -->
                            </div>

                            <input type="hidden" value="" id="inp_jawaban_id">
                            <input type="hidden" value="" id="inp_pilihan_nm">

                            <div class="row g-3 align-items-center mt-2">
                                <div class="col-12 col-md-5" id="dv_button">
                                    <!-- Tombol navigasi soal -->
                                </div>
                                <div class="col-12 col-md-7" id="dv_pembahasan">
                                    <!-- Gambar/teks pembahasan -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 10px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-th me-2 text-info"></i> Daftar Soal
                                </h6>
                            </div>
                            <div id="dv_boxnosoal" class="box-no-soal-grid">
                                <!-- Nomor soal dimuat via AJAX -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none" id='loader-wrapper'>
            <div class="loader"></div>
        </div>
    </div>
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="<?= base_url() ?>/dist/js/sweetalert2.js"></script>
    <script>
    function showImagePopup(largeUrl, fallbackUrl) {
        var safeFallback = fallbackUrl || largeUrl;
        Swal.fire({
            html: '<div style="padding:4px;"><img src="' + largeUrl + '" onerror="if(this.src!==\'' + safeFallback + '\'){this.src=\'' + safeFallback + '\';}" style="max-width:100%; max-height:80vh; width:auto; height:auto; object-fit:contain; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);" alt="Detail Gambar"></div>',
            width: 'auto',
            padding: '1rem',
            background: '#ffffff',
            showConfirmButton: false,
            showCloseButton: true,
            backdrop: 'rgba(15, 23, 42, 0.75)'
        });
    }

    $(document).on('click', '[data-toggle="lightbox"], #dv_img_soal img, .jawaban_dv img, .popup-img-trigger', function(event) {
        event.preventDefault();
        var $el = $(this);
        var $anchor = $el.closest('a[data-toggle="lightbox"]');
        var fallbackUrl = $el.attr('data-fallback-src') || ($el.is('img') ? $el.attr('src') : ($el.find('img').attr('src') || $el.attr('href')));
        var largeUrl = $el.attr('data-large-src') || ($anchor.length ? $anchor.attr('href') : ($el.attr('href') || fallbackUrl));
        if (largeUrl) {
            showImagePopup(largeUrl, fallbackUrl);
        }
    });

    var timers;
    $(document).ready(function() {
        setTimeout(() => {
            startujian("start");
        }, 1000);
    });

    function selectJawaban(jawaban_id, pilihan_nm) {
        let dv = document.getElementsByClassName("jawaban_dv");
        for (let index = 0; index < dv.length; index++) {
            dv[index].classList.remove("selected-jawaban");
        }
        if (jawaban_id && jawaban_id !== "" && jawaban_id !== "null") {
            $("#inp_jawaban_id").val(jawaban_id);
            $("#inp_pilihan_nm").val(pilihan_nm);
            let el = document.getElementById("dv_jawaban_" + jawaban_id);
            if (el) {
                el.classList.add("selected-jawaban");
            }
        }
    }

    function setboxsoal(no_soal) {
        no_soalx = no_soal + 1;
        $("#inp_no_soal").val(no_soal);
        $("#p_no_soal").text("Soal no. " + no_soal);
        startujian("prev");
    }

    function startujian(proc) {
        let soal_id = $("#inp_soal_id").val();
        let jawaban_id = $("#inp_jawaban_id").val();
        let group_id = <?= $request->getUri()->getSegment(4) ?>;
        let no_soal = $("#inp_no_soal").val();
        let pilihan_nm = $("#inp_pilihan_nm").val();
        let kolom_id = $("#inp_kolom_id").val();
        let used = $("#inp_used").val();
        let materi = <?= $request->getUri()->getSegment(3) ?>;
        $.ajax({
            url: "<?= base_url('pembahasan/startujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "group_id": group_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "kolom_id": kolom_id,
                "materi": materi,
                "proc": proc,
                "used" : used
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.proc == "selesai") {
                    if (group_id == 3) {
                        window.location.href = "<?= rtrim(base_url(), '/') ?>/pembahasan/hasil/" + materi+ "/" +
                        used;
                    } else {
                        let grp_id = group_id + 1;
                    window.location.href = "<?= rtrim(base_url(), '/') ?>/pembahasan/pilihanmateri/" + materi + "/" +
                        grp_id;
                    }
                    
                } else {
                    if (data == "jawaban_kosong") {
                        Swal.fire({
                            title: "Perhatian",
                            text: "Jawaban belum dipilih",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });
                    } else {
                        if (data.group_id == 1 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(2700);
                        } else if (data.group_id == 2 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(5400);
                        } else if (data.group_id == 3 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(2700);
                        } else if (data.group_id == 4 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(60);
                        }

                        $("#inp_soal_id").val(data.soal_id);
                        $("#inp_soal_nm").text(data.soal_nm);
                        $("#p_no_soal").text("Soal no. " + data.no_soal);
                        $("#inp_group_id").val(data.group_id);
                        $("#inp_no_soal").val(data.no_soal);
                        $("#inp_kolom_id").val(data.kolom_id);
                        $("#dv_main_jawaban").html(data.jawaban_nm);
                        $("#dv_boxnosoal").html(data.boxnomorsoal);
                        $("#dv_button").html(data.button);
                        $("#dv_pembahasan").html(data.pembahasan);
                        $("#inp_jawaban_id").val("");
                        $("#inp_pilihan_nm").val("");
                        $("#dv_img_soal").html(data.img_soal);
                        setTimeout(() => {
                            if (data.jawaban_idx && data.jawaban_idx !== "") {
                                selectJawaban(data.jawaban_idx, data.pilihan_nms);
                            }
                        }, 10);
                        
                    }

                    // $("#loader-wrapper").addClass("d-none");

                }
            },
            error: function() {
                Swal.fire({
                    title: "Error",
                    text: "Error system",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    }

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        return min + ":" + sec;
    }


    function countdown(detik) {
        var seconds = detik;
        var group_id = <?= $request->getUri()->getSegment(4) ?>;
        var materi = <?= $request->getUri()->getSegment(3) ?>;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000); // every second

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds === 0) {
                let grp_id = group_id + 1;
                window.location.href = "<?= rtrim(base_url(), '/') ?>/pembahasan/pilihanMateri/" + materi + "/" + grp_id;
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>

</html>