<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->ville as $aVille )
{
?>
<tr>
	<td align="center"><?php // echo $aVille->numero; ?></td>
	<td align="center"><?php // echo "checkbox"; ?></td>
	<td align="center"><?php echo $aVille->nom; ?></td>
	<td align="center"><img src="../media/com_places/flags/<?php echo $aVille->pays_drapeau; ?>" /></td>
	<td align="center"><?php echo $aVille->id; ?></td>
	<td align="center"><?php echo $aVille->lieux_count; ?></td>
</tr>
<?php
}
?>