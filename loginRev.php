<?php
include("back/conexion.php"); 
$sesion = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = conectarse();
    $user = $_POST['txtusr'];
    $pass = hash("sha256",$_POST['txtpass']);
    $ssql = "select idusuario,idperfil from usuarios where usuario='$user' and pass='$pass'";
    $array = mysqli_query($link,$ssql);
    while ($f = mysqli_fetch_array($array)) {
        session_start();
        $sesion = 1;
        $_SESSION["usuario"] = $f[0];
        $_SESSION["rol"] = $f[1];
        header('Location: principal.php');
    }
}    
if ($sesion == 0) {   
    header('Location: index.php');
}