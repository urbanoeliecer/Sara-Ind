<?php
require_once __DIR__ . "/conexion.php";
// FILTROS
function obtenerFiltros() {
    $fchInc = (!empty($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '2024-12-01';
    $fchFin = $_POST['fecha_fin'] ?? '9999-12-31';
    $Iddpto = $_POST['iddepartamento'] ?? null;
    $Idmnc  = $_POST['idmunicipio'] ?? null;
    $pgn    = max(1, ($_POST['pagina'] ?? 1));
    if ($fchInc && $fchFin && $fchInc > $fchFin) {
        echo "Error: rango de fechas inválido";
        exit;
    }
    return compact("fchInc", "fchFin", "Iddpto", "Idmnc", "pgn");
}

// DEPARTAMENTOS
function obtenerDepartamentos() {
    $cn = conectarse();
    $rs = $cn->query("SELECT iddepartamento, nombre FROM departamentos ORDER BY nombre");
    $data = [];
    while ($row = $rs->fetch_assoc()) $data[] = $row;
    return $data;
}

// MUNICIPIOS (dependen del departamento)
function obtenerMunicipios($Iddpto = null) {
    $cn = conectarse();
    $where = "";
    if ($Iddpto !== null && $Iddpto !== '') {
        $where = "WHERE iddepartamento = '$Iddpto'";
    }

    $rs = $cn->query("SELECT idmunicipio, nombre FROM municipios $where ORDER BY nombre");

    $data = [];
    while ($row = $rs->fetch_assoc()) $data[] = $row;
    return $data;
}

// PAGINACIÓN
function contarPaginas($fchInc, $fchFin, $Iddpto = null, $Idmnc = null) {
    $cn = conectarse();
    $where = "WHERE p.fechainicio BETWEEN '$fchInc' AND '$fchFin'";
    if ($Iddpto !== null && $Iddpto !== '') {
        $where .= " AND d.iddepartamento = '$Iddpto'";
    }
    if ($Idmnc !== null && $Idmnc !== '') {
        $where .= " AND m.idmunicipio = '$Idmnc'";
    }
    $sql = "
        SELECT COUNT(*) as total
        FROM (
            SELECT j.idjunta
            FROM proyectos p
            JOIN juntas j ON p.idjunta = j.idjunta
            JOIN municipios m ON j.idmunicipio = m.idmunicipio
            JOIN departamentos d ON m.iddepartamento = d.iddepartamento
            $where
            GROUP BY j.idjunta
        ) t
    ";
    $row = $cn->query($sql)->fetch_assoc();
    $registrosPorPagina = 10;
    return max(1, ceil($row['total'] / $registrosPorPagina));
}