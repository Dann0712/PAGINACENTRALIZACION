<?php
require_once(__DIR__ . '/../db/conexion.php');

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM plantas_clientes WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header("Location: /centralizacion_pyme/frontend/modulos/plantas_clientes.php");
exit;
