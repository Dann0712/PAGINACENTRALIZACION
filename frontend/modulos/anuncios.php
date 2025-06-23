<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header("Location: /centralizacion_pyme/frontend/dashboard.php");
    exit;
}
require_once(__DIR__ . '/../../backend/db/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Anuncios</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_anuncios.css">
</head>
<body>
    <header>
        <h1>Gestión de Anuncios</h1>
        <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
    </header>

    <main class="login-container">
        <form action="/centralizacion_pyme/backend/anuncios/crear.php" method="POST">
            <label>Título del anuncio</label>
            <input type="text" name="titulo" required>
            <label>Mensaje</label>
            <textarea name="mensaje" rows="6" required></textarea>
            <button type="submit">Publicar anuncio</button>
        </form>

        <div class="anuncios-tabla">
            <h2>Anuncios existentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = $pdo->query("SELECT * FROM anuncios ORDER BY fecha_publicacion DESC");
                    while ($fila = $res->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($fila['mensaje'])); ?></td>
                        <td><?php echo $fila['fecha_publicacion']; ?></td>
                        <td class="acciones">
                            <form action="/centralizacion_pyme/backend/anuncios/editar.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                                <button class="editar">Editar</button>
                            </form>
                            <form action="/centralizacion_pyme/backend/anuncios/eliminar.php" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este anuncio?');" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                                <button class="borrar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
