<?php
require_once "../functions/conexion.php";

function obtenerIntervencionGeneral($fchInc, $fchFin, $iddpt, $idmnc, $offset, $porPagina) {

    $conexion = conectarse();

    $where = "WHERE v.startdate BETWEEN '$fchInc' AND '$fchFin'";

    if (!empty($iddpt)) {
        $where .= " AND v.idspr = '$iddpt'";
    }
    if (!empty($idmnc)) {
        $where .= " AND v.idsst = '$idmnc'";
    }

$w_proyectos = 0.4;
$w_presupues = 0.3;
$w_participa = 0.3;
$sql = "SELECT v.supersystem AS departamento,
    v.system AS municipio, v.community AS vereda, YEAR(a.date) AS anio,
    GROUP_CONCAT(DISTINCT CONCAT(p.name,'(',DATE_FORMAT(p.startdate,'%Y-%m-%d'),')')
                 ORDER BY p.startdate ASC SEPARATOR '<br>') AS proyectos_fechas,
    COUNT(DISTINCT a.idprj) AS total_proyectos, SUM(a.budget) AS monto, 
    SUM(a.participants) AS participantes, COUNT(a.idact) AS total_actividades,
    IFNULL(cd.projects,0) AS proyectos_deseados,
    IFNULL(cd.budget,0) AS presupuesto_deseado,
    IFNULL(cd.participants,0) AS participantes_deseados,(
        ".$w_proyectos."*IF(cd.projects > 0,COUNT(DISTINCT a.idprj) / cd.projects, 0)
      + ".$w_presupues."*IF(cd.budget > 0, SUM(a.budget) / cd.budget, 0)
      + ".$w_participa."*IF(cd.participants > 0 AND COUNT(a.idact) > 0,
          (SUM(a.participants)/NULLIF(COUNT(a.idact),0))/cd.participants,0))*100 AS GII
FROM prjact a
INNER JOIN vprojectsxcommunityxyear v ON v.idprj = a.idprj
INNER JOIN projects p ON p.idprj = v.idprj
LEFT JOIN comm_dsc cd ON cd.idcommunity = v.idcommunity
$where
GROUP BY v.supersystem,v.system,v.community,YEAR(a.date)
UNION ALL
SELECT v.supersystem AS departamento, v.system AS municipio, v.community AS vereda, 'TOTAL' AS anio,
    GROUP_CONCAT(DISTINCT CONCAT(p.name, ' (', DATE_FORMAT(p.startdate, '%Y-%m-%d'), ')')
                 ORDER BY p.startdate ASC SEPARATOR '<br>') AS proyectos_fechas,
    COUNT(DISTINCT a.idprj), SUM(a.budget), SUM(a.participants), COUNT(a.idact),
    IFNULL(cd.projects,0), IFNULL(cd.budget,0),
    IFNULL(cd.participants,0),(
        ".$w_proyectos."*IF(cd.projects > 0,COUNT(DISTINCT a.idprj) / cd.projects, 0)
      + ".$w_presupues."*IF(cd.budget > 0,SUM(a.budget) / cd.budget, 0)
      + ".$w_participa."*IF(cd.participants > 0 AND COUNT(a.idact) > 0,
          (SUM(a.participants) / NULLIF(COUNT(a.idact),0)) / cd.participants,0))*100
FROM prjact a
INNER JOIN vprojectsxcommunityxyear v ON v.idprj = a.idprj
INNER JOIN projects p ON p.idprj = v.idprj
LEFT JOIN comm_dsc cd ON cd.idcommunity = v.idcommunity
$where
GROUP BY v.supersystem, v.system, v.community
ORDER BY departamento, municipio, vereda, anio
LIMIT $offset, $porPagina";
// print $sql;


    $result = mysqli_query($conexion, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conexion);

    return $data;
}
?>