<?php
session_start();
echo 'Usuario: ' . ($_SESSION['usuario'] ?? 'No definido') . '<br>';
echo 'Rol: ' . ($_SESSION['rol'] ?? 'No definido');
?>
