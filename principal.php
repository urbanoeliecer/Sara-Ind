<?php 
include("back/conexion.php"); 
$link = conectarse();
session_start(); ?>
<html><head><meta><title>SaraII - Indicadores de Administración Comunitaria Rural</title></head><body>
<table width="100%" cellpadding="15">
<tr>
<td width="35%" valign="top">
<h2>SARA II - Observaciones</h2>
<br>
Este Demo es presentado datos de diciembre de 2025 y enero de 2026.<br><br>
Se debe tener en cuenta que este módulo ya se integró a SARA en su framework Laravel, pero aquí se presentan de manera concreta en PHP y JavaScript básico para facilitar la comprensión, y se agregaron páginas de login, de validación de credenciales y de menú principal, además, solo dos de los informes fueron realizados con estructura MVC. 
<br><br>
La arquitectura de SARA es:<img src="docs/img/sara.jpg">
</td>
<td width="65%" valign="top">
<h2>Menú</h2>
<?php
if (isset($_SESSION["usuario"])) {
    echo 'Estas como: '.$_SESSION["usuario"];
    ?>
    &nbsp;<a href="logOut.php">Cerrar sesión</a>
    <nav><?php // if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <ul>
        <li><a href="admin/indCorelEjec.php">Ind. de Corelación de Ejecución</a></li>  
        <li><a href="admin/indInterGnrl.php">Ind. de Intervención General</a></li>
        <li><a href="admin/infPryMVC.php">Inf. de Proyectos por JAC</a></li>
        <li><a href="admin/infActivMesPryMVC.php">Inf. Mensual de Activ. por JAC </a></li>
        <li><a href="admin/infElem.php">Inf. de Infraestructura por JAC</a></li>        
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
</td>
</tr>
</table>
</body></html>