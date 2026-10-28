<?php
$session = \Config\Services::session();
$request = \Config\Services::request();
$segments = $request->getUri()->getSegments();
$currentSegment = $segments[0] ?? '';
$secondSegment = $segments[1] ?? '';
?>
<nav class="app-header navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;">
    <div class="container">
        <a href="<?= base_url() ?>/home" class="navbar-brand d-flex align-items-center me-4 text-decoration-none">
            <i class="fas fa-graduation-cap fa-lg text-warning me-2"></i>
            <div>
                <span class="fw-bold fs-6 text-white d-block lh-1">Simulasi CAT Psikologi</span>
                <small class="text-white-50" style="font-size: 11px;">Bintang Timur Prestasi</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <?php if ($currentSegment !== "tryout"): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/home" class="nav-link <?= ($currentSegment == 'home' || $currentSegment == '') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/materi" class="nav-link <?= ($currentSegment == 'materi') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-book me-1"></i> Materi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/pembahasan" class="nav-link <?= ($currentSegment == 'pembahasan') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-search me-1"></i> Pembahasan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/sikapkerja" class="nav-link <?= ($currentSegment == 'sikapkerja') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-stopwatch me-1"></i> Sikap Kerja
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/latihan" class="nav-link <?= ($currentSegment == 'latihan') ? 'active fw-bold' : '' ?>">
                            <i class="fas fa-tasks me-1"></i> Latihan Soal
                        </a>
                    </li>
                </ul>
            <?php elseif ($secondSegment !== "hasiltryout"): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="<?= base_url() ?>/materi" class="nav-link">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Materi
                        </a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <?php endif; ?>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center text-white" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="rounded-circle me-2 border border-2 border-white-50" width="34" height="34" alt="User Image">
                        <span class="d-none d-md-inline fw-semibold"><?= esc($session->person_nm ?? $session->user_nm ?? 'Siswa') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown" style="min-width: 240px;">
                        <li class="px-3 py-3 text-center bg-light border-bottom rounded-top">
                            <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="rounded-circle mb-2 border border-2 border-primary" width="60" height="60" alt="User Image">
                            <h6 class="mb-0 fw-bold text-dark"><?= esc($session->person_nm ?? $session->user_nm ?? 'Siswa') ?></h6>
                            <small class="text-muted d-block"><?= esc($session->satuan ?? '-') ?></small>
                            <?php if (!empty($session->birth_dttm)): ?>
                                <small class="text-muted" style="font-size: 11px;">Tgl Lahir: <?= esc($session->birth_dttm) ?></small>
                            <?php endif; ?>
                        </li>
                        <li class="p-2">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url() ?>/profile" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-user me-1"></i> Profil
                                </a>
                                <a href="<?= base_url() ?>/login/logout" class="btn btn-sm btn-danger">
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