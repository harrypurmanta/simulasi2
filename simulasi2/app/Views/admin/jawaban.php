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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Jawaban</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Jawaban</li>
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
              <div class="col-lg-12">
                <div class="col-lg-1" style="display:inline-block;text-align:left;width:100%;">
                  <button style="margin-bottom:10px;" onclick="tambahjawaban()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-lg">Tambah</button>
                </div>
                <div class="col-lg-5" style="display:inline-block;text-align:center;width:100%;">
                  <?php
                    foreach ($group as $grp) {
                    
                  ?>
                  <label> <input onclick="showjawaban('filter')" type="radio" value="<?= $grp->group_soal_id ?>" id="group_id" name="group_filter" style="margin-left:10px;"/> <?= $grp->group_nm ?> </label>
                  <?php
                    }
                  ?>
                </div>
                <div class="col-lg-4" style="display:inline-block;text-align:center;width:100%;">
                  <?php
                    foreach ($materi as $mtr) {
                  ?>
                  <label> <input onclick="showjawaban('filter')" type="radio" value="<?= $mtr->materi_id ?>" id="materi_id" name="materi_filter" style="margin-left:10px;"/> <?= $mtr->materi_nm ?> </label>
                  <?php
                    }
                  ?>
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
            alert("error");
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
          alert("error");
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
          alert("error");
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
            alert("Sukses");
          } else {
            alert("Gagal");
          }
          showjawaban('filter');
        },
        error: function() {
          alert("error");
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
        alert("Sukses");
        showjawaban('filter');
      },
      error: function() {
        alert("error");
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
          alert("Sukses");
        } else {
          alert("Gagal");
        }
        $('#modal-lg').modal("hide");
        showjawaban('filter');
      },
      error: function() {
        alert("error");
      }
    });
  } else {

  }

    
}
</script>
</body>
</html>