<?php
session_start();
require_once('../config/db.php');

if (isset($_SESSION['usuario_id'])) {
    $id = $_SESSION['usuario_id'];

    // Actualizar estado a fuera de línea
    $stmt = $pdo->prepare("UPDATE usuarios SET en_linea = 0 WHERE id = ?");
    $stmt->execute([$id]);
}

session_unset();
session_destroy();

header("Location: /centralizacion_pyme/frontend/login.html");
exit;
