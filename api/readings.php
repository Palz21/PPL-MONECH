<?php
require __DIR__ . '/config.php';

$user = require_login();
$id_alat = $user['id_alat'];

$latest = $pdo->prepare(
    'SELECT * FROM sensor_readings
     WHERE id_alat = ?
     ORDER BY created_at DESC
     LIMIT 1'
);
$latest->execute([$id_alat]);
$latestReading = $latest->fetch();

$hist = $pdo->prepare(
    'SELECT gas_ppm, suhu, kelembapan, status,
            DATE_FORMAT(created_at, "%H:%i") label,
            created_at
     FROM sensor_readings
     WHERE id_alat = ?
     ORDER BY created_at DESC
     LIMIT 12'
);
$hist->execute([$id_alat]);
$history = array_reverse($hist->fetchAll());

ok([
    'latest' => $latestReading,
    'history' => $history
]);
