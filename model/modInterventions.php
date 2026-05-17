<?php
function consultarProyectosxMes($fchInc, $fchFin, $iddpt, $idmnc, $pgn) {
$cn = conectarse(); $porPagina = 20; $offset = ($pgn - 1) * $porPagina;
// arma el where
$where = "WHERE p.startdate BETWEEN '$fchInc' AND '$fchFin'";
if ($iddpt !== null && $iddpt !== '') $where .= " AND d.idspr = '$iddpt'";
if ($idmnc !== null && $idmnc !== '') $where .= " AND m.idsst = '$idmnc'";
// Define el SQL
$sql = " SELECT
    p.idprj, p.name AS nombreproyecto, p.beneficiaries,
    d.idspr AS iddepartamento, d.name AS departamento,
    m.name AS municipio, j.name AS junta, DATE_FORMAT(a.date, '%Y-%m') AS mes,
    p.amount AS presupuesto, SUM(a.budget) AS total_presupuesto,
    p.beneficiaries AS personas, SUM(a.participants) AS total_personas,
    p.hours AS horas, SUM(a.hours) AS total_horas,
    p.activities AS actividades, COUNT(a.idact) AS total_actividades
FROM prjact a
JOIN projects p ON a.idprj = p.idprj
JOIN communities j ON p.idcommunity = j.idcommunity
JOIN systems m ON j.idsst = m.idsst
JOIN supersystems d ON m.idspr = d.idspr
$where
GROUP BY p.idprj, YEAR(a.date), MONTH(a.date), d.idspr, d.name,m.name,j.name, p.name, p.beneficiaries, p.amount
ORDER BY d.name, m.name, p.name, mes, p.idprj ";
return $cn->query($sql);
}
function consultarProyectosxJunta($fchInc, $fchFin, $iddpt = null, $idmnc = null, $pgn = 1) {
$cn = conectarse(); $registrosPorPagina = 20; $offset = ($pgn - 1) * $registrosPorPagina;
// arma el where
$where = "WHERE p.startdate BETWEEN '$fchInc' AND '$fchFin'";
if ($iddpt !== null && $iddpt !== '') {
    $where .= " AND d.idspr = '$iddpt'";
}
if ($idmnc !== null && $idmnc !== '') {
    $where .= " AND m.idsst = '$idmnc'";
}
$sqlDetalle = "
SELECT 
d.name AS departamento,
m.name AS municipio,
j.name AS junta,
MIN(p.startdate) AS fechainicio,
COUNT(DISTINCT p.idprj) AS proyectos,
GROUP_CONCAT(
    DISTINCT CONCAT(
        p.name,
        ' (',
        DATE_FORMAT(p.startdate, '%Y-%m-%d'),
        ')'
    )
    ORDER BY p.startdate ASC
    SEPARATOR '<br> '
) AS proyectos_fechas,
SUM(p.amount) AS monto,
SUM(p.beneficiaries) AS beneficiarios,
COUNT(pa.idact) AS total_actividades,
COALESCE(SUM(pa.hours),0) AS total_horas
FROM projects p
JOIN communities j
    ON p.idcommunity = j.idcommunity
JOIN systems m
    ON j.idsst = m.idsst
JOIN supersystems d
    ON m.idspr = d.idspr
LEFT JOIN prjact pa
    ON pa.idprj = p.idprj
$where
GROUP BY
    d.name,
    m.name,
    j.name
ORDER BY
    d.name,
    m.name,
    j.name
    LIMIT $offset, $registrosPorPagina
    ";
    $rs = $cn->query($sqlDetalle);
    $detalle = [];
    while ($row = $rs->fetch_assoc()) $detalle[] = $row;
    return ["detalle" => $detalle];
}
function consultarProyectosxAño($fchInc, $fchFin, $iddpt, $idmnc, $pgn) {
    $cn = conectarse();
    $porPagina = 20;
    $offset = ($pgn - 1) * $porPagina;
    $where = "WHERE v.startdate BETWEEN '$fchInc' AND '$fchFin'";
    if ($iddpt !== null && $iddpt !== '') {
        $where .= " AND idspr = '$iddpt'";
    }
    if ($idmnc !== null && $idmnc !== '') {
        $where .= " AND idsst = '$idmnc'";
    }
$sql = "
SELECT 
    v.year AS anio,
    v.supersystem AS departamento,
    v.system AS municipio,
    v.community AS vereda,

    COUNT(DISTINCT v.idprj) AS total_proyectos,

    GROUP_CONCAT(
        DISTINCT CONCAT(
            p.name,
            ' (',
            DATE_FORMAT(v.startdate, '%Y-%m-%d'),
            ')'
        )
        ORDER BY v.startdate ASC
        SEPARATOR '<br>'
    ) AS proyectos_fechas,

    SUM(v.totalactivities) AS total_actividades,

    SUM(v.totalhours) AS total_horas,

    SUM(v.totalbudget) AS monto,

    SUM(v.totalparticipants) AS beneficiarios

FROM vprojectsxcommunityxyear v

LEFT JOIN projects p
    ON p.idprj = v.idprj

$where

GROUP BY
    v.year,
    v.supersystem,
    v.system,
    v.community

ORDER BY
    v.supersystem,
    v.system,
    vereda,
    v.year DESC
LIMIT $offset, $porPagina
    ";
//print $sql;
return $cn->query($sql);
}
