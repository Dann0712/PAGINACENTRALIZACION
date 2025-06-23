<?php
require_once(__DIR__ . '/../db/conexion.php');

$descripcion = $_POST['descripcion'] ?? '';
$servicios = $_POST['servicios'] ?? '';
$mantenimiento = $_POST['mantenimiento'] ?? '';
$fotografia = null;

if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = uniqid() . '_' . $_FILES['fotografia']['name'];
    move_uploaded_file($_FILES['fotografia']['tmp_name'], "../../uploads/transportes/" . $nombreArchivo);
    $fotografia = $nombreArchivo;
}

$sql = "INSERT INTO transportes (descripcion, servicios, mantenimiento, fotografia) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$descripcion, $servicios, $mantenimiento, $fotografia]);

header("Location: /centralizacion_pyme/frontend/modulos/transportes.php");
exit;
