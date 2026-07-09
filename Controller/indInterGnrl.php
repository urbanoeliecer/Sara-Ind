<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión...";
    header("refresh:3;url=../index.php");
    exit;
}

require_once "../functions/filtro_func.php";
require_once "../model/modInterGnrl.php";

// filtros
$f = obtenerFiltros();

$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$iddpt  = $f["iddpt"];
$idmnc  = $f["idmnc"];
$pgn    = $f["pgn"];

// combos
$departamentos = obtenerDepartamentos();
$municipios    = obtenerMunicipios($iddpt);

// paginación
$porPagina = 30;
$offset = ($pgn - 1) * $porPagina;

// datos
$data = obtenerIntervencionGeneral($fchInc, $fchFin, $iddpt, $idmnc, $offset, $porPagina);


// funciones auxiliares
function porcentaje($real, $deseado) {
    if ($deseado <= 0) return 0;
    return ($real / $deseado) * 100;
}

function barra($porcentaje) {
    if ($porcentaje < 60) return '../img/barraroja.png';
    if ($porcentaje < 75) return '../img/barranaranja.png';
    return '../img/barraverde.png';
}

// llamar vista
require_once "../view/vstInterGnrl.php";
?>