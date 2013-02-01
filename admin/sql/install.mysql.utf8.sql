create table if not exists '#__places_pays' (
	`id` int(5) unsigned not null auto_increment,
	`nom` varchar(30) not null default '?',
	`drapeau` varchar(50) not null default '?',
	primary key  (`id`),
	unique key  (`nom`)
);

insert into '#__places_pays' ('nom', 'drapeau') VALUES
        ('andorre', 'ad.png'),
        ('arab emirates united', 'ae.png')
;

