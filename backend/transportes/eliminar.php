<?php
require_once(__DIR__ . '/../db/conexion.php');

$id = $_GET['id'] ?? null;

if ($id) {
    // Obtener nombre de la fotografía para eliminarla del servidor
    $stmt = $pdo->prepare("SELECT fotografia FROM transportes WHERE id = ?");
    $stmt->execute([$id]);
    $transporte = $stmt->fetch();

    if ($transporte && $transporte['fotografia']) {
        $ruta = "../../uploads/transportes/" . $transporte['fotografia'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }
    }

    // Eliminar registro de la base de datos
    $stmt = $pdo->prepare("DELETE FROM transportes WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: /centralizacion_pyme/frontend/modulos/transportes.php");
exit;
