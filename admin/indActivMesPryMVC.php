<html lang="es"><head><meta charset="UTF-8">
<title>SARA - Ind. mensual de actividades</title>
<link rel="stylesheet" href="../back/estilos.css">
</head><body>
<a href="../principal.php">Principal</a></li>
<h2>Ind. Mensual de Actividades por Proyecto</h2>
<form method="post">
    Fecha inicio:<input type="date" name="fecha_inicio">
    Fecha fin:<input type="date" name="fecha_fin">
    &nbsp;
    Departamento: 
    <select name="iddepartamento">
        <option value="">Seleccione...</option>
    </select>
    Municipio: <select name="departamento"><option>Seleccione...</option></select>
    Junta: <select name="departamento"><option>Seleccione...</option></select>
    <button type="submit">Consultar</button>
</form><br>
<?php
require_once "../back/conexion.php";
require_once "../back/ModActiv.php";
$model = new ActividadModel($pdo);
//2. RECIBIR FILTROS
$fechaInicio = $_POST['fecha_inicio'] ?? '0000-00-00';
$fechaFin    = $_POST['fecha_fin'] ?? '9999-12-31';
$idDepartamento = $_POST['iddepartamento'] ?? null;
//3. CONSULTA 
$datos = $model->obtenerInforme($fechaInicio, $fechaFin, $idDepartamento);
//4. PASAR A LA VISTA 
require_once "../back/vstActiv.php"; ?>
</body>
</html>