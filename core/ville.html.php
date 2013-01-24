<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function displayVille($option, $err, $kom = false) {
	global $config,$mosConfig_live_site,$database;
?>
	<form class="adminheading" action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr align="left">
			<td class="sectionname"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/categories.png"> Gestion des Villes </td>
		</tr>
		<tr><td >&nbsp;</td></tr>
		<tr>
			<td align='left' >
				<div class='componentheading' style="text-align:left; ">Insérer une nouvelle ville et son pays : <font color="<?php echo !$kom ? 'red' : 'green';?>" >[&nbsp;<?php echo $err; ?>&nbsp;]</font></div>
			</td>
		</tr>
		</table>
		<table cellpadding="4" cellspacing="0" border="1" width="50%" class="adminlist">
			<tr>
				<th width="30" align="middle">#</th>
				<th width="50">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $genres ); ?>);" />
				</th>
				<th width="150" align="left"><input type='text' name='nom' value='City'></th>
				<th width="150" align="left">Country</th>
				<th width=" 50" align="left">Id</th>
				<th width=" 50" align="left">Places Count</th>
			</tr>
<?php
		$k=0; $c=1; $i=0; $count=0;

		$results2 = db_getCountVille();
		$aVilleCount = $results2[0]['count'];

		$rows = db_getVille();

		for ($aCpt=0; $aCpt < $aVilleCount; $aCpt++) {

			$aVilleID = $rows[$aCpt]['id'];
			$aVilleNom = $rows[$aCpt]['nom'];
			$aVillePaysID = $rows[$aCpt]['pays'];

			$results = db_getCountLieuForVille($aVilleID);
			$aLieuCount = $results[0]['count'];
			$f = $totalcount > 0 ? $aLieuCount / $totalcount : 0;
			$w = $width * $f;
?>
			<tr class="row<?php echo $i;?>">
				<td align='middle'><?php echo $k++;?></td>
				<td>
<?php
			if ($aLieuCount != 0) {
?>
					<img src="<?php echo $mosConfig_live_site; ?>/administrator/images/checked_out.png" >
<?php
			} else {
				echo mosHTML::idBox($k, $aVilleID);
			}
?>
				</td>
				<td align='left'><?php echo $aVilleNom; ?></td>
				<td align='left'>
<?php
if ($aVillePaysID == 0) {
	$pays = '';
	$aQuery = "select id as value, nom as text from #__places_pays";
	$pays[] = mosHTML::makeOption( '0', '- pays -' );
	$database->setQuery( $aQuery );
	$pays = array_merge( $pays, $database->loadObjectList() );
	echo mosHTML::selectList( $pays, "select_pays_$aVilleID", "class='inputbox' size='1'", 'value', 'text' );

} else {

	$results3 = db_getPaysDrapeau($aVillePaysID);
	$aFlag = IMAGE_PATH . "flags/" . $results3[0]['drapeau'];
?>
	<img src="<?php echo $aFlag; ?>" border='0' />
<?php
}
?>
				</td>
				<td align='left'><?php echo $aVilleID; ?></td>
				<td align='left'><?php echo $aLieuCount; ?></td>
			</tr>
		<?php
	$i = 1 - $i;
	$c = $c % 5 + 1;
		}
		//echo $pageNav->getListFooter();
?>
		</table>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="ville" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
<?php
}
?>