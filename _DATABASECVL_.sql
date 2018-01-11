-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 11 Janvier 2018 à 20:14
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cvl`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `AId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ALogin` varchar(20) NOT NULL,
  `APwd` varchar(50) NOT NULL,
  `ADroit` varchar(4) NOT NULL,
  PRIMARY KEY (`AId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `candid`
--

CREATE TABLE IF NOT EXISTS `candid` (
  `CId` varchar(10) NOT NULL,
  `CIdBinome` varchar(10) NOT NULL,
  `CNbV` int(5) NOT NULL DEFAULT '0',
  `CIdSuffrage` int(10) unsigned NOT NULL,
  PRIMARY KEY (`CId`,`CIdBinome`),
  KEY `candidatSuffrage_ibfk_2` (`CIdSuffrage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `divis`
--

CREATE TABLE IF NOT EXISTS `divis` (
  `DCode` varchar(10) NOT NULL,
  PRIMARY KEY (`DCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `elect`
--

CREATE TABLE IF NOT EXISTS `elect` (
  `EId` varchar(10) NOT NULL,
  `ENom` varchar(30) NOT NULL,
  `EPrenom` varchar(30) NOT NULL,
  `ECodeINE` varchar(11) DEFAULT NULL,
  `EVote` datetime DEFAULT NULL,
  `EPwd` varchar(50) NOT NULL,
  `ELogin` varchar(20) NOT NULL,
  `EIdDivis` varchar(10) NOT NULL,
  `EDateLogin` datetime DEFAULT NULL,
  `EAdresseIP` varchar(20) DEFAULT NULL,
  `ELastLogin` datetime DEFAULT NULL,
  `ESession` varchar(100) DEFAULT NULL,
  `EDateLogout` datetime DEFAULT NULL,
  `EModif` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`EId`),
  KEY `ElectDivision_ibfk_1` (`EIdDivis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `suffrage`
--

CREATE TABLE IF NOT EXISTS `suffrage` (
  `SId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SChoix` int(2) NOT NULL DEFAULT '5',
  `SDateDeb` datetime NOT NULL,
  `SDateFin` datetime NOT NULL,
  `SDescription` varchar(40) NOT NULL,
  `SBlancs` int(4) NOT NULL DEFAULT '0',
  `SNuls` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `candid`
--
ALTER TABLE `candid`
  ADD CONSTRAINT `candidatSuffrage_ibfk_2` FOREIGN KEY (`CIdSuffrage`) REFERENCES `suffrage` (`SId`),
  ADD CONSTRAINT `fk_client_numero` FOREIGN KEY (`CId`) REFERENCES `elect` (`EId`);

--
-- Contraintes pour la table `elect`
--
ALTER TABLE `elect`
  ADD CONSTRAINT `ElectDivision_ibfk_1` FOREIGN KEY (`EIdDivis`) REFERENCES `divis` (`DCode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
