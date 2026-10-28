<?php 
  $this->session = \Config\Services::session();
?>
<?= $this->include('admin/template/head') ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  
 <?= $this->include('admin/navbar') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold text-dark d-flex align-items-center">
              <i class="fas fa-book-open text-success me-2"></i> Bank Soal Latihan Mandiri
            </h1>
            <p class="text-muted small mb-0 mt-1">Kelola data soal latihan bertingkat berdasarkan jenis materi</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item active">Soal Latihan</li>
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
                    <button onclick="tambahsoallatihan()" class="btn btn-success rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-lg">
                      <i class="fas fa-plus me-1"></i> Tambah Soal Latihan
                    </button>
                  </div>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="small fw-bold text-muted">Filter Jenis:</span>
                    <?php foreach ($jenis as $k): ?>
                    <div class="form-check form-check-inline mb-0">
                      <input class="form-check-input" <?= ($k->jenis_id == $this->session->jenis_filter ? "checked" : "") ?> onclick="showsoal('filter')" type="radio" value="<?= $k->jenis_id ?>" id="jns_<?= $k->jenis_id ?>" name="jenis_filter">
                      <label class="form-check-label small" for="jns_<?= $k->jenis_id ?>"><?= esc($k->jenis_nm) ?></label>
                    </div>
                    <?php endforeach; ?>
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
            <h5 class="modal-title fw-bold text-white"><i class="fas fa-edit me-2 text-warning"></i> Form Soal Latihan</h5>
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
      var jenis = $("input[name='jenis_filter']:checked").val();
      
      if (jenis == undefined && filter == "filter") {
          
      } else {
        $.ajax({
          url: "<?= base_url('soallatihan/showsoal') ?>",
          type: "post",
          data: {
            "filter" : filter,
            "jenis": jenis,
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

  function checkboxenable(soal_id) {
    var checkBox = document.getElementById('customSwitch1_'+soal_id);
    if (checkBox.checked) {
        var status_cd = "normal";
        var old_status = "disasble";
    } else {
      var status_cd = "disable";
      var old_status = "normal";
    }

    $.ajax({
          url: "<?= base_url('soallatihan/updatestatus') ?>",
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
            alert("error");
          }
        });
  }



  function checkdupe(kolom) {
    var char = document.getElementById(kolom).value;
    for (i = 0; i < char.length; i++) {
      for (j = i + 1; j < char.length; j++) {
          if (char[i] == char[j]) {
            alert("Karakter tidak boleh sama !");
            var val = char.substr(0, char.length - 1);
            document.getElementById(kolom).value = val;
          }
      }
    }
  }

  function tambahsoallatihan() {
    $.ajax({
        url: "<?= base_url('soallatihan/tambahsoallatihan') ?>",
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          alert("error");
        }
      });
  }

  function simpansoallatihan() {
    var formdata    = new FormData();
      var soal_nm   = $("#soal_nm").val();
      var kunci     = $("#kunci").val();
      var no_soal   = $("#no_soal").val();
      var jenis_soal  = $("#jenis_soal").val();
      jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
        formdata.append('soal_img['+i+']', file);
      });
      formdata.append('soal_nm',soal_nm);
      formdata.append('kunci',kunci);
      formdata.append('no_soal',no_soal);
      formdata.append('jenis_soal',jenis_soal);
      $.ajax({
        url: "<?= base_url('soallatihan/simpansoal') ?>",
        type: "post",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(data) {
          $('#modal-lg').modal("hide");
          alert("Sukses");
          showsoal("filter");
        },
        error: function() {
          alert("error");
        }
      });
  }


  function editsoal(soal_id) {
    $.ajax({
        url: "<?= base_url('soallatihan/editsoal') ?>",
        type: "post",
        data: {
          "soal_id": soal_id
        },
        success: function(data) {
          $('#modal_body').html(data);

        },
        error: function() {
          alert("error");
        }
      });
  }


  function updatesoallatihan(soal_id) {
    var formdata    = new FormData();
      var soal_nm   = $("#soal_nm").val();
      var kunci     = $("#kunci").val();
      var no_soal   = $("#no_soal").val();
      var jenis_soal  = $("#jenis_soal").val();
      var soal_img_lama = $("#soal_img_lama").val();
      jQuery.each($("input[name='soal_img'")[0].files, function(i, file) {
        formdata.append('soal_img['+i+']', file);
      });
      formdata.append('soal_nm',soal_nm);
      formdata.append('kunci',kunci);
      formdata.append('no_soal',no_soal);
      formdata.append('jenis_soal',jenis_soal);
      formdata.append('soal_img_lama',soal_img_lama);
      formdata.append('soal_id',soal_id);
      $.ajax({
        url: "<?= base_url('soallatihan/updatesoal') ?>",
        type: "post",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(data) {
          $('#modal-lg').modal("hide");
          alert("Sukses");
          showsoal("filter");
        },
        error: function() {
          alert("error");
        }
      });
}

function hapussoal(soal_id) {

    $.ajax({
      url: "<?= base_url('soallatihan/hapussoal') ?>",
      type: "post",
      dataType: "json",
      data: {
        "soal_id": soal_id
      },
      success: function(data) {
        $('#modal-lg').modal("hide");
          alert("Sukses");
        showsoal("filter");
      },
      error: function() {
        alert("error");
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
          alert("error");
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
            alert("Sukses");
            showjawaban(soal_id);
          },
          error: function() {
            alert("error");
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
              alert("Sukses");
            } else {
              alert("Gagal");
            }
            document.getElementById("tr_form_"+soal_id+"_"+jawaban_id).outerHTML="";
            showjawaban(soal_id);
          },
          error: function() {
            alert("error");
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