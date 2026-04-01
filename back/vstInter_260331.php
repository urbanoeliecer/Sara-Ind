<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require_once __DIR__ . "/conexion.php";
header('Content-Type: application/json');
require_once "modInter.php";
$accion = $_GET['accion'] ?? '';
switch ($accion) {
    case 'departamentos':
        echo json_encode(obtenerDepartamentos());
        break;
    case 'municipios':
        $iddepartamento = $_GET['iddepartamento'] ?? null;
        echo json_encode(obtenerMunicipios($iddepartamento));
        break;
    case 'juntas':
        $idmunicipio = $_GET['idmunicipio'] ?? null;
        echo json_encode(obtenerJuntas($idmunicipio));
        break;
    case 'consultar':
        $fecha_inicio  = $_POST['fecha_inicio']  ?? null;
        $fecha_fin     = $_POST['fecha_fin']     ?? null;
        $iddepartamento = $_POST['iddepartamento'] ?? null;
        $idmunicipio    = $_POST['idmunicipio']    ?? null;
        $idjunta        = $_POST['idjunta']        ?? null;
        echo json_encode(
            consultarProyectos(
                $fecha_inicio,
                $fecha_fin,
                $iddepartamento,
                $idmunicipio,
                $idjunta
            )
        );
        break;
    default:
        echo json_encode([]);
}