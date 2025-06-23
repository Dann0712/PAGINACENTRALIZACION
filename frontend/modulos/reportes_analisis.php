<?php
session_start();
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'supervisor')) {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../../backend/db/conexion.php');
$stmt = $pdo->query("SELECT * FROM reportes_analisis ORDER BY fecha_generado DESC");
$reportes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes y Análisis</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_reportes.css">
</head>
<body>
<header>
    <h1>Reportes y Análisis</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="contenedor">
    <?php if ($_SESSION['rol'] === 'admin'): ?>
    <section class="crear-reporte">
        <h2>Generar nuevo reporte</h2>
        <form action="/centralizacion_pyme/backend/reportes/crear.php" method="POST">
            <label>Módulo:</label>
            <input type="text" name="modulo" placeholder="Nombre del módulo" required>
            
            <label>Estadísticas:</label>
            <textarea name="estadisticas" rows="5" placeholder="Datos, observaciones, KPIs, etc." required></textarea>
            
            <button type="submit">Generar Reporte</button>
        </form>
    </section>
    <?php endif; ?>

    <section class="lista-reportes">
        <h2>Reportes Generados</h2>
        <table>
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Fecha</th>
                    <th>Estadísticas</th>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportes as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['modulo']) ?></td>
                    <td><?= htmlspecialchars($r['fecha_generado']) ?></td>
                    <td><?= nl2br(htmlspecialchars($r['estadisticas'])) ?></td>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <td>
                        <a href="/centralizacion_pyme/backend/reportes/editar.php?id=<?= $r['id'] ?>" class="btn-editar">Editar</a>
                        <a href="/centralizacion_pyme/backend/reportes/eliminar.php?id=<?= $r['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar este reporte?');">Eliminar</a>
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
