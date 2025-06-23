<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}
require_once(__DIR__ . '/../../backend/db/conexion.php');

$result = $conn->query("SELECT u.id, u.nombre, u.correo, r.nombre as rol, u.foto_perfil, u.en_linea, u.ultima_conexion FROM usuarios u JOIN roles r ON u.rol_id = r.id ORDER BY u.id ASC");
$usuarios = $result->fetch_all(MYSQLI_ASSOC);
$roles = $conn->query("SELECT * FROM roles ORDER BY id")->fetch_all(MYSQLI_ASSOC);
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
        <h1>Gestión de Usuarios</h1>
        <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
    </header>
    <main class="contenedor">
        <section class="formulario">
            <h2>Registrar nuevo usuario</h2>
            <form action="/centralizacion_pyme/backend/usuarios/crear.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre de usuario" required>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <input type="password" name="contrasena" placeholder="Contraseña temporal" required>
                <select name="rol_id" required>
                    <option value="">Selecciona un rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?php echo $rol['id']; ?>"><?php echo ucfirst($rol['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Crear usuario</button>
            </form>
        </section>

        <section class="tabla-usuarios">
            <h2>Usuarios registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Foto</th>
                        <th>Estado</th>
                        <th>Última conexión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                            <td><?php echo ucfirst($usuario['rol']); ?></td>
                            <td>
                                <?php if ($usuario['foto_perfil']): ?>
                                    <img src="/centralizacion_pyme/uploads/fotos/<?php echo htmlspecialchars($usuario['foto_perfil']); ?>" width="50">
                                <?php else: ?>
                                    Sin foto
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $usuario['en_linea'] ? '<span style="color:green;">En línea</span>' : '<span style="color:gray;">Desconectado</span>'; ?>
                            </td>
                            <td><?php echo $usuario['ultima_conexion'] ?? 'Nunca'; ?></td>
                            <td>
                                <form action="/centralizacion_pyme/backend/usuarios/eliminar.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <button class="borrar" onclick="return confirm('¿Eliminar este usuario?');">Eliminar</button>
                                </form>
                                <form action="/centralizacion_pyme/backend/usuarios/editar.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <button class="editar">Editar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
