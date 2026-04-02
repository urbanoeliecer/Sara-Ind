<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión. Será redirigido al <a href='../index.php'>login</a>.";
    header("refresh:3;url=../index.php");
    exit;
}
else {
?>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>SARA - Indicador de Co-relación de Ejecución</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<a href="../principal.php">Principal</a></li>
<h2>Ind. de Co-relación de Ejecución</h2>
<?php
// === consolidado.php ===
// modo: departamento / municipio / junta
include("../back/conexion.php"); 
$conn = conectarse();
//  Consolidado de Proyectos con Filtros, Agrupación y Paginación
//  Filtro por fechas
//  Filtro por departamento
//  Agrupa por: departamento / municipio / vereda (junta)
//  Reglas especiales por tipo de agrupación
//  Opción para agrupar por año
//  Paginador con orden dinámico según agrupación
//  Usa la vista consolidada que generamos

// 1. Parámetros de búsqueda
$fechaInicio = $_GET['fecha_inicio'] ?? '';
$fechaFin    = $_GET['fecha_fin'] ?? '';
$departamento = $_GET['departamento'] ?? '';
$agrupacion = $_GET['agrupacion'] ?? 'vereda'; // departamento / municipio / vereda
$agruparAnyo = 1; //isset($_GET['agrupar_anio']) ? intval($_GET['agrupar_anio']) : 0;
$orden = $_GET['orden'] ?? '';
// Paginación
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$porPagina = 20;
$offset = ($pagina - 1) * $porPagina;
// 2. Construcción del WHERE
$where = " WHERE 1=1 ";
if ($fechaInicio !== '' && $fechaFin !== '') {
    $where .= " AND fechaInicio BETWEEN '$fechaInicio' AND '$fechaFin' ";
}
if ($departamento !== '') {
    $where .= " AND departamento = '$departamento' ";
}
// 3. GROUP BY dinámico y seguro
$groupFields = [];
if ($agruparAnyo == 1) {
    $groupFields[] = "anio";
}
switch ($agrupacion) {
    case 'vereda':
        $groupFields[] = "departamento";
        $groupFields[] = "municipio";
        $groupFields[] = "junta";
        break;
    case 'municipio':
        $groupFields[] = "departamento";
        $groupFields[] = "municipio";
        break;
    case 'departamento':
    default:
        $groupFields[] = "departamento";
        break;
}
if (count($groupFields) == 0) {
    $groupFields[] = "departamento";
}
$groupBy = " GROUP BY " . implode(", ", $groupFields);
// 4. ORDER BY dinámico
$orderBy = " ORDER BY ";
// 1. Si agrupa por año, este orden siempre va primero
//if ($agruparAnyo == 1) 
{
    $orderBy .= "departamento, municipio, vereda, anio DESC, ";
}
// 2. Orden manual por botones
switch ($orden) {
    case 'junta':
        $orderBy .= "junta ASC";
        break;
    case 'monto':
        $orderBy .= "monto DESC";
        break;
    case 'beneficiarios':
        $orderBy .= "beneficiarios DESC";
        break;
    case 'fecha':
        $orderBy .= "fechaInicio ASC";
        break;
    default:
        // 3. Si no hay orden específico, usar orden natural según agrupación
        switch ($agrupacion) {
            case 'vereda':
                $orderBy .= "departamento ASC, municipio ASC, junta ASC";
                break;
            case 'municipio':
                $orderBy .= "departamento ASC, municipio ASC";
                break;
            case 'departamento':
            default:
                $orderBy .= "departamento ASC";
                break;
        }
}
// 5. Columnas a seleccionar según agrupación
$selectCols = [];
if ($agruparAnyo == 1) {
    $selectCols[] = "anio";
}
switch ($agrupacion) {
    case 'vereda':
        $selectCols[] = "departamento";
        $selectCols[] = "municipio";
        $selectCols[] = "junta AS vereda";
        break;
    case 'municipio':
        $selectCols[] = "departamento";
        $selectCols[] = "municipio";
        $selectCols[] = "COUNT(DISTINCT junta) AS total_juntas";
        break;
    case 'departamento':
    default:
        $selectCols[] = "departamento";
        $selectCols[] = "COUNT(DISTINCT municipio) AS total_municipios";
        $selectCols[] = "COUNT(DISTINCT junta) AS total_veredas";
        break;
}
$selectCols[] = "COUNT(DISTINCT idProyecto) AS total_proyectos";
$selectCols[] = "SUM(total_actividades) AS total_actividades";
$selectCols[] = "SUM(total_presupuesto) AS monto";
$selectCols[] = "SUM(total_beneficiarios) AS beneficiarios";
$selectSQL = implode(", ", $selectCols);
// 6. SQL final
$sql = "SELECT $selectSQL
        FROM vproyectosxjuntaxanio
        $where
        $groupBy
        $orderBy
        LIMIT $offset, $porPagina";
//print $sql;
$resultado = $conn->query($sql);
// Para paginador
$sqlTotal = "SELECT COUNT(*) AS total FROM (
                SELECT 1
                FROM vproyectosxjuntaxanio
                $where
                $groupBy
            ) AS sub";
