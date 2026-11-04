<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Portal - Bintang Timur Prestasi</title>
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/bootstrap.min.css') ?>">
  <!-- Theme style AdminLTE v4 -->
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/adminlte.min.css') ?>">
  <!-- DataTables BS5 -->
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/dataTables.bootstrap5.min.css') ?>">
  <!-- Summernote BS5 -->
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/summernote-bs5.min.css') ?>">
  <!-- Select2 BS5 -->
  <link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/adminlte4/css/select2-bootstrap-5-theme.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('dist/css/sweetalert2.css') ?>">
  
  <style>
    :root {
      --admin-primary: #1e3c72;
      --admin-secondary: #2a5298;
      --admin-bg: #f8fafc;
      --admin-card-bg: #ffffff;
      --admin-border: #e2e8f0;
      --admin-text-main: #1e293b;
      --admin-text-muted: #64748b;
    }

    * {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
      background-color: var(--admin-bg) !important;
      color: var(--admin-text-main);
      font-size: 13.5px;
    }

    .content-wrapper {
      background-color: var(--admin-bg) !important;
    }

    /* Content Header */
    .content-header {
      padding: 18px 0 14px 0;
    }

    .content-header h1 {
      font-size: 1.45rem;
      font-weight: 700;
      color: #0f172a;
      letter-spacing: -0.3px;
    }

    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 0;
      font-size: 12.5px;
    }

    .breadcrumb-item a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 500;
    }

    /* Cards */
    .card {
      border: 1px solid var(--admin-border) !important;
      border-radius: 14px !important;
      box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03) !important;
      background: var(--admin-card-bg);
      margin-bottom: 1.5rem;
      overflow: hidden;
      transition: all 0.2s ease;
    }

    .card-header {
      background-color: #ffffff !important;
      border-bottom: 1px solid var(--admin-border) !important;
      padding: 0.85rem 1.25rem !important;
      font-weight: 600;
      color: #0f172a;
    }

    .card-header .card-title {
      font-size: 1rem;
      font-weight: 700;
      margin: 0;
    }

    .card-body {
      padding: 1.25rem !important;
    }

    /* Tables */
    .table {
      font-size: 13px;
      vertical-align: middle;
      border-color: var(--admin-border);
    }

    .table thead th {
      background: #f1f5f9 !important;
      color: #334155;
      font-weight: 700;
      text-transform: uppercase;
      font-size: 11.5px;
      letter-spacing: 0.4px;
      border-bottom: 2px solid var(--admin-border);
      padding: 10px 12px;
      white-space: nowrap;
    }

    .table tbody td {
      padding: 10px 12px;
      border-bottom: 1px solid #f1f5f9;
      color: #334155;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(59, 130, 246, 0.04) !important;
    }

    /* DataTables Enhancements */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #cbd5e1 !important;
      border-radius: 8px !important;
      padding: 4px 10px !important;
      font-size: 13px !important;
      outline: none;
    }

    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    .dataTables_wrapper .dataTables_paginate .page-link {
      border-radius: 6px !important;
      margin: 0 2px;
      font-size: 12.5px;
      padding: 4px 10px;
    }

    .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
      border-color: #1e3c72 !important;
    }

    /* Buttons */
    .btn {
      font-size: 13px;
      font-weight: 600;
      border-radius: 8px;
      padding: 6px 14px;
      transition: all 0.2s ease;
    }

    .btn-sm {
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 6px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      border: none;
      box-shadow: 0 2px 6px rgba(30, 60, 114, 0.25);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #162d56 0%, #1e3c72 100%);
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(30, 60, 114, 0.35);
    }

    .btn-success {
      background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
      border: none;
    }

    .btn-danger {
      background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
      border: none;
    }

    .btn-warning {
      background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
      border: none;
      color: #ffffff;
    }

    .btn-warning:hover {
      color: #ffffff;
    }

    /* Modern Stats Boxes / Small Box */
    .small-box {
      border-radius: 14px !important;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08) !important;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      border: none !important;
    }

    .small-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 22px rgba(0, 0, 0, 0.12) !important;
    }

    .small-box .inner {
      padding: 1.25rem 1.25rem 0.75rem 1.25rem !important;
      position: relative;
      z-index: 2;
    }

    .small-box .inner h3 {
      font-size: 1.85rem;
      font-weight: 800;
      margin-bottom: 4px;
      letter-spacing: -0.5px;
    }

    .small-box .inner p {
      font-size: 0.85rem;
      font-weight: 500;
      opacity: 0.9;
      margin-bottom: 0;
    }

    .small-box .icon {
      position: absolute;
      right: 15px;
      top: 15px;
      opacity: 0.2;
      transition: transform 0.3s ease;
    }

    .small-box:hover .icon {
      transform: scale(1.15);
      opacity: 0.28;
    }

    .small-box-footer {
      background: rgba(0, 0, 0, 0.12) !important;
      padding: 6px 12px !important;
      font-size: 12px !important;
      font-weight: 600;
      transition: background 0.2s ease;
    }

    .small-box-footer:hover {
      background: rgba(0, 0, 0, 0.2) !important;
    }

    .bg-info-gradient {
      background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%) !important;
      color: #ffffff !important;
    }

    .bg-success-gradient {
      background: linear-gradient(135deg, #15803d 0%, #16a34a 100%) !important;
      color: #ffffff !important;
    }

    .bg-warning-gradient {
      background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%) !important;
      color: #ffffff !important;
    }

    .bg-danger-gradient {
      background: linear-gradient(135deg, #be123c 0%, #e11d48 100%) !important;
      color: #ffffff !important;
    }

    /* Modals */
    .modal-content {
      border: none !important;
      border-radius: 16px !important;
      box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2) !important;
      overflow: hidden;
    }

    .modal-header {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
      color: #ffffff !important;
      padding: 14px 20px !important;
      border-bottom: none !important;
    }

    .modal-header .modal-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #ffffff;
    }

    .modal-header .btn-close {
      filter: brightness(0) invert(1);
    }

    .modal-body {
      padding: 1.5rem !important;
      background: #f8fafc;
    }

    .modal-footer {
      border-top: 1px solid var(--admin-border) !important;
      background: #ffffff;
      padding: 10px 20px !important;
    }

    /* Form Controls */
    .form-control, .form-select {
      border: 1px solid #cbd5e1 !important;
      border-radius: 8px !important;
      font-size: 13px !important;
      padding: 6px 12px !important;
    }

    .form-control:focus, .form-select:focus {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }

    .form-label {
      font-weight: 600;
      font-size: 12.5px;
      color: #334155;
      margin-bottom: 4px;
    }

    /* Badges */
    .badge {
      font-weight: 600;
      padding: 0.35em 0.7em;
      border-radius: 6px;
      font-size: 11.5px;
    }

    /* Select2 Bootstrap 5 Enhancements */
    .select2-container--bootstrap-5 .select2-selection {
      border: 1px solid #cbd5e1 !important;
      border-radius: 8px !important;
      font-size: 13px !important;
      min-height: 38px !important;
      display: flex !important;
      align-items: center !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .select2-container--bootstrap-5 .select2-dropdown {
      border-color: #cbd5e1 !important;
      border-radius: 8px !important;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12) !important;
      font-size: 13px !important;
      z-index: 9999 !important;
    }
    .select2-container--bootstrap-5 .select2-dropdown .select2-results__option--highlighted[aria-selected] {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
      color: #ffffff !important;
    }
    .select2-container {
      width: 100% !important;
    }

    /* Legacy compatibility bridges */
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

    /* Loader */
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
      background-color: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(4px);
    }

    .loader {
      border: 6px solid #e2e8f0;
      border-radius: 50%;
      border-top: 6px solid #3b82f6;
      width: 46px;
      height: 46px;
      animation: spin 1s linear infinite;
      margin: 1.75rem auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>