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
$datos = consultarProyectosxMes($fchInc, $fchFin, $iddpt, $idmnc, $pgn);
// cabecera de la tabla
//$headers = ["#", "Mes", "Depart.", "Municipio", "Junta", "Id", "Proyecto", "$ Ej.", "$ Prs.", "-", "Pers. Ej.", "Pers. Prs.", "-", "Horas Ej.", "Horas Prs.", "-", "Activ. Ej.", "Activ. Prs.", "-"];
$headers = ["#", "Month", "Super.", "System", "Community", "Id", "Project", "Budget", "Part.","Hours","Activ" ,"Budget", "-", "Part", "-", "Hours", "-","Activ", "-"];
echo 'Ind. según Metas agrupando por mes (According to the defined goals grouping by month)<br><br><table><tr>';
echo '<tr><td colspan="7">&nbsp;</td><td colspan="4" align="center">Planned</td><td colspan="8" align="center">Executed</td></tr>';
foreach($headers as $h){ 
    echo '<th>'.$h.'</th>';
} 
$i = 0;
if (!empty($datos)):
    // 1. CONTAR ROWSPAN POR PROYECTO
    $rowspans = [];
    $prev = null;
    $count = 0;
    foreach ($datos as $row) {
        if ($prev === $row['idprj']) {
            $count++;
        } else {
            if ($prev !== null) {
                $rowspans[$prev] = $count;
            }
            $prev = $row['idprj'];
            $count = 1;
        }
    }
    if ($prev !== null) {
        $rowspans[$prev] = $count;
    }
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
        // COLUMNAS AGRUPADAS (PLAN)
        if (!isset($printed[$row['idprj']])) {
            $rs = $rowspans[$row['idprj']];
            $printed[$row['idprj']] = true;
            echo '<td rowspan="'.$rs.'">'.$row["mes"].'</td>';
            echo '<td rowspan="'.$rs.'">'.$row["departamento"].'</td>';
            echo '<td rowspan="'.$rs.'">'.$row["municipio"].'</td>';
            echo '<td rowspan="'.$rs.'">'.$row["junta"].'</td>';
            echo '<td rowspan="'.$rs.'" align="right">'.$row["idprj"].'</td>';
            echo '<td rowspan="'.$rs.'">'.$row["nombreproyecto"].'</td>';
            echo '<td rowspan="'.$rs.'" align="right">'.number_format($row["presupuesto"],0).'</td>';
            echo '<td rowspan="'.$rs.'" align="right">'.$row['personas'].'</td>';
            echo '<td rowspan="'.$rs.'" align="right">'.$row['horas'].'</td>';
            echo '<td rowspan="'.$rs.'" align="right">'.$row["actividades"].'</td>';
        }
        // EJECUCIÓN (NO AGRUPADA)
        echo '<td align="right">'.number_format($row["total_presupuesto"],0).'</td>';
        // % presupuesto
        echo '<td>';
        $var = ($row['presupuesto'] > 0)
            ? round($row['total_presupuesto']*100/$row['presupuesto'],0)
            : 0;
        echo '<img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        // personas ejecutadas
        echo '<td align="right">'.$row['total_personas'].'</td>';
        // % personas
        $var = ($row['personas'] > 0)
            ? round($row['total_personas']*100/$row['personas'],1)
            : 0;
        echo '<td><img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%</td>';
        // horas ejecutadas
        echo '<td align="right">'.$row['total_horas'].'</td>';
        // % horas
        echo '<td>';
        $var = ($row['horas'] > 0)
            ? round($row['total_horas']*50/$row['horas'],0)
            : 0;
        echo '<img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        // actividades ejecutadas
        echo '<td align="right">'.$row["total_actividades"].'</td>';
        // % actividades
        echo '<td>';
        $var = ($row['actividades'] > 0)
            ? round($row['total_actividades']*50/$row['actividades'],0)
            : 0;
        echo '<img src="../img/barra.png" height="16" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        echo '</tr>';
    endforeach;
