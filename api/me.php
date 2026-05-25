<?php
require __DIR__ . '/config.php';

$user = require_login();

ok([
    'user' => $user
]);
