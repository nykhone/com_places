<?php
/**
* Movie Stats
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );
global $task;

switch ($task) {

	case 'section_new':
	case 'section_edit':
	case 'section_editA':
		menu_places::SECTION_EDIT();
		break;

	case 'section_copyselect':
		menu_places::SECTION_COPY();
		break;

	case 'section':
	case 'section_go2menu':
	case 'section_go2menuitem':
	case 'section_menulink':
	case 'section_save':
	case 'section_apply':
	case 'section_remove':
	case 'section_section_copyselect':
	case 'section_copysave':
	case 'section_cancel':
		menu_places::SECTION_DEFAULT();
		break;

//	case "config":
//		menu_places::MENU_CONFIG();
//		break;

//	case "remove":
//	case "categories":
//		menu_places::MENU_CATEGORIES();
//		break;

//	case "stat":
//		menu_places::MENU_STAT();
//		break;

//	case "search":
//		menu_places::MENU_SEARCH();
//		break;

	case "about":
		menu_places::MENU_ABOUT();
		break;

	case "remove_pays":
	case "pays":
		menu_places::MENU_PAYS();
		break;

	case "remove_ville":
	case "ville":
		menu_places::MENU_VILLE();
		break;

	case "remove_lieu":
	case "lieu":
		menu_places::MENU_LIEU();
		break;

	case "remove_langue":
	case "langue":
		menu_places::MENU_LANGUE();
		break;

	default:
		menu_places::MENU_DEFAULT();
		break;
}

?>