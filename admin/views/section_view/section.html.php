<?php
/**
* Places
*/

defined( '_VALID_MOS' ) or die( 'Restricted access' );

class sections_html {

	function show( &$rows, $option ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
			<tr><th class="sections">Gestionnaire de Sections</th></tr>
		</table>

		<table class="adminlist">
			<tr>
				<th width="20">#</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" /></th>
				<th width="20%" class="title">Section Name</th>
				<th width="25%" class="title">Description</th>
				<th width="12%" nowrap>ID	Section		</th>
				<th width="12%" nowrap># Places</th>
				<th width="12%" nowrap># Cities</th>
				<th width="12%" nowrap># Countries</th>
			</tr>
		<?php
		$k = 0;
		for ( $i=0, $n=count( $rows ); $i < $n; $i++ ) {
			$row = &$rows[$i];

// faire un lien vers les lieux de cette section tris dans lien
			$link = 'index2.php?option=com_places&task=section_editA&id='. $row->id;

			$aBox = mosHTML::idBox( $i, $row->id );

			?>
			<tr class="<?php echo "row$k"; ?>">
				<td width="20" align="right"><?php echo $i; ?></td>
				<td width="20"><?php echo $aBox; ?></td>
				<td align="left"><a href="<?php echo $link; ?>"><?php echo $row->title; ?></a></td>
				<td align="left"><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
				<td align="center"><?php echo $row->id; ?></td>
				<td align="center"><?php echo $row->lieux; ?></td>
				<td align="center"><?php echo $row->villes; ?></td>
				<td align="center"><?php echo $row->pays; ?></td>
				<?php $k = 1 - $k; ?>
			</tr>
			<?php
		}
		?>
		</table>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing categories
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.  Note that the <var>section</var> property <b>must</b> be defined
	* even for a new record.
	*/
	function edit( &$row, $option) {
		global $mosConfig_live_site;

		if ( $row->id != 0 ) {
			$name = $row->name;
		} else {
			$name = "New Section";
		}
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'section_cancel') {
				submitform(pressbutton);
				return;
			}

			if (form.name.value == ""){
				alert("Section must have a description");
			} else if (form.title.value ==""){
				alert("Section must have a name");
			} else {
				submitform(pressbutton);
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="sections">Section:
			<small><?php echo $row->id ? 'Edit' : 'New';?></small>
			<small><small>[ <?php echo stripslashes($name); ?> ]</small></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td valign="top" width="60%">
				<table class="adminform">
				<tr><th colspan="3">Section Informations</th>
				<tr>
					<td>Id:</td>
					<td colspan="2"><?php echo $row->id; ?></td>
				</tr>
				<tr>
					<td>Name:</td>
					<td colspan="2">
					<input class="text_area" type="text" name="title" value="<?php echo $row->title; ?>" size="50" maxlength="50" title="Un nom court pour les menus" />
					</td>
				</tr>
				<tr>
					<td>Details</td>
					<td colspan="2">
					<input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255" title="Un nom long pour les titres" />
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="oldtitle" value="<?php echo $row->title ; ?>" />
		</form>
		<?php
	}


	/**
	* Form to select Section to copy Category to
	*/
	function copySectionSelect( $option, $cid, $categories, $contents, $section ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="sections">
			Copier la section
			</th>
		</tr>
		</table>

		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Copier vers la  section:</strong>
			<br />
			<input class="text_area" type="text" name="title" value="" size="35" maxlength="50" title="Le nom de la nouvelle section" />
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong>Cat&eacute;gories &agrave; copier:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $categories as $category ) {
				echo "<li>". $category->name ."</li>";
				echo "\n <input type=\"hidden\" name=\"category[]\" value=\"$category->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong>Articles &agrave; copier :</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>";
				echo "\n <input type=\"hidden\" name=\"content[]\" value=\"$content->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			Ceci copiera les cat&eacute;gories s&eacute;lectionn&eacute;es
			<br />
			ainsi que l'int&eacute;gralit&eacute; de leur contenu
			<br />
			dans la nouvelle section cr&eacute;&eacute;e.
			</td>.
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $section;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="scope" value="content" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}

}
?>