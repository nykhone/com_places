<?php
/**
* Movie Stats
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

class HTML_config {

	function displayConfig( &$rows, $pageNav, $option ) {
		global $mosConfig_live_site, $setup;

		$tabs = new mosTabs(0);
	?>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>

		<table border="0" class="adminheading" cellpadding="0" cellspacing="0" width="100%">
			<tr valign="middle"><th class="config"><?php echo _CONFPARAM_TITLE; ?></th></tr>
		</table>

		<form action="index2.php" method="post" name="adminForm" id="adminForm">
<?php
			$tabs->startPane('configPane');
			$tabs->startTab('Langues', 'configPane');
?>
		<table class="adminlist">
		<tr>
			<th width="10%" class="title">id</th>
			<th width="10%" class="title">langue</th>
			<th width="30%" class="title">drapeau</th>
			<th width="10%" class="title">gif</th>
			<th width="10%" class="title">ou</th>
		</tr>
<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row =& $rows[$i];
				$aDrapo = $row->drapeau;
				$aStDrapo = IMAGE_PATH . "/flags/$aDrapo";
				$aStr = "<img src='$aStDrapo' width='30' height='15' border='0' alt='$aDrapo' />";
?>
		<tr class="<?php echo "row$k"; ?>">
			<td><?php echo "$row->id"; ?></a></td>
			<td><?php echo "$row->langue"; ?></td>
			<td><?php echo "$row->drapeau"; ?></td>
			<td><?php echo "$aStr"; ?></td>
			<td><?php echo "$row->ou"; ?></td>
		</tr>
<?php
				$k = 1 - $k;
			}
?>
		</table>
<?php
			echo $language;
			$tabs->endTab();

		$tabs->startTab("Pays","configPane");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Langue:</td>
				<td><?php echo $lists['lang']; ?></td>
			</tr>
			<tr>
				<td width="185">Fuseau horaire:</td>
				<td>
				<?php echo $lists['offset']; ?>
				<?php
				$tip = "Date/heure courante &agrave; afficher: " . mosCurrentDate(_DATE_FORMAT_LC2);
				echo mosToolTip($tip);
				?>
				</td>
			</tr>
			<tr>
				<td width="185">Fuseau horaire du serveur:</td>
				<td>
				<input class="text_area" type="text" name="config_offset" size="15" value="<?php echo $row->config_offset; ?>" disabled="true"/>
				</td>
			</tr>
			<tr>
				<td width="185">Code langue:</td>
				<td>
				<input class="text_area" type="text" name="config_locale" size="15" value="<?php echo $row->config_locale; ?>"/>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();




			$out = '';

				for($i=0; $i<count($setup->SETUP_GLOBAL); $i++) {
					$row=$setup->SETUP_GLOBAL[$i];
					if (!empty($row[0]['group'])) {
						if ($i) {
							echo $out.'</table>';
							$tabs->endTab();
						}
						$tabs->startTab($row[1]['name'], 'configPane');
						$k=0;
						$out ='<table class="adminform">';
						$out.='<tr ><th width="25%">'._TITLE.'</th><th>'._OPIS.'</th></tr>';
					}
					$out.='<tr class="row'.$k.'">';
					$out.='<td class="center" nowrap="nowrap">';
					$out.='<b>'.$row['hl'].'</b><br/>';

					Switch ($row['type']) {
						case 'dropdown':
							$out.='<select name="'.$row['name'].'">';
							foreach($row['data'] as $key=>$value) {
								$out.='<option label="'.$value.'" value="'.$key.'"';
								$out.= ($key==$row['set']) ? ' selected="selected"' : '';
								$out.='>'.$value.'</option>';
							}
							$out.='</select>';
							break;
						case 'multi':
							$out.='<select name="'.$row['name'].'[]" size="5" multiple="multiple">';
							$out.='<option value=""></option> ';
							foreach($row['data'] as $key=>$value) {
								$out.='<option label="'.$value.'" value="'.$key.'"';
								$out.= (in_array($key,$row['set'])) ? ' selected="selected"' : '';
								$out.='>'.$value.'</option>';
							}
							$out.='</select>';
							break;
						case 'text':
							$out.='<input type="text" size="20" ';
							$out.='name="'.$row['name'].'" ';
							$out.='id="'.$row['name'].'" ';
							$out.='value="'.$row['set'].'" ';
							$out.='style="text-align:center"/>';
							break;
						case 'boolean':
							$out.='<input type="checkbox" ';
							$out.='name="'.$row['name'].'" ';
							$out.='id="'.$row['name'].'" value="'.$row['set'].'"';
							$out.= ($row['set']) ? ' checked="checked"' : '';
							$out.='/>';
							break;
						case 'special':
							$out.=$row['data'];
							break;
					}
					$out.='</td><td align="left">';
					$out.=$row['help'].'</td>';
					$out.='</tr>';
					$k=1-$k;
				}
				echo $out.'</table>';
				$tabs->endTab();
			$tabs->endPane();
	?>
			<input type="hidden" name="option" value="<?php echo $option; ?>">
			<input type="hidden" name="task" value="" />
		</form>
	<?php
	}
}
?>
