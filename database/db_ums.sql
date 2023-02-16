-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `image`, `cover_image`, `phone`, `about`, `address`, `status`, `uuid`, `created_at`, `updated_at`) VALUES
(1,	'United Med Staffing',	'info@umsmed.ca',	'$2y$10$iZqnvw.Pl/TKIE3zr44Rbe6taiqxv0fdMA.Jhs484SV5mdConF3mC',	'8776_image.jpg',	'9157_image.jpg',	'416-495-9000',	'InfoIcon Technologies',	'Toronto, Ontario',	1,	'a30b51e9-63e0-4896-b4bc-49e444d098bb',	'2022-12-08 04:14:47',	'2023-01-27 20:02:30'),
(2,	'United Med Staffing',	'admin@admin.com',	'$2y$10$VnaPG2pJpDQtrLeh5xFLzevSDt0e/6kkd38qs1bRAvW/TLUr0vApW',	'8776_image.jpg',	'9157_image.jpg',	'416-495-9000',	'InfoIcon Technologies',	'Toronto, Ontario',	1,	'a30b51e9-63e0-4896-b4bc-49e444d098bb',	'2022-12-08 04:14:47',	'2023-02-01 15:56:37');

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `job_id` int NOT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `booking` (`id`, `user_id`, `job_id`, `status`, `created_at`, `updated_at`) VALUES
(8,	15,	11,	1,	'2023-01-19 07:13:15',	'2023-01-19 07:13:15'),
(9,	15,	10,	1,	'2023-01-19 07:15:34',	'2023-01-19 07:15:34'),
(10,	34,	4,	1,	'2023-02-06 07:47:57',	'2023-02-06 07:47:57');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Personal support work',	1,	'2023-01-04 03:09:41',	'2023-01-04 03:15:57'),
(2,	'Registered Practical Nurses',	1,	'2023-01-04 03:13:31',	'2023-01-04 03:13:31'),
(3,	'3rd dose',	1,	'2023-01-04 03:13:39',	'2023-01-19 05:43:13'),
(4,	'Career',	1,	'2023-01-18 06:25:43',	'2023-01-18 06:25:43');

DROP TABLE IF EXISTS `covid_vaccines`;
CREATE TABLE `covid_vaccines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `covid_vaccines` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1,	'1st Dose',	1,	'2023-01-04 10:28:14',	'2023-01-19 06:11:48'),
(2,	'2nd Dose',	1,	'2023-01-04 10:28:14',	'2023-01-19 06:12:03'),
(3,	'3rd Dose',	1,	'2023-01-04 10:28:24',	'2023-01-19 06:12:15'),
(4,	'4th Dose',	1,	'2023-01-19 06:12:27',	'2023-01-19 06:12:27');

DROP TABLE IF EXISTS `devices`;
CREATE TABLE `devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `devices_user_id_foreign` (`user_id`),
  CONSTRAINT `devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `devices` (`id`, `user_id`, `type`, `token`, `created_at`, `updated_at`) VALUES
(2,	13,	'android',	'dfgsdfgsd',	'2023-01-13 06:56:30',	'2023-01-13 06:56:30'),
(6,	15,	'Android',	'ejWGnBHUTnqrPG4io1DJUe:APA91bEFojnqERE0_afAQ16GI0h6nlYUa3-Hw3oZPgnTR6UwKuSSMvZCoW6scxtDiBAwIqF6RYW6EDhUiDycXTpv9c4P_cZxI2y2NEr6p8K3d7Fj44zUbssBvZ2ot9GPg9hDLy9XlubV',	'2023-01-13 09:12:47',	'2023-01-13 09:12:47'),
(8,	15,	'Android',	'eaYnCR2gQl-Gk8by_D6OJj:APA91bF1MOJckbyX4RDNcROWceIk-QpN_BxyjnLFLbvMFXJpGjT0BXHK7fq7Zq2esopBWPVMqQMytw8XEKgI_6Gu0iui_w9pZ8yAqwFSld-KfqcVIVH4m2N5lNPpR_kKBJLQcZ4LN7GR',	'2023-01-13 10:52:17',	'2023-01-13 10:52:17'),
(9,	15,	'Android',	'fmMeUYhUTt2LcGo1My7Klj:APA91bHZSferupxQJI9Tj0xOWvGKhkZ0T-kRGs0jxppEZBoMw5i4XOmuZ_xZ2jagVhCNI4DXYUAEi_jkk_xEZk9U5SCqtRZGJdPtra1ZVblRHUfyvK4eMgXPmnQ_P34TdxOU_7acFCKh',	'2023-01-13 10:53:59',	'2023-01-13 10:53:59'),
(10,	15,	'Android',	'd7PZZuRxRj2xTkRaFJppI1:APA91bH1_lj92D0WVwRANMeaRSL242QpwFxDlRJT8iuW-Ok6QtWNUS7w8vEhX5p7-Za0gd4QhWxzTW3YZEF4UvTy2NjFYu-I48A3xpooKHYT0TXl6BTK3y_UtpE4GnY1KPJyNrpStxd_',	'2023-01-13 11:04:11',	'2023-01-13 11:04:11'),
(13,	15,	'Android',	'fLvkruN8RhGuK1jMOnJ6JM:APA91bEH_0JCTRZkkTgagk-WQKQn1roW7M84GAJlmLETh_H7dMqZ1xofbodiyVuH19ZvZkTv3C-a2ooxib_-SWLhZulG_iZC6Xi8cB-PNHvKyHXtTdZ32XVEM9VdPLBDzOkG3kxEGBSc',	'2023-01-13 12:10:06',	'2023-01-13 12:10:06'),
(18,	15,	'Android',	'fP4CZm8nRqu6kGKgM4msgp:APA91bETTpO8deOY3yTwCorsILSfDVbMFQjydQkCgeTyP-D_7zMEaw4ALnKrobBHyPziTbNbGFRWqmBMD4I5TcKxXf7jSucWftVAdC36lcIubTHogjiI3CNzIxBDjNzggR5FQ3cC7cMC',	'2023-01-18 11:25:55',	'2023-01-18 11:25:55'),
(20,	16,	'Android',	'cJccR6hBQCC4Y-FwMq_0cD:APA91bF-HCPckn9lrg5W9VVnqhfxu7YSVUifZfwwKk5dt4OMe7KgBODuOhaJhOFEaLdBYAjFPtxMjBk6NlBD_ia7DhpYmHkVGNpJFuV1Cgs189xFxktRrwC1mH1yHXZ5giPF5RNDbMXP',	'2023-01-18 17:51:23',	'2023-01-18 17:51:23'),
(21,	15,	'Android',	'ctlX_AhDRSWKr6Vp2EiUtP:APA91bE2aIJRvpZg3pP1D9et-RJC8EKOk4yiLOCKLvMDzOvsbqX5tPX4qtcDsEzRw700z5fW2zE5v2rGdXwtWSibq5KcOIeFglbCMfJqD8MzqE8v8Js3AGfMraeKNNwRWB4OKwuS9sIf',	'2023-01-19 05:52:23',	'2023-01-19 05:52:23'),
(23,	15,	'Android',	'efWIQIzCSXiR78hLsEH-jA:APA91bGTURB7RXCiXdV4N_YOegU6OADbFHp6bgwfctP3eEdpBOJ_NRRZXgFX2X3cJJlatrPHCizl2t6bt-5TjDk9NFwJRutiExGLecVhcJitcF8MOwrDBgrKG7mqdaGGcADNdWubf21V',	'2023-01-25 08:38:20',	'2023-01-25 08:38:20'),
(34,	33,	NULL,	NULL,	'2023-02-06 07:24:53',	'2023-02-06 07:24:53'),
(37,	34,	'Android',	'eFQGhGJNQgqhDg0nKrIzqa:APA91bFf9PYiui7-HS0sMnq_uEjBnYQY0gcwFQsw37h73MFcbwc2eg-_q-EejHVOAeo9zH89_L8p3kooNfScoEikaxDIpOSVaKlF-RGLht4D6GqVPXmKzfEj4hxwhMXe5TVrFFJ0PSFe',	'2023-02-07 05:25:42',	'2023-02-07 05:25:42'),
(39,	34,	'Android',	'd93OzNhjQU2jwHdxdpnOue:APA91bFSDPedNXivcDMI4R4GiDJGW6NcjXscLl5jWN4pP9qdvWJT9iUNgRWmxEJf8OCSdnQCP-2PNOi2dVhfVk2sHvyQf0ibzCbZMUSaZA-SaFLrysUlutRVsvCOIJfLD6sDWbZhBTGD',	'2023-02-07 06:14:05',	'2023-02-07 06:14:05'),
(40,	34,	'IOS',	'cwBdjMnOM0YIrKDmSYFI3K:APA91bE9JCesTFsB-EeuNCo9ivPoTHw9tF9Go7aKEzumk56_gpNHxQpOV_yVdPzLlNsjCX64V1nyy07eyRIcX8OB2NczuJBA7IChUzSmQPKbopZxzCQILni3h333ZoV4BRFr57_-f2hj',	'2023-02-16 05:28:26',	'2023-02-16 05:28:26');

DROP TABLE IF EXISTS `facilities`;
CREATE TABLE `facilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `facilities` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Noida Sec 8',	1,	'2023-01-30 09:30:47',	'2023-01-30 09:30:47'),
(2,	'Noida Sec 2',	1,	'2023-01-30 09:30:55',	'2023-01-30 09:30:55'),
(3,	'Elm Grove Living Centre',	1,	'2023-01-30 18:49:47',	'2023-01-30 18:49:47'),
(4,	'Belmont House',	1,	'2023-01-30 18:49:59',	'2023-01-30 18:49:59'),
(5,	'Chester Village',	1,	'2023-01-30 18:50:08',	'2023-01-30 18:50:08'),
(6,	'Erinview Retirement',	1,	'2023-01-30 18:50:18',	'2023-01-30 18:50:18'),
(7,	'Green Haven (ETOBICOKE)',	1,	'2023-01-30 18:50:32',	'2023-01-30 18:50:32'),
(8,	'Green Haven (RICHMOND HILL)',	1,	'2023-01-30 18:50:53',	'2023-01-30 18:50:53'),
(9,	'Greenview Lodge Retirement',	1,	'2023-01-30 18:51:18',	'2023-01-30 18:51:18'),
(10,	'Lakeside LTC',	1,	'2023-01-30 18:51:46',	'2023-01-30 18:51:46'),
(11,	'LOFT - Pine Villa',	1,	'2023-01-30 18:53:00',	'2023-01-30 18:53:00'),
(12,	'LOFT - St. Anne\'s',	1,	'2023-01-30 18:53:07',	'2023-01-30 18:53:07'),
(13,	'LOFT - Mount Dennis',	1,	'2023-01-30 18:53:19',	'2023-01-30 18:53:19'),
(14,	'LOFT - Shoreham Hub',	1,	'2023-01-30 18:53:27',	'2023-01-30 18:53:27'),
(15,	'LOFT - Arleta Hub',	1,	'2023-01-30 18:53:33',	'2023-01-30 18:53:33'),
(16,	'LOFT - The Path',	1,	'2023-01-30 19:13:25',	'2023-01-30 19:13:25'),
(17,	'LOFT - CAMH',	1,	'2023-01-30 19:13:38',	'2023-01-30 19:13:38'),
(18,	'Rekai Sherbourne',	1,	'2023-01-30 19:13:46',	'2023-01-30 19:13:46'),
(19,	'Russell Hill',	1,	'2023-01-30 19:13:53',	'2023-01-30 19:13:53'),
(20,	'The Dunfield',	1,	'2023-01-30 19:13:59',	'2023-01-30 19:13:59'),
(21,	'Wellesley Central Place',	1,	'2023-01-30 19:14:05',	'2023-01-30 19:14:05');

