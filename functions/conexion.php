<?php
// Mostrar errores (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Parámetros de conexión (UNIFICADOS)
define('DB_HOST', '127.0.0.1');   // Importante: no usar localhost
define('DB_PORT', 3306);          // Puerto real de MySQL
define('DB_NAME', 'bdsaraind');   // Base de datos
define('DB_USER', 'root');     // Usuario
define('DB_PASS', '');     // Contraseña
// * CONEXIÓN PDO (para informes nuevos)
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST .
        ";port=" . DB_PORT .
        ";dbname=" . DB_NAME .
        ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión PDO: " . $e->getMessage());
}
// CONEXIÓN MYSQLI (para informes antiguos)
function Conectarse()
{
    $link = mysqli_connect(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME,
        DB_PORT
    );
    if (!$link) {
        die("Error conectando a la base de datos (mysqli): " . mysqli_connect_error());
    }
    // Forzar UTF-8
    mysqli_set_charset($link, "utf8");
    return $link;
}
// Conexión mysqli lista para usar (opcional)
$link = Conectarse();
?>