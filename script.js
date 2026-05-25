const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);
const API = (path) => `api/${path}`;

let historyData = [];

function showToast(message) {
  const toast = $('#toast');

  if (!toast) {
    alert(message);
    return;
  }

  toast.textContent = message;
  toast.style.display = 'block';

  setTimeout(() => {
    toast.style.display = 'none';
  }, 2800);
}

function showPage(pageId) {
  $$('.page').forEach((page) => {
    page.classList.remove('active');
  });

  const target = $(`#${pageId}`);

  if (target) {
    target.classList.add('active');
  } else {
    showToast(`Halaman ${pageId} belum ada`);
  }
}

function showView(viewId) {
  $$('.dash-view').forEach((view) => {
    view.classList.remove('active');
  });

  const targetView = $(`#${viewId}`);

  if (!targetView) {
    showToast(`View ${viewId} belum ada`);
    return;
  }

  targetView.classList.add('active');

  $$('.nav-btn[data-view]').forEach((button) => {
    button.classList.toggle('active', button.dataset.view === viewId);
  });

  const pageTitle = $('#pageTitle');

  if (pageTitle) {
    pageTitle.textContent = viewId
      .replace('View', '')
      .replace(/^./, (char) => char.toUpperCase());
  }

  if (viewId === 'graphView') {
    setTimeout(drawChart, 60);
  }
}

async function post(url, form) {
  const data = Object.fromEntries(new FormData(form).entries());

  const response = await fetch(API(url), {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  });

  const result = await response.json();

  if (!result.ok && !result.success) {
    throw new Error(result.message || 'Terjadi error');
  }

  return result;
}

async function getJSON(url) {
  const response = await fetch(API(url));
  return await response.json();
}

function setUser(user) {
  const namaUser = $('#namaUser');
  const deviceId = $('#deviceId');

  if (namaUser) namaUser.textContent = user.nama || 'User';
  if (deviceId) deviceId.textContent = user.id_alat || 'MNC-001';

  if ($('#profileNama')) $('#profileNama').value = user.nama || '';
  if ($('#profileEmail')) $('#profileEmail').value = user.email || '';
  if ($('#profileIdAlat')) $('#profileIdAlat').value = user.id_alat || '';
  if ($('#profileTelepon')) $('#profileTelepon').value = user.no_telepon || '-';
  if ($('#profileAlamat')) $('#profileAlamat').value = user.alamat || '';
}

function updateCards(latest) {
  if (!latest) return;

  const gasVal = $('#gasVal');
  const tempVal = $('#tempVal');
  const humVal = $('#humVal');
  const gaugeNum = $('#gaugeNum');
  const gasStatus = $('#gasStatus');
  const alertText = $('#alertText');
  const alertDesc = $('#alertDesc');
  const monitoringView = $('#monitoringView');

  const gas = Number(latest.gas_ppm || 0);

  if (gasVal) gasVal.textContent = `${gas} PPM`;
  if (tempVal) tempVal.textContent = `${parseFloat(latest.suhu || 0).toFixed(1)}°C`;
  if (humVal) humVal.textContent = `${parseFloat(latest.kelembapan || 0).toFixed(0)}%`;
  if (gaugeNum) gaugeNum.textContent = gas;

  let status = 'safe';
  let title = 'Aman';
  let description = 'Kondisi gas berada pada level aman.';

  if (gas >= 600) {
    status = 'danger';
    title = 'Bahaya';
    description = 'Gas melewati batas aman. Segera lakukan pengecekan.';
  } else if (gas >= 300) {
    status = 'warning';
    title = 'Waspada';
    description = 'Gas mulai meningkat. Perhatikan area sekitar sensor.';
  }

  if (gasStatus) gasStatus.textContent = status.toUpperCase();
  if (alertText) alertText.textContent = title;
  if (alertDesc) alertDesc.textContent = description;

  if (monitoringView) {
    monitoringView.classList.remove('status-danger', 'status-warning');

    if (status === 'danger') {
      monitoringView.classList.add('status-danger');
    }

    if (status === 'warning') {
      monitoringView.classList.add('status-warning');
    }
  }
}

function updateTable(rows) {
  const historyBody = $('#historyBody');

  if (!historyBody) return;

  historyBody.innerHTML = rows
    .slice()
    .reverse()
    .map((row) => `
      <tr>
        <td>${row.label}</td>
        <td>${row.gas_ppm} PPM</td>
        <td>${parseFloat(row.suhu).toFixed(1)}°C</td>
        <td>
          <span class="badge ${row.status}">
            ${row.status}
          </span>
        </td>
      </tr>
    `)
    .join('');
}

async function loadReadings() {
  try {
    const result = await getJSON('readings.php');

    if (!result.ok && !result.success) return;

    const latest = result.latest;
    historyData = result.history || [];

    updateCards(latest);
    updateTable(historyData);
    drawChart();

  } catch (error) {
    showToast('API belum aktif. Jalankan lewat Laragon dan import database.');
  }
}

