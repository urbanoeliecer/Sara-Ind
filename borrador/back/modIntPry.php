<?php
// CONSULTA CON FILTRO DE FECHAS
function consultarProyectos($fchInc, $fchFin, $Iddpto = null, $Idmnc = null, $pgn = 1) {

    $cn = conectarse();

    $registrosPorPagina = 10;
    $offset = ($pgn - 1) * $registrosPorPagina;

    $where = "WHERE p.fechainicio BETWEEN '$fchInc' AND '$fchFin'";

    if ($Iddpto !== null && $Iddpto !== '') {
        $where .= " AND d.iddepartamento = '$Iddpto'";
    }
    if ($Idmnc !== null && $Idmnc !== '') {
        $where .= " AND m.idmunicipio = '$Idmnc'";
    }

    $sqlDetalle = "
        SELECT
            d.nombre AS departamento,
            m.nombre AS municipio,
            j.nombre AS junta,
            MIN(p.fechainicio) AS fechainicio,
            COUNT(*) AS proyecto,
            SUM(p.monto) AS monto,
            SUM(p.beneficiarios) AS beneficiarios
        FROM proyectos p
        JOIN juntas j ON p.idjunta = j.idjunta
        JOIN municipios m ON j.idmunicipio = m.idmunicipio
        JOIN departamentos d ON m.iddepartamento = d.iddepartamento
        $where
        GROUP BY d.nombre, m.nombre, j.nombre
        ORDER BY d.nombre, m.nombre, j.nombre
        LIMIT $offset, $registrosPorPagina
    ";

    $rs = $cn->query($sqlDetalle);

    $detalle = [];
    while ($row = $rs->fetch_assoc()) $detalle[] = $row;

    return ["detalle" => $detalle];
}