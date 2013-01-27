<?php
/**
* Movie Stats
*/

require_once (ADMIN_PATH.'core/movies.class.db.php');

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function import($option) {
	global $config, $mosConfig_live_site;

	$theImport = mosGetParam( $_REQUEST, 'import');

?>
	<div>
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr align="left">
			<td class="sectionname"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/dbrestore.png">Importe les données</td>
		</tr>
		<tr class="tableborder">
			<td class="center" >&nbsp;</td>
		</tr>
		</table>
	</div>
<?php

	$aTemp = db_getCountOriginalSeance();
	$aOriginalCount = $aTemp[0]['count'];
	$aTemp = db_getCountLieu();
	$aLieuCount = $aTemp[0]['count'];
?>

	<div><br/><?php echo "$aOriginalCount lieux dans seances -> $aLieuCount déjà dans la base"; ?>
	<br /><b style="font-size:1.5em;color: red;">mise à jour ?</b><br /><br />
	</div>

			<form action="index2.php?" id="imp" name="imp" method="post">
				<input type="hidden" name="option" value="<?php echo $option;?>" />
				<input type="hidden" name="task" value="import" />
				<input type="submit" name="import" value="NO" class="button" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="import" value="YES" class="button" />
			</form>
	<br /><br />
<?php

	if ($theImport == "YES") {

?>
		<table cellpadding="4" cellspacing="0" border="1" width="50%" class="adminlist">
			<th width="50">Id Lieu</th>
			<th width="150">Lieu</th>
			<th width="50">Id Ville</th>
			<th width="150">Ville</th>
			<th width="150">Description</th>
<?php

		$aSeance = db_getOriginalSeance();
		for ($aCpt = 0; $aCpt < $aOriginalCount; $aCpt++) {

			// ID : pas de changement
			$aLieu = addslashes($aSeance[$aCpt]['Lieu']);
			$aVille = addslashes($aSeance[$aCpt]['Ville']);

			// test ville déjà inserée ?
			$aTemp = db_getVilleId($aVille);
			if (count($aTemp) == 0) {
				// creer une ville (sans pays)
				$aError = db_addVille($aVille, 0);					// en cas erreur ???
				$aTemp = db_getVilleId($aVille);
				$aVilleID = $aTemp[0]['id'];
				$aVilleStatus = 'new';
			} else {
				$aVilleID = $aTemp[0]['id'];
				$aVilleStatus = 'old';
			}

// insérer la section spéciale movie stats si absente !
// rajouter le champ section = cellde moviestats

			// test lieu déjà inseré ?
			$aTemp = db_getLieuId($aLieu, $aVilleID);
			if (count($aTemp) == 0) {
				// creer un lieu (avec la ville)
				$aError = db_addLieu($aLieu, $aVilleID);		// en cas erreur ???
				$aTemp = db_getVilleId($aVille);
				$aLieuID = $aTemp[0]['id'];
				$aLieuStatus = 'new';
			} else {
				$aLieuID = $aTemp[0]['id'];
				$aLieuStatus = 'old';
			}

			if ($aError) {
				$aOK = 'pb';
			} else {
				$aOK = 'ok';
			}
?>

			<tr class="row<?php echo $i%2;?>">
				<td><?php echo $aLieuID; ?></td>
				<td><?php echo "$aLieu"; ?></td>
				<td><?php echo $aVilleID; ?></td>
				<td><?php echo "$aVille"; ?></td>
				<td><?php echo "$aOK ville:$aVilleStatus lieu:$aLieuStatus"; ?></td>
			</tr>

<?php
		}
	}
?>

		</table>

<?php
}
?>