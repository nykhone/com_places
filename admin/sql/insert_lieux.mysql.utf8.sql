SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `joom258_places_lieu` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `nom` varchar(30) collate latin1_spanish_ci NOT NULL default '?',
  `description` varchar(50) collate latin1_spanish_ci NOT NULL default '?',
  `ville` int(5) NOT NULL default '0',
  `section` int(5) NOT NULL default '0',
  `latitude` decimal(8,5) NOT NULL default '0.00000',
  `longitude` decimal(8,5) NOT NULL default '0.00000',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=272 ;

INSERT INTO `joom258_places_lieu` (`id`, `nom`, `description`, `ville`, `section`, `latitude`, `longitude`) VALUES
(1, 'Foyer', '?', 1, 1, 47.31815, 5.04021),
(2, 'Gaumont', '?', 1, 1, 47.32364, 5.03006),
(3, 'Devosges', '?', 1, 1, 47.32720, 5.04226),
(4, 'Darcy', '?', 1, 1, 47.32355, 5.03449),
(5, 'Internat', '?', 1, 1, 47.32323, 5.04744),
(6, 'Gde Taverne', '?', 1, 1, 47.32357, 5.02922),
(7, 'ABC', '?', 1, 1, 0.00000, 0.00000),
(8, 'Olivier Sup', '?', 2, 1, 0.00000, 0.00000),
(9, 'Logos', '?', 3, 1, 0.00000, 0.00000),
(10, 'Maison', '?', 4, 1, 48.88244, 2.19881),
(11, 'Accatone', '?', 3, 1, 0.00000, 0.00000),
(12, 'Ski Hotel', '?', 5, 1, 0.00000, 0.00000),
(13, 'Eldorado', '?', 1, 1, 47.31445, 5.04860),
(14, 'Toto', '?', 6, 1, 45.49536, 5.30903),
(15, 'Morel', '?', 6, 1, 45.49518, 5.30826),
(16, 'Utopia', '?', 3, 1, 0.00000, 0.00000),
(17, 'Franny', '?', 4, 1, 0.00000, 0.00000),
(18, 'Yoyo', '?', 4, 1, 0.00000, 0.00000),
(19, 'Lumieres', '?', 4, 1, 48.89266, 2.19556),
(20, 'Medicis', '?', 3, 1, 0.00000, 0.00000),
(21, 'Papa', '?', 3, 1, 48.83897, 2.26634),
(22, 'Biarritz', '?', 3, 1, 0.00000, 0.00000),
(23, 'Peneyrals', '?', 7, 1, 44.95757, 1.27237),
(24, '?4temps', '?', 8, 1, 0.00000, 0.00000),
(25, 'Maman', '?', 9, 1, 48.77570, -1.56473),
(26, 'Estival', '?', 9, 1, 48.77451, -1.56653),
(27, 'Rive Gauche', '?', 3, 1, 0.00000, 0.00000),
(28, '0', '?', 10, 1, 0.00000, 0.00000),
(29, 'Marielle', '?', 1, 1, 47.32913, 5.06114),
(30, 'Beaubourg', '?', 3, 1, 0.00000, 0.00000),
(31, 'Elys', '?', 3, 1, 0.00000, 0.00000),
(32, 'Gallande', '?', 3, 1, 0.00000, 0.00000),
(33, 'Beauquesne', '?', 1, 1, 47.31316, 5.06203),
(34, 'Karine', '?', 1, 1, 0.00000, 0.00000),
(35, 'Nitche', '?', 11, 1, 43.28098, 5.35173),
(36, 'Gau. Italie', '?', 3, 1, 0.00000, 0.00000),
(37, 'Gau. Montpa.', '?', 3, 1, 0.00000, 0.00000),
(38, 'P G5', '?', 3, 1, 0.00000, 0.00000),
(39, 'Champo', '?', 3, 1, 0.00000, 0.00000),
(40, 'Sandrine', '?', 4, 1, 48.89475, 2.21807),
(41, 'Cite U', '?', 1, 1, 47.31166, 5.07163),
(42, '0', '?', 3, 1, 0.00000, 0.00000),
(43, 'Marignan', '?', 3, 1, 0.00000, 0.00000),
(44, 'Gd Action', '?', 3, 1, 0.00000, 0.00000),
(45, 'Ecoles', '?', 3, 1, 0.00000, 0.00000),
(46, 'Cine Club', '?', 1, 1, 47.31327, 5.06655),
(47, 'Reflet', '?', 3, 1, 0.00000, 0.00000),
(48, 'Publicis', '?', 3, 1, 0.00000, 0.00000),
(49, 'Ht feuille', '?', 3, 1, 0.00000, 0.00000),
(50, 'Christine', '?', 3, 1, 0.00000, 0.00000),
(51, 'Arlequin', '?', 3, 1, 0.00000, 0.00000),
(52, 'Blaise', '?', 12, 1, 0.00000, 0.00000),
(53, 'Eclose', '?', 6, 1, 0.00000, 0.00000),
(54, 'Mantine', '?', 11, 1, 43.28322, 5.35560),
(55, 'Devos', '?', 1, 1, 0.00000, 0.00000),
(56, 'Mediatek U', '?', 1, 1, 47.31296, 5.06589),
(57, 'P GV', '?', 3, 1, 0.00000, 0.00000),
(58, 'Luxemb', '?', 3, 1, 0.00000, 0.00000),
(59, 'St Michel', '?', 3, 1, 0.00000, 0.00000),
(60, 'Epee Bois', '?', 3, 1, 0.00000, 0.00000),
(61, 'Yoanne', '?', 4, 1, 48.89087, 2.20494),
(62, 'Yoanne 2', '?', 4, 1, 48.88402, 2.20567),
(63, 'Cine Hasselt', '?', 13, 1, 0.00000, 0.00000),
(64, 'Lore', '?', 13, 1, 50.86306, 5.36380),
(65, 'Ambass.', '?', 3, 1, 0.00000, 0.00000),
(66, 'Gaumont', '?', 14, 1, 48.11038, -1.68126),
(67, 'CS2', '?', 14, 1, 48.12339, -1.63379),
(68, 'INSA', '?', 14, 1, 48.12037, -1.63541),
(69, 'Normand.', '?', 3, 1, 0.00000, 0.00000),
(70, 'Arm', '?', 15, 1, 47.59337, 1.34209),
(71, 'TNB', '?', 14, 1, 48.10794, -1.67284),
(72, 'Arvor', '?', 14, 1, 48.11598, -1.67912),
(73, 'C?line 2', '?', 14, 1, 0.00000, 0.00000),
(74, 'Colombier', '?', 14, 1, 48.10426, -1.67884),
(75, 'Gilles', '?', 16, 1, 0.00000, 0.00000),
(76, 'Celine 2', '?', 14, 1, 0.00000, 0.00000),
(77, '0', '?', 17, 1, 0.00000, 0.00000),
(78, 'P 14 odeon', '?', 3, 1, 0.00000, 0.00000),
(79, 'P gd action', '?', 3, 1, 0.00000, 0.00000),
(80, 'P danton', '?', 3, 1, 0.00000, 0.00000),
(81, 'P hautef', '?', 3, 1, 0.00000, 0.00000),
(82, 'P logos', '?', 3, 1, 0.00000, 0.00000),
(83, 'P champo', '?', 3, 1, 0.00000, 0.00000),
(84, 'P ursulines', '?', 3, 1, 0.00000, 0.00000),
(85, 'P ecoles', '?', 3, 1, 0.00000, 0.00000),
(86, 'franck', '?', 4, 1, 48.87833, 2.20748),
(87, 'SP select', '?', 18, 1, 0.00000, 0.00000),
(88, 'Boudigau', '?', 19, 1, 0.00000, 106.82944),
(89, 'olivier', '?', 4, 1, 0.00000, 0.00000),
(90, 'Philippe', '?', 4, 1, 0.00000, 0.00000),
(91, 'ediathk', '?', 4, 1, 48.89144, 2.19801),
(92, 'GN', '?', 14, 1, 0.00000, 0.00000),
(93, 'Cesson', '?', 20, 1, 0.00000, 0.00000),
(94, 'Juju', '?', 21, 1, 0.00000, 0.00000),
(95, 'Nanterre', '?', 4, 1, 0.00000, 0.00000),
(96, 'P', '?', 3, 1, 0.00000, 0.00000),
(97, 'Lionel 2', '?', 22, 1, 0.00000, 0.00000),
(98, 'Didier', '?', 4, 1, 48.88209, 2.19813),
(99, 'R?my', '?', 23, 1, 0.00000, 0.00000),
(100, 'Poke', '?', 24, 1, 48.48951, -2.71352),
(101, 'Insee', '?', 25, 1, 48.81076, -3.52427),
(102, 'Rameix', '?', 26, 1, 48.67325, -3.83888),
(103, 'Gilles', '?', 4, 1, 0.00000, 0.00000),
(104, 'BN2', '?', 14, 1, 48.12356, -1.63468),
(105, 'RN', '?', 14, 1, 0.00000, 0.00000),
(106, 'GN', '?', 4, 1, 0.00000, 0.00000),
(107, 'Phillipe', '?', 3, 1, 0.00000, 0.00000),
(108, 'Baladins', '?', 27, 1, 0.00000, 0.00000),
(109, 'Halles', '?', 3, 1, 0.00000, 0.00000),
(110, 'Locomotive', '?', 3, 1, 48.88416, 2.33206),
(111, '0', '?', 4, 1, 0.00000, 0.00000),
(112, 'Remy', '?', 4, 1, 48.87769, 2.20734),
(113, 'Pnormandie', '?', 3, 1, 0.00000, 0.00000),
(114, 'Celine', '?', 14, 1, 0.00000, 0.00000),
(115, 'R Colombier', '?', 14, 1, 0.00000, 0.00000),
(116, 'C?line', '?', 14, 1, 0.00000, 0.00000),
(117, 'Olivier (P)', '?', 4, 1, 48.89150, 2.20493),
(118, '0', '?', 28, 1, 0.00000, 0.00000),
(119, 'Rameix (P)', '?', 4, 1, 48.88826, 2.19911),
(120, 'Ariel', '?', 29, 1, 0.00000, 0.00000),
(121, 'Franny (P)', '?', 4, 1, 48.88171, 2.20042),
(122, 'Les Aunettes', '?', 30, 1, 0.00000, 0.00000),
(123, 'Miramax', '?', 31, 1, 0.00000, 0.00000),
(124, 'Fathia', '?', 32, 1, 0.00000, 0.00000),
(125, '0', '?', 14, 1, 0.00000, 0.00000),
(126, 'Lebi Gwen Bast', '?', 14, 1, 48.11072, -1.66910),
(127, 'St Melaine', '?', 14, 1, 48.11486, -1.67641),
(128, 'Philippe', '?', 17, 1, 0.00000, 0.00000),
(129, 'Poke', '?', 17, 1, 0.00000, 0.00000),
(130, 'Olivier', '?', 17, 1, 0.00000, 0.00000),
(131, 'Eliza', '?', 14, 1, 48.11111, -1.68085),
(132, 'Zytoun', '?', 14, 1, 0.00000, 0.00000),
(133, 'Remy', '?', 17, 1, 0.00000, 0.00000),
(134, 'Vari?t', '?', 11, 1, 43.29744, 5.37980),
(135, 'Gwen', '?', 14, 1, 0.00000, 0.00000),
(136, 'Antrain', '?', 14, 1, 48.11832, -1.67591),
(137, 'Ron', '?', 14, 1, 48.11057, -1.66775),
(138, 'Horizons Gwen Sandrine', '?', 14, 1, 0.00000, 0.00000),
(139, '0', '?', 33, 1, 0.00000, 0.00000),
(140, 'Sam & Lulu', '?', 14, 1, 0.00000, 0.00000),
(142, 'Lulu', '?', 14, 1, 48.11412, -1.68142),
(143, 'Nyko', '?', 14, 1, 0.00000, 0.00000),
(144, '0', '?', 34, 1, 0.00000, 0.00000),
(145, 'Marie', '?', 35, 1, 0.00000, 0.00000),
(146, 'Pierrot', '?', 36, 1, 0.00000, 0.00000),
(147, 'Bastoun', '?', 37, 1, 0.00000, 0.00000),
(148, 'Loki', '?', 14, 1, 48.10062, -1.65857),
(149, 'Corentin', '?', 14, 1, 48.11217, -1.66571),
(150, 'Greg', '?', 38, 1, 0.00000, 0.00000),
(151, 'Thai Airways', '?', 39, 1, 0.00000, 0.00000),
(152, 'CCF', '?', 40, 1, 13.35263, 103.85683),
(153, 'Mylène', '?', 3, 1, 48.88903, 2.34634),
(154, 'Gael', '?', 4, 1, 0.00000, 0.00000),
(155, 'Pierre', '?', 41, 1, 0.00000, 0.00000),
(156, 'Nyko', '?', 9, 1, 0.00000, 0.00000),
(157, 'Pierre', '?', 14, 1, 0.00000, 0.00000),
(158, 'Nyko - Gwen', '?', 14, 1, 0.00000, 0.00000),
(159, 'Elizatoun', '?', 14, 1, 0.00000, 0.00000),
(160, 'Méga CGR', '?', 42, 1, 0.00000, 0.00000),
(161, 'Thai Airways', '?', 43, 1, 0.00000, 0.00000),
(162, 'Vidano', '?', 40, 1, 0.00000, 0.00000),
(163, 'Pierre', '?', 40, 1, 13.36840, 103.86370),
(164, 'Christine', '?', 40, 1, 13.35457, 103.86307),
(165, '0', '?', 44, 1, 0.00000, 0.00000),
(166, 'Suami Resort', '?', 45, 1, 0.00000, 0.00000),
(167, 'Neak Spean', '?', 40, 1, 13.37564, 103.86769),
(168, 'Rata Beach', '?', 46, 1, 0.00000, 0.00000),
(169, '0', '?', 47, 1, 7.58202, 99.03213),
(170, 'Micka', '?', 4, 1, 0.00000, 0.00000),
(171, 'Franny', '?', 48, 1, 0.00000, 0.00000),
(172, 'Nanou', '?', 49, 1, 0.00000, 0.00000),
(173, 'Ana', '?', 40, 1, 13.34913, 103.85888),
(174, 'Meridien', '?', 50, 1, 1.30049, 103.84206),
(175, 'Liza', '?', 44, 1, 11.55439, 104.93114),
(176, 'Tuol Sleng', '?', 44, 1, 0.00000, 0.00000),
(177, 'Capitol', '?', 51, 1, 0.00000, 0.00000),
(178, 'Stade', '?', 40, 1, 13.36885, 103.85949),
(179, 'La Villette', '?', 3, 1, 0.00000, 0.00000),
(180, 'Lorraine', '?', 3, 1, 48.87661, 2.34719),
(181, 'Bastoun', '?', 52, 1, 0.00000, 0.00000),
(182, 'Lotus GH', '?', 53, 1, 0.00000, 0.00000),
(183, 'Queen GH', '?', 54, 1, 0.00000, 0.00000),
(184, 'Yhuong', '?', 55, 1, 0.00000, 0.00000),
(185, '0', '?', 56, 1, 0.00000, 0.00000),
(186, 'Nam Viet', '?', 57, 1, 0.00000, 0.00000),
(187, 'Stef Loic', '?', 40, 1, 13.37330, 103.86282),
(188, 'Le Tigre', '?', 40, 1, 13.35479, 103.85474),
(189, 'Cathay Pacific', '?', 58, 1, 0.00000, 0.00000),
(190, 'Vin Bbr', '?', 59, 1, -36.76261, 174.72693),
(191, 'Village', '?', 59, 1, -36.85156, 174.76344),
(192, 'Flaming Kiwi', '?', 60, 1, 0.00000, 0.00000),
(193, 'Resort Lodge', '?', 60, 1, 0.00000, 0.00000),
(194, 'Glow Worm', '?', 61, 1, -43.38820, 170.18268),
(195, 'Cathay Pacific', '?', 62, 1, 0.00000, 0.00000),
(196, 'Tri', '?', 63, 1, 0.00000, 0.00000),
(197, 'Bato', '?', 64, 1, 0.00000, 0.00000),
(198, 'Ban Lung I', '?', 65, 1, 0.00000, 0.00000),
(199, 'GTS', '?', 66, 1, 0.00000, 0.00000),
(200, 'Anna', '?', 67, 1, 0.00000, 0.00000),
(201, 'Gaumont', '?', 67, 1, 0.00000, 0.00000),
(202, '14A', '?', 67, 1, 0.00000, 0.00000),
(203, 'Anna', '?', 68, 1, 48.39643, -4.52021),
(204, 'Abchejitie', '?', 69, 1, 59.92571, 30.34740),
(205, 'Avrora', '?', 69, 1, 59.93479, 30.33290),
(206, 'Momo', '?', 70, 1, 0.00000, 0.00000),
(208, 'Lisa', '?', 67, 1, 0.00000, 0.00000),
(209, 'TNB - La Parcheminerie', '?', 14, 1, 48.10909, -1.68107),
(210, 'Prado', '?', 11, 1, 0.00000, 0.00000),
(211, 'Quantas', '?', 71, 1, 0.00000, 0.00000),
(212, 'Red Lodge', '?', 40, 1, 13.35415, 103.85117),
(213, 'Mekong Express', '?', 72, 1, 0.00000, 0.00000),
(214, 'CCF', '?', 44, 1, 11.56229, 104.92071),
(215, 'Hour Leam', '?', 73, 1, 0.00000, 0.00000),
(216, 'Royal Hotel', '?', 74, 1, 13.10253, 103.19722),
(217, 'Air India', '?', 75, 1, 0.00000, 0.00000),
(218, 'Stefany', '?', 76, 1, 0.00000, 0.00000),
(219, 'Erictreb', '?', 76, 1, 0.00000, 0.00000),
(220, 'Xinzha Lu', '?', 76, 1, 31.23748, 121.45643),
(221, '?Bus china', '?', 77, 1, 0.00000, 0.00000),
(222, 'Guillome', '?', 76, 1, 0.00000, 0.00000),
(223, 'Marine', '?', 76, 1, 0.00000, 0.00000),
(224, 'Air India', '?', 78, 1, 0.00000, 0.00000),
(225, 'British Airways', '?', 79, 1, 0.00000, 0.00000),
(226, 'PY', '?', 80, 1, 0.00000, 0.00000),
(227, 'Remy Cat', '?', 4, 1, 48.88513, 2.22070),
(228, 'Dzei Ester', '?', 4, 1, 48.88913, 2.19112),
(229, 'FX', '?', 81, 1, 0.00000, 0.00000),
(230, 'British Airways', '?', 82, 1, 0.00000, 0.00000),
(231, 'Karine', '?', 50, 1, 1.31268, 103.80587),
(232, 'GST', '?', 66, 1, 0.00000, 0.00000),
(233, 'Neak Meas', '?', 83, 1, 13.58784, 102.96867),
(234, 'JPM', '?', 40, 1, 13.36690, 103.86399),
(235, 'Silk Garden', '?', 40, 1, 13.35541, 103.85455),
(236, 'Antoine', '?', 40, 1, 13.34956, 103.85851),
(237, '?', '?', 84, 1, 0.00000, 0.00000),
(238, 'Rith Mony', '?', 66, 1, 0.00000, 0.00000),
(239, 'Charlotte', '?', 50, 1, 1.32468, 103.84119),
(240, 'Cathay', '?', 50, 1, 1.29940, 103.84775),
(241, 'Elizabeth', '?', 50, 1, 1.30640, 103.83622),
(242, 'Cipta 2', '?', 85, 1, -6.17444, 106.82944),
(243, 'JM', '?', 44, 1, 11.54905, 104.91891),
(244, 'Shaw Lido', '?', 50, 1, 1.30580, 103.83151),
(245, 'Hakara', '?', 44, 1, 11.54284, 104.91689),
(246, 'Celine', '?', 44, 1, 11.55474, 104.92147),
(247, 'PictureHouse', '?', 50, 1, 0.00000, 0.00000),
(248, 'VG Plaza', '?', 50, 1, 1.30090, 103.84498),
(249, 'Ya Ya GH', '?', 86, 1, 8.00908, 98.84073),
(250, 'Changi', '?', 50, 1, 1.35362, 103.98896),
(251, 'Avion', '?', 87, 1, 0.00000, 0.00000),
(252, 'Astrid', '?', 88, 1, 48.43992, 1.47706),
(253, 'Caro & Fred', '?', 11, 1, 0.00000, 0.00000),
(254, 'Alsa', '?', 89, 1, 0.00000, 0.00000),
(255, 'Sandra', '?', 90, 1, 0.00000, 0.00000),
(256, 'Alsa', '?', 91, 1, 0.00000, 0.00000),
(257, 'Alsa', '?', 92, 1, 0.00000, 0.00000),
(258, 'LN & Momo', '?', 70, 1, 44.71135, 0.99922),
(259, 'Quatar Airrlines', '?', 93, 1, 0.00000, 0.00000),
(260, 'Quatar Airrlines', '?', 94, 1, 0.00000, 0.00000),
(261, 'Beach Road', '?', 50, 1, 1.29975, 103.86058),
(262, 'Picture House', '?', 50, 1, 1.29940, 103.84778),
(263, 'GV Singapura', '?', 50, 1, 0.00000, 0.00000),
(264, 'Pierre BA 2', '?', 63, 1, 0.00000, 0.00000),
(265, 'GH Siem', '?', 40, 1, 0.00000, 0.00000),
(266, 'Capitol', '?', 72, 1, 0.00000, 0.00000),
(267, 'Suria', '?', 44, 1, 11.55006, 104.91767),
(268, 'Devonshire', '?', 50, 1, 1.29812, 103.83749),
(271, 'Horizons Gwen & Sandrine', '?', 14, 1, 0.00000, 0.00000);
