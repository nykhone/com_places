SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `joom258_places_pays` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL DEFAULT '?',
  `drapeau` varchar(50) NOT NULL DEFAULT '?',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

INSERT INTO `joom258_places_pays` (`id`, `nom`, `drapeau`) VALUES
(4, 'belgique', 'be.png'),
(5, 'chine', 'cn.png'),
(6, 'allemagne', 'de.png'),
(7, 'espagne', 'es.png'),
(8, 'finlande', 'fi.png'),
(9, 'france', 'fr.png'),
(10, 'hong kong', 'hk.png'),
(11, 'indonesie', 'id.png'),
(12, 'italie', 'it.png'),
(13, 'japon', 'jp.png'),
(14, 'cambodge', 'kh.png'),
(15, 'malaysie', 'my.png'),
(16, 'nouvelle zelande', 'nz.png'),
(17, 'philippines', 'ph.png'),
(18, 'russie', 'ru.png'),
(19, 'singapour', 'sg.png'),
(20, 'thailande', 'th.png'),
(21, 'vietnam', 'vn.png');

