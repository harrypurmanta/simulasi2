<?php 
  $this->session = \Config\Services::session();
?>
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
              <i class="fas fa-check-square text-primary me-2"></i> Kunci Jawaban Soal CAT
            </h1>
            <p class="text-muted small mb-0 mt-1">Kelola data opsi pilihan dan kunci jawaban soal ujian</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item active">Jawaban</li>
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
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                  <button onclick="tambahjawaban()" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-lg">
                    <i class="fas fa-plus me-1"></i> Tambah Jawaban
                  </button>
                  <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                      <span class="small fw-bold text-muted">Group:</span>
                      <?php foreach ($group as $grp): ?>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" onclick="showjawaban('filter')" type="radio" value="<?= $grp->group_soal_id ?>" id="grp_ans_<?= $grp->group_soal_id ?>" name="group_filter">
                        <label class="form-check-label small" for="grp_ans_<?= $grp->group_soal_id ?>"><?= esc($grp->group_nm) ?></label>
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                      <span class="small fw-bold text-muted">Materi:</span>
                      <?php foreach ($materi as $mtr): ?>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" onclick="showjawaban('filter')" type="radio" value="<?= $mtr->materi_id ?>" id="mtr_ans_<?= $mtr->materi_id ?>" name="materi_filter">
                        <label class="form-check-label small" for="mtr_ans_<?= $mtr->materi_id ?>"><?= esc($mtr->materi_nm) ?></label>
                      </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="dv_cardbody">
                
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
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Jawaban</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div id="modal_body" class="modal-body">

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <div class="d-none" id='loader-wrapper'>
        <div class="loader"></div>
      </div>
  </div>
  <!-- /.content-wrapper -->
 

</div>
<!-- ./wrapper -->

<?= $this->include('admin/template/scriptjs') ?>
<!-- Page specific script -->
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('.select2').select2()
  });

  function showjawaban(filter) {
      var group_id = $("input[name='group_filter']:checked").val();
      var materi = $("input[name='materi_filter']:checked").val();
      
      if (materi == undefined && filter == "filter") {
          
      } else {
        $.ajax({
          url: "<?= base_url('jawaban/showjawaban') ?>",
          type: "post",
          data: {
            "filter" : filter,
            "group_id": group_id,
            "materi": materi,
          },
          beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
              },
          success: function(data) {
            $("#loader-wrapper").addClass("d-none");
            $('#dv_cardbody').html(data);
          },
          error: function() {
            Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
          }
        });
      }
      
  }

  function tambahjawaban() {
    $.ajax({
        url: "<?= base_url('jawaban/tambahjawaban') ?>",
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }

  function editjawaban(jawaban_id,materi) {
    $.ajax({
        url: "<?= base_url('jawaban/editjawaban') ?>",
        type: "post",
        data: {
          "jawaban_id": jawaban_id,
          "materi": materi,
        },
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }

  function simpanjawaban() {
      var formdata = new FormData();
      var jawaban_nm = $("#jawaban_nm").val();
      var pilihan_nm = $("#pilihan_nm").val();
      var soal_id = $("#soal_id").val();
      var materi = $("#soal_id").find(':selected').data('materi');
      jQuery.each($("input[name='jawaban_img'")[0].files, function(i, file) {
        formdata.append('jawaban_img['+i+']', file);
      });
      formdata.append('jawaban_nm',jawaban_nm);
      formdata.append('pilihan_nm',pilihan_nm);
      formdata.append('soal_id',soal_id);
      formdata.append('materi',materi);
      $.ajax({
        url: "<?= base_url('jawaban/simpanjawaban') ?>",
        type: "post",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(data) { 
          $('#modal-lg').modal("hide");
          if (data == "sukses") {
            Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
          } else {
            Swal.fire({ title: "Error", text: "Gagal", icon: "error", confirmButtonText: "OK" });
          }
          showjawaban('filter');
        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }
  

  function updatejawaban(jawaban_id) {
    
    var formdata = new FormData();
      var jawaban_nm = $("#jawaban_nm").val();
      var pilihan_nm = $("#pilihan_nm").val();
      var soal_id = $("#soal_id").val();
      var jawaban_img_lama = $("#jawaban_img_lama").val();
      var materi = $("#soal_id").find(':selected').data('materi');
      jQuery.each($("input[name='jawaban_img'")[0].files, function(i, file) {
        formdata.append('jawaban_img['+i+']', file);
      });
      formdata.append('jawaban_nm',jawaban_nm);
      formdata.append('pilihan_nm',pilihan_nm);
      formdata.append('soal_id',soal_id);
      formdata.append('materi',materi);
      formdata.append('jawaban_img_lama',jawaban_img_lama);
      formdata.append('jawaban_id',jawaban_id);
   
    $.ajax({
      url: "<?= base_url('jawaban/updatejawaban') ?>",
      type: "post",
      data: formdata,
      contentType: false,
      processData: false,
      success: function(data) {
        $('#modal-lg').modal("hide");
        Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
        showjawaban('filter');
      },
      error: function() {
        Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
      }
    });
}

function hapusjawaban(jawaban_id) {
  let text = "Apakah anda yakin menghapus data ini ?";
  if (confirm(text) == true) {
    $.ajax({
      url: "<?= base_url('jawaban/hapusjawaban') ?>",
      type: "post",
      data: {
        "jawaban_id": jawaban_id
      },
      success: function(data) {
        if (data == "sukses") {
          Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
        } else {
          Swal.fire({ title: "Error", text: "Gagal", icon: "error", confirmButtonText: "OK" });
        }
        $('#modal-lg').modal("hide");
        showjawaban('filter');
      },
      error: function() {
        Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
      }
    });
  } else {

  }

    
}
</script>
</body>
</html>