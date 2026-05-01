<?php function consultarCorelEjec($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn) {
    $cn = conectarse();
    $porPagina = 20;
    $offset = ($pgn - 1) * $porPagina;
    $where = "WHERE fechaInicio BETWEEN '$fchInc' AND '$fchFin'";
    if ($Iddpto !== null && $Iddpto !== '') {
        $where .= " AND iddepartamento = '$Iddpto'";
    }
    if ($Idmnc !== null && $Idmnc !== '') {
        $where .= " AND idmunicipio = '$Idmnc'";
    }
    $sql = "
        SELECT anio, departamento, municipio, junta AS vereda, COUNT(DISTINCT idProyecto) AS total_proyectos, SUM(total_actividades) AS total_actividades, SUM(total_presupuesto) AS monto, SUM(total_beneficiarios) AS beneficiarios
        FROM vproyectosxjuntaxanio
        $where
        GROUP BY anio, departamento, municipio, junta 
        ORDER BY  departamento, municipio, vereda, anio DESC
        LIMIT $offset, $porPagina
    ";
    //print $sql;
    return $cn->query($sql);
}
?>