<?php
require __DIR__ . '/config.php';

$user = require_login();

if (empty($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    fail('Foto profil belum dipilih.');
}

$file = $_FILES['foto'];
$maxSize = 2 * 1024 * 1024;

if ($file['size'] > $maxSize) {
    fail('Ukuran foto maksimal 2MB.');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
$allowed = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

if (!isset($allowed[$mime])) {
    fail('Format foto harus JPG, PNG, atau WEBP.');
}

$uploadDir = dirname(__DIR__) . '/uploads/profile';

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true)) {
    fail('Folder upload tidak bisa dibuat.', 500);
}

$fileName = 'user-' . $user['id'] . '-' . time() . '.' . $allowed[$mime];
$target = $uploadDir . '/' . $fileName;

if (!move_uploaded_file($file['tmp_name'], $target)) {
    fail('Gagal menyimpan foto profil.', 500);
}

$photoPath = 'uploads/profile/' . $fileName;

$stmt = $pdo->prepare('UPDATE users SET foto_profil = ? WHERE id = ?');
$stmt->execute([$photoPath, $user['id']]);

$_SESSION['user']['foto_profil'] = $photoPath;

ok([
    'message' => 'Foto profil berhasil diperbarui.',
    'foto_profil' => $photoPath,
    'user' => $_SESSION['user']
]);
