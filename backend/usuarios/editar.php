<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../db/conexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol_id = $_POST['rol_id'];

    $sql = "UPDATE usuarios SET nombre = ?, correo = ?, rol_id = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $correo, $rol_id, $id]);

    header("Location: /centralizacion_pyme/frontend/modulos/usuarios.php");
    exit;
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch();

    $roles = $pdo->query("SELECT * FROM roles")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <label>Nombre: <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>" required></label><br>
        <label>Correo: <input type="email" name="correo" value="<?= $usuario['correo'] ?>" required></label><br>
        <label>Rol:
            <select name="rol_id" required>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= $rol['id'] ?>" <?= $rol['id'] == $usuario['rol_id'] ? 'selected' : '' ?>>
                        <?= $rol['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
<?php } ?>
