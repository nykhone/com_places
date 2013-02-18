<?php
defined( '_JEXEC' ) or die( 'Restricted Access' );
?>
<tr>
	<th width="30" align="middle">#</th>
	<th width="50"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->ville); ?>);" /></th>
	<th width="150" align="left">Nom</th>
	<th width="150" align="left">Country</th>
	<th width=" 50" align="left">Id</th>
	<th width=" 50" align="left">Places Count</th></tr>
