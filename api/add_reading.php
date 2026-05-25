<?php
require __DIR__ . '/config.php';

$user = require_login();
$d = input_json();

$id_alat = $user['id_alat'];
$gas = isset($d['gas_ppm']) ? (int) $d['gas_ppm'] : rand(90, 450);
$suhu = isset($d['suhu']) ? (float) $d['suhu'] : rand(270, 310) / 10;
$kelembapan = isset($d['kelembapan']) ? (float) $d['kelembapan'] : rand(55, 70);

if ($gas < 0 || $gas > 5000) {
    fail('Nilai gas tidak valid.');
}

if ($suhu < -20 || $suhu > 100) {
    fail('Nilai suhu tidak valid.');
}

if ($kelembapan < 0 || $kelembapan > 100) {
    fail('Nilai kelembapan tidak valid.');
}

$status = $gas >= 600 ? 'danger' : ($gas >= 300 ? 'warning' : 'safe');

$stmt = $pdo->prepare(
    'INSERT INTO sensor_readings (id_alat, gas_ppm, suhu, kelembapan, status)
     VALUES (?, ?, ?, ?, ?)'
);

$stmt->execute([$id_alat, $gas, $suhu, $kelembapan, $status]);

ok(['message' => 'Data sensor tersimpan']);
