<?php
require_once(__DIR__ . '/../db/conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM compras_proveedores WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: /centralizacion_pyme/frontend/modulos/compras.php");
exit;
?>
cre