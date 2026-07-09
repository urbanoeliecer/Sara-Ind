<html lang="es">
<head>
<meta charset="UTF-8">
<title>SARA - Ind. de Intervención General</title>
<link rel="stylesheet" href="../functions/estilos.css">
</head><body>
<a href="../principal.php">Principal</a>
Ind. General de Intervención
<?php require_once "../functions/filtro.php"; ?>
<table><thead><tr>
<?php 
// headers
$headers = ["#", "Year","Comm.","GII","-", "C.Prj.", "Goal", "%", "-", "Budget", "Goal", "%", "-","C.Time","Goal","%","-","Avg.Prt.", "Goal", "%", "-"];
//$headers = ["#", "Year","Sup.","Syst.","Comm.","GII","-", "Prjs & Dates", "C.Prj.", "Goal", "%", "-", "Budget", "Goal", "%", "-","C.Act.","Goal","-", "Avg.Prt.", "Goal", "%", "-"];
foreach($headers as $h): ?>
    <th><?= $h ?></th>
<?php endforeach; ?>
</tr>
</thead><tbody>
<?php
$fila = 1;
foreach ($data as $row):
    $pProy = porcentaje($row['total_proyectos'], $row['proyectos_deseados']);
    $pPres = porcentaje($row['monto'], $row['presupuesto_deseado']);
    $pPart = number_format($row['participantes']/$row['total_actividades'],1);
    $pBene = porcentaje($pPart, $row['participantes_deseados']);

    echo '<tr'.(($row['anio'] == 'TOTAL') ? ' style="background-color:#d9edf7;"' : '').'>';
    echo '<td>'.$fila.'</td>';
    echo '<td>'.$row['anio'].'</td>';
//    echo '<td>'.$row['departamento'].'</td>';
//    echo '<td>'.$row['municipio'].'</td>';
    echo '<td>'.$row['vereda'].'</td>';
    echo '<td><strong>'.round($row['GII']).'%</strong></td>';
    echo '<td><img src="'.barra($row['GII']).'" width="'.min(100,$row['GII']).'" style="height:16px;"></td>';
//    echo '<td>'.$row['proyectos_fechas'].'</td>';
    echo '<td align="right">'.$row['total_proyectos'].'</td>';
    echo '<td align="right">'.$row['proyectos_deseados'].'</td>';
    echo '<td align="right">'.round($pProy).'%</td>';
    echo '<td><img src="'.barra($pProy).'" width="'.min(100,$pProy).'" style="height:16px;"></td>';
    echo '<td align="right">'.number_format($row['monto'],0).'</td>';
    echo '<td align="right">'.number_format($row['presupuesto_deseado'],0).'</td>';
    echo '<td align="right">'.round($pPres).'%</td>';
    echo '<td><img src="'.barra($pPres).'" width="'.min(100,$pPres).'" style="height:16px;"></td>';
    
    echo '<td align="right">'.number_format($row['participantes'],0).'</td>';
    if($fila == 1) {
        $error1 = $row['total_actividades']*20;
        $error2 = ($row['participantes']/$error1)*100;
    }
    if ($fila == 3) {
        $error2 = ($row['participantes']/$error1)*100;        
    }
    echo '<td align="right">'.$error1.'</td><td align="right">'.number_format($error2,0).'%</td>';
    echo '<td><img src="'.barra($error2).'" width="'.min(100,$error2).'" style="height:16px;"></td>';
    echo '<td align="right">'.$pPart.'</td><td align="right">'.$row['participantes_deseados'].'</td>';
    echo '<td align="right">'.round($pBene).'%</td>';
    echo '<td><img src="'.barra($pBene).'" width="'.min(100,$pBene).'" style="height:16px;"></td>';
echo '</tr>';
$fila++;
endforeach;
?>
</tbody></table></body></html>