<html lang="es">
<head>
<meta charset="UTF-8">
<title>SARA II - Indicadores de Gestión Comunitaria Rural</title>
<link rel="stylesheet" href="../back/estilos.css">
</head>
<body>
<table width="100%" cellpadding="15">
<tr>
    <td width="65%" valign="top" rowspan="3">
        <h2>SARA II - Descripción</h2>
        Aplicativo web basado en arquitectura orientada a servicios para la medición del impacto
        de proyectos de infraestructura rural en juntas de acción comunal veredales.
        <br><br>
        Su descripción es presentada en: <a href="https://sara-indicadores.readthedocs.io">MkDocs</a> 
        y su repositorio de código en: <a href="https://github.com/urbanoeliecer/Sara00">Git</a>
        <br><br>
        Este aplicativo permite la generación de informes e indicadores de intervención en
        infraestructura rural a partir de la información gestionada en <a href="https://acofipapers.org/index.php/eiei/article/view/4844">SARA 1.0</a>, una arquitectura
        en la nube orientada a la administración de proyectos comunitarios rurales, compuesta por un sistema de
        información que favorece la gestión de proyectos comunitarios veredales ejecutados por
        las Juntas de Acción Comunal (JAC), con el apoyo de entidades territoriales.
        <br><br>
        En este contexto, SARA 2.0 amplía las capacidades del sistema original al ofrecer un módulo
        especializado para el análisis de indicadores, utilizando datos registrados en SARA 1.0.
        <br><br>
        Los indicadores que se agregaron a SARA 1.0 son generados por parte del administrador,
        quien supervisa al secretario de infraestructura municipal tenoendo así la medición del impacto de los proyectos.
    </td>
    <td width="35%" valign="top">
        <h2>Ingreso</h2>
        <form action="loginRev.php" method="POST">
            <table>
                <tr>
                    <td>Usuario:</td>
                    <td><input type="text" name="txtusr" size="12"></td>
                </tr>
                <tr>
                    <td>Contraseña:</td>
                    <td><input type="password" name="txtpass" size="12"></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Continuar">
        </form>
        Al ingresar podrá consultar:
        <ul>
            <li>Indicador de Intervención Correlacional</li>
            <li>Indicador General de Intervención</li>
            <li>Informe de Proyectos por JAC</li>
            <li>Informe Mensual de Actividades por Proyecto</li>
            <li>Informe de Infraestructura</li>
        </ul>
<tr>    
    <td align="center">
        Desarrollado en el proyecto 4271 de la VIE<br><br>Elaborado por:<br>
        <strong>Urbano Eliécer Gómez-Prada</strong><br>
        Escuela de Ingeniería de Sistemas<br>Universidad Industrial de Santander<br>Bucaramanga – Colombia<br>
        <a href="mailto:uegomezp@uis.edu.co">uegomezp@uis.edu.co</a><br>2026
    </td>
</tr>
</table>
</body>
</html>
