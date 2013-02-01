<?php
/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function displayAbout($option) {
	global $config, $mosConfig_absolute_path;

	$tabs = new mosTabs(0);
?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
	<script language="Javascript" src="<?php echo $mosConfig_absolute_path;?>/includes/js/overlib_mini.js"></script>

	<table border="0" class="adminheading" cellpadding="0" cellspacing="0" width="100%">
	<tr valign="middle">
		<th class="config">About</th>
		<td align="right"></td>
	</tr>
	</table>

	<form action="index2.php" method="post" name="adminForm" id="adminForm">

<?php

		$tabs->startPane("aboutPane");
		$tabs->startTab("pane 1", "aboutPane");
?>
			<table class="adminform">
			<tr>
				<td width="80%">
					<h3>Title blabla</h3>
					<br>blabla 1
					<br>blabla 2
					<br>blabla 3
				</td>
			</tr>
			</table>
<?php
		$tabs->endTab();
		$tabs->startTab("release notes", "aboutPane");
//			include(ADMIN_PATH.'doc/releasenote.php');
		$tabs->endTab();
		$tabs->endPane();
?>
		<input type="hidden" name="option" value="<?php echo $option;?>">
	</form>
<?php
}
?>