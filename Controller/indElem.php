<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión. Será redirigido...";
    header("refresh:3;url=../index.php");
    exit;
}

require_once "../functions/filtro_func.php";
require_once "../model/modElem.php";

// 🔹 filtros
$f = obtenerFiltros();

$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$iddpt  = $f["iddpt"];
$idmnc  = $f["idmnc"];
$pgn    = $f["pgn"];

// 🔹 combos
$departamentos = obtenerDepartamentos();
$municipios    = obtenerMunicipios($iddpt);

// 🔹 datos
$resultado = obtenerElementos($fchInc, $fchFin, $iddpt, $idmnc);

$data = $resultado["data"];
$maxTotal = $resultado["maxTotal"];

// 🔹 headers
$headers = ["#", "Super", "Systems", "Community", "IdElm.", "Element", "Type", "Total", "Chart", "Projects", "Dates"];

// 🔹 llamar vista
require_once "../view/vstElem.php";
?>
</body>
</html>