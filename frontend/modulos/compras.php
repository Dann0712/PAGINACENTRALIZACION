<?php
session_start();
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'supervisor')) {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}

require_once(__DIR__ . '/../../backend/db/conexion.php');
$stmt = $pdo->query("SELECT * FROM compras_proveedores ORDER BY fecha_compra DESC");
$compras = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Compras y Proveedores</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_compras.css">
</head>
<body>
<header>
    <h1>Compras y Proveedores</h1>
    <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
</header>

<main class="contenedor">
    <h2>Listado de Compras</h2>
    
    <?php if ($_SESSION['rol'] === 'admin'): ?>
    <form action="/centralizacion_pyme/backend/compras/crear.php" method="POST">
        <input type="text" name="proveedor_nombre" placeholder="Nombre del proveedor" required>
        <textarea name="contacto" placeholder="Datos de contacto" required></textarea>
        <input type="date" name="fecha_compra" required>
        <input type="number" step="0.01" name="monto" placeholder="Monto" required>
        <button type="submit">Registrar Compra</button>
    </form>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Contacto</th>
                <th>Fecha</th>
                <th>Monto</th>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compras as $compra): ?>
            <tr>
                <td><?= htmlspecialchars($compra['proveedor_nombre']) ?></td>
                <td><?= nl2br(htmlspecialchars($compra['contacto'])) ?></td>
                <td><?= $compra['fecha_compra'] ?></td>
                <td>$<?= number_format($compra['monto'], 2) ?></td>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                <td>
                    <a href="/centralizacion_pyme/backend/compras/editar.php?id=<?= $compra['id'] ?>" class="btn-editar">Editar</a>
                    <a href="/centralizacion_pyme/backend/compras/eliminar.php?id=<?= $compra['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar esta compra?')">Eliminar</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<footer class="footer">
    <p>&copy; 2025 Tecnología y Desarrollo Electromecánico. Todos los derechos reservados.</p>
</footer>
</body>
</html>
