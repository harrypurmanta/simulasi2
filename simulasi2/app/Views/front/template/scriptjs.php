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
</script>
