-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 27 déc. 2025 à 17:13
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
-- Base de données : `boardcompanion`
--
CREATE DATABASE IF NOT EXISTS `boardcompanion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `boardcompanion`;

-- --------------------------------------------------------

--
-- Structure de la table `appreciation`
--

DROP TABLE IF EXISTS `appreciation`;
CREATE TABLE IF NOT EXISTS `appreciation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` enum('very bad','bad','good','very good') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `fk_final_appreciation` (`fk_appreciation`),
  KEY `fk_final_project` (`fk_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `studio` varchar(50) NOT NULL,
  `episode_nb` varchar(50) NOT NULL,
  `episode_title` varchar(50) NOT NULL,
  `date_beginning` date NOT NULL,
  `date_end` date NOT NULL,
  `nb_predec` int NOT NULL,
  `is_cleaning` tinyint(1) NOT NULL,
  `project_is_alone` tinyint(1) NOT NULL,
  `nb_total_pages` float DEFAULT NULL,
  `nb_assigned_pages` float DEFAULT NULL,
  `estimated_total_duration` float DEFAULT NULL,
  `estimated_cleaning_duration` float DEFAULT NULL,
  `recommended_pages_per_day` float DEFAULT NULL,
  `fk_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sequence`
--

DROP TABLE IF EXISTS `sequence`;
CREATE TABLE IF NOT EXISTS `sequence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `script` text NOT NULL,
  `is_assigned` tinyint(1) NOT NULL,
  `duration_estimated` float DEFAULT NULL,
  `fk_type` int NOT NULL,
  `fk_project` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_appreciation_type` (`fk_type`),
  KEY `fk_appreciation_project` (`fk_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` enum('comedy','action','mixte') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avg_pages_per_day` int DEFAULT NULL,
  `avg_cleaning_duration` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_type_statistics`
--

DROP TABLE IF EXISTS `user_type_statistics`;
CREATE TABLE IF NOT EXISTS `user_type_statistics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `avg_pages_per_day` float NOT NULL,
  `fk_user` int NOT NULL,
  `fk_type` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_statistics` (`fk_user`),
  KEY `fk_type_statistics` (`fk_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ADD CONSTRAINT `fk_appreciation_project` FOREIGN KEY (`fk_project`) REFERENCES `project` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_appreciation_type` FOREIGN KEY (`fk_type`) REFERENCES `type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
