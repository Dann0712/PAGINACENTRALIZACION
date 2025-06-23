<?php
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    $inversion = $_POST['inversion'] ?? 0;

    $stmt = $pdo->prepare("INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin, inversion) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $fecha_inicio, $fecha_fin, $inversion]);

    header("Location: /centralizacion_pyme/frontend/modulos/proyectos.php");
    exit;
}
?>
