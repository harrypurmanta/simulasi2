<?php
$session = \Config\Services::session();
$request = \Config\Services::request();
$segments = $request->getUri()->getSegments();
$activeMenu = $segments[1] ?? 'dashboard';
if (empty($activeMenu) || $activeMenu === 'dashboard') {
    $activeMenu = 'home';
}
?>
<nav class="main-header navbar navbar-expand-lg navbar-dark shadow-sm py-1" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important; min-height: 50px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
  <div class="container-fluid px-3 px-lg-4">
    <a href="<?= base_url('admin') ?>" class="navbar-brand d-flex align-items-center me-3 py-0 text-decoration-none">
      <i class="fas fa-shield-alt text-warning me-2" style="font-size: 1.25rem;"></i>
      <span class="fw-bold text-white fs-6 lh-1">Bintang Timur</span>
      <span class="badge bg-primary text-white ms-2" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">ADMIN</span>
    </a>

    <button class="navbar-toggler py-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminCollapse" aria-controls="navbarAdminCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="width: 1.2em; height: 1.2em;"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarAdminCollapse">
      <!-- Centered navbar links -->
      <ul class="navbar-nav mx-auto mb-0" style="font-size: 13.5px;">
        <li class="nav-item">
          <a href="<?= base_url('admin') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'home' || empty($segments[1])) ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-tachometer-alt me-1 text-info"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/soal') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'soal') ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-file-alt me-1 text-primary"></i> Soal CAT
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/soalsikapkerjamateri') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'soalsikapkerjamateri') ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-stopwatch me-1 text-warning"></i> SK Materi
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/soallatihan') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'soallatihan') ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-book-open me-1 text-success"></i> Soal Latihan
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/soalsikapkerjalatihan') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'soalsikapkerjalatihan') ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-stopwatch-20 me-1 text-danger"></i> SK Latihan
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/token') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'token') ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-key me-1 text-warning"></i> Token
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/users') ?>" class="nav-link py-1 px-2 <?= ($activeMenu === 'users') ? 'active fw-bold text-white' : 'text-white-50' ?>">
            <i class="fas fa-users me-1 text-info"></i> Users
          </a>
        </li>
      </ul>

      <!-- Right user & logout actions -->
      <ul class="navbar-nav ms-auto mb-0 align-items-lg-center" style="font-size: 13px;">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link py-1 dropdown-toggle d-flex align-items-center text-white" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 12px; font-weight: 700;">
              <i class="fas fa-user-shield"></i>
            </div>
            <span class="d-none d-md-inline fw-semibold"><?= esc($session->user_nm ?? 'Admin') ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="adminDropdown" style="min-width: 200px; border-radius: 12px; margin-top: 8px;">
            <li class="px-3 py-2 bg-light border-bottom rounded-top text-center">
              <span class="badge bg-primary mb-1">Administrator</span>
              <h6 class="mb-0 fw-bold text-dark small"><?= esc($session->user_nm ?? 'Admin') ?></h6>
              <small class="text-muted" style="font-size: 11px;">Level: <?= esc($session->user_group ?? 'Owner') ?></small>
            </li>
            <li class="p-2">
              <a href="<?= base_url('login/logout') ?>" class="btn btn-sm btn-danger w-100 rounded-pill py-1">
                <i class="fas fa-sign-out-alt me-1"></i> Keluar / Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>