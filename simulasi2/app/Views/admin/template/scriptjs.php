<!-- jQuery -->
<script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 5 Bundle -->
<script src="<?= base_url('dist/adminlte4/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE 4 App -->
<script src="<?= base_url('dist/adminlte4/js/adminlte.min.js') ?>"></script>
<!-- DataTables & Plugins BS5 -->
<script src="<?= base_url('dist/adminlte4/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('dist/adminlte4/js/dataTables.bootstrap5.min.js') ?>"></script>
<!-- Summernote BS5 -->
<script src="<?= base_url('dist/adminlte4/js/summernote-bs5.min.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('dist/js/sweetalert2.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

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

    // Global Select2 auto-initializer for all <select> elements in Admin
    window.initAdminSelect2 = function(context) {
      if (typeof jQuery.fn.select2 === 'undefined') return;
      var $root = context ? $(context) : $(document);
      $root.find('select').each(function() {
        var $this = $(this);
        // Exclude DataTables pagination/length select or already initialized select2 or special ajax selects
        if ($this.hasClass('select2-hidden-accessible') || 
            $this.closest('.dataTables_length').length > 0 || 
            $this.attr('id') === 'user_tambah' ||
            $this.hasClass('no-select2')) {
          return;
        }

        var $modal = $this.closest('.modal');
        var selectOptions = {
          theme: 'bootstrap-5',
          width: '100%',
          placeholder: $this.attr('placeholder') || ($this.find('option:first').val() === '' ? $this.find('option:first').text() : 'Pilih opsi...')
        };

        if ($modal.length > 0) {
          selectOptions.dropdownParent = $modal;
        }

        $this.select2(selectOptions);
      });
    };

    $(document).ready(function() {
      window.initAdminSelect2();

      // Automatically re-initialize on any modal open
      $(document).on('shown.bs.modal', '.modal', function() {
        window.initAdminSelect2(this);
      });

      // Automatically re-initialize on any AJAX complete (e.g. dynamic modal body forms)
      $(document).ajaxComplete(function(event, xhr, settings) {
        setTimeout(function() {
          window.initAdminSelect2();
        }, 100);
      });
    });
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