<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 5 Bundle -->
<script src="<?= base_url() ?>/dist/adminlte4/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE 4 App -->
<script src="<?= base_url() ?>/dist/adminlte4/js/adminlte.min.js"></script>
<!-- DataTables & Plugins BS5 -->
<script src="<?= base_url() ?>/dist/adminlte4/js/dataTables.min.js"></script>
<script src="<?= base_url() ?>/dist/adminlte4/js/dataTables.bootstrap5.min.js"></script>
<!-- Summernote BS5 -->
<script src="<?= base_url() ?>/dist/adminlte4/js/summernote-bs5.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>/dist/js/sweetalert2.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>

<script>
  // Bootstrap 5 jQuery Modal / Tab Bridge
  if (typeof jQuery !== 'undefined') {
    jQuery.fn.modal = function(action) {
      return this.each(function() {
        var modal = bootstrap.Modal.getOrCreateInstance(this);
        if (action === 'show') modal.show();
        else if (action === 'hide') modal.hide();
        else if (action === 'toggle') modal.toggle();
      });
    };
  }
</script>