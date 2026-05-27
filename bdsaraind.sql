-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-05-2026 a las 03:35:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdsaraind`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `communities`
--

CREATE TABLE `communities` (
  `idcommunity` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `idsst` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `communities`
--

INSERT INTO `communities` (`idcommunity`, `name`, `idsst`) VALUES
(1, 'Sin Asignar', 1),
(2, 'Community 01', 2),
(3, 'Community 02', 5),
(4, 'Community 03', 6),
(5, 'Community 04', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comm_dsc`
--

CREATE TABLE `comm_dsc` (
  `idcommunitydesc` int(11) NOT NULL,
  `idcommunity` int(11) NOT NULL,
  `projects` int(11) NOT NULL DEFAULT 0,
  `participants` int(11) NOT NULL DEFAULT 0,
  `budget` int(11) NOT NULL DEFAULT 0,
  `fecharegistro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `comm_dsc`
--

INSERT INTO `comm_dsc` (`idcommunitydesc`, `idcommunity`, `projects`, `participants`, `budget`, `fecharegistro`, `estado`) VALUES
(1, 2, 3, 10, 18000, '2026-01-21 02:09:19', 1),
(2, 3, 2, 8, 8000, '2026-01-21 02:09:19', 1),
(3, 4, 2, 8, 8000, '2026-01-21 02:09:19', 1),
(4, 5, 1, 7, 8000, '2026-01-21 02:09:19', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comm_weights`
--

CREATE TABLE `comm_weights` (
  `idcmnwgt` int(11) NOT NULL,
  `idcmn` int(11) NOT NULL,
  `pB` decimal(1,1) NOT NULL DEFAULT 0.0,
  `pT` decimal(1,1) NOT NULL DEFAULT 0.0,
  `PU` decimal(1,1) NOT NULL DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comm_weights`
--

INSERT INTO `comm_weights` (`idcmnwgt`, `idcmn`, `pB`, `pT`, `PU`) VALUES
(1, 1, 0.4, 0.3, 0.3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elements`
--

CREATE TABLE `elements` (
  `idelement` int(11) NOT NULL,
  `idelementcls` int(11) NOT NULL,
  `addressname` varchar(30) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL,
  `dateregister` date NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `idcommunity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `elements`
--

INSERT INTO `elements` (`idelement`, `idelementcls`, `addressname`, `latitude`, `longitude`, `image`, `dateregister`, `state`, `idcommunity`) VALUES
(1, 2, 'Element 02 01', '6.952822', '-73.338738', '1587082864.png', '0000-00-00', 1, 2),
(2, 9, 'Element 02 02', '', '', '', '2020-03-17', 1, 2),
(3, 8, 'Element 03 01', '', '', '', '2020-03-24', 1, 2),
(4, 1, 'Element 04 01', '6.951701', '-73.340000', '1587082576.png', '0000-00-00', 1, 2),
(5, 12, 'Element 05 01', '6.954655', '-73.340861', '1587083072.png', '0000-00-00', 1, 2),
(6, 12, 'Element 06 01', '6.952269', '-73.339011', '1587082596.png', '0000-00-00', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prjact`
--

CREATE TABLE `prjact` (
  `idact` int(11) NOT NULL,
  `idprj` int(11) NOT NULL,
  `idusr` int(11) NOT NULL,
  `date` date NOT NULL,
  `fechareg` datetime NOT NULL,
  `tipAct` tinyint(4) NOT NULL COMMENT '1 a 5',
  `budget` int(11) NOT NULL,
  `participants` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `names` varchar(200) DEFAULT NULL,
  `observations` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prjact`
--

INSERT INTO `prjact` (`idact`, `idprj`, `idusr`, `date`, `fechareg`, `tipAct`, `budget`, `participants`, `hours`, `names`, `observations`) VALUES
(1, 1, 4, '2025-12-02', '2025-12-01 08:30:00', 1, 600, 5, 2, 'Grupo A', 'Actividad comunitaria'),
(2, 1, 4, '2025-12-03', '2025-12-03 09:10:00', 2, 500, 4, 3, 'Grupo B', 'Capacitación'),
(3, 1, 4, '2025-12-05', '2025-12-05 10:00:00', 3, 500, 7, 4, 'Grupo C', 'Jornada social'),
(4, 3, 4, '2025-12-06', '2025-12-06 11:00:00', 2, 300, 4, 2, 'Grupo D', 'Reunión'),
(5, 3, 4, '2025-12-08', '2025-12-08 14:00:00', 4, 500, 7, 5, 'Grupo E', 'Evento'),
(6, 2, 5, '2025-12-02', '2025-12-02 08:00:00', 1, 800, 8, 1, 'Grupo F', 'Planeación'),
(7, 2, 5, '2025-12-07', '2025-12-07 13:30:00', 3, 300, 7, 4, 'Grupo G', 'Capacitación'),
(8, 5, 7, '2025-12-04', '2025-12-04 09:45:00', 2, 900, 7, 3, 'Grupo H', 'Seguimiento'),
(9, 5, 7, '2025-12-09', '2025-12-09 15:00:00', 5, 900, 2, 6, 'Grupo I', 'Cierre'),
(10, 4, 6, '2025-12-01', '2025-12-10 10:30:00', 1, 500, 6, 1, 'Grupo J', 'Visita'),
(11, 1, 4, '2025-12-11', '2025-12-11 08:00:00', 2, 200, 7, 3, 'Grupo K', 'Actividad'),
(12, 2, 5, '2025-12-12', '2025-12-12 09:00:00', 3, 200, 4, 4, 'Grupo L', 'Capacitación'),
(13, 3, 4, '2025-12-13', '2025-12-13 10:00:00', 4, 200, 7, 5, 'Grupo M', 'Evento'),
(14, 4, 6, '2025-12-01', '2025-12-14 11:00:00', 5, 600, 7, 3, 'Grupo N', 'Reunión'),
(15, 5, 7, '2025-12-15', '2025-12-15 12:00:00', 1, 350, 5, 2, 'Grupo O', 'Actividad'),
(16, 1, 4, '2026-01-01', '0000-00-00 00:00:00', 1, 100, 6, 2, 'Grupo A', 'Actividad comunitaria'),
(17, 1, 4, '2026-01-03', '0000-00-00 00:00:00', 2, 100, 4, 3, 'Grupo B', 'Capacitación'),
(18, 1, 4, '2026-01-05', '0000-00-00 00:00:00', 3, 200, 6, 4, 'Grupo C', 'Jornada social'),
(19, 3, 4, '2026-01-06', '0000-00-00 00:00:00', 2, 300, 4, 2, 'Grupo D', 'Reunión'),
(20, 3, 4, '2026-01-08', '0000-00-00 00:00:00', 4, 200, 7, 5, 'Grupo E', 'Evento'),
(21, 2, 5, '2026-01-02', '0000-00-00 00:00:00', 1, 200, 5, 1, 'Grupo F', 'Planeación'),
(22, 2, 5, '2026-01-07', '0000-00-00 00:00:00', 3, 300, 7, 4, 'Grupo G', 'Capacitación'),
(23, 5, 7, '2026-01-04', '0000-00-00 00:00:00', 2, 900, 5, 3, 'Grupo H', 'Seguimiento'),
(24, 4, 6, '2025-12-02', '0000-00-00 00:00:00', 1, 900, 7, 1, 'Grupo J', 'Visita'),
(25, 1, 4, '2026-01-11', '0000-00-00 00:00:00', 2, 200, 5, 3, 'Grupo K', 'Actividad'),
(26, 2, 5, '2026-01-12', '0000-00-00 00:00:00', 3, 200, 4, 4, 'Grupo L', 'Capacitación'),
(27, 3, 4, '2026-01-13', '0000-00-00 00:00:00', 4, 200, 7, 5, 'Grupo M', 'Evento'),
(28, 4, 7, '2025-12-02', '2026-01-27 20:53:12', 1, 600, 6, 8, 'na', 'na'),
(29, 4, 7, '2025-12-27', '2025-04-30 20:53:12', 1, 500, 5, 8, 'na', 'na'),
(30, 3, 4, '2026-01-24', '2026-01-27 20:56:03', 1, 700, 9, 10, NULL, NULL),
(31, 3, 4, '2026-01-26', '2026-01-27 20:56:03', 1, 2800, 1, 16, 'na', 'na'),
(32, 3, 4, '2026-02-13', '0000-00-00 00:00:00', 4, 300, 17, 6, 'Todos', 'Evento'),
(33, 3, 4, '2025-12-13', '0000-00-00 00:00:00', 4, 300, 17, 6, 'Todos', 'Evento'),
(34, 4, 6, '2026-03-31', '2026-03-31 08:30:00', 1, 50, 7, 2, 'Todos', 'Actividad comunitaria'),
(35, 4, 6, '2026-04-03', '2026-04-03 09:10:00', 2, 100, 2, 3, 'Pedro y Jose', 'Arreglo de acueducto'),
(36, 4, 6, '2026-04-05', '2026-04-05 10:00:00', 3, 100, 3, 4, 'Pedro, Jose y Miguel', 'Destapar vía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projectelements`
--

CREATE TABLE `projectelements` (
  `idpryelemento` int(11) NOT NULL,
  `idprj` int(11) NOT NULL DEFAULT 1,
  `idelement` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `projectelements`
--

INSERT INTO `projectelements` (`idpryelemento`, `idprj`, `idelement`) VALUES
(6, 1, 2),
(5, 1, 6),
(2, 2, 4),
(3, 3, 5),
(1, 4, 1),
(4, 5, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `idprj` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `idcommunity` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '1',
  `amount` int(11) NOT NULL DEFAULT 0,
  `beneficiaries` int(11) NOT NULL DEFAULT 1,
  `hours` int(11) NOT NULL DEFAULT 30,
  `activities` int(11) NOT NULL DEFAULT 10,
  `enddate` varchar(10) NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`idprj`, `name`, `idcommunity`, `startdate`, `type`, `amount`, `beneficiaries`, `hours`, `activities`, `enddate`) VALUES
(1, 'Proj 01 01', 2, '2025-06-01', '1', 2000, 75, 30, 10, '2025-12-31'),
(2, 'Proj 02 01', 3, '2025-12-16', '1', 4000, 60, 30, 10, '2025-12-31'),
(3, 'Proj 01 02', 2, '2025-12-10', '1', 6000, 50, 30, 10, '0000-00-00'),
(4, 'Proj 03 01', 4, '2025-12-16', '1', 3000, 60, 30, 10, '0000-00-00'),
(5, 'Proj 04 01', 5, '2026-01-09', '1', 2000, 60, 30, 10, '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representatives`
--

CREATE TABLE `representatives` (
  `idrepresentative` int(11) NOT NULL,
  `idusr` int(11) NOT NULL,
  `idcommunity` int(11) NOT NULL,
  `datestart` date NOT NULL,
  `datefinish` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `representatives`
--

INSERT INTO `representatives` (`idrepresentative`, `idusr`, `idcommunity`, `datestart`, `datefinish`) VALUES
(1, 1, 1, '2025-12-09', NULL),
(2, 2, 1, '2025-12-09', NULL),
(3, 3, 1, '2025-12-09', NULL),
(4, 4, 2, '2025-01-15', '0000-00-00'),
(5, 5, 3, '2025-01-15', '0000-00-00'),
(6, 6, 4, '2026-01-02', NULL),
(7, 7, 5, '2025-01-01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supersystems`
--

CREATE TABLE `supersystems` (
  `idspr` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `supersystems`
--

INSERT INTO `supersystems` (`idspr`, `name`) VALUES
(1, 'Super 01'),
(2, 'Super 02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `systems`
--

CREATE TABLE `systems` (
  `idsst` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `idspr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `systems`
--

INSERT INTO `systems` (`idsst`, `name`, `idspr`) VALUES
(1, 'Sin Definir', 1),
(2, 'System 01 02', 1),
(3, 'System 01 03', 1),
(4, 'System 01 04', 1),
(5, 'System 01 05', 1),
(6, 'System 02 06', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tactividadestip`
--

CREATE TABLE `tactividadestip` (
  `idactividadtipo` int(11) NOT NULL,
  `tipActNombre` varchar(30) NOT NULL,
  `Estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tactividadestip`
--

INSERT INTO `tactividadestip` (`idactividadtipo`, `tipActNombre`, `Estado`) VALUES
(1, 'Formulación', 1),
(2, 'Seguros', 1),
(3, 'Combustible', 1),
(4, 'Impuestos', 1),
(5, 'Jornales', 1),
(6, 'Energía', 1),
(7, 'Mantenimiento', 1),
(8, 'Reunión', 1),
(9, 'Medición', 1),
(10, 'Visita', 1),
(11, 'Planeacion', 1),
(12, 'Abonar', 1),
(13, 'Documentos', 1),
(14, 'Transporte', 1),
(22, 'Tramites', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telementclss`
--

CREATE TABLE `telementclss` (
  `idelementcls` int(11) NOT NULL,
  `idtype` int(11) NOT NULL,
  `elmclsname` varchar(30) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='telementoscls';

--
-- Volcado de datos para la tabla `telementclss`
--

INSERT INTO `telementclss` (`idelementcls`, `idtype`, `elmclsname`, `state`) VALUES
(1, 5, 'Nacimiento pequeño', 1),
(2, 3, 'Flora - Ceiba', 1),
(3, 3, 'Flora - Caracolí', 1),
(4, 3, 'Flora - Mamón', 1),
(5, 3, 'Flora - Pomarroso', 1),
(6, 3, 'Flora - Ciruelo', 1),
(7, 3, 'Flora - Guayacan', 1),
(8, 2, 'Finca', 1),
(9, 4, 'Via', 1),
(10, 1, 'Vereda', 1),
(11, 6, 'Energía', 1),
(12, 7, 'Construcción', 1),
(13, 8, 'Cultivos', 1),
(14, 5, 'Acueducto veredal', 1),
(15, 6, 'Biodigestor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telementstypes`
--

CREATE TABLE `telementstypes` (
  `idtype` int(11) NOT NULL,
  `typeelementname` varchar(30) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `telementstypes`
--

INSERT INTO `telementstypes` (`idtype`, `typeelementname`, `state`) VALUES
(1, 'Vereda', 1),
(2, 'Finca', 1),
(3, 'Flora', 1),
(4, 'Via', 1),
(5, 'Acueducto', 1),
(6, 'Energía', 1),
(7, 'Infraestructura', 1),
(8, 'Cultivos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tproyectosactividadesmlt`
--

CREATE TABLE `tproyectosactividadesmlt` (
  `idpryactividadmlt` int(11) NOT NULL,
  `idpryactividad` int(11) NOT NULL,
  `multimedia` varchar(50) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '1.img, 2. mp3, 3.mp4',
  `estado` int(1) NOT NULL DEFAULT 1,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tproyectosactividadesmlt`
--

INSERT INTO `tproyectosactividadesmlt` (`idpryactividadmlt`, `idpryactividad`, `multimedia`, `type`, `estado`, `date`) VALUES
(101, 99, '1705421099.png', 1, 1, '2024-01-16 05:01:59'),
(102, 100, '1705421337.png', 1, 1, '2024-01-16 05:01:57'),
(105, 101, '66784cd1234a1.png ', 1, 1, '2024-06-23 06:06:57'),
(106, 101, '66784e245a30b.png ', 1, 1, '2024-06-23 06:06:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idusr` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `usr` varchar(15) DEFAULT NULL,
  `pass` varchar(64) DEFAULT NULL,
  `name1` varchar(45) DEFAULT NULL,
  `name2` varchar(45) DEFAULT NULL,
  `lastname1` varchar(45) DEFAULT NULL,
  `lastname2` varchar(45) DEFAULT NULL,
  `document` int(15) DEFAULT NULL,
  `state` int(1) DEFAULT 1,
  `email` varchar(50) NOT NULL,
  `idcommunity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`idusr`, `rol`, `usr`, `pass`, `name1`, `name2`, `lastname1`, `lastname2`, `document`, `state`, `email`, `idcommunity`) VALUES
(1, 1, 'samuel', 'e0bf559aed7e366445c42e30c506e557badcbedcf38844fb20bc0e6d17cc7280', 'Samuel', '-', 'Gómez', '', 13510121, 1, 'samuel@gmail.com', 1),
(2, 2, 'sara', 'e0bf559aed7e366445c42e30c506e557badcbedcf38844fb20bc0e6d17cc7280', 'Sara', '-', 'Gómez', NULL, 13510122, 1, 'sara@gmail.com', 2),
(3, 2, 'simon', 'e0bf559aed7e366445c42e30c506e557badcbedcf38844fb20bc0e6d17cc7280', 'Simon', '-', 'Carreño', NULL, 13510123, 1, 'simon@gmail.com', 3),
(4, 2, 'urbano', 'e0bf559aed7e366445c42e30c506e557badcbedcf38844fb20bc0e6d17cc7280', 'Urbano', NULL, 'Gómez', '-', 0, 1, 'urbanoeliecer@gmail.com', 1),
(5, 3, 'jacke', 'e0bf559aed7e366445c42e30c506e557badcbedcf38844fb20bc0e6d17cc7280', 'Jacke', NULL, 'Calderón', '-', 0, 1, 'jcalderontic@gmail.com', 2),
(6, 1, 'marco', 'ca1da079a39e218cbf0304fceea51d88f972c154c7a99fcd189993211c45cee8', 'Marco', 'Antonio', 'Villamizar', '-', 0, 1, 'marco.villamizar@gmail.com', 1),
(7, 1, 'javier', 'ca1da079a39e218cbf0304fceea51d88f972c154c7a99fcd189993211c45cee8', 'Javier', '', 'Castellanos', '-', 0, 1, 'urbanoeliecer1@gmail.com', 1),
(8, 4, 'rene', 'e0bf559aed7e366445c42e30c506e557badcbedcf38844fb20bc0e6d17cc7280', 'Rene', '', 'Carreno', '-', 0, 1, 'jcalderontic1@gmail.com', 1),
(11, 3, 'eliecer', 'ca1da079a39e218cbf0304fceea51d88f972c154c7a99fcd189993211c45cee8', 'Eliecer', '', 'Gomez', '-', 13806506, 1, 'marco.villamiza1r@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vprojectsxcommunityxyear`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vprojectsxcommunityxyear` (
`idprj` int(11)
,`projectname` varchar(50)
,`projecttype` varchar(50)
,`amount` bigint(11)
,`beneficiaries` int(11)
,`idspr` int(11)
,`supersystem` varchar(50)
,`idsst` int(11)
,`system` varchar(50)
,`idcommunity` int(11)
,`community` varchar(200)
,`idrepresentative` int(11)
,`representativename` varchar(45)
,`startdate` date
,`enddate` varchar(10)
,`year` int(4)
,`totalactivities` bigint(21)
,`totalbudget` decimal(32,0)
,`totalparticipants` decimal(32,0)
,`totalhours` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vprojectsxcommunityxyear`
--
DROP TABLE IF EXISTS `vprojectsxcommunityxyear`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vprojectsxcommunityxyear`  AS SELECT `p`.`idprj` AS `idprj`, `p`.`name` AS `projectname`, `p`.`type` AS `projecttype`, cast(`p`.`amount` as signed) AS `amount`, `p`.`beneficiaries` AS `beneficiaries`, `d`.`idspr` AS `idspr`, `d`.`name` AS `supersystem`, `m`.`idsst` AS `idsst`, `m`.`name` AS `system`, `j`.`idcommunity` AS `idcommunity`, `j`.`name` AS `community`, `r`.`idrepresentative` AS `idrepresentative`, `u`.`name1` AS `representativename`, `p`.`startdate` AS `startdate`, `p`.`enddate` AS `enddate`, year(`pa`.`date`) AS `year`, count(`pa`.`idact`) AS `totalactivities`, coalesce(sum(`pa`.`budget`),0) AS `totalbudget`, coalesce(sum(`pa`.`participants`),0) AS `totalparticipants`, coalesce(sum(`pa`.`hours`),0) AS `totalhours` FROM ((((((`projects` `p` join `communities` `j` on(`p`.`idcommunity` = `j`.`idcommunity`)) join `systems` `m` on(`j`.`idsst` = `m`.`idsst`)) join `supersystems` `d` on(`m`.`idspr` = `d`.`idspr`)) left join `representatives` `r` on(`r`.`idcommunity` = `j`.`idcommunity`)) left join `users` `u` on(`u`.`idusr` = `r`.`idusr`)) left join `prjact` `pa` on(`pa`.`idprj` = `p`.`idprj`)) GROUP BY `p`.`idprj`, `p`.`name`, `p`.`type`, `p`.`amount`, `p`.`beneficiaries`, `d`.`idspr`, `d`.`name`, `m`.`idsst`, `m`.`name`, `j`.`idcommunity`, `j`.`name`, `r`.`idrepresentative`, `u`.`name1`, `p`.`startdate`, `p`.`enddate`, year(`pa`.`date`) HAVING `year` is not null ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`idcommunity`),
  ADD KEY `fk_jac_municipio` (`idsst`);

--
-- Indices de la tabla `comm_dsc`
--
ALTER TABLE `comm_dsc`
  ADD PRIMARY KEY (`idcommunitydesc`),
  ADD KEY `fk_juntasdsc_junta` (`idcommunity`);

--
-- Indices de la tabla `comm_weights`
--
ALTER TABLE `comm_weights`
  ADD PRIMARY KEY (`idcmnwgt`),
  ADD KEY `fk_juntaspesos_juntas` (`idcmn`);

--
-- Indices de la tabla `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`idelement`),
  ADD KEY `fk_elements_community` (`idcommunity`),
  ADD KEY `fk_elements_cls` (`idelementcls`);

--
-- Indices de la tabla `prjact`
--
ALTER TABLE `prjact`
  ADD PRIMARY KEY (`idact`),
  ADD KEY `fk_tpryact_proyecto` (`idprj`),
  ADD KEY `fk_tpryact_usuario` (`idusr`);

--
-- Indices de la tabla `projectelements`
--
ALTER TABLE `projectelements`
  ADD PRIMARY KEY (`idpryelemento`),
  ADD UNIQUE KEY `idprj` (`idprj`,`idelement`),
  ADD KEY `fk_projectelements_element` (`idelement`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`idprj`),
  ADD KEY `fk_proy_junta` (`idcommunity`);

--
-- Indices de la tabla `representatives`
--
ALTER TABLE `representatives`
  ADD PRIMARY KEY (`idrepresentative`),
  ADD KEY `fk_rep_usuario` (`idusr`),
  ADD KEY `fk_rep_junta` (`idcommunity`);

--
-- Indices de la tabla `supersystems`
--
ALTER TABLE `supersystems`
  ADD PRIMARY KEY (`idspr`);

--
-- Indices de la tabla `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`idsst`),
  ADD KEY `fk_municipios_departamento` (`idspr`);

--
-- Indices de la tabla `tactividadestip`
--
ALTER TABLE `tactividadestip`
  ADD PRIMARY KEY (`idactividadtipo`);

--
-- Indices de la tabla `telementclss`
--
ALTER TABLE `telementclss`
  ADD PRIMARY KEY (`idelementcls`);

--
-- Indices de la tabla `telementstypes`
--
ALTER TABLE `telementstypes`
  ADD PRIMARY KEY (`idtype`);

--
-- Indices de la tabla `tproyectosactividadesmlt`
--
ALTER TABLE `tproyectosactividadesmlt`
  ADD PRIMARY KEY (`idpryactividadmlt`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idusr`),
  ADD UNIQUE KEY `u_email` (`email`),
  ADD KEY `fk_users_community` (`idcommunity`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comm_dsc`
--
ALTER TABLE `comm_dsc`
  MODIFY `idcommunitydesc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comm_weights`
--
ALTER TABLE `comm_weights`
  MODIFY `idcmnwgt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `elements`
--
ALTER TABLE `elements`
  MODIFY `idelement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `prjact`
--
ALTER TABLE `prjact`
  MODIFY `idact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `projectelements`
--
ALTER TABLE `projectelements`
  MODIFY `idpryelemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=671;

--
-- AUTO_INCREMENT de la tabla `representatives`
--
ALTER TABLE `representatives`
  MODIFY `idrepresentative` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tactividadestip`
--
ALTER TABLE `tactividadestip`
  MODIFY `idactividadtipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `telementclss`
--
ALTER TABLE `telementclss`
  MODIFY `idelementcls` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `telementstypes`
--
ALTER TABLE `telementstypes`
  MODIFY `idtype` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tproyectosactividadesmlt`
--
ALTER TABLE `tproyectosactividadesmlt`
  MODIFY `idpryactividadmlt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `idusr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `communities`
--
ALTER TABLE `communities`
  ADD CONSTRAINT `fk_jac_municipio` FOREIGN KEY (`idsst`) REFERENCES `systems` (`idsst`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `comm_dsc`
--
ALTER TABLE `comm_dsc`
  ADD CONSTRAINT `fk_juntasdsc_junta` FOREIGN KEY (`idcommunity`) REFERENCES `communities` (`idcommunity`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comm_weights`
--
ALTER TABLE `comm_weights`
  ADD CONSTRAINT `fk_communitiesweights_community` FOREIGN KEY (`idcmn`) REFERENCES `communities` (`idcommunity`),
  ADD CONSTRAINT `fk_juntaspesos_juntas` FOREIGN KEY (`idcmn`) REFERENCES `communities` (`idcommunity`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `elements`
--
ALTER TABLE `elements`
  ADD CONSTRAINT `fk_elements_cls` FOREIGN KEY (`idelementcls`) REFERENCES `telementclss` (`idelementcls`),
  ADD CONSTRAINT `fk_elements_community` FOREIGN KEY (`idcommunity`) REFERENCES `communities` (`idcommunity`);

--
-- Filtros para la tabla `prjact`
--
ALTER TABLE `prjact`
  ADD CONSTRAINT `fk_prjact_user` FOREIGN KEY (`idusr`) REFERENCES `users` (`idusr`),
  ADD CONSTRAINT `fk_tpryact_proyecto` FOREIGN KEY (`idprj`) REFERENCES `projects` (`idprj`),
  ADD CONSTRAINT `fk_tpryact_usuario` FOREIGN KEY (`idusr`) REFERENCES `users` (`idusr`);

--
-- Filtros para la tabla `projectelements`
--
ALTER TABLE `projectelements`
  ADD CONSTRAINT `fk_pp` FOREIGN KEY (`idprj`) REFERENCES `projects` (`idprj`),
  ADD CONSTRAINT `fk_projectelements_element` FOREIGN KEY (`idelement`) REFERENCES `elements` (`idelement`),
  ADD CONSTRAINT `fk_projectelements_project` FOREIGN KEY (`idprj`) REFERENCES `projects` (`idprj`);

--
-- Filtros para la tabla `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_proy_junta` FOREIGN KEY (`idcommunity`) REFERENCES `communities` (`idcommunity`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `representatives`
--
ALTER TABLE `representatives`
  ADD CONSTRAINT `fk_rep_user` FOREIGN KEY (`idusr`) REFERENCES `users` (`idusr`),
  ADD CONSTRAINT `fk_representatives_community` FOREIGN KEY (`idcommunity`) REFERENCES `communities` (`idcommunity`),
  ADD CONSTRAINT `fk_representatives_user` FOREIGN KEY (`idusr`) REFERENCES `users` (`idusr`);

--
-- Filtros para la tabla `systems`
--
ALTER TABLE `systems`
  ADD CONSTRAINT `fk_municipios_departamento` FOREIGN KEY (`idspr`) REFERENCES `supersystems` (`idspr`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_community` FOREIGN KEY (`idcommunity`) REFERENCES `communities` (`idcommunity`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
