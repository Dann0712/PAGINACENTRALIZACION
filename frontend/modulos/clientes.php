<?php
session_start();
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'supervisor')) {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../../backend/db/conexion.php');
$plantas = $pdo->query("SELECT * FROM plantas_clientes ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plantas y Clientes</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_plantas_clientes.css">
</head>
<body>
<header>
    <h1>Gestión de Plantas y Clientes</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="contenedor">
    <?php if ($_SESSION['rol'] === 'admin'): ?>
    <form action="/centralizacion_pyme/backend/plantas_clientes/crear.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre de planta o cliente" required>
        <textarea name="contacto" placeholder="Información de contacto" required></textarea>
        <textarea name="notas" placeholder="Notas adicionales"></textarea>
        <button type="submit">Registrar</button>
    </form>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Notas</th>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($plantas as $planta): ?>
            <tr>
                <td><?= htmlspecialchars($planta['nombre']) ?></td>
                <td><?= nl2br(htmlspecialchars($planta['contacto'])) ?></td>
                <td><?= nl2br(htmlspecialchars($planta['notas'])) ?></td>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                <td>
                    <a href="/centralizacion_pyme/backend/plantas_clientes/editar.php?id=<?= $planta['id'] ?>" class="btn-editar">Editar</a>
                    <a href="/centralizacion_pyme/backend/plantas_clientes/eliminar.php?id=<?= $planta['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar este registro?')">Eliminar</a>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>
