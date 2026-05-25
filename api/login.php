<?php
require __DIR__ . '/config.php';

$d = input_json();

$email = trim($d['email'] ?? '');
$password = $d['password'] ?? '';

if (!$email || !$password) {
    fail('Email dan password wajib diisi.');
}

$stmt = $pdo->prepare(
    'SELECT id, nama, email, id_alat, alamat, no_telepon, password_hash
     FROM users
     WHERE email = ?
     LIMIT 1'
);

$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    fail('Email atau password salah.');
}

$_SESSION['user'] = [
    'id'         => $user['id'],
    'nama'       => $user['nama'],
    'email'      => $user['email'],
    'id_alat'    => $user['id_alat'],
    'alamat'     => $user['alamat'] ?? '',
    'no_telepon' => $user['no_telepon'] ?? ''
];

ok([
    'user' => $_SESSION['user']
]);