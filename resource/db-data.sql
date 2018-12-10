
CREATE DATABASE IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `test`;

-- Dumping structure for table test.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gamer_name` varchar(100) DEFAULT '',
  `profile_image` varchar(50) DEFAULT '',
  `gender` char(10) NOT NULL DEFAULT 'male',
  `first_name` varchar(50) DEFAULT '',
  `last_name` varchar(50) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `password` varchar(100) DEFAULT '',
  `personal_info` text,
  `latitude` varchar(50) NOT NULL DEFAULT '0',
  `longitude` varchar(50) NOT NULL DEFAULT '0',
  `last_api_time` datetime DEFAULT NULL,
  `device_token` varchar(50) NOT NULL DEFAULT '1',
  `device_model` varchar(50) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT DEFAULT CHARSET=utf8;

-- Dumping data for table test.users: ~9 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `gamer_name`, `profile_image`, `gender`, `first_name`, `last_name`, `email`, `password`, `personal_info`, `latitude`, `longitude`, `last_api_time`, `device_token`, `device_model`, `created_at`, `updated_at`) VALUES
	(1, 'mx', '', 'male', 'Mr.', 'X', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.750580', '90.38872', '2018-11-08 18:54:35', 'dummy_token', 'Sony SO-04K', '2018-07-14 01:29:08', '2018-11-08 18:54:35'),
	(2, 'my', '', 'male', 'Mr.', 'Y', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.750380', '90.38872', '2018-11-08 18:54:52', 'dummy_token', 'iPhone SE', '2018-07-14 03:17:18', '2018-11-08 18:54:52'),
	(3, 'mz', '', 'male', 'Mr.', 'Z', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.755480', '90.38872', '2018-09-24 08:13:01', 'dummy_token', 'iPhone X', '2018-07-14 03:21:25', '2018-09-24 08:13:01'),
	(4, 'ma', '', 'male', 'Mr.', 'A', 'example@gmail.com', '$2y$12$NtrTnBFF99qzMReh113iqulYqWY8n1gZqspvtVIM7jHeueVwMfhRi', 'I am a tester', '23.75126', '90.38872', '2018-12-03 12:30:35', '1', '1', '2018-07-14 03:42:16', '2018-12-03 12:30:35'),
	(5, 'mb', '', 'male', 'Mr.', 'B', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.750480', '90.38872', '2018-08-04 05:59:28', '1', '1', '2018-07-14 04:53:39', '2018-10-17 12:28:48'),
	(6, 'mc', '', 'male', 'Ms.', 'C', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.75144', '90.38872', '2018-09-24 04:39:19', 'dummy_token', 'iPhone X', '2018-07-14 05:19:21', '2018-09-24 04:39:19'),
	(7, 'md', '', 'male', 'Ms.', 'D', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.750480', '135.3217', '2018-09-24 06:55:45', 'dummy_token', 'iPhone X', '2018-07-14 12:39:47', '2018-09-24 06:55:45'),
	(9, 'me', '', 'male', 'Mrs.', 'E', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.75048', '90.38872', '2018-11-12 17:27:45', 'dummy_token', 'MacBookPro12,1', '2018-07-16 05:14:45', '2018-11-12 17:27:45'),
	(10, 'mf', '', 'male', 'Mrs.', 'F', 'example@gmail.com', '$2y$12$b5Jf/NMTBrwawBpzeP2S/eP2AUlO57Y/xCuUh0j3NvlE8keP6BzHa', 'I am a tester', '23.750480', '90.388720', '2018-11-08 18:46:40', '1', '1', '2018-07-16 08:45:42', '2018-11-08 18:46:40');

