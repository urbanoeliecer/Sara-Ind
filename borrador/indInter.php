<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión. Será redirigido al <a href='../index.php'>login</a>.";
    header("refresh:3;url=../index.php");
    exit;
}
else {
?>
<?php
$rol = $_GET['rol'] ?? 0;
?>
<html lang="es">
<head>
<meta charset="utf-8">
<title>SARA - Ind. de Intervenciones Consoliado</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<a href="../principal.php">Principal</a><br>
<h2>Ind. de Intervenciones planteadas</h2>
<!-- Resumen y Detalles de los Proyectos -->
<div id="resumen"></div>
<div id="detalle"></div>
</body>
</html><?php
}
?>