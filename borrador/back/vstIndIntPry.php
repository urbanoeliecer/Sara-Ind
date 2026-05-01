<html>
<head>
<title>SARA - Informe de Intervencion</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<a href="../principal.php">Principal</a><br>
<h2>Ind. de Intervenciones planteadas</h2>
<?php
require_once "../back/filtro.php"; 
if (isset($resultado["error"])) {
    echo "<p>Error: {$resultado["error"]}</p>";
    exit;
}
$resultado = consultarProyectos($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn);
$datos = $resultado["detalle"];

// 🔹 calcular máximos
$maxProy = 0;
$maxMonto = 0;
$maxBenef = 0;

foreach ($datos as $d) {
    if ($d['proyecto'] > $maxProy) $maxProy = $d['proyecto'];
    if ($d['monto'] > $maxMonto) $maxMonto = $d['monto'];
    if ($d['beneficiarios'] > $maxBenef) $maxBenef = $d['beneficiarios'];
}
?>
<table>
<tr>
    <th>#</th>
    <th>Departamento</th>
    <th>Municipio</th>
    <th>Vereda</th>
    <th>Fecha Min.</th>
    <th>Proyectos</th>
    <th>-</th>
    <th>Dinero</th>
    <th>-</th>
    <th>Benef.</th>
    <th>-</th>
</tr>
<?php
$fila = 1;
foreach ($datos as $d) {
    // porcentajes
    $pProy = $maxProy ? ($d['proyecto'] * 100) / $maxProy : 0;
    $pMonto = $maxMonto ? ($d['monto'] * 100) / $maxMonto : 0;
    $pBenef = $maxBenef ? ($d['beneficiarios'] * 100) / $maxBenef : 0;

    $pProy = round($pProy);
    $pMonto = round($pMonto);
    $pBenef = round($pBenef);

    echo "<tr>
        <td>$fila</td>
        <td>{$d['departamento']}</td>
        <td>{$d['municipio']}</td>
        <td>{$d['junta']}</td>
        <td>{$d['fechainicio']}</td>
        <td>{$d['proyecto']}</td>
        
        <td><img src='../img/barra.png' height='16' width={$pProy}>&nbsp;{$pProy}%</td>
        </td>
        <td>" . number_format($d['monto'], 0, ',', '.') . "</td>
        <td><img src='../img/barra.png' height='16' width={$pMonto}>&nbsp;{$pMonto}%</td>
        </td>
        <td>{$d['beneficiarios']}</td>
        <td><img src='../img/barra.png' height='16' width={$pBenef}>&nbsp;{$pBenef}%</td>
    </tr>";

    $fila++;
}
?>

</table>

</body>
</html>