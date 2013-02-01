<?php
/**
* Places
**/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

// ----------------------------------------------------------
// --> requetes sur la base PAYS
// ----------------------------------------------------------
function db_getPays() {
	return RunSql('select id, nom, drapeau from jos_places_pays order by nom');
}

function db_getPaysId($theNom) {
    return RunSql("select id from jos_places_pays where lcase(nom) = lcase('$theNom')");
}

function db_getPaysNom($theID) {
    return RunSql("select nom from jos_places_pays where id = $theID");
}

function db_getPaysDrapeau($theID) {
    return RunSql("select drapeau from jos_places_pays where id = $theID");
}

function db_addPays($theNom) {
	return RunSql("insert into jos_places_pays (nom) values ('$theNom')");
}

function db_updPaysForDrapeau($theID, $theDrapeau) {
	return RunSql("update jos_places_pays set drapeau = '$theDrapeau' where id = $theID");
}

function db_delPays($id) {
	return RunSql("delete from jos_places_pays where id = $id");
}

function db_getCountPays() {
	return RunSql("select count(id) as count from jos_places_pays");
}

function db_getMaxIDPays() {
	return RunSql("select max(id) as max from jos_places_pays");
}

// ----------------------------------------------------------
// --> requetes sur la base LIEU
// ----------------------------------------------------------
function db_getLieu() {
	return RunSql('select * from jos_places_lieu order by nom asc');
}

function db_getLieuOrdered() {
	return RunSql('select l.*, v.nom as vnom from jos_places_lieu as l, jos_places_ville as v where l.ville = v.id order by v.nom asc, l.nom asc');
}

function db_getLieuId($theNom, $theVilleID) {
    return RunSql("select id from jos_places_lieu where nom = '$theNom' and ville = $theVilleID");
}

function db_getLieuNom($theID) {
    return RunSql("select nom from jos_places_lieu where id = $theID");
}

function db_updLieuForSeance($theID, $theSeanceID) {
	return RunSql("update jos_places_lieu set section = $theSeanceID where id = $theID");
}

function db_updLieuForLatitude($theID, $theLatitude) {
	return RunSql("update jos_places_lieu set latitude = $theLatitude where id = $theID");
}

function db_updLieuForLongitude($theID, $theLongitude) {
	return RunSql("update jos_places_lieu set longitude = $theLongitude where id = $theID");
}

function db_updLieuForDescription($theID, $theDescription) {
	return RunSql("update jos_places_lieu set description = '$theDescription' where id = $theID");
}

function db_addLieu($theNom, $theVilleID) {
	return RunSql("insert into jos_places_lieu (nom, ville) values ('$theNom',$theVilleID)");
}

function db_delLieu($id) {
	return RunSql("delete from jos_places_lieu where id = $id");
}

function db_getMaxIDLieu() {
	return RunSql("select max(id) as max from jos_places_lieu");
}

function db_getCountLieu() {
	return RunSql("select count(id) as count from jos_places_lieu");
}

function db_getCountLieuForVille($theVilleID) {
	return RunSql("select count(id) as count from jos_places_lieu where ville = '$theVilleID'");
}

// ----------------------------------------------------------
// --> requetes sur la base VILLE
// ----------------------------------------------------------
function db_getVille() {
	return RunSql('select id, nom, pays from jos_places_ville order by nom');
}

function db_getVilleId($theNom) {
    return RunSql("select id from jos_places_ville where nom = '$theNom'");
}

function db_getVilleNom($theID) {
    return RunSql("select nom from jos_places_ville where id = $theID");
}

function db_updVilleForPays($theID, $thePaysID) {
	return RunSql("update jos_places_ville set pays = $thePaysID where id = $theID");
}

function db_addVille($theNom, $thePaysID) {
	return RunSql("insert into jos_places_ville (nom, pays) values ('$theNom',$thePaysID)");
}

function db_delVille($id) {
	return RunSql("delete from jos_places_ville where id = $id");
}

function db_getCountVille() {
	return RunSql("select count(id) as count from jos_places_ville");
}

function db_getMaxIDVille() {
	return RunSql("select max(id) as max from jos_places_ville");
}

function db_getCountVilleForPays($thePaysID) {
	return RunSql("select count(id) as count from jos_places_ville where pays = '$thePaysID'");
}

// ----------------------------------------------------------
// --> requetes sur la base SECTION
// ----------------------------------------------------------
function db_getSectionName($theID) {
    return RunSql("select title from jos_places_section where id = $theID");
}

function db_getSectionLink($theID) {
    return RunSql("select linkfield, linktable from jos_places_section where id = $theID");
}

// ----------------------------------------------------------
// --> requetes sur la base CONFIG
// ----------------------------------------------------------
function db_getConfig() {
    return RunSql2("select * from jos_places_config where id = 1");
}


/**
 * SQL function
 * Wrapper for all Database accesses
 *
 * @param  string $sql_string The SQL-Statement to execute
 * @return mixed  either the resultset as an array with hashes or the insertid
 */
function RunSql($sql_string) {
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
	//echo '<br />RunSql='.$sql_string.' result='.$result.'<br />';

	if ($config['debug']) {
		$timestamp = getmicrotime() - $timestamp;
		echo "\n\n<!-- time: $timestamp -->\n\n";
	}
	return $result;
}

/**
 * SQL function
 * Wrapper for all Database accesses
 *
 * @param  string $sql_string The SQL-Statement to execute
 * @return mixed  either the resultset as an array with hashes or the insertid
 */
function RunSql2($sql_string) {
	global $config, $database;

	$instr = explode(' ',trim($sql_string));
	$com = strtoupper($instr[0]);
	if ($config['debug']) {
		echo "\n\n<!-- $sql_string -->\n\n";
		$timestamp = getmicrotime();
	}

	$database->setQuery($sql_string);
	if (DEBUG==1) {	echo $sql_string.'<br />'; }

	$result = $database->loadObjectList();

	if ($database->getErrorNum()) echo $database->getErrorMsg();
	//echo '<br />RunSql='.$sql_string.' result='.$result.'<br />';

	if ($config['debug']) {
		$timestamp = getmicrotime() - $timestamp;
		echo "\n\n<!-- time: $timestamp -->\n\n";
	}
	return $result;
}