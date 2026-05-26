<?php
require __DIR__ . '/config.php';

$d = input_json();

$nama       = trim($d['nama'] ?? '');
$email      = trim($d['email'] ?? '');
$id_alat    = trim($d['id_alat'] ?? '');
$alamat     = trim($d['alamat'] ?? '');
$no_telepon = trim($d['no_telepon'] ?? '');
$password   = $d['password'] ?? '';
$konfirmasi = $d['konfirmasi'] ?? '';

if (!$nama || !$email || !$id_alat || !$alamat || !$password) {
    fail('Semua field wajib diisi.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('Format email tidak valid.');
}

if (strlen($password) < 5) {
    fail('Password minimal 5 karakter.');
}

if ($password !== $konfirmasi) {
    fail('Konfirmasi password tidak sama.');
}

try {
    $stmtExistingDeviceUser = $pdo->prepare(
        'SELECT COUNT(*)
         FROM users
         WHERE id_alat = ?'
    );
    $stmtExistingDeviceUser->execute([$id_alat]);

    if ((int) $stmtExistingDeviceUser->fetchColumn() > 0) {
        fail('ID alat sudah terdaftar. Gunakan ID alat yang berbeda.');
    }

    $deviceToken = device_token_for_id($id_alat);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        'INSERT INTO users (nama, email, id_alat, alamat, no_telepon, password_hash)
         VALUES (?, ?, ?, ?, ?, ?)'
    );

    $stmt->execute([
        $nama,
        $email,
        $id_alat,
        $alamat,
        $no_telepon,
        $hash
    ]);

    $userId = (int) $pdo->lastInsertId();

    $stmtDevice = $pdo->prepare(
        'INSERT INTO devices (id_alat, nama_alat, lokasi, api_token, status)
         VALUES (?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
            lokasi = VALUES(lokasi),
            api_token = IF(api_token IS NULL OR api_token = "", VALUES(api_token), api_token),
            status = "online"'
    );

    $stmtDevice->execute([
        $id_alat,
        'MONECH Device',
        $alamat ?: 'Area Utama',
        $deviceToken,
        'online'
    ]);

    $stmtDeviceToken = $pdo->prepare('SELECT api_token FROM devices WHERE id_alat = ? LIMIT 1');
    $stmtDeviceToken->execute([$id_alat]);
    $deviceToken = $stmtDeviceToken->fetchColumn() ?: $deviceToken;

    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id'         => $userId,
        'nama'       => $nama,
        'email'      => $email,
        'id_alat'    => $id_alat,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon,
        'foto_profil'=> '',
        'device_token' => $deviceToken
    ];

    ok([
        'user' => $_SESSION['user']
    ]);

} catch (PDOException $e) {
    fail('Email sudah terdaftar atau database error.');
}
