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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reset Materi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Reset Materi</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table_materi" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center;">No.</th>
                    <th style="text-align:center;">Materi</th>
                    <th style="text-align:center;">Passhand</th>
                    <th style="text-align:center;">Kecerdasan</th>
                    <th style="text-align:center;">Kepribadian</th>
                    <th style="text-align:center;">Sikap Kerja</th>
                    <th style="text-align:center;">Semua</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                        foreach ($materi as $key) {
                    ?>
                  <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= $key->materi_nm ?></td>
                    <td style="text-align:center;"><?php if ($key->materi_id == 1) {
                        echo "<button class='btn btn-primary' onclick='resetrespon($key->materi_id,1)'>Reset</button>";
                    } ?></td>
                    <td style="text-align:center;"><button class="btn btn-primary" onclick="resetrespon(<?= $key->materi_id ?>,2)">Reset</button></td>
                    <td style="text-align:center;"><button class="btn btn-primary" onclick="resetrespon(<?= $key->materi_id ?>,3)">Reset</button></td>
                    <td style="text-align:center;"><?php if ($key->materi_id == 1) {
                        echo "<button class='btn btn-primary' onclick='resetrespon($key->materi_id,4)'>Reset</button>";
                    } ?></td>
                    <td style="text-align:center;"><button class="btn btn-primary" onclick="resetrespon(<?= $key->materi_id ?>,'semua')">Reset Semua</button></td>
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
    let text = "Apakah anda yakin mereset data ini ?";
    if (confirm(text) == true) {
        $.ajax({
            url: "<?= base_url('admin/users/resetrespon') ?>",
            type: "post",
            dataType: "json",
            data: {
            "materi_id": materi_id,
            "group_id": group_id
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data == true) {
                    alert("Reset berhasil");
                } else {
                    alert("Reset gagal");
                }
                $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
              alert("error");
            }
        });
    }
  }
</script>
</body>
</html>