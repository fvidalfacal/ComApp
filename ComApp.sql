-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 11 Mars 2015 à 13:55
-- Version du serveur :  5.5.40-0ubuntu0.14.04.1
-- Version de PHP :  5.5.9-1ubuntu4.5

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
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `readOnly` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `private`, `readOnly`) VALUES
(1, 'Twitter', 0, 0),
(2, 'Hashtag', 0, 0),
(3, 'PPE', 0, 0),
(4, 'ComApp', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(10) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `idUser` int(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`id`, `content`, `date`, `idUser`) VALUES
(1, 'J''aime beaucoup #twitter, c''est ma passion.', '2014-12-03 00:00:00', 1),
(2, 'Le #hashtag , un hashtag plutôt ennuyant à prononcer.', '2014-12-01 00:00:00', 1),
(3, '#twitter blblbl', '2014-12-10 00:00:00', 1),
(4, '#twitter est cool', '2014-12-02 00:00:00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `messagesGroup`
--

CREATE TABLE IF NOT EXISTS `messagesGroup` (
  `idMessage` int(10) NOT NULL,
  `idGroup` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `messagesGroup`
--

INSERT INTO `messagesGroup` (`idMessage`, `idGroup`) VALUES
(1, 1),
(3, 1),
(4, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `firstName` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `firstName`) VALUES
(1, 'jeanjacques@comapp.fr', 'dbaa30de22b1129ec140a188fc3c06a6af8e9f1f', 'Jacques', 'Jean'),
(2, 'guymarrant@comapp.fr', 'dbaa30de22b1129ec140a188fc3c06a6af8e9f1f', 'Marrant', 'Guy');

-- --------------------------------------------------------

--
-- Structure de la table `usersGroup`
--

CREATE TABLE IF NOT EXISTS `usersGroup` (
  `idUser` int(5) NOT NULL,
  `idGroup` int(5) NOT NULL,
  `emailNotification` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `usersGroup`
--

INSERT INTO `usersGroup` (`idUser`, `idGroup`, `emailNotification`) VALUES
(1, 1, 0),
(1, 2, 0),
(1, 3, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`), ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `messagesGroup`
--
ALTER TABLE `messagesGroup`
 ADD PRIMARY KEY (`idMessage`,`idGroup`), ADD KEY `pk_messagesgroups_groups` (`idGroup`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `usersGroup`
--
ALTER TABLE `usersGroup`
 ADD PRIMARY KEY (`idUser`,`idGroup`), ADD KEY `pk_usergroup_groups` (`idGroup`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
ADD CONSTRAINT `pk_messages_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messagesGroup`
--
ALTER TABLE `messagesGroup`
ADD CONSTRAINT `pk_messagesgroups_groups` FOREIGN KEY (`idGroup`) REFERENCES `groups` (`id`),
ADD CONSTRAINT `pk_messagesgroup_messages` FOREIGN KEY (`idMessage`) REFERENCES `messages` (`id`);

--
-- Contraintes pour la table `usersGroup`
--
ALTER TABLE `usersGroup`
ADD CONSTRAINT `pk_usergroup_groups` FOREIGN KEY (`idGroup`) REFERENCES `groups` (`id`),
ADD CONSTRAINT `pk_usergroup_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
