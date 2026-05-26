<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MONECH</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main id="app">

    <!-- SIGN UP -->
    <section class="page auth-page active" id="signupPage">
      <div class="phone-frame">
        <div class="auth-top">
          <div class="logo-bubble">
            <img src="assets/logo.png" alt="MONECH">
          </div>
        </div>

        <div class="wave wave-a"></div>
        <div class="wave wave-b"></div>
        <div class="wave wave-c"></div>
        <div class="wave wave-d"></div>

        <div class="auth-content signup-content">
          <h1>Sign Up</h1>

          <form class="auth-card signup-card" id="registerForm" method="post">
            <label>
              Nama
              <input name="nama" type="text" required>
            </label>

            <label>
              Email
              <input name="email" type="email" required>
            </label>

            <label>
              ID Alat
              <input name="id_alat" type="text" value="MNC-001" required>
            </label>

            <label>
              Alamat
               <input name="alamat" type="text" required>
            </label>

            <label>
              No Telepon
               <input name="no_telepon" type="text" required>
            </label>

            <label>
              Pass
              <input name="password" type="password" required>
            </label>

            <label>
              Konfirm Pass
              <input name="konfirmasi" type="password" required>
            </label>

            <button class="mini-btn" type="submit">DAFTAR</button>

            <p class="switch-text">
              Sudah punya akun?
              <button type="button" data-go="loginPage">Login</button>
            </p>
          </form>
        </div>
      </div>
    </section>

    <!-- LOGIN -->
    <section class="page auth-page" id="loginPage">
      <div class="phone-frame">
        <div class="auth-top">
          <div class="logo-bubble">
            <img src="assets/logo.png" alt="MONECH">
          </div>
        </div>

        <div class="wave wave-a"></div>
        <div class="wave wave-b"></div>
        <div class="wave wave-c"></div>
        <div class="wave wave-d"></div>

        <div class="auth-content login-content">
          <h1>Login</h1>

          <form class="auth-card login-card small" id="loginForm" method="post">
            <label>
              Email
              <input name="email" type="email" required>
            </label>

            <label>
              Password
              <input name="password" type="password" required>
            </label>

            <button class="mini-btn" type="submit">LOGIN</button>

            <p class="switch-text">
              Belum punya akun?
              <button type="button" data-go="signupPage">Daftar</button>
            </p>
          </form>
        </div>
      </div>
    </section>

    <!-- DASHBOARD -->
    <section class="page dash-page" id="dashboardPage">
      <aside class="sidebar">
        <div class="brand">
          <img src="assets/logo.png" alt="MONECH">
          <span>MONECH</span>
        </div>

        <button class="nav-btn active" data-view="homeView">Dashboard</button>
        <button class="nav-btn" data-view="monitoringView">Monitoring</button>
        <button class="nav-btn" data-view="graphView">Graph</button>
        <button class="nav-btn" data-view="performanceView">Performance</button>
        <button class="nav-btn" data-view="profileView">Profil</button>
        <button class="nav-btn danger" id="logoutBtn">Logout</button>
      </aside>

      <section class="content">
        <header class="topbar">
          <div>
            <p class="hello">Halo, <span id="namaUser">User</span></p>
            <h2 id="pageTitle">Dashboard</h2>
          </div>

          <div class="device-pill">
            ID ALAT <b id="deviceId">MNC-001</b>
          </div>
        </header>

        <!-- HOME VIEW -->
        <div class="dash-view active" id="homeView">
          <div class="hero-card">
            <div>
              <p class="eyebrow">Gas Leak Detection System</p>
              <h3>Monitoring kebocoran gas secara realtime</h3>
              <p>
                Dashboard MONECH menampilkan status sensor, gas PPM,
                suhu, kelembapan, dan histori pembacaan alat.
              </p>
              <button class="primary-wide" data-view="monitoringView">
                Lihat Monitoring
              </button>
            </div>

            <img src="assets/logo.png" alt="MONECH">
          </div>

          <div class="cards">
            <div class="info-card">
              <span>Gas</span>
              <strong id="gasVal">0 PPM</strong>
              <small id="gasStatus">SAFE</small>
            </div>

            <div class="info-card">
              <span>Suhu</span>
              <strong id="tempVal">0°C</strong>
              <small>Temperature</small>
            </div>

            <div class="info-card">
              <span>Kelembapan</span>
              <strong id="humVal">0%</strong>
              <small>Humidity</small>
            </div>
          </div>
        </div>

        <!-- MONITORING VIEW -->
        <div class="dash-view" id="monitoringView">
          <div class="monitor-grid">
            <div class="gauge-card">
              <p class="eyebrow">Realtime Monitoring</p>

              <div class="gauge">
                <span id="gaugeNum">0</span>
                <small>PPM</small>
              </div>

              <h3 id="alertText">Aman</h3>
              <p id="alertDesc">Kondisi gas berada pada level aman.</p>

              <div class="device-live-box">
                <span>Status Alat</span>
                <strong id="deviceLiveStatus">Menunggu Data</strong>
                <small id="deviceLastSeen">Belum ada data masuk dari ESP32</small>
              </div>
            </div>

            <div class="table-card">
              <h3>Riwayat Sensor</h3>

              <table>
                <thead>
                  <tr>
                    <th>Jam</th>
                    <th>Gas</th>
                    <th>Suhu</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="historyBody"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- GRAPH VIEW -->
        <div class="dash-view" id="graphView">
          <div class="chart-card">
            <div class="chart-head">
              <div>
                <p class="eyebrow">Graph</p>
                <h3>Grafik Gas PPM</h3>
              </div>
              <img src="assets/graph-arrow.png" alt="Graph">
            </div>

            <canvas id="gasChart" width="900" height="360"></canvas>
          </div>
        </div>

        <!-- PERFORMANCE VIEW -->
        <div class="dash-view" id="performanceView">
          <div class="performance-wrap">
            <div class="perf-card">
              <p class="eyebrow">Performance</p>
              <h3>Ringkasan Performa Alat</h3>

              <div class="bar-row">
                <span>Stability</span>
                <div><i style="width:92%"></i></div>
                <b>92%</b>
              </div>

              <div class="bar-row">
                <span>Accuracy</span>
                <div><i style="width:88%"></i></div>
                <b>88%</b>
              </div>

              <div class="bar-row">
                <span>Response</span>
                <div><i style="width:95%"></i></div>
                <b>95%</b>
              </div>
            </div>

            <div class="perf-note">
              <h3>Kesimpulan</h3>
              <p>
                Sistem bekerja normal. Status akan berubah otomatis menjadi warning
                ketika gas melewati 300 PPM dan danger ketika melewati 600 PPM.
              </p>
            </div>
          </div>
        </div>
          <!-- PROFILE VIEW -->
