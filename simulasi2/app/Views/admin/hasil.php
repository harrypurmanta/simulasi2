<?= $this->include('admin/template/head') ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <!-- Navbar -->
  <?= $this->include('admin/navbar') ?>
  <!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold text-dark d-flex align-items-center">
              <i class="fas fa-poll text-primary me-2"></i> Rekapitulasi Hasil Siswa
            </h1>
            <p class="text-muted small mb-0 mt-1">Ulasan nilai dan ekspor hasil simulasi CAT per peserta</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
              <li class="breadcrumb-item active">Hasil Siswa</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row">
          <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3">
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                      <i class="fas fa-user-graduate fa-lg"></i>
                    </div>
                    <div>
                      <?php
                      foreach ($user as $key) {
                          $dttm = explode(" ", $key->birth_dttm);
                      ?>
                      <h5 class="fw-bold text-dark mb-0"><?= esc($key->person_nm) ?></h5>
                      <small class="text-muted">TTL: <?= esc($key->birth_place) ?>, <?= esc($dttm[0] ?? '-') ?></small>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <div class="card-body">
              <div class="table-responsive">
              <table id="example2" class="table table-bordered table-hover align-middle">
                  <thead>
                  <tr>
                    <th style="width: 50%;">Materi Tryout CAT</th>
                    <th style="width: 50%;">Latihan Mandiri</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>
                      <div class="d-flex flex-column gap-2">
                        <?php foreach ($materi as $km): ?>
                        <div class="d-flex flex-wrap align-items-center justify-content-between p-2 rounded-3 bg-light border">
                          <span class="fw-semibold text-dark"><i class="fas fa-book me-1 text-primary"></i> <?= esc($km->materi_nm) ?></span>
                          <div class="btn-group btn-group-sm">
                            <a target="_blank" href="<?= base_url('admin/users/hasilexcel/' . $user_id . '/' . $km->materi_id) ?>" class="btn btn-outline-success">
                              <i class="fas fa-file-excel me-1"></i> Excel
                            </a>
                            <a target="_blank" href="<?= base_url('admin/users/hasilweb/' . $user_id . '/' . $km->materi_id) ?>" class="btn btn-outline-primary">
                              <i class="fas fa-globe me-1"></i> Web
                            </a>
                            <a target="_blank" href="<?= base_url('admin/users/hasilpdf/' . $user_id . '/' . $km->materi_id) ?>" class="btn btn-outline-danger">
                              <i class="fas fa-file-pdf me-1"></i> PDF
                            </a>
                          </div>
                        </div>
                        <?php endforeach; ?>
                      </div>
                    </td>
                    
                    <td class="align-top">
                      <div class="d-flex flex-wrap gap-2 mb-3">
                        <a target="_blank" href="<?= base_url('admin/users/hasillatihan/' . $user_id . '/5') ?>" class="btn btn-sm btn-outline-warning text-dark">
                          <i class="fas fa-stopwatch me-1"></i> Sikap Kerja
                        </a>
                        <button type="button" onclick="listmaterilatihan()" class="btn btn-sm btn-outline-info">
                          <i class="fas fa-list me-1"></i> Materi Latihan
                        </button>
                        <button type="button" onclick="listsubmaterilatihan()" class="btn btn-sm btn-outline-secondary">
                          <i class="fas fa-layer-group me-1"></i> Sub Materi
                        </button>
                      </div>
                      <div class="col-md-12" id="listlatihan"></div>
                    </td>
                    
                  </tr>
                  </tbody>
                </table>
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

        
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-lg" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detail Hasil</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div id="modal_body" class="modal-body">

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  </div>
  <!-- /.content-wrapper -->


</div>
<!-- ./wrapper -->


<?= $this->include('admin/template/scriptjs') ?>
<!-- Page specific script -->
<script>
 function listmaterilatihan() {
    var user_id = <?= $user_id; ?>;
    $.ajax({
        url: "<?= base_url('admin/hasil/listmaterilatihan') ?>",
        type: "post",
        data: {
          "user_id": user_id
        },
        success: function(data) {
          $('#listlatihan').html(data);
        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
    });
 }

 function listsubmaterilatihan() {
    var user_id = <?= $user_id; ?>;
    $.ajax({
        url: "<?= base_url('admin/hasil/listsubmaterilatihan') ?>",
        type: "post",
        data: {
          "user_id": user_id
        },
        success: function(data) {
          $('#listlatihan').html(data);
        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
    });
}
</script>
</body>
</html>