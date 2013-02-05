<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function displayPays($option, $err, $kom = false) {
	global $config,$mosConfig_live_site,$mosConfig_absolute_path;
?>
	<form class="adminheading" action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr align="left">
			<td class="sectionname"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/categories.png"> Countries Management </td>
		</tr>
		<tr><td >&nbsp;</td></tr>
		<tr>
			<td align='left' >
				<div class='componentheading' style="text-align:left; ">Insert a new country with flag : <font color="<?php echo !$kom ? 'red' : 'green';?>" >[&nbsp;<?php echo $err; ?>&nbsp;]</font></div>
			</td>
		</tr>
		</table>
		<table cellpadding="4" cellspacing="0" border="1" width="50%" class="adminlist">
			<tr>
				<th width="30" align="center">#</th>
				<th width="50" align="center"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $genres ); ?>);" /></th>
				<th width="150" align="left"><input type='text' name='nom' value='Country'></th>
				<th width="150" align="left">Country Flag</th>
				<th width=" 50" align="left">Country Id</th>
				<th width=" 50" align="left">City Count</th>
			</tr>
<?php
		$k=0; $c=1; $i=0; $count=0;

		$results2 = db_getCountPays();
		$aPaysCount = $results2[0]['count'];

		$rows = db_getPays();

		for ($aCpt=0; $aCpt < $aPaysCount; $aCpt++) {

			$aPaysID = $rows[$aCpt]['id'];
			$aPaysNom = $rows[$aCpt]['nom'];
			$aDrapeauNom = $rows[$aCpt]['drapeau'];
			$aDrapeau = IMAGE_PATH . "flags/" . $rows[$aCpt]['drapeau'];

			$results = db_getCountVilleForPays($aPaysID);
			$aVilleCount = $results[0]['count'];
			$f = $totalcount > 0 ? $aVilleCount / $totalcount : 0;
			$w = $width * $f;
?>
			<tr class="row<?php echo $i;?>">
				<td align="center"><?php echo $k++;?></td>
				<td align="center">
<?php				if ($aVilleCount != 0) {
?>
						<img src="<?php echo $mosConfig_live_site; ?>/administrator/images/checked_out.png" >
<?php
					} else {
						echo mosHTML::idBox( $k, $aPaysID );
					}
?>
				</td>
				<td align='left'><?php echo $aPaysNom; ?></td>
				<td align='left'><?php
if ($aDrapeauNom == "?") {
	$pays = '';
	$pays[] = mosHTML::makeOption( '?', '- pays -' );


	$aRepName = ADMIN_PATH . "/images/flags/";

	$aRep = opendir("$aRepName");
	while($aFile = readdir($aRep)) {
		$pays[] = mosHTML::makeOption( "$aFile", "$aFile-<img src='$aFile' border='0'>-" );
	}
	closedir($aRep);

	echo mosHTML::selectList( $pays, "select_drapeau_$aPaysID", "class='inputbox' size='1'", 'value', 'text' );

} else {
	echo "<img src='$aDrapeau' border='0' alt='$aPaysNom' />";
}
					?></td>
				<td align='left'><?php echo $aPaysID; ?></td>
				<td align='left'><?php echo $aVilleCount; ?></td>
			</tr>
<?php
			$i = 1 - $i;
		}
?>
		</table>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="pays" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
<?php
}
?>