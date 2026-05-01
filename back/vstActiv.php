<html lang="es"><head><meta charset="UTF-8">
<title>SARA - Ind. Consolidado</title>
<link rel="stylesheet" href="../back/estilos.css">
</head><body>
<a href="../principal.php">Principal</a></li>
<h2>Ind. Consolidado</h2>
<?php
require_once "../back/filtro.php"; 
if (isset($resultado["error"])) {
    echo "<p>Error: {$resultado["error"]}</p>";
    exit;
}
$datos = consultarProyectosxMes($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn);
?>
Ind. por Mes<br><br>
<table >
<tr>
    <th>#</th>
    <th>Mes</th>
    <th>Depart.</th>
    <th>Municipio</th>
    <th>Junta</th>
    <th>Id</th>
    <th>Proyecto</th>
    <th>$ Ej.</th>
    <th>$ Prs.</th><th>-
    <th>Pers. Ej.</th>
    <th>Pers. Prs.</th><th>-
    <th>Horas Ej.</th>
    <th>Horas Prs.</th><th>-
    <th>Activ. Ej.</th>
    <th>Activ. Prs.</th><th>-
</tr><?php
$i = 0;
if (!empty($datos)):
    foreach ($datos as $row):
        echo '<tr>';
        $i++;
        echo '<td>'.$i.'</td>';
        echo '<td>'.$row["mes"].'</td>';
        echo '<td>'.$row["departamento"].'</td>';
        echo '<td>'.$row["municipio"].'</td>';
        echo '<td>'.$row["junta"].'</td>';
        echo '<td align="right">'.$row["idproyecto"].'</td>';
        echo '<td>'.$row["nombreproyecto"].'</td>';
        echo '<td align="right">'.number_format($row["total_presupuesto"],0).'</td>';
        echo '<td align="right">'.number_format($row["presupuesto"],0).'</td>';
        echo '<td>';
        if ($row['presupuesto'] > 0) $var = round($row['total_presupuesto']*50/$row['presupuesto'],0);
        else $var = 0;
        echo '<img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        echo '<td align="right">'.$row['total_personas'];
        echo '<td align="right">'.$row['personas'].'</td>';
        if ($row['personas'] > 0)    $var = round($row['total_personas']*100/$row['personas'],1);
        else $var = 0;  
        echo '<td><img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%'; // = ('.$row["total_personas"].'/'.$row["total_actividades"].')/'.$row["beneficiarios"];
        echo '<td align="right">'.$row['total_horas'].'</td>';
        echo '<td align="right">'.$row['horas'].'</td>';
        echo '<td>';
        if ($row['horas'] > 0) $var = round($row['total_horas']*50/$row['horas'],0);
        else $var = 0;
        echo '<img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        echo '<td align="right">'.$row["total_actividades"].'</td>';
        echo '<td align="right">'.$row["actividades"].'</td>';
        echo '<td>';
        if ($row['actividades'] > 0) $var = round($row['total_actividades']*50/$row['actividades'],0);
        else $var = 0;
        echo '<img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        
        
        echo '</tr>';
    endforeach;
else:
?>
<tr><td colspan="13">No hay información</td></tr>
<?php endif; ?>
</table>
<?php
// consulta (la implementas tú en el modelo)
$resultado = consultarProyectosxAño($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn);
// calcular máximos (igual que antes)
$maxProy = 0; 
$maxBen  = 0; 
$maxMon  = 0;  
$maxHor = 0;
$maxAct = 0;
if ($resultado) {
    $resultado->data_seek(0);
    while($r = $resultado->fetch_assoc()){
        if ($r['total_proyectos'] > $maxProy) $maxProy = $r['total_proyectos'];
        if ($r['total_actividades'] > $maxAct) $maxAct = $r['total_actividades'];
        if ($r['beneficiarios'] > $maxBen) $maxBen  = $r['beneficiarios'];
        if ($r['total_horas'] > $maxHor) $maxHor  = $r['total_horas'];
        if ($r['monto'] > $maxMon) $maxMon  = $r['monto'];
    }
    $resultado->data_seek(0);
}
?>
<br>Ind. por Año<br><br>
<table style="padding:0px !important; margin:0px !important; line-height:1 !important;">
<tr>
    <th>#</th>
    <th>Año</th>
    <th>Depart.</th>
    <th>Municipio</th>
    <th>Vereda</th>
    <th>Cnt. Pry.</th>
    <th>Proyectos</th><th>-</th>
    <th>Dinero</th><th>-</th>
    <th>Benef.</th><th>-</th>
    <th>Horas</th><th>-</th>
    <th>Activ.</th><th>-</th>
