<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión.";
    exit;
}
require_once "../back/conexion.php";
require_once "../back/modIntPry.php";
require_once "../back/filtro_func.php";
// filtros
$f = obtenerFiltros();
$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$Iddpto = $f["Iddpto"];
$Idmnc  = $f["Idmnc"];
$pgn    = $f["pgn"];
// combos
$departamentos = obtenerDepartamentos();
$municipios    = obtenerMunicipios($Iddpto);
// paginación
$totalPaginas = contarPaginas('',$fchInc, $fchFin, $Iddpto, $Idmnc);

// 🔹 vista
require_once "../back/vstIndIntPry.php";