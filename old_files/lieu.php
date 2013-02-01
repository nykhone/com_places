<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all'))) {
	mosRedirect('index2.php', _NOT_AUTH);
}

require_once (ADMIN_PATH.'core/lieu.html.php');

function manageLieu($option) {
	global $setup, $config;

	$nom = mosGetParam( $_REQUEST, 'nom');
	$pays = mosGetParam( $_REQUEST, 'pays');
	$boxchecked = mosGetParam( $_REQUEST, 'boxchecked');
	$cid = mosGetParam( $_REQUEST, 'cid');

	if ($boxchecked) {
		for ($i=0; $i<$boxchecked; $i++) {
			//echo $i.'DEL ==> '.$_POST['cid'][$i];
			$id = db_delLieu($cid[$i]);
			if ($id) {
				$err = "OK - Place deleted";
				$kom = true;
			} else {
				$err = "Error - Place unknown";
				$kom = false;
			}
		}
	}

	$result = db_getMaxIDLieu();
	$aLieuMax = $result[0]['max'];
	for ($aCpt = 1; $aCpt <= $aLieuMax; $aCpt++) {
		$aSelectSection[$aCpt] = mosGetParam($_REQUEST, "select_section_$aCpt");
		$aInputLat[$aCpt] = mosGetParam($_REQUEST, "input_lat_$aCpt");
		$aInputLong[$aCpt] = mosGetParam($_REQUEST, "input_long_$aCpt");
		$aInputDesc[$aCpt] = mosGetParam($_REQUEST, "input_desc_$aCpt");

		if ($aSelectSection[$aCpt] != 0) {
			echo "1";
			db_updLieuForSeance($aCpt, $aSelectSection[$aCpt]);
		}

		if ($aInputLat[$aCpt] != 0) {
			db_updLieuForLatitude($aCpt, $aInputLat[$aCpt]);
		}

		if ($aInputLong[$aCpt] != 0) {
			db_updLieuForLongitude($aCpt, $aInputLong[$aCpt]);
		}

		if ($aInputDesc[$aCpt]) {
			if ($aInputDesc[$aCpt] != "?") {
				db_updLieuForDescription($aCpt, addslashes($aInputDesc[$aCpt]));
			}
		}
	}

	displayLieu($option, $err, $kom);
}
?>