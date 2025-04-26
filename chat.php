<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: templates/login.html');
    exit;
}

$mi_id = $_SESSION['usuario_id'];

// Enviar mensaje
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensaje']) && isset($_POST['receptor'])) {
    $mensaje = $_POST['mensaje'];
    $receptor = $_POST['receptor'];

    $stmt = $pdo->prepare("INSERT INTO mensajes (emisor_id, receptor_id, mensaje) VALUES (?, ?, ?)");
    $stmt->execute([$mi_id, $receptor, $mensaje]);
}

// Obtener todos los mensajes
$stmt = $pdo->prepare("SELECT u.usuario AS emisor_nombre, u2.usuario AS receptor_nombre, m.mensaje, m.fecha_hora
                       FROM mensajes m
                       JOIN usuarios u ON m.emisor_id = u.id
                       JOIN usuarios u2 ON m.receptor_id = u2.id
                       WHERE m.emisor_id = ? OR m.receptor_id = ?
                       ORDER BY m.fecha_hora ASC");
$stmt->execute([$mi_id, $mi_id]);
$mensajes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h2>Chat</h2>

<form method="POST">
    <input type="text" name="receptor" placeholder="ID del receptor" required><br>
    <textarea name="mensaje" placeholder="Mensaje" required></textarea><br>
    <button type="submit">Enviar</button>
</form>

<div id="mensajes">
<?php foreach ($mensajes as $m): ?>
    <p><strong><?= htmlspecialchars($m['emisor_nombre']) ?></strong> ➡️ <strong><?= htmlspecialchars($m['receptor_nombre']) ?></strong>: <?= htmlspecialchars($m['mensaje']) ?> <em>(<?= $m['fecha_hora'] ?>)</em></p>
<?php endforeach; ?>
</div>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>
