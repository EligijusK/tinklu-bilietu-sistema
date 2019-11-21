-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 20, 2019 at 10:10 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `traukiniai`
--

-- --------------------------------------------------------

--
-- Table structure for table `biletai`
--

DROP TABLE IF EXISTS `biletai`;
CREATE TABLE IF NOT EXISTS `biletai` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `FK_vartotojas` int(6) NOT NULL,
  `FK_tvarkarastis` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uzsako` (`FK_vartotojas`) USING BTREE,
  KEY `rezervuoja` (`FK_tvarkarastis`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `biletai`
--

INSERT INTO `biletai` (`id`, `FK_vartotojas`, `FK_tvarkarastis`) VALUES
(1, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tipai`
--

DROP TABLE IF EXISTS `tipai`;
CREATE TABLE IF NOT EXISTS `tipai` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `pavadinimas` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipai`
--

INSERT INTO `tipai` (`id`, `pavadinimas`) VALUES
(1, 'Naudotojas'),
(2, 'Vadybininkas'),
(3, 'Administratorius');

-- --------------------------------------------------------

--
-- Table structure for table `tvarkarastis`
--

DROP TABLE IF EXISTS `tvarkarastis`;
CREATE TABLE IF NOT EXISTS `tvarkarastis` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `traukinys` varchar(255) NOT NULL,
  `isvykimo_miestas` varchar(255) NOT NULL,
  `atvykimo_miestas` varchar(255) NOT NULL,
  `isvykimas` datetime(6) NOT NULL,
  `atvykimas` datetime(6) DEFAULT NULL,
  `kaina` int(6) NOT NULL,
  `visos_vietos` int(6) NOT NULL,
  `likusios_vietos` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tvarkarastis`
--

INSERT INTO `tvarkarastis` (`id`, `traukinys`, `isvykimo_miestas`, `atvykimo_miestas`, `isvykimas`, `atvykimas`, `kaina`, `visos_vietos`, `likusios_vietos`) VALUES
(4, 'Autobusu parkas', 'Kaunas', 'Vilnius', '2019-11-10 07:00:00.000000', '2019-11-10 09:00:00.000000', 0, 20, 19),
(5, 'Kauno Traukiniai', 'Kaunas', ' KlaipÄ—da', '2019-11-11 09:30:00.000000', NULL, 0, 30, 30),
(6, 'Vilniaus Traukiniai', 'Vilnius', 'Kaunas', '2019-11-11 08:40:00.000000', NULL, 0, 10, 10),
(7, 'KlaipÄ—dos traukinys', 'Klaipeda', 'Kaunas', '2019-11-12 09:34:00.000000', NULL, 0, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojai`
--

DROP TABLE IF EXISTS `vartotojai`;
CREATE TABLE IF NOT EXISTS `vartotojai` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `slapyvardis` varchar(255) NOT NULL,
  `vardas` varchar(255) NOT NULL,
  `pavarde` varchar(255) NOT NULL,
  `epastas` varchar(255) NOT NULL,
  `slaptazodis` varchar(255) NOT NULL,
  `tipas` int(6) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `vartotojo tipas` (`tipas`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vartotojai`
--

INSERT INTO `vartotojai` (`id`, `slapyvardis`, `vardas`, `pavarde`, `epastas`, `slaptazodis`, `tipas`) VALUES
(10, 'vartotojas', 'vartotojas', 'vartotojas', 'vartotojas@vartotojas', '$2y$10$Rb4BpWTm2dAfB5IdeUnLBuvGg2RwyNjnCbH98UJw7dMLp012GDelO', 1),
(11, 'vadybininkas', 'vadybininkas', 'vadybininkas', 'vadybininkas@vadybininkas', '$2y$10$sxlqml9Y9nCrUBqevLAcM.bu5lR.NslaaCo4dCWabwK6R0v/XhBnC', 2),
(12, 'admin', 'admin', 'admin', 'admin@admin', '$2y$10$qZM75ezBgrgsuyMVe4jKi.NAtuO06z6CPuQly6aygkJUxbu6jbw7y', 3),
(13, 'aaaaaa', 'aaaaaa', 'aaaaaa', 'a@a', '$2y$10$ssU4zpxg2mkoYnXId1Mv2OVw6tOQEaj68InJ83.deByWQ.xN8WBK.', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `biletai`
--
ALTER TABLE `biletai`
  ADD CONSTRAINT `rezervuoja` FOREIGN KEY (`FK_tvarkarastis`) REFERENCES `tvarkarastis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uzsako` FOREIGN KEY (`FK_vartotojas`) REFERENCES `vartotojai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vartotojai`
--
ALTER TABLE `vartotojai`
  ADD CONSTRAINT `vartotojo tipas` FOREIGN KEY (`tipas`) REFERENCES `tipai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
