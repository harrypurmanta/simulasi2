<?= $this->include('admin/template/head') ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <?= $this->include('admin/navbar') ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row g-3">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info text-white p-3 rounded">
              <div class="inner">
                <h3>Hasil</h3>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line fa-2x"></i>
              </div>
              <a href="<?= base_url() ?>/admin/users" class="small-box-footer text-white text-decoration-none d-block mt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning text-dark p-3 rounded">
              <div class="inner">
                <h3>Users</h3>
                <p>Jumlah User</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus fa-2x"></i>
              </div>
              <a href="<?= base_url() ?>/admin/users" class="small-box-footer text-dark text-decoration-none d-block mt-2">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-success text-white p-3 rounded">
              <div class="inner">
                <h3>Lulus</h3>
                <p>Memenuhi Syarat</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle fa-2x"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger text-white p-3 rounded">
              <div class="inner">
                <h3>Tidak Lulus</h3>
                <p>User Tidak lulus</p>
              </div>
              <div class="icon">
                <i class="fas fa-times-circle fa-2x"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?= $this->include('admin/template/scriptjs') ?>
</body>
</html>
