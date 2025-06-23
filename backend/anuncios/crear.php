<?php
session_start();
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    $autor = $_SESSION['usuario'] ?? 'anónimo';
    $fecha = date('Y-m-d H:i:s');

    try {
        $stmt = $pdo->prepare("INSERT INTO anuncios (titulo, mensaje, fecha_publicacion, autor) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $mensaje, $fecha, $autor]);
        header("Location: /centralizacion_pyme/frontend/modulos/anuncios.php");
        exit;
    } catch (PDOException $e) {
        echo "Error al publicar el anuncio: " . $e->getMessage();
    }
}
?>
