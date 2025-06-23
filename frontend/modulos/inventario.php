<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}
require_once(__DIR__ . '/../../backend/db/conexion.php');

$rol = $_SESSION['rol'];
$inventario = $pdo->query("SELECT * FROM inventario ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Inventario</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_inventario.css">
</head>
<body>
<header>
    <h1>Inventario General</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="contenedor">
    <?php if ($rol === 'admin' || $rol === 'supervisor'): ?>
    <section class="formulario">
        <h2>Registrar nuevo ítem</h2>
        <form action="/centralizacion_pyme/backend/inventario/crear.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <textarea name="descripcion" placeholder="Descripción del producto" required></textarea>
            <input type="number" name="cantidad" placeholder="Cantidad disponible" required>
            <label>Imagen:</label>
            <input type="file" name="imagen">
            <button type="submit">Registrar</button>
        </form>
    </section>
    <?php endif; ?>

    <section class="lista">
        <h2>Listado de inventario</h2>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <?php if ($rol === 'admin' || $rol === 'supervisor'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventario as $item): ?>
                <tr>
                    <td><img src="/centralizacion_pyme/uploads/inventario/<?= htmlspecialchars($item['imagen']) ?>" width="60"></td>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td><?= htmlspecialchars($item['descripcion']) ?></td>
                    <td><?= htmlspecialchars($item['cantidad']) ?></td>
                    <?php if ($rol === 'admin' || $rol === 'supervisor'): ?>
                    <td>
                        <a href="/centralizacion_pyme/backend/inventario/editar.php?id=<?= $item['id'] ?>" class="btn-editar">Editar</a>
                        <a href="/centralizacion_pyme/backend/inventario/eliminar.php?id=<?= $item['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este ítem?');">Eliminar</a>
                    </td>
                    <?php endif; ?>
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
