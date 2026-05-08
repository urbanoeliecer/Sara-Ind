<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión. Será redirigido al <a href='../index.php'>login</a>.";
    header("refresh:3;url=../index.php");
    exit;
}
?>
<html lang="es">
<head><meta charset="UTF-8">
<title>SARA - Ind. de Elementos</title>
<link rel="stylesheet" href="../functions/estilos.css">
</head><body>
<a href="../principal.php">Principal</a>
<h2>Ind. de Elementos</h2><?php
require_once "../functions/filtro_func.php";
// 1. obtener filtros (CENTRALIZADO)
$f = obtenerFiltros();
$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$iddpt = $f["iddpt"];
$idmnc  = $f["idmnc"];
$pgn    = $f["pgn"];
// 2. combos para el filtro
$departamentos = obtenerDepartamentos();
$municipios    = obtenerMunicipios($iddpt);
// 3. paginación
$totalPaginas = contarPaginas('elements', $fchInc, $fchFin, $iddpt, $idmnc);

require_once "../functions/filtro.php"; 

$where = "WHERE p.startdate BETWEEN '$fchInc' AND '$fchFin'";
if ($iddpt !== null && $iddpt !== '') {
    $where .= " AND d.idspr = '$iddpt'";
}
if ($idmnc !== null && $idmnc !== '') {
    $where .= " AND m.idsst = '$idmnc'";
}
$conexion = conectarse();
// 2. CONSULTA
$sql = "
SELECT 
    d.name AS departamento,
    m.name AS municipio,
    j.name AS junta,
    e.idelement,
    e.addressname AS elemento,
    t.typeelementname AS tipo,
    COUNT(DISTINCT p.idprj) AS total,
    GROUP_CONCAT(
        DISTINCT p.name
        ORDER BY p.name
        SEPARATOR '<br>'
    ) AS proyectos,
    GROUP_CONCAT(
        DISTINCT DATE_FORMAT(p.startdate, '%Y-%m-%d')
        ORDER BY p.startdate
        SEPARATOR '<br>'
    ) AS fechas_proyectos
FROM elements e
INNER JOIN projectelements pe
    ON pe.idelement = e.idelement
INNER JOIN projects p
    ON p.idprj = pe.idprj
    AND p.startdate BETWEEN '2024-09-02' AND '9999-12-31'
INNER JOIN communities j
    ON j.idcommunity = p.idcommunity
INNER JOIN systems m
    ON m.idsst = j.idsst
INNER JOIN supersystems d
    ON d.idspr = m.idspr
INNER JOIN telementoscls c
    ON e.idelementocls = c.idelementocls
INNER JOIN telementostip t
    ON c.idtipoactivo = t.idtipoactivo
$where
GROUP BY 
    e.idelement,
    d.name,
    m.name,
    j.name,
    t.typeelementname
ORDER BY 
    d.name ASC,
    m.name ASC,
    j.name ASC,
    t.typeelementname ASC;";
//print $sql;
$result = mysqli_query($conexion, $sql);
// 3. PROCESAR RESULTADOS
$data = [];
$maxTotal = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    if ($row['total'] > $maxTotal) {
        $maxTotal = $row['total'];
    }
}

$headers = ["#", "Super", "Sistemas", "Comunidad", "IdElm.", "Elemento", "Tipo", "Total", "Gráfica", "Proyectos", "Fechas"];
$headers = ["#", "Super", "Systems", "Community", "IdElm.", "Element", "Type", "Total", "Chart", "Projects", "Dates"];
echo '<table><tr>';
foreach($headers as $h){ 
    echo '<th>'.$h.'</th>';
} 
// 4. MOSTRAR TABLA + BARRAS
$anchoMaximo = 300; // ancho máximo de la barra en px
$jntant = '';
$fila= 1;
foreach ($data as $row) {
    $porcentaje = 0;
    $anchoBarra = 0;
    if ($maxTotal > 0) {
        $porcentaje = ($row['total'] / $maxTotal) * 100;
        $anchoBarra = ($row['total'] / $maxTotal) * $anchoMaximo;
    }
    $jnt = $row['junta'];
    if ($jnt <> $jntant && $jntant <> '') {
	echo '<tr><td>';
    }
    $jntant = $jnt; 
    ?>
    <tr><td class="text-center"><?= $fila ?></td>
        <td><?= $row['departamento'] ?></td>
        <td><?= $row['municipio'] ?></td>
        <td><?= $row['junta'] ?></td>
        <td><?= $row['idelement'] ?></td>
        <td><?= $row['elemento'] ?></td>
        <td><?php echo $row['tipo']; ?></td>
        <td align="center"><?php echo $row['total']; ?></td>
        <td><img src="../img/barra.png" width="<?php echo intval($anchoBarra); ?>" height="20">
        <?php echo round($porcentaje,1); ?>%
        </td>
        <td><?= $row['proyectos'] ?></td>
        <td><?= $row['fechas_proyectos'] ?></td>
    </tr>
<?php $fila++; 
} ?>
</table>
</body>
</html>
<?php
mysqli_close($conexion); //CERRAR CONEXIÓN
?>