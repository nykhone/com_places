create table if not exists `#__places_lieu` (
	`id` int(5) unsigned not null auto_increment,
	`nom` varchar(30) not null default '?',
	`description` varchar(50) not null default '?',
	`ville` int(5) not null default '0',
	`section` int(5) not null default '0',
	`latitude` varchar(10) not null default '?',
	`longitude` varchar(10) not null default '?',
	primary key  (`id`)
);

create table if not exists `#__places_ville` (
	`id` int(5) unsigned not null auto_increment,
	`nom` varchar(30) not null default '?',
	`pays` int(5) not null default '0',
	primary key  (`id`)
);

create table if not exists `#__places_pays` (
	`id` int(5) unsigned not null auto_increment,
	`nom` varchar(30) not null default '?',
	`drapeau` varchar(50) not null default '?',
	primary key  (`id`),
	unique key  (`nom`)
);

create table if not exists `#__places_section` (
	`id` int(5) unsigned not null auto_increment,
	`title` varchar(30) not null default '?',
	`name` varchar(50) not null default '?',
	`linkfield` varchar(50) not null default '?',
	`params` varchar(50) not null default '?',
	primary key  (`id`),
	unique key  (`title`)
);

create table if not exists `#__places_config` (
	`id` TINYINT(4) NOT NULL ,
	`mapWidth` varchar(10) NOT NULL,
	`mapHeight` varchar(10) NOT NULL,
	`mapBorder` TEXT,
	`zoomLevel` TINYINT(1) NOT NULL,
	`APIKey` varchar(100) NOT NULL,
	`title` TEXT NOT NULL,
	`misc` TEXT,
	`centerId` INT,
	`centerLat` varchar(10),
	`centerLng` varchar(10),
	`autoOpen` TINYINT(1) NOT NULL,
	`showScale` TINYINT(1) NOT NULL,
	`showZoom` TINYINT(1) NOT NULL,
	`whichZoom` TINYINT(1) NOT NULL,
	`showType` TINYINT(1) NOT NULL,
	`whichType` TINYINT(1) NOT NULL,
	`pdMarkers` text,
	`geocode` TINYINT(1) NOT NULL,
	PRIMARY KEY(`id`)
)
