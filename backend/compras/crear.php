<?php
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['proveedor_nombre'] ?? '';
    $contacto = $_POST['contacto'] ?? '';
    $fecha = $_POST['fecha_compra'] ?? '';
    $monto = $_POST['monto'] ?? 0;

    $stmt = $pdo->prepare("INSERT INTO compras_proveedores (proveedor_nombre, contacto, fecha_compra, monto) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $contacto, $fecha, $monto]);

    header("Location: /centralizacion_pyme/frontend/modulos/compras.php");
    exit;
}
?>
