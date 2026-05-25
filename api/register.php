<?php
require __DIR__ . '/config.php';

$d = input_json();

$nama       = trim($d['nama'] ?? '');
$email      = trim($d['email'] ?? '');
$alamat     = trim($d['alamat'] ?? '');
$no_telepon = trim($d['no_telepon'] ?? '');
$password   = $d['password'] ?? '';
$konfirmasi = $d['konfirmasi'] ?? '';

if (!$nama || !$email || !$alamat || !$password) {
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
    $stmtNext = $pdo->query(
        "SELECT COALESCE(MAX(CAST(SUBSTRING(id_alat, 5) AS UNSIGNED)), 0) + 1 AS next_number
         FROM users
         WHERE id_alat REGEXP '^MNC-[0-9]+$'"
    );
    $nextNumber = (int) $stmtNext->fetchColumn();
    $id_alat = 'MNC-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
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
        'INSERT IGNORE INTO devices (id_alat, nama_alat, lokasi, status)
         VALUES (?, ?, ?, ?)'
    );

    $stmtDevice->execute([
        $id_alat,
        'MONECH Device',
        $alamat ?: 'Area Utama',
        'online'
    ]);

    session_regenerate_id(true);

    $_SESSION['user'] = [
        'id'         => $userId,
        'nama'       => $nama,
        'email'      => $email,
        'id_alat'    => $id_alat,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon,
        'foto_profil'=> ''
    ];

    ok([
        'user' => $_SESSION['user']
    ]);

} catch (PDOException $e) {
    fail('Email sudah terdaftar atau database error.');
}
