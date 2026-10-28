<?php
$request = \Config\Services::request();
$title = 'Simulasi Tryout CAT - Bintang Timur Prestasi';
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
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-layer-group me-1"></i> TAHAPAN UJIAN
                                </span>
                            </div>
                            <input type="hidden" id="inp_group_id">
                            <div class="row g-2">
                                <?php foreach ($group as $key) {
                                    $active = ($request->getUri()->getSegment(4) == $key->group_soal_id);
                                    echo "<div class='col-6 col-sm-4 col-md-3'>
                                            <div class='card text-center p-2 rounded-3 border transition-hover " . ($active ? 'bg-success text-white border-success shadow-sm' : 'bg-light text-muted border-light-subtle') . "'>
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
                                <i class="fas fa-clock text-danger me-1"></i> Sisa Waktu Ujian
                            </span>
                            <label class="display-6 fw-bold text-danger mb-0" id="countdown">00:00</label>
                        </div>
                    </div>
                </div>

                <!-- Soal & Pilihan Jawaban + Box Nomor Soal -->
                <div class="row g-3">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                            <div class="p-3 mb-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary rounded-pill px-3 py-1" id="p_no_soal">Soal no. <?= $soal[0]->no_soal ?></span>
                                </div>
                                <div id="inp_soal_nm" class="fs-6 text-dark mb-2" style="line-height: 1.6;"><?= $soal[0]->soal_nm ?></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" value="<?= $soal[0]->soal_id ?>" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                                <input type="hidden" value="<?= $soal[0]->kolom_id ?>" id="inp_kolom_id">
                            </div>

                            <div id="dv_main_jawaban" class="mb-3">
                                <?php foreach ($jawaban as $key) { ?>
                                <div id="dv_jawaban_<?= $key->jawaban_id ?>"
                                    onclick="selectJawaban(<?= $key->jawaban_id ?>,'<?= $key->pilihan_nm ?>')"
                                    class="btn w-100 jawaban_dv text-start p-3 mb-2 rounded-3 border"
                                    style="background-color: #f8fafc;">
                                    <span class="badge bg-secondary me-2"><?= $key->pilihan_nm ?>.</span>
                                    <span class="text-dark"><?= $key->jawaban_nm ?></span>
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
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 20px; z-index: 10;">
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
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
            wrapping: false
        });
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
            dv[index].style.border = "none";
        }
        $("#inp_jawaban_id").val(jawaban_id);
        $("#inp_pilihan_nm").val(pilihan_nm);
        document.getElementById("dv_jawaban_" + jawaban_id).style.border = "thick solid #00a65a";
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
        let materi = <?= $request->getUri()->getSegment(3) ?>;
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
                    let grp_id = group_id + 1;
                    window.location.href = "<?= base_url() ?>/materi/pilihanMateri/" + materi + "/" +
                        grp_id;
                } else {
                    if (data == "jawaban_kosong") {
                        alert("Jawaban belum dipilih");
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
                        $("#inp_jawaban_id").val("");
                        $("#inp_pilihan_nm").val("");
                        $("#dv_img_soal").html(data.img_soal);
                        setTimeout(() => {
                            selectJawaban(data.jawaban_idx,data.pilihan_nms);
                        }, 10);
                        
                    }

                    // $("#loader-wrapper").addClass("d-none");

                }


                let dv = document.getElementsByClassName("jawaban_dv");
                for (let index = 0; index < dv.length; index++) {
                    dv[index].style.border = "none";
                }


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
                window.location.href = "<?= base_url() ?>/materi/pilihanMateri/" + materi + "/" + grp_id;
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>

</html>