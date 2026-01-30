<?php
// Activa todos los errores para facilitar la depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = "localhost";
$dbname = "bdsaraind"; // Nombre de tu base de datos
$username = "root"; // Tu usuario de base de datos
$password = ""; // Tu contraseña (si no tienes, está vacía)
// Usando PDO para la conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
// Pagina para definir la funcion de conexion
function Conectarse()
{
    // Establecer la conexión a la base de datos
    $host = "localhost";
    $dbname = "bdsaraind"; // Nombre de tu base de datos
    $username = "root"; // Tu usuario de base de datos
    $password = ""; // Tu contraseña (si no tienes, está vacía)
    if (!($link = mysqli_connect("localhost","root",""))){
        echo "Error conectando a la base de datos.";
        exit(); 
    }
    if (!mysqli_select_db($link,$dbname)){
        echo "Error seleccionando la base de datos.";
        exit();  
    }
    return $link;  
}
$link=Conectarse();