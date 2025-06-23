
<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_adquisicion'];
    $estado = $_POST['estado'];
    $foto_nombre = '';

    if (!empty($_FILES['foto']['name'])) {
        $foto_nombre = basename($_FILES['foto']['name']);
        $destino = __DIR__ . '/../../uploads/herramientas/' . $foto_nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
    }

    $stmt = $conn->prepare("INSERT INTO herramientas_equipos (nombre, estado, fecha_adquisicion, fotografia) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $estado, $fecha, $foto_nombre);
    $stmt->execute();
}

header("Location: /centralizacion_pyme/frontend/modulos/herramientas.php");
exit;
?>
