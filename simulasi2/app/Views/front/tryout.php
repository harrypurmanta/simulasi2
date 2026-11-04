<?php
$request = \Config\Services::request();
$session = \Config\Services::session();
$title = 'Simulasi Tryout CAT - Bintang Timur Prestasi';
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
        .jawaban_dv .pilihan-label {
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-right: 4px !important;
            margin-bottom: 0 !important;
            flex-shrink: 0 !important;
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
        .jawaban_dv.selected-jawaban .pilihan-label {
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
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-layer-group me-1"></i> TAHAPAN UJIAN
                                </span>
                            </div>
                            <input type="hidden" id="inp_group_id">
                            <div class="row g-2">
                                <?php foreach ($group as $key) {
                                    $active = ($request->getUri()->getSegment(4) == $key->group_soal_id);
                                    echo "<div class='col-6 col-sm-4 col-md-3'>
                                            <div class='card text-center py-1 px-2 rounded-3 border transition-hover " . ($active ? 'bg-success text-white border-success shadow-sm' : 'bg-light text-muted border-light-subtle') . "'>
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
                                <i class="fas fa-clock text-danger me-1"></i> Sisa Waktu Ujian
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
                                    <span class="badge bg-primary rounded-pill px-3 py-1" id="p_no_soal" style="font-size: 15.5px; font-weight: 600; padding: 6px 16px;">Soal no. <?= $soal[0]->no_soal ?></span>
                                </div>
                                <div id="inp_soal_nm" class="text-dark mb-2" style="font-size: 1.15rem; line-height: 1.7; font-weight: 500;"><?= $soal[0]->soal_nm ?></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" value="<?= $soal[0]->soal_id ?>" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                                <input type="hidden" value="<?= $soal[0]->kolom_id ?>" id="inp_kolom_id">
                            </div>

                            <div id="dv_main_jawaban" class="mb-3">
                                <?php foreach ($jawaban as $key) { ?>
                                <div id="dv_jawaban_<?= $key->jawaban_id ?>"
                                    onclick="selectJawaban(<?= $key->jawaban_id ?>,'<?= $key->pilihan_nm ?>')"
                                    class="btn col-12 jawaban_dv">
                                    <strong class="pilihan-label"><?= $key->pilihan_nm ?>.</strong>
                                    <?php if (!empty($key->jawaban_nm)): ?>
                                        <span class="jawaban-text"><?= $key->jawaban_nm ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($key->jawaban_img)):
                                        $jwbInitUrl = base_url() . "/images/jawaban/materi/" . $soal[0]->materi . "/" . $key->jawaban_img . ".jpg";
                                    ?>
                                        <div class="d-inline-flex align-items-center">
                                            <img style="max-width:350px;height:100%;cursor:zoom-in;border-radius:6px;" src="<?= $jwbInitUrl ?>" data-large-src="<?= $jwbInitUrl ?>" data-fallback-src="<?= $jwbInitUrl ?>" class="jawaban-img popup-img-trigger" title="Klik untuk memperbesar gambar">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php } ?>
                            </div>

                            <input type="hidden" value="" id="inp_jawaban_id">
                            <input type="hidden" value="" id="inp_pilihan_nm">

                            <div id="dv_button" class="mt-3">
                                <!-- Tombol aksi navigasi soal dimuat dari AJAX -->
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 10px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-th me-2 text-primary"></i> Navigasi Soal
                                </h6>
                            </div>
                            <div id="dv_boxnosoal" class="box-no-soal-grid">
                                <!-- Nomor soal dimuat dari AJAX -->
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
    var currentMateri = <?= (int) $request->getUri()->getSegment(3) ?>;
    var currentGroup = <?= (int) $request->getUri()->getSegment(4) ?>;
    var currentUserId = "<?= esc($session->user_id ?? 'guest') ?>";
    var timerStorageKey = "tryout_timer_" + currentUserId + "_" + currentMateri + "_" + currentGroup;

    function getDefaultDuration(grpId) {
        if (grpId == 1) return 2700;
        if (grpId == 2) return 5400;
        if (grpId == 3) return 2700;
        if (grpId == 4) return 60;
        return 2700;
    }

    function getSavedRemainingSeconds(defaultDetik) {
        try {
            var raw = localStorage.getItem(timerStorageKey);
            if (raw) {
                var parsed = JSON.parse(raw);
                if (parsed && typeof parsed.remaining === "number" && parsed.remaining > 0) {
                    var ageMs = Date.now() - (parsed.updatedAt || Date.now());
                    // Valid jika sesi masih dalam 6 jam terakhir
                    if (ageMs < 6 * 3600 * 1000) {
                        var elapsedSec = Math.floor(ageMs / 1000);
                        var rem = parsed.remaining - (elapsedSec > 0 && elapsedSec < 30 ? elapsedSec : 0);
                        if (rem > 0) {
                            return rem;
                        }
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
        var initSec = getSavedRemainingSeconds(getDefaultDuration(currentGroup));
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
        let group_id = currentGroup;
        let no_soal = $("#inp_no_soal").val();
        let pilihan_nm = $("#inp_pilihan_nm").val();
        let kolom_id = $("#inp_kolom_id").val();
        let materi = currentMateri;
        let waktu = document.getElementById('countdown').textContent;
        $.ajax({
            url: "<?= base_url('tryout/startujian') ?>",
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
                "waktu": waktu
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.proc == "selesai") {
                    clearSavedTimer();
                    let grp_id = group_id + 1;
                    window.location.href = "<?= rtrim(base_url(), '/') ?>/materi/pilihanMateri/" + materi + "/" +
                        grp_id;
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
                        $("#inp_kolom_id").val(data.kolom_id);
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
        var group_id = currentGroup;
        var materi = currentMateri;
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
                let grp_id = group_id + 1;
                window.location.href = "<?= rtrim(base_url(), '/') ?>/materi/pilihanMateri/" + materi + "/" + grp_id;
            } else {
                $("#countdown").text(convertSeconds(seconds));
                saveRemainingSeconds(seconds);
            }
        }, 1000);
    }
    </script>
</body>

</html>