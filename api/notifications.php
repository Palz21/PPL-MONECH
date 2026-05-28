<?php
require_once __DIR__ . '/telegram_config.php';

function telegram_ready()
{
    return defined('TELEGRAM_BOT_TOKEN')
        && defined('TELEGRAM_CHAT_ID')
        && TELEGRAM_BOT_TOKEN !== ''
        && TELEGRAM_CHAT_ID !== '';
}

function send_telegram_message($message)
{
    if (!telegram_ready()) {
        return false;
    }

    $url = 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/sendMessage';
    $payload = http_build_query([
        'chat_id' => TELEGRAM_CHAT_ID,
        'text' => $message,
        'parse_mode' => 'HTML'
    ]);

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => $payload,
            'timeout' => 5
        ]
    ]);

    $response = @file_get_contents($url, false, $context);

    return $response !== false;
}

function maybe_send_gas_alert(PDO $pdo, $id_alat, $gas, $suhu, $kelembapan, $status)
{
    if ($status !== 'danger') {
        return false;
    }

    $stmt = $pdo->prepare(
        'SELECT d.last_alert_at, u.nama, u.alamat
         FROM devices d
         LEFT JOIN users u ON u.id_alat = d.id_alat
         WHERE d.id_alat = ?
         LIMIT 1'
    );
    $stmt->execute([$id_alat]);
    $row = $stmt->fetch();

    if (!$row) {
        return false;
    }

    $cooldown = defined('TELEGRAM_ALERT_COOLDOWN_SECONDS')
        ? (int) TELEGRAM_ALERT_COOLDOWN_SECONDS
        : 300;

    if (!empty($row['last_alert_at'])) {
        $lastAlert = strtotime($row['last_alert_at']);

        if ($lastAlert && time() - $lastAlert < $cooldown) {
            return false;
        }
    }

    $nama = $row['nama'] ?: 'Pengguna GASCOM';
    $alamat = $row['alamat'] ?: 'Lokasi belum diisi';

    $message = "PERINGATAN GAS BAHAYA\n"
        . "Alat: {$id_alat}\n"
        . "Pengguna: {$nama}\n"
        . "Lokasi: {$alamat}\n"
        . "Gas: {$gas} PPM\n"
        . "Suhu: {$suhu} C\n"
        . "Kelembapan: {$kelembapan}%\n\n"
        . "Segera periksa kompor, regulator, selang gas, dan buka ventilasi ruangan.";

    if (!send_telegram_message($message)) {
        return false;
    }

    $stmtUpdate = $pdo->prepare(
        'UPDATE devices
         SET last_alert_at = NOW()
         WHERE id_alat = ?'
    );
    $stmtUpdate->execute([$id_alat]);

    return true;
}
