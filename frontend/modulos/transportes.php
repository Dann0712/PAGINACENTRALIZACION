<?php
session_start();
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin', 'supervisor', 'empleado'])) {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}
require_once(__DIR__ . '/../../backend/db/conexion.php');

$stmt = $pdo->query("SELECT * FROM transportes ORDER BY id DESC");
$transportes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Transportes</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_transportes.css">
</head>
<body>
<header>
    <h1>Gestión de Transportes</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>
<main class="contenedor">
    <?php if ($_SESSION['rol'] === 'admin'): ?>
    <form action="/centralizacion_pyme/backend/transportes/crear.php" method="POST" enctype="multipart/form-data">
        <textarea name="descripcion" placeholder="Descripción del vehículo" required></textarea>
        <textarea name="servicios" placeholder="Servicios realizados" required></textarea>
        <textarea name="mantenimiento" placeholder="Historial de mantenimiento" required></textarea>
        <label>Fotografía:</label>
        <input type="file" name="fotografia">
        <button type="submit">Registrar Transporte</button>
    </form>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Descripción</th>
                <th>Servicios</th>
                <th>Mantenimiento</th>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transportes as $item): ?>
                <tr>
                    <td>
                        <?php if ($item['fotografia']): ?>
                            <img src="/centralizacion_pyme/uploads/transportes/<?= $item['fotografia'] ?>" width="60">
                        <?php endif; ?>
                    </td>
                    <td><?= nl2br(htmlspecialchars($item['descripcion'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($item['servicios'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($item['mantenimiento'])) ?></td>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <td>
                        <a href="/centralizacion_pyme/backend/transportes/editar.php?id=<?= $item['id'] ?>" class="btn-editar">Editar</a>
                        <a href="/centralizacion_pyme/backend/transportes/eliminar.php?id=<?= $item['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Deseas eliminar este transporte?');">Eliminar</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>