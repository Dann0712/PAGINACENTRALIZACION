
<?php
require_once(__DIR__ . '/../db/conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM herramientas_equipos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: /centralizacion_pyme/frontend/modulos/herramientas.php");
exit;
?>
