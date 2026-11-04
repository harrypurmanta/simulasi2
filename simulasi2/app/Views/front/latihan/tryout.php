<?php
$request = \Config\Services::request();
$session = \Config\Services::session();
$title = 'Latihan Soal Mandiri - Bintang Timur Prestasi';
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
        .jawaban_dv:hover {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
        }
        .jawaban_dv label,
        .jawaban_dv .pilihan-label,
        .jawaban_dv strong {
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-right: 6px !important;
            margin-bottom: 0 !important;
            cursor: pointer;
        }
        .jawaban_dv.selected-jawaban {
            background-color: #d1fae5 !important;
            border: 2.5px solid #059669 !important;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2) !important;
            color: #064e3b !important;
            font-weight: 600 !important;
        }
        .jawaban_dv.selected-jawaban label,
        .jawaban_dv.selected-jawaban .pilihan-label,
        .jawaban_dv.selected-jawaban strong {
            color: #047857 !important;
            font-weight: 800 !important;
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
                <!-- Tahapan Ujian & Waktu Timer -->
                <div class="row g-2 mb-2">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-2 px-3 bg-white h-100">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-layer-group me-1"></i> TAHAPAN LATIHAN
                                </span>
                            </div>
                            <div class="card bg-success text-white border-0 py-1 px-3 rounded-3 text-center shadow-sm" style="max-width: 250px;">
                                <div class="fw-bold small"><?= esc($jenis_nm->jenis_nm ?? 'Latihan') ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-2 px-3 text-center bg-white h-100 d-flex flex-column justify-content-center">
                            <span class="text-muted small fw-semibold mb-1">
                                <i class="fas fa-clock text-danger me-1"></i> Sisa Waktu Pengerjaan
                            </span>
                            <label class="display-6 fw-bold text-danger mb-0" id="countdown">00:00</label>
                        </div>
                    </div>
                </div>

                <!-- Soal & Pilihan Jawaban + Box Nomor Soal -->
                <div class="row g-2">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                            <div class="p-3 mb-3" style="background-color: #f8fafc; border: 2px solid #cbd5e1; border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-success rounded-pill px-3 py-1" id="p_no_soal" style="font-size: 15.5px; font-weight: 600; padding: 6px 16px;">Soal no. 1</span>
                                </div>
                                <div id="inp_soal_nm" class="text-dark mb-2" style="font-size: 1.15rem; line-height: 1.7; font-weight: 500;"></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                                <input type="hidden" id="inp_kolom_id">
                                <input type="hidden" id="used">
                            </div>

                            <div id="dv_main_jawaban" class="mb-3">
                                <!-- Jawaban dimuat melalui AJAX -->
                            </div>

                            <input type="hidden" value="" id="inp_jawaban_id">
                            <input type="hidden" value="" id="inp_pilihan_nm">

                            <div id="dv_button" class="mt-3">
                                <!-- Tombol navigasi soal -->
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 10px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-th me-2 text-success"></i> Navigasi Soal
                                </h6>
                            </div>
                            <div id="dv_boxnosoal" class="box-no-soal-grid">
                                <!-- Box nomor soal dimuat melalui AJAX -->
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

    var timers = null;
    var timerRunning = false;
    var currentJenisId = <?= (int) $request->getUri()->getSegment(4) ?>;
    var currentGroupId = <?= (int) $group_id ?>;
    var currentUserId = "<?= esc($session->user_id ?? 'guest') ?>";
    var timerStorageKey = "latihan_timer_" + currentUserId + "_" + currentJenisId + "_" + currentGroupId;

    function getDefaultDuration(grpId) {
        return (grpId == 1) ? 3600 : 2700;
    }

    function getSavedRemainingSeconds(defaultDetik) {
        try {
            var raw = localStorage.getItem(timerStorageKey);
            if (raw) {
                var parsed = JSON.parse(raw);
                if (parsed && typeof parsed.remaining === "number" && parsed.remaining > 0) {
                    var ageMs = Date.now() - (parsed.updatedAt || Date.now());
                    if (ageMs < 6 * 3600 * 1000) {
                        var elapsedSec = Math.floor(ageMs / 1000);
                        var rem = parsed.remaining - (elapsedSec > 0 && elapsedSec < 30 ? elapsedSec : 0);
                        if (rem > 0) return rem;
                    }
                }
            }
        } catch (e) {}
        return defaultDetik;
    }

    function saveRemainingSeconds(sec) {
        try {
            localStorage.setItem(timerStorageKey, JSON.stringify({
                remaining: sec,
                updatedAt: Date.now()
            }));
        } catch (e) {}
    }

    function clearSavedTimer() {
        try {
            localStorage.removeItem(timerStorageKey);
        } catch (e) {}
    }

    $(document).ready(function() {
        var initSec = getSavedRemainingSeconds(getDefaultDuration(currentGroupId));
        $("#countdown").text(convertSeconds(initSec));
        countdown(initSec);

        setTimeout(() => {
            startujian("start");
        }, 300);
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
        let jenis_id = <?= $request->getUri()->getSegment(4) ?>;
        let no_soal = $("#inp_no_soal").val();
        let pilihan_nm = $("#inp_pilihan_nm").val();
        let group_id = <?= $group_id ?>;
        let level_id = <?= !empty($level_id) ? (int)$level_id : ($request->getUri()->getSegment(5) ? (int)$request->getUri()->getSegment(5) : 'null') ?>;
        let materi = 99;
        let waktu = document.getElementById('countdown').textContent;
        let used =  $("#used").val();
        $.ajax({
            url: "<?= base_url('latihan/startujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "jenis_id": jenis_id,
                "level_id": level_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "group_id": group_id,
                "materi": materi,
                "proc": proc,
                "used": used,
                "waktu": waktu
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.proc == "selesai") {
                    clearSavedTimer();
                    Swal.fire({
                            title: "anda telah selesai mengerjakan Test, klik Ok untuk keluar",
                            icon: "info",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Terima Kasih",
                                    text: "Anda telah menyelesaikan tes ini",
                                    icon: "success"
                                });
                                updateFinishRespon(materi,jenis_id);
                                window.location.href = "<?= rtrim(base_url(), '/') ?>/latihan/hasillatihan/" + materi + "/" +jenis_id+"/"+used+"/" +group_id;
                            }
                        });

                    
                } else {
                    if (data == "jawaban_kosong") {
                        Swal.fire({
                            title: "Perhatian",
                            text: "Jawaban belum dipilih",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });
                    } else {
                        if (!timerRunning) {
                            var resumeSec = getSavedRemainingSeconds(getDefaultDuration(data.group_id));
                            countdown(resumeSec);
                        }

                        $("#inp_soal_id").val(data.soal_id);
                        $("#inp_soal_nm").text(data.soal_nm);
                        $("#p_no_soal").text("Soal no. " + data.no_soal);
                        $("#inp_group_id").val(data.group_id);
                        $("#inp_no_soal").val(data.no_soal);
                        $("#used").val(data.used);
                        $("#dv_main_jawaban").html(data.jawaban_nm);
                        $("#dv_boxnosoal").html(data.boxnomorsoal);
                        $("#dv_button").html(data.button);
                        $("#inp_jawaban_id").val("");
                        $("#inp_pilihan_nm").val("");
                        $("#dv_img_soal").html(data.img_soal);
                        setTimeout(() => {
                            if (data.jawaban_idx && data.jawaban_idx !== "") {
                                selectJawaban(data.jawaban_idx, data.pilihan_nms);
                            }
                        }, 10);
                    }
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

    function updateFinishRespon(materi_id,jenis_id) {
        $.ajax({
            url: "<?= base_url('latihan/updateFinishRespon') ?>",
            type: "post",
            dataType: "json",
            data: {
                "materi_id": materi_id,
                "jenis_id": jenis_id
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
                Swal.fire("Ada terjadi sesuatu, mohon hubungi administrator", "", "warning");
            }
        });
    }

    function convertSeconds(s) {
        if (s < 0) s = 0;
        var min = Math.floor(s / 60);
        var sec = s % 60;
        if (sec < 10) {
            sec = "0" + sec;
        }
        if (min < 10) {
            min = "0" + min;
        }
        return min + ":" + sec;
    }

    function countdown(detik) {
        if (timers) {
            window.clearInterval(timers);
        }
        timerRunning = true;
        var seconds = detik;
        var jenis_id = <?= $request->getUri()->getSegment(3) ?>;
        $("#countdown").text(convertSeconds(seconds));
        saveRemainingSeconds(seconds);

        timers = window.setInterval(function() {
            seconds--;
            if (seconds <= 0) {
                seconds = 0;
                $("#countdown").text("00:00");
                window.clearInterval(timers);
                timerRunning = false;
                clearSavedTimer();
                window.location.href = "<?= rtrim(base_url(), '/') ?>/latihan/hasillatihan/" + jenis_id;
            } else {
                $("#countdown").text(convertSeconds(seconds));
                saveRemainingSeconds(seconds);
            }
        }, 1000);
    }
    </script>
</body>

</html>