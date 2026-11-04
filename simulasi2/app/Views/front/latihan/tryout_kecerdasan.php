<?php
$title = 'Latihan Kecerdasan - Bintang Timur Prestasi';
$session = \Config\Services::session();
?>
<?= $this->include('front/template/head') ?>
<head>
    <style>
        #p_no_soal {
            font-size: 15px !important;
            font-weight: 600 !important;
            padding: 6px 16px !important;
            letter-spacing: 0.3px;
        }
        #inp_soal_nm {
            font-size: 1.15rem !important;
            line-height: 1.75 !important;
            font-weight: 500;
            color: #1e293b;
        }
        .jawaban_dv {
            margin-top: 4px !important;
            margin-bottom: 4px !important;
            padding: 10px 44px 10px 16px !important;
            background-color: #f8fafc !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 10px !important;
            text-align: left !important;
            transition: all 0.15s ease-in-out !important;
            position: relative !important;
            color: #1e293b !important;
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
            width: 100% !important;
            cursor: pointer !important;
        }
        .jawaban_dv:hover {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            transform: translateX(2px);
        }
        .jawaban_dv .pilihan-label,
        .jawaban_dv strong {
            font-weight: 800 !important;
            color: #0f172a !important;
            font-size: 1.05rem !important;
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
            font-size: 1.3rem;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
        }
        .jawaban_dv img {
            border-radius: 6px;
            cursor: zoom-in;
            transition: transform 0.2s ease;
        }
        .jawaban_dv img:hover {
            transform: scale(1.02);
        }
        .box-no-soal-grid {
            display: grid !important;
            grid-template-columns: repeat(5, 1fr) !important;
            gap: 6px !important;
            max-height: 222px !important;
            overflow-y: auto !important;
            padding: 4px !important;
            scrollbar-width: thin;
        }
        .box-no-soal-grid::-webkit-scrollbar {
            width: 5px;
        }
        .box-no-soal-grid::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        .box-no-soal-grid::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .box-no-soal-grid::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .box-no-item {
            height: 38px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            user-select: none;
        }
        .box-no-item:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1) !important;
        }
    </style>
</head>

