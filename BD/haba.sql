-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla db_care_report.campaigns
CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(199) NOT NULL,
  `meta` double(16,2) NOT NULL,
  `id_campaign` varchar(50) NOT NULL,
  `fecha_init` date NOT NULL,
  `fecha_end` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_care_report.campaigns: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
INSERT INTO `campaigns` (`id`, `name`, `meta`, `id_campaign`, `fecha_init`, `fecha_end`) VALUES
	(1, 'NIÑAS CON OPORTUNIDADES', 300.00, 'ABCD', '2022-03-18', '2022-03-18');
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.donadores
CREATE TABLE IF NOT EXISTS `donadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) NOT NULL DEFAULT '0',
  `apellidos` varchar(50) NOT NULL DEFAULT '0',
  `tipoDocumento` varchar(50) NOT NULL DEFAULT '0',
  `documentoIdentidad` varchar(50) NOT NULL DEFAULT '0',
  `tipoDonacion` varchar(50) NOT NULL,
  `monto` double(7,2) NOT NULL,
  `pais` varchar(50) NOT NULL DEFAULT '',
  `region` varchar(50) NOT NULL DEFAULT '0',
  `telefono` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_care_report.donadores: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `donadores` DISABLE KEYS */;
INSERT INTO `donadores` (`id`, `nombres`, `apellidos`, `tipoDocumento`, `documentoIdentidad`, `tipoDonacion`, `monto`, `pais`, `region`, `telefono`, `email`, `create_at`) VALUES
	(1, 'Jorge', 'Acosta', 'DNI', '123', 'Puntual', 50.00, 'Lima', 'Barranco', '12345678', 'cliente1@gmail.com', '2022-03-15 18:50:55'),
	(2, 'Gabriel', 'Dantez', 'RUC', '1234', 'Mensual', 200.00, 'Lima', 'Chorrillos', '87654321', 'cliente2@gmail.com', '2022-03-15 18:50:55');
/*!40000 ALTER TABLE `donadores` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_care_report.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_care_report.migrations: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2021_08_26_045747_create_sessions_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_care_report.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_care_report.personal_access_tokens: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_care_report.sessions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.transacciones
CREATE TABLE IF NOT EXISTS `transacciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaccion_id` varchar(190) NOT NULL,
  `transaccion_token` varchar(190) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `id_campaign` varchar(50) NOT NULL,
  `obj_transaccion` json NOT NULL,
  `obj_cliente` json NOT NULL,
  `monto` double(7,2) NOT NULL,
  `tipo_donacion` varchar(50) NOT NULL,
  `detalles` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla db_care_report.transacciones: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `transacciones` DISABLE KEYS */;
INSERT INTO `transacciones` (`id`, `transaccion_id`, `transaccion_token`, `user_id`, `id_campaign`, `obj_transaccion`, `obj_cliente`, `monto`, `tipo_donacion`, `detalles`, `status`, `created_at`) VALUES
	(1, '993211570048581', 'B9587CD22A06411A987CD22A06E11A3B', 123, 'ABCD', '{}', '{}', 50.00, 'Puntual', 'Aprobado y completado con exito', 'Authorized', '2022-01-07 18:45:27'),
	(2, '983202990266296', '25BBDE35C9A340A1BBDE35C9A350A1AE', 1234, 'ABCD', '{}', '{}', 250.00, 'Mensual', 'Aprobado y completado con exito', 'Authorized', '2022-01-15 18:45:27'),
	(3, '983202990266297', '25BBDE35C9A340A1BBDE35C9A350A1AE', 1234, 'ABCD', '{}', '{}', 100.00, 'Puntual', 'Aprobado y completado con exito', 'Authorized', '2022-02-15 18:45:27'),
	(4, '983202990266298', '25BBDE35C9A340A1BBDE35C9A350A1AE', 1234, 'ABCDE', '{}', '{}', 180.00, 'Mensual', 'Aprobado y completado con exito', 'Authorized', '2022-02-15 18:45:27'),
	(5, '983202990266299', '25BBDE35C9A340A1BBDE35C9A350A1AE', 1234, 'ABCDR', '{}', '{}', 40.00, 'Puntual', 'Aprobado y completado con exito', 'Authorized', '2022-03-15 18:45:27'),
	(6, '983202990266388', '25BBDE35C9A340A1BBDE35C9A350A1AE', 1234, 'ABCDS', '{}', '{}', 60.00, 'Mensual', 'Aprobado y completado con exito', 'Authorized', '2022-03-15 18:45:27');
/*!40000 ALTER TABLE `transacciones` ENABLE KEYS */;

-- Volcando estructura para tabla db_care_report.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_care_report.users: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `device_token`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'AdminP', 'admin@care.org.pe', '$2y$10$AOTktQLEzw9MT0K9gCxqNO9GQ3YsRZela83vQ7K0KIyG44WE0t59q', 'admin', '', '3', '2022-03-15 18:01:11', '2022-03-20 00:38:50'),
	(2, 'Usuario Reportes', 'usuario@care.org.pe', '$2y$10$cGh411gMuAYjfK92M1.YoumgpU00vjLltcpfSzSkaqgasZCGRF8Dq', 'usuario', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9jYXJlX3JlcG9ydC50ZXN0XC9hcGlcL2xvZ2luIiwiaWF0IjoxNjQ3NzM2NzM3LCJuYmYiOjE2NDc3MzY3MzcsImp0aSI6InJZc0NtQWpYelhjWFNId0MiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.0t3BverSLvZFje_rBypvgGtIX0FSgg3S_RY4xsSBiZg', '1', '2022-03-15 18:01:11', '2022-03-20 00:39:14');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
