<?php
$request = \Config\Services::request();
$title = 'Ujian Sikap Kerja - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>
        <div class="content-wrapper">
            <div class="container py-3">
                <!-- Tahapan Ujian & Waktu Timer -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-layer-group me-1"></i> TAHAPAN UJIAN
                                </span>
                            </div>
                            <input type="hidden" id="inp_group_id">
                            <div class="card bg-success text-white border-0 p-2 rounded-3 text-center shadow-sm" style="max-width: 250px;">
                                <div class="fw-bold small">Sikap Kerja (Kecermatan)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 text-center bg-white h-100 d-flex flex-column justify-content-center">
                            <span class="text-muted small fw-semibold mb-1">
                                <i class="fas fa-clock text-danger me-1"></i> Waktu Kolom
                            </span>
                            <label class="display-6 fw-bold text-danger mb-0" id="countdown">00:00</label>
                        </div>
                    </div>
                </div>

                <!-- Soal Sikap Kerja & Kolom -->
                <div class="row g-3 justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center">
                            <div class="mb-3">
                                <span class="badge bg-primary px-4 py-2 fs-6 rounded-pill" id="lb_kolom">Kolom</span>
                            </div>
                            <div id="dv_soal" class="col-12 mb-3" style="min-height: 400px;">
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
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/adminlte.min.js"></script>
    <script>
    var timers;
    $(document).ready(function() {
        setTimeout(() => {
            startujian("start","","","",4,0,1,98);
        }, 1000);
    });

    function startujian(proc,pilihan_nm,jawaban_id,soal_id,group_id,no_soal,kolom_id,materi) {
        $.ajax({
            url: "<?= base_url('sikapkerja/sikapkerjaujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "proc": proc,
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "group_id": group_id,
                "materi": materi,
                "kolom_id": kolom_id,
                "sk_group_id": <?= $request->getUri()->getSegment(3) ?>
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.no_soal == 1) {
                    window.clearInterval(timers);
                    $("#dv_soal").html(data.ret);
                    $("#lb_kolom").text("Kolom "+data.kolom);
                    countdown(61,kolom_id);
                } else if (data.ret == "persiapan") {
                    window.clearInterval(timers);
                    $("#lb_kolom").text("Persiapan . . .");
                    $("#dv_soal").html("");
                    countdown(6,kolom_id,data.ret);
                } else if (data.ret == "selesai") {
                    window.location.href = "<?= rtrim(base_url(), '/') ?>/sikapkerja/hasiltryout/" + <?= $request->getUri()->getSegment(3) ?> ;
                } else if (data == "soal_tidak_ada") {
                    alert("Soal tidak ada");
                } else {
                    $("#dv_soal").html(data.ret);
                    $("#lb_kolom").text("Kolom "+data.kolom);
                }
                
                // $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
                alert("Error system");
            }
        });
    }

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        if (sec < 10) {
            sec = "0"+sec;
        }

        if (min < 10) {
            min = "0"+min;
        }
        return min + ":" + sec;
    }


    function countdown(detik,kolom_id,proc) {
        var seconds = detik;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000); // every second

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds === 0) {
                window.clearInterval(timers);
                if (proc == "persiapan") {
                    kolom_id = kolom_id + 1;
                    startujian("nextkolom","","","",4,0,kolom_id,98);
                } else {
                    startujian("persiapan","","","",4,0,kolom_id,98);
                }
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>
</html>