SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `joom258_places_pays` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `nom` varchar(30) collate latin1_spanish_ci NOT NULL default '?',
  `drapeau` varchar(50) collate latin1_spanish_ci NOT NULL default '?',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

INSERT INTO `joom258_places_pays` (`id`, `nom`, `drapeau`) VALUES
(1, 'france', 'fr.png'),
(2, 'entre 2', 'e2.png'),
(3, 'nouvelle zelande', 'nz.png'),
(4, 'cambodge', 'kh.png'),
(5, 'thailande', 'th.png'),
(6, 'belgique', 'be.png'),
(7, 'chine', 'cn.png'),
(8, 'vietnam', 'vn.png'),
(9, 'indonesie', 'id.png'),
(10, 'espagne', 'es.png'),
(11, 'russie', 'ru.png'),
(12, 'singapour', 'sg.png'),
(13, 'finlande', 'fi.png'),
(14, 'allemagne', 'de.png'),
(15, 'hong kong', 'hk.png'),
(16, 'italie', 'it.png'),
(17, 'japon', 'jp.png'),
(18, 'malaysie', 'my.png'),
(19, 'philippines', 'ph.png');