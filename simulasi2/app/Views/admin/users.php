<?= $this->include('admin/template/head') ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <!-- Navbar -->
  <?= $this->include('admin/navbar') ?>
  <!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold text-dark d-flex align-items-center">
              <i class="fas fa-users text-info me-2"></i> Data Users & Peserta
            </h1>
            <p class="text-muted small mb-0 mt-1">Daftar pengguna dan manajemen akses simulasi ujian</p>
          </div>
          <div class="col-sm-6 mt-2 mt-sm-0">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
              <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list me-2 text-primary"></i> Daftar Pengguna Terdaftar</h5>
                <button onclick="tambahuser()" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-lg">
                  <i class="fas fa-user-plus me-1"></i> Tambah User Baru
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example2" class="table table-bordered table-hover align-middle">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 45px;">No.</th>
                        <th>Nama Peserta</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">TTL</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">No. HP</th>
                        <th>Alamat</th>
                        <th class="text-center">Role / Level</th>
                        <th class="text-center" style="width: 190px;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1;
                      foreach ($users as $key) {
                      ?>
                      <tr>
                        <td class="text-center fw-semibold"><?= $no++ ?></td>
                        <td class="fw-bold text-dark"><?= esc($key->person_nm) ?></td>
                        <td class="text-center"><span class="badge bg-light text-dark border"><?= esc($key->satuan ?? '-') ?></span></td>
                        <td class="text-center small"><?= esc($key->birth_place) ?>, <?= esc($key->birth_dttm) ?></td>
                        <td class="text-center"><span class="badge <?= $key->gender_cd == 'L' ? 'bg-primary' : 'bg-info' ?>"><?= esc($key->gender_cd) ?></span></td>
                        <td class="text-center font-monospace small"><?= esc($key->user_nm) ?></td>
                        <td class="text-center small"><?= esc($key->cellphone) ?></td>
                        <td class="small text-muted"><?= esc($key->addr_txt) ?></td>
                        <td class="text-center">
                          <span class="badge <?= $key->user_group == 'owner' ? 'bg-danger' : 'bg-success' ?>">
                            <?= esc($key->user_group) ?>
                          </span>
                        </td>
                        <td class="text-center text-nowrap">
                          <div class="btn-group btn-group-sm" role="group">
                            <button onclick="editperson(<?= $key->person_id ?>)" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal-lg" title="Edit Data">
                              <i class="fa fa-pencil-alt"></i>
                            </button>
                            <button onclick="hapusperson(<?= $key->person_id ?>)" class="btn btn-outline-danger" title="Hapus User">
                              <i class="fa fa-trash"></i>
                            </button>
                            <a href="<?= base_url('admin/hasil/' . $key->user_id) ?>" target="_blank" class="btn btn-outline-primary" title="Detail Hasil">
                              <i class="fas fa-chart-bar me-1"></i> Detail
                            </a>
                            <a href="<?= base_url('admin/users/resetmateri/' . $key->user_id) ?>" target="_blank" class="btn btn-outline-warning text-dark" title="Reset Materi">
                              <i class="fas fa-redo-alt me-1"></i> Reset
                            </a>
                          </div>
                        </td>
                      </tr>
                      <?php } ?>
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
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <div class="modal-header py-3 px-4">
            <h5 class="modal-title fw-bold text-white"><i class="fas fa-user-edit me-2 text-warning"></i> Form Data Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div id="modal_body" class="modal-body p-4 bg-light">
          </div>
        </div>
      </div>
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
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });

  function tambahuser() {
    $.ajax({
        url: "<?= base_url('admin/users/tambahuser') ?>",
        success: function(data) {
          $('#modal_body').html(data);
        },
        error: function() {
          alert("error");
        }
      });
  }

  function editperson(person_id) {
    $.ajax({
        url: "<?= base_url('admin/users/edituser') ?>",
        type: "post",
        dataType: "json",
        data: {
          "person_id": person_id
        },
        success: function(data) {
          $('#modal_body').html(data);
        },
        error: function() {
          alert("error");
        }
      });
  }

  function simpanuser() {
    
      var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
      var user_group = $("#user_group").val();
     
      $.ajax({
        url: "<?= base_url('admin/users/simpanuser') ?>",
        type: "post",
        dataType: "json",
        data: {
            "person_nm" : person_nm,
            "satuan" : satuan,
            "birth_place" : birth_place,
            "birth_dttm" : birth_dttm,
            "cellphone" : cellphone,
            "addr_txt" : addr_txt,
            "user_nm" : user_nm,
            "user_group" : user_group,
            "gender_cd" : gender_cd
        },
        success: function(data) {
          $('#modal-lg').modal("hide");
          alert("Sukses");
          var table = document.getElementById("example2");
          var row   = table.insertRow(1);
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);
          var cell6 = row.insertCell(5);
          var cell7 = row.insertCell(6);
          var cell8 = row.insertCell(7);
          var cell9 = row.insertCell(8);
          var cell10 = row.insertCell(9);
          cell1.style.textAlign = "center";
          cell2.style.textAlign = "center";
          cell3.style.textAlign = "justify";
          cell4.style.textAlign = "center";
          cell5.style.textAlign = "center";
          cell6.style.textAlign = "center";
          cell7.style.textAlign = "center";
          cell8.style.textAlign = "center";
          cell9.style.textAlign = "center";
          cell10.style.textAlign = "center";
          cell1.innerHTML = "new";
          cell2.innerHTML = person_nm;
          cell3.innerHTML = satuan;
          cell4.innerHTML = birth_place+","+birth_dttm;
          cell8.innerHTML = gender_cd;
          cell7.innerHTML = user_nm;
          cell5.innerHTML = cellphone;
          cell6.innerHTML = addr_txt;
          cell8.innerHTML = user_group;
          cell9.innerHTML = "<button data-bs-toggle='modal' data-bs-target='#modal-lg' onclick='editperson("+data.person_id+")' style='font-size:10px;' class='btn btn-secondary'>Edit</button> <button style='font-size:10px;' class='btn btn-danger' onclick='hapuspersom("+data.person_id+")'>Hapus</button>";
        },
        error: function() {
          alert("error");
        }
      });
  }
  

  function updateuser(person_id) {
    
    var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
      var user_group = $("#user_group").val();
   
    $.ajax({
      url: "<?= base_url('admin/users/updateuser') ?>",
      type: "post",
      dataType: "json",
      data: {
        "person_nm" : person_nm,
            "satuan" : satuan,
            "birth_place" : birth_place,
            "birth_dttm" : birth_dttm,
            "cellphone" : cellphone,
            "addr_txt" : addr_txt,
            "user_nm" : user_nm,
            "user_group" : user_group,
            "gender_cd" : gender_cd,
            "person_id" : person_id
      },
      success: function(data) {
        $('#modal-lg').modal("hide");
        alert("Sukses");
        $("#example2").load(window.location.href+" #example2");
      },
      error: function() {
        alert("error");
      }
    });
}

function hapusperson(person_id) {
    $.ajax({
      url: "<?= base_url('admin/users/hapususer') ?>",
      type: "post",
      dataType: "json",
      data: {
        "person_id": person_id
      },
      success: function(data) {
        $('#modal-lg').modal("hide");
        alert("Sukses");
        $("#example2").load(window.location.href+" #example2");
      },
      error: function() {
        alert("error");
      }
    });
}
</script>
</body>
</html>