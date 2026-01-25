<?php
function mostrarTablaActividades($datos) {
?>
<table >
<tr>
    <th>#</th>
    <th>Id</th>
    <th>Proyecto</th>

    <th>Depart.</th>
    <th>Municipio</th>
    <th>Junta</th>
    <th>Mes</th>
    <th>Ejec.</th>
    <th>Pres.</th>
    <th>-
    <th>Prm.</th>
    <th>Benef.</th>
    <th>-
    <th>Cant. Horas</th>
    <th>Cant. Activ.</th>
</tr><?php
$i = 1;
if (!empty($datos)):
    foreach ($datos as $row):
        echo '<tr>';
        $i++;
        echo '<td>'.$i.'</td>';
        echo '<td>'.$row["idproyecto"].'</td>';
        echo '<td>'.$row["nombreproyecto"].'</td>';

        echo '<td>'.$row["departamento"].'</td>';
        echo '<td>'.$row["municipio"].'</td>';
        echo '<td>'.$row["junta"].'</td>';
        echo '<td>'.$row["mes"].'</td>';
        echo '<td>'.$row["total_presupuesto_actividades"].'</td>';
        echo '<td>'.$row["presupuesto_proyecto"].'</td>';
        echo '<td>';
        if ($row['presupuesto_proyecto'] > 0) 
             $var = round($row['total_presupuesto_actividades']*50/$row['presupuesto_proyecto'],0);
        else $var = 0;
        echo '<img src="../img/barra.png" height="12" width="'.$var.'"> '.$var.'%';
        echo '</td>';
        echo '<td>'.$row['total_personas'];
        echo '<td>'.$row['beneficiarios'].'</td>';
        if ($row['beneficiarios'] > 0) 
             $var = round((($row['total_personas']*100)/$row['total_actividades'])/$row['beneficiarios'],1);
        else $var = 0;  
        echo '<td><img src="../img/barra.png" height="12" width="'.$var.'"> '.$var.'%'; // = ('.$row["total_personas"].'/'.$row["total_actividades"].')/'.$row["beneficiarios"];
        echo '<td>'.$row['total_horas'].'</td>';
        echo '<td>'.$row['total_actividades'].'</td>';
        echo '</tr>';
    endforeach;
else:
?>
<tr><td colspan="13">No hay información</td></tr>
<?php endif; ?>
</table>
<?php
}
//print_r($datos);
mostrarTablaActividades($datos); 
