-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 12 Mai 2016 à 14:47
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `erp-aa-v1`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `idClient` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `FamilyName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `FirstName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Adress` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `CreatedBy` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `CreatedBy` (`CreatedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`idClient`, `FamilyName`, `FirstName`, `Phone`, `Adress`, `CreatedBy`) VALUES
('00000001', 'BEN ISSAA', 'ALI', '50436216', 'BARDO BOUCHOUCHA', '00000001'),
('00000002', 'BAYAR', 'FAHMI', '93201201', 'CITEE BEN MAHMOUD AGBA TUNIS', '00000001'),
('00000003', 'RAISSI', 'AZIZ', '20123123', 'Agba', '00000001'),
('00000004', 'YAKOUB', 'SAKLY', '27957171', 'CITEE ESSEHA AGBA TUNIS', '00000001'),
('00000005', 'BOUGHANMI', 'KHOULOUD', '93555666', 'Tunis', '00000001'),
('0014 L/M/A 000 RC ', 'STE : BFCO', 'SARL', '71554225', 'Zahrouni Tunis', '00000001'),
('1245 M/A/C 000 /J', 'TNL DISTRIBUTION', 'SARL', '71255366', 'GP5 AGBA MANOUBA', '00000001');

-- --------------------------------------------------------

--
-- Structure de la table `contractcycle`
--

