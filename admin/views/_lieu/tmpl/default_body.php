<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->lieu as $aLieu )
{
?>
<tr>
	<td align="center"><?php echo $aLieu->id; ?></td>
	<td align="center"><?php echo $aLieu->nom; ?></td>
	<td align="center"><?php echo $aLieu->description; ?></td>
	<td align="center"><?php echo $aLieu->ville; ?></td>
	<td align="center"><?php echo $aLieu->latitude; ?></td>
	<td align="center"><?php echo $aLieu->longitude; ?></td>
	<td align="center"><?php echo $aLieu->section; ?></td>
</tr>
<?php
}
?>