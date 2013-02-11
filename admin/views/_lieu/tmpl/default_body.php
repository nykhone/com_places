<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->lieu as $aLieu )
{
?>
<tr>
	<td align="center"><?php // echo $aLieu->numero; ?></td>
	<td align="center"><?php // echo "checkbox"; ?></td>
	<td align="center"><?php // echo $aLieu->count; ?></td>
	<td align="center"><?php echo $aLieu->nom; ?></td>
	<td align="center"><?php echo $aLieu->vnom; ?></td>
	<td align="center"><?php echo $aLieu->latitude; ?></td>
	<td align="center"><?php echo $aLieu->longitude; ?></td>
	<td align="center"><?php echo $aLieu->description; ?></td>
	<td align="center"><?php echo $aLieu->section_name; ?></td>
	<td align="center"><?php echo $aLieu->id; ?></td>
</tr>
<?php
}
?>