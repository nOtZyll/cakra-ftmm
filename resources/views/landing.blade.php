<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CAKRA - @yield('title','Landing')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- Google Fonts: Orbitron (futuristik bersih) + Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #073763;
      --accent: #741847;
      --bg-dark: #0A192F;
      --text-dark: #E0E6F1;
      --subtext-dark: #94A3B8;
      --card-bg: rgba(7, 55, 99, 0.1);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-dark);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Glassmorphism Effect */
    .glass-card {
      background: rgba(7, 55, 99, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(116, 24, 71, 0.2);
      border-radius: 12px;
    }

    /* NAVBAR */
    .navbar {
      background: rgba(7, 55, 99, 0.1) !important;
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(116, 24, 71, 0.2);
      padding: 15px 0;
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      background: rgba(7, 55, 99, 0.2) !important;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar .nav-link { 
      color: var(--subtext-dark);
      font-weight: 500;
      margin: 0 10px;
      transition: all 0.3s ease;
      position: relative;
    }

    .navbar .nav-link:hover { 
      color: var(--text-dark);
    }

    .navbar .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -5px;
      left: 0;
      background: var(--accent);
      transition: width 0.3s ease;
    }

    .navbar .nav-link:hover::after {
      width: 100%;
    }

    .brand-wrap { 
      display: flex; 
      align-items: center; 
      gap: 12px;
      text-decoration: none;
    }

    .brand-wrap img.logo-unair {
      width: 42px;
      height: 42px;
      object-fit: contain;
      border-radius: 50%;
      background: #fff;
      padding: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .brand-text { 
      display: flex; 
      flex-direction: column; 
      line-height: 1.2;
    }

    .brand-text .title { 
      font-weight: 700;
      font-size: 1.4rem;
      font-family: 'Orbitron', sans-serif;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 0.5px;
      animation: colorSweep 3s ease-in-out infinite;
    }

    .brand-text .subtitle { 
      font-size: 0.75rem; 
      color: var(--subtext-dark);
      font-weight: 400;
    }

    /* HERO SECTION — DENGAN BACKGROUND ANIMASI FUTURISTIK */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 0;
      position: relative;
      overflow: hidden;
      background: linear-gradient(-45deg, #0A192F, #073763, #00509D, #741847, #0A192F);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      z-index: 1;
    }

    @keyframes gradientBG {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }

    /* Grid Futuristik Transparan */
    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(rgba(116, 24, 71, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(116, 24, 71, 0.1) 1px, transparent 1px);
      background-size: 50px 50px;
      z-index: 2;
      pointer-events: none;
    }

    /* Partikel Cahaya Bergerak */
    .hero::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 30% 50%, rgba(0, 170, 255, 0.15) 0%, transparent 40%),
                  radial-gradient(circle at 70% 30%, rgba(255, 77, 148, 0.1) 0%, transparent 50%),
                  radial-gradient(circle at 50% 80%, rgba(116, 24, 71, 0.1) 0%, transparent 40%);
      z-index: 2;
      animation: pulse 8s ease-in-out infinite alternate;
      pointer-events: none;
    }

    @keyframes pulse {
      0% {
        opacity: 0.5;
        transform: scale(1);
      }
      100% {
        opacity: 0.8;
        transform: scale(1.05);
      }
    }

    .hero .container {
      position: relative;
      z-index: 3;
    }

    /* ✨ TULISAN "CAKRA" YANG DIPERBAIKI: LEBIH MUDAH DIBACA ✨ */
    .hero h1 {
      font-size: 4.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-family: 'Orbitron', sans-serif;
      background: linear-gradient(90deg, #7ca2c5, #a3c2e0, #741847);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-size: 200% 200%;
      animation: colorSweepFast 4s ease-in-out infinite;
      position: relative;
      letter-spacing: 3px;
      text-shadow: 
        0 0 10px rgba(124, 162, 197, 0.5),
        0 0 20px rgba(116, 24, 71, 0.3);
      text-transform: uppercase;
      line-height: 1.1;
      z-index: 3;
    }

    @keyframes colorSweepFast {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }

    .hero p {
      font-size: 1.2rem;
      color: var(--text-dark);
      margin-bottom: 2rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      z-index: 3;
    }

    .hero .lead {
      font-size: 1.5rem;
      font-weight: 500;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
    }

    .text-accent {
      color: #7ca2c5;
      font-weight: 600;
      text-shadow: 0 0 10px rgba(124, 162, 197, 0.5);
    }

    /* BUTTONS */
    .btn-custom {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white;
      font-weight: 600;
      border-radius: 8px;
      padding: 12px 30px;
      border: none;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      font-family: 'Orbitron', sans-serif;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-custom::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn-custom:hover::before {
      left: 100%;
    }

    .btn-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    /* SECTIONS */
    section {
      padding: 100px 0;
      position: relative;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-align: center;
      font-family: 'Orbitron', sans-serif;
      background: linear-gradient(90deg, var(--primary), var(--accent), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: colorSweep 5s ease-in-out infinite;
      position: relative;
    }

    .section-subtitle {
      font-size: 1.1rem;
      color: var(--text-dark);
      text-align: center;
      margin-bottom: 3rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    /* ABOUT SECTION */
    #tentang {
      background: var(--bg-dark);
      position: relative;
    }

    #tentang::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 10% 20%, rgba(116, 24, 71, 0.05) 0%, transparent 50%),
                  radial-gradient(circle at 90% 80%, rgba(7, 55, 99, 0.05) 0%, transparent 50%);
      pointer-events: none;
    }

    .feature-card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(116, 24, 71, 0.2);
      border-radius: 12px;
      padding: 30px;
      height: 100%;
      transition: all 0.3s ease;
      text-align: center;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      border-color: rgba(116, 24, 71, 0.4);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: colorSweep 6s ease-in-out infinite;
    }

    .feature-card h5 {
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--text-dark);
      font-family: 'Orbitron', sans-serif;
    }

    .feature-card p {
      color: var(--text-dark);
      font-size: 0.95rem;
    }

    /* CONTACT SECTION */
    #kontak {
      background: linear-gradient(135deg, var(--bg-dark) 0%, rgba(10, 25, 47, 0.9) 100%);
    }

    .contact-card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(116, 24, 71, 0.2);
      border-radius: 12px;
      padding: 30px;
      text-align: center;
      transition: all 0.3s ease;
      height: 100%;
    }

    .contact-card:hover {
      transform: translateY(-5px);
      border-color: rgba(116, 24, 71, 0.4);
    }

    .contact-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: colorSweep 5s ease-in-out infinite;
    }

    /* FOOTER */
    .footer {
      background: rgba(7, 55, 99, 0.1);
      backdrop-filter: blur(10px);
      border-top: 1px solid rgba(116, 24, 71, 0.2);
      padding: 40px 0;
      margin-top: 50px;
    }

    .footer p {
      color: var(--text-dark);
      margin: 0;
    }

    /* ANIMATIONS */
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    .floating {
      animation: float 3s ease-in-out infinite;
    }

    /* COLOR SWEEP ANIMATION — Efek warna lewat-lewat */
    @keyframes colorSweep {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }

    /* Terapkan animasi ke elemen yang pakai gradient text */
    .section-title, .feature-icon, .contact-icon, .brand-text .title {
      background-size: 200% 200%;
      animation: colorSweep 4s ease-in-out infinite;
    }

    /* LAYOUT PERBAIKAN - SEIMBANG DAN RAPI */
    .balanced-layout {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      min-height: 60vh;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin: 3rem 0;
    }

    .info-card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(116, 24, 71, 0.2);
      border-radius: 12px;
      padding: 2rem;
      transition: all 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-5px);
      border-color: rgba(116, 24, 71, 0.4);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .benefit-list {
      list-style: none;
      padding: 0;
      text-align: left;
    }

    .benefit-list li {
      margin-bottom: 1rem;
      color: var(--text-dark);
    }

    .benefit-list i {
      color: #28a745;
      margin-right: 0.5rem;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 3rem;
        letter-spacing: 2px;
      }
      
      .hero p {
        font-size: 1rem;
      }
      
      .section-title {
        font-size: 2rem;
      }
      
      .navbar .nav-link {
        margin: 5px 0;
        text-align: center;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }

      .balanced-layout {
        min-height: 40vh;
      }
    }
  </style>
