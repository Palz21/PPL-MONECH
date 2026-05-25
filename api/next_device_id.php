<?php
require __DIR__ . '/config.php';

$stmt = $pdo->query(
    "SELECT COALESCE(MAX(CAST(SUBSTRING(id_alat, 5) AS UNSIGNED)), 0) + 1 AS next_number
     FROM users
     WHERE id_alat REGEXP '^MNC-[0-9]+$'"
);

$nextNumber = (int) $stmt->fetchColumn();
$id_alat = 'MNC-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

ok(['id_alat' => $id_alat]);
