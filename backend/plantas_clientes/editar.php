require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $notas = $_POST['notas'];

    $stmt = $pdo->prepare("UPDATE plantas_clientes SET nombre = ?, contacto = ?, notas = ? WHERE id = ?");
    $stmt->execute([$nombre, $contacto, $notas, $id]);
    header("Location: /centralizacion_pyme/frontend/modulos/plantas_clientes.php");
    exit;
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM plantas_clientes WHERE id = ?");
    $stmt->execute([$id]);
    $planta = $stmt->fetch();
}
?>

<!-- Formulario HTML para edición -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Planta o Cliente</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
</head>
<body>
<header>
    <h1>Editar Registro</h1>
</header>
<main class="contenedor">
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $planta['id'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($planta['nombre']) ?>" required>
        <textarea name="contacto" required><?= htmlspecialchars($planta['contacto']) ?></textarea>
        <textarea name="notas"><?= htmlspecialchars($planta['notas']) ?></textarea>
        <button type="submit">Guardar Cambios</button>
    </form>
</main>
</body>
</html>