</head>
<body>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand brand-wrap" href="#" aria-label="Beranda CAKRA">
        <img
          src="https://arsip.unair.ac.id/wp-content/uploads/2019/01/logo-unair.png"
          alt="Logo Universitas Airlangga"
          class="logo-unair"
          loading="lazy"
        >
        <span class="brand-text">
          <span class="title">CAKRA</span>
          <span class="subtitle">Central Administrasi Keuangan dan Rencana Anggaran</span>
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
          <li class="nav-item">
            <a class="btn btn-custom ms-lg-3 mt-3 mt-lg-0" href="{{ route('login') }}">
              <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Hero Section --}}
  <section class="hero">
    <div class="container balanced-layout" data-aos="fade-up">
      <h1 class="floating">CAKRA</h1>
      <p class="lead">Sistem Keuangan Akademik ORMAWA</p>
      <p class="text-accent" style="font-size: 1.3rem; font-weight: 600;">Transparan • Cepat • Akuntabel</p>
      <a href="{{ route('login') }}" class="btn btn-custom btn-lg mt-3">
        <i class="bi bi-box-arrow-in-right me-2"></i> Mulai Login
      </a>
    </div>
  </section>

  {{-- Tentang Section --}}
  <section id="tentang">
    <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="section-title">Tentang CAKRA</h2>
        <p class="section-subtitle">Digital, mulai dari proposal, verifikasi, pencairan, hingga laporan pertanggungjawaban.</p>
      </div>

      <div class="info-grid">
        <div class="info-card" data-aos="fade-right">
          <h4 class="fw-bold text-center mb-4">Apa itu CAKRA?</h4>
          <p class="text-center">
            CAKRA (Central Administrasi Keuangan dan Rencana Anggaran) adalah sistem informasi yang dirancang 
            untuk mengelola alur pengajuan dana organisasi mahasiswa secara digital.
          </p>
        </div>

        <div class="info-card" data-aos="fade-left">
          <h4 class="fw-bold text-center mb-4">Manfaat Utama</h4>
          <ul class="benefit-list">
            <li><i class="bi bi-check-circle"></i> Mahasiswa: verifikasi & pencairan lebih cepat</li>
            <li><i class="bi bi-check-circle"></i> Stakeholder: pemantauan dana dengan dashboard</li>
          </ul>
        </div>
      </div>

      <div class="row g-4 mt-4">
        <div class="col-md-6" data-aos="zoom-in">
          <div class="feature-card">
            <i class="bi bi-file-earmark-text feature-icon"></i>
            <h5>Pengajuan Proposal</h5>
            <p>Ajukan proposal kegiatan dengan cepat dan terdokumentasi secara digital.</p>
          </div>
        </div>
        <div class="col-md-6" data-aos="zoom-in" data-aos-delay="200">
          <div class="feature-card">
            <i class="bi bi-check-circle feature-icon"></i>
            <h5>Verifikasi Berjenjang</h5>
            <p>Proses verifikasi transparan dari Ormawa hingga Stakeholder dengan tracking yang jelas.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Kontak Section --}}
  <section id="kontak">
    <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="section-title">Kontak Kami</h2>
        <p class="section-subtitle">Hubungi kami untuk informasi lebih lanjut tentang sistem CAKRA</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-5 mb-4" data-aos="fade-right">
          <div class="contact-card">
            <i class="bi bi-envelope-fill contact-icon"></i>
            <h5>Email</h5>
            <p>keuangan@universitas.ac.id</p>
            <small>Respon dalam 1x24 jam</small>
          </div>
        </div>
        <div class="col-md-5 mb-4" data-aos="fade-left">
          <div class="contact-card">
            <i class="bi bi-telephone-fill contact-icon"></i>
            <h5>Telepon</h5>
            <p>(021) 123-4567</p>
            <small>Senin - Jumat, 08:00 - 16:00</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Footer --}}
  <footer class="footer">
    <div class="container text-center">
      <p>&copy; 2024 CAKRA - Central Administrasi Keuangan dan Rencana Anggaran. Universitas Airlangga.</p>
    </div>
  </footer>

  {{-- Scripts --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      once: true
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>
</html>