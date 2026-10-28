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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Hasil Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                <div class="card-header">
                <table>
                    
                    <?php
                    foreach ($user as $key) {
                        $dttm = explode(" ",$key->birth_dttm);
                        echo "<tr><td>Nama</td><td>:</td><td>".$key->person_nm."</td></tr>";
                        echo "<tr><td>TTL</td><td>:</td><td>".$key->birth_place.",".$dttm[0]."</td></tr>";
                    }
                    ?>
                </table>
                </div>
              <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center;">Materi</th>
                    <th style="text-align:center;">latihan</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td style="text-align:center;">
                   
                        <?php
                            foreach ($materi as $km) {
                                echo " <div><a target='_blank' href='".base_url()."/admin/users/hasilexcel/$user_id/".$km->materi_id."'>Excel ".$km->materi_nm."</a> | <a target='_blank' href='".base_url() ."/admin/users/hasilweb/$user_id/".$km->materi_id."'>Web ".$km->materi_nm."</a> | <a target='_blank' href='".base_url() ."/admin/users/hasilpdf/$user_id/".$km->materi_id."'>PDF ".$km->materi_nm."</a></div>";

                            }
                        ?>
                        
                    </td>
                    
                    <td style="text-align:center;"><a target="_blank" href="<?= base_url() ?>/admin/users/hasillatihan/<?= $user_id ?>/5">Sikap Kerja</a> | <span onclick="listmaterilatihan()" style="cursor:pointer;">Materi</span> | <span style="cursor:pointer;" onclick="listsubmaterilatihan()">Sub Materi</span>
                    <div class="col-md-12" id="listlatihan"></div>
                    </td>
                    
                  </tr>
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
          alert("error");
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
          alert("error");
        }
    });
}
</script>
</body>
</html>