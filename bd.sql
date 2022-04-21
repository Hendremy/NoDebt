-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Dim 17 Avril 2022 à 10:09
-- Version du serveur :  5.7.29
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `in19b1145`
--

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_depense`
--

CREATE TABLE `nodebt_depense` (
  `did` int(11) NOT NULL,
  `dateHeure` datetime NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodebt_depense`
--

INSERT INTO `nodebt_depense` (`did`, `dateHeure`, `montant`, `libelle`, `uid`, `gid`) VALUES
(1, '2022-04-11 13:44:11', '10', 'Raclette', 14, 1),
(2, '2022-04-11 13:44:46', '25', 'Fondue', 14, 1),
(3, '2022-04-11 13:44:47', '36', 'Steak', 14, 1),
(7, '2022-04-14 00:00:00', '55', 'Cannettes Monster', 15, 1),
(8, '2022-04-14 00:00:00', '2', 'Nom', 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_facture`
--

CREATE TABLE `nodebt_facture` (
  `fid` int(11) NOT NULL,
  `scan` varchar(100) NOT NULL,
  `did` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_groupe`
--

CREATE TABLE `nodebt_groupe` (
  `gid` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `devise` varchar(5) NOT NULL,
  `own_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodebt_groupe`
--

INSERT INTO `nodebt_groupe` (`gid`, `nom`, `devise`, `own_uid`) VALUES
(1, 'My first group', 'EUR', 14),
(4, 'Un autre groupe', 'USD', 14),
(5, 'Zoubiii', 'USD', 14),
(6, 'Test', 'JPY', 14),
(7, 'Test sterling', 'GBP', 14),
(8, 'Tatatata', 'USD', 14),
(9, 'Zzzzzzz', 'EUR', 14),
(10, 'Joli', 'EUR', 14);

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_participe`
--

CREATE TABLE `nodebt_participe` (
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `estConfirme` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodebt_participe`
--

INSERT INTO `nodebt_participe` (`uid`, `gid`, `estConfirme`) VALUES
(14, 1, 1),
(14, 4, 1),
(14, 5, 1),
(14, 6, 1),
(14, 7, 1),
(14, 8, 1),
(14, 9, 1),
(14, 10, 1),
(15, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_tag`
--

CREATE TABLE `nodebt_tag` (
  `tid` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodebt_tag`
--

INSERT INTO `nodebt_tag` (`tid`, `tag`, `gid`) VALUES
(1, 'BBQ', 1),
(2, 'Sauce', 1),
(3, 'Energy', 1),
(4, 'NoSleep', 1),
(5, 'BBQ', 1);

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_tag_caracterise`
--

CREATE TABLE `nodebt_tag_caracterise` (
  `did` int(11) NOT NULL,
  `tid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodebt_tag_caracterise`
--

INSERT INTO `nodebt_tag_caracterise` (`did`, `tid`) VALUES
(7, 3),
(7, 4);

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_utilisateur`
--

CREATE TABLE `nodebt_utilisateur` (
  `uid` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `hashpass` varchar(128) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `nodebt_utilisateur`
--

INSERT INTO `nodebt_utilisateur` (`uid`, `email`, `lastname`, `firstname`, `hashpass`, `isActive`) VALUES
(14, 'remyremy2@gmail.com', 'Hendricé', 'Rémy', '99adc231b045331e514a516b4b7680f588e3823213abe901738bc3ad67b2f6fcb3c64efb93d18002588d3ccc1a49efbae1ce20cb43df36b38651f11fa75678e8', 1),
(15, 'r.hendrice@student.helmo.be', 'Rémy', 'Test', '1525555d9c57c42961e36ecf39e3ce040d0e115571f5a0424f15a4d612a773692bf0f91230a7bd31d58d5a461b761b921214c19309ee22eecfb6cf6a68d3a0c6', 1),
(16, 'ekuzplosion@gmail.com', 'Plosion', 'Ekuz', '42bb826d3015aee86f78251f716c77b5c9aadcbb029b811082ba4f77314d0c4d7466a1617dc4b5769e62b5efc4982f51d63902e589dd848dc5271e22bcf4c9d8', 1);

-- --------------------------------------------------------

--
-- Structure de la table `nodebt_versement`
--

CREATE TABLE `nodebt_versement` (
  `verseId` int(11) NOT NULL,
  `recoitId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  `dateHeure` datetime NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `estConfirme` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `nodebt_depense`
--
ALTER TABLE `nodebt_depense`
  ADD PRIMARY KEY (`did`),
  ADD KEY `uid` (`uid`),
  ADD KEY `guid` (`gid`);

--
-- Index pour la table `nodebt_facture`
--
ALTER TABLE `nodebt_facture`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `did` (`did`);

--
-- Index pour la table `nodebt_groupe`
--
ALTER TABLE `nodebt_groupe`
  ADD PRIMARY KEY (`gid`),
  ADD KEY `uid` (`own_uid`);

--
-- Index pour la table `nodebt_participe`
--
ALTER TABLE `nodebt_participe`
  ADD PRIMARY KEY (`uid`,`gid`),
  ADD KEY `gid` (`gid`);

--
-- Index pour la table `nodebt_tag`
--
ALTER TABLE `nodebt_tag`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `gid` (`gid`);

--
-- Index pour la table `nodebt_tag_caracterise`
--
ALTER TABLE `nodebt_tag_caracterise`
  ADD PRIMARY KEY (`did`,`tid`),
  ADD KEY `tid` (`tid`);

--
-- Index pour la table `nodebt_utilisateur`
--
ALTER TABLE `nodebt_utilisateur`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `nodebt_versement`
--
ALTER TABLE `nodebt_versement`
  ADD PRIMARY KEY (`verseId`,`recoitId`,`groupId`,`dateHeure`),
  ADD KEY `recoitId` (`recoitId`),
  ADD KEY `groupId` (`groupId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `nodebt_depense`
--
ALTER TABLE `nodebt_depense`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `nodebt_facture`
--
ALTER TABLE `nodebt_facture`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `nodebt_groupe`
--
ALTER TABLE `nodebt_groupe`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `nodebt_tag`
--
ALTER TABLE `nodebt_tag`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `nodebt_utilisateur`
--
ALTER TABLE `nodebt_utilisateur`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `nodebt_depense`
--
ALTER TABLE `nodebt_depense`
  ADD CONSTRAINT `nodebt_depense_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `nodebt_utilisateur` (`uid`),
  ADD CONSTRAINT `nodebt_depense_ibfk_2` FOREIGN KEY (`gid`) REFERENCES `nodebt_groupe` (`gid`);

--
-- Contraintes pour la table `nodebt_facture`
--
ALTER TABLE `nodebt_facture`
  ADD CONSTRAINT `nodebt_facture_ibfk_1` FOREIGN KEY (`did`) REFERENCES `nodebt_depense` (`did`);

--
-- Contraintes pour la table `nodebt_groupe`
--
ALTER TABLE `nodebt_groupe`
  ADD CONSTRAINT `nodebt_groupe_ibfk_1` FOREIGN KEY (`own_uid`) REFERENCES `nodebt_utilisateur` (`uid`);

--
-- Contraintes pour la table `nodebt_participe`
--
ALTER TABLE `nodebt_participe`
  ADD CONSTRAINT `nodebt_participe_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `nodebt_utilisateur` (`uid`),
  ADD CONSTRAINT `nodebt_participe_ibfk_2` FOREIGN KEY (`gid`) REFERENCES `nodebt_groupe` (`gid`);

--
-- Contraintes pour la table `nodebt_tag`
--
ALTER TABLE `nodebt_tag`
  ADD CONSTRAINT `nodebt_tag_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `nodebt_groupe` (`gid`);

--
-- Contraintes pour la table `nodebt_tag_caracterise`
--
ALTER TABLE `nodebt_tag_caracterise`
  ADD CONSTRAINT `nodebt_tag_caracterise_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `nodebt_tag` (`tid`),
  ADD CONSTRAINT `nodebt_tag_caracterise_ibfk_2` FOREIGN KEY (`did`) REFERENCES `nodebt_depense` (`did`);

--
-- Contraintes pour la table `nodebt_versement`
--
ALTER TABLE `nodebt_versement`
  ADD CONSTRAINT `nodebt_versement_ibfk_1` FOREIGN KEY (`verseId`) REFERENCES `nodebt_utilisateur` (`uid`),
  ADD CONSTRAINT `nodebt_versement_ibfk_2` FOREIGN KEY (`recoitId`) REFERENCES `nodebt_utilisateur` (`uid`),
  ADD CONSTRAINT `nodebt_versement_ibfk_3` FOREIGN KEY (`groupId`) REFERENCES `nodebt_groupe` (`gid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