<div class="dash-view" id="profileView">
  <div class="profile-mobile">
    <div class="profile-top">
      <div class="profile-logo-wrap">
        <img src="assets/logo.png" alt="logo">
        <div>
          <h3>GASCOM</h3>
          <p>By Monech</p>
        </div>
      </div>

      <button class="profile-home-btn" data-view="homeView" aria-label="Kembali ke dashboard">⌂</button>
    </div>

    <div class="profile-avatar">
      <img id="profilePhotoPreview" alt="Foto profil">
      <span id="profilePhotoInitial" aria-hidden="true">♡</span>
    </div>

    <div class="profile-form-card">
      <form class="profile-photo-form" id="profilePhotoForm" enctype="multipart/form-data">
        <label>Foto Profil
          <input id="profilePhotoInput" name="foto" type="file" accept="image/png,image/jpeg,image/webp">
        </label>
        <button class="primary-wide" type="submit">Simpan Foto</button>
      </form>

      <label>Nama
        <input id="profileNama" readonly>
      </label>

      <label>Email
        <input id="profileEmail" readonly>
      </label>

      <label>ID Alat
        <input id="profileIdAlat" readonly>
      </label>

      <label>Token Alat
        <input id="profileDeviceToken" readonly>
      </label>

      <label>No Telepon
        <input id="profileTelepon" readonly>
      </label>

      <label>Alamat
        <input id="profileAlamat" readonly>
      </label>
    </div>
  </div>
</div>

      <a href="menu.php" class="profile-menu-btn">
        Back to Menu Awal
      </a>

      </section>
    </section>
    
  </main>

  <div id="toast"></div>

  <script src="script.js"></script>
</body>
</html>
