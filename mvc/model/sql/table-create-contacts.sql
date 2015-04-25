-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 25 Avril 2015 à 22:43
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `haiku`
--

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
`id` bigint(20) NOT NULL,
  `email` text NOT NULL,
  `name` text NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `ip` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `contacts`
--

INSERT INTO `contacts` (`id`, `email`, `name`, `message`, `date`, `ip`) VALUES
(2, 'test1@gmail.com', 'TEST1', 'HELLO', '2015-04-22 00:00:00', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
