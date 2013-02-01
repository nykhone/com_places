<?php
/**
* Movie Stats
**/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $database, $mosConfig_absolute_path;
//include_once ($mosConfig_absolute_path.'/components/com_places/config.inc.php');

class menu_places {

	function SECTION_EDIT() {
		global $id;

		mosMenuBar::startTable();
		mosMenuBar::save('section_save', 'Save');
		mosMenuBar::spacer();
		mosMenuBar::apply('section_apply', 'Apply');
		mosMenuBar::spacer();
		if ( $id ) {
			mosMenuBar::cancel( 'section_cancel', 'Close' );
		} else {
			mosMenuBar::cancel('section_cancel');
		}
		mosMenuBar::endTable();
	}

	function SECTION_COPY() {
		mosMenuBar::startTable();
		mosMenuBar::save( 'copysave' );
		mosMenuBar::spacer();
		mosMenuBar::cancel('section_cancel');
		mosMenuBar::endTable();
	}

	function SECTION_DEFAULT(){
		mosMenuBar::startTable();
		mosMenuBar::customX( 'section_copyselect', 'copy.png', 'copy_f2.png', 'Copier', true );
		mosMenuBar::spacer();
		mosMenuBar::deleteList('', 'section_remove', 'Remove');
		mosMenuBar::spacer();
		mosMenuBar::editListX('section_edit', 'Edit');
		mosMenuBar::spacer();
		mosMenuBar::addNewX('section_new', 'New');
		mosMenuBar::endTable();
	}

	function MENU_ABOUT(){
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_PAYS(){
		mosMenuBar::startTable();
		mosMenuBar::save('pays');
		mosMenuBar::spacer();
		mosMenuBar::deleteList('','remove_pays');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_VILLE(){
		mosMenuBar::startTable();
		mosMenuBar::save('ville');
		mosMenuBar::spacer();
		mosMenuBar::deleteList('','remove_ville');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_LIEU(){
		mosMenuBar::startTable();
		mosMenuBar::save('lieu');
		mosMenuBar::spacer();
		mosMenuBar::deleteList('','remove_lieu');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_LANGUE(){
		mosMenuBar::startTable();
		mosMenuBar::save('langue');
		mosMenuBar::spacer();
		mosMenuBar::deleteList('','remove_langue');
		mosMenuBar::spacer();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::endTable();
	}

// non utilises

	function MENU_CONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::save('save_config');
		mosMenuBar::custom('manage', "search.png", "search_f2.png",  _places_SEARCH, false);
		mosMenuBar::cancel('stat');
		//mosMenuBar::help(./components/com_places/help/1.html);
		mosMenuBar::endTable();
	}

	function MENU_CATEGORIES(){
		mosMenuBar::startTable();
		mosMenuBar::save('categories');
		mosMenuBar::deleteList();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_STAT(){
		mosMenuBar::startTable();
		mosMenuBar::custom('manage', "search.png", "search_f2.png",  _places_SEARCH, false);
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function MENU_MANAGE(){
		mosMenuBar::startTable();
		mosMenuBar::addNew();
		mosMenuBar::custom('stat', "preview.png", "preview_f2.png", _places_STAT, false);
		mosMenuBar::back();
		mosMenuBar::endTable();
	}
}
?>