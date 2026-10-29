<?php
$session = \Config\Services::session();
$request = \Config\Services::request();
$segments = $request->getUri()->getSegments();
$currentSegment = $segments[0] ?? '';
$secondSegment = $segments[1] ?? '';
?>
<nav class="app-header navbar navbar-expand-lg navbar-dark shadow-sm py-1" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important; min-height: 46px !important;">
    <div class="container-fluid px-3 px-lg-4">
        <a href="<?= base_url('home') ?>" class="navbar-brand d-flex align-items-center me-3 ms-lg-2 py-0 text-decoration-none">
            <i class="fas fa-graduation-cap text-warning me-2" style="font-size: 1.2rem;"></i>
            <span class="fw-bold text-white" style="font-size: 0.92rem;">Bintang Timur Prestasi</span>
            <span class="text-white-50 ms-2 d-none d-sm-inline" style="font-size: 11px;">• Simulasi CAT Psikologi</span>
        </a>

        <button class="navbar-toggler py-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="width: 1.25em; height: 1.25em;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <?php if ($currentSegment !== "tryout"): ?>
                <ul class="navbar-nav mx-auto mb-0" style="font-size: 13.5px; padding-top: 3px;">
                    <li class="nav-item">
                        <a href="<?= base_url('home') ?>" class="nav-link py-1 px-2 <?= ($currentSegment == 'home' || $currentSegment == '') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('materi') ?>" class="nav-link py-1 px-2 <?= ($currentSegment == 'materi') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-book me-1"></i> Materi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pembahasan') ?>" class="nav-link py-1 px-2 <?= ($currentSegment == 'pembahasan') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-search me-1"></i> Pembahasan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('sikapkerja') ?>" class="nav-link py-1 px-2 <?= ($currentSegment == 'sikapkerja') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-stopwatch me-1"></i> Sikap Kerja
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('latihan') ?>" class="nav-link py-1 px-2 <?= ($currentSegment == 'latihan') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-tasks me-1"></i> Latihan Soal
                        </a>
                    </li>
                </ul>
            <?php elseif ($secondSegment !== "hasiltryout"): ?>
                <ul class="navbar-nav mx-auto mb-0" style="font-size: 13.5px; padding-top: 3px;">
                    <li class="nav-item">
                        <a href="<?= base_url('materi') ?>" class="nav-link py-1 px-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Materi
                        </a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav mx-auto mb-0" style="padding-top: 3px;"></ul>
            <?php endif; ?>

            <ul class="navbar-nav ms-auto mb-0 align-items-lg-center me-lg-2" style="font-size: 13px;">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link py-1 dropdown-toggle d-flex align-items-center text-white" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url('dist/img/user2-160x160.jpg') ?>" class="rounded-circle me-2 border border-2 border-white-50" width="28" height="28" alt="User Image">
                        <span class="d-none d-md-inline fw-semibold"><?= esc($session->person_nm ?? $session->user_nm ?? 'Siswa') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown" style="min-width: 240px;">
                        <li class="px-3 py-3 text-center bg-light border-bottom rounded-top">
                            <img src="<?= base_url('dist/img/user2-160x160.jpg') ?>" class="rounded-circle mb-2 border border-2 border-primary" width="60" height="60" alt="User Image">
                            <h6 class="mb-0 fw-bold text-dark"><?= esc($session->person_nm ?? $session->user_nm ?? 'Siswa') ?></h6>
                            <small class="text-muted d-block"><?= esc($session->satuan ?? '-') ?></small>
                            <?php if (!empty($session->birth_dttm)): ?>
                                <small class="text-muted" style="font-size: 11px;">Tgl Lahir: <?= esc($session->birth_dttm) ?></small>
                            <?php endif; ?>
                        </li>
                        <li class="p-2">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('profile') ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-user me-1"></i> Profil
                                </a>
                                <a href="<?= base_url('login/logout') ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>