-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 12 Novembre 2014 à 17:18
-- Version du serveur :  5.5.38-0ubuntu0.14.04.1
-- Version de PHP :  5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ComApp`
--

-- --------------------------------------------------------

--
-- Structure de la table `Groups`
--

CREATE TABLE IF NOT EXISTS `Groups` (
`id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `readOnly` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Groups`
--

INSERT INTO `Groups` (`id`, `name`, `private`, `readOnly`) VALUES
(1, 'Twitter', 0, 0),
(2, 'Hashtag', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
`id` int(10) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `idUser` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MessagesGroup`
--

CREATE TABLE IF NOT EXISTS `MessagesGroup` (
  `idMessage` int(10) NOT NULL,
  `idGroup` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
`id` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Users`
--

INSERT INTO `Users` (`id`, `email`, `password`, `name`, `firstName`) VALUES
(1, 'jeanjacques@comapp.fr', 'dbaa30de22b1129ec140a188fc3c06a6af8e9f1f', 'Jacques', 'Jean'),
(2, 'guymarrant@comapp.fr', 'dbaa30de22b1129ec140a188fc3c06a6af8e9f1f', 'Marrant', 'Guy');

-- --------------------------------------------------------

--
-- Structure de la table `UsersGroup`
--

CREATE TABLE IF NOT EXISTS `UsersGroup` (
  `idUser` int(5) NOT NULL,
  `idGroup` int(5) NOT NULL,
  `emailNotification` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Groups`
--
ALTER TABLE `Groups`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Messages`
--
ALTER TABLE `Messages`
 ADD PRIMARY KEY (`id`), ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `MessagesGroup`
--
ALTER TABLE `MessagesGroup`
 ADD PRIMARY KEY (`idMessage`,`idGroup`), ADD KEY `pk_messagesgroups_groups` (`idGroup`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `UsersGroup`
--
ALTER TABLE `UsersGroup`
 ADD PRIMARY KEY (`idUser`,`idGroup`), ADD KEY `pk_usergroup_groups` (`idGroup`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Groups`
--
ALTER TABLE `Groups`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Messages`
--
ALTER TABLE `Messages`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Users`
--
ALTER TABLE `Users`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Messages`
--
ALTER TABLE `Messages`
ADD CONSTRAINT `pk_messages_users` FOREIGN KEY (`idUser`) REFERENCES `Users` (`id`);

--
-- Contraintes pour la table `MessagesGroup`
--
ALTER TABLE `MessagesGroup`
ADD CONSTRAINT `pk_messagesgroups_groups` FOREIGN KEY (`idGroup`) REFERENCES `Groups` (`id`),
ADD CONSTRAINT `pk_messagesgroup_messages` FOREIGN KEY (`idMessage`) REFERENCES `Messages` (`id`);

--
-- Contraintes pour la table `UsersGroup`
--
ALTER TABLE `UsersGroup`
ADD CONSTRAINT `pk_usergroup_groups` FOREIGN KEY (`idGroup`) REFERENCES `Groups` (`id`),
ADD CONSTRAINT `pk_usergroup_users` FOREIGN KEY (`idUser`) REFERENCES `Users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
