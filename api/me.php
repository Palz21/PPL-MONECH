<?php
require __DIR__ . '/config.php';

$user = require_login();

if (!empty($user['id_alat'])) {
    $stmt = $pdo->prepare('SELECT api_token FROM devices WHERE id_alat = ? LIMIT 1');
    $stmt->execute([$user['id_alat']]);
    $token = $stmt->fetchColumn();

    if ($token) {
        $_SESSION['user']['device_token'] = $token;
        $user = $_SESSION['user'];
    }
}

ok([
    'user' => $user
]);
