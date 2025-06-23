<?php
require_once(__DIR__ . '/../db/conexion.php');

$nombre = $_POST['nombre'] ?? '';
$contacto = $_POST['contacto'] ?? '';
$notas = $_POST['notas'] ?? '';

if (!empty($nombre) && !empty($contacto)) {
    $stmt = $pdo->prepare("INSERT INTO plantas_clientes (nombre, contacto, notas) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $contacto, $notas]);
}

header("Location: /centralizacion_pyme/frontend/modulos/plantas_clientes.php");
exit;
