<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Siswa Baru - Bintang Timur Prestasi</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/bootstrap.min.css">
    <!-- AdminLTE v4 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("<?= base_url() ?>/images/bg/bg-body.jpg");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 30px 15px;
        }

        .register-card-container {
            width: 100%;
            max-width: 650px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="register-card-container">
        <div class="text-white text-center py-4 px-3" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
            <h4 class="fw-bold mb-1">Pendaftaran Siswa Baru</h4>
            <p class="small text-white-50 mb-0">Lengkapi formulir di bawah ini untuk membuat akun simulasi</p>
        </div>

        <div class="p-4 p-md-5">
            <div class="row g-3">
                <div class="col-12">
                    <label for="person_nm" class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="Nama lengkap sesuai identitas" id="person_nm" name="person_nm" required>
                    </div>
                </div>

                <div class="col-12">
                    <label for="satuan" class="form-label small fw-semibold text-secondary">Satuan / Asal Instansi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-building text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="Contoh: Polres / Kodim / Kedinasan" id="satuan" name="satuan">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="birth_place" class="form-label small fw-semibold text-secondary">Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat lahir" id="birth_place" name="birth_place">
                </div>

                <div class="col-md-6">
                    <label for="birth_dttm" class="form-label small fw-semibold text-secondary">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="birth_dttm" name="birth_dttm">
                </div>

                <div class="col-md-6">
                    <label for="gender_cd" class="form-label small fw-semibold text-secondary">Jenis Kelamin</label>
                    <select class="form-select" id="gender_cd" name="gender_cd">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="cellphone" class="form-label small fw-semibold text-secondary">No. Handphone (WhatsApp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-phone text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="08xxxxxxxxxx" id="cellphone" name="cellphone" required>
                    </div>
                </div>

                <div class="col-12">
                    <label for="addr_txt" class="form-label small fw-semibold text-secondary">Alamat Lengkap</label>
                    <textarea class="form-control" rows="2" placeholder="Alamat domisili" id="addr_txt" name="addr_txt"></textarea>
                </div>

                <div class="col-12">
                    <label for="user_nm" class="form-label small fw-semibold text-secondary">Username (Untuk Login)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-id-badge text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="Buat username tanpa spasi" id="user_nm" name="user_nm" required>
                    </div>
                    <small class="text-muted">Password awal otomatis menggunakan default <strong>123456</strong>.</small>
                </div>

                <div class="col-12 mt-4 d-grid gap-2">
                    <button type="button" onclick="simpanregister()" class="btn btn-primary btn-lg rounded-pill fw-bold">
                        Daftar Sekarang <i class="fas fa-arrow-right ms-1"></i>
                    </button>
                    <a href="<?= base_url() ?>/login" class="btn btn-outline-secondary rounded-pill">
                        Sudah punya akun? Login di sini
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery & Bootstrap 5 Bundle JS -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
    <script>
    function simpanregister() {
        var person_nm   = $("#person_nm").val();
        var satuan      = $("#satuan").val();
        var birth_place = $("#birth_place").val();
        var birth_dttm  = $("#birth_dttm").val();
        var cellphone   = $("#cellphone").val();
        var addr_txt    = $("#addr_txt").val();
        var user_nm     = $("#user_nm").val();
        var gender_cd   = $("#gender_cd").val();

        if (!person_nm || !cellphone || !user_nm) {
            alert("Harap isi Nama, No. HP, dan Username!");
            return;
        }

        $.ajax({
            url: "<?= base_url('login/simpanregister') ?>",
            type: "post",
            dataType: "json",
            data: {
                "person_nm"   : person_nm,
                "satuan"      : satuan,
                "birth_place" : birth_place,
                "birth_dttm"  : birth_dttm,
                "cellphone"   : cellphone,
                "addr_txt"    : addr_txt,
                "user_nm"     : user_nm,
                "gender_cd"   : gender_cd
            },
            success: function(data) {
                if (data == "userada") {
                    alert("Nomor Handphone atau Username sudah terdaftar!");
                } else {
                    alert("Pendaftaran berhasil! Silakan login menggunakan username Anda.");
                    location.href = "<?= base_url() ?>/login";
                }
            },
            error: function() {
                alert("Terjadi kesalahan saat memproses pendaftaran.");
            }
        });
    }
    </script>
</body>
</html>
