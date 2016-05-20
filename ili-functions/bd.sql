-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 20 Mai 2016 à 19:29
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `contractcycle`
--

INSERT INTO `contractcycle` (`idCycle`, `idPayment`, `idContract`, `StartDate`, `EndDate`, `CreatedBy`) VALUES
(12, 22, '1002003001', '20-05-2016', '20-12-2016', '00000001');

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

CREATE TABLE IF NOT EXISTS `discussion` (
  `idDiscussion` int(255) NOT NULL AUTO_INCREMENT,
  `idMessage` int(255) NOT NULL,
  `FromUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ToUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Containt` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TimeStamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Seen` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDiscussion`),
  KEY `idMessage` (`idMessage`),
  KEY `FormUser` (`FromUser`),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `help`
--

INSERT INTO `help` (`idHelp`, `Category`, `Question`, `Answer`) VALUES
(1, 'Profile', 'Modification des diplôme?', '<ul>\n<li>Connexion > Mon Profile > Modifier Profile > Modifier Mes Diplômes</li>\n<li>Effectuer la modification</li>\n<li>Enregistrer</li>\n</ul>'),
(2, 'Utilisateurs', 'Ajouter un utilisateur', '<ul>\n<li>Connexion > Utilisateurs > Ajouter </li>\n<li>Remplir le formulaire </li>\n<li>Crée</li>\n</ul>  '),
(3, 'Profile', 'Modification des d’expérance?', 'Connexion > Mon Profile > Modifier Profile > Modifier Mes Expérance<br> Effectuer la modification <br>\r\nEnregistrer'),
(4, 'Profile', 'Modification des informations personelle?', 'Connexion > Mon Profile > Modifier Profile > Modifier Mes Informations Personelles<br> Effectuer la modification <br>\r\nEnregistrer'),
(5, 'Profile', 'Modification de la photo de profile?', '<ul>\r\n<li>Connexion > Mon Profile > Modifier Profile > Modifier photo de profile</li>\r\n<li>Effectuer la modification</li>\r\n<li>Enregistrer</li>\r\n</ul>'),
(6, 'Utilisateurs', 'Supprimer un utilisateur?', '<ul>\n<li>Connexion > Utilisateurs > supprimer ></li>\n<li>Effectuer la supprission</li>\n<li>supprimer</li>\n</ul>'),
(7, 'Utilisateurs', 'modifier un utilisateur?', '<ul>\n<li>Connexion > Utilisateurs > modifier les champs ></li>\n<li>Effectuer la modification</li>\n<li>Enregistrer</li>\n</ul>'),
(10, 'Jornal System', 'Affiche le jornal du system?', '<ul>\n<li>Connexion > Jornal du system > Recherche par id ou opérateur ou operation ou date ></li>\n</ul>'),
(11, 'Message', 'Envoyer message?', '<ul>\r\n<li>Connexion > Message > Nouveau message</li>\r\n<li>Remplir sujet</li>\r\n<li>choisir le destinateur</li>\r\n<li>Remplir le contenu de message</li>\r\n<li>Envoyer</li>\r\n</ul>'),
(12, 'Message', 'Boite de reception?', '<ul>\r\n<li>Connexion > Message > Boite de reception </li>\r\n<li>ouvrir boite de message et repondu</li>\r\n</ul>'),
(13, 'Dashboard', 'Dashboard?', '<ul>\r\n<li>Connexion > Dashboard > </li>\r\n<li>les statistiques du système</li>\r\n<li>historique des notifications </li>\r\n<li>historique des messages</li>\r\n</ul>'),
(14, 'Client', 'Ajout client?', '<ul>\n<li>Connexion > Clients > Ajouter </li>\n<li>Remplir le formulaire </li>\n<li>Crée</li>\n</ul>'),
(15, 'Client', 'Supprimer un client?', '<ul>\n<li>Connexion > Clients > click sur le Client que vous souhaitez supprimer > supprimer ></li>\n<li>Effectuer la supprission</li>\n<li>supprimer</li>\n</ul>'),
(16, 'Client', 'Modifier un client?', '<ul>\n<li>Connexion > Clients > click sur le Client que vous souhaitez modifier > modifier les champs ></li>\n<li>Effectuer la modification</li>\n<li>Enregistrer</li>\n</ul>'),
(17, 'Contrat', 'Liste des contrats?', '<ul>\n<li>Connexion > Liste des contrats </li>\n<li>Recherche par Conrtat, Client, Nature, Type, Date Debut, Date Fin ou Etat</li>\n</ul>'),
(18, 'Caisse', 'Journal du caisse?', '<ul>\r\n<li>Connexion > Caisse > Journal du caisse  </li>\r\n<li>choisir la date début et la date fin </li>\r\n<li>filtrer la recette de caisse par utilisateur ou par tous les opérateurs</li>\r\n<li>chercher</li>\r\n</ul>'),
(19, 'Caisse', 'Echéancier ?', '<ul>\r\n<li>Connexion > Caisse > Echéancier  </li>\r\n<li>choisir la date début et la date fin </li>\r\n<li>filtrer la recette de Echéancier chèque par credits ou debuts</li>\r\n<li>chercher</li>\r\n</ul>'),
(20, 'Caisse', 'Décaissement  ?', '<ul>\r\n<li>Connexion > Caisse > Décaissement   </li>\r\n<li>choisir la paiement de décaissement chéque ou espéces </li>\r\n<li>écrit le montant et la désignation de décaissement</li>\r\n<li>Enregistrer</li>\r\n</ul>'),
(21, 'Contrat', 'Ajout?', '<ul>\r\n<li>Connexion > Contrat > choix d''ajout > Poursuivre</li>\r\n<li>Remplir le formulaire </li>\r\n<li>Crée</li>\r\n</ul>\r\n</ul>'),
(22, 'Contrat', 'Renouveler?', '<ul>\r\n<li>Connexion > Contrat > Renouveler </li>\r\n<li>click sur le Client que vous souhaitez de renouveler </li>\r\n<li>Enregistrer</li>\r\n</ul>\r\n</ul>'),
(23, 'Caisse', 'Détails paiement  ?', '<ul>\r\n<li>Connexion > Caisse >    </li>\r\n<li>  </li>\r\n<li></li>\r\n<li></li>\r\n</ul>');

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
('1002003001', '00000001', 'Automobile', 'Renouvelable');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=301 ;

