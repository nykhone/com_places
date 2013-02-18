<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

$j = 0;

foreach( $this->pays as $aPays )
{
	$j++;
?>
<tr class="row<?php echo $j % 2;?>">
	<td align="center"><?php echo $j; ?></td>
	<td align="center"><?php echo JHtml::_('grid.id', $j - 1, $aPays->id); ?></td>
	<td align="center"><?php echo $aPays->nom; ?></td>
	<td align="center"><img src="../media/com_places/flags/<?php echo $aPays->drapeau; ?>" /></td>
	<td align="center"><?php echo $aPays->id; ?></td>
	<td align="center"><?php echo $aPays->ville_count; ?></td>
</tr>
<?php
}
?>