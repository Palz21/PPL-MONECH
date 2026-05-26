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

$stmtDevice = $pdo->prepare(
    'SELECT status, last_seen,
            CASE
              WHEN last_seen IS NULL THEN 1
              WHEN TIMESTAMPDIFF(SECOND, last_seen, NOW()) > 12 THEN 1
              ELSE 0
            END AS is_offline
     FROM devices
     WHERE id_alat = ?
     LIMIT 1'
);
$stmtDevice->execute([$id_alat]);
$device = $stmtDevice->fetch();

if ($device && (int) $device['is_offline'] === 1) {
    $device['status'] = 'offline';

    $stmtOffline = $pdo->prepare(
        'UPDATE devices
         SET status = ?
         WHERE id_alat = ?'
    );
    $stmtOffline->execute(['offline', $id_alat]);
}

ok([
    'latest' => $latestReading,
    'history' => $history,
    'device' => $device
]);
