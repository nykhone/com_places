<?php

/**
* Places
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

// vérifie que user peut accèder administration
if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all'))) {
	mosRedirect('index2.php', _NOT_AUTH);
}

global $option, $mosConfig_absolute_path;

$index = 'index2.php';

require_once ($mosConfig_absolute_path.'/administrator/components/com_places/core/places.class.php');
//require_once (ADMIN_PATH.'templates/admin.css.php');
require_once( ADMIN_PATH.'core/header_footer.html.php' );

switch ($task) {

	case 'section_new':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		editSection( 0, $option );
		break;

	case 'section_edit':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		editSection( intval( $cid[0] ), $option );
		break;

	case 'section_editA':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		editSection( $id, $option );
		break;

	case 'section_save':
	case 'section_apply':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		saveSection( $option, $scope, $task );
		break;

	case 'section_remove':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		removeSections( $cid, $option );
		break;

	case 'section_section_copyselect':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		copySectionSelect( $option, $cid, $section );
		break;

	case 'section_copysave':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		copySectionSave( $cid );
		break;

	case 'section':
	case 'section_cancel':
		require_once (ADMIN_PATH.'core/sections.php');
		require_once (ADMIN_PATH.'core/sections.html.php');
		showSections( $option );
		break;

//	case 'manage':
//		require_once (ADMIN_PATH.'core/filter.php');
//		require_once (ADMIN_PATH.'core/filter.html.php');
//		filter($option, $index);
//		displayFilter($option, $index);
//		break;

//	case 'save_config':
//		require_once (ADMIN_PATH.'core/config.php');
//		saveConfig($option);
//		break;

	case 'config':
		require_once (ADMIN_PATH.'core/config.php');
		require_once (ADMIN_PATH.'core/config.html.php');
		showConfig($option);
		break;

	case 'import';
		require_once (ADMIN_PATH.'core/import.html.php');
		import($option);
		break;

	case 'remove_pays';
	case 'pays';
		require_once (ADMIN_PATH.'core/pays.php');
		require_once (ADMIN_PATH.'core/pays.html.php');
		managePays($option);
		break;

	case 'remove_ville';
	case 'ville';
		require_once (ADMIN_PATH.'core/ville.php');
		require_once (ADMIN_PATH.'core/ville.html.php');
		manageVille($option);
		break;

	case 'remove_lieu';
	case 'lieu';
		require_once (ADMIN_PATH.'core/lieu.php');
		require_once (ADMIN_PATH.'core/lieu.html.php');
		manageLieu($option);
		break;

	default:
		break;
}

?>