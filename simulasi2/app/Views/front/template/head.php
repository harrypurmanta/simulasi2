<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Bintang Timur Prestasi - Simulasi CAT' ?></title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <!-- Font Awesome 5/6 -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/bootstrap.min.css">
    
    <!-- AdminLTE v4 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/adminlte4/css/adminlte.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/sweetalert2.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">

    <style>
        :root {
            --btp-primary: #1e3c72;
            --btp-secondary: #2a5298;
            --btp-accent: #38bdf8;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1 0 auto;
            background-color: #f4f6f9;
            padding: 24px 0;
        }

        .main-footer {
            flex-shrink: 0;
            background: #ffffff;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            padding: 15px 0;
        }

        /* Legacy Helper Bridges for BS3 -> BS5 */
        .btn-default {
            color: #212529;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }
        .btn-default:hover, .btn-default:focus {
            color: #212529;
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
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
        .bg-gray { background-color: #f1f5f9 !important; color: #1e293b !important; }
        .bg-blue { background-color: #2563eb !important; color: #ffffff !important; }
        .bg-green { background-color: #16a34a !important; color: #ffffff !important; }
        .bg-yellow { background-color: #eab308 !important; color: #000000 !important; }
        .bg-aqua { background-color: #06b6d4 !important; color: #ffffff !important; }
        .bg-red { background-color: #dc2626 !important; color: #ffffff !important; }

        /* Modern Small Box for AdminLTE 4 */
        .small-box {
            border-radius: 12px;
            position: relative;
            display: block;
            margin-bottom: 20px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            overflow: hidden;
            transition: all 0.25s ease-in-out;
            color: #fff;
        }
        .small-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }
        .small-box > .inner {
            padding: 20px;
        }
        .small-box > .inner h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            white-space: nowrap;
            padding: 0;
        }
        .small-box .icon {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 0;
            font-size: 50px;
            color: rgba(255, 255, 255, 0.25);
            transition: transform 0.3s ease;
        }
        .small-box:hover .icon {
            transform: scale(1.1);
        }
        .small-box > .small-box-footer {
            position: relative;
            text-align: center;
            padding: 8px 0;
            color: rgba(255,255,255,0.9);
            display: block;
            z-index: 10;
            background: rgba(0,0,0,0.12);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .small-box > .small-box-footer:hover {
            background: rgba(0,0,0,0.22);
            color: #fff;
        }

        /* Modern Box / Card for Front */
        .box {
            position: relative;
            border-radius: 12px;
            background: #ffffff;
            border-top: 3px solid #dee2e6;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .box.box-primary {
            border-top-color: var(--btp-primary);
        }
        .box.box-info {
            border-top-color: #00c0ef;
        }
        .box.box-success {
            border-top-color: #00a65a;
        }
        .box.box-warning {
            border-top-color: #f39c12;
        }
        .box.box-danger {
            border-top-color: #dd4b39;
        }
        .box-header {
            color: #444;
            display: block;
            padding: 14px 20px;
            position: relative;
            border-bottom: 1px solid #f4f4f4;
        }
        .box-header .box-title {
            display: inline-block;
            font-size: 18px;
            margin: 0;
            line-height: 1;
            font-weight: 600;
        }
        .box-body {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 12px;
            border-bottom-left-radius: 12px;
            padding: 20px;
        }

        /* Callout */
        .callout {
            border-radius: 10px;
            margin: 0 0 20px 0;
            padding: 18px 22px;
            border-left: 5px solid #eee;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .callout-info {
            border-left-color: #0dcaf0;
            background-color: #e8f9fd;
            color: #055160;
        }
        .callout-warning {
            border-left-color: #ffc107;
            background-color: #fff9e6;
            color: #664d03;
        }
        .callout-success {
            border-left-color: #198754;
            background-color: #e8f5e9;
            color: #0f5132;
        }
        .callout-danger {
            border-left-color: #dc3545;
            background-color: #fde8e8;
            color: #842029;
        }

        /* Small box latihan card */
        .small-box-latihan {
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            transition: all 0.25s ease-in-out;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }
        .small-box-latihan:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            border-color: #3b82f6;
        }
        .small-box-latihan .inner {
            padding: 22px 18px;
            min-height: 95px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .small-box-latihan .inner h4 {
            margin: 0;
            font-weight: 600;
            color: #1e293b;
            font-size: 16px;
            line-height: 1.4;
        }
        .small-box-latihan .small-box-footer {
            display: block;
            padding: 12px 15px;
            color: #ffffff;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            text-align: center;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s;
            cursor: pointer;
        }
        .small-box-latihan .small-box-footer:hover {
            opacity: 0.92;
            color: #ffffff;
        }

        #loader-wrapper {
            display: flex;
            position: fixed;
            z-index: 9999;
            top: 0; right: 0; bottom: 0; left: 0;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.7);
        }
        .loader {
            border: 6px solid #f3f3f3;
            border-radius: 50%;
            border-top: 6px solid #1e3c72;
            width: 48px;
            height: 48px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Responsive Exam Layout & Component System */
        #dv_boxnosoal, .box-no-soal-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(44px, 1fr)) !important;
            gap: 6px !important;
            max-height: 480px;
            overflow-y: auto;
            padding: 4px;
        }
        #dv_boxnosoal div, .box-no-soal-grid div {
            width: 100% !important;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px !important;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            user-select: none;
            box-sizing: border-box !important;
            margin: 0 !important;
        }
        #dv_boxnosoal div:hover, .box-no-soal-grid div:hover {
            transform: scale(1.06);
            z-index: 2;
        }
        .jawaban_dv {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            user-select: none;
            border: 2px solid transparent !important;
        }
        .jawaban_dv:hover {
            background-color: #e2e8f0 !important;
            transform: translateX(4px);
        }
        #dv_img_soal img, #dv_pembahasan img {
            max-width: 100% !important;
            height: auto !important;
            border-radius: 8px;
        }
        /* Responsive Sikap Kerja (Tes Kecermatan) */
        #dv_soal {
            width: 100%;
            overflow-x: hidden;
        }
        #dv_soal table {
            margin: 0 auto;
            max-width: 100% !important;
        }
        @media (max-width: 768px) {
            #dv_boxnosoal, .box-no-soal-grid {
                grid-template-columns: repeat(auto-fill, minmax(38px, 1fr)) !important;
                max-height: 320px;
            }
            #dv_boxnosoal div, .box-no-soal-grid div {
                min-height: 34px;
                font-size: 11px !important;
            }
            #dv_soal table tr:first-child {
                font-size: clamp(30px, 9vw, 55px) !important;
            }
            #dv_soal table td {
                width: clamp(38px, 16vw, 65px) !important;
                padding: 2px !important;
            }
            #dv_soal table tr:nth-child(2) {
                font-size: clamp(18px, 5vw, 26px) !important;
            }
            #dv_soal .col-md-2 {
                font-size: clamp(32px, 9vw, 50px) !important;
                min-height: 50px !important;
                min-width: 44px !important;
                margin: 4px !important;
            }
            #dv_soal img {
                max-width: 55px !important;
                height: auto !important;
            }
            .content-wrapper {
                padding: 15px 0 !important;
            }
        }
    </style>
</head>
