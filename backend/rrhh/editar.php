<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if ($_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$puesto = $_POST['puesto'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$foto = $_FILES['foto']['name'] ?? null;
$documento = $_FILES['documento']['name'] ?? null;

if ($foto) {
    $foto_path = "../../uploads/rrhh/fotos/" . basename($foto);
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path);
}

if ($documento) {
    $doc_path = "../../uploads/rrhh/documentos/" . basename($documento);
    move_uploaded_file($_FILES['documento']['tmp_name'], $doc_path);
}

$sql = "UPDATE recursos_humanos SET nombre=?, puesto=?, fecha_ingreso=?";
$params = [$nombre, $puesto, $fecha_ingreso];

if ($foto) {
    $sql .= ", foto=?";
    $params[] = $foto;
}

if ($documento) {
    $sql .= ", documento=?";
    $params[] = $documento;
}

$sql .= " WHERE id=?";
$params[] = $id;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

header("Location: /centralizacion_pyme/frontend/modulos/recursos_humanos.php");
exit;
?>
