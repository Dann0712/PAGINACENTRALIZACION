<?php
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegurar que los campos esperados están presentes
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $puesto = isset($_POST['puesto']) ? $_POST['puesto'] : '';
    $fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : '';

    // Preparar info_general combinando nombre, puesto y fecha
    $info_general = "Nombre: $nombre\nPuesto: $puesto\nFecha de ingreso: $fecha_ingreso";

    // Procesar la fotografía
    $foto_nombre = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto_nombre = uniqid() . "_" . basename($_FILES['foto']['name']);
        $destino_foto = __DIR__ . '/../../uploads/rrhh/fotos/' . $foto_nombre;
        if (!is_dir(dirname($destino_foto))) {
            mkdir(dirname($destino_foto), 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], $destino_foto);
    }

    // Procesar documento
    $doc_nombre = '';
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        $doc_nombre = uniqid() . "_" . basename($_FILES['documento']['name']);
        $destino_doc = __DIR__ . '/../../uploads/rrhh/documentos/' . $doc_nombre;
        if (!is_dir(dirname($destino_doc))) {
            mkdir(dirname($destino_doc), 0777, true);
        }
        move_uploaded_file($_FILES['documento']['tmp_name'], $destino_doc);
    }

    // Insertar en la base de datos
    $stmt = $pdo->prepare("INSERT INTO recursos_humanos (usuario_id, fotografia, documento, info_general) VALUES (?, ?, ?, ?)");
    $stmt->execute([null, $foto_nombre, $doc_nombre, $info_general]);

    header("Location: /centralizacion_pyme/frontend/modulos/recursos_humanos.php");
    exit;
}
?>
