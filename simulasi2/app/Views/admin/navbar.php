<nav class="main-header navbar navbar-expand-md navbar-light bg-dark" style="background-color: rgb(52, 78, 65) !important;">
    <div class="container">
      <a href="<?= base_url() ?>" class="navbar-brand">
        <span class="brand-text fw-bold" style="color:#ffffff;">Bintang Timur</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin" class="nav-link" style="color:#ffffff;">Home</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/soal" class="nav-link" style="color:#ffffff;">Soal</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/soalsikapkerjamateri" class="nav-link" style="color:#ffffff;">SK Materi</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/soallatihan" class="nav-link" style="color:#ffffff;">Soal latihan</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/soalsikapkerjalatihan" class="nav-link" style="color:#ffffff;">SK latihan</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/token" class="nav-link" style="color:#ffffff;">Token</a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/admin/users" class="nav-link" style="color:#ffffff;">Users</a>
          </li>
        </ul>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ms-auto">
          <li class="nav-item">
            <a href="<?= base_url() ?>/login/logout" class="nav-link" style="color:#ffffff;">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>