<html lang="es">
<head>
<meta charset="UTF-8">
<title>SARA - Ind. de Intervención General</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<a href="../principal.php">Principal</a></li>
<h2>Ind. General de Intervención</h2>
<?php
include("../back/conexion.php");$conexion = conectarse();
// 1. Conexión a MySQL
if ($conexion->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// SQL BASE + JOIN NUEVO
$w_proyectos = 0.4;
$w_presupues = 0.3;
$w_participa = 0.3;
$sql = " SELECT
    v.departamento, v.municipio,v.junta AS vereda,
    /* TOTALES REALES */
    COUNT(distinct a.idpry) AS total_proyectos,    SUM(a.presupuesto) AS monto,
    SUM(a.cntpersonas)      AS participantes,      COUNT(a.idact)     AS total_actividades,
    /* OBJETIVOS DESEADOS */
    IFNULL(jd.proyectos,0)  AS proyectos_deseados, IFNULL(jd.presupuesto, 0) AS presupuesto_deseado,
    IFNULL(jd.participantes, 0) AS participantes_deseados,
    /* GII PARAMETRIZADO */
    (   {$w_proyectos} * IF(jd.proyectos > 0, COUNT(DISTINCT a.idpry) /jd.proyectos,0)
      + {$w_presupues} * IF(jd.presupuesto > 0, SUM(a.presupuesto) /jd.presupuesto,0)
      + {$w_participa} * IF(jd.participantes>0 AND COUNT(a.idact)>0,(SUM(a.cntpersonas)/NULLIF(COUNT(a.idact),0))/jd.participantes,0)
    ) * 100 AS GII
FROM pryact a
INNER JOIN vproyectosxjunta v ON v.idproyecto = a.idpry
LEFT JOIN juntasdsc jd ON jd.idjnt = v.idjunta
GROUP BY v.departamento, v.municipio, v.junta
ORDER BY v.departamento ASC, v.municipio ASC, v.junta ASC
LIMIT 0, 20; ";
//print $sql;
// ORDENAMIENTO POR GII
if (isset($_GET['order'])) {
    if ($_GET['order'] === 'gii_asc') {
        $sql .= " ORDER BY GII ASC";
    } elseif ($_GET['order'] === 'gii_desc') {
        $sql .= " ORDER BY GII DESC";
    }
}
// print $sql;
$result = mysqli_query($conexion, $sql);
// FUNCIONES
function porcentaje($real, $deseado) {
    if ($deseado <= 0) return 0;
    return ($real / $deseado) * 100;
}
function barra($porcentaje) {
    if ($porcentaje < 60) return '../img/barraroja.png';
    if ($porcentaje < 75) return '../img/barranaranja.png';
    return '../img/barraverde.png';
}
?>
<!-- BOTONES ORDEN 
<a href="?order=gii_desc" class="btn btn-success btn-sm">GII ↓</a>
<a href="?order=gii_asc" class="btn btn-warning btn-sm">GII ↑</a>
-->
<form method="GET">
    <div>
    Fecha inicio: <input type="date" name="fecha_inicio">
    Fecha fin: <input type="date" name="fecha_fin">
    &nbsp;
    Departamento: <select name="departamento"><option>Seleccione...</option></select>
    Municipio: <select name="departamento"><option>Seleccione...</option></select>
    Junta: <select name="departamento"><option>Seleccione...</option></select>
    <br><br>
    Agrupar por:
    <select name="agrupacion">
        <option value="ninguna">No agrupar</option>
        <option value="departamento">Departamento</option>
        <option value="municipio">Municipio</option>
        <option value="vereda">Junta / Vereda</option>
    </select>
    ¿Consolidar por año?
    <input type="radio" name="agrupar_anio" value="1"> Sí
    <input type="radio" name="agrupar_anio" value="0"> No
    &nbsp;
    <button type="submit">Filtrar</button>&nbsp;&nbsp;
    <strong>Ordenar:</strong>
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'junta'])) ?>">Junta</a> |
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'monto'])) ?>">Monto</a> |
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'beneficiarios'])) ?>">Beneficiarios</a> |
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'fecha'])) ?>">Fecha Inicio</a>
    </div>
</form>
<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Depart.</th>
    <th>Municipio</th>
    <th>Vereda</th>

    <th>GII</th>
    <th>Gráfica</th>
    
    <th>Activ.</th>
    <th>Proy.</th>
    <th>Meta</th>
    <th>%</th>
    <th>Gráfica</th>

    <th>Presup.</th>
    <th>Deseado</th>
    <th>%</th>
    <th>Gráfica</th>

    <th>Prom. Benef.</th>
    <th>Meta</th>
    <th>%</th>
    <th>Gráfica</th>
</tr>
</thead>
<tbody>
<?php
$fila = 1;
while ($row = mysqli_fetch_assoc($result)):
    $pProy = porcentaje($row['total_proyectos'], $row['proyectos_deseados']);
    $pPres = porcentaje($row['monto'], $row['presupuesto_deseado']);
    $pPart = number_format($row['participantes']/$row['total_actividades'],1);
    $pBene = porcentaje($pPart, $row['participantes_deseados']);
?>
<tr>
    <td><?= $fila ?></td>
    <td><?= $row['departamento'] ?></td>
    <td><?= $row['municipio'] ?></td>
    <td><?= $row['vereda'] ?></td>
    <td><strong><?= round($row['GII']) ?>%</strong></td>
    <td><img src="<?= barra($row['GII']) ?>" class="barra" width="<?= min(100, $row['GII']) ?>%" style="height:16px;" ></td>
    <td><strong><?= $row['total_actividades'] ?></strong></td>
    <td><?= $row['total_proyectos'] ?></td>
    <td><?= $row['proyectos_deseados'] ?></td>
    <td><?= round($pProy) ?>%</td>
    <td><img src="<?= barra($pProy) ?>" width="<?= min(100, round($pProy)) ?>%" style="height:16px;"></td>

    <td><?= number_format($row['monto'],0) ?></td>
    <td><?= number_format($row['presupuesto_deseado'],0) ?></td>
    <td><?= round($pPres) ?>%</td>
    <td>
        <img src="<?= barra($pPres) ?>" width="<?= min(100, round($pPres)) ?>%" style="height:16px;">
    </td>

    <td><?= $pPart ?></td>
    <td><?= $row['participantes_deseados'] ?></td>
    <td><?= round($pBene) ?>%</td>
    <td><img src="<?= barra($pBene) ?>" width="<?= min(100, round($pBene)) ?>%" style="height:16px;">
    </td>
</tr>
<?php
$fila++;
endwhile;
?>
</tbody>
</table>