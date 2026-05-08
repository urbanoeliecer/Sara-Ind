<?php
require_once __DIR__ . "/conexion.php";
// FILTROS
function obtenerFiltros() {
    $fchInc = (!empty($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '2024-12-01';
    $fchFin = $_POST['fecha_fin'] ?? '9999-12-31';
    $Iddpto = $_POST['idspr'] ?? null;
    $Idmnc  = $_POST['idsst'] ?? null;
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
    $rs = $cn->query("SELECT idspr, name FROM supersystems ORDER BY name");
    $data = [];
    while ($row = $rs->fetch_assoc()) $data[] = $row;
    return $data;
}

// MUNICIPIOS (dependen del departamento)
function obtenerMunicipios($Iddpto = null) {
    $cn = conectarse();
    $where = "";
    if ($Iddpto !== null && $Iddpto !== '') {
        $where = "WHERE idspr = '$Iddpto'";
    }

    $rs = $cn->query("SELECT idsst, name FROM systems $where ORDER BY name");

    $data = [];
    while ($row = $rs->fetch_assoc()) $data[] = $row;
    return $data;
}

// PAGINACIÓN
function contarPaginas($tipoInforme,$fchInc, $fchFin, $Iddpto = null, $Idmnc = null) {
$cn = conectarse();

$where = "WHERE p.startdate BETWEEN '$fchInc' AND '$fchFin'";

if ($Iddpto !== null && $Iddpto !== '') {
    $where .= " AND d.idspr = '$Iddpto'";
}

if ($Idmnc !== null && $Idmnc !== '') {
    $where .= " AND m.idsst = '$Idmnc'";
}

switch ($tipoInforme) {

    // 🔵 INFORME 1: por comunidades
    case 'juntas':

        $sql = "SELECT COUNT(*) as total
            FROM (
                SELECT j.idcommunity
                FROM projects p
                JOIN communities j ON p.idcommunity = j.idcommunity
                JOIN systems m ON j.idsst = m.idsst
                JOIN supersystems d ON m.idspr = d.idspr
                $where
                GROUP BY j.idcommunity
            ) t";

    break;

    // 🔵 INFORME 2: por elemento
    case 'elementos':

        $sql = "
            SELECT COUNT(*) as total
            FROM (
                SELECT e.idelement
                FROM elements e
                JOIN projectelements pe ON pe.idelement = e.idelement
                JOIN projects p ON p.idproject = pe.idproject
                JOIN communities j ON j.idcommunity = p.idcommunity
                JOIN systems m ON j.idsst = m.idsst
                JOIN supersystems d ON m.idspr = d.idspr
                $where
                GROUP BY e.idelement
            ) t
        ";

    break;

    // 🔵 INFORME 3: GII
    case 'Gii':

        $sql = "
            SELECT COUNT(*) as total
            FROM (
                SELECT v.community, YEAR(a.date)
                FROM prjact a
                JOIN vprojectsxcommunityxyear v ON v.idproject = a.idprj
                JOIN projects p ON p.idproject = v.idproject
                JOIN communities j ON j.idcommunity = p.idcommunity
                JOIN systems m ON j.idsst = m.idsst
                JOIN supersystems d ON m.idspr = d.idspr
                $where
                GROUP BY v.community, YEAR(a.date)
            ) t
        ";

    break;

    // 🔴 DEFAULT
    default:

        $sql = "SELECT 1 as total";

    break;
}

$sql = "
    SELECT COUNT(*) as total
    FROM (
        SELECT j.idcommunity
        FROM projects p
        JOIN communities j ON p.idcommunity = j.idcommunity
        JOIN systems m ON j.idsst = m.idsst
        JOIN supersystems d ON m.idspr = d.idspr
        $where
        GROUP BY j.idcommunity
    ) t
";
$row = $cn->query($sql)->fetch_assoc();
    $registrosPorPagina = 10;
    return max(1, ceil($row['total'] / $registrosPorPagina));
}