<?php
defined( '_JEXEC' ) or die( 'Restricted Access' );
?>
<tr>
	<th width="30" align="center">#</th>
	<th width="50" align="center"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->pays); ?>);" /></th>
	<th width="150" align="left">Country Name</th>
	<th width="150" align="left">Country Flag</th>
	<th width=" 50" align="left">Country Id</th>
	<th width=" 50" align="left">City Count</th>
</tr>