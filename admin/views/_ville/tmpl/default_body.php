<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

$j = 0;

foreach( $this->ville as $aVille )
{
	$j++;
?>
<tr>
	<td align="center"><?php echo $j; ?></td>
	<td align="center"><?php echo JHtml::_('grid.id', $j - 1, $aVille->id); ?></td>
	<td align="center"><?php echo $aVille->nom; ?></td>
	<td align="center"><img src="../media/com_places/flags/<?php echo $aVille->pays_drapeau; ?>" /></td>
	<td align="center"><?php echo $aVille->id; ?></td>
	<td align="center"><?php echo $aVille->lieux_count; ?></td>
</tr>
<?php
}
?>