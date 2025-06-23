<?php
session_start();
require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $titulo = $_POST['titulo'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    if ($id) {
        try {
            $stmt = $pdo->prepare("UPDATE anuncios SET titulo = ?, mensaje = ? WHERE id = ?");
            $stmt->execute([$titulo, $mensaje, $id]);
            header("Location: /centralizacion_pyme/frontend/modulos/anuncios.php");
            exit;
        } catch (PDOException $e) {
            echo "Error al actualizar el anuncio: " . $e->getMessage();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM anuncios WHERE id = ?");
    $stmt->execute([$id]);
    $anuncio = $stmt->fetch();
    if (!$anuncio) {
        echo "Anuncio no encontrado.";
        exit;
    }
} else {
    header("Location: /centralizacion_pyme/frontend/modulos/anuncios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Anuncio</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_anuncios.css">
</head>
<body>
    <header>
        <h1>Editar Anuncio</h1>
        <a href="/centralizacion_pyme/frontend/modulos/anuncios.php">← Volver</a>
    </header>
    <main class="login-container">
        <form action="editar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($anuncio['id']); ?>">
            <label>Título</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($anuncio['titulo']); ?>" required>
            <label>Mensaje</label>
            <textarea name="mensaje" rows="6" required><?php echo htmlspecialchars($anuncio['mensaje']); ?></textarea>
            <button type="submit">Guardar cambios</button>
        </form>
    </main>
</body>
</html>
