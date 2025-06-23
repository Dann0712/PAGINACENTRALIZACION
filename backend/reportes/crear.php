<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modulo = $_POST['modulo'] ?? '';
    $estadisticas = $_POST['estadisticas'] ?? '';

    $fecha_generado = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO reportes_analisis (modulo, fecha_generado, estadisticas) VALUES (?, ?, ?)");
    $stmt->execute([$modulo, $fecha_generado, $estadisticas]);

    header("Location: /centralizacion_pyme/frontend/modulos/reportes.php");
    exit;
}
?>