<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper" style="padding-top: 8px !important; padding-bottom: 24px !important; background-color: #f4f6f9;">
            <div class="container" style="max-width: 1240px;">
                <!-- Top Bar Info & Timer -->
                <div class="row g-2 mb-2">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-brain me-1"></i> LATIHAN KECERDASAN
                                </span>
                                <span id="answered_stat" class="badge bg-light text-secondary border px-3 py-1 rounded-pill fw-semibold">
                                    <i class="fas fa-tasks me-1 text-primary"></i> Memuat...
                                </span>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <div class="badge bg-success text-white py-2 px-3 rounded-3 shadow-sm fs-6">
                                    <?= esc($jenis_nm->jenis_nm ?? 'Kecerdasan') ?>
                                </div>
                                <?php if (!empty($level_nm)): ?>
                                    <div class="badge bg-primary text-white py-2 px-3 rounded-3 shadow-sm fs-6">
                                        <?= esc($level_nm) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-2 px-3 text-center bg-white h-100 d-flex flex-column justify-content-center">
                            <span class="text-muted small fw-semibold mb-1">
                                <i class="fas fa-clock text-danger me-1"></i> Sisa Waktu Pengerjaan
                            </span>
                            <label class="display-6 fw-bold text-danger mb-0" id="countdown" style="font-size: 2.2rem; font-family: monospace; letter-spacing: 1px;">00:00</label>
                        </div>
                    </div>
                </div>

                <!-- Main Exam Area -->
                <div class="row g-2">
                    <!-- Left Area: Question & Choices (col-12 col-lg-8) -->
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
                            <!-- Question Box -->
                            <div class="p-3 mb-3" style="background-color: #f8fafc; border: 2px solid #cbd5e1; border-radius: 12px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary rounded-pill px-3 py-1" id="p_no_soal">
                                        Soal no. 1
                                    </span>
                                    <span id="progress_text" class="text-muted small fw-semibold"></span>
                                </div>
                                <div id="inp_soal_nm" class="mb-2"></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                                <input type="hidden" id="used" value="">
                            </div>

                            <!-- Choices Container -->
                            <div id="dv_main_jawaban" class="d-flex flex-column gap-2 mb-3">
                                <!-- Options injected via AJAX -->
                            </div>
                            <input type="hidden" value="" id="inp_jawaban_id">
                            <input type="hidden" value="" id="inp_pilihan_nm">

                            <!-- Action Buttons -->
                            <div id="dv_button" class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                                <!-- Buttons injected via AJAX -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Area: Box Nomor Soal (col-12 col-lg-4) -->
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 15px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-th me-2 text-primary"></i> Navigasi Nomor Soal
                                </h6>
                                <span class="badge bg-light text-muted border small">5 per baris</span>
                            </div>

                            <div>
                                <div id="dv_boxnosoal" class="box-no-soal-grid mb-3">
                                    <!-- 5 Box per baris injected via AJAX -->
                                </div>
                            </div>

                            <!-- Legend -->
                            <div class="pt-2 border-top d-flex justify-content-around text-muted small" style="font-size: 11.5px;">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="display:inline-block; width:13px; height:13px; background:#e8f8e8; border:2px solid #3cce3c; border-radius:3px;"></span>
                                    <span>Dijawab</span>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <span style="display:inline-block; width:13px; height:13px; background:#ffffff; border:2px solid #f87171; border-radius:3px;"></span>
                                    <span>Belum</span>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <span style="display:inline-block; width:13px; height:13px; background:#d0e2ff; border:2.5px solid #2a5298; border-radius:3px;"></span>
                                    <span>Aktif</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none" id='loader-wrapper'>
            <div class="loader"></div>
        </div>
        <?= $this->include('front/footer') ?>
    </div>

    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="<?= base_url() ?>/dist/js/sweetalert2.js"></script>

    <script>
    // Popup Image Zoom Modal
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
    var jenis_id = <?= (int)$jenis_id ?>;
    var level_id = <?= (int)$level_id ?>;
    var total_soal_count = 0;
    var currentUserId = "<?= esc($session->user_id ?? 'guest') ?>";
    var timerStorageKey = "latihan_timer_kecerdasan_" + currentUserId + "_" + jenis_id + "_" + level_id;

    function getSavedRemainingSeconds(defaultDetik) {
        try {
            var raw = localStorage.getItem(timerStorageKey);
            if (raw) {
                var parsed = JSON.parse(raw);
                if (parsed && typeof parsed.remaining === "number" && parsed.remaining > 0) {
                    var ageMs = Date.now() - (parsed.updatedAt || Date.now());
                    if (ageMs < 4 * 3600 * 1000) {
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
        startujian("start");
    });

    function selectJawaban(jawaban_id, pilihan_nm) {
        if (jawaban_id != "") {
            $(".jawaban_dv").removeClass("selected-jawaban");
            $("#inp_jawaban_id").val(jawaban_id);
            $("#inp_pilihan_nm").val(pilihan_nm);
            let $active = $("#dv_jawaban_" + jawaban_id);
            if ($active.length) {
                $active.addClass("selected-jawaban");
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

                // Inisialisasi timer di awal dengan localStorage persistence
                if (proc == "start" && timers === null) {
                    var remaining = getSavedRemainingSeconds(2700);
                    countdown(remaining);
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

                // Auto scroll ke nomor soal yang aktif agar selalu terlihat dalam 5 baris
                setTimeout(() => {
                    let activeBox = document.querySelector("#dv_boxnosoal .box-no-item[style*='#2a5298'], #dv_boxnosoal .box-item-active");
                    if (activeBox) {
                        activeBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                }, 40);
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
        clearSavedTimer();
        Swal.fire({
            title: "Latihan Selesai!",
            text: "Terima kasih, Anda telah menyelesaikan latihan soal kecerdasan ini.",
            icon: "success",
            confirmButtonText: "Lihat Hasil"
        }).then(() => {
            window.location.href = "<?= rtrim(base_url(), '/') ?>/latihan/hasillatihan_kecerdasan/99/" + jenis_id + "/" + level_id + "/" + used;
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
        $("#countdown").text(convertSeconds(seconds));
        saveRemainingSeconds(seconds);

        timers = window.setInterval(function() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            saveRemainingSeconds(seconds);

            if (seconds <= 0) {
                window.clearInterval(timers);
                clearSavedTimer();
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
