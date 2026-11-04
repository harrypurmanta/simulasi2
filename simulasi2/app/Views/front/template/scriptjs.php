<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 5 Bundle (Popper included) -->
<script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE v4 App -->
<script src="<?= base_url() ?>/dist/adminlte4/js/adminlte.min.js"></script>

<!-- SweetAlert2 -->
<script src="<?= base_url() ?>/dist/js/sweetalert2.js"></script>

<script>
    // Bootstrap 5 Compatibility Bridge for jQuery Modal calls
    if (typeof jQuery !== 'undefined') {
        jQuery.fn.modal = function(action) {
            return this.each(function() {
                var modal = bootstrap.Modal.getOrCreateInstance(this);
                if (action === 'show') {
                    modal.show();
                } else if (action === 'hide') {
                    modal.hide();
                } else if (action === 'toggle') {
                    modal.toggle();
                }
            });
        };
        jQuery.fn.tab = function(action) {
            return this.each(function() {
                var tab = bootstrap.Tab.getOrCreateInstance(this);
                if (action === 'show') {
                    tab.show();
                }
            });
        };
    }

    // Global override alert() -> SweetAlert2
    if (typeof Swal !== 'undefined') {
        window.alert = function(message) {
            var msg = String(message || '');
            var lower = msg.toLowerCase();
            var icon = 'info';
            var title = 'Informasi';
            if (lower.indexOf('sukses') !== -1 || lower.indexOf('berhasil') !== -1) {
                icon = 'success';
                title = 'Berhasil';
            } else if (lower.indexOf('error') !== -1 || lower.indexOf('gagal') !== -1 || lower.indexOf('salah') !== -1) {
                icon = 'error';
                title = 'Error';
            } else if (lower.indexOf('belum') !== -1 || lower.indexOf('tidak') !== -1 || lower.indexOf('kurang') !== -1 || lower.indexOf('pilih') !== -1 || lower.indexOf('harap') !== -1) {
                icon = 'warning';
                title = 'Perhatian';
            }
            return Swal.fire({
                title: title,
                text: msg,
                icon: icon,
                confirmButtonText: 'OK'
            });
        };
    }
</script>
