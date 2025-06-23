<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: /centralizacion_pyme/frontend/login.html");
    exit();
}
?>
