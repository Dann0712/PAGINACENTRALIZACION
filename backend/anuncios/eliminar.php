<?php
session_start();
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM anuncios WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Error al eliminar el anuncio: " . $e->getMessage();
            exit;
        }
    }
}
header("Location: /centralizacion_pyme/frontend/modulos/anuncios.php");
exit;
?>
