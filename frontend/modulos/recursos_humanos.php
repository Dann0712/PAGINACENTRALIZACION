<?php
session_start();
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'supervisor')) {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../../backend/db/conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Recursos Humanos</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_rrhh.css">
</head>
<body>
<header>
    <h1>Recursos Humanos</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="rrhh-container">
    <section>
        <h2>Gestión de Personal</h2>
        <?php if ($_SESSION['rol'] === 'admin'): ?>
        <form action="/centralizacion_pyme/backend/rrhh/crear.php" method="POST" enctype="multipart/form-data">
            <label>Información general (nombre, puesto, fecha de ingreso):</label>
            <textarea name="info_general" required></textarea>

            <label>Fotografía:</label>
            <input type="file" name="foto">

            <label>Documentos (PDF):</label>
            <input type="file" name="documento">

            <button type="submit">Registrar Empleado</button>
        </form>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre / Correo</th>
                    <th>Información</th>
                    <th>Documento</th>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $pdo->query("SELECT rh.*, u.nombre, u.correo 
                                FROM recursos_humanos rh 
                                LEFT JOIN usuarios u ON rh.usuario_id = u.id 
                                ORDER BY rh.id DESC");

            while ($empleado = $stmt->fetch()):
            ?>
                <tr>
                    <td>
                        <?php if ($empleado['fotografia']): ?>
                            <img src="/centralizacion_pyme/uploads/rrhh/fotos/<?= htmlspecialchars($empleado['fotografia']) ?>" width="60">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($empleado['nombre']) ?><br><?= htmlspecialchars($empleado['correo']) ?></td>
                    <td><?= nl2br(htmlspecialchars($empleado['info_general'])) ?></td>
                    <td>
                        <?php if ($empleado['documento']): ?>
                            <a href="/centralizacion_pyme/uploads/rrhh/documentos/<?= htmlspecialchars($empleado['documento']) ?>" target="_blank">Ver Documento</a>
                        <?php endif; ?>
                    </td>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <td>
                        <a href="/centralizacion_pyme/backend/rrhh/editar.php?id=<?= $empleado['id'] ?>" class="btn-editar">Editar</a>
                        <a href="/centralizacion_pyme/backend/rrhh/eliminar.php?id=<?= $empleado['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar este registro?');">Eliminar</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p>&copy; 2025 Tecnología y Desarrollo Electromecánico. Todos los derechos reservados.</p>
</footer>
</body>
</html>
