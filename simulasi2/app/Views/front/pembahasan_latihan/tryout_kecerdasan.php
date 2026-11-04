<?php
$title = 'Pembahasan Latihan Kecerdasan - Bintang Timur Prestasi';
$session = \Config\Services::session();
?>
<?= $this->include('front/template/head') ?>
<head>
    <style>
        .exam-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04), 0 2px 6px -1px rgba(15, 23, 42, 0.02) !important;
            border-radius: 16px !important;
        }
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
        .soal-box-container {
            background-color: #ffffff !important;
            border: 1.5px solid #edf2f7 !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02) !important;
        }
        .jawaban_dv {
            margin-top: 4px !important;
            margin-bottom: 4px !important;
            padding: 12px 18px !important;
            background-color: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
        }
        .jawaban_dv img {
            border-radius: 6px;
            cursor: zoom-in;
            transition: transform 0.2s ease;
        }
        .jawaban_dv img:hover {
            transform: scale(1.02);
        }
        /* 5 Kolom Kebawah */
        #dv_boxnosoal, .box-no-soal-grid {
            display: grid !important;
            grid-template-columns: repeat(5, 1fr) !important;
            gap: 4px !important;
            padding: 4px !important;
            max-height: 480px !important;
            overflow-y: auto !important;
            scrollbar-width: thin;
        }
        #dv_boxnosoal::-webkit-scrollbar, .box-no-soal-grid::-webkit-scrollbar {
            width: 5px;
        }
        #dv_boxnosoal::-webkit-scrollbar-track, .box-no-soal-grid::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 4px;
        }
        #dv_boxnosoal::-webkit-scrollbar-thumb, .box-no-soal-grid::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        #dv_boxnosoal::-webkit-scrollbar-thumb:hover, .box-no-soal-grid::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .box-no-item {
            height: 35px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            user-select: none;
            box-sizing: border-box !important;
        }
        .box-no-item:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        }
        @media (max-width: 991.98px) {
            #dv_boxnosoal, .box-no-soal-grid {
                grid-template-columns: repeat(5, 1fr) !important;
                gap: 5px !important;
                max-height: 280px !important;
            }
            .box-no-item {
                height: 34px !important;
                font-size: 11px !important;
            }
        }
    </style>
</head>

