<?php
/**
* Places
*/

defined( '_VALID_MOS' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'admin_html' ) );

// get parameters from the URL or submitted form
$section 	= mosGetParam( $_REQUEST, 'scope', '' );
$cid 		= mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}

/**
* Compiles a list of categories for a section
* @param database A database connector object
* @param string The name of the category section
*/
function showSections( $option ) {
	global $database, $my, $mainframe, $mosConfig_list_limit;

	$query = "select * from jos_places_section order by name";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	$count = count( $rows );

	for ( $i = 0; $i < $count; $i++ ) {
		$aID = $rows[$i]->id;
		$aQuery = "select count(id) from jos_places_lieu where section = '$aID'";
		$database->setQuery($aQuery);
		$aCountLieu = $database->loadResult();
		$rows[$i]->lieux = $aCountLieu;
	}

	for ( $i = 0; $i < $count; $i++ ) {
		$aID = $rows[$i]->id;
		$query = "select distinct(ville) from jos_places_lieu WHERE section = '$aID'";
		$database->setQuery( $query );
		$aVille = $database->loadObjectList();
		$rows[$i]->villes = count($aVille);
	}

	for ( $i = 0; $i < $count; $i++ ) {
		$aID = $rows[$i]->id;
		$query = "select distinct(v.pays) from jos_places_lieu as l"
		. " left join jos_places_ville as v on l.ville = v.id"
		. " where l.section = '$aID'";
		$database->setQuery( $query );
		$aPays = $database->loadObjectList();
		$rows[$i]->pays = count($aPays);
	}

	sections_html::show( $rows, $option );
}

/**
* Compiles information to add or edit a section
* @param database A database connector object
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editSection( $uid = 0, $option ) {
	global $database;

	$query = "select * from jos_places_section where id = $uid";
	$database->setQuery( $query );
	$row = $database->loadObjectList();

	sections_html::edit( $row, $option );
}

/**
* Saves the catefory after an edit form submit
* @param database A database connector object
* @param string The name of the category section
*/
function saveSection( $option, $scope, $task ) {
	global $database;

	$oldtitle = strval( mosGetParam( $_POST, 'oldtitle', null ) );
	$title = strval( mosGetParam( $_POST, 'title', null ) );
	$name = strval( mosGetParam( $_POST, 'name', null ) );

// get section deja la !
	$row = new mosSection( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); document.location.href='index2.php?option=$option&scope=$scope&task=new'; </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); document.location.href='index2.php?option=$option&scope=$scope&task=new'; </script>\n";
		exit();
	}

// si sction existe bug
// sinon insert

	if ( $oldtitle != $title ) {
		$query = "insert into jos_places_section"
		. " (title, name) values "
		. " ('$title', '$name')";
		$database->setQuery( $query );
		$database->query();
	}

	switch ( $task ) {
		case 'section_apply':
			$msg = 'Section Modified';
			mosRedirect( 'index2.php?option='. $option .'&scope='. $scope .'&task=editA&hidemainmenu=1&id='. $row->id, $msg );
			break;

		case 'section_save':
		default:
			$msg = 'Section Saved';
			showSections($scope, $option);
			break;
	}
}
/**
* Deletes one or more categories from the categories table
* @param database A database connector object
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeSections( $cid, $scope, $option ) {
	global $database;

	if (count( $cid ) < 1) {
		echo "<script> alert('Selectionner une section à supprimer'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$query = "SELECT s.id, s.name, COUNT(c.id) AS numcat"
	. "\n FROM #__sections AS s"
	. "\n LEFT JOIN #__categories AS c ON c.section=s.id"
	. "\n WHERE s.id IN ( $cids )"
	. "\n GROUP BY s.id"
	;
	$database->setQuery( $query );
	if (!($rows = $database->loadObjectList())) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
	}

	$err = array();
	$cid = array();
	foreach ($rows as $row) {
		if ($row->numcat == 0) {
			$cid[] = $row->id;
			$name[] = $row->name;
		} else {
			$err[] = $row->name;
		}
	}

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = "DELETE FROM #__sections"
		. "\n WHERE id IN ( $cids )"
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}

	if (count( $err )) {
		$cids = implode( ', ', $err );
		$msg = 'Sections(s): '. $cids .' ne peuvent être supprimées tant qu\'elles contiennent des catégories';
		mosRedirect( 'index2.php?option='. $option .'&scope='. $scope, $msg );
	}

	// clean any existing cache files
	mosCache::cleanCache( 'com_content' );

	$names = implode( ', ', $name );
	$msg = 'Section(s): '. $names .' successfully deleted';
	mosRedirect( 'index2.php?option='. $option .'&scope='. $scope, $msg );
}

/**
* Form for copying item(s) to a specific menu
*/
function copySectionSelect( $option, $cid, $section ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Sélectionner un élément à déplacer'); window.history.go(-1);</script>\n";
		exit;
	}

	## query to list selected categories
	$cids = implode( ',', $cid );
	$query = "SELECT a.name, a.id"
	. "\n FROM #__categories AS a"
	. "\n WHERE a.section IN ( $cids )"
	;
	$database->setQuery( $query );
	$categories = $database->loadObjectList();

	## query to list items from categories
	$query = "SELECT a.title, a.id"
	. "\n FROM #__content AS a"
	. "\n WHERE a.sectionid IN ( $cids )"
	. "\n ORDER BY a.sectionid, a.catid, a.title"
	;
	$database->setQuery( $query );
	$contents = $database->loadObjectList();

	sections_html::copySectionSelect( $option, $cid, $categories, $contents, $section );
}


