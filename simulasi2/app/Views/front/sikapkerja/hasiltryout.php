<?php
$title = 'Hasil Penilaian Sikap Kerja - Bintang Timur Prestasi';
?>
<?= $this->include('front/template/head') ?>
<body class="layout-top-nav">
    <div class="wrapper">
        <?= $this->include('front/navbar') ?>

        <div class="content-wrapper">
            <div class="container py-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">TES KECERMATAN</span>
                        <h3 class="fw-bold mb-0">HASIL PENILAIAN SIKAP KERJA</h3>
                    </div>
                    <div class="card-body p-4 p-md-5 bg-white text-center">
                        <div class="alert alert-info border-0 rounded-3 mb-4 mx-auto" style="max-width: 800px;">
                            <i class="fas fa-info-circle me-1"></i> Nilai yang tampil merupakan hasil dari jumlah soal yang terjawab, dan bukan merupakan bobot penilaian seperti saat tes sesungguhnya.
                        </div>

                        <?php
                        $kolom_nm = [];
                        $soal_terjawab_chart = [];
                        $jawaban_benar_chart = [];
                        ?>

                        <!-- Tabel Hasil Penilaian -->
                        <div class="row justify-content-center mb-4">
                            <div class="col-12 col-lg-8">
                                <div class="table-responsive rounded-3 border">
                                    <table class="table table-bordered table-hover text-center align-middle mb-0">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Kolom</th>
                                                <th>Soal Terjawab</th>
                                                <th class="text-success">Benar</th>
                                                <th class="text-danger">Salah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $db = db_connect();
                                                $request = \Config\Services::request();
                                                $this->session = \Config\Services::session();
                                                foreach ($kolom as $kkolom) {
                                                    $kolom_nm[] = $kkolom->kolom_nm;
                                                    $benar = 0;
                                                    $salah = 0;
                                                    $soal_terjawab = 0;
                                                    $query = $db->query("SELECT *,a.pilihan_nm AS pilihan_respon FROM respon_latihan a LEFT JOIN soal b ON b.soal_id = a.soal_id LEFT JOIN jawaban c ON c.jawaban_id = a.jawaban_id WHERE a.materi = 98 AND b.sk_group_id = ".$request->getUri()->getSegment(3)." AND a.created_user_id = ".$this->session->user_id." AND a.used = ".$this->session->used." AND a.kolom_id = $kkolom->kolom_id AND a.group_id = 4")->getResult();

                                                    if (count($query)>0) {
                                                        $soal_terjawab = count($query);
                                                        foreach ($query as $rSK) {
                                                            if ($rSK->pilihan_respon == $rSK->kunci) {
                                                                $benar = $benar + 1;
                                                            } else {
                                                                $salah = $salah + 1;
                                                            }
                                                        }
                                                    } else {
                                                        $soal_terjawab = $soal_terjawab;
                                                    }

                                                    $soal_terjawab_chart[] =  $soal_terjawab;
                                                    $jawaban_benar_chart[] = $benar;
                                            ?>
                                            <tr>
                                                <td class="fw-bold"><?= esc($kkolom->kolom_nm) ?></td>
                                                <td><?= $soal_terjawab ?></td>
                                                <td class="fw-bold text-success"><?= $benar ?></td>
                                                <td class="fw-bold text-danger"><?= $salah ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Grafik Bar Chart -->
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10">
                                <div class="card border rounded-3 p-3 shadow-sm">
                                    <h6 class="fw-bold text-dark text-start mb-3"><i class="fas fa-chart-bar me-2 text-primary"></i> Grafik Performa per Kolom:</h6>
                                    <div class="chart position-relative" style="min-height: 320px; height: 350px;">
                                        <canvas id="barChart" style="min-height: 320px; height: 350px; max-height: 350px; width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="<?= base_url('sikapkerja') ?>" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Menu Sikap Kerja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->include('front/footer') ?>
    </div>
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/chart.js/Chart.min.js"></script>

    <script>
        $(document).ready(function(){
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var areaChartData = {
            labels  : <?= json_encode($kolom_nm) ?>,
            datasets: [
                {
                  label               : "Jawaban Benar",
                  backgroundColor     : "rgba(40,167,69,1)",
                  borderColor         : "rgba(60,141,188,0.8)",
                  pointRadius         : false,
                  pointColor          : "#00a65a",
                  pointStrokeColor    : "rgba(60,141,188,1)",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data                : <?= json_encode($jawaban_benar_chart) ?>,
                  bezierCurve : false
                },
                {
                  label               : "Soal Terjawab",
                  backgroundColor     : "rgba(60,141,188,0.9)",
                  borderColor         : "rgba(60,141,188,0.8)",
                  pointRadius         : false,
                  pointColor          : "#3b8bba",
                  pointStrokeColor    : "rgba(60,141,188,1)",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data                : <?= json_encode($soal_terjawab_chart) ?>
                },
              ]
          }
          
            
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
            }

            new Chart(barChartCanvas, {
              type: "bar",
              data: barChartData,
              options: barChartOptions
            })
        });
    </script>
</body>

</html>