<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper" style="padding-top: 10px !important; padding-bottom: 24px !important; background-color: #f8fafc;">
            <div class="container" style="max-width: 1280px;">
                <!-- Top Bar Info -->
                <div class="row g-2 mb-2">
                    <div class="col-12 col-lg-9">
                        <div class="card exam-card p-3 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold">
                                    <i class="fas fa-brain me-1"></i> PEMBAHASAN LATIHAN KECERDASAN
                                </span>
                                <span id="answered_stat" class="badge bg-white text-secondary border px-3 py-1 rounded-pill fw-semibold shadow-xs">
                                    <i class="fas fa-book-reader me-1 text-primary"></i> Mode Pembahasan
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
                    <div class="col-12 col-lg-3">
                        <div class="card exam-card p-2 px-3 text-center h-100 d-flex flex-column justify-content-center">
                            <span class="text-muted small fw-semibold mb-1" style="font-size: 12px;">
                                <i class="fas fa-info-circle text-info me-1"></i> Status Ujian
                            </span>
                            <span class="badge bg-info bg-opacity-10 text-primary border border-info border-opacity-25 py-2 px-3 rounded-pill fw-bold" style="font-size: 0.95rem;">
                                Selesai Dikerjakan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Main Discussion Area -->
                <div class="row g-2">
                    <!-- Left Area: Question, Choices & Pembahasan (col-12 col-lg-9) -->
                    <div class="col-12 col-lg-9">
                        <div class="card exam-card p-3 p-md-4">
                            <!-- Question Box -->
                            <div class="p-3 mb-3 soal-box-container">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary rounded-pill px-3 py-1" id="p_no_soal">
                                        Soal no. 1
                                    </span>
                                    <span id="user_choice_badge"></span>
                                </div>
                                <div id="inp_soal_nm" class="mb-2"></div>
                                <div id="dv_img_soal" class="text-center my-2"></div>
                                <input type="hidden" id="inp_soal_id">
                                <input type="hidden" value="1" id="inp_no_soal">
                            </div>

                            <!-- Choices Container -->
                            <div id="dv_main_jawaban" class="d-flex flex-column gap-2 mb-3">
                                <!-- Pilihan jawaban dimuat melalui AJAX -->
                            </div>

                            <!-- Pembahasan Container -->
                            <div id="dv_pembahasan_box" class="mb-3">
                                <!-- Penjelasan & Pembahasan dimuat melalui AJAX -->
                            </div>

                            <!-- Action Buttons -->
                            <div id="dv_button" class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                                <!-- Tombol aksi navigasi dimuat melalui AJAX -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Area: Box Nomor Soal (col-12 col-lg-3) -->
                    <div class="col-12 col-lg-3">
                        <div class="card exam-card p-2 p-md-3 sticky-lg-top" style="top: 15px; z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fas fa-th me-2 text-primary"></i> Navigasi Soal
                                </h6>
                                <span class="badge bg-light text-primary border small fw-semibold">5 Kolom</span>
                            </div>

                            <div>
                                <div id="dv_boxnosoal" class="box-no-soal-grid mb-3">
                                    <!-- Box nomor dimuat melalui AJAX -->
                                </div>
                            </div>

                            <!-- Legend -->
                            <div class="pt-2 border-top d-flex justify-content-between text-muted small px-1" style="font-size: 11px;">
                                <span class="d-flex align-items-center gap-1">
                                    <span style="display:inline-block; width:11px; height:11px; background:#f0fdf4; border:2px solid #22c55e; border-radius:3px;"></span>
                                    <span>Benar</span>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <span style="display:inline-block; width:11px; height:11px; background:#fef2f2; border:2px solid #ef4444; border-radius:3px;"></span>
                                    <span>Salah</span>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <span style="display:inline-block; width:11px; height:11px; background:#eff6ff; border:2px solid #2563eb; border-radius:3px;"></span>
                                    <span>Aktif</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none" id="loader-wrapper">
            <div class="loader"></div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <?= $this->include('front/template/scriptjs') ?>

    <script>
    var jenis_id = <?= (int)$jenis_id ?>;
    var level_id = <?= (int)$level_id ?>;
    var used     = <?= (int)$used ?>;

    function showImagePopup(imageUrl, fallbackUrl) {
        Swal.fire({
            html: '<div style="padding: 10px; max-height: 80vh; overflow: auto; display:flex; align-items:center; justify-content:center;">' +
                  '<img src="' + imageUrl + '" style="max-width: 100%; max-height: 75vh; height: auto; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); object-fit: contain;" ' +
                  'onerror="if(this.src!=\'' + fallbackUrl + '\'){this.src=\'' + fallbackUrl + '\';}">' +
                  '</div>',
            width: 'auto',
            showCloseButton: true,
            showConfirmButton: false,
            background: '#ffffff',
            padding: '1em',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg'
            }
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

    $(document).ready(function() {
        startpembahasan("start");
    });

    function setboxsoal(no_soal) {
        $("#inp_no_soal").val(no_soal);
        $("#p_no_soal").text("Soal no. " + no_soal);
        startpembahasan("jump");
    }

    function startpembahasan(proc) {
        let soal_id = $("#inp_soal_id").val();
        let no_soal = $("#inp_no_soal").val();

        $.ajax({
            url: "<?= base_url('latihan/startujianpembahasan_kecerdasan') ?>",
            type: "post",
            dataType: "json",
            data: {
                "soal_id": soal_id,
                "jenis_id": jenis_id,
                "level_id": level_id,
                "no_soal": no_soal,
                "proc": proc,
                "used": used
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none");
            },
            success: function(data) {
                $("#loader-wrapper").addClass("d-none");
                $("#inp_soal_id").val(data.soal_id);
                $("#inp_soal_nm").text(data.soal_nm);
                $("#p_no_soal").text("Soal no. " + data.no_soal + " dari " + data.total_soal);
                $("#inp_no_soal").val(data.no_soal);
                $("#dv_main_jawaban").html(data.jawaban_nm);
                $("#dv_boxnosoal").html(data.boxnomorsoal);
                $("#dv_pembahasan_box").html(data.pembahasan_html);
                $("#dv_button").html(data.button);
                $("#dv_img_soal").html(data.img_soal || "");

                if (data.user_jawaban) {
                    var isCorrect = (data.user_jawaban === data.kunci_soal);
                    var badgeClass = isCorrect ? 'bg-success' : 'bg-danger';
                    var badgeIcon = isCorrect ? 'fa-check-circle' : 'fa-times-circle';
                    var statusText = isCorrect ? 'Benar' : 'Salah';
                    $("#user_choice_badge").html("<span class='badge " + badgeClass + " px-3 py-1 rounded-pill'><i class='fas " + badgeIcon + " me-1'></i> Jawaban Anda: " + data.user_jawaban + " (" + statusText + ")</span>");
                } else {
                    $("#user_choice_badge").html("<span class='badge bg-secondary px-3 py-1 rounded-pill'><i class='fas fa-question-circle me-1'></i> Tidak Dijawab</span>");
                }
            },
            error: function() {
                $("#loader-wrapper").addClass("d-none");
                Swal.fire({
                    title: "Terjadi Kendala",
                    text: "Gagal memuat data pembahasan.",
                    icon: "error"
                });
            }
        });
    }
    </script>
</body>
</html>
