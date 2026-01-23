<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sara II - Ind. Actividades</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<a href="../principal.php">Principal</a></li>
<h2>Indicador de intervenciones ejecutadas</h2>
<?php
include("../back/conexion.php"); 
$conexion = conectarse();
// 1. Conexión a MySQL
if ($conexion->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// SQL BASE + JOIN NUEVO
$sql = "
SELECT
    v.departamento,
    v.municipio,
    v.junta AS vereda,
/* TOTALES REALES (DESDE tpryact) */
    COUNT(DISTINCT a.idpry) AS total_proyectos,
    SUM(a.presupuesto)           AS monto,
    SUM(a.cntpersonas)           AS participantes,
    COUNT(a.idact)               AS total_actividades,
/* OBJETIVOS DESEADOS (juntasdsc) */
    IFNULL(jd.proyectos, 0)      AS proyectos_deseados,
    IFNULL(jd.presupuesto, 0)    AS presupuesto_deseado,
    IFNULL(jd.participantes, 0) AS participantes_deseados,
/* RGI (40% - 30% - 30%) */
    (   0.4 * IF(jd.proyectos > 0, COUNT(DISTINCT a.idpry) / jd.proyectos,0)
      + 0.3 * IF(jd.presupuesto > 0, SUM(a.presupuesto) / jd.presupuesto,0)
      + 0.3 * IF(jd.participantes > 0, (SUM(a.cntpersonas)/COUNT(a.idact)) / jd.participantes,0)
    ) * 100 AS RGI

FROM pryact a
INNER JOIN vproyectosxjunta v ON v.idproyecto = a.idpry
LEFT JOIN juntasdsc jd
       ON jd.idjnt = v.idjunta WHERE 1 = 1
/* FILTROS DINÁMICOS */
GROUP BY v.departamento, v.municipio, v.junta
ORDER BY v.departamento ASC,v.municipio ASC, v.junta ASC
LIMIT 0, 20; ";
// ORDENAMIENTO POR RGI
if (isset($_GET['order'])) {
    if ($_GET['order'] === 'rgi_asc') {
        $sql .= " ORDER BY RGI ASC";
    } elseif ($_GET['order'] === 'rgi_desc') {
        $sql .= " ORDER BY RGI DESC";
    }
}
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
<!-- BOTONES ORDEN -->
<a href="?order=rgi_desc" class="btn btn-success btn-sm">RGI ↓</a>
<a href="?order=rgi_asc" class="btn btn-warning btn-sm">RGI ↑</a>
<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Depart.</th>
    <th>Municipio</th>
    <th>Vereda</th>

    <th>RGI</th>
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
    <td><strong><?= round($row['RGI']) ?>%</strong></td>
    <td><img src="<?= barra($row['RGI']) ?>" class="barra" width="<?= min(100, $row['RGI']) ?>%" style="height:16px;" ></td>
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