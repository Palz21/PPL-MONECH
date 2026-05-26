<?php
require __DIR__ . '/config.php';

$d = input_json();

$email = trim($d['email'] ?? '');
$password = $d['password'] ?? '';

if (!$email || !$password) {
    fail('Email dan password wajib diisi.');
}

$stmt = $pdo->prepare(
    'SELECT u.id, u.nama, u.email, u.id_alat, u.alamat, u.no_telepon,
            u.foto_profil, u.password_hash, d.api_token AS device_token
     FROM users u
     LEFT JOIN devices d ON d.id_alat = u.id_alat
     WHERE u.email = ?
     LIMIT 1'
);

$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    fail('Email atau password salah.');
}

session_regenerate_id(true);

$_SESSION['user'] = [
    'id'         => $user['id'],
    'nama'       => $user['nama'],
    'email'      => $user['email'],
    'id_alat'    => $user['id_alat'],
    'alamat'     => $user['alamat'] ?? '',
    'no_telepon' => $user['no_telepon'] ?? '',
    'foto_profil'=> $user['foto_profil'] ?? '',
    'device_token' => $user['device_token'] ?? ''
];

ok([
    'user' => $_SESSION['user']
]);
