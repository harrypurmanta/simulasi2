<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Pages</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/bootstrap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
<?= $this->include('admin/navbar') ?>
<!-- Content Wrapper. Contains page content -->
<div id="contentwrapper" class="content-wrapper" style="background-color: #f8fafc;">

<!-- Main content -->
<div class="content py-4">
  <div class="container-fluid px-3 px-lg-4">
    <div class="row justify-content-center">
      <div class="col-12">
        <div id="card" class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-4 bg-white">
            <div id="cardbody">
    
<div>
  <?= $ret; ?>
</div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 5 -->
<script src="<?= base_url('dist/adminlte4/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('dist/adminlte4/js/adminlte.min.js') ?>"></script>
<script>
var barChartCanvas = $("#barChart").get(0).getContext("2d")
            var areaChartData = {
            labels  : <?= json_encode($kolom_nm) ?>,
            datasets: [
                {
                  label               : "Jawaban Benar",
                  backgroundColor     : "rgba(60,141,188,0.9)",
                  borderColor         : "rgba(60,141,188,0.8)",
                  pointRadius          : false,
                  pointColor          : "#3b8bba",
                  pointStrokeColor    : "rgba(60,141,188,1)",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(60,141,188,1)",
                  data                : <?= json_encode($jawaban_benar_chart)?>,
                  bezierCurve : false
                },
                {
                  label               : "Soal Terjawab",
                  backgroundColor     : "rgba(210, 214, 222, 1)",
                  borderColor         : "rgba(210, 214, 222, 1)",
                  pointRadius         : false,
                  pointColor          : "rgba(210, 214, 222, 1)",
                  pointStrokeColor    : "#c1c7d1",
                  pointHighlightFill  : "#fff",
                  pointHighlightStroke: "rgba(220,220,220,1)",
                  data                : <?= json_encode($soal_terjawab_chart)?>
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
            });
  
</script>
</body>
</html>

