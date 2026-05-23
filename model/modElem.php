<?php
require_once "../functions/conexion.php";
function obtenerElementos($fchInc, $fchFin, $iddpt, $idmnc) {
    $conexion = conectarse();
    $where = "WHERE p.startdate BETWEEN '$fchInc' AND '$fchFin'";
    if (!empty($iddpt)) {
        $where .= " AND d.idspr = '$iddpt'";
    }
    if (!empty($idmnc)) {
        $where .= " AND m.idsst = '$idmnc'";
    }
    $sql = "SELECT 
        d.name AS departamento,
        m.name AS municipio,
        j.name AS junta,
        e.idelement,
        e.addressname AS elemento,
        t.typeelementname AS tipo,
        COUNT(DISTINCT p.idprj) AS total,
        GROUP_CONCAT(DISTINCT p.name ORDER BY p.name SEPARATOR '<br>') AS proyectos,
        GROUP_CONCAT(DISTINCT DATE_FORMAT(p.startdate, '%Y-%m-%d') ORDER BY p.startdate SEPARATOR '<br>') AS fechas_proyectos
    FROM elements e
    INNER JOIN projectelements pe ON pe.idelement = e.idelement
    INNER JOIN projects p ON p.idprj = pe.idprj
    INNER JOIN communities j ON j.idcommunity = p.idcommunity
    INNER JOIN systems m ON m.idsst = j.idsst
    INNER JOIN supersystems d ON d.idspr = m.idspr
    INNER JOIN telementclss c ON e.idelementcls = c.idelementcls
    INNER JOIN telementstypes t ON c.idtype = t.idtype
    $where
    GROUP BY e.idelement, d.name, m.name, j.name, t.typeelementname
    ORDER BY d.name, m.name, j.name, t.typeelementname";
    $result = mysqli_query($conexion, $sql);
    $data = [];
    $maxTotal = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        if ($row['total'] > $maxTotal) {
            $maxTotal = $row['total'];
        }
    }
    mysqli_close($conexion);
    return [
        "data" => $data,
        "maxTotal" => $maxTotal
    ];
}
?>