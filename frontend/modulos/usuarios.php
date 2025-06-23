<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../../backend/db/conexion.php');

$stmt = $pdo->query("SELECT u.id, u.nombre, u.correo, r.nombre AS rol FROM usuarios u JOIN roles r ON u.rol_id = r.id ORDER BY u.id DESC");
$usuarios = $stmt->fetchAll();

$roles = $pdo->query("SELECT * FROM roles")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_usuarios.css">
</head>
<body>
<header>
    <h1>Gestión de Usuarios y Roles</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="usuarios-container">
    <section class="crear-usuario">
        <h2>Registrar nuevo usuario</h2>
        <form action="/centralizacion_pyme/backend/usuarios/crear.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre de usuario" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <select name="rol_id" required>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= $rol['id'] ?>"><?= ucfirst($rol['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Crear Usuario</button>
        </form>
    </section>

    <section class="lista-usuarios">
        <h2>Lista de usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                        <td><?= ucfirst($usuario['rol']) ?></td>
                        <td>
                            <a href="/centralizacion_pyme/backend/usuarios/editar.php?id=<?= $usuario['id'] ?>" class="btn-editar">Editar</a>
                            <a href="/centralizacion_pyme/backend/usuarios/eliminar.php?id=<?= $usuario['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p>&copy; 2025 Tecnología y Desarrollo Electromecánico. Todos los derechos reservados.</p>
</footer>
</body>
</html>
