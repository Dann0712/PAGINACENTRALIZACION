<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $rol_id = intval($_POST['rol_id']);

    $sql = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo', rol_id = $rol_id WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: /centralizacion_pyme/frontend/modulos/usuarios.php");
        exit;
    } else {
        echo "Error actualizando usuario: " . $conn->error;
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