$totalRows = $conn->query($sqlTotal)->fetch_assoc()['total'];
$totalPaginas = ceil($totalRows / $porPagina);
?>
<form method="GET">
    <div>
    Fecha inicio: <input type="date" name="fecha_inicio" value="<?= $fechaInicio ?>">
    Fecha fin: <input type="date" name="fecha_fin" value="<?= $fechaFin ?>">
    &nbsp;
    Departamento: <select name="departamento"><option>Seleccione...</option></select>
    Municipio: <select name="departamento"><option>Seleccione...</option></select>
    Junta: <select name="departamento"><option>Seleccione...</option></select>
    <br><br>
    Agrupar por:
    <select name="agrupacion">
        <option value="ninguna" <?= $agrupacion=='ninguna'?'selected':'' ?>>No agrupar</option>
        <option value="departamento" <?= $agrupacion=='departamento'?'selected':'' ?>>Departamento</option>
        <option value="municipio" <?= $agrupacion=='municipio'?'selected':'' ?>>Municipio</option>
        <option value="vereda" <?= $agrupacion=='vereda'?'selected':'' ?>>Junta / Vereda</option>
    </select>
    ¿Consolidar por año?
    <input type="radio" name="agrupar_anio" value="1" <?= $agruparAnyo==1?'checked':'' ?>> Sí
    <input type="radio" name="agrupar_anio" value="0" <?= $agruparAnyo==0?'checked':'' ?>> No
    &nbsp;
    <button type="submit">Filtrar</button>&nbsp;&nbsp;
    <strong>Ordenar:</strong>
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'junta'])) ?>">Junta</a> |
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'monto'])) ?>">Monto</a> |
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'beneficiarios'])) ?>">Beneficiarios</a> |
    <a href="?<?= http_build_query(array_merge($_GET, ['orden'=>'fecha'])) ?>">Fecha Inicio</a>
    </div>
</form>
<?php
// Obtener máximos reales para barras
$maxProy = 0;
$maxBen  = 0;
$maxact = 0;
$maxMon  = 0;
$resultado->data_seek(0);
while($r = $resultado->fetch_assoc()){
    if ($r['total_proyectos'] > $maxProy) $maxProy = $r['total_proyectos'];
    if ($r['total_actividades'] > $maxact) $maxact = $r['total_actividades'];
    if ($r['beneficiarios'] > $maxBen) $maxBen  = $r['beneficiarios'];
    if ($r['monto'] > $maxMon) $maxMon  = $r['monto'];
}
$resultado->data_seek(0);
?>
<table style="padding:0px !important; margin:0px !important; line-height:1 !important;">
    <tr><th>#</th>
        <?php if ($agruparAnyo == 1): ?>
            <th>Año</th>
        <?php endif; ?>
        <?php if ($agrupacion == 'departamento'): ?>
            <th>Departamento</th>
            <th>Total municipios</th>
            <th>Total veredas</th>
        <?php elseif ($agrupacion == 'municipio'): ?>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Total juntas</th>
        <?php else: ?>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Vereda</th>
        <?php endif; ?>
        <th>Proyectos</th><th>-</th>
        <th>Actividades</th><th>-</th>
        <th>Dinero</th><th>-</th>
        <th>Benef.</th><th>-</th>
    </tr><?php 
    $contFil = 1;
    while ($row = $resultado->fetch_assoc()): ?>
        <tr><td><?= $contFil ?></td><?php //260331
            if ($agruparAnyo == 1) {
                echo '<td>' . $row['anio'] . '</td>';
            }
            if ($contFil % 2 == 0) {
                //echo '<td colspan="5">';
            }
            else {
                if ($agrupacion == 'departamento') {
                    echo '<td>' . $row['departamento'] . '</td>';
                    echo '<td>' . $row['total_municipios'] . '</td>';
                    echo '<td>' . $row['total_veredas'] . '</td>';
                } elseif ($agrupacion == 'municipio') {
                    echo '<td>' . $row['departamento'] . '</td>';
                    echo '<td>' . $row['municipio'] . '</td>';
                    echo '<td>' . $row['total_juntas'] . '</td>';
                } else {
                    echo '<td rowspan="2">' . $row['departamento'] . '</td>';
                    echo '<td rowspan="2">' . $row['municipio'] . '</td>';
                    echo '<td rowspan="2">' . $row['vereda'] . '</td>';
                }
                $a0 = $maxProy > 0 ? intval(($row['total_proyectos'] / $maxProy) * 100) : 0;
                $img0 = '<img src="../img/barra.png" height="16" width="' . $a0 . '">';
                echo '<td  rowspan="2" align="right">' . $row['total_proyectos'] . '</td>';
                echo '<td rowspan="2">' . $img0 . '</td>';
            }
            $aa = $maxact>0? intval(($row['total_actividades']/$maxact)*100):0;
            $a1 = $maxMon>0? intval(($row['monto']/$maxMon)*100):0;    
            $a2 = $maxBen>0? intval(($row['beneficiarios']/$maxBen)*100):0;
            
            $imga = '<img src="../img/barra.png" height="16" width="'.$aa.'">'; 
            $img1 = '<img src="../img/barra.png" height="16" width="'.$a1.'">';
            $img2 = '<img src="../img/barra.png" height="16" width="'.$a2.'">';
            ?>
            <td align="right"><?= $row['total_actividades'] ?></td>
	    <td><?= $imga; ?></td>
            <td align="right"><?= number_format($row['monto']) ?></td>
            <td><?= $img1; ?></td>
            <td align="right"><?= $row['beneficiarios'] ?></td>
            <td><?= $img2; ?></td>
        </tr>
    <?php $contFil++; 
    endwhile; ?>
</table>
<br>
<div>
    <?php for ($i=1; $i <= $totalPaginas; $i++): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['pagina'=>$i])) ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
</body>
</html><?php
mysqli_close($conn); //CERRAR CONEXIÓN
}
?>