</tr>
<?php
$contFil = 1;
if ($resultado) {
while ($row = $resultado->fetch_assoc()):

    $a0 = $maxProy > 0 ? intval(($row['total_proyectos'] / $maxProy) * 100) : 0;
    $aa = $maxAct > 0 ? intval(($row['total_actividades'] / $maxAct) * 100) : 0;
    $a1 = $maxMon > 0 ? intval(($row['monto'] / $maxMon) * 100) : 0;
    $a2 = $maxHor > 0 ? intval(($row['total_horas'] / $maxHor) * 100) : 0;
    $a3 = $maxBen > 0 ? intval(($row['beneficiarios'] / $maxBen) * 100) : 0;

    echo "<tr>
        <td>$contFil</td>
        <td>{$row['anio']}</td>        
        <td>{$row['departamento']}</td>
        <td>{$row['municipio']}</td>
        <td>{$row['vereda']}</td>
        <td align='right'>{$row['total_proyectos']}</td>
        <td>{$row['proyectos_fechas']}</td>
        <td><img src='../img/barra.png' height='16' width='$a0'>&nbsp;{$a0}%</td>

        <td align='right'>" . number_format($row['monto']) . "</td>
        <td><img src='../img/barra.png' height='16' width='$a1'>&nbsp;{$a1}%</td>

        <td align='right'>{$row['beneficiarios']}</td>
        <td><img src='../img/barra.png' height='16' width='$a3'>&nbsp;{$a3}%</td>

        <td align='right'>{$row['total_horas']}</td>
        <td><img src='../img/barra.png' height='16' width='$a2'>&nbsp;{$a2}%</td>
        <td align='right'>{$row['total_actividades']}</td>
        <td><img src='../img/barra.png' height='16' width={$aa}>&nbsp;{$aa}%</td>
    </tr>";

    $contFil++;

endwhile;
}
?>
</table>
<?php
$resultado = consultarProyectosxJunta($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn);
$datos = $resultado["detalle"];
// 🔹 calcular máximos
$maxProy = 0;
$maxMonto = 0;
$maxBenef = 0;
$maxHoras = 0;
$maxAct = 0;
foreach ($datos as $d) {
    if ($d['proyectos'] > $maxProy) $maxProy = $d['proyectos'];
    if ($d['monto'] > $maxMonto) $maxMonto = $d['monto'];
    if ($d['beneficiarios'] > $maxBenef) $maxBenef = $d['beneficiarios'];
    if ($d['total_horas'] > $maxHoras) $maxHoras = $d['total_horas'];
    if ($d['total_actividades'] > $maxAct) $maxAct = $d['total_actividades'];
}
?>
<br>Ind. por Junta<br><br>
<table>
<tr>
    <th>#</th>
    <th>Depart.</th>
    <th>Municipio</th>
    <th>Vereda</th>
    <th>Cnt. Pry.</th>
    <th>Proyectos</th><th>-</th>
    <th>Dinero</th><th>-</th>
    <th>Benef.</th><th>-</th>
    <th>Horas</th><th>-</th>
    <th>Activ.</th><th>-</th>
</tr>
<?php
$fila = 1;
foreach ($datos as $d) {
    // porcentajes
    $pProy = $maxProy ? ($d['proyectos'] * 100) / $maxProy : 0;
    $pMonto = $maxMonto ? ($d['monto'] * 100) / $maxMonto : 0;
    $pBenef = $maxBenef ? ($d['beneficiarios'] * 100) / $maxBenef : 0;
    $pHoras = $maxHoras ? ($d['total_horas'] * 100) / $maxHoras : 0;
    $pAct = $maxAct ? ($d['total_actividades'] * 100) / $maxAct : 0;

    $pProy = round($pProy);
    $pMonto = round($pMonto);
    $pBenef = round($pBenef);
    $pHoras = round($pHoras);
    $pAct = round($pAct);

    
    echo "<tr>
        <td>$fila</td>
        <td>{$d['departamento']}</td>
        <td>{$d['municipio']}</td>
        <td>{$d['junta']}</td>
        <td align='right'>{$d['proyectos']}</td>
        <td>{$d['proyectos_fechas']}</td>
        
        <td><img src='../img/barra.png' height='16' width={$pProy}>&nbsp;{$pProy}%</td>
        </td>
        <td align='right'>" . number_format($d['monto'], 0, ',', '.') . "</td>
        <td><img src='../img/barra.png' height='16' width={$pMonto}>&nbsp;{$pMonto}%</td>
        </td>
        <td align='right'>{$d['beneficiarios']}</td>
        <td><img src='../img/barra.png' height='16' width={$pBenef}>&nbsp;{$pBenef}%</td>
    
        <td align='right'>{$d['total_horas']}</td>
        <td><img src='../img/barra.png' height='16' width={$pHoras}>&nbsp;{$pHoras}%</td>
        <td align='right'>{$d['total_actividades']}</td>
        <td><img src='../img/barra.png' height='16' width={$pAct}>&nbsp;{$pAct}%</td>";
        echo '</td>';
        
    echo '</tr>';

    $fila++;
}
?>

</table>
