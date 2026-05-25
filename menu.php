<?php
session_start();
$loggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - GASCOM</title>
  <link rel="stylesheet" href="style.css">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
    }

    .menu-page {
      width: 100%;
      min-height: 100vh;
      background: #1f1f1f;
      display: flex;
      justify-content: center;
      font-family: 'Poppins', Arial, sans-serif;
    }

    .menu-phone {
      width: 430px;
      min-height: 100vh;
      background: #155f6d;
      overflow: hidden;
    }

    .menu-hero {
      min-height: 405px;
      padding: 20px 18px 0;
      background:
        linear-gradient(rgba(227, 239, 231, 0.66), rgba(227, 239, 231, 0.66)),
        url("assets/bg-menu.png");
      background-size: cover;
      background-position: center top;
    }

    .menu-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .brand-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-left: 0;
    }

    .brand-wrap img {
      width: 70px;
      height: auto;
      margin: 0;
      display: block;
    }

    .brand-text {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .brand-text h1 {
      font-size: 22px;
      line-height: 1;
      color: #0b0b0b;
      margin: 0;
      font-weight: 800;
      letter-spacing: .2px;
    }

    .brand-text p {
      font-size: 12px;
      color: #222;
      margin: 4px 0 0;
    }

    .auth-link {
      font-size: 13px;
      font-weight: 800;
      color: #0f5968;
      margin: 0;
      display: flex;
      align-items: center;
      white-space: nowrap;
    }

    .auth-link a {
      color: #0f5968;
      text-decoration: none;
    }

    .auth-link span {
      color: #111;
      margin: 0 7px;
    }

    .menu-nav {
      margin-top: 52px;
      display: flex;
      justify-content: space-between;
      gap: 14px;
      padding: 0 16px;
    }

    .menu-nav a {
      flex: 1;
      background: #0f5968;
      color: #ffffff;
      text-decoration: none;
      font-size: 13px;
      padding: 9px 0;
      border-radius: 24px;
      text-align: center;
      box-shadow: 0 6px 12px rgba(0,0,0,.12);
    }

    .welcome-text {
      margin-top: 50px;
      padding-left: 16px;
      color: #105c6c;
    }

    .welcome-text h2 {
      font-size: 31px;
      line-height: 1;
      margin: 0 0 8px;
      font-weight: 800;
    }

    .welcome-text p {
      font-size: 13px;
      line-height: 1.45;
      width: 270px;
      margin: 0;
      color: #1d6270;
    }

    .learn-more {
      display: inline-block;
      margin-top: 18px;
      font-size: 11px;
      color: #0f5968;
      font-weight: 800;
      text-decoration: none;
    }

    .gascomp-section {
      margin-top: -1px;
      min-height: 500px;
      background: #155f6d;
      color: white;
      text-align: center;
      padding: 70px 38px 44px;
      border-top-left-radius: 50% 54px;
      border-top-right-radius: 50% 54px;
      position: relative;
    }

    .gascomp-section h2 {
      color: #5defff;
      font-size: 27px;
      margin: 0;
      font-weight: 800;
      letter-spacing: .5px;
    }

    .gascomp-section .by {
      font-size: 12px;
      color: #8df2f6;
      margin-top: 6px;
    }

    .device-img {
      width: 190px;
      margin: 45px auto 38px;
      display: block;
      filter: drop-shadow(0 13px 18px rgba(0,0,0,.32));
    }

    .gascomp-section p {
      font-size: 13px;
      line-height: 1.45;
      color: white;
      margin: 0 auto;
      max-width: 335px;
      font-weight: 500;
    }

    @media (max-width: 480px) {
      .menu-phone {
        width: 100%;
      }

      .brand-wrap img {
        width: 64px;
      }

      .brand-text h1 {
        font-size: 20px;
      }

      .auth-link {
        font-size: 12px;
      }

      .menu-nav {
        gap: 10px;
        padding: 0 14px;
      }

      .menu-nav a {
        font-size: 12px;
      }

      .welcome-text h2 {
        font-size: 29px;
      }
    }

    /* Modern refresh */
    body {
      background:
        radial-gradient(circle at 12% 8%, rgba(47, 184, 198, .18), transparent 30%),
        linear-gradient(135deg, #eaf3f6 0%, #f8fbfc 48%, #e6f1ef 100%);
      font-family: Inter, Poppins, Arial, sans-serif;
      color: #10232a;
    }

    .menu-page {
      min-height: 100vh;
      background: transparent;
      align-items: center;
      padding: 28px;
    }

    .menu-phone {
      width: min(100%, 1120px);
      min-height: 720px;
      background: rgba(255, 255, 255, .78);
      border: 1px solid rgba(255, 255, 255, .78);
      border-radius: 34px;
      overflow: hidden;
      box-shadow: 0 24px 70px rgba(16, 35, 42, .16);
      backdrop-filter: blur(18px);
      display: grid;
      grid-template-columns: minmax(360px, 1.05fr) minmax(330px, .95fr);
    }

    .menu-hero {
      min-height: 720px;
      padding: 30px;
      background:
        linear-gradient(135deg, rgba(15, 111, 125, .94), rgba(16, 35, 42, .9)),
        url("assets/bg-menu.png");
      background-size: cover;
      background-position: center;
      color: #fff;
      display: flex;
      flex-direction: column;
    }

    .menu-header {
      align-items: center;
      gap: 18px;
    }

    .brand-wrap img {
      width: 58px;
      background: #fff;
      border-radius: 18px;
      padding: 7px;
      box-shadow: 0 16px 32px rgba(0, 0, 0, .18);
    }

    .brand-text h1,
    .brand-text p,
    .auth-link,
    .auth-link a,
    .auth-link span {
      color: #fff;
    }

    .brand-text h1 {
      font-size: 22px;
      letter-spacing: 0;
    }

    .auth-link {
      background: rgba(255, 255, 255, .14);
      border: 1px solid rgba(255, 255, 255, .22);
      border-radius: 999px;
      padding: 10px 14px;
      backdrop-filter: blur(12px);
    }

    .menu-nav {
      margin-top: 48px;
      justify-content: flex-start;
      gap: 10px;
      padding: 0;
      flex-wrap: wrap;
    }

    .menu-nav a {
      flex: 0 0 auto;
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .2);
      color: #fff;
      font-size: 13px;
      padding: 11px 18px;
      border-radius: 999px;
      box-shadow: none;
      transition: background .2s, transform .2s;
    }

    .menu-nav a:hover {
      background: rgba(255, 255, 255, .25);
      transform: translateY(-1px);
    }

    .welcome-text {
      margin-top: auto;
      padding: 0;
      color: #fff;
      max-width: 560px;
    }

    .welcome-text h2 {
      font-size: clamp(46px, 7vw, 82px);
      line-height: .94;
      margin-bottom: 18px;
      letter-spacing: -2px;
      color: #fff;
    }

    .welcome-text p {
      width: auto;
      max-width: 460px;
      color: rgba(255, 255, 255, .8);
      font-size: 16px;
      line-height: 1.7;
    }

    .learn-more {
      margin-top: 24px;
      color: #10232a;
      background: #ffffff;
      border-radius: 14px;
      padding: 13px 18px;
      font-size: 13px;
      box-shadow: 0 18px 36px rgba(0, 0, 0, .16);
    }

    .gascomp-section {
      margin-top: 0;
      min-height: 720px;
      background: #ffffff;
      color: #10232a;
      text-align: left;
      padding: 46px;
      border-radius: 0;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      position: relative;
      overflow-y: auto;
    }

    .gascomp-section::before {
      content: "Realtime IoT Monitoring";
      display: inline-flex;
      width: max-content;
      max-width: 100%;
      margin-bottom: 14px;
      background: #eaf7f8;
      color: #0f6f7d;
      border: 1px solid #c8edf0;
      border-radius: 999px;
      padding: 8px 12px;
      font-size: 12px;
      font-weight: 800;
      letter-spacing: .8px;
      text-transform: uppercase;
    }

    .gascomp-section h2 {
      color: #10232a;
      font-size: clamp(38px, 5vw, 64px);
      line-height: .96;
      letter-spacing: -1px;
    }

    .gascomp-section .by {
      font-size: 14px;
      color: #6b7d84;
      margin-top: 10px;
    }

    .device-img {
      width: min(210px, 62%);
      margin: 30px auto;
      filter: drop-shadow(0 22px 32px rgba(16, 35, 42, .22));
    }

    .gascomp-section p {
      color: #5e7078;
      margin: 0;
      max-width: 460px;
      font-size: 15px;
      line-height: 1.8;
      font-weight: 500;
    }

    .learn-intro {
      color: #5e7078;
      margin: 16px 0 0;
      max-width: 520px;
      font-size: 15px;
      line-height: 1.8;
      font-weight: 500;
    }

    .status-title {
      margin: 28px 0 14px;
      font-size: 18px;
      font-weight: 800;
      color: #10232a;
    }

    .safety-note {
      display: block;
      color: #5e7078;
      font-size: 13px;
      line-height: 1.65;
    }

    .status-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 10px;
    }

    .status-card {
      border-radius: 16px;
      padding: 14px;
      border: 1px solid #dcebed;
      background: #f8fbfc;
    }

    .status-card strong {
      display: block;
      margin-bottom: 6px;
      font-size: 13px;
    }

    .status-card small {
      color: #5e7078;
      line-height: 1.55;
      display: block;
    }

    .status-safe strong {
      color: #1f9f68;
    }

    .status-warning strong {
      color: #b87808;
    }

    .status-danger strong {
      color: #d94f54;
    }

    .safety-note {
      margin-top: 18px;
      padding: 14px;
      background: #fff8e8;
      border: 1px solid #ffe1a6;
      border-radius: 16px;
    }

    @media (max-width: 860px) {
      .menu-page {
        padding: 0;
      }

      .menu-phone {
        grid-template-columns: 1fr;
        border-radius: 0;
        min-height: 100vh;
      }

      .menu-hero,
      .gascomp-section {
        min-height: auto;
        padding: 26px;
      }

      .menu-hero {
        min-height: 620px;
      }

      .welcome-text h2 {
        font-size: 48px;
      }

      .status-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <main class="menu-page">
    <section class="menu-phone">

      <div class="menu-hero">
        <header class="menu-header">
          <div class="brand-wrap">
            <img src="assets/logo.png" alt="Logo Monech">
            <div class="brand-text">
              <h1>GASCOM</h1>
              <p>By Monech</p>
            </div>
          </div>

          <div class="auth-link">
            <a href="index.php#loginPage">LOGIN</a>
            <span>/</span>
            <a href="index.php#signupPage">Sign Up</a>
          </div>
        </header>

            <nav class="menu-nav">
              <a href="menu.php">Home</a>

              <a href="<?= $loggedIn ? 'index.php#monitoringView' : 'index.php#loginPage' ?>">
                Data
              </a>

              <a href="bantuan.php">Bantuan</a>

              <a href="<?= $loggedIn ? 'index.php#profileView' : 'index.php#loginPage' ?>">
                Profil
              </a>
            </nav>

        <div class="welcome-text">
          <h2>Selamat Datang</h2>
          <p>
            Temukan kemudahan dalam menjaga keamanan rumah berbasis internet bersama kami
          </p>
          <a class="learn-more" href="terms.php">Pelajari Lebih Lanjut</a>
        </div>
      </div>

      <section class="gascomp-section" id="gascomp">
        <h2>GASCOM</h2>
        <div class="by">By Monech</div>

        <img class="device-img" src="assets/gascomp.png" alt="GASCOMP Device">

        <p class="learn-intro">
          GASCOM adalah alat pendeteksi kebocoran gas berbasis IoT yang membantu pengguna
          memantau kondisi gas LPG secara realtime melalui website. Sistem ini dibuat agar
          keluarga, pemilik kos, warung, dan dapur kecil bisa lebih cepat mengetahui tanda bahaya.
        </p>

        <h3 class="status-title">Arti Status GASCOM</h3>
        <div class="status-grid">
          <div class="status-card status-safe">
            <strong>Aman</strong>
            <small>Kadar gas masih rendah dan kondisi ruangan terpantau normal.</small>
          </div>
          <div class="status-card status-warning">
            <strong>Waspada</strong>
            <small>Kadar gas mulai naik. Periksa kompor, regulator, selang, dan ventilasi ruangan.</small>
          </div>
          <div class="status-card status-danger">
            <strong>Bahaya</strong>
            <small>Kadar gas tinggi. Matikan sumber api, buka ventilasi, dan jauhi pemicu listrik.</small>
          </div>
        </div>

        <p class="safety-note">
          GASCOM membantu memberi peringatan dini, tetapi keselamatan tetap membutuhkan tindakan pengguna.
          Jika tercium bau gas menyengat, jangan menyalakan api atau saklar listrik, buka pintu/jendela,
          lalu hubungi orang terdekat atau petugas terkait.
        </p>
      </section>

    </section>
  </main>
</body>
</html>
