<?php 
include("back/conexion.php"); 
$link = conectarse();
session_start(); ?>
<html><head><meta><title>SaraII - Indicadores de Administración Comunitaria Rural</title></head><body>
<?php
if (isset($_SESSION["usuario"])) {
    echo 'Estas como: '.$_SESSION["usuario"];
    ?>
    &nbsp;<a href="logOut.php">Cerrar sesión</a>
    <nav><?php // if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <ul>
        <li><a href="admin/indcorelEjec.php">Ind. de Corelación de Ejecución</a></li>  
        <li><a href="admin/indInterConsMVC.php">Ind. de Intervención Consolidado</a></li>
        <li><a href="admin/indInterGnrl.php">Ind. de Intervención General</a></li>
        <li><a href="admin/infElem.php">Inf. de Elementos por JAC</a></li>
        <li><a href="admin/infActivMesPryMVC.php">Inf. de Actividades</a></li>
        </ul>
    </nav>    
    <div class="container">
        <div class="col-md-3"><?php
        if ($_SESSION["rol"] == 1) {
//         echo '<a href="usuarios.php">Gestión de Usuarios</a><br>';
//         echo '<a href="juntas.php">Gestión de JAC</a><br>';
        }
        ?>
        </div>
    </div><?php
}
else {
    echo 'La sesión está cerrada, debe volver a iniciarla<br>';
    echo '<a href="index.php">Iniciar sesión</a>';
}
?>
</body></html>