CREATE TABLE IF NOT EXISTS `contractcycle` (
  `idCycle` int(255) NOT NULL AUTO_INCREMENT,
  `idPayment` int(255) NOT NULL,
  `idContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `StartDate` varchar(255) NOT NULL,
  `EndDate` varchar(255) NOT NULL,
  `CreatedBy` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idCycle`),
  KEY `idContract` (`idContract`),
  KEY `idPayment` (`idPayment`),
  KEY `CreatedBy` (`CreatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `contractcycle`
--

INSERT INTO `contractcycle` (`idCycle`, `idPayment`, `idContract`, `StartDate`, `EndDate`, `CreatedBy`) VALUES
(1, 1, '0100', '18-04-2016', '18-05-2016', '00000001'),
(2, 2, '0200', '19-04-2016', '19-05-2016', '00000001'),
(3, 3, '0300', '19-04-2016', '19-04-2016', '00000001'),
(4, 7, '0200', '20-05-2016', '20-06-2016', '00000001'),
(5, 8, '0200', '21-06-2016', '21-07-2016', '00000001'),
(6, 9, '0500', '20-04-2016', '20-04-2017', '00000001'),
(7, 10, '0500', '21-04-2017', '21-04-2018', '00000001'),
(8, 11, '0900', '21-04-2016', '21-10-2016', '00000001'),
(9, 14, '0901', '25-04-2016', '25-10-2016', '00000001'),
(10, 16, '011', '01-05-2016', '01-06-2016', '00000001'),
(11, 19, '0902', '09-05-2016', '09-11-2016', '00000001');

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

CREATE TABLE IF NOT EXISTS `discussion` (
  `idDiscussion` int(255) NOT NULL AUTO_INCREMENT,
  `idMessage` int(255) NOT NULL,
  `FormUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ToUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Containt` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TimeStamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Seen` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDiscussion`),
  KEY `idMessage` (`idMessage`),
  KEY `FormUser` (`FormUser`),
  KEY `ToUser` (`ToUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `idHelp` int(20) NOT NULL AUTO_INCREMENT,
  `Category` varchar(255) NOT NULL,
  `Question` varchar(1000) NOT NULL,
  `Answer` varchar(10000) NOT NULL,
  PRIMARY KEY (`idHelp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `help`
--

INSERT INTO `help` (`idHelp`, `Category`, `Question`, `Answer`) VALUES
(1, 'Profile', 'Modification des diplôme?', '<ul>\r\n<li>Connexion > Mon Profile > Modifier Profile > Modifier Mes Diplômes</li>\r\n<li>Effectuer la modification</li>\r\n<li>Enregistrer</li>\r\n</ul>'),
(2, 'Utilisateurs', 'Ajouter un utilisateur', 'Connexion > Ajouter <br>\r\nRemplir le formulaire <br>\r\nCrée  '),
(3, 'Profile', 'Modification des d’expérance?', 'Connexion > Mon Profile > Modifier Profile > Modifier Mes Expérance<br> Effectuer la modification <br>\r\nEnregistrer'),
(4, 'Profile', 'Modification des informations personelle?', 'Connexion > Mon Profile > Modifier Profile > Modifier Mes Informations Personelles<br> Effectuer la modification <br>\r\nEnregistrer');

-- --------------------------------------------------------

--
-- Structure de la table `insurancecontract`
--

CREATE TABLE IF NOT EXISTS `insurancecontract` (
  `idContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `idClient` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TypeContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `KindContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idContract`),
  KEY `idClient` (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `insurancecontract`
--

INSERT INTO `insurancecontract` (`idContract`, `idClient`, `TypeContract`, `KindContract`) VALUES
('0100', '00000001', 'Automobile', 'Ferme'),
('011', '00000001', 'Automobile', 'Renouvelable'),
('0200', '00000003', 'Multirisque habitation', 'Renouvelable'),
('0300', '00000001', 'Assurance voyage', 'Ferme'),
('0500', '00000002', 'Automobile', 'Renouvelable'),
('0900', '1245 M/A/C 000 /J', 'Automobile', 'Renouvelable'),
('0901', '00000005', 'Automobile', 'Renouvelable'),
('0902', '0014 L/M/A 000 RC', 'Automobile', 'Renouvelable');

-- --------------------------------------------------------

--
-- Structure de la table `logsystem`
--

CREATE TABLE IF NOT EXISTS `logsystem` (
  `idLog` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Timestamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=213 ;

--
-- Contenu de la table `logsystem`
--

INSERT INTO `logsystem` (`idLog`, `idUser`, `Timestamp`, `Description`) VALUES
(1, '00000001', '14-04-2016 11:58:53', 'Conexion'),
(3, '00000001', '14-04-2016 13:09:46', 'Connexion'),
(4, '00000001', '14-04-2016 14:24:42', 'Déconnexion'),
(5, '00000001', '14-04-2016 14:24:44', 'Connexion'),
(6, '00000001', '14-04-2016 14:32:34', 'Modification des informations de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(7, '00000001', '14-04-2016 15:00:44', 'Déconnexion'),
(8, '00000001', '14-04-2016 15:01:26', 'Connexion'),
(9, '00000001', '14-04-2016 15:08:28', 'Modification des informations de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(10, '00000001', '14-04-2016 15:38:16', 'Déconnexion'),
(11, '00000001', '14-04-2016 15:38:17', 'Connexion'),
(12, '00000001', '14-04-2016 21:45:09', 'Connexion'),
(13, '00000001', '14-04-2016 22:07:34', 'Modification des informations de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(14, '00000001', '14-04-2016 22:45:57', 'Déconnexion'),
(15, '00000001', '14-04-2016 22:46:05', 'Connexion'),
(16, '00000001', '14-04-2016 22:46:20', 'Modification des informations de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(17, '00000001', '14-04-2016 22:55:24', 'Modification des liens socieaux de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(20, '00000001', '15-04-2016 11:20:22', 'Connexion'),
(21, '00000001', '15-04-2016 11:21:12', 'Ajout du compétence : js, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(22, '00000001', '15-04-2016 11:32:25', 'Déconnexion'),
(23, '00000001', '15-04-2016 11:32:27', 'Connexion'),
(24, '00000001', '15-04-2016 11:34:34', 'Ajout du compétence : 10, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(25, '00000001', '15-04-2016 11:34:43', 'Ajout du compétence : 10, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(26, '00000001', '15-04-2016 11:34:46', 'Ajout du compétence : 10, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(27, '00000001', '15-04-2016 11:44:41', 'Ajout du compétence : ts, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(28, '00000001', '15-04-2016 11:44:52', 'Suppression du compétence : ts de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(29, '00000001', '15-04-2016 11:44:55', 'Suppression du compétence : js de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(30, '00000001', '15-04-2016 11:45:42', 'Ajout du diplôme : bac, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(31, '00000001', '15-04-2016 11:45:49', 'Modification du diplôme : bacc, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(32, '00000001', '15-04-2016 11:45:51', 'Suppression du diplôme : bacc, de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(33, '00000001', '15-04-2016 12:37:09', 'Ajout du diplôme : bac, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(34, '00000001', '15-04-2016 12:37:23', 'Suppression du diplôme : bac, de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(35, '00000001', '15-04-2016 12:37:33', 'Ajout du diplôme : bac, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(36, '00000001', '15-04-2016 12:37:40', 'Suppression du diplôme : bac, de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(37, '00000001', '15-04-2016 13:12:24', 'Ajout de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(38, '00000001', '15-04-2016 13:14:30', 'Ajout de l''expérience dans l''etablissement : a, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(39, '00000001', '15-04-2016 13:14:36', 'Modification de l''expérience dans l''etablissement : b, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(40, '00000001', '15-04-2016 13:14:41', 'Suppression du l''expérience : , de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(41, '00000001', '15-04-2016 13:19:03', 'Modification de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(42, '00000001', '15-04-2016 13:25:05', 'Modification de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(43, '00000001', '15-04-2016 13:25:18', 'Modification de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(44, '00000001', '15-04-2016 13:26:29', 'Modification de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(45, '00000001', '15-04-2016 13:31:43', 'Modification de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(48, '00000001', '15-04-2016 13:40:40', 'Modification de l''expérience dans l''etablissement : oktoboot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(49, '00000001', '15-04-2016 13:48:37', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(51, '00000001', '15-04-2016 13:49:06', 'Connexion'),
(52, '00000001', '15-04-2016 13:53:56', 'Suppression du l''expérience : , de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(53, '00000001', '15-04-2016 13:54:29', 'Ajout du diplôme : Bac, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(54, '00000001', '15-04-2016 13:54:50', 'Modification du diplôme : Bac Technique, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(55, '00000001', '15-04-2016 13:54:55', 'Suppression du diplôme : Bac Technique, de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(56, '00000001', '15-04-2016 13:55:11', 'Ajout de l''expérience dans l''etablissement : ok, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(57, '00000001', '15-04-2016 13:55:34', 'Modification de l''expérience dans l''etablissement : OkToBoot, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(58, '00000001', '15-04-2016 13:59:26', 'Suppression du l''expérience : , de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(59, '00000001', '15-04-2016 13:59:37', 'Ajout de l''expérience dans l''etablissement : 1, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(60, '00000001', '15-04-2016 13:59:51', 'Suppression du l''expérience : , de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(61, '00000001', '15-04-2016 14:00:50', 'Ajout de l''expérience dans l''etablissement : 1, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(62, '00000001', '15-04-2016 14:01:27', 'Suppression du l''expérience : 1, de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(63, '00000001', '15-04-2016 14:01:46', 'Ajout de l''expérience dans l''etablissement : ok, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(64, '00000001', '15-04-2016 14:01:49', 'Suppression du l''expérience : ok, de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(66, '00000001', '15-04-2016 14:30:19', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(67, '00000001', '15-04-2016 14:42:49', 'Déconnexion'),
(68, '00000001', '15-04-2016 14:42:53', 'Connexion'),
(69, '00000001', '15-04-2016 15:08:45', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(70, '00000001', '15-04-2016 15:16:12', 'Déconnexion'),
(71, '00000001', '15-04-2016 15:16:17', 'Connexion'),
(72, '00000001', '15-04-2016 15:16:38', 'Déconnexion'),
(73, '00000001', '15-04-2016 15:16:44', 'Connexion'),
(74, '00000001', '15-04-2016 15:17:41', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(75, '00000001', '15-04-2016 15:17:42', 'Déconnexion'),
(76, '00000001', '15-04-2016 15:17:46', 'Connexion'),
(77, '00000001', '15-04-2016 15:20:04', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(78, '00000001', '15-04-2016 15:20:04', 'Déconnexion'),
(79, '00000001', '15-04-2016 15:20:10', 'Connexion'),
(80, '00000001', '15-04-2016 15:21:19', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(81, '00000001', '15-04-2016 15:21:19', 'Déconnexion'),
(82, '00000001', '15-04-2016 15:22:23', 'Connexion'),
(83, '00000001', '15-04-2016 15:26:04', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(84, '00000001', '15-04-2016 15:26:22', 'Changement du mot de passe de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(91, '00000001', '15-04-2016 15:58:29', 'Modification des liens socieaux de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(92, '00000001', '15-04-2016 15:58:44', 'Changement de l''image de profil de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(93, '00000001', '15-04-2016 16:10:39', 'Déconnexion'),
(94, '00000001', '15-04-2016 16:10:41', 'Connexion'),
(95, '00000001', '15-04-2016 16:10:57', 'Changement de l''image de profil de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(96, '00000001', '15-04-2016 16:11:01', 'Déconnexion'),
(97, '00000001', '15-04-2016 16:11:03', 'Connexion'),
(98, '00000001', '15-04-2016 16:11:15', 'Changement de l''image de profil de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(99, '00000001', '15-04-2016 16:11:17', 'Déconnexion'),
(100, '00000001', '15-04-2016 16:11:19', 'Connexion'),
(103, '00000001', '15-04-2016 16:49:15', 'Connexion'),
(104, '00000001', '15-04-2016 16:55:43', 'Ajout de privilége <strong>CREER</strong> sur le bloc <strong>CLIENTS</strong> pour l''utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a>'),
(105, '00000001', '15-04-2016 20:55:53', 'Connexion'),
(106, '00000001', '15-04-2016 20:56:08', 'Utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a> a été <strong>banni</strong>'),
(107, '00000001', '15-04-2016 20:56:32', 'Utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a> a été <strong>débanni</strong>'),
(108, '00000001', '15-04-2016 20:57:07', 'Utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a> a été <strong>banni</strong>'),
(109, '00000001', '15-04-2016 20:57:15', 'Utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a> a été <strong>débanni</strong>'),
(110, '00000001', '15-04-2016 20:59:56', 'Utilisateur : <a href="ili-users/user_profil?id=00000003">00000003</a> a été <strong>débanni</strong>'),
(111, '00000001', '15-04-2016 21:00:05', 'Utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a> a été <strong>banni</strong>'),
(112, '00000001', '15-04-2016 21:00:21', 'Utilisateur : <a href="ili-users/user_profil?id=00000002">00000002</a> a été <strong>débanni</strong>'),
(113, '00000001', '15-04-2016 21:00:30', 'Utilisateur : <a href="ili-users/user_profil?id=00000003">00000003</a> a été <strong>banni</strong>'),
(114, '00000001', '15-04-2016 21:16:16', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(115, '00000001', '15-04-2016 21:18:05', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(116, '00000001', '15-04-2016 21:18:21', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(117, '00000001', '15-04-2016 21:20:15', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(118, '00000001', '15-04-2016 21:29:59', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(119, '00000001', '15-04-2016 21:35:57', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(120, '00000001', '15-04-2016 21:44:11', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=11111111">11111111</a>'),
(121, '00000001', '16-04-2016 11:08:14', 'Connexion'),
(122, '00000001', '16-04-2016 11:43:50', 'Modification de client : <a href="ili-modules/client/client?id=00000001">BEN ISSAOUI ALI</a>'),
(123, '00000001', '16-04-2016 11:46:04', 'Modification de client : <a href="ili-modules/client/client?id=00000001">BEN ISSAA ALI</a>'),
(124, '00000001', '16-04-2016 13:47:33', 'Connexion'),
(125, '00000001', '16-04-2016 13:57:06', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=00000009">00000009</a>'),
(126, '00000001', '16-04-2016 14:01:40', 'Suppression de l''utilisateur avec CIN=00000009'),
(127, '00000001', '16-04-2016 14:03:10', 'Suppression de l''utilisateur avec CIN=00000002'),
(128, '00000001', '16-04-2016 14:04:33', 'Suppression de l`utilisateur avec CIN=00000003'),
(129, '00000001', '16-04-2016 14:08:09', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(130, '00000001', '16-04-2016 14:08:39', 'Changement de l''image de profil de l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(131, '00000001', '16-04-2016 14:09:19', 'Modification des liens socieaux de l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(132, '00000001', '16-04-2016 14:10:01', 'Ajout du diplôme : Bac, pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(133, '00000001', '16-04-2016 14:10:50', 'Changement de l''image de profil de l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(134, '00000001', '16-04-2016 14:11:25', 'Ajout du compétence : JS, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(135, '00000001', '16-04-2016 14:11:41', 'Ajout du compétence : HTML5, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(136, '00000001', '16-04-2016 14:11:49', 'Ajout du compétence : CSS3, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(137, '00000001', '16-04-2016 14:12:03', 'Ajout du compétence : PHP4/5, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(138, '00000001', '16-04-2016 14:12:28', 'Ajout du compétence : JS, pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(139, '00000001', '16-04-2016 14:12:37', 'Ajout du compétence : HTML4/5, pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(140, '00000001', '16-04-2016 14:12:49', 'Ajout du compétence : PHP4/5, pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(141, '00000001', '16-04-2016 14:12:58', 'Ajout du compétence : JAVA, pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(142, '00000001', '16-04-2016 14:40:26', 'Création de client : <a href="ili-modules/client/client?id=2">2</a>'),
(143, '00000001', '16-04-2016 14:41:03', 'Création de client : <a href="ili-modules/client/client?id=3">3</a>'),
(144, '00000001', '16-04-2016 14:41:29', 'Création de client : <a href="ili-modules/client/client?id=4">4</a>'),
(145, '00000001', '16-04-2016 14:42:12', 'Création de client : <a href="ili-modules/client/client?id=5">5</a>'),
(146, '00000001', '16-04-2016 14:49:55', 'Suppression de de client 1 1'),
(147, '00000001', '16-04-2016 14:50:02', 'Suppression de de client 2 2'),
(148, '00000001', '16-04-2016 14:50:08', 'Suppression de de client 3 3'),
(149, '00000001', '16-04-2016 14:50:13', 'Suppression de de client 4 4'),
(150, '00000001', '16-04-2016 14:50:19', 'Suppression de de client 5 5'),
(151, '00000001', '16-04-2016 21:47:54', 'Connexion'),
(152, '00000001', '16-04-2016 21:52:17', 'Modification de client : <a href="ili-modules/client/client?id=00000001">BEN ISSA ALI</a>'),
(153, '00000001', '16-04-2016 21:53:07', 'Modification de client : <a href="ili-modules/client/client?id=00000001">BEN ISSAA ALI</a>'),
(154, '00000001', '16-04-2016 21:53:30', 'Modification de client : <a href="ili-modules/client/client?id=00000001">BEN ISSAA ALI</a>'),
(155, '00000001', '16-04-2016 21:53:42', 'Modification de client : <a href="ili-modules/client/client?id=00000001">BEN ISSAA ALI</a>'),
(156, '00000001', '16-04-2016 23:04:32', 'Utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a> a été <strong>banni</strong>'),
(157, '00000001', '16-04-2016 23:18:02', 'Utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a> a été <strong>débanni</strong>'),
(158, '00000001', '17-04-2016 14:08:23', 'Connexion'),
(159, '00000001', '18-04-2016 11:12:12', 'Connexion'),
(160, '00000001', '18-04-2016 12:27:28', 'Ajout contract ID : 0100'),
(161, '00000001', '19-04-2016 00:37:24', 'Connexion'),
(162, '00000001', '19-04-2016 01:05:47', 'Création de client : <a href="ili-modules/client/client?id=00000003">00000003</a>'),
(163, '00000001', '19-04-2016 01:06:21', 'Ajout contract ID : 0200'),
(164, '00000001', '19-04-2016 01:27:16', 'Ajout contract ID : 0300'),
(165, '00000001', '19-04-2016 11:41:42', 'Connexion'),
(166, '00000001', '19-04-2016 11:43:22', 'Création de client : <a href="ili-modules/client/client?id=00000005">00000005</a>'),
(167, '00000001', '19-04-2016 11:57:34', 'Connexion'),
(168, '00000001', '19-04-2016 14:12:10', 'Renouvellement du contract #0200'),
(169, '00000001', '19-04-2016 17:36:09', 'Connexion'),
(170, '00000001', '20-04-2016 00:32:06', 'Connexion'),
(171, '00000001', '20-04-2016 11:55:14', 'Connexion'),
(172, '00000001', '20-04-2016 14:21:02', 'Ajout contract ID : 0500'),
(173, '00000001', '20-04-2016 14:59:20', 'Ajout de privilége <strong>CREER</strong> sur le bloc <strong>CONTRAT</strong> pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(174, '00000001', '20-04-2016 15:07:18', 'Renouvellement du contract #0500'),
(175, '00000001', '20-04-2016 15:49:10', 'Connexion'),
(176, '00000001', '20-04-2016 19:59:25', 'Connexion'),
(177, '00000001', '20-04-2016 20:10:32', 'Connexion'),
(178, '00000001', '21-04-2016 11:42:34', 'Connexion'),
(179, '00000001', '21-04-2016 13:39:35', 'Modification de client : <a href="ili-modules/client/client?id=00000003">RAISSI AZIZ</a>'),
(180, '00000001', '21-04-2016 13:40:01', 'Modification de client : <a href="ili-modules/client/client?id=00000005">BOUGHANMI KHOULOUD</a>'),
(181, '00000001', '21-04-2016 13:41:19', 'Création de client : <a href="ili-modules/client/client?id=1245 M/A/C 000 /J">1245 M/A/C 000 /J</a>'),
(182, '00000001', '21-04-2016 13:42:05', 'Ajout contract ID : 0900'),
(183, '00000001', '21-04-2016 13:54:08', 'Décaissement : #FACTURE:00618610_SONED'),
(184, '00000001', '21-04-2016 19:02:56', 'Connexion'),
(185, '00000001', '21-04-2016 23:14:32', 'Connexion'),
(186, '00000001', '23-04-2016 14:42:39', 'Connexion'),
(187, '00000001', '23-04-2016 15:44:07', 'Ajout de privilége <strong>RENOUVELER</strong> sur le bloc <strong>CONTRAT</strong> pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(188, '00000001', '23-04-2016 15:44:28', 'Déconnexion'),
(189, '00000001', '25-04-2016 12:31:02', 'Connexion'),
(190, '00000001', '25-04-2016 12:35:37', 'Ajout contract ID : 0901'),
(191, '00000001', '25-04-2016 12:37:22', 'Décaissement : Gazoile'),
(192, '00000001', '25-04-2016 12:38:12', 'Ajout de privilége <strong>CREER</strong> sur le bloc <strong>USERS</strong> pour l''utilisateur : <a href="ili-users/user_profil?id=09186670">09186670</a>'),
(193, '00000001', '26-04-2016 01:16:33', 'Connexion'),
(194, '00000001', '01-05-2016 01:28:57', 'Connexion'),
(195, '00000001', '01-05-2016 01:31:10', 'Ajout contract ID : 011'),
(196, '00000001', '01-05-2016 01:32:17', 'Décaissement : FACTURE ADSL'),
(197, '00000001', '01-05-2016 01:33:18', 'Décaissement : STEG'),
(198, '00000001', '09-05-2016 11:18:25', 'Connexion'),
(199, '00000001', '09-05-2016 11:20:36', 'Déconnexion'),
(200, '00000001', '09-05-2016 11:20:37', 'Connexion'),
(201, '09186670', '09-05-2016 11:24:35', 'Connexion'),
(202, '00000001', '09-05-2016 11:32:22', 'Création de client : <a href="ili-modules/client/client?id=0014 L/M/A 000 RC ">0014 L/M/A 000 RC </a>'),
(203, '00000001', '09-05-2016 11:33:08', 'Ajout contract ID : 0902'),
(204, '00000001', '09-05-2016 11:49:44', 'Décaissement : Divers & Imprévus'),
(205, '00000001', '10-05-2016 11:04:54', 'Connexion'),
(206, '00000001', '10-05-2016 11:09:17', 'Déconnexion'),
(207, '00000001', '10-05-2016 11:09:19', 'Connexion'),
(208, '00000001', '10-05-2016 13:01:20', 'Décaissement : test3'),
(209, '00000001', '10-05-2016 13:01:38', 'Décaissement : test3'),
(210, '00000001', '12-05-2016 10:26:52', 'Connexion'),
(211, '00000001', '12-05-2016 14:36:27', 'Ajout du diplôme : tayaran, pour l''utilisateur : <a href="ili-users/user_profil?id=00000001">00000001</a>'),
(212, '00000001', '12-05-2016 14:44:02', 'Création de l''utilisateur : <a href="ili-users/user_profil?id=07204349">07204349</a>');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `idMessage` int(255) NOT NULL AUTO_INCREMENT,
  `FromUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ToUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Containt` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TimeStamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Seen` tinyint(1) NOT NULL,
  `ClosedBy` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `idUser` (`FromUser`,`ClosedBy`),
  KEY `ClosedBy` (`ClosedBy`),
  KEY `FromUser` (`FromUser`),
  KEY `ToUser` (`ToUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`idMessage`, `FromUser`, `ToUser`, `Subject`, `Containt`, `TimeStamp`, `Seen`, `ClosedBy`) VALUES
(1, '00000001', '09186670', 'test', '<p>1</p>\r\n', '09-05-2016 11:24:05', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `notificationsystem`
--

CREATE TABLE IF NOT EXISTS `notificationsystem` (
  `idNotification` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Timestamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seen` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idNotification`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=224 ;

--
-- Contenu de la table `notificationsystem`
--

INSERT INTO `notificationsystem` (`idNotification`, `idUser`, `Description`, `Timestamp`, `seen`) VALUES
(40, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, modification des informations', '15-04-2016 13:35:35', '1'),
(62, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, ajout du diplôme : c', '15-04-2016 15:28:31', '1'),
(64, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, suppression du diplôme : c', '15-04-2016 15:28:33', '1'),
(75, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>CLIENTS</strong> de USER USER', '15-04-2016 16:55:43', '1'),
(77, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, a été banni', '15-04-2016 20:56:08', '1'),
(80, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, a été débanni', '15-04-2016 20:56:32', '1'),
(82, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, a été banni', '15-04-2016 20:57:07', '1'),
(85, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, a été débanni', '15-04-2016 20:57:15', '1'),
(88, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000003">SUSPENDUE SUSPENDUE, a été débanni', '15-04-2016 20:59:56', '1'),
(90, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, a été banni', '15-04-2016 21:00:05', '1'),
(93, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000002">USER USER, a été débanni', '15-04-2016 21:00:21', '1'),
(95, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000003">SUSPENDUE SUSPENDUE, a été banni', '15-04-2016 21:00:30', '1'),
(98, '00000001', '<a href="ili-users/user_profil?id=00000009">Nouveau utilisateur, Nom Prenom', '15-04-2016 21:16:16', '1'),
(101, '00000001', '<a href="ili-users/user_profil?id=00000009">Nouveau utilisateur, Nom Prenom', '15-04-2016 21:18:05', '1'),
(104, '00000001', '<a href="ili-users/user_profil?id=00000009">Nouveau utilisateur, Nom Prenom', '15-04-2016 21:18:21', '1'),
(107, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000009">Nouveau utilisateur, Nom Prenom', '15-04-2016 21:20:15', '1'),
(110, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000009">Nouveau utilisateur, nom Prenom', '15-04-2016 21:29:59', '1'),
(113, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000009">Nouveau utilisateur, test test', '15-04-2016 21:35:57', '1'),
(116, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=11111111">Nouveau utilisateur, Nom Prenom', '15-04-2016 21:44:11', '1'),
(119, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAOUI ', '16-04-2016 11:43:50', '1'),
(122, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ', '16-04-2016 11:46:04', '1'),
(125, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000009">Nouveau utilisateur,  ', '16-04-2016 13:57:06', '1'),
(126, '00000001', 'L`utilisateur avec CIN :00000003 a été supprimer', '16-04-2016 14:04:33', '1'),
(127, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Nouveau utilisateur, Hafaeid Abd El Karim', '16-04-2016 14:08:09', '1'),
(128, '00000001', '<a href="ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, modification de photo de profile', '16-04-2016 14:08:39', '1'),
(129, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, modification des liens socieaux', '16-04-2016 14:09:19', '1'),
(130, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, ajout du diplôme : Bac', '16-04-2016 14:10:01', '1'),
(131, '09186670', '<a href="ili-users/user_profil?id=00000001">Sakly Ayoub, modification de photo de profile', '16-04-2016 14:10:50', '0'),
(132, '09186670', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000001">Sakly Ayoub, ajout de compétence : JS', '16-04-2016 14:11:25', '0'),
(133, '09186670', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000001">Sakly Ayoub, ajout de compétence : HTML5', '16-04-2016 14:11:41', '0'),
(134, '09186670', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000001">Sakly Ayoub, ajout de compétence : CSS3', '16-04-2016 14:11:49', '0'),
(135, '09186670', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=00000001">Sakly Ayoub, ajout de compétence : PHP4/5', '16-04-2016 14:12:03', '0'),
(136, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, ajout de compétence : JS', '16-04-2016 14:12:28', '1'),
(137, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, ajout de compétence : HTML4/5', '16-04-2016 14:12:37', '1'),
(138, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, ajout de compétence : PHP4/5', '16-04-2016 14:12:49', '1'),
(139, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, ajout de compétence : JAVA', '16-04-2016 14:12:58', '1'),
(140, '09186670', '<a href="ili-modules/client/client?id=2">Sakly Ayoub a creé un nouveau client , 2 2', '16-04-2016 14:40:26', '0'),
(141, '00000001', '<a href="ili-modules/client/client?id=2">Sakly Ayoub a creé un nouveau client , 2 2', '16-04-2016 14:40:26', '1'),
(142, '09186670', '<a href="ili-modules/client/client?id=3">Sakly Ayoub a creé un nouveau client , 3 3', '16-04-2016 14:41:03', '0'),
(143, '00000001', '<a href="ili-modules/client/client?id=3">Sakly Ayoub a creé un nouveau client , 3 3', '16-04-2016 14:41:03', '1'),
(144, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=4">Sakly Ayoub a creé un nouveau client , 4 4', '16-04-2016 14:41:29', '0'),
(145, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=4">Sakly Ayoub a creé un nouveau client , 4 4', '16-04-2016 14:41:29', '1'),
(146, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=5">Sakly Ayoub a creé un nouveau client , 5 5', '16-04-2016 14:42:12', '0'),
(147, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=5">Sakly Ayoub a creé un nouveau client , 5 5', '16-04-2016 14:42:12', '1'),
(148, '09186670', '<a href="#">Sakly Ayoub a supprimé le client, 1 1', '16-04-2016 14:49:55', '0'),
(149, '00000001', '<a href="#">Sakly Ayoub a supprimé le client, 1 1', '16-04-2016 14:49:55', '1'),
(150, '09186670', '<a href="#">Sakly Ayoub a supprimé le client, 2 2', '16-04-2016 14:50:02', '0'),
(151, '00000001', '<a href="#">Sakly Ayoub a supprimé le client, 2 2', '16-04-2016 14:50:02', '1'),
(152, '09186670', '<a href="#">Sakly Ayoub a supprimé le client, 3 3', '16-04-2016 14:50:08', '0'),
(153, '00000001', '<a href="#">Sakly Ayoub a supprimé le client, 3 3', '16-04-2016 14:50:08', '1'),
(154, '09186670', '<a href="#">Sakly Ayoub a supprimé le client, 4 4', '16-04-2016 14:50:13', '0'),
(155, '00000001', '<a href="#">Sakly Ayoub a supprimé le client, 4 4', '16-04-2016 14:50:13', '1'),
(156, '09186670', '<a href="#">Sakly Ayoub a supprimé le client, 5 5', '16-04-2016 14:50:19', '0'),
(157, '00000001', '<a href="#">Sakly Ayoub a supprimé le client, 5 5', '16-04-2016 14:50:19', '1'),
(158, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSA ', '16-04-2016 21:52:17', '0'),
(159, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSA ', '16-04-2016 21:52:17', '1'),
(160, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ', '16-04-2016 21:53:07', '0'),
(161, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ', '16-04-2016 21:53:07', '1'),
(162, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ALI', '16-04-2016 21:53:30', '0'),
(163, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ALI', '16-04-2016 21:53:30', '1'),
(164, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ALI', '16-04-2016 21:53:42', '0'),
(165, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000001">Sakly Ayoub a modifié le client, BEN ISSAA ALI', '16-04-2016 21:53:42', '1'),
(166, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, a été banni', '16-04-2016 23:04:32', '1'),
(167, '09186670', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, a été débanni', '16-04-2016 23:18:02', '0'),
(168, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=09186670">Hafaeid Abd El Karim, a été débanni', '16-04-2016 23:18:02', '1'),
(169, '09186670', 'Ajout contract ID : 0100', '18-04-2016 12:27:28', '0'),
(170, '00000001', 'Ajout contract ID : 0100', '18-04-2016 12:27:28', '1'),
(171, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000003">Sakly Ayoub a creé un nouveau client , Rassi Aziz', '19-04-2016 01:05:47', '0'),
(172, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000003">Sakly Ayoub a creé un nouveau client , Rassi Aziz', '19-04-2016 01:05:47', '1'),
(173, '09186670', 'Ajout contract ID : 0200', '19-04-2016 01:06:21', '0'),
(174, '00000001', 'Ajout contract ID : 0200', '19-04-2016 01:06:21', '1'),
(175, '09186670', 'Ajout contract ID : 0300', '19-04-2016 01:27:16', '0'),
(176, '00000001', 'Ajout contract ID : 0300', '19-04-2016 01:27:16', '1'),
(177, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000005">Sakly Ayoub a creé un nouveau client , Boughanmi Khouloud', '19-04-2016 11:43:22', '0'),
(178, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000005">Sakly Ayoub a creé un nouveau client , Boughanmi Khouloud', '19-04-2016 11:43:22', '1'),
(179, '09186670', 'Sakly Ayoub a renouveler le contrat #0200', '19-04-2016 14:12:10', '0'),
(180, '00000001', 'Sakly Ayoub a renouveler le contrat #0200', '19-04-2016 14:12:10', '1'),
(181, '09186670', 'Ajout contract ID : 0500', '20-04-2016 14:21:02', '0'),
(182, '00000001', 'Ajout contract ID : 0500', '20-04-2016 14:21:02', '1'),
(183, '09186670', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>CONTRAT</strong> de Hafaeid Abd El Karim', '20-04-2016 14:59:20', '0'),
(184, '00000001', '<a href="http://localhost/ili-crm-assure/ili-users/user_profil?id=">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>CONTRAT</strong> de Hafaeid Abd El Karim', '20-04-2016 14:59:20', '1'),
(185, '09186670', 'Sakly Ayoub a renouveler le contrat #0500', '20-04-2016 15:07:18', '0'),
(186, '00000001', 'Sakly Ayoub a renouveler le contrat #0500', '20-04-2016 15:07:18', '1'),
(187, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000003">Sakly Ayoub a modifié le client, RAISSI AZIZ', '21-04-2016 13:39:35', '0'),
(188, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000003">Sakly Ayoub a modifié le client, RAISSI AZIZ', '21-04-2016 13:39:35', '1'),
(189, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000005">Sakly Ayoub a modifié le client, BOUGHANMI KHOULOUD', '21-04-2016 13:40:01', '0'),
(190, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=00000005">Sakly Ayoub a modifié le client, BOUGHANMI KHOULOUD', '21-04-2016 13:40:01', '1'),
(191, '09186670', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=1245 M/A/C 000 /J">Sakly Ayoub a creé un nouveau client , TNL DISTRIBUTION SARL', '21-04-2016 13:41:19', '0'),
(192, '00000001', '<a href="http://localhost/ili-crm-assure/ili-modules/client/client?id=1245 M/A/C 000 /J">Sakly Ayoub a creé un nouveau client , TNL DISTRIBUTION SARL', '21-04-2016 13:41:19', '1'),
(193, '09186670', 'Ajout contract ID : 0900', '21-04-2016 13:42:05', '0'),
(194, '00000001', 'Ajout contract ID : 0900', '21-04-2016 13:42:05', '1'),
(195, '09186670', ' a effectuer un décaissement : #FACTURE:00618610_SONED', '21-04-2016 13:54:08', '0'),
(196, '00000001', ' a effectuer un décaissement : #FACTURE:00618610_SONED', '21-04-2016 13:54:08', '1'),
(197, '09186670', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=">Ajout du privilége <strong>RENOUVELER</strong> sur le bloc <strong>CONTRAT</strong> de Hafaeid Abd El Karim', '23-04-2016 15:44:07', '0'),
(198, '00000001', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=">Ajout du privilége <strong>RENOUVELER</strong> sur le bloc <strong>CONTRAT</strong> de Hafaeid Abd El Karim', '23-04-2016 15:44:07', '1'),
(199, '09186670', 'Ajout contract ID : 0901', '25-04-2016 12:35:37', '0'),
(200, '00000001', 'Ajout contract ID : 0901', '25-04-2016 12:35:37', '1'),
(201, '09186670', ' a effectuer un décaissement : Gazoile', '25-04-2016 12:37:22', '0'),
(202, '00000001', ' a effectuer un décaissement : Gazoile', '25-04-2016 12:37:22', '1'),
(203, '09186670', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>USERS</strong> de Hafaeid Abd El Karim', '25-04-2016 12:38:12', '0'),
(204, '00000001', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=">Ajout du privilége <strong>CREER</strong> sur le bloc <strong>USERS</strong> de Hafaeid Abd El Karim', '25-04-2016 12:38:12', '1'),
(205, '09186670', 'Ajout contract ID : 011', '01-05-2016 01:31:10', '0'),
(206, '00000001', 'Ajout contract ID : 011', '01-05-2016 01:31:10', '1'),
(207, '09186670', ' a effectuer un décaissement : FACTURE ADSL', '01-05-2016 01:32:17', '0'),
(208, '00000001', ' a effectuer un décaissement : FACTURE ADSL', '01-05-2016 01:32:17', '1'),
(209, '09186670', ' a effectuer un décaissement : STEG', '01-05-2016 01:33:18', '0'),
(210, '00000001', ' a effectuer un décaissement : STEG', '01-05-2016 01:33:18', '1'),
(211, '09186670', '<a href="http://localhost/erp-aa-v1/ili-modules/client/client?id=0014 L/M/A 000 RC ">Sakly Ayoub a creé un nouveau client , STE : BFCO SARL', '09-05-2016 11:32:22', '0'),
(212, '00000001', '<a href="http://localhost/erp-aa-v1/ili-modules/client/client?id=0014 L/M/A 000 RC ">Sakly Ayoub a creé un nouveau client , STE : BFCO SARL', '09-05-2016 11:32:22', '1'),
(213, '09186670', 'Ajout contract ID : 0902', '09-05-2016 11:33:08', '0'),
(214, '00000001', 'Ajout contract ID : 0902', '09-05-2016 11:33:08', '1'),
(215, '09186670', ' a effectuer un décaissement : Divers & Imprévus', '09-05-2016 11:49:44', '0'),
(216, '00000001', ' a effectuer un décaissement : Divers & Imprévus', '09-05-2016 11:49:44', '1'),
(217, '09186670', ' a effectuer un décaissement : test3', '10-05-2016 13:01:20', '0'),
(218, '00000001', ' a effectuer un décaissement : test3', '10-05-2016 13:01:20', '1'),
(219, '09186670', '00000001 a effectuer un décaissement : test3', '10-05-2016 13:01:38', '0'),
(220, '00000001', '00000001 a effectuer un décaissement : test3', '10-05-2016 13:01:38', '1'),
(221, '09186670', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=00000001">Sakly Ayoub, ajout du diplôme : tayaran', '12-05-2016 14:36:27', '0'),
(222, '09186670', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=07204349">Nouveau utilisateur, Boughanmi Khouloud', '12-05-2016 14:44:02', '0'),
(223, '00000001', '<a href="http://localhost/erp-aa-v1/ili-users/user_profil?id=07204349">Nouveau utilisateur, Boughanmi Khouloud', '12-05-2016 14:44:02', '0');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `idPayment` int(255) NOT NULL AUTO_INCREMENT,
  `EncashmentDate` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PaymentKind` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PaymentCode` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Bank` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TransferDate` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `RecevedBy` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idPayment`),
  KEY `RecevedBy` (`RecevedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `payment`
--

INSERT INTO `payment` (`idPayment`, `EncashmentDate`, `Description`, `PaymentKind`, `PaymentCode`, `Bank`, `TransferDate`, `Amount`, `RecevedBy`) VALUES
(1, '18-04-2016', '', 'ESPECE', '', '', '', '250.000', '00000001'),
(2, '19-04-2016', '', 'ESPECE', '', '', '', '245.250', '00000001'),
(3, '19-04-2016', '', 'ESPECE', '', '', '', '80.000', '00000001'),
(7, '19-04-2016', '', 'ESPECE', '', '', '', '100.000', '00000001'),
(8, '19-04-2016', '', 'ESPECE', '', '', '', '150.000', '00000001'),
(9, '20-04-2016', '', 'CHEQUE', '0100600', 'STB', '25-04-2016', '850.000', '00000001'),
(10, '20-04-2016', '', 'ESPECE', '', '', '', '245.022', '00000001'),
(11, '21-04-2016', '', 'CHEQUE', '0100609', 'UBCI', '21-05-2016', '287.000', '00000001'),
(12, '21-04-2016', '#FACTURE:001524250_TOPNET', 'ESPECE', '', '', '', '-100', '00000001'),
(13, '21-04-2016', '#FACTURE:00618610_SONED', 'ESPECE', '', '', '', '-50', '00000001'),
(14, '25-04-2016', '', 'CHEQUE', '0100200300', 'UIB', '26-04-2016', '250.000', '00000001'),
(15, '25-04-2016', 'Gazoile', 'CHEQUE', '0123', 'BIAT', '25-04-2016', '-70', '00000001'),
(16, '01-05-2016', '', 'ESPECE', '', '', '', '250.000', '00000001'),
(17, '01-05-2016', 'FACTURE ADSL', 'ESPECE', '', '', '', '-100', '00000001'),
(18, '01-05-2016', 'STEG', 'CHEQUE', '5000', 'UIB', '02-05-2016', '-100', '00000001'),
(19, '09-05-2016', '', 'CHEQUE', '00015245245', 'UBCI', '09-05-2016', '352.245', '00000001'),
(20, '09-05-2016', 'Divers & Imprévus', 'CHEQUE', '02255025531', 'BIAT', '09-05-2016', '-100', '00000001');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `idRank` int(10) NOT NULL,
  `FamilyName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `FirstName` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `FunctionPost` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Adress` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `BirthDay` varchar(255) NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `LastPasswordChangedDate` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fbAccount` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `githubAccount` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `linkedinAccount` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ProfilePhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `CreatedBy` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `CreatedDate` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idUser`),
  KEY `idRank` (`idRank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUser`, `idRank`, `FamilyName`, `FirstName`, `Email`, `FunctionPost`, `Phone`, `Adress`, `BirthDay`, `Password`, `LastPasswordChangedDate`, `fbAccount`, `githubAccount`, `linkedinAccount`, `ProfilePhoto`, `CreatedBy`, `CreatedDate`) VALUES
('00000001', 3, 'Sakly', 'Ayoub', 'saklyayoub@live.com', 'Gérant', '20.666.996', '16 Rue Ben Zid Agba 2010 Manouba', '22-09-1988', '3cb61b94f984497b9230075a6f777346', '15-04-2016 15:26:22', 'http://www.facebook.com/saklyayoub', 'https://github.com/saklyayoub', 'https://www.linkedin.com/in/sakly-ayoub-ba269391', 'http://www.ili-studios.tn/img/saklyayoub.png', 'SAKLY AYOUB', '2016-03-12 11:48:10'),
('07204349', 2, 'Boughanmi', 'Khouloud', 'kouloud.boughanmi@yahoo.fr', 'Stagiaire ', '20.180.681', 'Ben arous', '05-08-1993', '8eaaded21bf16e0e151c0e96f1302405', '12-05-2016 14:44:02', '', '', '', '', 'Sakly Ayoub', '12-05-2016 14:44:02'),
('09186670', 2, 'Hafaeid', 'Abd El Karim', 'hafaeidh@ili-studios.com', 'CO-Founder', '52.239.322', '60 Rue de tazarka, Denden, Manouba 2010', '01-08-1993', '21232f297a57a5a743894a0e4a801fc3', '16-04-2016 14:08:09', 'https://www.facebook.com/profile.php?id=100004842556636&fref=ts', 'https://github.com/AbdouHF', '', 'http://www.ili-studios.tn/img/abdou.png', 'Sakly Ayoub', '16-04-2016 14:08:09');

-- --------------------------------------------------------

--
-- Structure de la table `usersdiploma`
--

CREATE TABLE IF NOT EXISTS `usersdiploma` (
  `idDiploma` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Year` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Institute` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idDiploma`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `usersdiploma`
--

INSERT INTO `usersdiploma` (`idDiploma`, `idUser`, `Year`, `Location`, `Description`, `Institute`) VALUES
(1, '09186670', '2013', 'Manouba', 'Bac', 'Ibn Abi Dhiaf'),
(2, '00000001', '2010', 'gamra', 'tayaran', 'naza');

-- --------------------------------------------------------

--
-- Structure de la table `usersexperience`
--

CREATE TABLE IF NOT EXISTS `usersexperience` (
  `idExperience` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Company` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `CompanyURL` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Period` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idExperience`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `usersprivilege`
--

CREATE TABLE IF NOT EXISTS `usersprivilege` (
  `idPrivilege` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bloc` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `s` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `c` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `u` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `d` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idPrivilege`),
  KEY `idUser` (`idUser`),
  KEY `idUser_2` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `usersprivilege`
--

INSERT INTO `usersprivilege` (`idPrivilege`, `idUser`, `bloc`, `s`, `c`, `u`, `d`) VALUES
(6, '09186670', 'USERS', '1', '1', '0', '0'),
(7, '09186670', 'CLIENTS', '1', '0', '0', '0'),
(8, '09186670', 'CONTRAT', '1', '1', '1', '0'),
(9, '07204349', 'USERS', '1', '0', '0', '0'),
(10, '07204349', 'CLIENTS', '1', '0', '0', '0'),
(11, '07204349', 'CONTRAT', '1', '0', '0', '0');

-- --------------------------------------------------------

--
-- Structure de la table `usersqualification`
--

CREATE TABLE IF NOT EXISTS `usersqualification` (
  `idQualification` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Label` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Value` float NOT NULL,
  PRIMARY KEY (`idQualification`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `usersqualification`
--

INSERT INTO `usersqualification` (`idQualification`, `idUser`, `Label`, `Value`) VALUES
(1, '00000001', 'JS', 50),
(2, '00000001', 'HTML5', 83),
(3, '00000001', 'CSS3', 92),
(4, '00000001', 'PHP4/5', 87),
(5, '09186670', 'JS', 62),
(6, '09186670', 'HTML4/5', 75),
(7, '09186670', 'PHP4/5', 59),
(8, '09186670', 'JAVA', 68);

-- --------------------------------------------------------

--
-- Structure de la table `usersrank`
--

CREATE TABLE IF NOT EXISTS `usersrank` (
  `idRank` int(10) NOT NULL AUTO_INCREMENT,
  `Level` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idRank`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `usersrank`
--

INSERT INTO `usersrank` (`idRank`, `Level`) VALUES
(1, 'suspendue'),
(2, 'utilisateur'),
(3, 'admin'),
(4, 'developpeur');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `contractcycle`
--
ALTER TABLE `contractcycle`
  ADD CONSTRAINT `contractcycle_ibfk_1` FOREIGN KEY (`idContract`) REFERENCES `insurancecontract` (`idContract`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contractcycle_ibfk_2` FOREIGN KEY (`idPayment`) REFERENCES `payment` (`idPayment`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contractcycle_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `discussion`
--
ALTER TABLE `discussion`
  ADD CONSTRAINT `discussion_ibfk_1` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_2` FOREIGN KEY (`FormUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_3` FOREIGN KEY (`ToUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `insurancecontract`
--
ALTER TABLE `insurancecontract`
  ADD CONSTRAINT `insurancecontract_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `logsystem`
--
ALTER TABLE `logsystem`
  ADD CONSTRAINT `logsystem_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`ClosedBy`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`FromUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_4` FOREIGN KEY (`ToUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notificationsystem`
--
ALTER TABLE `notificationsystem`
  ADD CONSTRAINT `notificationsystem_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`RecevedBy`) REFERENCES `users` (`idUser`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idRank`) REFERENCES `usersrank` (`idRank`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersdiploma`
--
ALTER TABLE `usersdiploma`
  ADD CONSTRAINT `usersdiploma_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersexperience`
--
ALTER TABLE `usersexperience`
  ADD CONSTRAINT `usersexperience_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersprivilege`
--
ALTER TABLE `usersprivilege`
  ADD CONSTRAINT `usersprivilege_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `usersqualification`
--
ALTER TABLE `usersqualification`
  ADD CONSTRAINT `usersqualification_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
