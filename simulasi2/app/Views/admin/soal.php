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
              <i class="fas fa-file-alt text-primary me-2"></i> Bank Soal CAT
            </h1>
            <p class="text-muted small mb-0 mt-1">Kelola data butir soal dan kunci jawaban simulasi CAT</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item active">Soal</li>
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
                  <div class="d-flex flex-wrap gap-2">
                    <button onclick="tambahsoal()" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-lg">
                      <i class="fas fa-plus me-1"></i> Tambah Soal
                    </button>
                    <button onclick="tambahsoallatihan()" class="btn btn-warning text-dark rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-lg">
                      <i class="fas fa-stopwatch me-1"></i> Tambah SK
                    </button>
                    <button onclick="showsoal('all')" class="btn btn-outline-secondary rounded-pill px-3">
                      <i class="fas fa-list me-1"></i> Semua Soal SK
                    </button>
                  </div>
                  <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                      <span class="small fw-bold text-muted">Materi:</span>
                      <?php foreach ($materi as $mtr): ?>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" <?= ($mtr->materi_id == $this->session->materi_filter ? "checked" : "") ?> onclick="showsoal('filter')" type="radio" value="<?= $mtr->materi_id ?>" id="materi_<?= $mtr->materi_id ?>" name="materi_filter">
                        <label class="form-check-label small" for="materi_<?= $mtr->materi_id ?>"><?= esc($mtr->materi_nm) ?></label>
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                      <span class="small fw-bold text-muted">Group:</span>
                      <?php foreach ($group as $grp): ?>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" <?= ($grp->group_soal_id == $this->session->group_filter ? "checked" : "") ?> onclick="showsoal('filter')" type="radio" value="<?= $grp->group_soal_id ?>" id="grp_<?= $grp->group_soal_id ?>" name="group_filter">
                        <label class="form-check-label small" for="grp_<?= $grp->group_soal_id ?>"><?= esc($grp->group_nm) ?></label>
                      </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="dv_cardbody">
                    <?= $soal; ?>
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
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <div class="modal-header py-3 px-4">
            <h5 class="modal-title fw-bold text-white"><i class="fas fa-edit me-2 text-warning"></i> Form Butir Soal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div id="modal_body" class="modal-body p-4 bg-light">

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

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  });

  function showsoal(filter) {
      var group_id = $("input[name='group_filter']:checked").val();
      var materi = $("input[name='materi_filter']:checked").val();
      
      if (materi == undefined && filter == "filter") {
          
      } else {
        $.ajax({
          url: "<?= base_url('soal/showsoal') ?>",
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

  function checkboxenable(jawaban_nm,kolom_id,soal_id) {
    var checkBox = document.getElementById('customSwitch1_'+kolom_id+'_'+soal_id);
    if (checkBox.checked) {
        var status_cd = "normal";
        var old_status = "disasble";
    } else {
      var status_cd = "disable";
      var old_status = "normal";
    }

    $.ajax({
          url: "<?= base_url('soal/updatestatus') ?>",
          type: "post",
          data: {
            "jawaban_nm" : jawaban_nm,
            "kolom_id"  : kolom_id,
            "status_cd" : status_cd,
            "old_status" : old_status
          },
          beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none")
          },
          success: function(data) {
            $("#loader-wrapper").addClass("d-none");
          },
          error: function() {
            Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
          }
        });
  }



  function checkdupe(kolom) {
    var char = document.getElementById(kolom).value;
    for (i = 0; i < char.length; i++) {
      for (j = i + 1; j < char.length; j++) {
          if (char[i] == char[j]) {
            Swal.fire({ title: "Perhatian", text: "Karakter tidak boleh sama !", icon: "warning", confirmButtonText: "OK" });
            var val = char.substr(0, char.length - 1);
            document.getElementById(kolom).value = val;
          }
      }
    }
  }

  function tambahsoallatihan() {
    $.ajax({
        url: "<?= base_url('soal/tambahsoallatihan') ?>",
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }

  function simpansoallatihan() {
    var kolom1 = $("#kolom1").val();
    var kolom2 = $("#kolom2").val();
    var kolom3 = $("#kolom3").val();
    var kolom4 = $("#kolom4").val();
    var kolom5 = $("#kolom5").val();
    var kolom6 = $("#kolom6").val();
    var kolom7 = $("#kolom7").val();
    var kolom8 = $("#kolom8").val();
    var kolom9 = $("#kolom9").val();
    var kolom10 = $("#kolom10").val();
    var materi = document.getElementsByName("materix");
    var checkBox = ""
        for (var i = 0, length = materi.length; i < length; i++) {
            if (materi[i].checked) {
                checkBox = "checked";
                break;
            }
        }
    
    if (checkBox == "checked") {
      var materi_id = $("input[name='materix']:checked").val();
      // alert(materi_id);

      if (kolom1.length < 5 && kolom1.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 1 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom1").focus();
        return;
      } 
      
      if (kolom2.length < 5 && kolom2.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 2 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom2").focus();
        return;
      }

      if (kolom3.length < 5 && kolom3.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 3 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom3").focus();
        return;
      }

      if (kolom4.length < 5 && kolom4.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 4 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom4").focus();
        return;
      }

      if (kolom5.length < 5 && kolom5.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 5 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom5").focus();
        return;
      }

      if (kolom6.length < 5 && kolom6.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 6 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        kdocument.getElementById("kolom6").focus();
        return;
      }

      if (kolom7.length < 5 && kolom7.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 7 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom7").focus();
        return;
      }

      if (kolom8.length < 5 && kolom8.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 8 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom8").focus();
        return;
      }

      if (kolom9.length < 5 && kolom9.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 9 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom9").focus();
        return;
      }

      if (kolom10.length < 5 && kolom10.length > 0) {
        Swal.fire({ title: "Perhatian", text: "Jumlah karakter pada KOLOM 10 kurang dari 5", icon: "warning", confirmButtonText: "OK" });
        document.getElementById("kolom10").focus();
        return;
      }  

        $.ajax({
        url: "<?= base_url('soal/simpansoallatihan') ?>",
        type: "post",
        dataType: "json",
        data: {
          "kolom1" : kolom1,
          "kolom2" : kolom2,
          "kolom3" : kolom3,
          "kolom4" : kolom4,
          "kolom5" : kolom5,
          "kolom6" : kolom6,
          "kolom7" : kolom7,
          "kolom8" : kolom8,
          "kolom9" : kolom9,
          "kolom10" : kolom10,
          "materi_id" : materi_id
        },
        beforeSend: function() {
          $("#loader-wrapper").removeClass("d-none")
        },
        success: function(data) {
          $("#loader-wrapper").addClass("d-none");
          $('#modal-lg').modal("hide");
          Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
          
        },
        error: function() {
          $("#loader-wrapper").addClass("d-none");
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
    } else {
      Swal.fire({ title: "Perhatian", text: "pilih materi dahulu", icon: "warning", confirmButtonText: "OK" });
    }
}

  function tambahsoal() {
    $.ajax({
        url: "<?= base_url('soal/tambahsoal') ?>",
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }

  function editsoal(soal_id) {
    $.ajax({
        url: "<?= base_url('soal/editsoal') ?>",
        type: "post",
        dataType: "json",
        data: {
          "soal_id": soal_id
        },
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }

  function simpansoal() {
      var formdata = new FormData();
      var soal_nm = $("#soal_nm").val();
      var kunci = $("#kunci").val();
      var no_soal = $("#no_soal").val();
      var group_id = $("input[name='group_nm']:checked").val();
      var materi = $("input[name='materi']:checked").val();

      jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
        formdata.append('soal_img['+i+']', file);
      });
      formdata.append('soal_nm',soal_nm);
      formdata.append('kunci',kunci);
      formdata.append('no_soal',no_soal);
      formdata.append('group_id',group_id);
      formdata.append('materi',materi);
      $.ajax({
        url: "<?= base_url('soal/simpansoal') ?>",
        type: "post",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(data) {
          $('#modal-lg').modal("hide");
          Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }
  

  function updatesoal(soal_id) {
    var formdata = new FormData();
    var soal_nm = $("#soal_nm").val();
    var soal_img_lama = $("#soal_img_lama").val();
    var kunci = $("#kunci").val();
    var no_soal = $("#no_soal").val();
    var group_id = $("input[name='group_nm']:checked").val();
    var materi = $("input[name='materi']:checked").val();

      jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
        formdata.append('soal_img['+i+']', file);
      });
      formdata.append('soal_nm',soal_nm);
      formdata.append('kunci',kunci);
      formdata.append('no_soal',no_soal);
      formdata.append('group_id',group_id);
      formdata.append('materi',materi);
      formdata.append('soal_img_lama',soal_img_lama);
      formdata.append('soal_id',soal_id);

   
    $.ajax({
      url: "<?= base_url('soal/updatesoal') ?>",
      type: "post",
      data: formdata,
      contentType: false,
        processData: false,
      success: function(data) {
        $('#modal-lg').modal("hide");
        Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
        $("#example2").load(window.location.href+" #example2");
      },
      error: function() {
        Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
      }
    });
}

function hapussoal(soal_id) {

    $.ajax({
      url: "<?= base_url('soal/hapussoal') ?>",
      type: "post",
      dataType: "json",
      data: {
        "soal_id": soal_id
      },
      success: function(data) {
        $('#modal-lg').modal("hide");
          Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
        $("#example2").load(window.location.href+" #example2");
      },
      error: function() {
        Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
      }
    });
}

function showjawaban(soal_id) {
  var td_form = document.querySelectorAll(".td_form");
  if (td_form.length !== 0) {
      for (let i = 0; i < td_form.length; i++) {
        td_form[i].remove();
      }
  }
      $.ajax({
        url: "<?= base_url('soal/showjawaban') ?>",
        type: "post",
        dataType: "json",
        data: {
          "soal_id": soal_id
        },
        success: function(data) {
          $('#tr_data_'+soal_id).html(data);
        },
        error: function() {
          Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
        }
      });
  }


function plusbtn(soal_id,jawaban_id) {
  var tr_form = document.getElementById("tr_form_"+soal_id+"_"+jawaban_id);
  var table   = document.getElementById("tb_jawaban"+soal_id);
  var table_len = (table.rows.length);
  var row = table.insertRow(table_len).outerHTML = "<tr class='tr_form' id='tr_form_"+soal_id+"_"+table_len+"'><td style='text-align:center;width:50px;'><button onclick='timesbtn("+soal_id+","+table_len+")' type='button' class='btn btn-outline-danger'><i class='fa fa-times'></i></button></td><td style='text-align:center;width:50px;'><input style='width:50px;text-align:center;' type='text' name='pilihan_nm[]' data-id='new'/> </td><td><input style='padding-left:10px;width:100%;' type='text' name='jawaban_nm[]'/></td></tr>";

}

function checkbtn(soal_id) {
      var formdata = new FormData();
      var pilihan_nm = [];
      var jawaban_nm = [];
      var jawaban_id = [];


      jQuery.each($("input[name='jawaban_img[]'")[0].files, function(i, file) {
        formdata.append('jawaban_img['+i+']', file);
      });

      $("input[name='jawaban_img[]'").each(function() {
        jawaban_id.push($(this).data("jawaban_id"));
      });

      // var jawaban_id = $("input[name='jawaban_img[]'").map(function() {
      //     return {
      //       jawaban_id: $(this).data("jawaban_id")
      //     };
      // }).get();


      var pilihan_nm = $("input[name='pilihan_nm[]'").map(function() {
            return {
                id: $(this).data("id"),
                value: $(this).val()
            };
        }).get();

      $("input[name='jawaban_nm[]'").each(function() {
        jawaban_nm.push($(this).val());
      });

      formdata.append('pilihan_nm',pilihan_nm);
      formdata.append('jawaban_nm',jawaban_nm);
      formdata.append('soal_id',soal_id);
      formdata.append('jawaban_id',jawaban_id);

      $.ajax({
          url: "<?= base_url('soal/simpanjawaban') ?>",
          type: "post",
          data: formdata,
          contentType: false,
          processData: false,
          
          success: function(data) {
            Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
            showjawaban(soal_id);
          },
          error: function() {
            Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
          }
      });
}

function deletebtn(soal_id,jawaban_id) {
  let text = "Apakah anda yakin menghapus data ini ?";
  if (confirm(text) == true) {
    $.ajax({
          url: "<?= base_url('soal/deletejawaban') ?>",
          type: "post",
          dataType: "json",
          data: {
            "jawaban_id": jawaban_id
          },
          success: function(data) {
            if (data == "sukses") {
              Swal.fire({ title: "Berhasil", text: "Sukses", icon: "success", confirmButtonText: "OK" });
            } else {
              Swal.fire({ title: "Error", text: "Gagal", icon: "error", confirmButtonText: "OK" });
            }
            document.getElementById("tr_form_"+soal_id+"_"+jawaban_id).outerHTML="";
            showjawaban(soal_id);
          },
          error: function() {
            Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
          }
      });
  } else {

  }
  
}

function timesbtn(soal_id,jawaban_id) {
  document.getElementById("tr_form_"+soal_id+"_"+jawaban_id).outerHTML="";
}

function simpangambarjawaban(soal_id,jawaban_id) {

}
</script>
</body>
</html>