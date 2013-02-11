SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `joom258_places_section` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `title` varchar(30) collate latin1_spanish_ci NOT NULL default '?',
  `name` varchar(50) collate latin1_spanish_ci NOT NULL default '?',
  `linkfield` varchar(50) collate latin1_spanish_ci NOT NULL default '?',
  `linktable` varchar(50) collate latin1_spanish_ci NOT NULL default '?',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `joom258_places_section` (`id`, `title`, `name`, `linkfield`, `linktable`) VALUES
(1, 'movie stats', 'lieux de visionnage', 'lieu', 'joom258_moviestats_seance');
