<?php
require __DIR__ . '/config.php';
require __DIR__ . '/notifications.php';

$d = input_json();

$id_alat = trim($d['id_alat'] ?? '');
$token = trim($d['token'] ?? '');
$gas = isset($d['gas_ppm']) ? (int) $d['gas_ppm'] : null;
$suhu = isset($d['suhu']) ? (float) $d['suhu'] : null;
$kelembapan = isset($d['kelembapan']) ? (float) $d['kelembapan'] : null;

if (!$id_alat || !$token) {
    fail('ID alat dan token wajib dikirim.', 401);
}

if ($gas === null || $suhu === null || $kelembapan === null) {
    fail('Data gas, suhu, dan kelembapan wajib dikirim.');
}

if ($gas < 0 || $gas > 5000) {
    fail('Nilai gas tidak valid.');
}

if ($suhu < -20 || $suhu > 100) {
    fail('Nilai suhu tidak valid.');
}

if ($kelembapan < 0 || $kelembapan > 100) {
    fail('Nilai kelembapan tidak valid.');
}

$stmtDevice = $pdo->prepare(
    'SELECT id_alat, api_token
     FROM devices
     WHERE id_alat = ?
     LIMIT 1'
);
$stmtDevice->execute([$id_alat]);
$device = $stmtDevice->fetch();

if (!$device || !hash_equals($device['api_token'], $token)) {
    fail('Token alat tidak valid.', 403);
}

$status = $gas >= 600 ? 'danger' : ($gas >= 300 ? 'warning' : 'safe');
$deviceStatus = $status === 'safe' ? 'online' : $status;

$stmt = $pdo->prepare(
    'INSERT INTO sensor_readings (id_alat, gas_ppm, suhu, kelembapan, status)
     VALUES (?, ?, ?, ?, ?)'
);
$stmt->execute([$id_alat, $gas, $suhu, $kelembapan, $status]);

$stmtUpdateDevice = $pdo->prepare(
    'UPDATE devices
     SET status = ?, last_seen = NOW()
     WHERE id_alat = ?'
);
$stmtUpdateDevice->execute([$deviceStatus, $id_alat]);

$notificationSent = maybe_send_gas_alert(
    $pdo,
    $id_alat,
    $gas,
    $suhu,
    $kelembapan,
    $status
);

ok([
    'message' => 'Data sensor diterima.',
    'status' => $status,
    'notification_sent' => $notificationSent
]);
