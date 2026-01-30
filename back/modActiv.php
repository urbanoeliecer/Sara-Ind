<?php
class ActividadModel {
private $pdo;
public function __construct($pdo) {
    $this->pdo = $pdo;
}
public function obtenerInforme($fechaInicio, $fechaFin, $idDepartamento = null) {
$sql = "
SELECT
    p.idproyecto,
    p.nombre AS nombreproyecto,
    p.beneficiarios,
    d.iddepartamento,
    d.nombre AS departamento,
    m.nombre AS municipio,
    j.nombre AS junta,
    DATE_FORMAT(a.fecha, '%Y-%m') AS mes,
    p.monto AS presupuesto_proyecto,
    SUM(a.presupuesto) AS total_presupuesto_actividades,
    SUM(a.cntpersonas) AS total_personas,
    SUM(a.horas) AS total_horas,
    COUNT(a.idact) AS total_actividades
FROM pryact a
JOIN proyectos p ON a.idpry = p.idproyecto
JOIN juntas j ON p.idjunta = j.idjunta
JOIN municipios m ON j.idmunicipio = m.idmunicipio
JOIN departamentos d ON m.iddepartamento = d.iddepartamento
GROUP BY
    p.idproyecto,
    YEAR(a.fecha),
    MONTH(a.fecha),
    d.iddepartamento,
    d.nombre,
    m.nombre,
    j.nombre,
    p.nombre,
    p.beneficiarios,
    p.monto
ORDER BY d.nombre, m.nombre, j.nombre, mes, p.idproyecto
";
// print $sql;
        $stmt = $this->pdo->prepare($sql);
//        $stmt->bindValue(':fecha_inicio', $fechaInicio);
//        $stmt->bindValue(':fecha_fin', $fechaFin);
//        $stmt->bindValue(
//            ':iddepartamento',
//            $idDepartamento ?: null,
//            $idDepartamento ? PDO::PARAM_INT : PDO::PARAM_NULL
//        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
