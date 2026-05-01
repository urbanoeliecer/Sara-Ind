<?php
// CONSULTA CON FILTRO DE FECHAS
function consultarProyectosxJunta($fchInc, $fchFin, $Iddpto = null, $Idmnc = null, $pgn = 1) {

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
        COUNT(DISTINCT p.idProyecto) AS proyectos,
        GROUP_CONCAT(
            DISTINCT CONCAT(p.nombre, ' (', DATE_FORMAT(p.fechainicio, '%Y-%m-%d'), ')')
            ORDER BY p.fechainicio ASC
            SEPARATOR '<br> '
        ) AS proyectos_fechas,
        SUM(p.monto) AS monto,
        SUM(p.beneficiarios) AS beneficiarios,
        COUNT(pa.idact) AS total_actividades,
        COALESCE(SUM(pa.horas),0) AS total_horas
    FROM proyectos p
    JOIN juntas j 
        ON p.idjunta = j.idjunta
    JOIN municipios m 
        ON j.idmunicipio = m.idmunicipio
    JOIN departamentos d 
        ON m.iddepartamento = d.iddepartamento
    LEFT JOIN pryact pa 
        ON pa.idpry = p.idproyecto
    $where
    GROUP BY 
        d.nombre, 
        m.nombre, 
        j.nombre
    ORDER BY 
        d.nombre, 
        m.nombre, 
        j.nombre
    LIMIT $offset, $registrosPorPagina
    ";

    $rs = $cn->query($sqlDetalle);

    $detalle = [];
    while ($row = $rs->fetch_assoc()) $detalle[] = $row;

    return ["detalle" => $detalle];
}

function consultarProyectosxAño($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn) {
    $cn = conectarse();
    $porPagina = 20;
    $offset = ($pgn - 1) * $porPagina;
    $where = "WHERE v.fechaInicio BETWEEN '$fchInc' AND '$fchFin'";
    if ($Iddpto !== null && $Iddpto !== '') {
        $where .= " AND iddepartamento = '$Iddpto'";
    }
    if ($Idmnc !== null && $Idmnc !== '') {
        $where .= " AND idmunicipio = '$Idmnc'";
    }
$sql = "
SELECT 
    v.anio,
    v.departamento,
    v.municipio,
    v.junta AS vereda,
    COUNT(DISTINCT v.idProyecto) AS total_proyectos,
    GROUP_CONCAT(
        DISTINCT CONCAT(p.nombre, ' (', DATE_FORMAT(v.fechaInicio, '%Y-%m-%d'), ')')
        ORDER BY v.fechaInicio ASC
        SEPARATOR '<br>'
    ) AS proyectos_fechas,
    SUM(v.total_actividades) AS total_actividades,
    SUM(v.total_horas) AS total_horas,
    SUM(v.total_presupuesto) AS monto,
    SUM(v.total_beneficiarios) AS beneficiarios
FROM vproyectosxjuntaxanio v
LEFT JOIN proyectos p 
    ON p.idproyecto = v.idProyecto
$where
GROUP BY 
    v.anio, 
    v.departamento, 
    v.municipio, 
    v.junta
ORDER BY 
    v.departamento, 
    v.municipio, 
    vereda, 
    v.anio DESC
LIMIT $offset, $porPagina
    ";
$sql;
return $cn->query($sql);
}

function consultarProyectosxMes($fchInc, $fchFin, $Iddpto, $Idmnc, $pgn) {
$cn = conectarse();
$porPagina = 20;
$offset = ($pgn - 1) * $porPagina;
$where = "WHERE p.fechaInicio BETWEEN '$fchInc' AND '$fchFin'";
if ($Iddpto !== null && $Iddpto !== '') {
    $where .= " AND d.iddepartamento = '$Iddpto'";
}
if ($Idmnc !== null && $Idmnc !== '') {
    $where .= " AND m.idmunicipio = '$Idmnc'";
}
$sql = "
SELECT
    p.idproyecto,
    p.nombre AS nombreproyecto,
    p.beneficiarios,
    d.iddepartamento,
    d.nombre AS departamento,
    m.nombre AS municipio,
    j.nombre AS junta,
    DATE_FORMAT(a.fecha, '%Y-%m') AS mes,
    p.monto AS presupuesto,
    SUM(a.presupuesto) AS total_presupuesto,
    p.beneficiarios as personas,
    SUM(a.cntpersonas) AS total_personas,
    p.horas as horas,
    SUM(a.horas) AS total_horas,
    p.actividades as actividades,
    COUNT(a.idact) AS total_actividades
FROM pryact a
JOIN proyectos p ON a.idpry = p.idproyecto
JOIN juntas j ON p.idjunta = j.idjunta
JOIN municipios m ON j.idmunicipio = m.idmunicipio
JOIN departamentos d ON m.iddepartamento = d.iddepartamento
$where
GROUP BY
    p.idproyecto,
    YEAR(a.fecha),
    MONTH(a.fecha),
    d.iddepartamento,
    d.nombre,
    m.nombre,
    j.nombre,
    p.nombre,
    p.beneficiarios,
    p.monto
ORDER BY d.nombre, m.nombre, p.nombre, mes, p.idproyecto
";
return $cn->query($sql);
}