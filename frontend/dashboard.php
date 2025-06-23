<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header('Location: /centralizacion_pyme/frontend/login.html');
    exit;
}

require_once(__DIR__ . '/../backend/db/conexion.php'); // ✅ Aseguramos la conexión antes de usar $conn
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="/centralizacion_pyme/frontend/assets/css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Panel de Control - T.D.E</h1>
        </div>
        <div class="logout">
            <form action="/centralizacion_pyme/backend/auth/logout.php" method="post">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <main class="dashboard-main">
        <section class="welcome">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> (<?php echo htmlspecialchars($_SESSION['rol']); ?>)</h2>
            <div class="user-info">
                <img src="/centralizacion_pyme/uploads/fotos/<?php echo $_SESSION['usuario']; ?>.jpg" alt="Foto de usuario" class="user-photo" width="150">
                <p class="mensaje">Acceso concedido al sistema. Por favor, selecciona un módulo para continuar.</p>
            </div>
        </section>

        <nav class="dashboard-nav">
            <ul>
                <?php
                switch ($_SESSION['rol']) {
                    case 'admin':
                        echo <<<HTML
                            <li><a href="modulos/usuarios.php">Gestión de Usuarios y Roles</a></li>
                            <li><a href="modulos/recursos_humanos.php">Recursos Humanos</a></li>
                            <li><a href="modulos/inventario.php">Inventario</a></li>
                            <li><a href="modulos/transportes.php">Transportes</a></li>
                            <li><a href="modulos/herramientas.php">Herramientas y Equipos</a></li>
                            <li><a href="modulos/compras.php">Compras y Proveedores</a></li>
                            <li><a href="modulos/proyectos.php">Proyectos</a></li>
                            <li><a href="modulos/clientes.php">Plantas (Clientes)</a></li>
                            <li><a href="modulos/reportes_analisis.php">Reportes y Análisis</a></li>
                            <li><a href="modulos/anuncios.php">Gestión de Anuncios</a></li>
                        HTML;
                        break;

                    case 'supervisor':
                        echo <<<HTML
                            <li><a href="modulos/recursos_humanos.php">Recursos Humanos</a></li>
                            <li><a href="modulos/inventario.php">Inventario</a></li>
                            <li><a href="modulos/transportes.php">Transportes</a></li>
                            <li><a href="modulos/herramientas.php">Herramientas y Equipos</a></li>
                            <li><a href="modulos/proyectos.php">Proyectos</a></li>
                            <li><a href="modulos/clientes.php">Plantas (Clientes)</a></li>
                            <li><a href="modulos/reportes_analisis.php">Reportes y Análisis</a></li>
                        HTML;
                        break;

                    case 'empleado':
                        echo <<<HTML
                            <li><a href="modulos/inventario.php">Inventario</a></li>
                            <li><a href="modulos/transportes.php">Transportes</a></li>
                            <li><a href="modulos/herramientas.php">Herramientas y Equipos</a></li>
                            <li><a href="modulos/proyectos.php">Proyectos</a></li>
                        HTML;
                        break;
                }
                ?>
            </ul>
        </nav>

        <section class="anuncios">
            <h3>📰 Noticias y Comunicados</h3>
            <div class="anuncios-lista">
                <?php
                $consulta = "SELECT titulo, mensaje, fecha_publicacion FROM anuncios ORDER BY fecha_publicacion DESC LIMIT 5";
                $result = $conn->query($consulta);
                while ($fila = $result->fetch_assoc()):
                ?>
                    <article class="anuncio">
                        <h4><?php echo htmlspecialchars($fila['titulo']); ?></h4>
                        <small><i>Publicado: <?php echo $fila['fecha_publicacion']; ?></i></small>
                        <p><?php echo nl2br(htmlspecialchars($fila['mensaje'])); ?></p>
                    </article>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Tecnología y Desarrollo Electromecánico. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
