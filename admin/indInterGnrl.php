<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión. Será redirigido al <a href='../index.php'>login</a>.";
    header("refresh:3;url=../index.php");
    exit;
}
?>
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
include("../back/conexion.php");

require_once "../back/filtro_func.php";

// 1. obtener filtros (CENTRALIZADO)
$f = obtenerFiltros();
$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$Iddpto = $f["Iddpto"];
$Idmnc  = $f["Idmnc"];
$pgn    = $f["pgn"];
// 2. combos para el filtro
$departamentos = obtenerDepartamentos();
$municipios    = obtenerMunicipios($Iddpto);
// 3. paginación
$totalPaginas = contarPaginas('gii',$fchInc, $fchFin, $Iddpto, $Idmnc);

require_once "../back/filtro.php"; 

$porPagina = 30;
$offset = ($pgn - 1) * $porPagina;
    
$where = "WHERE v.startdate BETWEEN '$fchInc' AND '$fchFin'";
if ($Iddpto !== null && $Iddpto !== '') {
    $where .= " AND v.iddepartamento = '$Iddpto'";
}
if ($Idmnc !== null && $Idmnc !== '') {
    $where .= " AND v.idmunicipio = '$Idmnc'";
}
    
$conexion = conectarse();
// 1. Conexión a MySQL
if ($conexion->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// SQL BASE + JOIN NUEVO
// 260429 ponerle el filtro
// 260429 me arreglarias este para agregarle el año en la columna 4 y que lo agrupe por año ya que las metas son anuales
$w_proyectos = 0.4;
$w_presupues = 0.3;
$w_participa = 0.3;
$sql = "
SELECT
    v.supersystem AS departamento,
    v.system AS municipio,
    v.community AS vereda,
    YEAR(a.date) AS anio,
    GROUP_CONCAT(
        DISTINCT CONCAT(p.name, ' (', DATE_FORMAT(p.startdate, '%Y-%m-%d'), ')')
        ORDER BY p.startdate ASC
        SEPARATOR '<br>'
    ) AS proyectos_fechas,
    COUNT(DISTINCT a.idprj) AS total_proyectos,
    SUM(a.budget) AS monto,
    SUM(a.participants) AS participantes,
    COUNT(a.idact) AS total_actividades,
    IFNULL(cd.projects,0) AS proyectos_deseados,
    IFNULL(cd.budget,0) AS presupuesto_deseado,
    IFNULL(cd.participants,0) AS participantes_deseados,
    (
        " . $w_proyectos . " * IF(cd.projects > 0,
            COUNT(DISTINCT a.idprj) / cd.projects, 0)
      + " . $w_presupues . " * IF(cd.budget > 0,
            SUM(a.budget) / cd.budget, 0)
      + " . $w_participa . " * IF(cd.participants > 0
            AND COUNT(a.idact) > 0,
            (SUM(a.participants) / NULLIF(COUNT(a.idact),0)) / cd.participants,
            0)
    ) * 100 AS GII
FROM prjact a
INNER JOIN vprojectsxcommunityxyear v
    ON v.idprj = a.idprj
INNER JOIN projects p
    ON p.idprj = v.idprj
LEFT JOIN communitiesdesc cd
    ON cd.idcommunity = v.idcommunity
$where
GROUP BY
    v.supersystem,
    v.system,
    v.community,
    YEAR(a.date)
UNION ALL
SELECT
    v.supersystem AS departamento,
    v.system AS municipio,
    v.community AS vereda,
    'TOTAL' AS anio,
    GROUP_CONCAT(
        DISTINCT CONCAT(p.name, ' (', DATE_FORMAT(p.startdate, '%Y-%m-%d'), ')')
        ORDER BY p.startdate ASC
        SEPARATOR '<br>'
    ) AS proyectos_fechas,
    COUNT(DISTINCT a.idprj),
    SUM(a.budget),
    SUM(a.participants),
    COUNT(a.idact),
    IFNULL(cd.projects,0),
    IFNULL(cd.budget,0),
    IFNULL(cd.participants,0),
    (
        " . $w_proyectos . " * IF(cd.projects > 0,
            COUNT(DISTINCT a.idprj) / cd.projects, 0)

      + " . $w_presupues . " * IF(cd.budget > 0,
            SUM(a.budget) / cd.budget, 0)

      + " . $w_participa . " * IF(cd.participants > 0
            AND COUNT(a.idact) > 0,
            (SUM(a.participants) / NULLIF(COUNT(a.idact),0)) / cd.participants,
            0)
    ) * 100
FROM prjact a
INNER JOIN vprojectsxcommunityxyear v
    ON v.idprj = a.idprj
INNER JOIN projects p
    ON p.idprj = v.idprj
LEFT JOIN communitiesdesc cd
    ON cd.idcommunity = v.idcommunity
$where
GROUP BY
    v.supersystem,
    v.system,
    v.community
ORDER BY
    departamento,
    municipio,
    vereda,
    anio
LIMIT $offset, $porPagina";
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
//$headers = ["#", "Super.", "Sistema", "Comunidad", "Año", "GII", "Gráfica", "# Activ.", "Prys & Fechas", "# Proy.", "Meta", "%", "Gráfica", "Presup.", "Deseado", "%", "Gráfica", "Prom. Benef.", "Meta", "%", "Gráfica"];
$headers = ["#", "Super.", "System", "Community", "Year", "GII", "Chart", "# Activ.", "Prjs & Dates", "# Prj.", "Goal", "%", "Chart", "Budget", "Desired", "%", "Chart", "Avg. Benef.", "Goal", "%", "Chart"];
echo '<table class="table table-bordered table-striped"><thead><tr>';
foreach($headers as $h){ 
    echo '<th>'.$h.'</th>';
} 
$fila = 1;
while ($row = mysqli_fetch_assoc($result)):
    $pProy = porcentaje($row['total_proyectos'], $row['proyectos_deseados']);
    $pPres = porcentaje($row['monto'], $row['presupuesto_deseado']);
    $pPart = number_format($row['participantes']/$row['total_actividades'],1);
    $pBene = porcentaje($pPart, $row['participantes_deseados']);
?>
<tr <?php if ($row['anio'] == 'TOTAL') echo 'style="background-color:#d9edf7; font-weight:bold;"'; ?>>
    <td><?= $fila ?></td>
    <td><?= $row['departamento'] ?></td>
    <td><?= $row['municipio'] ?></td>
    <td><?= $row['vereda'] ?></td>
    <td><?= $row['anio'] ?></td>
    <td><strong><?= round($row['GII']) ?>%</strong></td>
    <td><img src="<?= barra($row['GII']) ?>" class="barra" width="<?= min(100, $row['GII']) ?>%" style="height:16px;" ></td>
    <td><?= $row['total_actividades'] ?></td>
    
    <td><?= $row['proyectos_fechas'] ?></td>

    <td><?= $row['total_proyectos'] ?></td>
    <td><?= $row['proyectos_deseados'] ?></td>
    <td><?= round($pProy) ?>%</td>
    <td><img src="<?= barra($pProy) ?>" width="<?= min(100, round($pProy)) ?>%" style="height:16px;"></td>
    <td><?= number_format($row['monto'],0) ?></td>
    <td><?= number_format($row['presupuesto_deseado'],0) ?></td>
    <td><?= round($pPres) ?>%</td>
    <td><img src="<?= barra($pPres) ?>" width="<?= min(100, round($pPres)) ?>%" style="height:16px;"></td>
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
</table><?php
mysqli_close($conexion); //CERRAR CONEXIÓN
?>