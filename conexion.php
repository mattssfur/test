<?php
$host = 'trolley.proxy.rlwy.net';
$dbname = 'railway';
$username = 'root';
$password = 'NRSPvoOhVxIzsWhWNguztJUuoPjZsdqF';
$port = '31116';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "¡Conexión exitosa!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>
