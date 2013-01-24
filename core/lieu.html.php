<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function displayLieu($option, $err, $kom = false) {
	global $config,$mosConfig_live_site,$database;
?>
	<form class="adminheading" action="index2.php" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="0" border="0" width="100%">
		<tr align="left">
			<td class="sectionname"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/categories.png"> Gestion des Lieux </td>
		</tr>
		<tr><td >&nbsp;</td></tr>
		</table>
		<table cellpadding="4" cellspacing="0" border="1" width="50%" class="adminlist">
			<tr>
				<th width="20" align="center">#</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $genres ); ?>);" /></th>
				<th width="20" align="center">Nb</th>
				<th width="100" align="left">Nom</th>
				<th width="50" align="left">Ville</th>
				<th width="30" align="center">Latitude</th>
				<th width="30" align="center">Longitude</th>
				<th width="150" align="left">Description</th>
				<th width="50" align="left">Section(s)</th>
				<th width="50" align="left">Id</th>
			</tr>
<?php
		$k=0; $c=1; $i=0; $count=0;

		$results2 = db_getCountLieu();
		$aLieuCount = $results2[0]['count'];

		$rows = db_getLieuOrdered();

		for ($aCpt=0; $aCpt < $aLieuCount; $aCpt++) {

			$aLieuID = $rows[$aCpt]['id'];
			$aLieuNom = $rows[$aCpt]['nom'];
			$aLieuLatitude = $rows[$aCpt]['latitude'];
			$aLieuLongitude = $rows[$aCpt]['longitude'];
			$aLieuVilleID = $rows[$aCpt]['ville'];
			$aLieuSectionID = $rows[$aCpt]['section'];
			$aLieuDescription = $rows[$aCpt]['description'];
			$aVilleNom = $rows[$aCpt]['vnom'];

			$results3 = db_getSectionLink($aLieuSectionID);
			$aLinkField = $results3[0]['linkfield'];
			$aLinkTable = $results3[0]['linktable'];

			$aQuery = "select count(*) as count";
			$aQuery .= " from $aLinkTable";
			$aQuery .= " where $aLinkField = $aLieuID";
			$database->setQuery( $aQuery );
			$rows2 = $database->loadObjectList();
			$row2 = $rows2[0];
			$count = $row2->count;
?>
			<tr class="row<?php echo $i;?>">
				<td align='center'><?php echo $k++;?></td>
				<td align='center'>
<?php				if ($count != 0) {
?>
						<img src="<?php echo $mosConfig_live_site; ?>/administrator/images/checked_out.png" >
<?php
					} else {
						echo mosHTML::idBox($k, $aLieuID);
					}
?>
				</td>
				<td align='center'><?php echo $count; ?></td>
				<td align='left'><?php echo $aLieuNom; ?></td>
				<td align='left'><?php echo $aVilleNom; ?></td>
				<td align='center'>
				<?php
if ($aLieuLatitude == 0) {
	$aLatText = "<input type='text' size='10' name='input_lat_$aLieuID' id='input_lat_$aLieuID' style='text-align:center' value='0' />";
} else {
	$aLatText = $aLieuLatitude;
}
echo $aLatText;
				?>
				</td>
				<td align='center'>
				<?php
if ($aLieuLongitude == 0) {
	$aLongText = "<input type='text' size='10' name='input_long_$aLieuID' id='input_long_$aLieuID' style='text-align:center' value='0' />";
	echo $aInput;
} else {
	$aLongText = $aLieuLongitude;
}
echo $aLongText;
				?>
				</td>
				<td align='left'>
				<?php
if ($aLieuDescription == "?") {
	$aDescText = "<input type='text' size='50' name='input_desc_$aLieuID' id='input_desc_$aLieuID' style='text-align:center' value='?' />";
} else {
	$aDescText = $aLieuDescription;
}
echo $aDescText;
				?>
				</td>
				<td align='left'>
				<?php
if ($aLieuSectionID == 0) {
	$aSection = '';
	$aQuery = "select id as value, title as text from #__places_section";
	$aSection[] = mosHTML::makeOption( '0', '- section -' );
	$database->setQuery( $aQuery );
	$aSection = array_merge( $aSection, $database->loadObjectList() );
	echo mosHTML::selectList( $aSection, "select_section_$aLieuID", "class='inputbox' size='1'", 'value', 'text' );
} else {
	$aTemp = db_getSectionName($aLieuSectionID);
	echo $aTemp[0]['title'];
}
				?>
				</td>
				<td align='left'><?php echo $aLieuID; ?></td>
			</tr>
		<?php
	$i = 1 - $i;
	$c = $c % 5 + 1;
		}
//	echo $pageNav->getListFooter();
?>
		</table>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="lieu" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
<?php
}
?>