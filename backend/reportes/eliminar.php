<?php
require_once(__DIR__ . '/../db/conexion.php');

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM reportes_analisis WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: /centralizacion_pyme/frontend/modulos/reportes_analisis.php");
exit;
?>
