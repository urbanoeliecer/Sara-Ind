<?php
function conect() {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $bd = "bdsaraind";     
    if (!($cn= mysqli_connect($servername,$username,$password,$bd,3306))){
        echo "Error conectando a la base de datos.";
        exit();
    }
   if (!mysqli_select_db($cn,$bd)){
        echo "Error seleccionando la base de datos.";
        exit();
   }
   return $cn;
}
//Departamentos
function obtenerDepartamentos() {
    $cn = conect();
    $sql = "SELECT iddepartamento, nombre FROM departamentos";
    $rs = $cn->query($sql);

    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}
//Municipios
function obtenerMunicipios($iddepartamento) {
    if (!$iddepartamento) return [];
    $cn = conect();
    $sql = "
        SELECT idmunicipio, nombre
        FROM municipios
        WHERE iddepartamento = '$iddepartamento'
    ";
    $rs = $cn->query($sql);
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
// JUNTAS
function obtenerJuntas($idmunicipio) {
    if (!$idmunicipio) return [];
    $cn = conect();
    $sql = "
        SELECT idjunta, nombre
        FROM juntas
        WHERE idmunicipio = '$idmunicipio'
    ";
    $rs = $cn->query($sql);
    $data = [];
    while ($row = $rs->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
// CONSULTA DE PROYECTOS
function consultarProyectos($fi, $ff) { //, $dep, $mun, $jun
    $cn = conect();
    /* ===== FILTROS DINÁMICOS ===== */
//    $where = "WHERE p.fechainicio BETWEEN '$fi' AND '$ff'";
//    if ($dep) {
//        $where .= " AND d.iddepartamento = '$dep'";
//    }
//    if ($mun) {
//        $where .= " AND m.idmunicipio = '$mun'";
//    }
//    if ($jun) {
//        $where .= " AND j.idjunta = '$jun'";
//    }
    /* ===== RESUMEN ===== */
    $sqlResumen = "
        SELECT
            COUNT(*) AS total_proyectos,
            SUM(p.monto) AS total_monto,
            SUM(p.beneficiarios) AS total_beneficiarios
        FROM proyectos p
        JOIN juntas j ON p.idjunta = j.idjunta
        JOIN municipios m ON j.idmunicipio = m.idmunicipio
        JOIN departamentos d ON m.iddepartamento = d.iddepartamento
        ";
        //$where
    //print $sqlResumen;
    //exit();
    $resResumen = $cn->query($sqlResumen);
    if (!$resResumen) {
        return ["error" => $cn->error];
    }
    $resumen = $resResumen->fetch_assoc();
    /* ===== DETALLE ===== */
    $sqlDetalle = "
        SELECT
            p.nombre AS proyecto,
            p.monto,
            p.beneficiarios,
            j.nombre AS junta,
            m.nombre AS municipio,
            d.nombre AS departamento
        FROM proyectos p
        JOIN juntas j ON p.idjunta = j.idjunta
        JOIN municipios m ON j.idmunicipio = m.idmunicipio
        JOIN departamentos d ON m.iddepartamento = d.iddepartamento
        ORDER BY d.nombre, m.nombre, j.nombre
    ";
    //$where
    $rs = $cn->query($sqlDetalle);
    if (!$rs) {
        return ["error" => $cn->error];
    }
    $detalle = [];
    while ($row = $rs->fetch_assoc()) {
        $detalle[] = $row;
    }
    return [
        "resumen" => $resumen,
        "detalle" => $detalle
    ];
}