<?php
session_start();
require_once('../config/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $sql = "SELECT id, nombre, correo, contrasena, rol_id FROM usuarios WHERE nombre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

    if ($user && hash('sha256', $contrasena) === $user['contrasena']) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = match((int)$user['rol_id']) {
            1 => 'empleado',
            2 => 'supervisor',
            3 => 'admin',
            default => 'invitado'
        };

        // Actualizar última conexión y estado en línea
        $update = $pdo->prepare("UPDATE usuarios SET ultima_conexion = NOW(), en_linea = 1 WHERE id = ?");
        $update->execute([$user['id']]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Credenciales inválidas']);
    }
}
