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
<link rel="stylesheet" href="../back/estilos.css">
</head><body>
<a href="../principal.php">Principal</a>
<h2>Ind. de Elementos</h2>
<?php
// 1. CONEXIÓN A LA BD
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
$totalPaginas = contarPaginas('elementos', $fchInc, $fchFin, $Iddpto, $Idmnc);

require_once "../back/filtro.php"; 

$where = "WHERE p.fechaInicio BETWEEN '$fchInc' AND '$fchFin'";
if ($Iddpto !== null && $Iddpto !== '') {
    $where .= " AND d.iddepartamento = '$Iddpto'";
}
if ($Idmnc !== null && $Idmnc !== '') {
    $where .= " AND m.idmunicipio = '$Idmnc'";
}

$conexion = conectarse();
// 2. CONSULTA
$sql = "
SELECT 
    d.nombre AS departamento,
    m.nombre AS municipio,
    j.nombre AS junta,
    e.idelemento,
    e.adressname as elemento,
    t.tipElmNombre AS tipo,
    COUNT(DISTINCT p.idproyecto) AS total,
    GROUP_CONCAT(DISTINCT p.nombre ORDER BY p.nombre SEPARATOR '<br>') AS proyectos,
    GROUP_CONCAT(DISTINCT DATE_FORMAT(p.fechainicio, '%Y-%m-%d') 
                 ORDER BY p.fechainicio SEPARATOR '<br>') AS fechas_proyectos
FROM elementos e
INNER JOIN tproyectoselementos pe 
    ON pe.idelemento = e.idelemento
INNER JOIN proyectos p 
    ON p.idproyecto = pe.idproyecto
    AND p.fechaInicio BETWEEN '2024-09-02' AND '9999-12-31'
INNER JOIN juntas j ON j.idjunta = p.idjunta
INNER JOIN municipios m ON m.idmunicipio = j.idmunicipio
INNER JOIN departamentos d ON d.iddepartamento = m.iddepartamento
INNER JOIN telementoscls c ON e.idelementocls = c.idelementocls
INNER JOIN telementostip t ON c.idtipoactivo = t.idtipoactivo
$where
GROUP BY 
    e.idelemento,
    d.nombre,
    m.nombre,
    j.nombre,
    t.tipElmNombre

ORDER BY 
    d.nombre ASC,
    m.nombre ASC,
    j.nombre ASC,
    t.tipElmNombre ASC;";
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
?>
<table><tr><th>#</th>
    <th>Departamento</th>

    <th>Municipio</th>        
    <th>Junta</th>        
    <th>IdElm.</th>
    <th>Elemento</th>
    <th>Tipo</th>
    <th>Total</th>
    <th>Gráfica</th>
    <th>Proyectos</th>
    <th>Fechas</th></tr>
<?php
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
        <td><?= $row['idelemento'] ?></td>
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