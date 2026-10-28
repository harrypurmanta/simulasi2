<?php
$request = \Config\Services::request();
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
                            <div class="row g-2">
                                <?php foreach ($group as $key) {
                                    $active = ($request->getUri()->getSegment(4) == $key->group_soal_id);
                                    echo "<div class='col-6 col-sm-4 col-md-3'>
                                            <div class='card text-center p-2 rounded-3 border " . ($active ? 'bg-success text-white border-success shadow-sm' : 'bg-light text-muted border-light-subtle') . "'>
                                                <div class='small fw-bold'>" . esc($key->group_nm) . "</div>
                                            </div>
                                          </div>";
                                } ?>
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
    <?= view('front/template/scriptjs'); ?>
    <script>
    var timers;
    $(document).ready(function() {
        setTimeout(() => {
            startujian("start","","","",<?= $request->getUri()->getSegment(4) ?>,0,1,<?= $request->getUri()->getSegment(3) ?>);
        }, 1000);
    });


    function startujian(proc,pilihan_nm,jawaban_id,soal_id,group_id,no_soal,kolom_id,materi) {
        $.ajax({
            url: "<?= base_url('tryout/sikapkerjaujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "proc": proc,
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "group_id": <?= $request->getUri()->getSegment(4) ?>,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "kolom_id": kolom_id,
                "materi": <?= $request->getUri()->getSegment(3) ?>
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
                    window.location.href = "<?= base_url() ?>/tryout/hasiltryout/" + materi;
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
        var group_id = <?= $request->getUri()->getSegment(4) ?>;
        var materi = <?= $request->getUri()->getSegment(3) ?>;
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
                    startujian("nextkolom","","","",group_id,0,kolom_id,materi);
                } else {
                    startujian("persiapan","","","",group_id,0,kolom_id,materi);
                }
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>

</html>