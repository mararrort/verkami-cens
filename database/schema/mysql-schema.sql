/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `editorials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `editorials` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empresas_name_unique` (`name`),
  UNIQUE KEY `empresas_url_unique` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `m_p_u_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_p_u_s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `presale_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `m_p_u_s_presale_id_foreign` (`presale_id`),
  CONSTRAINT `m_p_u_s_presale_id_foreign` FOREIGN KEY (`presale_id`) REFERENCES `presales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pending_update_presales`;
/*!50001 DROP VIEW IF EXISTS `pending_update_presales`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `pending_update_presales` AS SELECT 
 1 AS `id`,
 1 AS `lastMPU`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `petitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `petitions` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `presale_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presale_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presale_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editorial_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editorial_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editorial_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` enum('Recaudando','Pendiente de entrega','Parcialmente entregado','Entregado','Entregado, faltan recompensas','Abandonado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start` date DEFAULT NULL,
  `announced_end` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `petitions_editorial_id_foreign` (`editorial_id`),
  KEY `petitions_presale_id_foreign` (`presale_id`),
  CONSTRAINT `petitions_editorial_id_foreign` FOREIGN KEY (`editorial_id`) REFERENCES `editorials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `petitions_presale_id_foreign` FOREIGN KEY (`presale_id`) REFERENCES `presales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `solicitud_adicion_preventas_editorial_id_foreign` FOREIGN KEY (`editorial_id`) REFERENCES `editorials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `solicitud_adicion_preventas_presale_id_foreign` FOREIGN KEY (`presale_id`) REFERENCES `presales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `presales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presales` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` enum('Recaudando','Pendiente de entrega','Parcialmente entregado','Entregado','Entregado, faltan recompensas','Abandonado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `editorial_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start` date DEFAULT NULL,
  `announced_end` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `preventas_name_unique` (`name`),
  UNIQUE KEY `preventas_url_unique` (`url`),
  KEY `presales_editorial_id_foreign` (`editorial_id`),
  CONSTRAINT `presales_editorial_id_foreign` FOREIGN KEY (`editorial_id`) REFERENCES `editorials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `preventas_editorial_id_foreign` FOREIGN KEY (`editorial_id`) REFERENCES `editorials` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram` (
  `id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telegram_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telegram_chat` (
  `id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acceptedPetitions` tinyint(1) NOT NULL DEFAULT '0',
  `createdPetitions` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50001 DROP VIEW IF EXISTS `pending_update_presales`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `pending_update_presales` AS select `presales`.`id` AS `id`,max(`m_p_u_s`.`created_at`) AS `lastMPU` from (`presales` left join `m_p_u_s` on((`presales`.`id` = `m_p_u_s`.`presale_id`))) where ((`presales`.`state` in ('Pendiente de entrega','Parcialmente entregado')) and (`presales`.`announced_end` < now())) group by `presales`.`id` having ((`lastMPU` < (now() - interval 1 month)) or (`lastMPU` is null)) order by `presales`.`announced_end` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (26,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (27,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (28,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (29,'2021_04_02_173337_create_empresas_table',1);
INSERT INTO `migrations` VALUES (30,'2021_04_02_183502_create_preventas_table',1);
INSERT INTO `migrations` VALUES (31,'2021_04_04_024645_aÃ±adir_tarde_a_preventas',1);
INSERT INTO `migrations` VALUES (32,'2021_04_04_030434_create_solicitud_adicion_preventas_table',1);
INSERT INTO `migrations` VALUES (33,'2021_04_04_154414_petitions_improvement',1);
INSERT INTO `migrations` VALUES (34,'2021_04_06_204024_create_t_o_d_o_s_table',1);
INSERT INTO `migrations` VALUES (35,'2021_04_07_202442_changed_max_text_lenght',1);
INSERT INTO `migrations` VALUES (36,'2021_04_08_184942_added_info_field_text_to_the_petitions',1);
INSERT INTO `migrations` VALUES (37,'2021_04_10_165752_store_telegram_updates',1);
INSERT INTO `migrations` VALUES (38,'2021_04_10_210746_fix_telegram_id',1);
INSERT INTO `migrations` VALUES (39,'2021_04_11_132731_add_telegram_notification_check',1);
INSERT INTO `migrations` VALUES (40,'2021_04_11_140726_add_recaudation_anounced_and_finish_date',1);
INSERT INTO `migrations` VALUES (41,'2021_04_13_095058_refactor_empresa_to_editorial',1);
INSERT INTO `migrations` VALUES (42,'2021_04_13_105848_refactor_preventa_to_presale',1);
INSERT INTO `migrations` VALUES (43,'2021_04_13_121311_refactor_s_a_p_to_petition',1);
INSERT INTO `migrations` VALUES (44,'2021_04_13_145618_telegram_added_petitions',1);
INSERT INTO `migrations` VALUES (45,'2021_04_15_083825_cascade_remove_the_models',1);
INSERT INTO `migrations` VALUES (46,'2021_04_17_162204_generates_late_automatically',1);
INSERT INTO `migrations` VALUES (47,'2021_04_17_172752_remove_late_from_petitions',1);
INSERT INTO `migrations` VALUES (48,'2021_04_18_131404_automatize_telegram_notifications',1);
INSERT INTO `migrations` VALUES (49,'2021_09_01_111302_create_m_p_u_s_table',1);
INSERT INTO `migrations` VALUES (50,'2021_12_07_160841_remove_t_o_d_o',1);
