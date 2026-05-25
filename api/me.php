<?php
require __DIR__ . '/config.php';

if (empty($_SESSION['user'])) {
    fail('Belum login.');
}

ok([
    'user' => $_SESSION['user']
]);