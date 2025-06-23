<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = hash('sha256', $_POST['contrasena']);
    $rol_id = $_POST['rol_id'];

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena, rol_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $correo, $contrasena, $rol_id]);

    header("Location: /centralizacion_pyme/frontend/modulos/usuarios.php");
    exit;
}
?>

