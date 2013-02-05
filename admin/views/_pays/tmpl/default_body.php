<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->pays as $aPays )
{
	$aName = $aPays->nom;
?>
<tr>
	<td align="center"><?php echo $aPays->id; ?></td>
	<td align="center"><?php echo $aName; ?></td>
	<td align="center"><img src="../media/com_places/flags/<?php echo $aPays->drapeau; ?>" alt="<?php echo $aName; ?>"/></td>
</tr>
<?php
}
?>