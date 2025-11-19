<?php

echo "<pre>=== TEST DE CONEXIÓN A PLANETSCALE ===\n\n";

try {
    // 1. Cargar variables de entorno
    $host = getenv("DB_HOST");
    $db   = getenv("DB_NAME");
    $user = getenv("DB_USERNAME");
    $pass = getenv("DB_PASSWORD");

    echo "Variables de entorno cargadas:\n";
    echo "HOST: $host\n";
    echo "DB: $db\n";
    echo "USER: $user\n";
    echo "PASS: (oculto por seguridad)\n\n";

    // 2. Construir cadena de conexión (DSN)
    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

    echo "DSN: $dsn\n\n";

    // 3. Crear conexión PDO con SSL (obligatorio en PlanetScale)
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt'
    ];

    $conexion = new PDO($dsn, $user, $pass, $opciones);

    echo "✔ Conexión establecida correctamente.\n";

    // 4. Probar consulta básica
    $consulta = $conexion->query("SELECT 1 as resultado");
    $fila = $consulta->fetch();

    echo "Consulta de prueba exitosa. Resultado: ";
    print_r($fila);

} catch (PDOException $e) {
    echo "❌ ERROR DE PDO:\n" . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ ERROR GENERAL:\n" . $e->getMessage() . "\n";
}

echo "\n=== FIN DEL TEST ===</pre>";
