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
//  Opción para agrupar por año (YEAR(fechaInicio))
//  Paginador con orden dinámico según agrupación
//  Usa la vista consolidada que generamos

// 1. Parámetros de búsqueda
$fechaInicio = $_GET['fecha_inicio'] ?? '';
$fechaFin    = $_GET['fecha_fin'] ?? '';
$departamento = $_GET['departamento'] ?? '';
$agrupacion = $_GET['agrupacion'] ?? 'vereda'; // departamento / municipio / vereda
$agruparAnyo = isset($_GET['agrupar_anio']) ? intval($_GET['agrupar_anio']) : 0;
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
    $groupFields[] = "YEAR(fechaInicio)";
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
if ($agruparAnyo == 1) {
    $orderBy .= "YEAR(fechaInicio) ASC, ";
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
    $selectCols[] = "YEAR(fechaInicio) AS anio";
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
$selectCols[] = "SUM(monto) AS monto";
$selectCols[] = "SUM(Beneficiarios) AS beneficiarios";
$selectSQL = implode(", ", $selectCols);
// 6. SQL final
$sql = "SELECT $selectSQL
        FROM vproyectosxjunta
        $where
        $groupBy
        $orderBy
        LIMIT $offset, $porPagina";
//print $sql;
$resultado = $conn->query($sql);
// Para paginador
$sqlTotal = "SELECT COUNT(*) AS total FROM (
                SELECT 1
                FROM vproyectosxjunta
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
$maxMon  = 0;
$resultado->data_seek(0);
while($r = $resultado->fetch_assoc()){
    if ($r['total_proyectos'] > $maxProy) $maxProy = $r['total_proyectos'];
    if ($r['beneficiarios'] > $maxBen) $maxBen  = $r['beneficiarios'];
    if ($r['monto'] > $maxMon) $maxMon  = $r['monto'];
}
$resultado->data_seek(0);
?>
<table>
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
        <th>Dinero</th><th>-</th>
        <th>Benef.</th><th>-</th>
    </tr><?php 
    $contFil = 1;
    while ($row = $resultado->fetch_assoc()): ?>
        <tr> <td><?= $contFil ?></td>
            <?php if ($agruparAnyo == 1): ?>
                <td><?= $row['anio'] ?></td>
            <?php endif; ?>

            <?php if ($agrupacion == 'departamento'): ?>
                <td><?= $row['departamento'] ?></td>
                <td><?= $row['total_municipios'] ?></td>
                <td><?= $row['total_veredas'] ?></td>

            <?php elseif ($agrupacion == 'municipio'): ?>
                <td><?= $row['departamento'] ?></td>
                <td><?= $row['municipio'] ?></td>
                <td><?= $row['total_juntas'] ?></td>

            <?php else: ?>
                <td><?= $row['departamento'] ?></td>
                <td><?= $row['municipio'] ?></td>
                <td><?= $row['vereda'] ?></td>
            <?php endif;
            $a0 = $maxProy>0? intval(($row['total_proyectos']/$maxProy)*100):0;	
            $a1 = $maxMon>0? intval(($row['monto']/$maxMon)*100):0;    
            $a2 = $maxBen>0? intval(($row['beneficiarios']/$maxBen)*100):0;
            $img0 = '<img src="../img/barra.png" height="20" width="'.$a0.'">'; 
            $img1 = '<img src="../img/barra.png" height="20" width="'.$a1.'">';
            $img2 = '<img src="../img/barra.png" height="20" width="'.$a2.'">';
	    ?>
            <td><?= $row['total_proyectos'] ?></td>
	    <td><?= $img0; ?></td>
            <td><?= number_format($row['monto']) ?></td>
            <td><?= $img1; ?></td>
            <td><?= $row['beneficiarios'] ?></td>
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
</html>

