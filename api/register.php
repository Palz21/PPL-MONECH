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

    $_SESSION['user'] = [
        'nama'       => $nama,
        'email'      => $email,
        'id_alat'    => $id_alat,
        'alamat'     => $alamat,
        'no_telepon' => $no_telepon
    ];

    ok([
        'user' => $_SESSION['user']
    ]);

} catch (PDOException $e) {
    fail('Email sudah terdaftar atau database error.');
}
