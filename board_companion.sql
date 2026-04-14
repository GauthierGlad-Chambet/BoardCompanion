-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 14 avr. 2026 à 11:09
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `board_companion`
--
CREATE DATABASE IF NOT EXISTS `board_companion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `board_companion`;

-- --------------------------------------------------------

--
-- Structure de la table `appreciation`
--

DROP TABLE IF EXISTS `appreciation`;
CREATE TABLE IF NOT EXISTS `appreciation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` enum('smiley-sad.svg','smiley-unhappy.svg','smiley-smile.svg','smiley-happy.svg') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `appreciation`
--

INSERT INTO `appreciation` (`id`, `label`) VALUES
(1, 'smiley-happy.svg'),
(2, 'smiley-smile.svg'),
(3, 'smiley-unhappy.svg'),
(4, 'smiley-sad.svg');

-- --------------------------------------------------------

--
-- Structure de la table `final_report`
--

DROP TABLE IF EXISTS `final_report`;
CREATE TABLE IF NOT EXISTS `final_report` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total_duration` float NOT NULL,
  `cleaning_duration` float NOT NULL,
  `nb_shots` int NOT NULL,
  `commentary` text NOT NULL,
  `fk_appreciation` int NOT NULL,
  `fk_project` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_project` (`fk_project`),
  KEY `fk_final_appreciation` (`fk_appreciation`),
  KEY `fk_final_project` (`fk_project`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `studio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `episode_nb` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `episode_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nb_predec` int NOT NULL,
  `is_alone` tinyint(1) NOT NULL,
  `is_cleaning` tinyint(1) NOT NULL,
  `is_detailed` tinyint(1) NOT NULL,
  `script_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `template_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_beginning` date NOT NULL,
  `date_end` date NOT NULL,
  `nb_total_pages` float DEFAULT NULL,
  `nb_assigned_pages` float DEFAULT NULL,
  `estimated_total_duration` float DEFAULT NULL,
  `estimated_cleaning_duration` float DEFAULT NULL,
  `avg_duration_estimated_per_pages` float NOT NULL,
  `recommended_pages_per_day` float DEFAULT NULL,
  `fk_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sequence`
--

DROP TABLE IF EXISTS `sequence`;
CREATE TABLE IF NOT EXISTS `sequence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `number` int NOT NULL,
  `script` text NOT NULL,
  `lines_count` int NOT NULL,
  `is_assigned` tinyint(1) NOT NULL,
  `duration_estimated` float DEFAULT NULL,
  `duration_real` int DEFAULT NULL,
  `fk_type` int NOT NULL,
  `fk_project` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appreciation_type` (`fk_type`),
  KEY `fk_appreciation_project` (`fk_project`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` enum('comédie','action','mixte','indéterminé') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `label`) VALUES
(1, 'comédie'),
(2, 'action'),
(3, 'mixte'),
(4, 'indéterminé');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avg_pages_per_day` float DEFAULT '1',
  `avg_cleaning_duration` float DEFAULT '0.2',
  `avg_shots_per_page` int NOT NULL,
  `fk_appreciation` int NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user__appreciation` (`fk_appreciation`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_type_statistics`
--

DROP TABLE IF EXISTS `user_type_statistics`;
CREATE TABLE IF NOT EXISTS `user_type_statistics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `avg_pages_per_day` float NOT NULL DEFAULT '1',
  `fk_user` int NOT NULL,
  `fk_type` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_statistics` (`fk_user`),
  KEY `fk_type_statistics` (`fk_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `final_report`
--
ALTER TABLE `final_report`
  ADD CONSTRAINT `fk_final_appreciation` FOREIGN KEY (`fk_appreciation`) REFERENCES `appreciation` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_final_project` FOREIGN KEY (`fk_project`) REFERENCES `project` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `sequence`
--
ALTER TABLE `sequence`
  ADD CONSTRAINT `fk_sequence_project` FOREIGN KEY (`fk_project`) REFERENCES `project` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_sequence_type` FOREIGN KEY (`fk_type`) REFERENCES `type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user__appreciation` FOREIGN KEY (`fk_appreciation`) REFERENCES `appreciation` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `user_type_statistics`
--
ALTER TABLE `user_type_statistics`
  ADD CONSTRAINT `fk_type_statistics` FOREIGN KEY (`fk_type`) REFERENCES `type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_user_statistics` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
