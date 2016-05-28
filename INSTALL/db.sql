CREATE TABLE IF NOT EXISTS `usersrank` (
  `idRank` int(10) NOT NULL AUTO_INCREMENT,
  `Level` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idRank`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
INSERT INTO `usersrank` (`idRank`, `Level`) VALUES
(1, 'suspendue'),
(2, 'utilisateur'),
(3, 'admin'),
(4, 'developpeur');
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
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idRank`) REFERENCES `usersrank` (`idRank`) ON DELETE CASCADE ON UPDATE CASCADE;
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
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`ClosedBy`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_3` FOREIGN KEY (`FromUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_4` FOREIGN KEY (`ToUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
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
ALTER TABLE `discussion`
  ADD CONSTRAINT `discussion_ibfk_1` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_2` FOREIGN KEY (`FromUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discussion_ibfk_3` FOREIGN KEY (`ToUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `contractcycle`
  ADD CONSTRAINT `contractcycle_ibfk_1` FOREIGN KEY (`idContract`) REFERENCES `insurancecontract` (`idContract`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contractcycle_ibfk_2` FOREIGN KEY (`idPayment`) REFERENCES `payment` (`idPayment`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contractcycle_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `insurancecontract` (
  `idContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `idClient` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `TypeContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `KindContract` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idContract`),
  KEY `idClient` (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `insurancecontract`
  ADD CONSTRAINT `insurancecontract_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`) ON UPDATE CASCADE;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`RecevedBy`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `logsystem` (
  `idLog` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Timestamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `notificationsystem` (
  `idNotification` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Timestamp` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seen` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idNotification`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `notificationsystem`
  ADD CONSTRAINT `notificationsystem_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL,
  `MF` varchar(255) NOT NULL,
  `RC` varchar(255) NOT NULL,
  `RS` varchar(255) NOT NULL,
  `Activity` varchar(255) NOT NULL,
  `Adress` varchar(255) NOT NULL,
  `Phone1` varchar(255) NOT NULL,
  `Phone2` varchar(255) NOT NULL,
  `Fax` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `WebSite` varchar(255) NOT NULL,
  `BankAccount1` varchar(255) NOT NULL,
  `BankAccount2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `RC` (`RC`,`RS`,`Activity`,`Phone1`,`Phone2`,`Fax`,`Email`,`WebSite`,`BankAccount1`,`BankAccount2`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `help` (
  `idHelp` int(20) NOT NULL AUTO_INCREMENT,
  `Category` varchar(255) NOT NULL,
  `Question` varchar(1000) NOT NULL,
  `Answer` varchar(10000) NOT NULL,
  PRIMARY KEY (`idHelp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
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
CREATE TABLE IF NOT EXISTS `usersqualification` (
  `idQualification` int(255) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Label` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Value` float NOT NULL,
  PRIMARY KEY (`idQualification`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `usersqualification`
  ADD CONSTRAINT `usersqualification_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `usersprivilege`
  ADD CONSTRAINT `usersprivilege_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
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
ALTER TABLE `usersexperience`
  ADD CONSTRAINT `usersexperience_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
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
ALTER TABLE `usersdiploma`
  ADD CONSTRAINT `usersdiploma_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;