else: 
echo '<tr><td colspan="13">No hay información</td></tr>';
endif;
echo '</table>';
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
$headers = ["#", "Year", "Super.", "System", "Community", "Cnt. Prj.", "Projects", "-", "Budget", "-", "Partic.", "-", "Hours", "-", "Activ.", "-"];
echo '<br>Ind. según listado agrupando por año  (According to the list generated grouping by year)<br><br><table style="padding:0px !important; margin:0px !important; line-height:1 !important;"><tr>';
foreach($headers as $h){ 
    echo '<th>'.$h.'</th>';
} 
$contFil = 1;
if ($resultado) {
while ($row = $resultado->fetch_assoc()):
    $a0 = $maxProy > 0 ? intval(($row['total_proyectos'] / $maxProy) * 100) : 0;
    $aa = $maxAct > 0 ? intval(($row['total_actividades'] / $maxAct) * 100) : 0;
    $a1 = $maxMon > 0 ? intval(($row['monto'] / $maxMon) * 100) : 0;
    $a2 = $maxHor > 0 ? intval(($row['total_horas'] / $maxHor) * 100) : 0;
    $a3 = $maxBen > 0 ? intval(($row['beneficiarios'] / $maxBen) * 100) : 0;
    if ($contFil % 2 == 0) {
        echo '<tr style="background-color:#f2f2f2;">'; // fila par
    } else {
        echo '<tr>'; // fila impar
    }     
    echo "<td>$contFil</td>
   
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
                    <td>{$row['anio']}</td>     
    </tr>";
    $contFil++;
endwhile;
}
?>
</table>
<?php
$resultado = consultarProyectosxJunta($fchInc, $fchFin, $iddpt, $idmnc, $pgn);
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

echo '<br>Ind. según listado agrupando por super (According to the list generatedgrouping by super)<br><br><table><tr>';
//$headers = ["#", "Depart.", "Municipio", "Vereda", "Cnt. Pry.", "Proyectos", "-", "Dinero", "-", "Benef.", "-", "Horas", "-", "Activ.", "-"];
$headers = ["#", "Super.", "System", "Community", "Cnt. Prj.", "Projects", "-", "Budget", "-", "Benef.", "-", "Hours", "-", "Activ.", "-"];
foreach($headers as $h){ 
    echo '<th>'.$h.'</th>';
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
        echo "<tr>
            <td colspan='4' align='right'>MAX $depActual</td>
            <td align='right'>{$m['proyectos']}</td>
            <td></td>
            <td></td>
            <td align='right'>" .
                number_format($m['monto'],0,',','.') .
            "</td>
            <td></td>
            <td align='right'>{$m['beneficiarios']}</td>
            <td></td>
            <td align='right'>{$m['horas']}</td>
            <td></td>
            <td align='right'>{$m['actividades']}</td>
            <td></td>
        </tr>";
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
    // FILA NORMAL
    if ($fila% 2 == 0) {
        echo '<tr style="background-color:#f2f2f2;">'; // fila par
    } else {
        echo '<tr>'; // fila impar
    }    
    echo "<td>$fila</td>
        <td>{$d['departamento']}</td>
        <td>{$d['municipio']}</td>
        <td>{$d['junta']}</td>
        <td align='right'>{$d['proyectos']}</td>
        <td>{$d['proyectos_fechas']}</td>
        <td>
            <img src='../img/barra.png'
                 height='16'
                 width='{$pProy}'>
            &nbsp;{$pProy}%
        </td>
        <td align='right'>" .
            number_format($d['monto'],0,',','.') .
        "</td>
        <td>
            <img src='../img/barra.png'
                 height='16'
                 width='{$pMonto}'>
            &nbsp;{$pMonto}%
        </td>
        <td align='right'>{$d['beneficiarios']}</td>
        <td>
            <img src='../img/barra.png'
                 height='16'
                 width='{$pBenef}'>
            &nbsp;{$pBenef}%
        </td>
        <td align='right'>{$d['total_horas']}</td>
        <td>
            <img src='../img/barra.png'
                 height='16'
                 width='{$pHoras}'>
            &nbsp;{$pHoras}%
        </td>
        <td align='right'>{$d['total_actividades']}</td>
        <td><img src='../img/barra.png' height='16' width='{$pAct}'>&nbsp;{$pAct}%</td>
    </tr>";
    $fila++;
}
// ULTIMO SUPER
if ($depActual != '') {
    $m = $maximos[$depActual];
    echo "<tr>
        <td><td>$depActual</td><td colspan='2' align='right'>
        <td align='right'>{$m['proyectos']}</td>
        <td></td>
        <td></td>
        <td align='right'>".number_format($m['monto'],0,',','.')."</td>
        <td></td>
        <td align='right'>{$m['beneficiarios']}</td>
        <td></td>
        <td align='right'>{$m['horas']}</td>
        <td></td>
        <td align='right'>{$m['actividades']}</td>
        <td></td>
    </tr>";
}
?>
</table>