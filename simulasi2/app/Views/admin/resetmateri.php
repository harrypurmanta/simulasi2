<?= view('admin/template/head') ?>
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

  @keyframes spin {
      0% {
          transform: rotate(0deg);
      }

      100% {
          transform: rotate(360deg);
      }
  }
</style>
<body class="layout-top-nav">
<div class="wrapper">
 <!-- Navbar -->
 <?= view('admin/navbar') ?>
  <!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold text-dark d-flex align-items-center">
              <i class="fas fa-redo-alt text-warning me-2"></i> Reset Respon Materi Ujian
            </h1>
            <p class="text-muted small mb-0 mt-1">Reset riwayat pengerjaan paket ujian peserta untuk simulasi ulang</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
              <li class="breadcrumb-item active">Reset Materi</li>
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
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="table_materi" class="table table-bordered table-hover align-middle">
                  <thead>
                  <tr>
                    <th class="text-center" style="width: 45px;">No.</th>
                    <th>Nama Paket Materi</th>
                    <th class="text-center">Passhand</th>
                    <th class="text-center">Kecerdasan</th>
                    <th class="text-center">Kepribadian</th>
                    <th class="text-center">Sikap Kerja</th>
                    <th class="text-center" style="width: 140px;">Reset Total</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                        foreach ($materi as $key) {
                    ?>
                  <tr>
                    <td class="text-center fw-semibold"><?= $no++ ?></td>
                    <td class="fw-bold text-dark"><?= esc($key->materi_nm) ?></td>
                    <td class="text-center"><?php if ($key->materi_id == 1) {
                        echo "<button class='btn btn-sm btn-outline-danger rounded-pill px-3' onclick='resetrespon($key->materi_id,1)'><i class='fas fa-undo me-1'></i> Reset</button>";
                    } else { echo "-"; } ?></td>
                    <td class="text-center"><button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="resetrespon(<?= $key->materi_id ?>,2)"><i class="fas fa-undo me-1"></i> Reset</button></td>
                    <td class="text-center"><button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="resetrespon(<?= $key->materi_id ?>,3)"><i class="fas fa-undo me-1"></i> Reset</button></td>
                    <td class="text-center"><button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="resetrespon(<?= $key->materi_id ?>,4)"><i class="fas fa-undo me-1"></i> Reset</button></td>
                    <td class="text-center"><button class="btn btn-sm btn-danger rounded-pill px-3" onclick="resetrespon(<?= $key->materi_id ?>,'semua')"><i class="fas fa-trash-alt me-1"></i> Semua</button></td>
                  </tr>
                    <?php
                        }
                    ?>
                  </tbody>
                </table>
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
            <h5 class="modal-title">Detail</h5>
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
  <div class="d-none" id='loader-wrapper'>
      <div class="loader"></div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-end d-none d-sm-block">
      <b>Version</b> 4.0
    </div>
    <strong>Copyright &copy; <?= date('Y') ?>.</strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<?= view('admin/template/scriptjs') ?>
<!-- Page specific script -->
<script>
  $(function () {
    $('#table_materi').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });

  function resetrespon(materi_id,group_id) {
    Swal.fire({
      title: "Konfirmasi Reset",
      text: "Apakah anda yakin mereset data ini ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Ya, Reset!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
            url: "<?= base_url('admin/users/resetrespon') ?>",
            type: "post",
            dataType: "json",
            data: {
              "materi_id": materi_id,
              "group_id": group_id,
              "user_id": "<?= $user_id ?? '' ?>"
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data == true) {
                    Swal.fire({ title: "Berhasil", text: "Reset berhasil", icon: "success", confirmButtonText: "OK" });
                } else {
                    Swal.fire({ title: "Error", text: "Reset gagal", icon: "error", confirmButtonText: "OK" });
                }
                $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
              $("#loader-wrapper").addClass("d-none");
              Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
            }
        });
      }
    });
  }
</script>
</body>
</html>