<html lang="es"><head><meta charset="UTF-8">
<title>SARA - Ind. Consolidado</title>
<link rel="stylesheet" href="../functions/estilos.css">
</head><body><a href="../principal.php">Principal</a></li>
<h2>Ind. Intervención</h2><?php
require_once "../functions/filtro.php"; 
if (isset($resultado["error"])) {
    echo "<p>Error: {$resultado["error"]}</p>"; exit;
}
// consulta (implementada en el modelo)
$datos = consultarMetasxMes($fchInc, $fchFin, $iddpt, $idmnc, $pgn);
// cabecera de la tabla
//$headers = ["#", "Mes", "Depart.", "Municipio", "Junta", "Id", "Proyecto", "$ Ej.", "$ Prs.", "-", "Pers. Ej.", "Pers. Prs.", "-", "Horas Ej.", "Horas Prs.", "-", "Activ. Ej.", "Activ. Prs.", "-"];
//$headers = ["#", "Month", "Super.", "System", "Comm.", "Id", "Prjct", "Bud.", "Part.","Hrs.","Act." ,"Budget", "-", "Part", "-", "Tim.", "-","Activ", "-"];
$headers = ["#", "Month", "Comm.", "Id.Prj.", "Prjct", "Bud.", "Part.","Tim.","Act." ,"Bud.", "-", "Part.", "-", "Tim.", "-","Activ", "-"];
echo '<table>';
echo '<tr><td  colspan="20">Ind. según Metas agrupando por mes (According to the defined goals grouping by month)<tr>';
echo '<tr><td colspan="5">&nbsp;</td><td colspan="4" align="center">Planned</td><td colspan="8" align="center">Executed</td></tr>';
foreach($headers as $h){ 
    echo '<th>'.$h.'</th>';
} 
$i = 0;
if (!empty($datos)):
    // 1. CONTAR ROWSPAN POR PROYECTO
    $rowspans = [];
    $prev = null;
    $count = 0;
    // 2. IMPRIMIR TABLA
    $printed = [];
    $i = 0;
    foreach ($datos as $row):
        $i++;
        if ($i % 2 == 0) {
            echo '<tr style="background-color:#f2f2f2;">'; // fila par
        } else {
            echo '<tr>'; // fila impar
        }        
        echo '<td>'.$i.'</td>';
        $rs=1;
        $printed[$row['idprj']] = true;
        echo '<td rowspan="'.$rs.'">'.$row["mes"].'</td>';
//            echo '<td rowspan="'.$rs.'">'.$row["departamento"].'</td>';
//            echo '<td rowspan="'.$rs.'">'.$row["municipio"].'</td>';
        echo '<td rowspan="'.$rs.'">'.$row["junta"].'</td>';
        echo '<td rowspan="'.$rs.'" align="right">'.$row["idprj"].'</td>';
        echo '<td rowspan="'.$rs.'">'.$row["nombreproyecto"].'</td>';
        echo '<td rowspan="'.$rs.'" align="right">'.number_format($row["presupuesto"],0).'</td>';
        echo '<td rowspan="'.$rs.'" align="right">'.$row['personas'].'</td>';
        echo '<td rowspan="'.$rs.'" align="right">'.$row['horas'].'</td>';
        echo '<td rowspan="'.$rs.'" align="right">'.$row["actividades"].'</td>';
        echo '<td align="right">'.number_format($row["total_presupuesto"],0).'</td>';
        echo '<td>';
        $var = ($row['presupuesto'] > 0) ? round($row['total_presupuesto']*100/$row['presupuesto'],0) : 0;
        $vara= $var/2;
        echo '<img src="../img/barra.png" height="16" width="'.$vara.'"> '.$var.'%';
        echo '</td>';
        echo '<td align="right">'.$row['total_personas'].'</td>';
        $var = ($row['personas'] > 0) ? round($row['total_personas']*100/$row['personas'],0) : 0;
        $vara= $var/2;
        echo '<td><img src="../img/barra.png" height="16" width="'.$vara.'"> '.$var.'%</td>';
        echo '<td align="right">'.$row['total_horas'].'</td>';
        echo '<td>';
        $var = ($row['horas'] > 0) ? round($row['total_horas']*100/$row['horas'],0) : 0;
        $vara= $var/2;
        echo '<img src="../img/barra.png" height="16" width="'.$vara.'"> '.$var.'%';
        echo '</td>';
        echo '<td align="right">'.$row["total_actividades"].'</td>';
        echo '<td>';
        $var = ($row['actividades'] > 0) ? round($row['total_actividades']*100/$row['actividades'],0): 0;
        $vara= $var/2;
        echo '<img src="../img/barra.png" height="16" width="'.$vara.'"> '.$var.'%';
        echo '</td>';
        echo '</tr>';
    endforeach;
else: 
    echo '<tr><td colspan="13">No hay información</td></tr>';
