<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all'))) {
	mosRedirect('index2.php', _NOT_AUTH);
}

require_once (ADMIN_PATH.'core/ville.html.php');

function manageVille($option) {
	global $setup, $config;

	$nom = mosGetParam( $_REQUEST, 'nom');
	$pays = mosGetParam( $_REQUEST, 'pays');
	$boxchecked = mosGetParam( $_REQUEST, 'boxchecked');
	$cid = mosGetParam( $_REQUEST, 'cid');

	if (!empty($nom) && $nom !== "City") {
		$result = db_getVilleId($nom);
		if (!empty($result[0]['id'])) {
			$err = "Error - City Unknown";
			$kom = true;
		} else {
			$id = db_addVille($nom, $pays);
			$_POST['nom'] = '';
			$err = "OK - City added";
			$kom = true;
		}
	} else {
		$err = "Valeurs par défaut";
		$kom = false;
	}
	if ($boxchecked) {
		for ($i=0; $i<$boxchecked; $i++) {
			//echo $i.'DEL ==> '.$_POST['cid'][$i];
			$id = db_delVille($cid[$i]);
			if ($id) {
				$err = "OK - City deleted";
				$kom = true;
			} else {
				$err = "Error - City unknown";
				$kom = false;
			}
		}
	}

	$result = db_getMaxIDVille();
	$aVilleMax = $result[0]['max'];
	for ($aCpt = 1; $aCpt <= $aVilleMax; $aCpt++) {
		$select[$aCpt] = mosGetParam( $_REQUEST, "select_pays_$aCpt");
	}

	for ($aCpt = 1; $aCpt <= $aVilleMax; $aCpt++) {
		//	echo "ville : $aCpt -> $select[$aCpt]";
		if ($select[$aCpt] > 0) {
			db_updVilleForPays($aCpt, $select[$aCpt]);
		}
	}

	displayVille($option, $err, $kom);
}
?>