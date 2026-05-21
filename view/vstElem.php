<html lang="es">
<head>
<meta charset="UTF-8">
<title>SARA - Ind. de Elementos</title>
<link rel="stylesheet" href="../functions/estilos.css">
</head>
<body>

<a href="../principal.php">Principal</a>
<h2>Ind. de Elementos</h2>

<?php require_once "../functions/filtro.php"; ?>

<table>
<tr>
<?php foreach($headers as $h): ?>
    <th><?= $h ?></th>
<?php endforeach; ?>
</tr>

<?php
$anchoMaximo = 300;
$fila = 1;

foreach ($data as $row):

    $porcentaje = ($maxTotal > 0) ? ($row['total'] / $maxTotal) * 100 : 0;
    $anchoBarra = ($maxTotal > 0) ? ($row['total'] / $maxTotal) * $anchoMaximo : 0;
?>

<tr>
    <td><?= $fila ?></td>
    <td><?= $row['departamento'] ?></td>
    <td><?= $row['municipio'] ?></td>
    <td><?= $row['junta'] ?></td>
    <td><?= $row['idelement'] ?></td>
    <td><?= $row['elemento'] ?></td>
    <td><?= $row['tipo'] ?></td>
    <td align="center"><?= $row['total'] ?></td>

    <td>
        <img src="../img/barra.png" width="<?= intval($anchoBarra) ?>" height="20">
        <?= round($porcentaje,1) ?>%
    </td>

    <td><?= $row['proyectos'] ?></td>
    <td><?= $row['fechas_proyectos'] ?></td>
</tr>

<?php
$fila++;
endforeach;
?>
</table>