endif;
//echo '</table>';
// consulta (la implementas tú en el modelo)
$resultado = consultarProyectosxAño($fchInc, $fchFin, $iddpt, $idmnc, $pgn);
// calcular máximos (igual que antes)
$maxProy = 0; $maxBen  = 0; $maxMon  = 0;  
$maxHor = 0;  $maxAct = 0;
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
//$headers = ["#", "Año", "Depart.", "Municipio", "Vereda", "Cnt. Pry.", "Proyectos", "-", "Dinero", "-", "Benef.", "-", "Horas", "-", "Activ.", "-"];
//$headers = ["#", "Year", "Super.", "System", "Comm.", "C.Prj.", "Prjcts", "-","Budget", "-", "Part.", "-", "Tim.", "-", "Activ.", "-"];
$headers = ["#", "Year", "Comm.", "C.Prj.", "Prjcts", "-","Bud.", "-", "Part.", "-", "Tim.", "-", "Activ.", "-"];
echo '<tr><td colspan="20">Ind. según Listado agrupando por año  (According to the list generated grouping by year)<tr>';
foreach($headers as $i => $h){  
    echo '<th';
    if ($i == 5) echo ' colspan="4"';
    echo '>'.$h.'</th>';
}
$contFil = 1;
if ($resultado) {
while ($row = $resultado->fetch_assoc()):
    $a0 = $maxProy > 0 ? intval(($row['total_proyectos'] / $maxProy) * 100) : 0;
    $aa = $maxAct > 0 ? intval(($row['total_actividades'] / $maxAct) * 100) : 0;
    $a1 = $maxMon > 0 ? intval(($row['monto'] / $maxMon) * 100) : 0;
    $a2 = $maxHor > 0 ? intval(($row['total_horas'] / $maxHor) * 100) : 0;
    $a3 = $maxBen > 0 ? intval(($row['beneficiarios'] / $maxBen) * 100) : 0;
    $a0a = $a0/2;
    $aaa = $aa/2;
    $a1a = $a1/2;
    $a2a = $a2/2;
    $a3a = $a3/2;    
    if ($contFil % 2 == 0) {
        echo '<tr style="background-color:#f2f2f2;">'; // fila par
    } else {
        echo '<tr>'; // fila impar
    }     
    echo '<tr>';
    echo '<td>'.$contFil.'</td>';
    echo '<td>'.$row['anio'].'</td>';
//    echo '<td>'.$row['departamento'].'</td>';
//    echo '<td>'.$row['municipio'].'</td>';
    echo '<td>'.$row['vereda'].'</td>';
    echo '<td align="right">'.$row['total_proyectos'].'</td>';
    echo '<td>'.$row['proyectos_fechas'].'</td>';
    echo '<td colspan="4"><img src="../img/barra.png" height="16" width="'.$a0a.'">&nbsp;'.$a0.'%</td>';
    echo '<td align="right">'.number_format($row['monto']).'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$a1a.'">&nbsp;'.$a1.'%</td>';
    echo '<td align="right">'.$row['beneficiarios'].'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$a3a.'">&nbsp;'.$a3.'%</td>';
    echo '<td align="right">'.$row['total_horas'].'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$a2a.'">&nbsp;'.$a2.'%</td>';
    echo '<td align="right">'.$row['total_actividades'].'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$aaa.'">&nbsp;'.$aa.'%</td>';
    echo '</tr>';
    $contFil++;
endwhile;
}
// Tabla 3
$resultado = consultarProyectosxJunta($fchInc, $fchFin, $iddpt, $idmnc, $pgn);
$datos = $resultado["detalle"];
// calcular máximos
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
echo '<tr><td colspan="13">Ind. según Comunidad agrupando por Super (According to Community grouping by Super)</td><tr>';
//$headers = ["#", "Depart.", "Municipio", "Vereda", "Cnt. Pry.", "Proyectos", "-", "Dinero", "-", "Benef.", "-", "Horas", "-", "Activ.", "-"];
//$headers = ["#","-","Super.", "System", "Comm.", "C.Prj.", "Prjcts", "-", "Budget", "-", "Part.", "-", "Tim.", "-", "Activ.", "-"];
$headers = ["#","-","Comm.", "C.Prj.", "Prjcts", "-", "Bud.", "-", "Part.", "-", "Tim.", "-", "Activ.", "-"];
foreach($headers as $i => $h){  
    echo '<th';
    if ($i == 5) echo ' colspan="4"';
    echo '>'.$h.'</th>';
}
$fila = 1;
$maximos = [];
// Calcular los máximos por super
foreach ($datos as $d) {
    $sup = $d['departamento'];
    if (!isset($maximos[$sup])) {
        $maximos[$sup] = [
            'proyectos' => 0,
            'monto' => 0,
            'beneficiarios' => 0,
            'horas' => 0,
            'actividades' => 0
        ];
    }
    $maximos[$sup]['proyectos'] =  max($maximos[$sup]['proyectos'], $d['proyectos']);
    $maximos[$sup]['monto'] = max($maximos[$sup]['monto'], $d['monto']);
    $maximos[$sup]['beneficiarios'] = max($maximos[$sup]['beneficiarios'], $d['beneficiarios']);
    $maximos[$sup]['horas'] = max($maximos[$sup]['horas'], $d['total_horas']);
    $maximos[$sup]['actividades'] = max($maximos[$sup]['actividades'], $d['total_actividades']);
}
// Recorrer datos
$depActual = '';
foreach ($datos as $d) {
    $sup = $d['departamento'];
    // CAMBIO DE SUPER
    if ($depActual != '' && $depActual != $sup) {
        $m = $maximos[$depActual];
        echo '<tr>';
        echo '<td colspan="3" align="right">MAX '.$depActual.'</td>';
        echo '<td align="right">'.$m['proyectos'].'</td>';
        echo '<td></td>';
        echo '<td colspan="4"></td>';
        echo '<td align="right">'.number_format($m['monto'],0,',','.').'</td>';
        echo '<td></td>';
        echo '<td align="right">'.$m['beneficiarios'].'</td>';
        echo '<td></td>';
        echo '<td align="right">'.$m['horas'].'</td>';
        echo '<td></td>';
        echo '<td align="right">'.$m['actividades'].'</td>';
        echo '<td></td>';
        echo '</tr>';
    }
    $depActual = $sup;
    // MAXIMOS DEL SUPER ACTUAL
    $maxProy  = $maximos[$sup]['proyectos'];
    $maxMonto = $maximos[$sup]['monto'];
    $maxBenef = $maximos[$sup]['beneficiarios'];
    $maxHoras = $maximos[$sup]['horas'];
    $maxAct   = $maximos[$sup]['actividades'];
    // PORCENTAJES
    $pProy  = $maxProy  ? round(($d['proyectos'] * 100) / $maxProy) : 0;
    $pMonto = $maxMonto ? round(($d['monto'] * 100) / $maxMonto) : 0;
    $pBenef = $maxBenef ? round(($d['beneficiarios'] * 100) / $maxBenef) : 0;
    $pHoras = $maxHoras ? round(($d['total_horas'] * 100) / $maxHoras) : 0;
    $pAct   = $maxAct   ? round(($d['total_actividades'] * 100) / $maxAct) : 0;
    $pProya  = $pProy/2;
    $pMontoa = $pMonto/2;
    $pBenefa = $pBenef/2;
    $pHorasa = $pHoras/2;
    $pActa   = $pAct/2;
    // FILA NORMAL
    if ($fila% 2 == 0) {
        echo '<tr style="background-color:#f2f2f2;">'; // fila par
    } else {
        echo '<tr>'; // fila impar
    }    
    echo '<tr>';
    echo '<td>'.$fila.'</td>';
    echo '<td></td>';
    //echo '<td>'.$d['departamento'].'</td>';
    //echo '<td>'.$d['municipio'].'</td>';
    echo '<td>'.$d['junta'].'</td>';
    echo '<td align="right">'.$d['proyectos'].'</td>';
    echo '<td>'.$d['proyectos_fechas'].'</td>';
    echo '<td colspan="4"><img src="../img/barra.png" height="16" width="'.$pProya.'">&nbsp;'.$pProy.'%</td>';
    echo '<td align="right">'.number_format($d['monto'],0,',','.').'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$pMontoa.'">&nbsp;'.$pMonto.'%</td>';
    echo '<td align="right">'.$d['beneficiarios'].'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$pBenefa.'">&nbsp;'.$pBenef.'%</td>';
    echo '<td align="right">'.$d['total_horas'].'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$pHorasa.'">&nbsp;'.$pHoras.'%</td>';
    echo '<td align="right">'.$d['total_actividades'].'</td>';
    echo '<td><img src="../img/barra.png" height="16" width="'.$pActa.'">&nbsp;'.$pAct.'%</td>';
    echo '</tr>';
    $fila++;
}
// ULTIMO SUPER
if ($depActual != '') {
    $m = $maximos[$depActual];
    echo '<tr>';
    echo '<td></td>';
    echo '<td colspan="2" align="right">MAX '.$depActual.'</td>';
    echo '<td align="right">'.$m['proyectos'].'</td>';
    echo '<td></td>';
    echo '<td colspan="4"></td>';
    echo '<td align="right">'.number_format($m['monto'],0,',','.').'</td>';
    echo '<td></td>';
    echo '<td align="right">'.$m['beneficiarios'].'</td>';
    echo '<td></td>';
    echo '<td align="right">'.$m['horas'].'</td>';
    echo '<td></td>';
    echo '<td align="right">'.$m['actividades'].'</td>';
    echo '<td></td>';
    echo '</tr>';
}
?>
</table>