
<?php
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: /centralizacion_pyme/frontend/empleados_login.html");
    exit;
}
require_once(__DIR__ . '/../../backend/db/conexion.php');
$rol = $_SESSION['rol'];
$soloLectura = $rol === 'empleado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Herramientas y Equipos</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_moderno.css">
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles_herramientas.css">
</head>
<body>
    <header>
        <h1>Herramientas y Equipos</h1>
        <a href="/centralizacion_pyme/frontend/dashboard.php">← Volver al panel</a>
    </header>

    <main class="contenedor">
        <?php if (!$soloLectura): ?>
        <section class="formulario">
            <form action="/centralizacion_pyme/backend/herramientas/crear.php" method="POST" enctype="multipart/form-data">
                <label>Nombre de la herramienta</label>
                <input type="text" name="nombre" required>

                <label>Descripción</label>
                <textarea name="descripcion" rows="3"></textarea>

                <label>Fecha de adquisición</label>
                <input type="date" name="fecha_adquisicion" required>

                <label>Estado</label>
                <select name="estado" required>
                    <option value="Operativa">Operativa</option>
                    <option value="En reparación">En reparación</option>
                    <option value="Fuera de servicio">Fuera de servicio</option>
                </select>

                <label>Fotografía</label>
                <input type="file" name="foto" accept="image/*">

                <button type="submit">Guardar herramienta</button>
            </form>
        </section>
        <?php endif; ?>

        <section class="tabla-herramientas">
            <h2>Listado de herramientas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <?php if (!$soloLectura): ?>
                        <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM herramientas_equipos ORDER BY fecha_adquisicion DESC");
                    while ($row = $res->fetch_assoc()):
                    ?>
                    <tr>
                        <td><img src="/centralizacion_pyme/uploads/herramientas/<?php echo htmlspecialchars($row['fotografia']); ?>" width="60" height="60"></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo $row['fecha_adquisicion']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                        <?php if (!$soloLectura): ?>
                        <td class="acciones">
                            <form action="/centralizacion_pyme/backend/herramientas/editar.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="editar">Editar</button>
                            </form>
                            <form action="/centralizacion_pyme/backend/herramientas/eliminar.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Deseas eliminar esta herramienta?');">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="borrar">Eliminar</button>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
