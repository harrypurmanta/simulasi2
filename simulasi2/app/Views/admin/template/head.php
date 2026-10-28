<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Soal</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/bootstrap.min.css">
  <!-- Theme style AdminLTE v4 -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/adminlte.min.css">
  <!-- DataTables BS5 -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/dataTables.bootstrap5.min.css">
  <!-- Summernote BS5 -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/summernote-bs5.min.css">
  <!-- Select2 BS5 -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/select2-bootstrap-5-theme.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/sweetalert2.css">
  <style>
    /* Legacy BS3/BS4 to BS5 compatibility bridges */
    .pull-right, .float-right { float: right !important; }
    .pull-left, .float-left { float: left !important; }
    .label {
      display: inline-block;
      padding: 0.25em 0.6em;
      font-size: 75%;
      font-weight: 700;
      line-height: 1;
      text-align: center;
      white-space: nowrap;
      vertical-align: baseline;
      border-radius: 0.25rem;
    }
    .label-primary { background-color: #0d6efd; color: #fff; }
    .label-success { background-color: #198754; color: #fff; }
    .label-info { background-color: #0dcaf0; color: #000; }
    .label-warning { background-color: #ffc107; color: #000; }
    .label-danger { background-color: #dc3545; color: #fff; }
    .btn-default {
      color: #212529;
      background-color: #f8f9fa;
      border: 1px solid #ced4da;
    }
    .btn-default:hover {
      background-color: #e9ecef;
      border-color: #adb5bd;
    }

    #loader-wrapper {
	display: flex;
	position: fixed;
	z-index: 1060;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	flex-direction: row;
	align-items: center;
	justify-content: center;
	padding: 0.625em;
	overflow-x: hidden;
	transition: background-color 0.1s;
	background-color: rgb(253 253 253 / 58%);
	-webkit-overflow-scrolling: touch;
}

.loader {
	border: 10px solid #f3f3f3;
	border-radius: 50%;
	border-top: 10px solid #3af3f5;
	border-bottom: 10px solid #3abcec;
	width: 50px;
	height: 50px;
	-webkit-animation: spin 2s linear infinite;
	animation: spin 2s linear infinite;
	margin: 1.75rem auto;
}

	

		@keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-moz-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-webkit-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-o-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-ms-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-webkit-keyframes spin {
		  0% {
		    -webkit-transform: rotate(0deg);
		  }
		  100% {
		    -webkit-transform: rotate(360deg);
		  }
		}

		@keyframes spin {
		  0% {
		    transform: rotate(0deg);
		  }
		  100% {
		    transform: rotate(360deg);
		  }
		}
  </style>
</head>