DROP TABLE IF EXISTS `failed_jobs`;
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


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facility` int DEFAULT NULL,
  `position` int DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `descriptions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`position`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `jobs` (`id`, `title`, `facility`, `position`, `location`, `time_from`, `time_to`, `date`, `descriptions`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(4,	'Personal Care',	NULL,	NULL,	'gbad, up',	'11:00:00 PM',	'07:00:00 AM',	'2023-01-20',	'<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n\r\n<p><strong>Skills Required</strong></p>\r\n\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n	<li>Etiam vel neque eget lectus fringilla molestie.</li>\r\n	<li>Curabitur nec enim eu elit ullamcorper ultricies at at enim.</li>\r\n	<li>Praesent non neque non</li>\r\n</ul>\r\n\r\n<p><strong>Roles &amp; Responsibilities</strong></p>\r\n\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n	<li>Etiam vel neque eget lectus fringilla molestie.</li>\r\n	<li>Curabitur nec enim eu elit ullamcorper ultricies at at enim.</li>\r\n	<li>Praesent non neque non</li>\r\n</ul>',	'personal-care',	2,	'2023-01-09 09:18:11',	'2023-02-06 07:47:57'),
(10,	'Hospital Staff2',	NULL,	NULL,	'noida, up',	'03:00:00 PM',	'11:00:00 PM',	'2023-01-28',	'<p>Metro Heart Hospital staff work</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n\r\n<p><strong>Skills Required</strong></p>\r\n\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n	<li>Etiam vel neque eget lectus fringilla molestie.</li>\r\n	<li>Curabitur nec enim eu elit ullamcorper ultricies at at enim.</li>\r\n	<li>Praesent non neque non</li>\r\n</ul>\r\n\r\n<p><strong>Roles &amp; Responsibilities</strong></p>\r\n\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n	<li>Etiam vel neque eget lectus fringilla molestie.</li>\r\n	<li>Curabitur nec enim eu elit ullamcorper ultricies at at enim.</li>\r\n	<li>Praesent non neque non</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>',	'hospital-staff2',	2,	'2023-01-10 12:32:27',	'2023-01-19 07:15:34'),
(11,	'Home care',	NULL,	NULL,	'E-32, E block noida sector 8',	'07:00:00 AM',	'03:00:00 PM',	'2023-01-14',	'<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n\r\n<p><strong>Skills Required</strong></p>\r\n\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n	<li>Etiam vel neque eget lectus fringilla molestie.</li>\r\n	<li>Curabitur nec enim eu elit ullamcorper ultricies at at enim.</li>\r\n	<li>Praesent non neque non</li>\r\n</ul>\r\n\r\n<p><strong>Roles &amp; Responsibilities</strong></p>\r\n\r\n<ul>\r\n	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n	<li>Etiam vel neque eget lectus fringilla molestie.</li>\r\n	<li>Curabitur nec enim eu elit ullamcorper ultricies at at enim.</li>\r\n	<li>Praesent non neque non</li>\r\n</ul>',	'home-care',	2,	'2023-01-13 08:40:17',	'2023-01-19 07:13:15'),
(13,	'Test Job',	1,	2,	'dddd',	'11:58:00 AM',	'01:00:00 PM',	'2023-02-10',	'<p>sssssss</p>',	'test-job',	1,	'2023-01-30 05:28:22',	'2023-02-01 08:57:25');

DROP TABLE IF EXISTS `medical_history`;
CREATE TABLE `medical_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` bigint unsigned DEFAULT NULL,
  `title` text,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `medical_history_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `medical_history` (`id`, `job_id`, `title`, `desc`, `created_at`, `updated_at`) VALUES
(2,	4,	'Personal Care',	'<p><strong>Sed porta sem at imperdiet tincidunt.</strong></p>\r\n\r\n<p>It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>',	NULL,	'2023-01-12 09:23:21'),
(3,	10,	'Hospital Staff2',	'<p><strong>Sed porta sem at imperdiet tincidunt.</strong></p>\r\n\r\n<p>It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>',	'2023-01-10 12:32:27',	'2023-01-16 11:46:41'),
(4,	11,	'Home care',	'<p><strong>Sed porta sem at imperdiet tincidunt.</strong></p>\r\n\r\n<p>It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>',	'2023-01-13 08:40:17',	'2023-01-13 08:40:17'),
(6,	13,	NULL,	NULL,	'2023-01-30 05:28:22',	'2023-01-30 10:32:11');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2022_12_08_090502_create_admin_table',	1),
(6,	'2022_12_08_104350_create_settings_table',	2),
(7,	'2022_12_21_052049_create_banners_table',	3),
(8,	'2022_12_21_133122_create_categories_table',	4),
(9,	'2022_12_22_053958_create_partners_table',	5),
(10,	'2022_12_22_061539_create_testimonials_table',	6),
(11,	'2022_12_22_064717_create_enquiries_table',	7),
(12,	'2022_12_22_071146_create_subscribers_table',	8),
(13,	'2022_12_22_073028_create_pages_table',	9),
(14,	'2022_12_26_063902_create_blogs_table',	10),
(15,	'2022_12_26_091430_create_faqs_table',	11),
(16,	'2022_12_26_094532_create_teams_table',	12),
(17,	'2022_12_26_103122_create_galleries_table',	13),
(18,	'2022_12_26_112525_create_products_table',	14),
(19,	'2022_12_26_120544_create_catalogs_table',	15),
(20,	'2022_12_26_130119_create_pagesections_table',	16),
(21,	'2022_12_27_045446_create_signs_table',	17),
(27,	'2016_06_01_000001_create_oauth_auth_codes_table',	18),
(28,	'2016_06_01_000002_create_oauth_access_tokens_table',	18),
(29,	'2016_06_01_000003_create_oauth_refresh_tokens_table',	18),
(30,	'2016_06_01_000004_create_oauth_clients_table',	18),
(31,	'2016_06_01_000005_create_oauth_personal_access_clients_table',	18);

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `created_at`, `updated_at`) VALUES
(1,	0,	'test',	'sdfgsgdf sdf',	NULL,	NULL),
(2,	0,	'job updated: demo title',	'job updated: demo title',	'2023-01-12 07:36:48',	'2023-01-12 07:36:48'),
(3,	0,	'job updated: Past medical problems',	'job updated: Past medical problems',	'2023-01-12 09:11:14',	'2023-01-12 09:11:14'),
(4,	0,	'job updated: Past medical problems',	'job updated: Past medical problems',	'2023-01-12 09:12:46',	'2023-01-12 09:12:46'),
(5,	0,	'job updated: Past medical problems',	'job updated: Past medical problems',	'2023-01-12 09:21:24',	'2023-01-12 09:21:24'),
(6,	0,	'job updated: Past medical problems',	'job updated: Past medical problems',	'2023-01-12 09:22:19',	'2023-01-12 09:22:19'),
(7,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-12 09:22:48',	'2023-01-12 09:22:48'),
(8,	0,	'job updated: Past medical problems',	'job updated: Past medical problems',	'2023-01-12 09:23:09',	'2023-01-12 09:23:09'),
(9,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-12 09:23:21',	'2023-01-12 09:23:21'),
(10,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-12 09:54:07',	'2023-01-12 09:54:07'),
(11,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-12 09:55:09',	'2023-01-12 09:55:09'),
(12,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-12 09:56:00',	'2023-01-12 09:56:00'),
(13,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-12 09:56:59',	'2023-01-12 09:56:59'),
(14,	0,	'Job added Successfully.',	'Job added Successfully.',	'2023-01-13 08:40:17',	'2023-01-13 08:40:17'),
(15,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-13 08:47:59',	'2023-01-13 08:47:59'),
(16,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-13 08:50:56',	'2023-01-13 08:50:56'),
(17,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-13 08:55:46',	'2023-01-13 08:55:46'),
(18,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-13 09:22:20',	'2023-01-13 09:22:20'),
(19,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-13 09:22:54',	'2023-01-13 09:22:54'),
(20,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-13 09:29:38',	'2023-01-13 09:29:38'),
(21,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-13 12:26:01',	'2023-01-13 12:26:01'),
(22,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-13 12:36:09',	'2023-01-13 12:36:09'),
(23,	0,	'job updated: Hospital Staff',	'job updated: Hospital Staff',	'2023-01-16 09:11:07',	'2023-01-16 09:11:07'),
(24,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-16 09:11:26',	'2023-01-16 09:11:26'),
(25,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-16 09:26:33',	'2023-01-16 09:26:33'),
(26,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-16 09:26:44',	'2023-01-16 09:26:44'),
(27,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-16 09:34:21',	'2023-01-16 09:34:21'),
(28,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-16 09:34:32',	'2023-01-16 09:34:32'),
(29,	0,	'job updated: Hospital Staff2',	'job updated: Hospital Staff2',	'2023-01-16 11:46:41',	'2023-01-16 11:46:41'),
(30,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-18 08:46:02',	'2023-01-18 08:46:02'),
(31,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-18 08:46:36',	'2023-01-18 08:46:36'),
(32,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-18 08:47:15',	'2023-01-18 08:47:15'),
(33,	0,	'job updated: Hospital Staff2',	'job updated: Hospital Staff2',	'2023-01-18 08:47:24',	'2023-01-18 08:47:24'),
(34,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-18 08:47:32',	'2023-01-18 08:47:32'),
(35,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-18 08:48:20',	'2023-01-18 08:48:20'),
(36,	0,	'job updated: Hospital Staff2',	'job updated: Hospital Staff2',	'2023-01-18 08:48:34',	'2023-01-18 08:48:34'),
(37,	0,	'job updated: Home care',	'job updated: Home care',	'2023-01-19 07:10:16',	'2023-01-19 07:10:16'),
(38,	0,	'job updated: Hospital Staff2',	'job updated: Hospital Staff2',	'2023-01-19 07:10:57',	'2023-01-19 07:10:57'),
(39,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-19 07:11:38',	'2023-01-19 07:11:38'),
(40,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-27 07:36:59',	'2023-01-27 07:36:59'),
(41,	0,	'job updated: Personal Care',	'job updated: Personal Care',	'2023-01-27 07:37:44',	'2023-01-27 07:37:44'),
(42,	0,	'Job added Successfully.',	'Job added Successfully.',	'2023-01-30 05:26:54',	'2023-01-30 05:26:54'),
(43,	0,	'Job added Successfully.',	'Job added Successfully.',	'2023-01-30 05:28:22',	'2023-01-30 05:28:22'),
(44,	0,	'Job added Successfully.',	'Job added Successfully.',	'2023-01-30 05:59:56',	'2023-01-30 05:59:56'),
(45,	0,	'job updated: sssssss',	'job updated: sssssss',	'2023-01-30 10:32:11',	'2023-01-30 10:32:11'),
(46,	0,	'job updated: sssssss',	'job updated: sssssss',	'2023-01-30 10:38:34',	'2023-01-30 10:38:34'),
(47,	0,	'job updated: sssssss',	'job updated: sssssss',	'2023-01-30 10:40:11',	'2023-01-30 10:40:11'),
(48,	0,	'job updated: sssssss',	'job updated: sssssss',	'2023-01-30 10:41:28',	'2023-01-30 10:41:28'),
(49,	0,	'Job added Successfully.',	'Job added Successfully.',	'2023-01-30 16:50:30',	'2023-01-30 16:50:30'),
(50,	0,	'job updated: sssssss',	'job updated: sssssss',	'2023-02-01 08:55:35',	'2023-02-01 08:55:35'),
(51,	0,	'job updated: Test Job',	'job updated: Test Job',	'2023-02-01 08:57:25',	'2023-02-01 08:57:25'),
(52,	0,	'job updated: Test Job',	'job updated: Test Job',	'2023-02-07 05:57:45',	'2023-02-07 05:57:45'),
(53,	0,	'job updated: Test Job',	'job updated: Test Job',	'2023-02-07 06:06:45',	'2023-02-07 06:06:45'),
(54,	0,	'job updated: Test Job',	'job updated: Test Job',	'2023-02-07 06:23:31',	'2023-02-07 06:23:31');

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('016c81a7a77ef8d5730fd7fdc1bacf3297121051c363351157252303bcceaee42540a3347433154a',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 11:13:37',	'2023-01-13 11:13:37',	'2024-01-13 11:13:37'),
('0b48e7fd91704c7c69915aa27ca5cdeb0d949dd414e401b57f8516776d99dc0d2d049cf734b31937',	4,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-05 02:15:08',	'2023-01-05 02:15:08',	'2024-01-05 07:45:08'),
('1bbfc154866039c2a66e670b854ef33997cc1bd286151d853fd78194c49bdb4a29d2b15fe49afae9',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 08:35:53',	'2023-01-13 08:35:53',	'2024-01-13 08:35:53'),
('1bd60872059bbc64c115ecfb21c7586454556bec81d030855571f21cca321a9cf7b80e5ed9134617',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-11 13:07:16',	'2023-01-11 13:07:16',	'2024-01-11 13:07:16'),
('25197ac5bfae938ba070156080b31b8ef8746697c215f71837375607ce30f47679ef220cbc4ae044',	34,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-07 05:25:42',	'2023-02-07 05:25:42',	'2024-02-07 05:25:42'),
('263027ab9defba7cb4410c9f5649f32ff48903c12985a227e852d3637bf52d6fcc4fac31a5574c5b',	8,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 10:45:30',	'2023-01-06 10:45:30',	'2024-01-06 10:45:30'),
('27d174153d79a49c67fb32a92c2155960f8e3aaef224ff2306219b94ef133943288735bd40f5f4f8',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-09 12:30:39',	'2023-01-09 12:30:39',	'2024-01-09 12:30:39'),
('27fd6e8aa8e5b49f5fc28ac3a9f3503d2270171725d87ed91ed48b6c67197ea934def8f0a5b03cf9',	33,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 07:24:55',	'2023-02-06 07:24:55',	'2024-02-06 07:24:55'),
('289021494f20fd06d857886b1c299635d64bf89645127cbf7f6d4e5d9c22a7fb2d58722dd9feaf6b',	34,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-16 05:28:26',	'2023-02-16 05:28:26',	'2024-02-16 05:28:26'),
('294c867bf004b0edbe72c158c2995d3203c7d04a38d3b79622caea008acf99f178277eb322ebc076',	32,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:58:46',	'2023-02-06 06:58:46',	'2024-02-06 06:58:46'),
('2b837d042e51d8aa3975cee1a027c93dfad7291d4add97798d3be6ffc11f95fe192aed43cb147fb8',	11,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 10:49:19',	'2023-01-06 10:49:19',	'2024-01-06 10:49:19'),
('2f57c40df89a75a76df7ae1ddc40a7454008b668d8f7dc1bd35fd6f75a966e54fcceec641542bde2',	2,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-09 12:28:41',	'2023-01-09 12:28:41',	'2024-01-09 12:28:41'),
('2fc6e06ddd801d629b37408937616307b1dced7880b5249874a051b4ddcf1d4bb0eafac726cfc794',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 12:10:06',	'2023-01-13 12:10:06',	'2024-01-13 12:10:06'),
('33733b1922b261754919fcac2f013b2080480b5ced13da1eac98fee5afa979b4d25e1c0eedacd368',	1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-05 10:07:33',	'2023-01-05 10:07:33',	'2024-01-05 10:07:33'),
('33b1d0712b984bf0b75daa3f3f5556142cbb7955fff4c2dda67a3f5ece3232a66e91c5e474b882b9',	1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-05 02:16:03',	'2023-01-05 02:16:03',	'2024-01-05 07:46:03'),
('3de13c8f75a346562346f208f17f5cfb911e712ea1f323a490ab3a798f6d08d84f0ca60731a20a3f',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-10 10:37:38',	'2023-01-10 10:37:38',	'2024-01-10 10:37:38'),
('4298730ff4ec0bf617d85b300dc8f86366d4fcc82c103cd54e172334296f1264f6b0f4a493086479',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 11:04:11',	'2023-01-13 11:04:11',	'2024-01-13 11:04:11'),
('4904d8c0078fc128f31264403b90de02037f815df18d91f21c6faf444d7a78b7b1fdc451bd753576',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 09:11:46',	'2023-01-13 09:11:46',	'2024-01-13 09:11:46'),
('4aee412f39c8dd89bffc1c747360d16d1e9b1e1e7b8c45879f74e355d7f57202d05812ba6f006bd1',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 11:35:16',	'2023-01-12 11:35:16',	'2024-01-12 11:35:16'),
('4e6578dbdd4d8e689ac0135ec63cb54a21ed75ffbd7556b4953224351049d1fc2eb9f51085eafcbb',	14,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 09:36:41',	'2023-01-12 09:36:41',	'2024-01-12 09:36:41'),
('4e9ae8ca399627f2fcdfb6164f2c0703f07b19d7d8d4a5871e9d5d2ed1293f7607852b013a180096',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-25 08:55:10',	'2023-01-25 08:55:10',	'2024-01-25 08:55:10'),
('50ee2abd656c0119445a978a465b55b4e67d46406e98eefcd933f84f581b223d85353d8becb5b8a9',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'newToken',	'[]',	0,	'2023-01-09 12:20:53',	'2023-01-09 12:20:53',	'2024-01-09 12:20:53'),
('51bd15e3724d05dec2765e3e451f7cc8e82323b83ba936f1f9fc893ea0e124c72e939aaa1585cec9',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 06:55:01',	'2023-01-13 06:55:01',	'2024-01-13 06:55:01'),
('5578a470297016fcf2b615c1904da53fea3090ef462b75fcd71f6fef8e112ed92ba60fcf58ced800',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 11:45:21',	'2023-01-12 11:45:21',	'2024-01-12 11:45:21'),
('569723a9f080e3dc72c8e506a3898d368558388e4180204f68a9b631100139e8600197095d4ac79a',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	1,	'2023-01-09 12:23:13',	'2023-01-09 12:23:13',	'2024-01-09 12:23:13'),
('5719500aa2e63ac80d31b447ba798429e4fae9f38805f84105b31003fed7e2cc2939f94c49cb0b09',	1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-05 02:17:29',	'2023-01-05 02:17:29',	'2024-01-05 07:47:29'),
('5fd4dbda64910ff4c734784f91ef8f4a04c83978300d39309078e9529ae986e7e34dd02c9899775f',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 11:06:26',	'2023-01-06 11:06:26',	'2024-01-06 11:06:26'),
('643e314e17f6a1cda7dc658d01efd3070bb5be3d30bbd6640a4fe96b5689d09d509a47c1643e0738',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-16 09:24:28',	'2023-01-16 09:24:28',	'2024-01-16 09:24:28'),
('69292007823bc233ccf395d2a0419cf723c8d12ec838bccf55934662a60849a50b6b3620ac94dc7f',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-16 09:14:52',	'2023-01-16 09:14:52',	'2024-01-16 09:14:52'),
('6c6630accc2c71e7381d4a5adac0fefcef079bc59b221bbc4e4a9473ffc08b4dabd76f917c117255',	16,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-18 17:51:23',	'2023-01-18 17:51:23',	'2024-01-18 17:51:23'),
('7077121593a97036bfe9188bf323d9cc5d3304926b5074584570227445fc3553e639d001993646f6',	2,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 07:06:01',	'2023-01-06 07:06:01',	'2024-01-06 07:06:01'),
('7236e6111e47bb797bf1705daafe8c54af12d8725ca1a7b689e2111353635949ea2b9150fc36b685',	16,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-18 17:48:48',	'2023-01-18 17:48:48',	'2024-01-18 17:48:48'),
('728804bb4897b4d342312423769866ba9f2fb26d0b735ecf073c911d67cc1e8442392b0822f667eb',	10,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 10:47:38',	'2023-01-06 10:47:38',	'2024-01-06 10:47:38'),
('77f0ab036fe812dfe968980718f05c294b52ef40c3d0374d86eb84e943fa44fbf27ecf014ff11f81',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-19 05:52:23',	'2023-01-19 05:52:23',	'2024-01-19 05:52:23'),
('7c576bf4348ffdfb71c67e9f0f21b7706345ab5fc4d2f16c6331fdbedbe43a4c4efdb7a3da99efe2',	32,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:56:33',	'2023-02-06 06:56:33',	'2024-02-06 06:56:33'),
('7d20d9807cdd88527d8bcb623a5a168af141eaaf7e87fdd9574f346c24164c1d6d048ce0b14c9483',	9,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 10:46:05',	'2023-01-06 10:46:05',	'2024-01-06 10:46:05'),
('7ec398c3a53ae0aee8b18dadb4f5687ce1a91e4b056f98eec19f037ed4f6e58d078ebd9f126215c0',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-09 05:48:52',	'2023-01-09 05:48:52',	'2024-01-09 05:48:52'),
('7fd60efcd9e3e0f47cc17f88ed6f57d5b4d6aef639cf98229c100404ca417ebe2c770ecac6181b13',	2,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-09 12:25:56',	'2023-01-09 12:25:56',	'2024-01-09 12:25:56'),
('7febacfa56c837341df8399c8d0188ae92c64b5f8bc8be5eee74150bccb0fb479a2d988367b4602c',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-25 08:37:33',	'2023-01-25 08:37:33',	'2024-01-25 08:37:33'),
('81de43b7e00370aca9562caddb183e6a2fb003f196aecc8f56dc863281cee8927d0393ff96fa98e6',	30,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:47:46',	'2023-02-06 06:47:46',	'2024-02-06 06:47:46'),
('8209ce6508cf404574fdcc11db4e43523a62d347494047b5bcec99925382709b4ec0c46ef99432ce',	25,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-30 13:29:52',	'2023-01-30 13:29:52',	'2024-01-30 13:29:52'),
('8335ee37cf289c679b0b0d6d50108470e8c3ea87fea0b99cd4d329750c9ea415aedce16a2532770b',	2,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 07:03:54',	'2023-01-06 07:03:54',	'2024-01-06 07:03:54'),
('8723d1a47fdfb71896613f205519b0bcfd3cda89c9840d8c3af3b5a179210a53f0840f277d6ee8c1',	29,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:44:38',	'2023-02-06 06:44:38',	'2024-02-06 06:44:38'),
('8d7592e704622088094af7cac9106e54eb470b136f2d2a97edcb541437dd8c7193f7fbfa57b528a4',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 07:57:19',	'2023-01-13 07:57:19',	'2024-01-13 07:57:19'),
('8f4d544ca7cd7ffdd324492d7e29754a1da7ee47e81c686931b476348168a4e35809e0e9aed6aa16',	34,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-07 05:24:20',	'2023-02-07 05:24:20',	'2024-02-07 05:24:20'),
('90a7020ab966cae988407a4cab1e20dbdf299832c8e432c9a799850c6eccf37608dffc300c68b5bf',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-18 07:10:53',	'2023-01-18 07:10:53',	'2024-01-18 07:10:53'),
('9670c19dc860a6c8733536360b7968eca8777ffa67bf74aecfd68a45ab4bd1c633cdb241d9dcbf8a',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 11:09:23',	'2023-01-13 11:09:23',	'2024-01-13 11:09:23'),
('987a3e5be03961917032e3e22a1f9e2348a49519382395cbc97e9fe28ecc287ecea0a734f33334c6',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 06:56:30',	'2023-01-13 06:56:30',	'2024-01-13 06:56:30'),
('9e1e46a3d47ca68c12961748a92b07faba802a34895d3e881a5da23b97d3b90f2c03cb82ad68a211',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 10:52:17',	'2023-01-13 10:52:17',	'2024-01-13 10:52:17'),
('a168cfef409c72e2251d8a1627943331e4634186b799937938bb3fb657a3a2e88276b235c708de86',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	1,	'2023-01-09 06:09:38',	'2023-01-09 06:09:38',	'2024-01-09 06:09:38'),
('a52f1530df4b9003f7b4805f938edfce3b82b430228978ddae3166eb643e42f620bf45a660e6f98f',	34,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-07 06:13:03',	'2023-02-07 06:13:03',	'2024-02-07 06:13:03'),
('ac8c1258b5b4e6d9dce3b199b8ce93042f453f040fb421a24712054599af15f28a60769678576854',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 10:53:59',	'2023-01-13 10:53:59',	'2024-01-13 10:53:59'),
('b448d1ea3ddd88e771809c0ea458d06042d037c37a95146c0f2bcc7ff83f0a9e0679e84e939cf26c',	34,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-07 06:14:05',	'2023-02-07 06:14:05',	'2024-02-07 06:14:05'),
('b565fe22ab59032ed77253865d1ae58a2ae38d2cd2e661570ff00bb21113df7839c1b18aa496bc1e',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 06:22:12',	'2023-01-13 06:22:12',	'2024-01-13 06:22:12'),
('bb5a2d1dbf0525d9218ad7f91184e0d86d93f84c442ff6e061c43cf185a9161d855a9ec004129d54',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 09:47:43',	'2023-01-12 09:47:43',	'2024-01-12 09:47:43'),
('be843dba427e86cb3895902aa0fe1e3e4fdad97a558059b82a4ec6ec51474e09e11f0c7833aa2f87',	31,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:48:58',	'2023-02-06 06:48:58',	'2024-02-06 06:48:58'),
('c410c0a21aaa5190ccd6d4361f1718287a95b92896181a69964bd8078fa32db93ac6da99017f1381',	12,	'98265720-94e1-423e-b486-56b5ecc837f2',	'newToken',	'[]',	0,	'2023-01-09 12:25:16',	'2023-01-09 12:25:16',	'2024-01-09 12:25:16'),
('c5610c0fe09f9c449594f329b28f3b71098127c91d9612385d6e8576c295d3fb9ad6c182204fb797',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 12:16:06',	'2023-01-12 12:16:06',	'2024-01-12 12:16:06'),
('c7a57e1867bd9f20a85fb57d8e89caab674cb5be1f00fd529a2d205cea78f2c7524cdf8e63e9fbeb',	2,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-05 02:09:57',	'2023-01-05 02:09:57',	'2024-01-05 07:39:57'),
('c8a64f366ecb67d0d9bc39abcb2b26a1269ed6e3925fab8c7d3171121aa2baea17583bdca648f6dd',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-16 07:26:41',	'2023-01-16 07:26:41',	'2024-01-16 07:26:41'),
('ca424e84188c1958f6ed4e2e0ec93f9f87098695cba43c67c695b37768eaa581526fd6341949247d',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 09:12:47',	'2023-01-13 09:12:47',	'2024-01-13 09:12:47'),
('d123a54cd2ade16021e84cc1139249546ec14f255c77b85c5cbea3176ea885d9d5bb97e04f29885f',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 10:43:30',	'2023-01-13 10:43:30',	'2024-01-13 10:43:30'),
('d145a01d67ac1e16b5e8ff81f6f9c3e36f6e83498c36e77c605a7395832c6bddbabb546ceac4d2cb',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-25 08:38:20',	'2023-01-25 08:38:20',	'2024-01-25 08:38:20'),
('db2b99fcb04a0d04c82f93c86756430e7c2c6ccb9837963512076a7dccb567aa7d54cc817e9a3408',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-09 05:32:24',	'2023-01-09 05:32:24',	'2024-01-09 05:32:24'),
('df24bf2d7152007cbd5feee592279fdc7a3f02accc00d407e089329c454eb456a080eb43cdd41aaa',	26,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:19:18',	'2023-02-06 06:19:18',	'2024-02-06 06:19:18'),
('df84f0f87a0ddb28c5c73fd106e7a2db323499b28919003b1e830a7f2a27b77a6b6753ac27d1f0d2',	13,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-10 09:08:36',	'2023-01-10 09:08:36',	'2024-01-10 09:08:36'),
('e115e184657e5a899704b255cf4537c141e2e62e05ef724b0e7e674e7f7165d66308fea3a721f859',	34,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 07:41:25',	'2023-02-06 07:41:25',	'2024-02-06 07:41:25'),
('e4b66249a0515c6e2d920e090cfdb55d96d710aaf4da78a74cb96d9eaa017337a6d6170ec4bb16ca',	1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'newToken',	'[]',	0,	'2023-01-05 10:52:23',	'2023-01-05 10:52:23',	'2024-01-05 10:52:23'),
('e58b268a4df1f8ede586fa4aa2232aec187056482f29f2011e169ff9cddb5bbf9adfd3e3d5e5b737',	1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	1,	'2023-01-05 10:50:50',	'2023-01-05 10:50:50',	'2024-01-05 10:50:50'),
('e5e7877a31dd440937123405805e954ea7ce0967f59ae963d58680564e6a40a6a1762129b6fe691f',	28,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-02-06 06:42:41',	'2023-02-06 06:42:41',	'2024-02-06 06:42:41'),
('e68712286504a70fb2824b9410d6fe7092e8ddbb0b3f588dca0583ac5a13dda8752a46cc88ade770',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-18 11:25:55',	'2023-01-18 11:25:55',	'2024-01-18 11:25:55'),
('eca7e5ac912d8dad96c05f750584c20cd9cfa420a32be3964d8876145403278b7b397b12b8ed46be',	1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-05 02:19:53',	'2023-01-05 02:19:53',	'2024-01-05 07:49:53'),
('f192007971673e714f6172719e24cbd6b6e6ddd4d29ee87ff63c8c6da7306a6c864df61b55a8b532',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 09:59:16',	'2023-01-12 09:59:16',	'2024-01-12 09:59:16'),
('f21dc7c871c711da0fdcfbfae884a2152c182c4a22b3df2366a33eb17c079ecb2a542da6a193d177',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-13 05:26:58',	'2023-01-13 05:26:58',	'2024-01-13 05:26:58'),
('f2970a0ff63926cc32a04ab77109db1da27db15a053ede4d3e402b33b71babb48c6b02402c262c0a',	18,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-30 12:56:57',	'2023-01-30 12:56:57',	'2024-01-30 12:56:57'),
('f95158402c62a98cb9d91c5884392f722f1fde2d0ff2d6db96462716f6f266bb2ec91af4fce67845',	2,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-09 12:28:56',	'2023-01-09 12:28:56',	'2024-01-09 12:28:56'),
('f959384757b3f57d9f7f27886f8968e70f9600e11560716c4e3cf609868cab630bb56eb87acfa769',	15,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-12 11:37:47',	'2023-01-12 11:37:47',	'2024-01-12 11:37:47'),
('fb3c940f00c0a22427980df2506c0d74215b09681ec5977feb79ce15a0de0df126ce4e4df0f74253',	5,	'98265720-94e1-423e-b486-56b5ecc837f2',	'LaravelAuthApp',	'[]',	0,	'2023-01-06 10:37:14',	'2023-01-06 10:37:14',	'2024-01-06 10:37:14');

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('98265720-94e1-423e-b486-56b5ecc837f2',	NULL,	'ums',	'VCw1TXjbS6xlAOF2E0bx3Z3CEacBigoDy7ihtQhs',	NULL,	'http://localhost',	1,	0,	0,	'2023-01-05 02:09:39',	'2023-01-05 02:09:39');

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1,	'98265720-94e1-423e-b486-56b5ecc837f2',	'2023-01-05 02:09:39',	'2023-01-05 02:09:39');

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `page_sections`;
CREATE TABLE `page_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `descriptions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `page_sections` (`id`, `title`, `sub_title`, `image`, `short_desc`, `descriptions`, `status`, `created_at`, `updated_at`) VALUES
(1,	'about us',	'March 2018',	'/storage/pageSection/22122771251bf-baner.jpg',	NULL,	'<p>Signaco doo, a company for the production of traffic and non-traffic signs, was founded in 1994 as a subsidiary of Signa doo, a company for the implementation of horizontal signage.&nbsp;The main activity of the company is the production of road traffic signs.&nbsp;Due to the demands of the market, we have expanded our offer and added traffic equipment and other signaling as well as the offer of other equipment to ensure safety in road and other traffic.</p>\r\n\r\n<p>In addition to the production of traffic signs and other signs, our program also offers other necessary materials - supporting poles, portals, anchors and other communal and urban equipment necessary for the comprehensive arrangement of construction sites or the improvement of the existing situation.</p>\r\n\r\n<p>In more than 20 years of the company&#39;s existence, we have installed our products on highways, national and local roads, private and other land as well as on railways and other facilities, so we are sure that with our knowledge and experience we can satisfy and always find the most suitable solution for our customers.</p>\r\n\r\n<p>Ale&scaron; Babnik, director</p>',	1,	'2022-12-27 01:36:29',	'2022-12-27 01:42:51'),
(2,	'Izdelajte svoj znak po meri v samo treh korakih!',	NULL,	'/storage/pageSection/22122772354ps1.jpg',	NULL,	'<p>Vsi produkti so izdelani po najvi&scaron;jih standardih kakovosti in so tako obstojni in odporni na vse vremenske vplive, hkrati pa izgledajo odlično.</p>\r\n\r\n<p>V na&scaron;em urejevalniku lahko svojo idejo spremenite v čudovito darilo in z njim presenetite svoje bližnje.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores enim magnam totam, ullam aliquid nihil delectus qui iusto ratione deserunt id mollitia doloribus inventore cum earum sunt voluptates reiciendis vero.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores enim magnam totam, ullam aliquid nihil delectus qui iusto ratione deserunt id mollitia doloribus inventore cum earum sunt voluptates reiciendis vero.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores enim magnam totam, ullam aliquid nihil delectus qui iusto ratione deserunt id mollitia doloribus inventore cum earum sunt voluptates reiciendis vero.</p>',	1,	'2022-12-27 01:53:54',	'2022-12-27 01:53:54'),
(3,	'Izdelajte svoj znak po meri v samo treh korakih!',	NULL,	'/storage/pageSection/22122772416ps2.jpg',	NULL,	'<p>Vsi produkti so izdelani po najvi&scaron;jih standardih kakovosti in so tako obstojni in odporni na vse vremenske vplive, hkrati pa izgledajo odlično.</p>\r\n\r\n<p>V na&scaron;em urejevalniku lahko svojo idejo spremenite v čudovito darilo in z njim presenetite svoje bližnje.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores enim magnam totam, ullam aliquid nihil delectus qui iusto ratione deserunt id mollitia doloribus inventore cum earum sunt voluptates reiciendis vero.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores enim magnam totam, ullam aliquid nihil delectus qui iusto ratione deserunt id mollitia doloribus inventore cum earum sunt voluptates reiciendis vero.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores enim magnam totam, ullam aliquid nihil delectus qui iusto ratione deserunt id mollitia doloribus inventore cum earum sunt voluptates reiciendis vero.</p>',	1,	'2022-12-27 01:54:16',	'2022-12-27 01:54:16'),
(4,	'Free Shipping Returns',	NULL,	NULL,	'For all orders over $99',	NULL,	1,	'2022-12-30 01:27:42',	'2022-12-30 01:27:42'),
(5,	'Secure Payment',	NULL,	NULL,	'We ensure secure payment',	NULL,	1,	'2022-12-30 01:27:57',	'2022-12-30 01:27:57'),
(6,	'Money Back Guarantee',	NULL,	NULL,	'Any back within 30 days',	NULL,	1,	'2022-12-30 01:28:10',	'2022-12-30 01:28:10'),
(7,	'Customer Support',	NULL,	NULL,	'Call or email us 24/7',	NULL,	1,	'2022-12-30 01:28:23',	'2022-12-30 01:28:23'),
(8,	'Subscribe To Our Newsletter',	NULL,	NULL,	'Get all the latest information on Events, Sales and Offers.',	NULL,	1,	'2022-12-30 01:28:50',	'2022-12-30 01:28:50');

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descriptions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pages` (`id`, `title`, `image`, `descriptions`, `slug`, `meta_title`, `meta_keyword`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Terms and Conditions',	NULL,	'<p>coming soon..</p>',	'terms-and-conditions',	NULL,	NULL,	NULL,	1,	'2023-01-31 05:37:30',	'2023-01-31 05:37:30'),
(2,	'Privacy Policy',	NULL,	'<p>coming soon...</p>',	'privacy-policy',	NULL,	NULL,	NULL,	1,	'2023-01-31 05:37:58',	'2023-01-31 05:37:58');

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `patients` (`id`, `job_id`, `name`, `dob`, `gender`, `state`, `city`, `zip_code`, `created_at`, `updated_at`) VALUES
(2,	4,	'Gaurav Sharma',	'2023-01-27',	'Male',	'UP',	'Noida',	201301,	'2023-01-10 12:07:15',	'2023-01-10 12:07:15'),
(3,	10,	'Hospital Staff',	'2023-01-20',	'Female',	'Uttar Pradesh',	'Noida',	201301,	'2023-01-12 09:54:07',	'2023-01-12 09:54:07'),
(4,	11,	'Jhon',	'2001-06-12',	'Female',	'Uttar Perdash',	'Noida',	201301,	'2023-01-13 08:40:17',	'2023-01-13 08:40:17'),
(6,	13,	'milly',	'2023-01-04',	'Female',	'sssss',	'dddd',	15151,	'2023-01-30 05:28:22',	'2023-01-30 05:28:22');

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `positions` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Caregiver',	1,	'2023-01-30 06:37:16',	'2023-01-30 06:37:16'),
(2,	'PSW',	1,	'2023-01-30 06:37:21',	'2023-01-30 06:37:21'),
(3,	'RPN',	1,	'2023-01-30 06:37:29',	'2023-01-30 06:37:29'),
(4,	'RN',	1,	'2023-01-30 06:37:35',	'2023-01-30 06:37:35');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1,	'sitename',	'UMS',	NULL,	'2023-01-19 05:38:37'),
(2,	'default_meta_title',	'ums',	NULL,	'2023-01-19 05:38:37'),
(3,	'default_meta_keywords',	'ums',	NULL,	'2023-01-19 05:38:37'),
(4,	'default_meta_description',	'Welcome to UMS Healthcare Agency! This app was designed to create a better employee experience that allows you to control when and where you work from the palm of your hand.',	NULL,	'2023-01-19 05:38:37'),
(5,	'site_email',	'info@umsmed.ca',	NULL,	'2023-01-19 05:38:37'),
(6,	'site_phone',	'4164959000',	NULL,	'2023-01-19 05:38:37'),
(7,	'facebook_url',	'www.facebook.com/',	NULL,	'2023-01-19 05:38:37'),
(8,	'instagram_url',	'www.instagram.com/',	NULL,	'2023-01-19 05:38:37'),
(9,	'twitter_url',	'www.twitter.com/',	NULL,	'2023-01-19 05:38:37'),
(10,	'linkedin_url',	'www.linkedin.com/',	NULL,	'2023-01-19 05:38:37'),
(11,	'site_address',	'Noida, India',	NULL,	'2023-01-19 05:38:37'),
(12,	'_token',	'ax0rT9KWp92LYBz2AF7fZvKqqbRHDSxEezxAahA0',	'2023-01-02 02:24:18',	'2023-01-19 05:38:37');

DROP TABLE IF EXISTS `slots`;
CREATE TABLE `slots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `from_time` varchar(255) DEFAULT NULL,
  `to_time` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `slots` (`id`, `user_id`, `from_time`, `to_time`, `date`, `status`, `created_at`, `updated_at`) VALUES
(4,	15,	'05:25:00 pm',	'07:25:00 pm',	'2023-01-18',	1,	'2023-01-18 08:45:11',	'2023-01-18 08:45:11'),
(13,	15,	'06:00:00 am',	'06:30:00 am',	'2023-01-18',	1,	'2023-01-18 08:52:03',	'2023-01-18 08:52:03'),
(14,	15,	'12:00:00 AM',	'12:00:00 AM',	'2023-01-19',	1,	'2023-01-19 06:19:47',	'2023-01-19 06:19:47'),
(15,	15,	'07:00:00 AM',	'03:00:00 PM',	'2023-01-19',	1,	'2023-01-19 06:48:37',	'2023-01-19 06:48:37'),
(16,	15,	'12:00:00 AM',	'12:00:00 AM',	'2023-01-22',	1,	'2023-01-19 07:01:24',	'2023-01-19 07:01:24'),
(17,	15,	'03:00:00 PM',	'11:00:00 PM',	'2023-01-24',	1,	'2023-01-19 07:24:53',	'2023-01-19 07:24:53'),
(18,	15,	'07:00:00 AM',	'03:00:00 PM',	'2023-01-24',	1,	'2023-01-19 09:06:07',	'2023-01-19 09:06:07'),
(19,	15,	'03:00:00 PM',	'11:00:00 PM',	'2023-01-21',	1,	'2023-01-20 08:48:08',	'2023-01-20 08:48:08'),
(20,	15,	'07:00:00 AM',	'03:00:00 PM',	'2023-01-22',	1,	'2023-01-20 08:48:17',	'2023-01-20 08:48:17'),
(21,	15,	'03:00:00 PM',	'11:00:00 PM',	'2023-01-23',	1,	'2023-01-20 08:48:22',	'2023-01-20 08:48:22'),
(22,	15,	'12:00:00 AM',	'12:00:00 AM',	'2023-01-24',	0,	'2023-01-20 08:48:31',	'2023-01-20 08:48:31'),
(23,	15,	'03:00:00 PM',	'11:00:00 PM',	'2023-01-26',	1,	'2023-01-23 06:16:53',	'2023-01-23 06:16:53'),
(24,	15,	'03:00:00 PM',	'11:00:00 PM',	'2023-01-25',	1,	'2023-01-23 06:17:25',	'2023-01-23 06:17:25'),
(25,	15,	'11:00:00 PM',	'07:00:00 AM',	'2023-02-06',	1,	'2023-02-06 05:11:10',	'2023-02-06 05:11:10'),
(26,	15,	'11:00:00 PM',	'07:00:00 AM',	'2023-02-07',	1,	'2023-02-06 05:11:24',	'2023-02-06 05:11:24'),
(27,	34,	'03:00:00 PM',	'11:00:00 PM',	'2023-02-06',	1,	'2023-02-06 07:47:28',	'2023-02-06 07:47:28'),
(28,	34,	'03:00:00 PM',	'11:00:00 PM',	'2023-02-07',	1,	'2023-02-06 07:47:32',	'2023-02-06 07:47:32'),
(29,	34,	'03:00:00 PM',	'11:00:00 PM',	'2023-02-08',	1,	'2023-02-06 07:47:37',	'2023-02-06 07:47:37'),
(30,	34,	'07:00:00 AM',	'03:00:00 PM',	'2023-02-16',	1,	'2023-02-16 05:28:53',	'2023-02-16 05:28:53');

DROP TABLE IF EXISTS `time_sheets`;
CREATE TABLE `time_sheets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `time_sheets` (`id`, `user_id`, `title`, `image`, `time`, `date`, `created_at`, `updated_at`) VALUES
(1,	15,	'Test Time Sheet',	'/storage/timesheet/23011892019scaled_f7703343-18cc-4763-a76d-f2ccfd5f371e247912179408966683.jpg',	'09:20:19',	'2023-01-18',	'2023-01-18 09:20:19',	'2023-01-18 09:20:19'),
(2,	15,	'Testing Time Sheet',	'/storage/timesheet/23011892121scaled_ce7b3364-53d3-4546-af72-afdec63b89fe413483208214896225.jpg',	'09:21:21',	'2023-01-18',	'2023-01-18 09:21:21',	'2023-01-18 09:21:21'),
(3,	15,	'Testing Times-Picayune',	'/storage/timesheet/23011973331scaled_3131f5b9-a501-4f2e-b657-0efec50821e36447776747893638674.jpg',	'07:33:31 AM',	'2023-01-19',	'2023-01-19 07:33:31',	'2023-01-19 07:33:31');

DROP TABLE IF EXISTS `time_slots`;
CREATE TABLE `time_slots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from_time` varchar(255) DEFAULT NULL,
  `to_time` varchar(255) DEFAULT NULL,
  `status` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `time_slots` (`id`, `from_time`, `to_time`, `status`, `created_at`, `updated_at`) VALUES
(1,	'07:00:00 AM',	'03:00:00 PM',	1,	'2023-01-10 09:37:22',	'2023-01-19 05:50:28'),
(10,	'03:00:00 PM',	'11:00:00 PM',	1,	'2023-01-19 05:51:05',	'2023-01-19 05:51:05'),
(11,	'11:00:00 PM',	'07:00:00 AM',	1,	'2023-01-19 05:51:28',	'2023-01-19 05:51:28'),
(12,	'01:01:00 AM',	'05:05:00 AM',	1,	'2023-01-19 06:03:51',	'2023-01-30 06:17:02');

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `facility` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `prov` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `insurance_no` varchar(255) DEFAULT NULL,
  `career` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_provided` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `covid_vaccines` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_details` (`id`, `user_id`, `position`, `facility`, `street_address`, `apartment`, `city`, `prov`, `postal_code`, `dob`, `insurance_no`, `career`, `user_provided`, `covid_vaccines`, `created_at`, `updated_at`) VALUES
(2,	2,	NULL,	NULL,	'Jagmohan gali',	'H2-1st',	'Mayur Vihar',	'Delhi',	'110096',	NULL,	NULL,	'3',	'a:1:{i:0;s:5:\"6,5,2\";}',	'a:1:{i:0;s:5:\"3,2,1\";}',	'2023-01-06 07:03:52',	'2023-01-12 09:30:23'),
(3,	5,	'Test1',	NULL,	'noida, up',	'b213',	'noida',	'test',	'201032',	'2022-02-21',	'tafad234',	'Registered Practical Nurses',	's:31:\"[JotForm application,Flue shot]\";',	's:19:\"[1st dose,3rd dose]\";',	'2023-01-06 10:37:13',	'2023-01-06 10:37:13'),
(4,	8,	'Teat',	NULL,	'Noida',	'Noida',	'Noida',	'UP',	'201301',	'1997-12-12',	'727277q7q',	'Personal support work',	's:23:\"Vulnerable sector check\";',	's:8:\"2nd dose\";',	'2023-01-06 10:45:29',	'2023-01-06 10:45:29'),
(5,	9,	'Teat',	NULL,	'Noida',	'Noida',	'Noida',	'UP',	'201301',	'1997-12-12',	'727277q7q',	'Personal support work',	's:23:\"Vulnerable sector check\";',	's:8:\"2nd dose\";',	'2023-01-06 10:46:04',	'2023-01-06 10:46:04'),
(6,	10,	'Test1',	NULL,	'noida, up',	'b213',	'noida',	'test',	'201032',	'1997-12-12',	'tafad234',	'Registered Practical Nurses',	's:31:\"[JotForm application,Flue shot]\";',	's:19:\"[1st dose,3rd dose]\";',	'2023-01-06 10:47:37',	'2023-01-06 10:47:37'),
(7,	11,	'Test',	NULL,	'Noida',	'Noida',	'Noida',	'UP',	'201301',	'1997-12-12',	'727277q7q',	'Personal support work',	's:23:\"Vulnerable sector check\";',	's:8:\"2nd dose\";',	'2023-01-06 10:49:18',	'2023-01-06 10:49:18'),
(8,	12,	'Test',	NULL,	'Noida',	'Noida',	'Noida',	'UP',	'201301',	'1991-12-20',	'727277q7q',	'Personal support work',	's:23:\"Vulnerable sector check\";',	's:8:\"2nd dose\";',	'2023-01-06 11:06:25',	'2023-01-06 11:06:25'),
(9,	13,	'3',	'1',	'noida, up',	'b213',	'noida',	'test',	'201032',	'2022-02-21',	'tafad234',	'Registered Practical Nurses',	'a:2:{i:0;s:23:\"PSW/Nursing Certificate\";i:1;s:19:\"JotForm Application\";}',	'a:1:{i:0;s:8:\"4th Dose\";}',	'2023-01-09 05:32:22',	'2023-01-30 11:10:55'),
(10,	14,	'Staff',	NULL,	'Jagmohan Gali',	'H2-1st',	'Noida',	'Uttar Pradesh',	'201301',	'2011-01-03',	'1234567in',	'Personal support work',	's:23:\"PSW/Nursing certificate\";',	's:8:\"3rd dose\";',	'2023-01-12 09:36:39',	'2023-01-12 09:36:39'),
(11,	15,	'3',	'18',	'Jagmohan Sector',	'B-13',	'Noida',	'test',	'Test1',	'2022-02-21',	'tafad234',	'Personal support work',	'a:3:{i:0;s:23:\"PSW/Nursing Certificate\";i:1;s:12:\"N96 Mask Fit\";i:2;s:8:\"FLU Shot\";}',	'a:3:{i:0;s:8:\"3rd Dose\";i:1;s:8:\"2nd Dose\";i:2;s:8:\"1st Dose\";}',	'2023-01-12 09:47:41',	'2023-02-06 07:14:49'),
(12,	16,	'4',	'21',	'2770 Dufferin St',	'213',	'Toronto',	'Ont',	'M1t 2s3',	'1976-01-03',	'500',	'Personal support work',	'a:3:{i:0;s:23:\"PSW/Nursing Certificate\";i:1;s:8:\"FLU Shot\";i:2;s:16:\"Police Clearance\";}',	'a:3:{i:0;s:8:\"3rd Dose\";i:1;s:8:\"2nd Dose\";i:2;s:8:\"1st Dose\";}',	'2023-01-18 17:48:46',	'2023-02-06 07:16:21'),
(22,	33,	'1',	NULL,	'noida, up',	'b213',	'noida',	'test',	'201032',	'2022-02-21',	'tafad234',	'Registered Practical Nurses',	'a:2:{i:0;s:12:\"N96 Mask Fit\";i:1;s:8:\"FLU Shot\";}',	'a:1:{i:0;s:8:\"1st dose\";}',	'2023-02-06 07:24:53',	'2023-02-06 07:24:53'),
(23,	34,	'2',	NULL,	'Noida',	'E32',	'Noida',	'Uttar Pradesh',	'201301',	'2000-10-11',	'25776',	'Registered Practical Nurses',	'a:5:{i:0;s:19:\"JotForm Application\";i:1;s:16:\"Police Clearance\";i:2;s:23:\"Vulnerable Sector Check\";i:3;s:8:\"FLU Shot\";i:4;s:12:\"N96 Mask Fit\";}',	'a:4:{i:0;s:8:\"1st Dose\";i:1;s:8:\"2nd Dose\";i:2;s:8:\"3rd Dose\";i:3;s:8:\"4th Dose\";}',	'2023-02-06 07:41:23',	'2023-02-06 07:41:23');

DROP TABLE IF EXISTS `user_provided`;
CREATE TABLE `user_provided` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_provided` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1,	'JotForm Application',	1,	'2023-01-04 10:21:00',	'2023-01-19 06:10:54'),
(2,	'Police Clearance',	1,	'2023-01-04 10:21:00',	'2023-01-19 06:10:37'),
(3,	'Vulnerable Sector Check',	1,	'2023-01-04 10:21:18',	'2023-01-19 06:10:07'),
(4,	'FLU Shot',	1,	'2023-01-04 10:21:18',	'2023-01-19 06:09:43'),
(5,	'N96 Mask Fit',	1,	'2023-01-04 10:21:34',	'2023-01-19 06:09:28'),
(6,	'PSW/Nursing Certificate',	1,	'2023-01-04 10:21:34',	'2023-01-19 06:08:44');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_type` int NOT NULL DEFAULT '1',
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `user_type`, `first_name`, `last_name`, `phone`, `email`, `email_verified_at`, `password`, `image`, `uuid`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13,	1,	'gaurav',	'sharma',	'9971695047',	'gauravss@yopmail.com',	NULL,	'$2y$10$X.nvU5Awofl2q/sC6B4lb.AMq/A3Bw7O1kAuSOjhp3QREPTSfPbIK',	NULL,	'f2ef16e8-f36d-498c-9814-455e5c7d1dec',	1,	NULL,	'2023-01-09 05:32:22',	'2023-02-06 07:15:50',	NULL),
(15,	1,	'UMS',	'Developer',	'1234567890',	'ums@gmail.com',	NULL,	'$2y$10$brM5Jd5gW924b05T92Wvj.DhQbjekF12HAEXTvpqnKusqtPhoMWAi',	NULL,	'a123ccfa-aeff-4a6e-94d1-4bc64cd54025',	1,	NULL,	'2023-01-12 09:47:41',	'2023-02-06 07:14:49',	NULL),
(16,	1,	'Margaret',	'Marsilla',	'4168929433',	'margmarsilla@gmail.com',	NULL,	'$2y$10$fVjANotkPXyyA4Sb5H8tWOntnNxgKkqpVzvs8BqKTv5KDAJeo9XPm',	NULL,	'7d317de3-8981-4453-97be-260f3a2ab5b9',	1,	NULL,	'2023-01-18 17:48:46',	'2023-02-06 07:16:21',	NULL),
(33,	1,	'gaurav',	'sharma',	'9971695047',	'gaurav4411s@yopmail.com',	NULL,	'$2y$10$hX2hnVHvoYjfH/wXkzFoxeVgvEGNu8jlVsgISY6YergS2ck.wdfMa',	NULL,	'807849d3-f10b-45e9-a5fa-52dbba1b804c',	1,	NULL,	'2023-02-06 07:24:53',	'2023-02-06 07:24:53',	NULL),
(34,	1,	'Ums',	'Developer',	'9632581470',	'test@ums.com',	NULL,	'$2y$10$Ohr6zkvCLBtvbpefk/N7PuEFHVAhfY5R9dEUBUyHSN3ecLaesTmVO',	NULL,	'7768cde5-d506-41c4-9187-2e2395ba35d4',	1,	NULL,	'2023-02-06 07:41:23',	'2023-02-06 07:41:23',	NULL);

