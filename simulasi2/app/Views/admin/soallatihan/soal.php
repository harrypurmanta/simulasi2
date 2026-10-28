<?php 
  $this->session = \Config\Services::session();
?>
<?= $this->include('admin/template/head') ?>

<body class="hold-transition layout-top-nav">
<div class="wrapper">
 <!-- Navbar -->
 <?= $this->include('admin/navbar') ?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Soal Latihan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Soal Latihan</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="col-md-6">
                  <form class="form-horizontal">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="group_id" class="col-sm-2 col-form-label">Group Soal</label>
                        <div class="col-sm-10">
                          <select name="group_id" id="group_id" class="form-control" onchange="handleGroupChange()">
                              <option value="" disabled <?= ($this->session->group_id == null ? "" : "selected") ?>>Pilih Materi Soal</option>
                              <?php
                                  foreach ($group as $key) {
                              ?>
                              <option value="<?= $key->group_soal_id ?>" <?= ($this->session->group_id == $key->group_soal_id ? "selected" : "") ?>>
                                  <?= $key->group_nm ?>
                              </option>
                              <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jenis_id" class="col-sm-2 col-form-label">Jenis Soal</label>
                        <div class="col-sm-10">
                          <select name="jenis_id" id="jenis_id" class="form-control" onchange="handleJenisChange()">
                             
                          </select>
                        </div>
                      </div>
                      <div class="form-group row" id="row_level" style="<?= ($this->session->group_id == 2 ? '' : 'display: none;') ?>">
                        <label for="level_id" class="col-sm-2 col-form-label">Level Soal</label>
                        <div class="col-sm-10">
                          <select name="level_id" id="level_id" class="form-control" onchange="setSessionLevel()">
                             
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10 d-flex justify-content-end">
                          <div class="form-check">
                            <button type="button" class="btn btn-sm btn-primary" onclick="tampilkansoal()">Tampilkan</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              <div class="col-lg-12 d-flex flex-wrap align-items-center mb-2">
                <a href="<?= base_url() ?>/admin/soallatihan/viewTambahsoal" class="btn btn-primary mr-2"><i class="fas fa-plus mr-1"></i> Tambah Soal</a>
                <button type="button" class="btn btn-success mr-2" onclick="openModalImport()"><i class="fas fa-file-excel mr-1"></i> Import Soal</button>
                <a href="<?= base_url('admin/soallatihan/downloadTemplate') ?>" class="btn btn-outline-success"><i class="fas fa-download mr-1"></i> Download Template Excel</a>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="tbl_soal" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="text-center" width="25">No.</th>
                        <th class="text-center" width="55">No. Soal</th>
                        <th class="text-center" width="90">Level</th>
                        <th class="text-center">Soal</th>
                        <th class="text-center">Kunci</th>
                        <th class="text-center" width="100">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal Import Soal -->
    <div class="modal fade" id="modalImportSoal" tabindex="-1" role="dialog" aria-labelledby="modalImportSoalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalImportSoalLabel"><i class="fas fa-file-excel me-2"></i> Import Soal Latihan (Excel / CSV)</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="formImportSoal" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-1"></i> Format file harus sesuai dengan template. Jika belum memiliki template, silakan <a href="<?= base_url('admin/soallatihan/downloadTemplate') ?>" class="alert-link fw-bold"><i class="fas fa-download"></i> Download Template Excel Di Sini</a>.
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="import_group_id">Group Soal <span class="text-danger">*</span></label>
                    <select name="group_id" id="import_group_id" class="form-control" onchange="handleImportGroupChange()" required>
                      <option value="" disabled selected>Pilih Group Soal</option>
                      <?php foreach ($group as $key) { ?>
                        <option value="<?= $key->group_soal_id ?>"><?= $key->group_nm ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="import_jenis_id">Jenis Soal <span class="text-danger">*</span></label>
                    <select name="jenis_id" id="import_jenis_id" class="form-control" onchange="handleImportJenisChange()" required>
                      <option value="" disabled selected>Pilih Jenis Soal</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row" id="import_row_level" style="display: none;">
                <div class="col-md-12">
                  <div class="form-group mb-3">
                    <label for="import_level_id">Level Soal (Khusus Group Kecerdasan)</label>
                    <select name="level_id" id="import_level_id" class="form-control">
                      <option value="">Sesuai Kolom Level di Excel (Otomatis)</option>
                    </select>
                    <small class="form-text text-muted">
                      Pilih <i>"Sesuai Kolom Level di Excel"</i> jika file Anda memuat beberapa level sekaligus (berdasarkan kolom J di Excel). Atau pilih level tertentu jika semua soal yang diimpor diperuntukkan untuk 1 level spesifik.
                    </small>
                  </div>
                </div>
              </div>

              <div class="form-group mb-3">
                <label for="import_file">Pilih File Excel / CSV (.xlsx, .xls, .csv) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="file" class="form-control" id="import_file" name="file_excel" accept=".xlsx, .xls, .csv" required onchange="updateFileName(this)">
                </div>
              </div>

              <div class="form-group mb-3">
                <label class="d-block fw-bold mb-2">Opsi Penanganan Soal yang Sudah Ada:</label>
                <div class="form-check form-check-inline">
                  <input type="radio" id="mode_append" name="mode" value="append" class="form-check-input" checked>
                  <label class="form-check-label" for="mode_append">Tambahkan ke soal yang sudah ada (Append)</label>
                </div>
                <div class="form-check form-check-inline">
                  <input type="radio" id="mode_replace" name="mode" value="replace" class="form-check-input">
                  <label class="form-check-label text-danger" for="mode_replace"><i class="fas fa-exclamation-triangle"></i> Hapus &amp; timpa soal lama pada kategori ini</label>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" id="btnSubmitImport" class="btn btn-success">
                <span id="btnImportSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <i class="fas fa-upload mr-1" id="btnImportIcon"></i> Mulai Import
              </button>
            </div>
          </form>
        </div>
      </div>
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
    var initialGroup = $('#group_id').val();
    var sessionJenis = "<?= $this->session->jenis_id ?? '' ?>";
    var sessionLevel = "<?= $this->session->level_id ?? '' ?>";

    getJenis(sessionJenis, sessionLevel, true);

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

  function handleGroupChange() {
    var group_id = $('#group_id').val();
    if (group_id == 2) {
      $('#row_level').show();
    } else {
      $('#row_level').hide();
      $('#level_id').empty();
    }
    getJenis(null, null, true);
  }

  function handleJenisChange() {
    setSessionJenis();
    var group_id = $('#group_id').val();
    if (group_id == 2) {
      getLevel(null, true);
    } else {
      tampilkansoal();
    }
  }

  function setSessionJenis() {
      var group_id = $('#group_id').val();
      var jenis_id = $('#jenis_id').val();
      var level_id = group_id == 2 ? $('#level_id').val() : null;
      $.ajax({
          url: "<?= base_url('admin/soallatihan/setSessionJenis') ?>",
          type: "post",
          dataType: 'json',
          data: {
            "group_id" : group_id,
            "jenis_id" : jenis_id,
            "level_id" : level_id
          },
          beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none")
          },
          success: function(data) {
           $("#loader-wrapper").addClass("d-none");
          },
          error: function(xhr, status, error) {
            $("#loader-wrapper").addClass("d-none");
            console.error('Gagal mengambil data:', error);
          }
      });
  }

  function setSessionLevel() {
      var level_id = $('#level_id').val();
      $.ajax({
          url: "<?= base_url('admin/soallatihan/setSessionLevel') ?>",
          type: "post",
          dataType: 'json',
          data: {
            "level_id" : level_id
          },
          beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none")
          },
          success: function(data) {
            $("#loader-wrapper").addClass("d-none");
            tampilkansoal();
          },
          error: function(xhr, status, error) {
            $("#loader-wrapper").addClass("d-none");
            console.error('Gagal mengambil data:', error);
          }
      });
  }

  function getJenis(selectedJenis, selectedLevel, autoLoad) {
    var group_id = $('#group_id').val();
    if (group_id == 2) {
      $('#row_level').show();
    } else {
      $('#row_level').hide();
      $('#level_id').empty();
    }
    $.ajax({
        url: "<?= base_url('admin/soallatihan/getJenis') ?>",
        type: "post",
        dataType: 'json',
        data: {
          "group_id" : group_id
        },
        beforeSend: function() {
          $("#loader-wrapper").removeClass("d-none")
        },
        success: function(data) {
          $('#jenis_id').empty();
          $.each(data, function(index, item) {
            $('#jenis_id').append(
              `<option value="${item.jenis_id}">${item.jenis_nm}</option>`
            );
          });
          if (selectedJenis) {
            $('#jenis_id').val(selectedJenis);
          }
          $("#loader-wrapper").addClass("d-none");
          if (group_id == 2) {
            getLevel(selectedLevel, autoLoad);
          } else {
            if (autoLoad) {
              tampilkansoal();
            }
          }
        },
        error: function(xhr, status, error) {
          $("#loader-wrapper").addClass("d-none");
          console.error('Gagal mengambil data:', error);
        }
      });
  }

  function getLevel(selectedLevel, autoLoad) {
    var jenis_id = $('#jenis_id').val();
    if (!jenis_id) {
        $('#level_id').html('<option value="">Semua Level</option>');
        return;
    }
    $.ajax({
        url: "<?= base_url('admin/soallatihan/getLevel') ?>",
        type: "post",
        dataType: 'json',
        data: {
            "jenis_id": jenis_id
        },
        beforeSend: function() {
            $("#loader-wrapper").removeClass("d-none");
        },
        success: function(data) {
            $('#level_id').empty();
            $('#level_id').append('<option value="">Semua Level</option>');
            $.each(data, function(index, item) {
                var isSelected = (selectedLevel && selectedLevel == item.level_id) ? 'selected' : '';
                $('#level_id').append(
                    `<option value="${item.level_id}" ${isSelected}>${item.level_nm}</option>`
                );
            });
            if (selectedLevel) {
                $('#level_id').val(selectedLevel);
            }
            $("#loader-wrapper").addClass("d-none");
            if (autoLoad) {
                tampilkansoal();
            }
        },
        error: function(xhr, status, error) {
            $("#loader-wrapper").addClass("d-none");
            console.error('Gagal mengambil level:', error);
        }
    });
  }

  tampilkansoal = () => {
    var group_id = $("#group_id").val();
    var jenis_id = $("#jenis_id").val();
    var level_id = group_id == 2 ? $("#level_id").val() : null;
    $("#tbl_soal").DataTable({
        ajax: {
            url: "<?= base_url('admin/soallatihan/showsoal') ?>",
            type: "POST",
            data: function(d) {
                d.jenis_id = jenis_id;
                d.group_id = group_id;
                d.level_id = level_id;
            },
            dataSrc: function(json) {
                let nomor = 1
                json.forEach((row, idx) => {
                    if (idx > 0) {
                        nomor++
                    }
                    row.nomor = nomor
                });

                return json
            }
        },
        bDestroy: true,
        pageLength: 100,
        columns: [{
                data: "nomor",
                className: "text-center",
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).css("vertical-align", "center")
                }
            },
            {
                data: "no_soal",
                className: "text-center"
            },
            {
                data: "level_nm",
                className: "text-center",
                render: function(data) {
                    return data ? data : '-';
                }
            },
            {
                data: "soal_nm",
                className: "text-left"
            },
            {
                data: "kunci",
                className: "text-center"
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                  return `
                  <a href="<?= base_url() ?>/admin/soallatihan/viewEditsoal/${data.soal_id}" type="button" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                  <button type="button" class="btn btn-sm btn-danger" onclick="hapussoal(${data.soal_id})"><i class="fas fa-trash"></i></button>`
                }
            }
        ]
    })
}

  function updateFileName(input) {
    var fileName = input.files[0] ? input.files[0].name : 'Pilih file...';
    $('#import_file_label').text(fileName);
  }

  function openModalImport() {
    var currentGroup = $('#group_id').val();
    var currentJenis = $('#jenis_id').val();
    var currentLevel = $('#level_id').val();

    if (currentGroup) {
      $('#import_group_id').val(currentGroup);
    }
    handleImportGroupChange(currentJenis, currentLevel);
    $('#modalImportSoal').modal('show');
  }

  function handleImportGroupChange(targetJenis, targetLevel) {
    var group_id = $('#import_group_id').val();
    if (group_id == 2) {
      $('#import_row_level').show();
    } else {
      $('#import_row_level').hide();
      $('#import_level_id').html('<option value="">Sesuai Kolom Level di Excel (Otomatis)</option>');
    }

    if (!group_id) {
      $('#import_jenis_id').html('<option value="" disabled selected>Pilih Jenis Soal</option>');
      return;
    }

    $.ajax({
      url: "<?= base_url('admin/soallatihan/getJenis') ?>",
      type: "post",
      dataType: 'json',
      data: { "group_id": group_id },
      success: function(data) {
        $('#import_jenis_id').empty();
        $('#import_jenis_id').append('<option value="" disabled selected>Pilih Jenis Soal</option>');
        $.each(data, function(index, item) {
          $('#import_jenis_id').append(`<option value="${item.jenis_id}">${item.jenis_nm}</option>`);
        });

        if (targetJenis) {
          $('#import_jenis_id').val(targetJenis);
        } else if (data.length > 0) {
          $('#import_jenis_id').val(data[0].jenis_id);
        }

        if (group_id == 2) {
          loadImportLevels(targetLevel);
        }
      }
    });
  }

  function handleImportJenisChange() {
    var group_id = $('#import_group_id').val();
    if (group_id == 2) {
      loadImportLevels();
    }
  }

  function loadImportLevels(targetLevel) {
    var jenis_id = $('#import_jenis_id').val();
    if (!jenis_id) return;

    $.ajax({
      url: "<?= base_url('admin/soallatihan/getLevel') ?>",
      type: "post",
      dataType: 'json',
      data: { "jenis_id": jenis_id },
      success: function(data) {
        $('#import_level_id').empty();
        $('#import_level_id').append('<option value="">Sesuai Kolom Level di Excel (Otomatis)</option>');
        $.each(data, function(index, item) {
          var isSel = (targetLevel && targetLevel == item.level_id) ? 'selected' : '';
          $('#import_level_id').append(`<option value="${item.level_id}" ${isSel}>${item.level_nm}</option>`);
        });
      }
    });
  }

  $(function() {
    $('#formImportSoal').on('submit', function(e) {
      e.preventDefault();

      var group_id = $('#import_group_id').val();
      var jenis_id = $('#import_jenis_id').val();
      var fileInput = document.getElementById('import_file');

      if (!group_id || !jenis_id) {
        Swal.fire('Peringatan', 'Harap pilih Group Soal dan Jenis Soal!', 'warning');
        return;
      }

      if (!fileInput.files.length) {
        Swal.fire('Peringatan', 'Harap pilih file Excel / CSV terlebih dahulu!', 'warning');
        return;
      }

      var formData = new FormData(this);
      var mode = $('input[name="mode"]:checked').val();

      var confirmTitle = 'Konfirmasi Import';
      var confirmText = 'Apakah Anda yakin ingin mengimpor soal dari file ini?';
      if (mode === 'replace') {
        confirmTitle = 'Perhatian! Mode Timpa Soal';
        confirmText = 'Anda memilih mode TIMPA. Seluruh soal lama pada kategori yang dipilih akan dihapus dan digantikan oleh soal di file Excel. Lanjutkan?';
      }

      Swal.fire({
        title: confirmTitle,
        text: confirmText,
        icon: mode === 'replace' ? 'warning' : 'question',
        showCancelButton: true,
        confirmButtonColor: mode === 'replace' ? '#d33' : '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Import Sekarang',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#btnSubmitImport').prop('disabled', true);
          $('#btnImportSpinner').removeClass('d-none');
          $('#btnImportIcon').addClass('d-none');
          $("#loader-wrapper").removeClass("d-none");

          $.ajax({
            url: "<?= base_url('admin/soallatihan/importsoal') ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(res) {
              $('#btnSubmitImport').prop('disabled', false);
              $('#btnImportSpinner').addClass('d-none');
              $('#btnImportIcon').removeClass('d-none');
              $("#loader-wrapper").addClass("d-none");

              if (res.status === 'success') {
                Swal.fire({
                  title: 'Import Berhasil!',
                  text: res.message,
                  icon: 'success',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK'
                }).then(() => {
                  $('#modalImportSoal').modal('hide');
                  $('#formImportSoal')[0].reset();
                  $('#import_file_label').text('Pilih file...');
                  // Sync filter with imported category and refresh table
                  $('#group_id').val(group_id);
                  getJenis(jenis_id, $('#import_level_id').val(), true);
                });
              } else if (res.status === 'warning') {
                Swal.fire('Perhatian', res.message, 'warning');
              } else {
                Swal.fire('Gagal Import', res.message || 'Terjadi kesalahan sistem.', 'error');
              }
            },
            error: function(xhr, status, error) {
              $('#btnSubmitImport').prop('disabled', false);
              $('#btnImportSpinner').addClass('d-none');
              $('#btnImportIcon').removeClass('d-none');
              $("#loader-wrapper").addClass("d-none");
              Swal.fire('Gagal', 'Terjadi kesalahan pada server saat mengimpor data.', 'error');
            }
          });
        }
      });
    });
  });

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


  
function hapussoal(soal_id) {
  Swal.fire({
        title: "Apakah anda yakin hapus data ini?",
        // text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yakin"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: "<?= base_url('soallatihan/hapussoal') ?>",
              type: "post",
              dataType: "json",
              data: {
                "soal_id": soal_id
              },
              success: function(data) {
                if (data = "sukses") {
                  Swal.fire({
                      title: "Soal berhasil di hapus",
                      icon: "success",
                      showCancelButton: false,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText: "OK"
                      }).then((result) => {
                      if (result.isConfirmed) {
                          tampilkansoal();
                      }
                  }); 
                }
              },
              error: function() {
                Swal.fire({ title: "Error", text: "error", icon: "error", confirmButtonText: "OK" });
              }
          });
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