function drawChart() {
  const canvas = $('#gasChart');

  if (!canvas || !historyData.length) return;

  const ctx = canvas.getContext('2d');
  const width = canvas.width;
  const height = canvas.height;

  ctx.clearRect(0, 0, width, height);

  ctx.strokeStyle = '#cbd2d4';
  ctx.lineWidth = 1;
  ctx.font = '14px Poppins';
  ctx.fillStyle = '#46656d';

  for (let i = 0; i < 5; i++) {
    const y = 35 + i * (height - 70) / 4;

    ctx.beginPath();
    ctx.moveTo(45, y);
    ctx.lineTo(width - 25, y);
    ctx.stroke();

    ctx.fillText(String(700 - i * 175), 8, y + 4);
  }

  const values = historyData.map((item) => Number(item.gas_ppm));
  const max = 700;
  const min = 0;
  const step = (width - 90) / (values.length - 1 || 1);

  ctx.strokeStyle = '#1d5c68';
  ctx.lineWidth = 5;
  ctx.beginPath();

  values.forEach((value, index) => {
    const x = 55 + index * step;
    const y = height - 35 - ((value - min) / (max - min)) * (height - 80);

    if (index === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }
  });

  ctx.stroke();

  values.forEach((value, index) => {
    const x = 55 + index * step;
    const y = height - 35 - (value / max) * (height - 80);

    ctx.fillStyle = '#1d5c68';
    ctx.beginPath();
    ctx.arc(x, y, 6, 0, Math.PI * 2);
    ctx.fill();

    ctx.fillStyle = '#46656d';

    if (historyData[index]) {
      ctx.fillText(historyData[index].label, x - 18, height - 12);
    }
  });
}

/* PINDAH SIGNUP / LOGIN */
const goLogin = $('[data-go="loginPage"]');
const goSignup = $('[data-go="signupPage"]');

if (goLogin) {
  goLogin.addEventListener('click', () => showPage('loginPage'));
}

if (goSignup) {
  goSignup.addEventListener('click', () => showPage('signupPage'));
}

/* REGISTER */
const registerForm = $('#registerForm');

if (registerForm) {
  registerForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    try {
      await post('register.php', registerForm);

      showToast('Akun berhasil dibuat, silakan login');
      registerForm.reset();
      showPage('loginPage');

    } catch (error) {
      showToast(error.message);
    }
  });
}

/* LOGIN */
const loginForm = $('#loginForm');

if (loginForm) {
  loginForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    try {
      const result = await post('login.php', loginForm);

      setUser(result.user || {});

      if ($('#dashboardPage')) {
        showPage('dashboardPage');
        await loadReadings();
        showToast('Login berhasil');
      } else {
        showToast('Login berhasil, tapi dashboard belum ada di index.php');
      }

    } catch (error) {
      showToast(error.message);
    }
  });
}

/* NAV DASHBOARD */
$$('.nav-btn[data-view], .primary-wide[data-view]').forEach((button) => {
  button.addEventListener('click', () => {
    showView(button.dataset.view);
  });
});

/* LOGOUT */
const logoutBtn = $('#logoutBtn');

if (logoutBtn) {
  logoutBtn.addEventListener('click', async () => {
    try {
      await getJSON('logout.php');
      showToast('Logout berhasil');

      setTimeout(() => {
        window.location.href = 'menu.php';
      }, 800);

    } catch (error) {
      showToast('Logout gagal');
    }
  });
}

/* SIMULASI DATA */
const simulateBtn = $('#simulateBtn');

if (simulateBtn) {
  simulateBtn.addEventListener('click', async () => {
    try {
      await fetch(API('add_reading.php'), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          gas_ppm: Math.floor(80 + Math.random() * 620)
        })
      });

      await loadReadings();
      showToast('Data simulasi ditambahkan');

    } catch (error) {
      showToast('Gagal tambah data simulasi');
    }
  });
}

/* CEK SESSION */
(async function boot() {
  try {
    const result = await getJSON('me.php');

    if ((result.ok || result.success) && result.user) {
      setUser(result.user);

      if ($('#dashboardPage')) {
        showPage('dashboardPage');
        await loadReadings();
      }
    }

  } catch (error) {}
})();

/* AUTO REFRESH DATA */
setInterval(() => {
  const dashboardPage = $('#dashboardPage');

  if (dashboardPage && dashboardPage.classList.contains('active')) {
    loadReadings();
  }
}, 15000);

/* BUKA PAGE SESUAI HASH URL */
window.addEventListener('load', () => {
  const hash = window.location.hash.replace('#', '');

  if (hash === 'loginPage') {
    showPage('loginPage');
  }

  if (hash === 'signupPage') {
    showPage('signupPage');
  }

  if (hash === 'dashboardPage') {
    showPage('dashboardPage');
  }

  if (hash === 'profileView') {
    showPage('dashboardPage');
    showView('profileView');
  }

  if (hash === 'monitoringView') {
    showPage('dashboardPage');
    showView('monitoringView');
  }
});