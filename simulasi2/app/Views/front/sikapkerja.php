<?php
$request = \Config\Services::request();
$session = \Config\Services::session();
?>
<?= view('front/template/head'); ?>
    <style>
    .d-none {
        display: none !important;
    }

    #loader-wrapper {
        display: flex;
        position: fixed;
        z-index: 1060;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        padding: 0.625em;
        overflow-x: hidden;
        transition: background-color 0.1s;
        background-color: rgb(253 253 253 / 58%);
        -webkit-overflow-scrolling: touch;
    }

    .loader {
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 10px solid #3af3f5;
        border-bottom: 10px solid #3abcec;
        width: 50px;
        height: 50px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        margin: 1.75rem auto;
    }



    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-o-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-ms-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>
        <div class="content-wrapper" style="padding-top: 8px !important; padding-bottom: 20px !important;">
            <div class="container pt-0 pb-3">
                <!-- Tahapan Ujian & Waktu Timer -->
                <div class="row g-2 mb-2">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-2 px-3 bg-white h-100">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-layer-group me-1"></i> TAHAPAN UJIAN
                                </span>
                            </div>
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
                                <i class="fas fa-clock text-danger me-1"></i> Waktu Kolom
                            </span>
                            <label class="display-6 fw-bold text-danger mb-0" id="countdown">00:00</label>
                        </div>
                    </div>
                </div>

                <!-- Soal Sikap Kerja & Kolom -->
                <div class="row g-2 justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white text-center">
                            <div class="mb-2">
                                <span class="badge bg-primary px-4 py-2 fs-6 rounded-pill" id="lb_kolom">Kolom</span>
                            </div>
                            <div id="dv_soal" class="col-12 mb-2" style="min-height: 380px;">
                                <!-- Soal sikap kerja dimuat via AJAX -->
                            </div>
                            <div id="dv_button" class="mt-2">
                                <!-- Tombol aksi jika ada -->
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
    <?= view('front/template/scriptjs'); ?>
    <script>
    var timers = null;
    var retryTimeout = null;
    var currentMateri = <?= (int) $request->getUri()->getSegment(3) ?>;
    var currentGroup = <?= (int) $request->getUri()->getSegment(4) ?>;
    var currentUserId = "<?= esc($session->user_id ?? 'guest') ?>";
    var skStorageKey = "sk_tryout_state_" + currentUserId + "_" + currentMateri + "_" + currentGroup;

    var currentSeconds = 60;
    var currentKolomId = 1;
    var currentNoSoal = 1;
    var currentMode = "ujian"; // "ujian" | "persiapan"

    function getSavedSKState() {
        try {
            var raw = localStorage.getItem(skStorageKey);
            if (raw) {
                var parsed = JSON.parse(raw);
                if (parsed && typeof parsed.kolom_id === "number") {
                    var ageMs = Date.now() - (parsed.updatedAt || Date.now());
                    if (ageMs < 6 * 3600 * 1000) {
                        var elapsedSec = Math.floor(ageMs / 1000);
                        var rem = (typeof parsed.remaining === "number") ? parsed.remaining : 60;
                        if (elapsedSec > 0 && elapsedSec < 15) {
                            rem = Math.max(0, rem - elapsedSec);
                        }
                        parsed.remaining = rem;
                        return parsed;
                    }
                }
            }
        } catch (e) {}
        return null;
    }

    function saveSKState() {
        try {
            localStorage.setItem(skStorageKey, JSON.stringify({
                remaining: currentSeconds,
                kolom_id: currentKolomId,
                no_soal: currentNoSoal,
                mode: currentMode,
                updatedAt: Date.now()
            }));
        } catch (e) {}
    }

    function clearSavedSKState() {
        try {
            localStorage.removeItem(skStorageKey);
        } catch (e) {}
    }

    $(document).ready(function() {
        var saved = getSavedSKState();
        if (saved) {
            currentKolomId = saved.kolom_id || 1;
            currentNoSoal = saved.no_soal || 1;
            currentMode = saved.mode || "ujian";
            currentSeconds = (typeof saved.remaining === "number") ? saved.remaining : 60;

            if (currentMode === "persiapan") {
                $("#lb_kolom").text("Persiapan . . .");
                $("#dv_soal").html("");
                var prepSec = currentSeconds > 0 ? currentSeconds : 6;
                $("#countdown").text(convertSeconds(prepSec));
                countdown(prepSec, currentKolomId, "persiapan");
            } else if (currentSeconds <= 0) {
                $("#countdown").text("00:00");
                startujian("persiapan", "", "", "", currentGroup, 0, currentKolomId, currentMateri);
            } else {
                $("#countdown").text(convertSeconds(currentSeconds));
                countdown(currentSeconds, currentKolomId, "ujian");
                setTimeout(() => {
                    startujian("resume", "", "", "", currentGroup, Math.max(0, currentNoSoal - 1), currentKolomId, currentMateri);
                }, 200);
            }
        } else {
            setTimeout(() => {
                startujian("start", "", "", "", currentGroup, 0, 1, currentMateri);
            }, 300);
        }
    });

    function startujian(proc, pilihan_nm, jawaban_id, soal_id, group_id, no_soal, kolom_id, materi) {
        if (retryTimeout) {
            clearTimeout(retryTimeout);
            retryTimeout = null;
        }

        var countdownText = $("#countdown").text().trim();
        // Jika waktu sudah 00:00 (misal karena koneksi sempat terputus) dan user menekan tombol pilihan jawaban,
        // langsung arahkan ke tahap persiapan dan kolom selanjutnya
        if (proc === "next" && (currentSeconds <= 0 || countdownText === "00:00")) {
            proc = "persiapan";
            pilihan_nm = "";
            jawaban_id = "";
            soal_id = "";
            no_soal = 0;
        }

        $.ajax({
            url: "<?= base_url('tryout/sikapkerjaujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "proc": proc,
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "group_id": currentGroup,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "kolom_id": kolom_id,
                "materi": currentMateri
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.ret == "persiapan") {
                    if (timers) window.clearInterval(timers);
                    currentKolomId = parseInt(data.kolom || kolom_id, 10);
                    currentMode = "persiapan";
                    $("#lb_kolom").text("Persiapan . . .");
                    $("#dv_soal").html("");
                    countdown(6, currentKolomId, "persiapan");
                } else if (data.ret == "selesai") {
                    if (timers) window.clearInterval(timers);
                    clearSavedSKState();
                    window.location.href = "<?= rtrim(base_url(), '/') ?>/tryout/hasiltryout/" + currentMateri;
                } else if (data.ret == "soal_tidak_ada" || data == "soal_tidak_ada") {
                    Swal.fire({ title: "Perhatian", text: "Soal tidak ada", icon: "warning", confirmButtonText: "OK" });
                } else if (data.no_soal == 1) {
                    currentKolomId = parseInt(data.kolom || kolom_id, 10);
                    currentNoSoal = 1;
                    currentMode = "ujian";
                    $("#dv_soal").html(data.ret);
                    $("#lb_kolom").text("Kolom " + currentKolomId);
                    if (proc !== "resume") {
                        if (timers) window.clearInterval(timers);
                        countdown(61, currentKolomId, "ujian");
                    } else {
                        saveSKState();
                    }
                } else {
                    currentKolomId = parseInt(data.kolom || kolom_id, 10);
                    currentNoSoal = parseInt(data.no_soal || (no_soal + 1), 10);
                    currentMode = "ujian";
                    $("#dv_soal").html(data.ret);
                    $("#lb_kolom").text("Kolom " + currentKolomId);
                    saveSKState();
                }
            },
            error: function() {
                if (proc === "persiapan" || proc === "nextkolom") {
                    // Otomatis coba lagi ketika koneksi pulih
                    retryTimeout = setTimeout(function() {
                        startujian(proc, "", "", "", currentGroup, 0, kolom_id, currentMateri);
                    }, 3000);
                } else {
                    Swal.fire({ title: "Error", text: "Koneksi terputus. Silakan periksa jaringan Anda dan coba lagi.", icon: "error", confirmButtonText: "OK" });
                }
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

    function countdown(detik, kolom_id, proc) {
        if (timers) {
            window.clearInterval(timers);
        }
        var seconds = detik;
        currentSeconds = seconds;
        currentKolomId = parseInt(kolom_id, 10) || currentKolomId;
        currentMode = (proc === "persiapan") ? "persiapan" : "ujian";
        saveSKState();

        var group_id = currentGroup;
        var materi = currentMateri;
        timers = window.setInterval(function() {
            seconds--;
            if (seconds < 0) seconds = 0;
            currentSeconds = seconds;
            $("#countdown").text(convertSeconds(seconds));
            saveSKState();

            if (seconds <= 0) {
                window.clearInterval(timers);
                if (proc == "persiapan") {
                    var nextKolom = currentKolomId + 1;
                    startujian("nextkolom", "", "", "", group_id, 0, nextKolom, materi);
                } else {
                    startujian("persiapan", "", "", "", group_id, 0, currentKolomId, materi);
                }
            }
        }, 1000);
    }
    </script>
</body>

</html>