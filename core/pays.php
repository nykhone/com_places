<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all'))) {
	mosRedirect('index2.php', _NOT_AUTH);
}

require_once (ADMIN_PATH.'core/pays.html.php');

function managePays($option) {
	global $setup, $config;

	$nom = mosGetParam( $_REQUEST, 'nom');
	$drapeau = mosGetParam( $_REQUEST, 'drapeau');
	$boxchecked = mosGetParam( $_REQUEST, 'boxchecked');
	$cid		= mosGetParam( $_REQUEST, 'cid');

	if (!empty($nom) && $nom !== "Country") {
		$result = db_getPaysId($nom);
		if (!empty($result[0]['id'])) {
			$err = "Erreur - Pays Existant";
			$kom = true;
		} else {
			$id = db_addPays($nom);
			$_POST['nom'] = '';
			$err = "OK - Pays Ajouté";
			$kom = true;
		}
	} else {
		$err = "Valeurs par défaut";
		$kom = false;
	}
	if ($boxchecked) {
		for ($i=0; $i<$boxchecked; $i++) {
			//echo $i.'DEL ==> '.$_POST['cid'][$i];
			$id = db_delPays($cid[$i]);
			if ($id) {
				$err = "OK - Pays éffacé";
				$kom = true;
			} else {
				$err = "Erreur - Pays non éffacé - Inexistant";
				$kom = false;
			}
		}
	}

	$result = db_getMaxIDPays();
	$aPaysMax = $result[0]['max'];
	for ($aCpt = 1; $aCpt <= $aPaysMax; $aCpt++) {
		$select[$aCpt] = mosGetParam( $_REQUEST, "select_drapeau_$aCpt");
	}

	for ($aCpt = 1; $aCpt <= $aPaysMax; $aCpt++) {
		// echo "pays : $aCpt -> $select[$aCpt]";
		if ($select[$aCpt] != '') {
			db_updPaysForDrapeau($aCpt, $select[$aCpt]);
		}
	}

	displayPays($option, $err, $kom);
}
?>