<?php
$request = \Config\Services::request();
$title = 'Pembahasan Latihan Soal - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>
        <div class="content-wrapper">
            <div class="container py-3">
                <!-- Tahapan Latihan -->
                <div class="row g-3 mb-3">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill fw-bold mb-2 align-self-start">
                                <i class="fas fa-search me-1"></i> REVIEW LATIHAN
                            </span>
                            <div class="card bg-success text-white border-0 p-2 rounded-3 text-center shadow-sm" style="max-width: 250px;">
                                <div class="fw-bold small"><?= esc($jenis_nm->jenis_nm ?? 'Latihan') ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 text-center bg-white h-100 d-flex flex-column justify-content-center">
                            <span class="text-muted small fw-semibold mb-1">
                                <i class="fas fa-info-circle text-primary me-1"></i> Mode Pembahasan
                            </span>
                            <span class="badge bg-info fs-6 px-3 py-2 rounded-pill">Tanpa Batas Waktu</span>
                        </div>
                    </div>
                </div>

                <!-- Soal & Pilihan Jawaban + Pembahasan -->
                <div class="row g-3">
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                            <div class="p-3 mb-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-success rounded-pill px-3 py-1" id="p_no_soal">Soal no. 1</span>
                                </div>
                                <div id="inp_soal_nm" class="fs-6 text-dark mb-2" style="line-height: 1.6;"></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                                <input type="hidden" id="inp_kolom_id">
                                <input type="hidden" id="used">
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
                                    <!-- Pembahasan -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 20px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-th me-2 text-success"></i> Navigasi Soal
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
        if (jawaban_id != "") {
            let dv = document.getElementsByClassName("jawaban_dv");
            for (let index = 0; index < dv.length; index++) {
                dv[index].style.border = "none";
            }
            $("#inp_jawaban_id").val(jawaban_id);
            $("#inp_pilihan_nm").val(pilihan_nm);
            document.getElementById("dv_jawaban_" + jawaban_id).style.border = "thick solid #00a65a";
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
        let materi = 99;
        let waktu = document.getElementById('countdown').textContent;
        let used =  <?= $request->getUri()->getSegment(5) ?>;
        $.ajax({
            url: "<?= base_url('latihan/startujianpembahasan') ?>",
            type: "post",
            dataType: "json",
            data: {
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "jenis_id": jenis_id,
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
                                window.location.href = "<?= rtrim(base_url(), '/') ?>/latihan/hasillatihan/" + materi + "/" +jenis_id+"/"+used;
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
                        if (data.no_soal == 1) {
                            window.clearInterval(timers);
                            // countdown(2700);
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
                            selectJawaban(data.jawaban_idx,data.pilihan_nms);
                        }, 10);
                        
                    }
                }
                let dv = document.getElementsByClassName("jawaban_dv");
                for (let index = 0; index < dv.length; index++) {
                    dv[index].style.border = "none";
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
        var jenis_id = <?= $request->getUri()->getSegment(3) ?>;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000); // every second

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds === 0) {
                window.location.href = "<?= rtrim(base_url(), '/') ?>/latihan/hasillatihan/" + jenis_id;
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>

</html>