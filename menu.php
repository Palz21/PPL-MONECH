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
          <a class="learn-more" href="#gascomp">Pelajari Lebih Lanjut</a>
        </div>
      </div>

      <section class="gascomp-section" id="gascomp">
        <h2>GASCOM</h2>
        <div class="by">By Monech</div>

        <img class="device-img" src="assets/gascomp.png" alt="GASCOMP Device">

        <p>
          GASCOM adalah sistem monitoring gas berbasis IoT yang terintegrasi secara langsung
          dengan website. Sistem cerdas ini hadir sebagai solusi praktis untuk mengatasi masalah
          keterlambatan penanganan kebocoran gas di lingkungan rumah tangga, khususnya bagi
          para pengguna gas LPG.
        </p>
      </section>

    </section>
  </main>
</body>
</html>