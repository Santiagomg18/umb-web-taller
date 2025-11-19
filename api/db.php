<?php

// 1. Cargar variables desde el archivo .env
$envPath = __DIR__ . '/.env';

if (file_exists($envPath)) {
    $vars = parse_ini_file($envPath);
} else {
    die("ERROR: No existe el archivo .env en /api");
}

$host = $vars['DB_HOST'];
$db_name = $vars['DB_NAME'];
$username = $vars['DB_USERNAME'];
$password = $vars['DB_PASSWORD'];

try {

    // 2. Conexión PDO sin SSL (para Codespaces)
    $dsn = "mysql:host={$host};dbname={$db_name};charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Arrays asociativos
        PDO::ATTR_EMULATE_PREPARES => false                 // Prepared reales
        // ❌ QUITAMOS SSL porque PHP de Codespaces NO lo soporta
    ];

    $conn = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    die("ERROR de conexión: " . $e->getMessage());
}

?>
