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
<head><meta charset="UTF-8">
<title>SARA - Ind. de Ubicaciones</title>
<link rel="stylesheet" href="../back/estilos.css">
</head><body>
<a href="../principal.php">Principal</a>
<h2>Ind. de Ubicaciones</h2>
<form method="post">
    Departamento: 
    <select name="iddepartamento">
        <option value="">Seleccione...</option>
    </select>
    Municipio: <select name="departamento"><option>Seleccione...</option></select>
    Junta: <select name="departamento"><option>Seleccione...</option></select>
    <button type="submit">Consultar</button>
</form>
<?php
// 1. CONEXIÓN A LA BD
include("../back/conexion.php"); 
$conexion = conectarse();
// 2. CONSULTA
$sql = "
SELECT
    d.nombre AS departamento,
    m.nombre AS municipio,
    j.nombre AS junta,
    t.tipElmNombre AS tipo,
    COUNT(e.idelemento) AS total
FROM elementos e
/* JUNTA (idorg = idjunta) */
INNER JOIN juntas j
        ON j.idjunta = e.idorg
/* UBICACIÓN */
INNER JOIN municipios m
        ON m.idmunicipio = j.idmunicipio
INNER JOIN departamentos d
        ON d.iddepartamento = m.iddepartamento
/* CLASIFICACIÓN DEL ELEMENTO */
INNER JOIN telementoscls c
        ON e.idelementocls = c.idelementocls
INNER JOIN telementostip t
        ON c.idtipoactivo = t.idtipoactivo
WHERE 1 = 1
/* AQUÍ SIGUEN FUNCIONANDO TUS FILTROS */
/* AGRUPAMIENTO CLAVE (NO SE PIERDE) */
GROUP BY
    e.idorg,
    t.idtipoactivo,
    d.nombre,
    m.nombre,
    j.nombre,
    t.tipElmNombre
ORDER BY
    d.nombre ASC,
    m.nombre ASC,
    j.nombre ASC,
    t.tipElmNombre ASC
";
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
    <th>Tipo</th>
    <th>Total</th>
    <th>Gráfica</th></tr>
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
        <td><?php echo $row['tipo']; ?></td>
        <td align="center"><?php echo $row['total']; ?></td>
        <td><img src="../img/barra.png" width="<?php echo intval($anchoBarra); ?>" height="20" alt="<?php echo round($porcentaje,1); ?>%" >
            <?php echo round($porcentaje,1); ?>%
        </td>
    </tr>
<?php $fila++; 
    } ?>
</table>
</body>
</html>
<?php
mysqli_close($conexion); //CERRAR CONEXIÓN
}

?>