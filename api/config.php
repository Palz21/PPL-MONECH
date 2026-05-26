<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 60 * 60 * 24 * 7,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'monech';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Database belum terhubung. Import database/monech_database.sql lalu cek api/config.php.']);
    exit;
}
function input_json(){
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $_POST;
}
function ok($data=[]){ echo json_encode(['success'=>true] + $data); exit; }
function fail($msg,$code=400){ http_response_code($code); echo json_encode(['success'=>false,'message'=>$msg]); exit; }
function device_token_for_id($id_alat){
    if (preg_match('/(\d+)$/', $id_alat, $matches)) {
        return 'monech-device-' . str_pad($matches[1], 3, '0', STR_PAD_LEFT);
    }

    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $id_alat));
    $slug = trim($slug, '-');

    return 'monech-device-' . ($slug ?: 'unknown');
}
function require_login(){
    if (empty($_SESSION['user'])) {
        fail('Belum login.', 401);
    }

    return $_SESSION['user'];
}
?>