/**
* Save the item(s) to the menu selected
*/
function copySectionSave( $sectionid ) {
	global $database;

	$title 		= strval( mosGetParam( $_REQUEST, 'title', '' ) );
	$contentid 	= mosGetParam( $_REQUEST, 'content', '' );
	$categoryid = mosGetParam( $_REQUEST, 'category', '' );

	// copy section
	$section = new mosSection ( $database );
	foreach( $sectionid as $id ) {
		$section->load( $id );
		$section->id 	= NULL;
		$section->title = $title;
		$section->name 	= $title;
		if ( !$section->check() ) {
			echo "<script> alert('".$section->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if ( !$section->store() ) {
			echo "<script> alert('".$section->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$section->checkin();
		$section->updateOrder( "section = '$section->id'" );
		// stores original catid
		$newsectids[]["old"] = $id;
		// pulls new catid
		$newsectids[]["new"] = $section->id;
	}
	$sectionMove = $section->id;

	// copy categories
	$category = new mosCategory ( $database );
	foreach( $categoryid as $id ) {
		$category->load( $id );
		$category->id = NULL;
		$category->section = $sectionMove;
		foreach( $newsectids as $newsectid ) {
			if ( $category->section == $newsectid["old"] ) {
				$category->section = $newsectid["new"];
			}
		}
		if (!$category->check()) {
			echo "<script> alert('".$category->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$category->store()) {
			echo "<script> alert('".$category->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$category->checkin();
		$category->updateOrder( "section = '$category->section'" );
		// stores original catid
		$newcatids[]["old"] = $id;
		// pulls new catid
		$newcatids[]["new"] = $category->id;
	}

	$content = new mosContent ( $database );
	foreach( $contentid as $id) {
		$content->load( $id );
		$content->id = NULL;
		$content->hits = 0;
		foreach( $newsectids as $newsectid ) {
			if ( $content->sectionid == $newsectid["old"] ) {
				$content->sectionid = $newsectid["new"];
			}
		}
		foreach( $newcatids as $newcatid ) {
			if ( $content->catid == $newcatid["old"] ) {
				$content->catid = $newcatid["new"];
			}
		}
		if (!$content->check()) {
			echo "<script> alert('".$content->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$content->store()) {
			echo "<script> alert('".$content->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$content->checkin();
	}
	$sectionOld = new mosSection ( $database );
	$sectionOld->load( $sectionMove );

	// clean any existing cache files
	mosCache::cleanCache( 'com_content' );

	$msg = 'La section '. $sectionOld-> name .' et toutes ses catégories et articles a été copiée en tant que '. $title;
	mosRedirect( 'index2.php?option=com_sections&scope=content&mosmsg='. $msg );
}

function menuLink( $id ) {
	global $database;

	$section = new mosSection( $database );
	$section->bind( $_POST );
	$section->checkin();

	$menu 	= strval( mosGetParam( $_POST, 'menuselect', '' ) );
	$name 	= strval( mosGetParam( $_POST, 'link_name', '' ) );
	$type 	= strval( mosGetParam( $_POST, 'link_type', '' ) );

	$name	= stripslashes( ampReplace($name) );

	switch ( $type ) {
		case 'content_section':
			$link 		= 'index.php?option=com_content&task=section&id='. $id;
			$menutype	= 'Tableau - Section de contenu';
			break;

		case 'content_blog_section':
			$link 		= 'index.php?option=com_content&task=blogsection&id='. $id;
			$menutype	= 'Blog - Section de contenu';
			break;

		case 'content_archive_section':
			$link 		= 'index.php?option=com_content&task=archivesection&id='. $id;
			$menutype	= 'Blog - Archive de section ';
			break;
	}

	$row 				= new mosMenu( $database );
	$row->menutype 		= $menu;
	$row->name 			= $name;
	$row->type 			= $type;
	$row->published		= 1;
	$row->componentid	= $id;
	$row->link			= $link;
	$row->ordering		= 9999;

	if ( $type == 'content_blog_section' ) {
		$row->params = 'sectionid='. $id;
	}

	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$row->updateOrder( "menutype = '$menu'" );

	// clean any existing cache files
	mosCache::cleanCache( 'com_content' );

	$msg = $name .' ( '. $menutype .' ) dans le menu: '. $menu .' créé avec succès';
	mosRedirect( 'index2.php?option=com_sections&scope=content&task=editA&hidemainmenu=1&id='. $id,  $msg );
}

function recursive_listdir( $base ) {
	static $filelist = array();
	static $dirlist = array();

	if(is_dir($base)) {
		$dh = opendir($base);
		while (false !== ($dir = readdir($dh))) {
			if (is_dir($base .'/'. $dir) && $dir !== '.' && $dir !== '..' && strtolower($dir) !== 'cvs' && strtolower($dir) !== '.svn') {
				$subbase = $base .'/'. $dir;
				$dirlist[] = $subbase;
				$subdirlist = recursive_listdir($subbase);
			}
		}
		closedir($dh);
	}
	return $dirlist;
}
?>