DROP TABLE IF EXISTS `users_verifies`;
CREATE TABLE `users_verifies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users_verifies` (`id`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(1,	'1',	'y7Sb15Z3AVcOJFUVVyzIDslJokTlwyYUBAFlVtISL0duKqLvsVfLKHjZhFMn8h68',	'2023-01-05 02:08:47',	'2023-01-05 02:08:47'),
(2,	'2',	'5WOYeYwk5S5V4L98vP47nbWxZWN9Fs5kgav9zJlQ3IeVSI6VTm7OlWX6aIuQmYL5',	'2023-01-05 02:09:53',	'2023-01-05 02:09:53'),
(3,	'4',	'DozeYwTrcou6ghmfFXSz8e39RH3MYUvLNnHEbYO5qWZEfuK5zXRVwAgvd0YFCqwz',	'2023-01-05 02:15:04',	'2023-01-05 02:15:04'),
(4,	'1',	'QTSfSLTl8W82u7pDdta8uHy6rbi9JP3Du1nwqzMf4Ai1gC30fbw36ObNAobXABKR',	'2023-01-05 02:15:59',	'2023-01-05 02:15:59'),
(5,	'2',	'zQe6rP9sv5RnXavUcKu41rBy5xSata9KEIPgb8Mcq8A0RkEVpQX8gxKdFEd7TEj6',	'2023-01-06 07:03:52',	'2023-01-06 07:03:52'),
(6,	'5',	'x6fd5BRUv2nLMsFUVgmdJMtqz3EW9JsuwTw05TqHMshSm6cDmzC3Z7srIAt7uNVl',	'2023-01-06 10:37:13',	'2023-01-06 10:37:13'),
(7,	'8',	'r75HEhPjVeaB3ybCJ3RhkF7boqv5ZNoGFemb0vBQcPqkPMQIJgQowIYGkPc1oY1v',	'2023-01-06 10:45:29',	'2023-01-06 10:45:29'),
(8,	'9',	'6DWyMytxtF80uiw1XyFg2eWNSZAaXssGMg1NpOrMMl0d9kKEJtn3Xwmd5hinVtPy',	'2023-01-06 10:46:04',	'2023-01-06 10:46:04'),
(9,	'10',	'7xTL7LSwMLQhV4KfHyR71SOd6cOOQeg8kjwsJc3uT0AzxmL2ja8AEysUbYLCA06E',	'2023-01-06 10:47:37',	'2023-01-06 10:47:37'),
(10,	'11',	'jjBiIJKjoaGe3tmAbscDfXFhmLESzfnVlh5Jt4MnP7NSawnC8H68lF3NMCrRzX7e',	'2023-01-06 10:49:18',	'2023-01-06 10:49:18'),
(11,	'12',	'kmVFTQV4GCwVccqfnueFWnOWpk956o803QWo4IU4d65ivRoefJtc09mhMK3CLIaG',	'2023-01-06 11:06:25',	'2023-01-06 11:06:25'),
(12,	'13',	'C87BoOV1quGAwWXUumyve9WLSNjodz92JcQ4Lc7seOje8an22rIlLdm1bziuIhkL',	'2023-01-09 05:32:22',	'2023-01-09 05:32:22'),
(13,	'14',	'5O1i7ls8Kl8kucwbb5lyU4HMKK8Nkx11vI9Zvahq9D1hTueq8pih9oOUMHWKLbYK',	'2023-01-12 09:36:39',	'2023-01-12 09:36:39'),
(14,	'15',	'CWoYTavjdj3pOoUgZxTyJQseoCmgUCSVgIbvAqmXxHczAQYxUTfwF2uwNGUw59xS',	'2023-01-12 09:47:41',	'2023-01-12 09:47:41'),
(15,	'16',	'1k1Y5jYvkbaHOSj2vYsmcwoAoykRclMowmm5V2oXxeomZTWLJ0Hx1oz25KtZhTfq',	'2023-01-18 17:48:46',	'2023-01-18 17:48:46'),
(16,	'18',	'g8oMNDKJMb53tkgSibvF7enNMtnBEMCobtqUnt33mmDEUIEXAZFE4iBHVUsgZJNQ',	'2023-01-30 12:56:55',	'2023-01-30 12:56:55'),
(17,	'25',	'Oa0jhLsrB8vgkm3U5ihwQvaAYfQmlnGxPRc2RpOKw8s06Lom2HIDz2bH56p5gaLv',	'2023-01-30 13:29:50',	'2023-01-30 13:29:50'),
(18,	'26',	'hIwsOww4pGxAVUd6VmLEqjfpTefHuOMHXGp6YYGVHLNxJzDPl5Pp2xNElHtp8MDU',	'2023-02-06 06:19:16',	'2023-02-06 06:19:16'),
(19,	'28',	'LT3dhtxsIbXf56xWewjZHjdvUooDGXvBO5gaefDCSylcV4ceHML6YDB1fEObZxf6',	'2023-02-06 06:42:40',	'2023-02-06 06:42:40'),
(20,	'29',	'Dxdmic45nNq2VozhJTzzE1vwl5rKCGQAWnen5U0FOl6VUtElO4GtlDMTq5BuJuGG',	'2023-02-06 06:44:37',	'2023-02-06 06:44:37'),
(21,	'30',	'LqS7eWXjtMz2Rp318IqZw2a1oN8XF6hgAi3QNa3aJBMIeptDzqSoLd5hF3f28jN4',	'2023-02-06 06:47:45',	'2023-02-06 06:47:45'),
(22,	'31',	'r8bBx9Fmfx7tkjhhPb1L7Ts0g4bfho7epj2boBPBbdmwzi4v0cWMjXYReomPAsqF',	'2023-02-06 06:48:57',	'2023-02-06 06:48:57'),
(23,	'32',	'o6JtNOwW0AS7u7H7ErhG5gpeBSC5Lexkvnjy657EZwHLXQsfJUgsnEBaNQe8HLBZ',	'2023-02-06 06:56:32',	'2023-02-06 06:56:32'),
(24,	'33',	'7iu3M1aOBLJUCk0evKpmjGHDMq63FliXJxvTBahdSZhtcKrDgyc51MSuBBbOd1pj',	'2023-02-06 07:24:53',	'2023-02-06 07:24:53'),
(25,	'34',	'txJe2Z6MCGjE1O6KHzSbnw7Nu3hdWQsHv7jiNoKuyaAKdNKqiTVBP1vMIfp5DbGd',	'2023-02-06 07:41:24',	'2023-02-06 07:41:24');

-- 2023-02-16 05:33:00
