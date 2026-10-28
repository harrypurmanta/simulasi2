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
            <h1>Data Users</h1>
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
              <button onclick="tambahuser()" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-lg">Tambah</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center;">No.</th>
                    <th style="text-align:center;">Nama</th>
                    <th style="text-align:center;">Satuan</th>
                    <th style="text-align:center;">TTL</th>
                    <th style="text-align:center;">Jenis Kelamin</th>
                    <th style="text-align:center;">Username</th>
                    <th style="text-align:center;">No. Hp</th>
                    <th style="text-align:center;">Alamat</th>
                    <th style="text-align:center;">Level</th>
                    <th style="text-align:center;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                        foreach ($users as $key) {
                         
                    ?>
                  <tr>
                    <td style="text-align:center;"><?= $no++ ?></td>
                    <td><?= $key->person_nm ?></td>
                    <td style="text-align:center;"><?= $key->satuan ?></td>
                    <td style="text-align:center;"><?= $key->birth_place ?>, <?= $key->birth_dttm ?></td>
                    <td style="text-align:center;"><?= $key->gender_cd ?></td>
                    <td style="text-align:center;"><?= $key->user_nm ?></td>
                    <td style="text-align:center;"><?= $key->cellphone ?></td>
                    <td><?= $key->addr_txt ?></td>
                    <td><?= $key->user_group ?></td>
                    <td style="text-align:center;"><button onclick="editperson(<?= $key->person_id ?>)" style="font-size:10px;" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-lg"><i class="fa fa-pencil-alt"></i></button> <button onclick="hapusperson(<?= $key->person_id ?>)" style="font-size:10px;" class="btn btn-danger"><i class="fa fa-trash"></i></button> 
                    <a href="<?= base_url() ?>/admin/hasil/<?= $key->user_id ?>" target="_blank"><button type="button" class="btn btn-primary">Detail</button></a>
                    <a href="<?= base_url() ?>/admin/users/resetmateri/<?= $key->user_id ?>" target="_blank" class="btn btn-warning">Reset</a> 
                   
                  </td>
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
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form User</h5>
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