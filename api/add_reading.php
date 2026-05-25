<?php require __DIR__.'/config.php';
$d = input_json(); $id_alat = $_SESSION['user']['id_alat'] ?? ($d['id_alat'] ?? 'MNC-001');
$gas = intval($d['gas_ppm'] ?? rand(90,450)); $suhu = floatval($d['suhu'] ?? rand(270,310)/10); $hum = floatval($d['kelembapan'] ?? rand(55,70));
$status = $gas >= 600 ? 'danger' : ($gas >= 300 ? 'warning' : 'safe');
$pdo->prepare('INSERT INTO sensor_readings(id_alat,gas_ppm,suhu,kelembapan,status) VALUES(?,?,?,?,?)')->execute([$id_alat,$gas,$suhu,$hum,$status]);
ok(['message'=>'Data sensor tersimpan']);
