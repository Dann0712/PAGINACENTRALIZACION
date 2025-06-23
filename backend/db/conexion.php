<?php
$host = 'localhost';
$db = 'centralizacion_pyme';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Conexión PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Conexión PDO fallida: ' . $e->getMessage());
}

// Conexión MySQLi (para compatibilidad)
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Conexión MySQLi fallida: ' . $conn->connect_error);
}
?>