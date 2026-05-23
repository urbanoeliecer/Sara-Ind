<html lang="es">
<head>
<meta charset="UTF-8">
<title>SARA - Ind. de Intervención General</title>
<link rel="stylesheet" href="../functions/estilos.css">
</head><body>
<a href="../principal.php">Principal</a>
<h2>Ind. General de Intervención</h2>
<?php require_once "../functions/filtro.php"; ?>
<table><thead><tr>
<?php foreach($headers as $h): ?>
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
?>
<tr <?= ($row['anio'] == 'TOTAL') ? 'style="background-color:#d9edf7;"' : '' ?>>
    <td><?= $fila ?></td>
    <td><?= $row['departamento'] ?></td>
    <td><?= $row['municipio'] ?></td>
    <td><?= $row['vereda'] ?></td>
    <td><?= $row['anio'] ?></td>
    <td><strong><?= round($row['GII']) ?>%</strong></td>
    <td><img src="<?= barra($row['GII']) ?>" width="<?= min(100,$row['GII']) ?>%" style="height:16px;"></td>
    <td><?= $row['total_actividades'] ?></td>
    <td><?= $row['proyectos_fechas'] ?></td>
    <td><?= $row['total_proyectos'] ?></td>
    <td><?= $row['proyectos_deseados'] ?></td>
    <td><?= round($pProy) ?>%</td>
    <td><img src="<?= barra($pProy) ?>" width="<?= min(100,$pProy) ?>%" style="height:16px;"></td>
    <td><?= number_format($row['monto'],0) ?></td>
    <td><?= number_format($row['presupuesto_deseado'],0) ?></td>
    <td><?= round($pPres) ?>%</td>
    <td><img src="<?= barra($pPres) ?>" width="<?= min(100,$pPres) ?>%" style="height:16px;"></td>
    <td><?= $pPart ?></td>
    <td><?= $row['participantes_deseados'] ?></td>
    <td><?= round($pBene) ?>%</td>
    <td><img src="<?= barra($pBene) ?>" width="<?= min(100,$pBene) ?>%" style="height:16px;"></td>
</tr><?php
$fila++;
endforeach;
?>
</tbody></table></body></html>