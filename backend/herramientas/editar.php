
<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $fecha = $_POST['fecha_adquisicion'];
    $foto_nombre = $_POST['foto_actual'];

    if (!empty($_FILES['foto']['name'])) {
        $foto_nombre = basename($_FILES['foto']['name']);
        $destino = __DIR__ . '/../../uploads/herramientas/' . $foto_nombre;
        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
    }

    $stmt = $conn->prepare("UPDATE herramientas_equipos SET nombre=?, estado=?, fecha_adquisicion=?, fotografia=? WHERE id=?");
    $stmt->bind_param("ssssi", $nombre, $estado, $fecha, $foto_nombre, $id);
    $stmt->execute();
}

header("Location: /centralizacion_pyme/frontend/modulos/herramientas.php");
exit;
?>
