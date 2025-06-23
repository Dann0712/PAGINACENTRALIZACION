<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pdo->prepare("DELETE FROM inventario WHERE id = ?")->execute([$id]);
}
header("Location: /centralizacion_pyme/frontend/modulos/inventario.php");
exit;
?>
