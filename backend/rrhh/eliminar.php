<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if ($_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM recursos_humanos WHERE id = ?");
$stmt->execute([$id]);

header("Location: /centralizacion_pyme/frontend/modulos/recursos_humanos.php");
exit;
?>
