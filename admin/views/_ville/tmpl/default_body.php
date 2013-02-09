<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->ville as $aVille )
{
	$aName = $aVille->nom;
?>
<tr>
	<td align="center"><?php // echo $aVille->numero; ?></td>
	<td align="center"><?php // echo "checkbox"; ?></td>
	<td align="center"><?php echo $aVille->nom; ?></td>
	<td align="center"><?php echo $aVille->pays; ?></td>
	<td align="center"><?php echo $aVille->id; ?></td>
	<td align="center"><?php // echo $aVille->count; ?></td>
</tr>
<?php
}
?>