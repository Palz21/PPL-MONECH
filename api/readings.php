<?php require __DIR__.'/config.php';
$id_alat = $_SESSION['user']['id_alat'] ?? ($_GET['id_alat'] ?? 'MNC-001');
$latest = $pdo->prepare('SELECT * FROM sensor_readings WHERE id_alat=? ORDER BY created_at DESC LIMIT 1'); $latest->execute([$id_alat]); $l=$latest->fetch();
if(!$l){
  $pdo->prepare('INSERT INTO sensor_readings(id_alat,gas_ppm,suhu,kelembapan,status) VALUES(?,?,?,?,?)')->execute([$id_alat,120,28.5,65,'safe']);
  $latest->execute([$id_alat]); $l=$latest->fetch();
}
$hist = $pdo->prepare('SELECT gas_ppm,suhu,kelembapan,status, DATE_FORMAT(created_at, "%H:%i") label, created_at FROM sensor_readings WHERE id_alat=? ORDER BY created_at DESC LIMIT 12'); $hist->execute([$id_alat]);
$history = array_reverse($hist->fetchAll());
ok(['latest'=>$l,'history'=>$history]);
