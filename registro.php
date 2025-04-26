<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $imagen = ''; // Se puede agregar subida de imagen luego

    if (strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
        die('La contraseña debe tener al menos 6 caracteres, una mayúscula y un símbolo especial.');
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_completo, telefono, usuario, password, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $telefono, $usuario, $password_hash, $imagen]);

    echo "¡Registro exitoso! <a href='templates/login.html'>Iniciar sesión</a>";
}
?>
