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
<title>SARA - Indicador de Co-relación de Ejecución</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<a href="../principal.php">Principal</a>
<h2>Ind. de Co-relación de Ejecución</h2>

<?php

require_once "../back/filtro.php";

// 🔹 obtener filtros (centralizado)
$f = obtenerFiltros();

$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$Iddpto = $f["Iddpto"];
$Idmnc  = $f["Idmnc"];
$pgn    = $f["pgn"];


// 🔹 consulta (la implementas tú en el modelo)
$resultado = consultarCorelEjec($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn);

?>

<?php
// 🔹 calcular máximos (igual que antes)
$maxProy = 0;
$maxBen  = 0;
$maxact  = 0;
$maxMon  = 0;

if ($resultado) {
    $resultado->data_seek(0);
    while($r = $resultado->fetch_assoc()){
        if ($r['total_proyectos'] > $maxProy) $maxProy = $r['total_proyectos'];
        if ($r['total_actividades'] > $maxact) $maxact = $r['total_actividades'];
        if ($r['beneficiarios'] > $maxBen) $maxBen  = $r['beneficiarios'];
        if ($r['monto'] > $maxMon) $maxMon  = $r['monto'];
    }
    $resultado->data_seek(0);
}
?>

<table style="padding:0px !important; margin:0px !important; line-height:1 !important;">
<tr>
    <th>#</th>
    <th>Año</th>
    <th>Departamento</th>
    <th>Municipio</th>
    <th>Vereda</th>
    <th>Proyectos</th><th>-</th>
    <th>Actividades</th><th>-</th>
    <th>Dinero</th><th>-</th>
    <th>Benef.</th><th>-</th>
</tr>

<?php
$contFil = 1;

if ($resultado) {
while ($row = $resultado->fetch_assoc()):

    $a0 = $maxProy > 0 ? intval(($row['total_proyectos'] / $maxProy) * 100) : 0;
    $aa = $maxact > 0 ? intval(($row['total_actividades'] / $maxact) * 100) : 0;
    $a1 = $maxMon > 0 ? intval(($row['monto'] / $maxMon) * 100) : 0;
    $a2 = $maxBen > 0 ? intval(($row['beneficiarios'] / $maxBen) * 100) : 0;

    echo "<tr>
        <td>$contFil</td>
        <td>{$row['anio']}</td>        
        <td>{$row['departamento']}</td>
        <td>{$row['municipio']}</td>
        <td>{$row['vereda']}</td>

        <td align='right'>{$row['total_proyectos']}</td>
        <td><img src='../img/barra.png' height='16' width='$a0'></td>

        <td align='right'>{$row['total_actividades']}</td>
        <td><img src='../img/barra.png' height='16' width='$aa'></td>

        <td align='right'>" . number_format($row['monto']) . "</td>
        <td><img src='../img/barra.png' height='16' width='$a1'></td>

        <td align='right'>{$row['beneficiarios']}</td>
        <td><img src='../img/barra.png' height='16' width='$a2'></td>
    </tr>";

    $contFil++;

endwhile;
}
?>
</table></body></html>