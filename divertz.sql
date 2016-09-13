-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 26 Juillet 2015 à 16:36
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `divertz`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`ID` int(2) NOT NULL,
  `theme` varchar(30) NOT NULL,
  `theme_en` varchar(30) NOT NULL,
  `description` varchar(250) NOT NULL,
  `description_en` varchar(250) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `keyword_en` varchar(100) NOT NULL,
  `ID_data` int(2) NOT NULL DEFAULT '3'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE IF NOT EXISTS `compteur` (
  `ID_compteur` int(9) NOT NULL,
  `vt_pos` int(4) NOT NULL DEFAULT '1',
  `vt_neg` int(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compteur`
--

INSERT INTO `compteur` (`ID_compteur`, `vt_pos`, `vt_neg`) VALUES
(573177281, 4, 0),
(35855872, 1, 1),
(133574787, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `descriptions`
--

CREATE TABLE IF NOT EXISTS `descriptions` (
`ID` int(9) NOT NULL,
  `ID_element` int(9) NOT NULL,
  `tube` int(2) NOT NULL DEFAULT '1',
  `ID_data` int(2) NOT NULL DEFAULT '1',
  `ID_categorie` int(2) NOT NULL,
  `duree` varchar(300) NOT NULL,
  `largeur` varchar(3) NOT NULL DEFAULT '650',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titre` varchar(150) NOT NULL DEFAULT 'n/a',
  `description` varchar(3000) NOT NULL DEFAULT 'n/a',
  `keyword` varchar(200) NOT NULL DEFAULT 'n/a'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `descriptions`
--

INSERT INTO `descriptions` (`ID`, `ID_element`, `tube`, `ID_data`, `ID_categorie`, `duree`, `largeur`, `date`, `titre`, `description`, `keyword`) VALUES
(2, 573177281, 1, 1, 1, '09:55', '650', '2015-03-31 08:52:37', 'Chevrolet Camaro SS', 'For the best video experience, we recommend wearing a good set of headphones for the POV Test Drive at 3:11. The audio in this video was recorded with binaural microphones that, when played back through headphones, give the feel of 3D sound.', 'camaro,car'),
(1, 35855872, 1, 1, 4, '04:55', '650', '2015-03-31 11:12:45', 'Incroyable improbables amitiÃ©s', 'amitiÃ©s improbables | improbables amitiÃ©s animaux | amis les animaux | amitiÃ© animale entre les diffÃ©rentes espÃ¨ces | amitiÃ©s animaux | ', 'chien,cerf,nature'),
(3, 133574787, 1, 1, 5, '06:55', '650', '2015-03-31 11:13:18', 'JE BRULE DE RAGE', '3 jeux 1 attaque de dragon 1 possession', 'jeux,drole,ado');

-- --------------------------------------------------------

--
-- Structure de la table `lien`
--

CREATE TABLE IF NOT EXISTS `lien` (
  `ID_lien` int(9) NOT NULL,
  `lk_fichier` varchar(300) NOT NULL DEFAULT 'n/a',
  `lk_fichier_fr` varchar(300) NOT NULL DEFAULT 'n/a',
  `embed_video` varchar(5000) NOT NULL,
  `lk_image` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lien`
--

INSERT INTO `lien` (`ID_lien`, `lk_fichier`, `lk_fichier_fr`, `embed_video`, `lk_image`) VALUES
(573177281, 'http://localhost/divertiz/video/autos/chevrolet-camaro-ss-573177281.php', 'n/a', '<iframe width="640" height="360" src="https://www.youtube.com/embed/_rLRT0f80x4" frameborder="0" allowfullscreen></iframe>', 'http://localhost/divertiz/video/upload/chevrolet-camaro-ss-573177281.jpg'),
(35855872, 'http://localhost/divertiz/video/animaux/incroyable-improbables-amitia-s-035855872.php', 'n/a', '<iframe width="640" height="360" src="https://www.youtube.com/embed/yM5eL4oZrcw" frameborder="0" allowfullscreen></iframe>', 'http://localhost/divertiz/video/upload/incroyable-improbables-amitia-s-035855872.jpg'),
(133574787, 'http://localhost/divertiz/video/droles/je-brule-de-rage-133574787.php', 'n/a', '<iframe width="640" height="360" src="https://www.youtube.com/embed/u_3nsMgZhnk" frameborder="0" allowfullscreen></iframe>', 'http://localhost/divertiz/video/upload/je-brule-de-rage-133574787.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `statistiques`
--

CREATE TABLE IF NOT EXISTS `statistiques` (
  `id_stat` int(9) NOT NULL,
  `nb_vue` int(9) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `statistiques`
--

INSERT INTO `statistiques` (`id_stat`, `nb_vue`) VALUES
(573177281, 24),
(35855872, 8),
(133574787, 5);

-- --------------------------------------------------------

--
-- Structure de la table `vote_ip`
--

CREATE TABLE IF NOT EXISTS `vote_ip` (
  `ID_ip` varchar(20) NOT NULL,
  `ID_vote` int(9) NOT NULL,
  `date_vote` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vote_ip`
--

INSERT INTO `vote_ip` (`ID_ip`, `ID_vote`, `date_vote`) VALUES
('127.0.0.1', 573177281, '2015-03-31 10:24:37'),
('127.0.0.1', 35855872, '2015-03-31 10:48:14');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `compteur`
--
ALTER TABLE `compteur`
 ADD UNIQUE KEY `ID_compteur` (`ID_compteur`);

--
-- Index pour la table `descriptions`
--
ALTER TABLE `descriptions`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `ID_element` (`ID_element`);

--
-- Index pour la table `lien`
--
ALTER TABLE `lien`
 ADD UNIQUE KEY `ID_lien` (`ID_lien`);

--
-- Index pour la table `statistiques`
--
ALTER TABLE `statistiques`
 ADD UNIQUE KEY `id_stat` (`id_stat`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `descriptions`
--
ALTER TABLE `descriptions`
MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
