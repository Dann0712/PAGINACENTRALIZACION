<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    $imagen = null;
    if (!empty($_FILES['imagen']['name'])) {
        $nombreImagen = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $rutaImagen = __DIR__ . '/../../uploads/inventario/' . $nombreImagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
        $imagen = $nombreImagen;
    }

    $stmt = $pdo->prepare("INSERT INTO inventario (nombre, descripcion, cantidad, imagen) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $cantidad, $imagen]);

    header("Location: /centralizacion_pyme/frontend/modulos/inventario.php");
    exit;
}
?>
