<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->ville as $aVille )
{
	$aName = $aVille->nom;
?>
<tr>
	<td align="center"><?php echo $aVille->id; ?></td>
	<td align="center"><?php echo $aName; ?></td>
	<td align="center"><?php echo $aVille->pays; ?></td>
</tr>
<?php
}
?>