<?php
$rol = $_GET['rol'] ?? 0;
?>
<html lang="es">
<head>
<meta charset="utf-8">
<title>SARA - Ind. de Intervenciones Consoliado</title>
<link rel="stylesheet" href="../back/estilos.css">
<script src="../back/vstInter.js"></script>
</head>
<body>
<a href="../principal.php">Principal</a><br>
<h2>Ind. de Intervenciones planteadas</h2>
<form id="formFiltros">
    <input type="hidden" name="rol" value="<?= $rol ?>">
    Fecha inicio: <input type="date" id="fecha_inicio" name="fecha_inicio">
    Fecha final:  <input type="date" id="fecha_fin" name="fecha_fin">
    <br><br>
    Departamento: <select name="iddepartamento" id="departamento" onchange="cargarMunicipios()"></select>
    Municipio: <select name="idmunicipio" id="municipio" onchange="cargarJuntas()"></select>
    Junta: <select name="idjunta" id="junta"></select>
    <button type="submit" id="consultar">Consultar</button>
</form>
<!-- Resumen y Detalles de los Proyectos -->
<div id="resumen"></div>
<div id="detalle"></div>
<script>
    // Función para validar y habilitar el botón de envío
    function validar() {
        var dep = document.getElementById("departamento").value;
        var mun = document.getElementById("municipio").value;
        var jun = document.getElementById("junta").value;
        var btn = document.getElementById("btn");

        // Habilitar el botón si los tres campos están seleccionados
        if (dep && mun && jun) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }
</script>
</body>
</html>