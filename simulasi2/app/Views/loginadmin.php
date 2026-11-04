<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Portal - Bintang Timur Prestasi</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
  
  <style>
    :root {
      --primary: #3b82f6;
      --primary-hover: #2563eb;
      --accent: #6366f1;
      --bg-dark: #0b0f19;
      --card-bg: rgba(17, 24, 39, 0.78);
      --card-border: rgba(255, 255, 255, 0.08);
      --input-bg: rgba(15, 23, 42, 0.65);
      --input-border: rgba(255, 255, 255, 0.12);
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
    }

    html, body {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      height: 100vh;
      max-height: 100vh;
      background-color: var(--bg-dark);
      color: var(--text-main);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: clamp(0.75rem, 2vh, 1.5rem);
      position: relative;
      overflow: hidden;
    }

    /* Ambient Background Glow */
    .ambient-glow {
      position: fixed;
      border-radius: 50%;
      filter: blur(100px);
      z-index: 0;
      pointer-events: none;
      opacity: 0.5;
      animation: floatGlow 12s ease-in-out infinite alternate;
    }

    .glow-1 {
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, #3b82f6, #1d4ed8);
      top: -100px;
      left: -100px;
    }

    .glow-2 {
      width: 450px;
      height: 450px;
      background: radial-gradient(circle, #6366f1, #4338ca);
      bottom: -120px;
      right: -80px;
      animation-delay: -6s;
    }

    .glow-3 {
      width: 280px;
      height: 280px;
      background: radial-gradient(circle, #06b6d4, #0284c7);
      top: 40%;
      left: 60%;
      opacity: 0.25;
      animation-delay: -3s;
    }

    @keyframes floatGlow {
      0% {
        transform: translate(0, 0) scale(1);
      }
      100% {
        transform: translate(25px, 30px) scale(1.06);
      }
    }

    /* Subtle Grid Overlay */
    .grid-pattern {
      position: fixed;
      inset: 0;
      background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
      background-size: 26px 26px;
      z-index: 1;
      pointer-events: none;
    }

    /* Login Card Container */
    .login-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 410px;
      margin: auto;
    }

    .login-card {
      background: var(--card-bg);
      backdrop-filter: blur(24px) saturate(180%);
      -webkit-backdrop-filter: blur(24px) saturate(180%);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: clamp(1.2rem, 2.5vh, 1.75rem) clamp(1.25rem, 3.5vw, 2rem);
      box-shadow: 
        0 20px 40px -15px rgba(0, 0, 0, 0.7),
        0 0 0 1px rgba(255, 255, 255, 0.05),
        0 0 50px -15px rgba(59, 130, 246, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
      box-shadow: 
        0 25px 50px -15px rgba(0, 0, 0, 0.8),
        0 0 0 1px rgba(255, 255, 255, 0.08),
        0 0 65px -10px rgba(59, 130, 246, 0.26);
    }

    /* Brand Header */
    .brand-header {
      text-align: center;
      margin-bottom: clamp(0.75rem, 1.8vh, 1.25rem);
    }

    .logo-badge {
      width: clamp(44px, 5.5vh, 52px);
      height: clamp(44px, 5.5vh, 52px);
      margin: 0 auto clamp(0.4rem, 1vh, 0.75rem);
      background: linear-gradient(135deg, #3b82f6, #6366f1);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px -4px rgba(59, 130, 246, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.3);
      position: relative;
    }

    .logo-badge::after {
      content: '';
      position: absolute;
      inset: -3px;
      border-radius: 17px;
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.4), rgba(99, 102, 241, 0));
      z-index: -1;
    }

    .logo-badge i {
      font-size: clamp(1.2rem, 2.3vh, 1.45rem);
      color: #ffffff;
    }

    .portal-tag {
      display: inline-block;
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #60a5fa;
      background: rgba(59, 130, 246, 0.12);
      border: 1px solid rgba(59, 130, 246, 0.25);
      padding: 0.15rem 0.65rem;
      border-radius: 9999px;
      margin-bottom: 0.35rem;
    }

    .brand-header h1 {
      font-size: clamp(1.2rem, 2.2vh, 1.4rem);
      font-weight: 800;
      letter-spacing: -0.02em;
      color: #ffffff;
      margin-bottom: 0.2rem;
    }

    .brand-header p {
      font-size: clamp(0.75rem, 1.35vh, 0.825rem);
      color: var(--text-muted);
      line-height: 1.35;
    }

    /* Form Styles */
    .form-group {
      margin-bottom: clamp(0.6rem, 1.4vh, 0.95rem);
    }

    .form-label {
      display: block;
      font-size: 0.78rem;
      font-weight: 600;
      color: #cbd5e1;
      margin-bottom: 0.3rem;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 0.9rem;
      color: #64748b;
      font-size: 0.9rem;
      pointer-events: none;
      transition: color 0.2s ease;
    }

    .form-input {
      width: 100%;
      height: clamp(38px, 4.6vh, 44px);
      padding: 0 0.85rem 0 2.5rem;
      background: var(--input-bg);
      border: 1.5px solid var(--input-border);
      border-radius: 10px;
      color: #ffffff;
      font-size: clamp(0.85rem, 1.4vh, 0.9rem);
      transition: all 0.2s ease;
      outline: none;
    }

    .form-input::placeholder {
      color: #64748b;
    }

    .form-input:focus {
      border-color: var(--primary);
      background: rgba(15, 23, 42, 0.85);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.22);
    }

    .form-input:focus + .input-icon,
    .input-wrapper:focus-within .input-icon {
      color: var(--primary);
    }

    /* Password Toggle Button */
    .btn-toggle-pwd {
      position: absolute;
      right: 0.6rem;
      background: transparent;
      border: none;
      color: #64748b;
      cursor: pointer;
      padding: 0.4rem;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s ease;
      outline: none;
    }

    .btn-toggle-pwd:hover {
      color: #cbd5e1;
    }

    /* Action Buttons */
    .btn-submit {
      width: 100%;
      height: clamp(40px, 4.8vh, 46px);
      background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-size: clamp(0.85rem, 1.5vh, 0.925rem);
      font-weight: 700;
      letter-spacing: 0.01em;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.45);
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      margin-top: clamp(0.75rem, 1.8vh, 1.25rem);
    }

    .btn-submit:hover {
      background: linear-gradient(135deg, #1d4ed8 0%, #4338ca 100%);
      box-shadow: 0 12px 24px -4px rgba(37, 99, 235, 0.6);
      transform: translateY(-1.5px);
    }

    .btn-submit:active {
      transform: translateY(0);
      box-shadow: 0 5px 12px -3px rgba(37, 99, 235, 0.4);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: clamp(0.5rem, 1.3vh, 0.85rem) 0;
      color: #475569;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: rgba(255, 255, 255, 0.08);
    }

    .divider span {
      padding: 0 0.6rem;
    }

    .btn-back {
      width: 100%;
      height: clamp(34px, 4.2vh, 40px);
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 10px;
      color: #94a3b8;
      font-size: clamp(0.78rem, 1.4vh, 0.825rem);
      font-weight: 600;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.45rem;
      transition: all 0.2s ease;
    }

    .btn-back:hover {
      background: rgba(255, 255, 255, 0.08);
      color: #ffffff;
      border-color: rgba(255, 255, 255, 0.15);
      text-decoration: none;
    }

    /* Footer Info */
    .card-footer-info {
      margin-top: clamp(0.6rem, 1.4vh, 0.95rem);
      text-align: center;
      font-size: 0.72rem;
      color: #64748b;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
    }

    .card-footer-info i {
      color: #10b981;
      font-size: 0.8rem;
    }

    /* Height-based and width-based responsive adjustments */
    @media (max-height: 600px) {
      .logo-badge {
        display: none;
      }
      .card-footer-info {
        display: none;
      }
      .brand-header {
        margin-bottom: 0.5rem;
      }
      .divider {
        margin: 0.4rem 0;
      }
      .login-card {
        padding: 0.9rem 1.25rem;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 0.75rem;
      }
      .login-card {
        padding: 1.25rem 1.15rem;
        border-radius: 18px;
      }
    }
  </style>
</head>
<body>

  <!-- Ambient Glowing Orbs -->
  <div class="ambient-glow glow-1"></div>
  <div class="ambient-glow glow-2"></div>
  <div class="ambient-glow glow-3"></div>

  <!-- Subtle Pattern -->
  <div class="grid-pattern"></div>

  <!-- Login Card Box -->
  <div class="login-container">
    <div class="login-card">
      
      <!-- Brand & Header -->
      <div class="brand-header">
        <div class="logo-badge">
          <i class="fas fa-user-shield"></i>
        </div>
        <span class="portal-tag">Portal Administrasi</span>
        <h1>Admin Console</h1>
        <p>Bintang Timur Prestasi &bull; Masuk untuk mengelola sistem simulasi</p>
      </div>

      <!-- Login Form -->
      <form action="<?= base_url('belakang/checklogin') ?>" method="post" id="adminLoginForm">
        
        <!-- Username -->
        <div class="form-group">
          <label class="form-label" for="usernameInput">Username</label>
          <div class="input-wrapper">
            <i class="fas fa-user input-icon"></i>
            <input 
              type="text" 
              class="form-input" 
              id="usernameInput" 
              name="username" 
              placeholder="Masukkan username admin" 
              required 
              autocomplete="username"
              autofocus
            >
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label class="form-label" for="passwordInput">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock input-icon"></i>
            <input 
              type="password" 
              class="form-input" 
              id="passwordInput" 
              name="password" 
              placeholder="Masukkan password admin" 
              required 
              autocomplete="current-password"
            >
            <button type="button" class="btn-toggle-pwd" id="togglePassword" aria-label="Tampilkan atau sembunyikan password">
              <i class="far fa-eye" id="toggleIcon"></i>
            </button>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit" id="btnSubmit">
          <i class="fas fa-sign-in-alt"></i>
          <span>Masuk ke Dashboard</span>
        </button>

        <!-- Divider -->
        <div class="divider">
          <span>Akses Publik</span>
        </div>

        <!-- Back to Home -->
        <a href="<?= base_url('/') ?>" class="btn-back">
          <i class="fas fa-arrow-left"></i>
          <span>Halaman Utama Siswa</span>
        </a>

      </form>

      <!-- Security / Footer Info -->
      <div class="card-footer-info">
        <i class="fas fa-shield-alt"></i>
        <span>Sesi Terenkripsi &bull; Sistem CAT Simulasi</span>
      </div>

    </div>
  </div>

  <script>
    // Show / Hide Password toggle
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('toggleIcon');

    if (togglePasswordBtn && passwordInput && toggleIcon) {
      togglePasswordBtn.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        toggleIcon.classList.toggle('fa-eye', !isPassword);
        toggleIcon.classList.toggle('fa-eye-slash', isPassword);
      });
    }

    // Submit state feedback
    const loginForm = document.getElementById('adminLoginForm');
    const btnSubmit = document.getElementById('btnSubmit');
    if (loginForm && btnSubmit) {
      loginForm.addEventListener('submit', function () {
        btnSubmit.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i><span>Memverifikasi...</span>';
        btnSubmit.style.opacity = '0.85';
        btnSubmit.style.pointerEvents = 'none';
      });
    }
  </script>
</body>
</html>