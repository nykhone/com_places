<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );
$i = 1;

foreach( $this->pays as $aPays )
{
	$i = 1 - $i;
?>
<tr class="row<?php echo $i;?>">
	<td align="center"><?php // echo $aPays->numero; ?></td>
	<td align="center"><?php // echo "checkbox"; ?></td>
	<td align="center"><?php echo $aPays->nom; ?></td>
	<td align="center"><img src="../media/com_places/flags/<?php echo $aPays->drapeau; ?>" /></td>
	<td align="center"><?php echo $aPays->id; ?></td>
	<td align="center"><?php echo $aPays->ville_count; ?></td>
</tr>
<?php
}
?>