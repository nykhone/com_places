<?php
// -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
// Places, MovieStats et tous les composants qui accedent a la base primaire de cinema
// -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

// ----------------------------------------------------------
// --> requetes sur la base original SEANCE
// ----------------------------------------------------------
function db_getOriginalSeance() {
	return DoSql('select * from seance order by Id asc');
}

function db_getCountOriginalSeance() {
	return DoSql("select count(*) as count from seance");
}

// ----------------------------------------------------------
// --> requetes sur la base original FILM
// ----------------------------------------------------------
function db_getOriginalFilmTitre($theImdb) {
    return DoSql("select Titre from film where Imdb = '$theImdb'");
}


// ----------------------------------------------------------
function DoSql($sql_string) {
	global $config, $database;

	$instr = explode(' ',trim($sql_string));
	$com = strtoupper($instr[0]);
	if ($config['debug']) {
		echo "\n\n<!-- $sql_string -->\n\n";
		$timestamp = getmicrotime();
	}

	$database->setQuery($sql_string);
	if (DEBUG==1) {	echo $sql_string.'<br />'; }
	if ($com == "INSERT" || $com == "DELETE" || $com == "UPDATE" || $com == "REPLACE") {
		$result = $database->query();
//		if ($database->getErrorNum()) $result = $database->getErrorMsg();
		if ($database->getErrorNum()) echo $database->getErrorMsg();
//		if ($com === "INSERT" or $com === "REPLACE") $result = mysql_insert_id();
	} else {
		$result = $database->loadAssocList();
		if ($database->getErrorNum()) echo $database->getErrorMsg();
	}
	//echo '<br />DoSql='.$sql_string.' result='.$result.'<br />';

	if ($config['debug']) {
		$timestamp = getmicrotime() - $timestamp;
		echo "\n\n<!-- time: $timestamp -->\n\n";
	}
	return $result;
}