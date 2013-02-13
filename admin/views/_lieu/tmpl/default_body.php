<?php

defined( '_JEXEC' ) or die( 'Restricted Access' );

foreach( $this->items as $i => $item )
{
?>
<tr class="row<?php echo $i % 2; ?>">
	<td align="center"><?php // echo $aLieu->numero; ?></td>
	<td align="center"><?php // echo "checkbox"; ?></td>
	<td align="center"><?php // echo $aLieu->count; ?></td>
	<td align="center"><?php echo $item->nom; ?></td>
	<td align="center"><?php echo $item->ville_name; ?></td>
	<td align="center"><?php echo $item->latitude; ?></td>
	<td align="center"><?php echo $item->longitude; ?></td>
	<td align="center"><?php echo $item->description; ?></td>
	<td align="center"><?php echo $item->section_name; ?></td>
	<td align="center"><?php echo $item->id; ?></td>
</tr>
<?php
}
?>