<?php
/**
* Movie Stats
*/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all'))) {
	mosRedirect('index2.php', _NOT_AUTH);
}

function showConfig( $option ) {
	global $database, $mainframe, $my, $acl, $mosConfig_list_limit;

	$limit = intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	$limitstart = intval( $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 ) );

// en fonction de la requete effectuee
	$query = "select count(id)";
	$query .= " from #__moviestats_langue";
	$database->setQuery( $query );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$query = "select *";
	$query .= " from #__moviestats_langue";
	$query .= " order by id asc";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_config::displayConfig( $rows, $pageNav, $option );
}


function saveConfig($option) {
	global $config, $setup, $my;

    for ($i=1; $i<count($setup->SETUP_GLOBAL); $i++) {
		$name = $setup->SETUP_GLOBAL[$i]['name'];

		if(isset($_POST[$name])) {
			if ($name == 'adultgenres') {
				$value = @join('::', $_POST['adultgenres']);
			} else {
				$value=$_POST[$name];
			}

			if ($value) {
				if($_SESSION['ms']['config'][$name]!=$value) {
					$value = addslashes($value);
					db_setConfigOption($name, $value);
				}
			} else {
				if ($setup->SETUP_GLOBAL[$i]['type'] == 'boolean') {
					$value = 1;
					db_setConfigOption($name, $value);
				} else {
					$value="";
					db_setConfigOption($name, $value);
				}
			}
		} else {
			if ($setup->SETUP_GLOBAL[$i]['type'] == 'boolean') {

				$config['enginedefault']=$_POST['enginedefault'];
				$value = ($name == 'engine'.$config['enginedefault']) ? 1 : 0;
				db_setConfigOption($name, $value);
			} else {
				if ($name == 'languageflags') {
					$value = @join('::', $_POST['languages']);
				}
				db_setConfigOption($name, $value);
			}
		}
	}

	foreach ($_POST as $key=>$value) {
		if (substr($key,0,6) == 'custom') {
			if($_SESSION['ms']['config'][$key]!=$value) {
				db_setConfigOption($key, addslashes($value));
			}
		}
	}

    // remove user-specific config options
	$user_id = $my->id;
	if (!empty($user_id)) {
		db_deleteUserConfig(addslashes($user_id));
	}

	// reload config
	$setup->loadConfig();
	mosRedirect("index2.php?option=$option&task=config");

}
?>