--
-- Contenu de la table `logsystem`
--

INSERT INTO `logsystem` (`idLog`, `idUser`, `Timestamp`, `Description`) VALUES
(297, '00000001', '20-05-2016 12:09:39', 'Ajout contract ID : 1002003001'),
(298, '00000001', '20-05-2016 18:42:24', 'Connexion'),
(299, '00000001', '20-05-2016 18:43:34', 'Connexion'),
(300, '00000001', '20-05-2016 18:44:43', 'Décaissement : #FACTURE TOPNET #1516121032');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=345 ;

--
-- Contenu de la table `notificationsystem`
--

INSERT INTO `notificationsystem` (`idNotification`, `idUser`, `Description`, `Timestamp`, `seen`) VALUES
(341, '09186670', 'Ajout contract ID : 1002003001', '20-05-2016 12:09:39', '0'),
(342, '00000001', 'Ajout contract ID : 1002003001', '20-05-2016 12:09:39', '0'),
(343, '09186670', '00000001 a effectuer un décaissement : #FACTURE TOPNET #1516121032', '20-05-2016 18:44:43', '0'),
(344, '00000001', '00000001 a effectuer un décaissement : #FACTURE TOPNET #1516121032', '20-05-2016 18:44:43', '0');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `idPayment` int(255) NOT NULL AUTO_INCREMENT,
  `EncashmentDate` date NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PaymentKind` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PaymentCode` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Bank` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TransferDate` date NOT NULL,
  `Amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `RecevedBy` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idPayment`),
  KEY `RecevedBy` (`RecevedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `payment`
--

INSERT INTO `payment` (`idPayment`, `EncashmentDate`, `Description`, `PaymentKind`, `PaymentCode`, `Bank`, `TransferDate`, `Amount`, `RecevedBy`) VALUES
(22, '2016-05-20', '', 'ESPECE', '', '', '0000-00-00', '280.000', '00000001'),
(23, '2016-05-20', '#FACTURE TOPNET #1516121032', 'CHEQUE', '100200300', 'UIB', '2016-05-30', '-195', '00000001');

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
('09186670', 2, 'hafeidh', 'abdel kerim', 'hafeidh@ili-studios.com', 'administrateur', '52.239.322', 'tunis', '01-08-1993', '8a30ec6807f71bc69d096d8e4d501ade', '19-05-2016 11:01:32', '', '', '', 'http://ili-studios.tn/img/abdou.png', 'Sakly Ayoub', '13-05-2016 13:07:49');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `usersprivilege`
--

INSERT INTO `usersprivilege` (`idPrivilege`, `idUser`, `bloc`, `s`, `c`, `u`, `d`) VALUES
(12, '09186670', 'USERS', '0', '1', '1', '1'),
(13, '09186670', 'CLIENTS', '1', '1', '1', '1'),
(14, '09186670', 'CONTRAT', '1', '1', '1', '1'),
(15, '09186670', 'CAISSE', '0', '0', '0', '0');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `usersqualification`
--

INSERT INTO `usersqualification` (`idQualification`, `idUser`, `Label`, `Value`) VALUES
(1, '00000001', 'JS', 50),
(2, '00000001', 'HTML5', 83),
(3, '00000001', 'CSS3', 92),
(4, '00000001', 'PHP4/5', 87);

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
  ADD CONSTRAINT `discussion_ibfk_2` FOREIGN KEY (`FromUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
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
