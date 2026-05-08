<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    echo "Debe iniciar sesión. Será redirigido al <a href='../index.php'>login</a>.";
    header("refresh:3;url=../index.php");
    exit;
}
// dependencias
require_once "../back/conexion.php"; 
require_once "../back/ModActiv.php";
require_once "../back/filtro_func.php";

// 1. obtener filtros (CENTRALIZADO)
$f = obtenerFiltros();
$fchInc = $f["fchInc"];
$fchFin = $f["fchFin"];
$iddpt = $f["iddpt"];
$idmnc  = $f["idmnc"];
$pgn    = $f["pgn"];
// 2. combos para el filtro
$departamentos = obtenerDepartamentos();
$municipios    = obtenerMunicipios($iddpt);
// 3. paginación
$totalPaginas = contarPaginas('',$fchInc, $fchFin, $iddpt, $idmnc);
// 4. cargar vista
require_once "../back/vstActiv.php"; ?>
</body>
</html>