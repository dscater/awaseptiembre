-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-10-2023 a las 23:34:25
-- Versión del servidor: 8.0.30
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `awaseptiembre_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_profesors`
--

CREATE TABLE `actividad_profesors` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `actividad_profesors`
--

INSERT INTO `actividad_profesors` (`id`, `user_id`, `fecha`, `descripcion`, `observacion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 6, '2023-08-04', 'DESFILE ESCOLAR', 'DESFILE ESCOLAR', '2023-09-20', '2023-09-21 01:56:53', '2023-09-21 02:03:33'),
(2, 6, '2023-08-17', 'DESFILE ESCOLAR', 'DESFILE ESCOLAR', '2023-09-20', '2023-09-21 01:57:05', '2023-09-21 02:03:53'),
(3, 6, '2023-10-31', 'ACTIVIDAD ESCOLAR', 'ACTIVIDAD ESCOLAR', '2023-09-20', '2023-09-21 01:57:27', '2023-09-21 02:05:09'),
(4, 6, '2023-06-06', 'DÍA DEL MAESTRO', 'DÍA DEL MAESTRO', '2023-09-20', '2023-09-21 01:57:56', '2023-09-21 02:02:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativos`
--

CREATE TABLE `administrativos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar_nac` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `edad` int NOT NULL,
  `sexo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_civil` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avenida` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_rda` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `afp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nua` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_fiscal` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_seguro_social` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caja_seguro_social` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestiones_trabajo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mes` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrativos`
--

INSERT INTO `administrativos` (`id`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `lugar_nac`, `fecha_nac`, `edad`, `sexo`, `estado_civil`, `zona`, `avenida`, `nro`, `fono`, `cel`, `email`, `nro_rda`, `afp`, `nua`, `item_fiscal`, `nro_seguro_social`, `caja_seguro_social`, `titulado`, `gestiones_trabajo`, `cargo`, `mes`, `observaciones`, `foto`, `fecha_registro`, `user_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'PABLO', 'PACHECO', 'FLORES', '1023030', 'LP', 'LA PAZ', '1988-09-12', 35, 'M', '345', 'ZONA CENTRAL', 'LITORAL', '234', '2881547', '76544875', '', '8485', '456', '567', '567', '4563223', 'CNS', '1RA FASE', '2015', 'DIRECCIÓN ACADÉMICA', 'ENERO', '', 'PABLO1698455602.png', '2023-10-27', 2, 1, '2023-09-21 00:18:51', '2023-10-28 01:13:22'),
(2, 'FELIPE', 'PERES', '', '213123', 'LP', 'LA PAZ', '1995-01-01', 28, 'M', 'SOLTERO', 'LOS OLIVOS', 'AV. 3', '1', '', '777777', '', '111', '11', '222', '333', '444', 'SEGURO', '1RA FASE', '', '', '', '', 'user_default.png', '2023-10-28', 16, 1, '2023-09-21 13:31:09', '2023-10-28 21:27:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativo_cursos`
--

CREATE TABLE `administrativo_cursos` (
  `id` bigint UNSIGNED NOT NULL,
  `administrativo_id` bigint UNSIGNED NOT NULL,
  `nominacion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duracion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrativo_cursos`
--

INSERT INTO `administrativo_cursos` (`id`, `administrativo_id`, `nominacion`, `institucion`, `duracion`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '', '0000-00-00', '2023-09-21 00:18:52', '2023-10-28 01:33:02'),
(2, 1, '', '', '', '0000-00-00', '2023-09-21 00:18:52', '2023-10-28 01:33:02'),
(3, 1, '', '', '', '0000-00-00', '2023-09-21 00:18:52', '2023-10-28 01:33:03'),
(4, 2, '', '', '', '0000-00-00', '2023-09-21 13:31:09', '2023-10-28 21:27:18'),
(5, 2, '', '', '', '0000-00-00', '2023-09-21 13:31:09', '2023-10-28 21:27:18'),
(6, 2, '', '', '', '0000-00-00', '2023-09-21 13:31:09', '2023-10-28 21:27:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativo_estudios`
--

CREATE TABLE `administrativo_estudios` (
  `id` bigint UNSIGNED NOT NULL,
  `administrativo_id` bigint UNSIGNED NOT NULL,
  `nivel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anio_egreso` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especialidad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_titulo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrativo_estudios`
--

INSERT INTO `administrativo_estudios` (`id`, `administrativo_id`, `nivel`, `institucion`, `anio_egreso`, `especialidad`, `nro_titulo`, `created_at`, `updated_at`) VALUES
(1, 1, 'SECUNDARIO', 'UE MEJILLONES', '2002', 'UMANIDADES', '45344', '2023-09-21 00:18:51', '2023-10-28 01:09:43'),
(2, 1, 'NORMAL', '', '', '', '', '2023-09-21 00:18:51', '2023-10-28 01:09:43'),
(3, 1, 'UNIVERSITARIO', '', '', '', '', '2023-09-21 00:18:52', '2023-10-28 01:09:43'),
(4, 1, 'POST GRADO', '', '', '', '', '2023-09-21 00:18:52', '2023-10-28 01:09:43'),
(5, 1, 'POST GRADO', '', '', '', '', '2023-09-21 00:18:52', '2023-10-28 01:09:43'),
(6, 2, 'SECUNDARIO', '', '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:33'),
(7, 2, 'NORMAL', '', '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:33'),
(8, 2, 'UNIVERSITARIO', '', '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:33'),
(9, 2, 'POST GRADO', '', '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:33'),
(10, 2, 'POST GRADO', '', '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativo_otros`
--

CREATE TABLE `administrativo_otros` (
  `id` bigint UNSIGNED NOT NULL,
  `administrativo_id` bigint UNSIGNED NOT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `turno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zona` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_horas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrativo_otros`
--

INSERT INTO `administrativo_otros` (`id`, `administrativo_id`, `institucion`, `turno`, `zona`, `cargo`, `total_horas`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '', '', 0, '2023-09-21 00:18:53', '2023-09-21 00:18:53'),
(2, 1, '', '', '', '', 0, '2023-09-21 00:18:53', '2023-09-21 00:18:53'),
(3, 1, '', '', '', '', 0, '2023-09-21 00:18:53', '2023-09-21 00:18:53'),
(4, 2, '', '', '', '', 0, '2023-09-21 13:31:09', '2023-09-21 13:31:09'),
(5, 2, '', '', '', '', 0, '2023-09-21 13:31:09', '2023-09-21 13:31:09'),
(6, 2, '', '', '', '', 0, '2023-09-21 13:31:09', '2023-09-21 13:31:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativo_trabajos`
--

CREATE TABLE `administrativo_trabajos` (
  `id` bigint UNSIGNED NOT NULL,
  `administrativo_id` bigint UNSIGNED NOT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gestion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrativo_trabajos`
--

INSERT INTO `administrativo_trabajos` (`id`, `administrativo_id`, `institucion`, `gestion`, `cargo`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '', '2023-09-21 00:18:53', '2023-09-21 00:18:53'),
(2, 1, '', '', '', '2023-09-21 00:18:53', '2023-09-21 00:18:53'),
(3, 1, '', '', '', '2023-09-21 00:18:53', '2023-09-21 00:18:53'),
(4, 2, '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:09'),
(5, 2, '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:09'),
(6, 2, '', '', '', '2023-09-21 13:31:09', '2023-09-21 13:31:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` bigint UNSIGNED NOT NULL,
  `campo_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `campo_id`, `nombre`, `tipo`, `descripcion`, `created_at`, `updated_at`) VALUES
(2, 1, 'CIENCIAS NATURALES', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(3, 2, 'COMUNICACIÓN Y LENGUAJES, LENGUA ORIGINARIA, LENGUA EXTRANJERA', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(4, 2, 'COMUNICACIÓN Y LENGUAJES', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(5, 2, 'CIENCIAS SOCIALES', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(6, 2, 'EDUACIÓN FÍSICA Y DEPORTES', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(7, 2, 'EDUCACIÓN MUSICAL', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(8, 2, 'ARTES PLÁSTICAS Y VISUALES', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(9, 3, 'COSMOVISIÓN-FILOSOFÍA-PSICOLOGÍA', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(10, 3, 'VALORES ESPIRITUALES RELIGIONES', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(11, 4, 'MATEMÁTICA', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(12, 4, 'TÉCNICA TECNOLÓGICA', 'HUMANÍSTICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(15, 4, 'TÉCNICA TECNOLÓGICA', 'TÉCNICA TECNOLÓGICA', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacions`
--

CREATE TABLE `calificacions` (
  `id` bigint UNSIGNED NOT NULL,
  `inscripcion_id` bigint UNSIGNED NOT NULL,
  `estudiante_id` bigint UNSIGNED NOT NULL,
  `gestion` int NOT NULL,
  `profesor_materia_id` bigint UNSIGNED NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `ponderacion` double(8,2) NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campos`
--

CREATE TABLE `campos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `campos`
--

INSERT INTO `campos` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'VIDA TIERRA Y TERRITORIO', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(2, 'COMUNIDAD Y SOCIEDAD', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(3, 'COSMOS Y PENSAMIENTO', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(4, 'CIENCIA TECNOLOGÍA Y PRODUCCIÓN', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunicados`
--

CREATE TABLE `comunicados` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `gestion` int NOT NULL,
  `nivel` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profesor_materia_id` bigint UNSIGNED DEFAULT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `paralelo_id` bigint UNSIGNED NOT NULL,
  `turno` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `inscripcion_id` bigint UNSIGNED NOT NULL,
  `profesor_materia_id` bigint UNSIGNED NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `tarea_id` bigint UNSIGNED NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_entrega` date DEFAULT NULL,
  `calificacion` double(8,2) DEFAULT NULL,
  `estado` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enviado` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` int NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_archivos`
--

CREATE TABLE `entrega_archivos` (
  `id` bigint UNSIGNED NOT NULL,
  `entrega_id` bigint UNSIGNED NOT NULL,
  `link` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_doc` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_doc` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais_nac` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dpto_nac` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_nac` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `localidad_nac` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `sexo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oficialia` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `libro` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `partida` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folio` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ue_procedencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_sie_ue` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avenida_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `localidad_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idioma_niniez` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idiomas_estudiante` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pueblo_nacion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pueblo_nacion_otro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centro_salud` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `veces_centro_salud` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discapacidad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discapacidad_otro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_discapacidad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agua` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `energia_electrica` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `banio` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actividad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dias_trabajo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recibio_pago` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internet` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `frecuencia_internet` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `llega` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `llega_otro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_llega` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apm_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idioma_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ocupacion_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentezco_padre_tutor` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apm_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idioma_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ocupacion_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grado_madre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugar` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombre`, `paterno`, `materno`, `tipo_doc`, `nro_doc`, `ci_exp`, `pais_nac`, `dpto_nac`, `provincia_nac`, `localidad_nac`, `fecha_nac`, `sexo`, `oficialia`, `libro`, `partida`, `folio`, `ue_procedencia`, `codigo_sie_ue`, `provincia_dir`, `zona_dir`, `municipio_dir`, `avenida_dir`, `localidad_dir`, `fono_dir`, `nro_dir`, `idioma_niniez`, `idiomas_estudiante`, `pueblo_nacion`, `pueblo_nacion_otro`, `centro_salud`, `veces_centro_salud`, `discapacidad`, `discapacidad_otro`, `desc_discapacidad`, `agua`, `energia_electrica`, `banio`, `actividad`, `dias_trabajo`, `recibio_pago`, `internet`, `frecuencia_internet`, `llega`, `llega_otro`, `desc_llega`, `ci_padre_tutor`, `app_padre_tutor`, `apm_padre_tutor`, `nom_padre_tutor`, `idioma_padre_tutor`, `ocupacion_padre_tutor`, `grado_padre_tutor`, `parentezco_padre_tutor`, `ci_madre`, `app_madre`, `apm_madre`, `nom_madre`, `idioma_madre`, `ocupacion_madre`, `grado_madre`, `lugar`, `foto`, `fecha_registro`, `user_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'DANIEL', 'PAREDES', 'CONDE', 'CI', '405060', 'LP', 'LA PAZ', 'LA PAZ', 'MURILLO', 'LA PAZ', '2004-08-15', 'M', '234', '34', '345', '45', 'UNIDAD EDUCATIVA MARISCAL SANTA CRUZ', '234235234', 'MURILLO', 'ZONA NORTE', 'LA PAZ', 'CALLE 4', 'LA PAZ', '76544875', '868', 'CASTELLANO', 'CASTELLANO', 'NO PERTENECE', '', 'SI', '1 A 2 VECES', '', '', '', 'CAÑERÍA DE RED', 'SI', 'ALCANTARILLADO', 'NO TRABAJÓ', '5', 'NO', 'SU DOMICILIO', 'DIARIAMENTE', 'A PIE', '', 'MENOS DE MEDIA HORA', '708090', 'PAREDES', 'TAPIA', 'RICARDO', 'CASTELLANO', 'PROFESOR', 'LICENCIATURA', 'PADRE', '908070', 'CONDE', 'SUAREZ', 'MARTHA', 'CASTELLANO', 'LABORES DE HOGAR', 'SECUNDARIA', '', 'DANIEL1698515013.png', '2023-09-20', 3, 1, '2023-09-21 00:24:38', '2023-10-28 17:43:33'),
(2, 'CARLOS', 'GONZALES', 'MARTINES', 'CI', '12312', 'LP', 'BOLIVIA', 'LA PAZ', 'LAPAZ', 'LA PAZ', '2010-01-21', 'M', '123123', '12', '2112', '1212', '', '', 'LOS OLIVOS', 'ZONA VILLA', 'SECCION 1|', 'AV. 3', 'LOCALIDAD 1', '7777', '32', 'ESPAÑOL', 'ESPAÑOL', 'NO PERTENECE', '', 'SI', '1 A 2 VECES', 'SENSORIAL Y DE LA COMUNICACIÓN', '', '', 'CAÑERÍA DE RED', 'SI', 'ALCANTARILLADO', 'TRABAJÓ EN AGRICULTURA O AGROINDUSTRIA', '', '', 'EN LA UNIDAD EDUCATIVA', 'MÁS DE UNA VEZ A LA SEMANA', 'A PIE', '', 'MENOS DE MEDIA HORA', '3123', 'GONZALES', '', 'MARTIN', 'ESPAÑOL', 'OCUPACION', 'SECUNDARIA', '', '', '', '', '', '', '', '', '', 'CARLOS1695303507.jpg', '2023-09-21', 10, 1, '2023-09-21 13:38:27', '2023-09-21 13:38:27'),
(3, 'MAMANI', 'VALENTINA', 'MENDOZA', 'CI', '33223', 'LP', 'BOLIVIA', 'LA PAZ', 'LA PAZ', 'LA PAZ', '2006-01-01', 'F', '1212', '12223', '324234', '123123', '', '', 'LOS OLIVOS', 'LA PAZ', 'LA PAZ', 'AV. 33', 'LA PAZ', '777777', '3', 'ESPAÑOL', 'ESPAÑOL', 'NO PERTENECE', '', 'SI', '1 A 2 VECES', '', '', '', 'CAÑERÍA DE RED', 'SI', 'ALCANTARILLADO', 'NO TRABAJÓ', '', '', 'SU DOMICILIO', 'DIARIAMENTE', 'A PIE', '', 'MENOS DE MEDIA HORA', '88888', 'MENDOZA', 'MARTINES', 'PEDRO', 'ESPAÑOL', 'OCUPACION 1', 'GRADO ALCANZADO', 'PADRE', '77777', 'MAMANI', 'MAMANI', 'MARIA', 'ESPAÑOL', 'OCUPACION 2', 'GRADO 2', '', 'MAMANI1695305977.jpg', '2023-09-21', 12, 1, '2023-09-21 14:19:38', '2023-09-21 14:19:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_accions`
--

CREATE TABLE `historial_accions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos_original` text COLLATE utf8mb4_unicode_ci,
  `datos_nuevo` text COLLATE utf8mb4_unicode_ci,
  `modulo` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcions`
--

CREATE TABLE `inscripcions` (
  `id` bigint UNSIGNED NOT NULL,
  `estudiante_id` bigint UNSIGNED NOT NULL,
  `nivel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paralelo_id` bigint UNSIGNED NOT NULL,
  `turno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion` int NOT NULL,
  `estado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscripcions`
--

INSERT INTO `inscripcions` (`id`, `estudiante_id`, `nivel`, `grado`, `paralelo_id`, `turno`, `gestion`, `estado`, `status`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 'SECUNDARIA', '1', 3, 'MAÑANA', 2023, 'REPROBADO', 1, '2023-09-20', '2023-09-21 01:53:27', '2023-10-28 14:46:25'),
(2, 3, 'SECUNDARIA', '1', 3, 'MAÑANA', 2023, 'REPROBADO', 1, '2023-09-21', '2023-09-21 14:22:04', '2023-09-21 14:22:04'),
(5, 2, 'SECUNDARIA', '2', 3, 'MAÑANA', 2023, 'REPROBADO', 1, '2023-10-28', '2023-10-28 17:30:14', '2023-10-28 17:30:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` bigint UNSIGNED NOT NULL,
  `area_id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `area_id`, `codigo`, `nivel`, `nombre`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(2, 11, 'M001', 'SECUNDARIA', 'MATEMÁTICAS', '2023-05-11', '2023-05-11 20:13:29', '2023-09-21 01:49:32'),
(3, 2, 'M002', 'SECUNDARIA', 'BIOLOGÍA, GEOGRAFÍA', '2023-05-11', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(5, 2, 'M003', 'SECUNDARIA', 'FÍSICA - QUÍMICA', '2023-05-11', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(6, 3, 'CS001', 'SECUNDARIA', 'COMUNICACIÓN Y LENGUAJES', '2023-05-11', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(7, 3, 'CS002', 'SECUNDARIA', 'LENGUAS CASTELLANA Y ORIGINARIA', '2023-05-11', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(9, 7, 'TT001', 'SECUNDARIA', 'MUSICA', '2023-05-11', '2023-05-11 20:13:29', '2023-09-21 01:49:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_grados`
--

CREATE TABLE `materia_grados` (
  `id` bigint UNSIGNED NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `grado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `horas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materia_grados`
--

INSERT INTO `materia_grados` (`id`, `materia_id`, `grado`, `horas`, `created_at`, `updated_at`) VALUES
(1, 2, '1', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(2, 2, '2', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(3, 2, '3', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(4, 2, '4', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(5, 2, '5', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(6, 2, '6', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(7, 3, '1', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(8, 3, '2', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(9, 3, '3', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(10, 3, '4', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(11, 3, '5', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(12, 3, '6', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(13, 5, '1', NULL, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(14, 5, '2', NULL, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(15, 5, '3', 12, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(16, 5, '4', 12, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(17, 5, '5', 12, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(18, 5, '6', 12, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(19, 6, '1', 44, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(20, 6, '2', 44, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(21, 6, '3', 36, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(22, 6, '4', 36, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(23, 6, '5', 36, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(24, 6, '6', 36, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(25, 7, '1', 24, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(26, 7, '2', 24, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(27, 7, '3', 24, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(28, 7, '4', 16, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(29, 7, '5', 12, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(30, 7, '6', 12, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(31, 8, '1', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(32, 8, '2', 8, '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(33, 9, '1', 8, '2023-05-11 20:13:29', '2023-09-21 01:49:16'),
(34, 9, '2', 8, '2023-05-11 20:13:29', '2023-09-21 01:49:16'),
(35, 9, '3', 8, '2023-05-11 20:13:29', '2023-09-21 01:49:16'),
(36, 9, '4', 8, '2023-05-11 20:13:29', '2023-09-21 01:49:17'),
(37, 9, '5', 8, '2023-05-11 20:13:29', '2023-09-21 01:49:17'),
(38, 9, '6', 8, '2023-05-11 20:13:29', '2023-09-21 01:49:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_10_27_132550_create_tareas_table', 1),
(2, '2023_10_27_132551_create_entregas_table', 2),
(3, '2023_10_27_133604_create_tarea_archivos_table', 3),
(4, '2023_10_27_133614_create_entrega_archivos_table', 4),
(5, '2023_10_27_133633_create_comunicados_table', 5),
(6, '2023_10_27_133641_create_notificacions_table', 6),
(7, '2023_10_27_133712_create_notificacion_users_table', 7),
(8, '2023_08_26_190801_create_historial_accions_table', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacions`
--

CREATE TABLE `notificacions` (
  `id` bigint UNSIGNED NOT NULL,
  `registro_id` bigint UNSIGNED NOT NULL,
  `modulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_users`
--

CREATE TABLE `notificacion_users` (
  `id` bigint UNSIGNED NOT NULL,
  `notificacion_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `visto` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paralelos`
--

CREATE TABLE `paralelos` (
  `id` bigint UNSIGNED NOT NULL,
  `paralelo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paralelos`
--

INSERT INTO `paralelos` (`id`, `paralelo`, `descripcion`, `created_at`, `updated_at`) VALUES
(3, 'A', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(4, 'B', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(5, 'C', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29'),
(6, 'D', '', '2023-05-11 20:13:29', '2023-05-11 20:13:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesors`
--

CREATE TABLE `profesors` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `materno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar_nac` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `edad` int NOT NULL,
  `sexo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_civil` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zona` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avenida` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_rda` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `afp` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nua` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_fiscal` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_seguro_social` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caja_seguro_social` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestiones_trabajo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mes` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesors`
--

INSERT INTO `profesors` (`id`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `lugar_nac`, `fecha_nac`, `edad`, `sexo`, `estado_civil`, `zona`, `avenida`, `nro`, `fono`, `cel`, `email`, `nro_rda`, `afp`, `nua`, `item_fiscal`, `nro_seguro_social`, `caja_seguro_social`, `titulado`, `gestiones_trabajo`, `cargo`, `mes`, `observaciones`, `foto`, `fecha_registro`, `user_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'MARIO', 'APAZA', 'LLANOS', '302010', 'LP', 'LA PAZ', '1987-11-01', 36, 'M', 'CASADO', 'ZONA CENTRAL', 'SAAVEDRA', '3423', '2887654', '76564312', '', '45345', '343', '343', '343', '3423423', 'CNS', '1RA FASE', '2013', 'PROFESOR', 'EBERO', '', 'MARIO1698458395.jpg', '2023-10-27', 6, 1, '2023-09-21 01:41:00', '2023-10-28 01:59:55'),
(2, 'MARIO', 'GONZALES', '', '3232', 'CB', 'LA PAZ', '1999-12-04', 23, 'M', 'SOLTERO', 'LOS OLIVOS', 'AV. 32', '1', '', '67676767', '', '1212', '212', '323', '13212', '3223', 'SEGURO', '2DA FASE', '', '', '', '', 'user_default.png', '2023-09-21', 9, 1, '2023-09-21 13:32:10', '2023-09-21 13:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_cursos`
--

CREATE TABLE `profesor_cursos` (
  `id` bigint UNSIGNED NOT NULL,
  `profesor_id` bigint UNSIGNED NOT NULL,
  `nominacion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duracion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesor_cursos`
--

INSERT INTO `profesor_cursos` (`id`, `profesor_id`, `nominacion`, `institucion`, `duracion`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '', '0000-00-00', '2023-09-21 01:41:01', '2023-10-28 01:59:55'),
(2, 1, '', '', '', '0000-00-00', '2023-09-21 01:41:01', '2023-10-28 01:59:55'),
(3, 1, '', '', '', '0000-00-00', '2023-09-21 01:41:02', '2023-10-28 01:59:55'),
(4, 2, '', '', '', '0000-00-00', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(5, 2, '', '', '', '0000-00-00', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(6, 2, '', '', '', '0000-00-00', '2023-09-21 13:32:10', '2023-09-21 13:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_estudios`
--

CREATE TABLE `profesor_estudios` (
  `id` bigint UNSIGNED NOT NULL,
  `profesor_id` bigint UNSIGNED NOT NULL,
  `nivel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anio_egreso` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especialidad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_titulo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesor_estudios`
--

INSERT INTO `profesor_estudios` (`id`, `profesor_id`, `nivel`, `institucion`, `anio_egreso`, `especialidad`, `nro_titulo`, `created_at`, `updated_at`) VALUES
(1, 1, 'SECUNDARIO', '', '', '', '', '2023-09-21 01:41:01', '2023-10-28 01:13:55'),
(2, 1, 'NORMAL', '', '', '', '', '2023-09-21 01:41:01', '2023-10-28 01:13:55'),
(3, 1, 'UNIVERSITARIO', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '2008', 'CIENCIAS DE LA EDUCACIÓN', '2324', '2023-09-21 01:41:01', '2023-10-28 01:13:55'),
(4, 1, 'POST GRADO', '', '', '', '', '2023-09-21 01:41:01', '2023-10-28 01:13:55'),
(5, 1, 'POST GRADO', '', '', '', '', '2023-09-21 01:41:01', '2023-10-28 01:13:55'),
(6, 2, 'Secundario', '', '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(7, 2, 'Normal', '', '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(8, 2, 'Universitario', '', '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(9, 2, 'Post Grado', '', '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(10, 2, 'Post Grado', '', '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_materias`
--

CREATE TABLE `profesor_materias` (
  `id` bigint UNSIGNED NOT NULL,
  `profesor_id` bigint UNSIGNED NOT NULL,
  `nivel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paralelo_id` bigint UNSIGNED NOT NULL,
  `turno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gestion` int NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesor_materias`
--

INSERT INTO `profesor_materias` (`id`, `profesor_id`, `nivel`, `grado`, `paralelo_id`, `turno`, `gestion`, `materia_id`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 'SECUNDARIA', '1', 3, 'MAÑANA', 2023, 2, '2023-09-20', '2023-09-21 01:55:28', '2023-09-21 01:55:28'),
(2, 2, 'SECUNDARIA', '2', 3, 'MAÑANA', 2023, 2, '2023-10-28', '2023-10-28 17:21:21', '2023-10-28 17:21:21'),
(3, 2, 'SECUNDARIA', '2', 3, 'MAÑANA', 2023, 3, '2023-10-28', '2023-10-28 17:21:22', '2023-10-28 17:21:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_otros`
--

CREATE TABLE `profesor_otros` (
  `id` bigint UNSIGNED NOT NULL,
  `profesor_id` bigint UNSIGNED NOT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `turno` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zona` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_horas` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesor_otros`
--

INSERT INTO `profesor_otros` (`id`, `profesor_id`, `institucion`, `turno`, `zona`, `cargo`, `total_horas`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '', '', 0, '2023-09-21 01:41:02', '2023-09-21 01:41:02'),
(2, 1, '', '', '', '', 0, '2023-09-21 01:41:02', '2023-09-21 01:41:02'),
(3, 1, '', '', '', '', 0, '2023-09-21 01:41:02', '2023-09-21 01:41:02'),
(4, 2, '', '', '', '', 0, '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(5, 2, '', '', '', '', 0, '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(6, 2, '', '', '', '', 0, '2023-09-21 13:32:10', '2023-09-21 13:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_trabajos`
--

CREATE TABLE `profesor_trabajos` (
  `id` bigint UNSIGNED NOT NULL,
  `profesor_id` bigint UNSIGNED NOT NULL,
  `institucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gestion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profesor_trabajos`
--

INSERT INTO `profesor_trabajos` (`id`, `profesor_id`, `institucion`, `gestion`, `cargo`, `created_at`, `updated_at`) VALUES
(1, 1, '', '', '', '2023-09-21 01:41:02', '2023-09-21 01:41:02'),
(2, 1, '', '', '', '2023-09-21 01:41:02', '2023-09-21 01:41:02'),
(3, 1, '', '', '', '2023-09-21 01:41:02', '2023-09-21 01:41:02'),
(4, 2, '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(5, 2, '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(6, 2, '', '', '', '2023-09-21 13:32:10', '2023-09-21 13:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razon_socials`
--

CREATE TABLE `razon_socials` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_resolucion` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_sie` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_ue` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_distrito` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_distrito` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_aut` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fono` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cel` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `casilla` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actividad_economica` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `razon_socials`
--

INSERT INTO `razon_socials` (`id`, `codigo`, `nombre`, `alias`, `nro_resolucion`, `codigo_sie`, `tipo_ue`, `ciudad`, `nro_distrito`, `desc_distrito`, `dir`, `nit`, `nro_aut`, `fono`, `cel`, `casilla`, `correo`, `web`, `logo`, `actividad_economica`, `created_at`, `updated_at`) VALUES
(1, 'C1001', 'U. E. PRUEBA', 'UE GV', '0', '0', 'PÚBLICA', 'LA PAZ', '1', 'DISTRITO', 'ZONA CENTRAL CALLE 1', '0', '0', '0', '0', '', '', '', 'logo1698421356.png', 'SERVICIO DE ENSEÑANZA', '2023-05-05 20:15:36', '2023-10-28 01:14:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `materia_id` bigint UNSIGNED NOT NULL,
  `profesor_materia_id` bigint UNSIGNED NOT NULL,
  `gestion` int NOT NULL,
  `nombre` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `fecha_asignacion` date NOT NULL,
  `fecha_limite` date NOT NULL,
  `estado` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea_archivos`
--

CREATE TABLE `tarea_archivos` (
  `id` bigint UNSIGNED NOT NULL,
  `tarea_id` bigint UNSIGNED NOT NULL,
  `link` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('ADMINISTRADOR','SECRETARIA ACADÉMICA','PROFESOR','ESTUDIANTE','TUTOR') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` bigint NOT NULL,
  `estado` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `tipo`, `foto`, `codigo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$.ERox9PjDF0yccV5sWkWk.Dwvq1rPmaXjOTKrdW4y9adSnCFc4bI6', 'ADMINISTRADOR', 'user_default.png', 0, 1, '2023-09-20 19:33:50', '2023-09-20 19:33:50'),
(2, 'PPF100001', '$2y$10$yA7vdUUQKq5oDSfRHMmaKOFjYi4fMdI6NgR3E3ikSkPg5rs6qlRMm', 'ADMINISTRADOR', 'PABLO1698455602.png', 100001, 1, '2023-09-21 00:18:51', '2023-10-28 01:13:22'),
(3, 'CDP500001', '$2y$10$Tswp/Ynexk79GD5sJ2KNtOHcXSZPCz.lFsgYLeF0QZbRUJ/jaDoO6', 'ESTUDIANTE', 'DANIEL1698515013.png', 500001, 1, '2023-09-21 00:24:37', '2023-10-28 17:43:33'),
(6, 'MAL200001', '$2y$10$83tAf8wRwQoA9tsnW1Q/4.4A2/fLVJ6WdZ6vhS4WZWwd5zQudewku', 'PROFESOR', 'MARIO1698458395.jpg', 200001, 1, '2023-09-21 01:41:00', '2023-10-28 01:59:55'),
(9, 'MG200002', '$2y$10$8f0/wYvYeFZA11QJUliCxe.CCbh2ElG9d6KSRrjbMIUJejRhiafRq', 'PROFESOR', 'user_default.png', 200002, 1, '2023-09-21 13:32:10', '2023-09-21 13:32:10'),
(10, 'CGM500002', '$2y$10$DCz8brGPfvi47VEc50rZHeC356Cd3/6TBhi9ZcnKFfiVQMBUV0lVi', 'ESTUDIANTE', 'CARLOS1695303507.jpg', 500002, 1, '2023-09-21 13:38:27', '2023-09-21 13:38:27'),
(12, 'MVM500003', '$2y$10$nVb07HO8bg/.ReU4SPdYAOGxpQ5ieTSUku3MG4aU65toTDRk5tlp.', 'ESTUDIANTE', 'MAMANI1695305977.jpg', 500003, 1, '2023-09-21 14:19:37', '2023-09-21 14:19:37'),
(16, 'FP100002', '$2y$10$NZLbpXX9uBlixatMrm.9iefL.IrxmizHLe5o/huboC.F5v9kKsFNi', 'SECRETARIA ACADÉMICA', 'user_default.png', 100002, 1, '2023-10-28 21:27:18', '2023-10-28 21:27:18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad_profesors`
--
ALTER TABLE `actividad_profesors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrativos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `administrativo_cursos`
--
ALTER TABLE `administrativo_cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrativo_cursos_administrativo_id_foreign` (`administrativo_id`);

--
-- Indices de la tabla `administrativo_estudios`
--
ALTER TABLE `administrativo_estudios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrativo_estudios_administrativo_id_foreign` (`administrativo_id`);

--
-- Indices de la tabla `administrativo_otros`
--
ALTER TABLE `administrativo_otros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrativo_otros_administrativo_id_foreign` (`administrativo_id`);

--
-- Indices de la tabla `administrativo_trabajos`
--
ALTER TABLE `administrativo_trabajos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrativo_trabajos_administrativo_id_foreign` (`administrativo_id`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_campo_id_foreign` (`campo_id`);

--
-- Indices de la tabla `calificacions`
--
ALTER TABLE `calificacions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calificacions_materia_id_foreign` (`materia_id`);

--
-- Indices de la tabla `campos`
--
ALTER TABLE `campos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comunicados`
--
ALTER TABLE `comunicados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entrega_archivos`
--
ALTER TABLE `entrega_archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entrega_archivos_entrega_id_foreign` (`entrega_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiantes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscripcions_estudiante_id_foreign` (`estudiante_id`),
  ADD KEY `inscripcions_paralelo_id_foreign` (`paralelo_id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materias_area_id_foreign` (`area_id`);

--
-- Indices de la tabla `materia_grados`
--
ALTER TABLE `materia_grados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materia_grados_materia_id_foreign` (`materia_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificacions`
--
ALTER TABLE `notificacions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificacion_users`
--
ALTER TABLE `notificacion_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paralelos`
--
ALTER TABLE `paralelos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesors`
--
ALTER TABLE `profesors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesors_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `profesor_cursos`
--
ALTER TABLE `profesor_cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_cursos_profesor_id_foreign` (`profesor_id`);

--
-- Indices de la tabla `profesor_estudios`
--
ALTER TABLE `profesor_estudios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_estudios_profesor_id_foreign` (`profesor_id`);

--
-- Indices de la tabla `profesor_materias`
--
ALTER TABLE `profesor_materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_materias_profesor_id_foreign` (`profesor_id`),
  ADD KEY `profesor_materias_paralelo_id_foreign` (`paralelo_id`),
  ADD KEY `profesor_materias_materia_id_foreign` (`materia_id`);

--
-- Indices de la tabla `profesor_otros`
--
ALTER TABLE `profesor_otros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_otros_profesor_id_foreign` (`profesor_id`);

--
-- Indices de la tabla `profesor_trabajos`
--
ALTER TABLE `profesor_trabajos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_trabajos_profesor_id_foreign` (`profesor_id`);

--
-- Indices de la tabla `razon_socials`
--
ALTER TABLE `razon_socials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tareas_materia_id_foreign` (`materia_id`);

--
-- Indices de la tabla `tarea_archivos`
--
ALTER TABLE `tarea_archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarea_archivos_tarea_id_foreign` (`tarea_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad_profesors`
--
ALTER TABLE `actividad_profesors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `administrativo_cursos`
--
ALTER TABLE `administrativo_cursos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `administrativo_estudios`
--
ALTER TABLE `administrativo_estudios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `administrativo_otros`
--
ALTER TABLE `administrativo_otros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `administrativo_trabajos`
--
ALTER TABLE `administrativo_trabajos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `calificacions`
--
ALTER TABLE `calificacions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campos`
--
ALTER TABLE `campos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comunicados`
--
ALTER TABLE `comunicados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrega_archivos`
--
ALTER TABLE `entrega_archivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `materia_grados`
--
ALTER TABLE `materia_grados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `notificacions`
--
ALTER TABLE `notificacions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion_users`
--
ALTER TABLE `notificacion_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paralelos`
--
ALTER TABLE `paralelos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `profesors`
--
ALTER TABLE `profesors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesor_cursos`
--
ALTER TABLE `profesor_cursos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `profesor_estudios`
--
ALTER TABLE `profesor_estudios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `profesor_materias`
--
ALTER TABLE `profesor_materias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `profesor_otros`
--
ALTER TABLE `profesor_otros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `profesor_trabajos`
--
ALTER TABLE `profesor_trabajos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `razon_socials`
--
ALTER TABLE `razon_socials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tarea_archivos`
--
ALTER TABLE `tarea_archivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `administrativo_cursos`
--
ALTER TABLE `administrativo_cursos`
  ADD CONSTRAINT `administrativo_cursos_administrativo_id_foreign` FOREIGN KEY (`administrativo_id`) REFERENCES `administrativos` (`id`);

--
-- Filtros para la tabla `administrativo_estudios`
--
ALTER TABLE `administrativo_estudios`
  ADD CONSTRAINT `administrativo_estudios_administrativo_id_foreign` FOREIGN KEY (`administrativo_id`) REFERENCES `administrativos` (`id`);

--
-- Filtros para la tabla `administrativo_otros`
--
ALTER TABLE `administrativo_otros`
  ADD CONSTRAINT `administrativo_otros_administrativo_id_foreign` FOREIGN KEY (`administrativo_id`) REFERENCES `administrativos` (`id`);

--
-- Filtros para la tabla `administrativo_trabajos`
--
ALTER TABLE `administrativo_trabajos`
  ADD CONSTRAINT `administrativo_trabajos_administrativo_id_foreign` FOREIGN KEY (`administrativo_id`) REFERENCES `administrativos` (`id`);

--
-- Filtros para la tabla `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_campo_id_foreign` FOREIGN KEY (`campo_id`) REFERENCES `campos` (`id`);

--
-- Filtros para la tabla `calificacions`
--
ALTER TABLE `calificacions`
  ADD CONSTRAINT `calificacions_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `entrega_archivos`
--
ALTER TABLE `entrega_archivos`
  ADD CONSTRAINT `entrega_archivos_entrega_id_foreign` FOREIGN KEY (`entrega_id`) REFERENCES `entregas` (`id`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  ADD CONSTRAINT `inscripcions_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `inscripcions_paralelo_id_foreign` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelos` (`id`);

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Filtros para la tabla `profesors`
--
ALTER TABLE `profesors`
  ADD CONSTRAINT `profesors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `tarea_archivos`
--
ALTER TABLE `tarea_archivos`
  ADD CONSTRAINT `tarea_archivos_tarea_id_foreign` FOREIGN KEY (`tarea_id`) REFERENCES `tareas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
