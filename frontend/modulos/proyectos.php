<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: /centralizacion_pyme/frontend/login.php");
    exit;
}

require_once(__DIR__ . '/../../backend/db/conexion.php');

$proyectos = $pdo->query("SELECT * FROM proyectos ORDER BY fecha_inicio DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Proyectos</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_proyectos.css">
</head>
<body>
<header>
    <h1>Gestión de Proyectos</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="proyectos-container">
    <?php if ($_SESSION['rol'] === 'admin'): ?>
    <section class="formulario-proyecto">
        <h2>Registrar Nuevo Proyecto</h2>
        <form action="/centralizacion_pyme/backend/proyectos/crear.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre del proyecto" required>
            <textarea name="descripcion" placeholder="Descripción del proyecto" required></textarea>
            <label>Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" required>
            <label>Fecha de fin:</label>
            <input type="date" name="fecha_fin">
            <label>Inversión (USD):</label>
            <input type="number" step="0.01" name="inversion" required>
            <button type="submit">Registrar Proyecto</button>
        </form>
    </section>
    <?php endif; ?>

    <section class="lista-proyectos">
        <h2>Listado de Proyectos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Inversión</th>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($proyectos as $proyecto): ?>
                <tr>
                    <td><?= htmlspecialchars($proyecto['nombre']) ?></td>
                    <td><?= htmlspecialchars($proyecto['descripcion']) ?></td>
                    <td><?= $proyecto['fecha_inicio'] ?></td>
                    <td><?= $proyecto['fecha_fin'] ?></td>
                    <td>$<?= number_format($proyecto['inversion'], 2) ?></td>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <td>
                        <a href="/centralizacion_pyme/backend/proyectos/editar.php?id=<?= $proyecto['id'] ?>" class="btn-editar">Editar</a>
                        <a href="/centralizacion_pyme/backend/proyectos/eliminar.php?id=<?= $proyecto['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Deseas eliminar este proyecto?');">Eliminar</a>
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
