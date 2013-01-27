<?php
/**
* Places
**/

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

global $mosConfig_absolute_path, $mosConfig_live_site, $config, $index;

define ('USER_PATH' , $mosConfig_absolute_path.'/components/com_places/');
define ('ADMIN_PATH', $mosConfig_absolute_path.'/administrator/components/com_places/');
define ('IMAGE_PATH', $mosConfig_live_site.'/administrator/components/com_places/images/');
define ('FLAG_PATH', $mosConfig_live_site.'/administrator/components/com_places/images/flags/');

// Config file
//define ('CONFIG_FILE', USER_PATH.'config.inc.php');
//include_once (CONFIG_FILE);

define ('REL_VERSION', $config['release']['version']);
define ('REL_DATE', $config['release']['date']);

// Table names
define('TBL_DATA',          $config['db_prefix'].'videodata');
define('TBL_CONFIG',        $config['db_prefix'].(empty($config['conf_table']) ? 'config' : $config['conf_table']));
define('TBL_USERCONFIG',    $config['db_prefix'].'userconfig');
// -------- db v.17 -----------
define('TBL_PDATA',         $config['db_prefix'].'persondata');
define('TBL_STAT',			$config['db_prefix'].'stat');
// ----------------------------

// Required database version
define('DB_REQUIRED',		17);
define('DEBUG',				$config['debug']);

// Database functions
include_once(ADMIN_PATH.'core/places.class.db.php');

include_once(ADMIN_PATH.'core/google_maps.class.php');

//Set vars depending on activ panel (USER or ADMIN)
$upanel = ($index == 'index.php') ? true : false;

$setup = new VideoDBSetup(true);
$config = $_SESSION['ms']['config'];

// simplified '^["\\\' ]*[^ABCabcÄäDEFdefGHIghiJKLjklMNOmnoÖöPQRSpqrsTUVtuvÜüßWXZwxy"\\\' ]',
$filter_expr = array(
	'0-9' => '^["\\\' ]*[0-9]',
	'A' => '^["\\\' ]*[Aa]',
	'B' => '^["\\\' ]*[Bb]',
	'C' => '^["\\\' ]*[Cc]',
	'D' => '^["\\\' ]*[Dd]',
	'E' => '^["\\\' ]*[Ee]',
	'F' => '^["\\\' ]*[Ff]',
	'G' => '^["\\\' ]*[Gg]',
	'H' => '^["\\\' ]*[Hh]',
	'I' => '^["\\\' ]*[Ii]',
	'J' => '^["\\\' ]*[Jj]',
	'K' => '^["\\\' ]*[Kk]',
	'L' => '^["\\\' ]*[Ll]',
	'M' => '^["\\\' ]*[Mm]',
	'N' => '^["\\\' ]*[Nn]',
	'O' => '^["\\\' ]*[OoÖö]',
	'P' => '^["\\\' ]*[Pp]',
	'Q' => '^["\\\' ]*[Qq]',
	'R' => '^["\\\' ]*[Rr]',
	'S' => '^["\\\' ]*[Ssß]',
	'T' => '^["\\\' ]*[Tt]',
	'U' => '^["\\\' ]*[UuÜü]',
	'V' => '^["\\\' ]*[Vv]',
	'W' => '^["\\\' ]*[Ww]',
	'X' => '^["\\\' ]*[Xx]',
	'Y' => '^["\\\' ]*[Yy]',
	'Z' => '^["\\\' ]*[Zz]',
	'all'	 => 'all',
	'unseen' => 'unseen',
	'new'	 => 'new',
	'wanted' => 'wanted'
);

$_SESSION['ms']['filters']  = $filter_expr;

class VideoDBSetup {

	/**
	 * Functions for config options
	 *
	 * @package Core
	 * @author  Andreas Gohr    <a.gohr@web.de>
	 * @version $Id: setupfunctions.php,v 1.19 2005/05/06 09:10:33 andig2 Exp $
	 * require_once './core/functions.php';
	 * require_once './core/custom.php';
	 * require_once './core/output.php';
	 */

	var $SETUP_GLOBAL;		/* ustawianie konfiguracji */
	var $SETUP_USER;
	var $allcustomtypes;	/* This array contains all available types - be sure to add your type if
							   you ad a new one */

	/**
	 * Load config options from config.inc.php and database and
	 * setup sane defaults.
	 * Return configuration in global $config array variable
	 *
	 * @todo    Add security check if install.php is still available
	 * @param   boolean force reload of configuration data
	 */
	function VideoDBSetup($force_reload = false)
	{
		/**
		 * Constants
		 *
		 * Contains global constants for table names
		 * Must only be loaded after config.inc.php
		 *
		 * @package Core
		 * @author  Andreas Goetz   <cpuidle@gmx.de>
		 * @version $Id: constants.php,v 1.11 2005/10/11 22:19:00 andig2 Exp $
		 */

		$this->SETUP_GLOBAL		= array();

		$this->loadConfig();
		$this->ConfigSetup($_SESSION['ms']['config'],$force_reload);
	}

	/**
	 * Load config options from config.inc.php and database and
	 * setup sane defaults.
	 * Return configuration in global $config array variable
	 *
	 * @todo    Add security check if install.php is still available
	 * @param   boolean force reload of configuration data
	 */
	function loadConfig() {
		global $config, $my, $upanel;

		// get config options from the database
//		$result = db_loadConfig();

		// put db results into global config array
//		foreach ($result as $option) {
//			$config[$option['opt']] = $option['value'];
//		}

		// check if database matches the current version
//		if ($config['dbversion'] < DB_REQUIRED) {

//			$version = array (
//				'dbver'		=> $config['dbversion'],
//				'softver'	=> DB_REQUIRED
//			);

			// run installer
//			$res = false;
//			require_once (ADMIN_PATH."core/places.class.xml.php");
//			$res = xmlimport(ADMIN_PATH.'upgrade/mod_db17.xml', 'upgradeVDB', $version, $error, $report);

//			if ($res === false) {
//				echo LOAD_CONF_ERR1."<br />$error";
//			} else {
//				$cd = db_clearActors();
//				echo LOAD_CONF_KOM2."[ $cd ]<br />";

//				db_upgradeVideodbMenu();
//				echo LOAD_CONF_KOM1."<br />$report";

				// create cache directory
//				if (!is_dir(USER_PATH.'cache/imdb')) mkdir(USER_PATH.'cache/imdb',0777);
//				if (!is_dir(USER_PATH.'cache/movie')) mkdir(USER_PATH.'cache/movie',0777);
//				if (!is_dir(USER_PATH.'cache/person')) mkdir(USER_PATH.'cache/person',0777);

				// remove old files
//				if (file_exists(ADMIN_PATH.'admin.places.class.php')) unlink(ADMIN_PATH.'admin.places.class.php');
//				if (file_exists(ADMIN_PATH.'admin.places.class.xml.php')) unlink(ADMIN_PATH.'admin.places.class.xml.php');
//			}
//		}

		// get user config options from the database
//		$user_id = $my->id;
//		if (!empty($user_id)) {
//			$result = db_getUserConfig($user_id);
//			if (count($result))	{
//				foreach ($result as $option) {
//					$config[$option['opt']] = $option['value'];
//				}
//			}
//		}

		// set some defaults
		if (empty($config['template'])) $config['template'] = 'compact';
		if (empty($config['filterdefault'])) $config['filterdefault'] = 'new';

		if ($config['IMDBage']		< 1) $config['IMDBage']      = 60*60*24*5;
		if ($config['castcolumns']	< 1) $config['castcolumns']  = 4;
		if ($config['listcolumns']	< 1) $config['listcolumns']  = 1;
		if ($config['thumbAge']		< 1) $config['thumbAge']     = 60*60*24*7*3;
		if ($config['shownew']		< 1) $config['shownew']      = 12;
		if ($config['guestid']		< 1) $config['guestid']      = 10000;

		// prepare template/style
		$config['templatedir']  = ADMIN_PATH.'templates/';
		$config['style']        = $config['templatedir'].$config['template'].'.css';

		// cacheid for multiuser mode
		$config['cacheid']      = $config['template'];

		// check if selected template is valid
		if (!file_exists($config['style'])) {
			$config['template']    = 'compact';
			$config['templatedir'] = ADMIN_PATH.'templates/';
			$config['style']       = $config['templatedir'].'compact.css';
		}

		// added proxy support for $_ENV
		$proxy = $config['proxy_host'];
		if (empty($proxy)) {
			$env = array_change_key_case($_ENV);
			$proxy = $env['http_proxy'];
		}
		if (!empty($proxy)) {
			$uri = parse_url($proxy);
			$config['proxy_host'] = ($uri['scheme']) ? $uri['host'] : $uri['path'];
			$config['proxy_port'] = ($uri['port']) ? $uri['port'] : 8080;
		}

		// store loaded configuration
        $_SESSION['ms']['config'] = $config;
	}

	/**
	 * build config options array
	 *
	 * returns associative array of config options
	 *
	 * @param boolean   $isprofile  Determines if user-specific options are to be displayed
	 * function setup_mkOptions($isprofile = false)
	 */
	function ConfigSetup (&$config,$isprofile = false) {

		// built list of setup options
		$setup = array();

		// isprofile, name, type (text|boolean|dropdown|special|link|multi), data, set, helphl, helptxt
		$this->setup_addSection($setup, 'opt_general',_OPT_GENERAL);
		$this->setup_addOption($setup, $isprofile, 'msname', 'text', null, null, _VDBNAMEN, _VDBNAMEO);
		$this->setup_addOption($setup, $isprofile, 'userinterface', 'boolean', null, null, _USERINTERFACEN, _USERINTERFACEO);
		$this->setup_addOption($setup, $isprofile, 'easyfilter', 'boolean', null, null, _EASYFILTERN, _EASYFILTERO);
		//$this->setup_addOption($setup, $isprofile, 'template', 'dropdown', $this->setup_getTemplates(), null, _TEMPLATEN, _TEMPLATEO);
		$this->setup_addOption($setup, $isprofile, 'plusminus', 'boolean', null, null, _PLUSMINUSN, _PLUSMINUSO);
		$this->setup_addOption($setup, $isprofile, 'listcolumns', 'text', null, null, _LISTCOLUMNSN, _LISTCOLUMNSO);
		$this->setup_addOption($setup, $isprofile, 'castcolumns', 'text', null, null, _CASTCOLUMNSN, _CASTCOLUMNSO);
		$this->setup_addOption($setup, $isprofile, 'filterdefault', 'dropdown', array('all'=>_ALL, 'unseen'=>_UNSEEN, 'new'=>_NEW, 'wanted'=>_WANTED), null, _FILTERDEFAULTN, _FILTERDEFAULTO);
		$this->setup_addOption($setup, $isprofile, 'orderallbydisk', 'boolean', null, null, _ORDERALLBYDISKN, _ORDERALLBYDISKO);
		$this->setup_addOption($setup, $isprofile, 'shownew', 'text', null, null, _SHOWNEWN, _SHOWNEWO);
		$this->setup_addOption($setup, $isprofile, 'pageno', 'text', null, null, _PAGENON, _PAGENOO);

		$this->setup_addSection($setup, 'opt_security',_OPT_SECURITY);
		$this->setup_addOption($setup, $isprofile, 'autoregister', 'boolean', null, null, _AUTOREGISTER, _AUTOREGISTERO);
		$this->setup_addOption($setup, $isprofile, 'proxy_host', 'text', null, null, _PROXY_HOSTN, _PROXY_HOSTO);
		$this->setup_addOption($setup, $isprofile, 'proxy_port', 'text', null, null, _PROXY_PORTN, _PROXY_PORTO);

		$this->setup_addSection($setup, 'opt_places',_OPT_IMPEXP);
		$this->setup_addOption($setup, $isprofile, 'ms_host', 'text', null, null, _VDB_HOSTN, _VDB_HOSTO);
		$this->setup_addOption($setup, $isprofile, 'ms_name', 'text', null, null, _VDB_NAMEN, _VDB_NAMEO);
		$this->setup_addOption($setup, $isprofile, 'ms_user', 'text', null, null, _VDB_USERN, _VDB_USERO);
		$this->setup_addOption($setup, $isprofile, 'ms_psswd', 'text', null, null, _VDB_PASSWDN, _VDB_PASSWDO);

		$this->setup_addSection($setup, 'opt_log',_OPT_STAT);
		$this->setup_addOption($setup, $isprofile, 'log_director', 'boolean', null, null, _STAT_DIRN, _STAT_DIRO);
		$this->setup_addOption($setup, $isprofile, 'log_actor', 'boolean', null, null, _STAT_ACTORN, _STAT_ACTORO);
		$this->setup_addOption($setup, $isprofile, 'log_genre', 'boolean', null, null, _STAT_GENREN, _STAT_GENREO);
		$this->setup_addOption($setup, $isprofile, 'log_video', 'boolean', null, null, _STAT_VIDEON, _STAT_VIDEOO);
		$this->setup_addOption($setup, $isprofile, 'log_user', 'boolean', null, null, _STAT_USERN, _STAT_USERO);
		$this->setup_addOption($setup, $isprofile, 'log_count', 'text', null, null, _STAT_LCOUNTN, _STAT_LCOUNTO);
		$this->setup_addOption($setup, $isprofile, 'log_func', 'boolean', null, null, _STAT_FUNCN, _STAT_FUNCO);

		// store loaded configuration
		$this->SETUP_GLOBAL=$setup;
	}

	/**
	 * Add a new section to the config options array
	 *
	 * @param array   $setup      The config array
	 * @param string  $section    Name of the new section
	 */
	function setup_addSection(&$setup, $section,$name) {
		$option[0]['group'] = $section;
		$option[1]['name']	= $name;
		$setup[]            = $option;
	}

	/**
	 * Adds an entry for the config option array
	 *
	 * returns NULL on global options if $isprofile is true
	 * so global options will not be added to user profile settings
	 *
	 * @param array   $setup      The config array
	 * @param boolean $isprofile  Do we prepare a profile array?
	 * @param string  $name       Name of the config option
	 * @param string  $type       Type of option (text|boolean|dropdown|special|link)
	 * @param string  $data       Current value of this option
	 * @param string  $set        Default value of this option
	 * @param string  $hl         Help text headline
	 * @param string  $help       Help text
	 */
	function setup_addOption(&$setup, $isprofile, $name, $type, $data='', $set=NULL, $hl=NULL, $help=NULL) {
		global $lang;

		// user-specific setting?
//		$isuser = in_array($name, $this->SETUP_USER);

		//if ($isprofile and !$isuser) return;
//		$option['isuser']   = $isuser;
		$option['name']     = $name;
		$option['type']     = $type;
		$option['data']     = $data;
		$option['set']		= ($set)  ? $set  : $_SESSION['ms']['config'][$name];
		$option['hl']		= ($hl)   ? $hl   : $lang['help_'.$name.'n'];
		$option['help']		= ($help) ? $help : $lang['help_'.$name];

		$setup[] = $option;
	}

	/**
	 * Find available templates/styles
	 */
	function setup_getTemplates() {
		$matches = array();
		if ($dh = @opendir(ADMIN_PATH.'templates')) {
			while (($file = readdir($dh)) !== false) {
				if (preg_match("/^\./", $file)) continue;
				if (is_dir(ADMIN_PATH.'templates/'.$file)) {
					if ($dh2 = opendir(ADMIN_PATH.'templates/'.$file)) {
						while (($style = readdir($dh2)) !== false) {
							if (preg_match("/(.*)\.css$/", $style, $matches)) {
								$templates[$file.'::'.$matches[1]] = $file.' ('.$matches[1].')';
							}
						}
						closedir($dh2);
					}
				}
			}
			closedir($dh);
		}
		return $templates;
	}


// -----------------------------------
// --> Pays
// -----------------------------------
//function setup_getPays() {
//	$result = db_getPays();
//	foreach($result as $row) {
//		$pays[$row['id']] = $row['name'];
//	}
//	return $pays;
//}

}

function formvar($name) {
	if (get_magic_quotes_gpc()) {
		$name = stripslashes($name);
	}
	return htmlspecialchars($name);
}

/**
 * Checks if the page is accessed from within the local net.
 *
 * @return  bool  true if localnet
 */
function localnet() {
	global $config;
	return (preg_match('/'.$config['localnet'].'/', $_SERVER['REMOTE_ADDR']));
}

/**
 * Searchquerystring Parser
 *
 * Parses a search query into it's tokens kann detect + - AND OR NOT Operators
 * and Phrases.
 *
 * @todo    remove german errorstrings, maybe handle umlauts and stuff...
 *
 * @package Search
 * @author  Andreas Gohr    <a.gohr@web.de>
 * @version $Id: queryparser.php,v 1.8 2005/04/29 06:09:19 andig2 Exp $
 */

/**
 * Querystringparser
 *
 * Parses a querystring into a datastructure
 *
 * @param   string  $query    Querystring
 * @param   string  &$errors  Stringreference to write errors back
 * @return  array             parsed querytokens
 */
function queryparser($query, &$errors) {
    $query	= trim($query);
    $ops    = array();
    $struct = array();
    $tokens	= tokenizer($query);

    // look through tokens
    while ($current = array_shift($tokens)) {
		if (preg_match('/^(AND|OR|NOT)$/i', $current)) {
            // token is operator
            $ops[] = strtoupper($current);
        } else {
            // token is searchword
            if (!count($ops)) {
                // empty operator counts as AND
                $ops[] = 'AND';
            }

            // clean invalid operators
            $cleanops = cleanoperators($ops, $errors);

            // check wildcards
            $wild = '';
            if (substr($current,0,1) == '*') $wild .= 'l';
            if (substr($current, -1) == '*') $wild .= 'r';
            $current    = str_replace('*', '', $current);
            $struct[]   = array('ops'      => $cleanops,
                                'token'    => $current,
                                'wildcard' => $wild);
            $ops = array();
        }
    }
    return $struct;
}

/**
 * Querystring tokenizer
 *
 * Parse string into array of tokens.
 * Honors literal expressions enclosed by "",
 * converts +/- to AND and NOT
 *
 * @param   string    Querystring
 * @return  array     All tokens of the Strings
 */
function tokenizer($qstring) {
    // replace +/- with AND and NOT
    $qstring = ' '.$qstring; // for following regexps
    $qstring = preg_replace('/(\s)-(\S)/',  '\1NOT \2', $qstring);
    $qstring = preg_replace('/(\s)\+(\S)/', '\1AND \2', $qstring);
    $qstring = preg_replace('/(\")/', '', $qstring);
    $qstring = trim($qstring);

    $tokens  = array();
    $current = '';
    $sep     = '\s';

    for ($i=0; $i < strlen($qstring); $i++) {
        $char = $qstring{$i};

        // match current separator?
        if (preg_match("/$sep/", $char)) {
            $current = trim($current);
            if (!empty($current) AND ((str_replace('*', '', $current)) != '')) {
                // add non-empty token
                $tokens[] = $current;
            }
            $current    = '';
            $sep		= '\s';
        }

        // begin literal expression?
        elseif ($char == '"' || $char =='\\') {
            $sep = '"';
        }

        // normal token character
        else {
            $current .= $char;
		}
    }

    // add remaining token
    $current = trim($current);

    if (!empty($current) AND ((str_replace('*','',$current))!='')) {
        $tokens[] = $current;
    }
    return $tokens;
}

/**
 * Operator cleaning
 *
 * removes illogical operator combinations...
 *
 * @param   array   Operators
 * @param   string  Stringreference to write errors back
 * @return  string  cleaned Operators
 */
function cleanoperators($ops, &$errors) {
    $newops = array();

    // make unique
    $ops = array_unique($ops);

    // sort
    if (in_array('AND', $ops))  $newops[] = 'AND';
    if (in_array('OR', $ops))   $newops[] = 'OR';
    if (in_array('NOT', $ops))  $newops[] = 'NOT';

    // join
    $opstr = join(' ', $newops);

    // clean unnormal conditions
    if (strstr($opstr, 'AND OR')) {
        $errors	.="Die logische Verknüpfung 'AND OR' ist nicht erlaubt und wurde in 'OR' umgewandelt.\n";
        $opstr	 = str_replace('AND OR', 'OR', $opstr);
    }
    if (strstr($opstr, 'OR NOT')) {
        $errors	.="Die logische Verknüpfung 'OR NOT' ist nicht erlaubt und wurde in 'AND' umgewandelt.\n";
        $opstr	 = str_replace('OR NOT', 'AND', $opstr);
    }
    if ($opstr == 'NOT') $opstr = 'AND NOT';
    return $opstr;
}

/**
 * Convert SQL result array into associative key=>value array
 *
 * @param   $key    key index name
 * @param   $value  value index name
 * @param   $result SQL result array
 * @return  array   resulting associative array
 */
function associateResultSet($key, $value, &$result) {
    $ary = array();
    foreach ($result as $row) {
        $ary[$row[$key]] = $row[$value];
    }
	return $ary;
}


/**
 * Converts keys of an array to MySQL compatible list
 *
 * @author  Chinamann <chinamann@users.sourceforge.net>
 * @param   Array   $owners        Array from out_owners
 * @param   boolean $isString      return list of strings?
 * @return  string                 MySQL compatible list
 */
function owners2list($owners, $isString = true) {
    if ($isString) return "'".join("', '", array_keys($owners))."'";
    else return join(", ", array_keys($owners));
}

/**
 * Tries to find the given image in template directory then in the default
 * image directory.
 *
 * @param  string  filename of image
 * @return string  path to the image
 */
function img($img) {
	global $config;

	$result = ADMIN_PATH.'images/'.$img;
	//if (file_exists($config['templatedir'].$result)) $result = $config['templatedir'].$result;
	//return ($result);  // oryginalnie
	if (file_exists($result)) return IMAGE_PATH.$img;
	else return ('');
}

/**
 * Image loader
 *
 * Loads an image from the net and creates a chachefile for it.
 *
 * @package videoDB
 * @author  Andreas Gohr    <a.gohr@web.de>
 * @version $Id: img.php,v 2.19 2005/05/20 09:57:45 andig2 Exp $
 */

function getimg($sw, $text, $actorid = 0, $folder='img') {

	switch ($sw) {
		case 'name':
			$name = $text;
			$url = '';
			break;
		case 'url' :
			$url = $text;
			$name = '';
			break;
	}

	// Get imgurl for the actor
	//echo '<br />name='.$name.' url='.$url. ' actorid='.$actorid;
	if ($name) {
		// name given
		//$name   = html_entity_decode($name);
		$engine = engineGetEngine($actorid);
		$func = $engine.'Actor';
		$result = $func($name, $actorid);
		$url    = $result[0][1];
		//echo '<br />name='.$name.'  -  url='.$url.'<br />';

		if (preg_match('/nohs(-[f|m])?.gif$/', $url)) {
			// imdb no-image picture
			$url = '';
		}

		// write actor last checked record
		 db_setActorChecked(addslashes($name), addslashes($url), addslashes($actorid));
	}

	// Get image for the given url
	$matches = array();
	if (preg_match('/\.(jpe?g|gif|png)$/i', $url, $matches)) {

		//echo '<br />type='.$matches[1].' url='.$url;

		// construct cache file name
		$md5    = md5($url);
		$subdir = ''; //substr($md5, 0, 1).'/';
		$file   = USER_PATH.'cache/'.$folder.'/'.$subdir.$md5.'.'.$matches[1];
		if (download($url, $file)) {
			// cache created
			$data = $file;
		} else {
			// cache creation failed
			$data = img('nocover.gif');
		}
	} else {
		// no url given -> nopic
		$data = img('nocover.gif');
	}
	return $data;
}

/**
 * Downloads an URL to the given local file
 *
 * @param   string  $url    URL to download
 * @param   string  $local  Full path to save to
 * @return  bool            true on succes else false
 */
function download($url, $local) {
	$resp = httpClient($url);
	if (!$resp['success']) return false;
	return(@file_put_contents($local, $resp['data']) !== false);
}

/**
 * HTTP Client
 *
 * Returns the raw data from the given URL, uses proxy when configured
 * and follows redirects
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @param  string  $url      URL to fetch
 * @param  bool    $cache    use caching? defaults to false
 * @param  string  $post     POST data, if nonempty POST is used instead of GET
 * @param  integer $timeout  Timeout in seconds defaults to 15
 * @return mixed             HTTP response
 */
function httpClient($url, $cache=0, $post='', $timeout=15, $cookies = null, $headers2 = '') {
    global $config;

    // since we shouldn't don't need session functionality here,
    // use this as workaround for php bug #22526 session_start/popen hang
    //session_write_close();
    //echo"<br />HTTP Client=$url";
    $method = 'GET';
    $headers = '';  // additional HTTP headers, used for post data
    if (!empty($post)) {
        // POST request
        $method = 'POST';
        $headers .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $headers .= "Content-Length: ".strlen($post)."\r\n";
    }

    // get data from cache?
    if ($cache) {
        $resp = getHTTPcache($url.$post);
        if ($resp !== false) {
            return $resp;
        }
    }

    $response['error']  = '';
    $response['header'] = '';
    $response['data']   = '';
    $response['url']    = $url;
    $response['success']= false;

    $uri = parse_url($url);
    $server = $uri['host'];
    $path = $uri['path'];
    if (empty($path)) $path = '/'; #get root on empty path
    if (!empty($uri['query'])) $path .= '?'.$uri['query'];
    $port = $uri['port'];

    // proxy setup
    if (!empty($config['proxy_host'])) {
        $request_url = $url;
        $server      = $config['proxy_host'];
        $port        = $config['proxy_port'];
        if (empty($port)) $port = 8080;
    } else {
        $request_url = $path;  // cpuidle@gmx.de: use $path instead of $url if HTTP/1.0
        $server      = $server;
        if (empty($port)) $port = 80;
    }

    //print "<pre>$request_url</pre>";

    // open socket
    $socket = fsockopen($server, $port);
    if (!$socket) {
        $response['error'] = _HTTPCLIENT_ERR1;
        return $response;
    }
    socket_set_timeout($socket, $timeout);

    // build request
    $request  = "$method $request_url HTTP/1.0\r\n";
    $request .= "Host: ".$uri['host']."\r\n";
    $request .= "User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows 98)\r\n";
    if (extension_loaded('zlib')) $request .= "Accept-encoding: gzip\r\n";
    if ($cookies) $request .= cookies2header($cookies);
    $request .= "Connection: Close\r\n";
    $request .= $headers;
    $request .= $headers2;
    $request .= "\r\n";
    $request .= $post;

    // send request
    fputs($socket, $request);

    if ($config['debug']) echo "request:<br>".nl2br($request)."<p>";

    // log request
    if ($config['httpclientlog']) {
        $log = fopen('httpClient.log', 'a');
        fwrite($log, $request."\n");
        fclose($log);
    }

    // read headers from socket
    do {
        $response['header'] .= fread($socket,1);
    }
    while(!preg_match('/\r\n\r\n$/',$response['header']));

    // chunked encoding?
    if (preg_match('/transfer\-(en)?coding:\s+chunked\r\n/i',$response['header'])) {
        do {
            unset($chunk_size);
            do {
                $byte = fread($socket,1);
                $chunk_size .= $byte;
            }
            while (preg_match('/[a-zA-Z0-9]/',$byte)); // read chunksize including \r

            $byte = fread($socket,1);     // readtrailing \n
            $chunk_size = hexdec($chunk_size);
            $this_chunk = fread($socket,$chunk_size);
            $response['data'] .= $this_chunk;
            if ($chunk_size) $byte = fread($socket,2); // read trailing \r\n
        }
        while ($chunk_size);
    } else {
        // read entire socket
        while (!feof($socket)) {
            $response['data'] .= fread($socket,4096);
        }
    }

    // close socket
    $status = socket_get_status($socket);
    fclose($socket);

    if ($config['debug']) echo "header:<br>".nl2br($response['header'])."<p>";
    // if ($config['debug']) echo "data:<br>".htmlspecialchars($response['data'])."<p>";

    // check for timeout
    if ($status['timed_out']) {
        $response['error'] = _HTTPCLIENT_ERR2;
        return $response;
    }

    // log response
    if ($config['httpclientlog']) {
        $log = fopen('httpClient.log', 'a');
        fwrite($log, $response['header']."\n");
        fclose($log);
    }

    // check server status code to follow redirect
    $matches = array();
    if (preg_match("/^HTTP\/1.\d 30[12].*?\n/s", $response['header'])) {
        preg_match("/Location:\s+(.*?)\n/s",$response['header'],$matches);
        if (empty($matches[1])) {
            $response['error'] = _HTTPCLIENT_ERR3;
            return $response;
        } else {
            $location = trim($matches[1]);
            if (!preg_match("/^http/", $location)) $location = "http://".$uri['host'].$location;

            // don't use old headers again
            $headers	= '';

            // if this is a redirect, we must GET, not POST
            $post		= '';
            $_cookies = array();
            if (preg_match_all('/Set-Cookie:\s*(.+?);/', $response['header'], $_cookies, PREG_PATTERN_ORDER)) {
                foreach ($_cookies[1] as $cookie) {
                    // limit split to 2 elements (key/value)
                    list($key, $value) = split('=', $cookie, 2);
                    $cookies[$key] = $value;
                }
            }

            // perform redirected request
            $response = httpClient($location, $cache, $post, $timeout, $cookies);

            // remember we were redirected
            $response['redirect'] = $location;

            if ($response['success'] == true && $cache) saveHTTPcache($url.$post, $response);

            return $response;
        }
    }

    // verify status code
    if (!preg_match("/^.*? 200 .*?\n/s",$response['header'])) {
        $response['error'] = _HTTPCLIENT_ERR4;
        return $response;
    }

    $response['success'] = true;

    // decode data if necessary- do not modify original headers
    if (preg_match("/Content-Encoding:\s+gzip\r?\n/i", $response['header'])) {
        $response['data'] = gzdecode($response['data']);
    }

    // commit succesful request to cache
    if ($cache) saveHTTPcache($url.$post, $response);
    return $response;
}

// convert cookies to http header
function cookies2header($cookies) {
    global $request_cookies;

    // concatenate cookie string
	foreach ($cookies as $key => $val) {
        // remember cookies for next request
        $request_cookies[$key] = $val;

        if ($headers) $headers .= '; ';
        $headers .= $key.'='.$val;
    }

    // build header
    if ($headers) $headers = 'Cookie: '.$headers."\r\n";
    return $headers;
}

// decode content-encoding: gzip
function gzdecode(&$string) {
	return gzinflate(substr($string, 10));
}

//=============== security.php ===========================================
 /**
 * Security functions
 *
 * @package Core
 * @author  Andreas Goetz   <cpuidle@gmx.de>
 * @author  tREXX           <www.trexx.ch>
 * @version $Id: security.php,v 1.1 2005/01/05 15:20:04 andig2 Exp $
 */

/**
 * Allow these tags
 */
$allowedTags = '<h1><h2><h3><h4><b><strong><i><ol><ul><li><pre><hr><blockquote><img><image>'; //usunalem <a>

/**
 * Disallow these attributes/prefix within a tag
 */
$stripAttrib = 'javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|'.
               'onmousemove|onmouseout|onkeypress|onkeydown|onkeyup';

/**
 * @return string
 * @param string
 * @desc Strip forbidden attributes from a tag
 */
function removeEvilAttributes($tagSource) {
    global $stripAttrib;
    return stripslashes(preg_replace("/$stripAttrib/i", 'forbidden', $tagSource));
}

/**
 * @return string
 * @param string
 * @desc Strip forbidden tags and delegate tag-source check to removeEvilAttributes()
 */
function removeEvilTags($source) {
    global $allowedTags;
    $source = strip_tags($source, $allowedTags);
    return preg_replace('/<(.*?)>/ie', "'<'.removeEvilAttributes('\\1').'>'", $source);
}
//======================= end security.php ============================================

/**
 * Used to check permissions on a user for a page
 *
 * @author Mike Clark <Mike.Clark@Cinven.com>
 * @author Chinamann <chinamann@users.sourceforge.net>
 * @param  integer $permission Permission to check
 * @param  String  $destUserId UserId to access
 * @return boolean             True if permission exists else false
 */
function check_permission($permission, $destUserId = false) {
	return true;
}
/*    global $config, $my;

    if ($_SESSION['ms']['permissions']) $_SESSION['ms']['permissions'] = array();

    if ($config['multiuser']) return true;
    if (empty($my->id)) {
        // not logged in
        $permissions = 0;
    } else {
        if ($destUserId) $destString = (string)('DUID_'.$destUserId);
        else $destString = 'DUID_UNKNOWN';

        // Owner Level Permissions
        if (isset($_SESSION['ms']['permissions'][$destString])) {
            // permission cache
            $permissions = $_SESSION['ms']['permissions'][$destString];
        } else {
            //if ($config['multiuser']) {
                $userid = $my->id;
				$result = db_getGivenPermissions($userid, $destUserId);

                $permissions = 0;
                foreach ($result as $perm) {
                    $permissions |= $perm['permissions'];
                }
           //} else {
           // 	$permissions |= PERM_READ;
           // }

            $_SESSION['ms']['permissions'][$destString] = $permissions;
        }

        // User Level Permissions
        if (isset($_SESSION['ms']['permissions']['USERLEVEL'])) {
            $permissions |= $_SESSION['ms']['permissions']['USERLEVEL'];
        } else {

            $userid = $my->id;
			$result = db_getUserPermissions($userid);
            $_SESSION['ms']['permissions']['USERLEVEL'] = $result[0]['permissions'];
            $permissions |= $_SESSION['ms']['permissions']['USERLEVEL'];
        }
    }
    // check permissionbits
    return ($permissions & $permission);
}
*/

/**
 * Displays an errorpage and exits
 *
 * @param string $title   The pages headline
 * @param string $body    An additional message
 * Creates HTML
 */
function errorpage($title = 'Wystapi³ B£¡D', $body = '') {
    echo '<?xml version="1.0" encoding="pl"?>';
?>
    <html xmlns="http:// www.w3.org/1999/xhtml" xml:lang="pl" lang="pl" dir="ltr">
    <head>
        <title>VideoDB - ERROR</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
        <meta name="description" content="VideoDB" />
    </head>
    <body>
        <h1><?=$title?></h1>
        <?=$body?>
    </body>
    </html>
<?
	exit;
}

/**
 * Compatibility functions
 *
 * Borrowed simplified functions from PEAR module PHP_Compat
 *
 * @package Core
 * @author  Andreas Goetz   <cpuidle@gmx.de>
 * @link    http://pear.php.net PEAR
 * @version $Id: compatibility.php,v 1.6 2004/09/20 15:15:41 andig2 Exp $
 */

/**
 * Implements file_get_contents introduced in v4.3.0
 */
if (!function_exists('file_get_contents')) {
	function file_get_contents($filename) {
		$fh = @fopen($filename, 'rb');
		if (!$fh) return false;
		$content = fread($fh, filesize($filename));
		fclose($fh);
		return $content;
	}
}

/**
 * Implements file_put_contents introduced in v5.0.0
 */
if (!function_exists('file_put_contents'))
{
	function file_put_contents($filename, $content) {
		$fh = @fopen($filename, 'wb');
		if (!$fh) return false;
		if (!fwrite($fh, $content, strlen($content))) return false;
		fclose($fh);
		return true;
	}
}

/**
 * Implements html_entity_decode introduced in v4.3.0
 * @author <martin@swertcw.com>
 * @param   string  $string  HTML encoded string
 * @return  string           HTML decoded string
 */
if (!function_exists('html_entity_decode')) {
	function html_entity_decode($string) {
		$string = strtr($string, array_flip(get_html_translation_table(HTML_ENTITIES)));
		$string = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $string);
		return $string;
	}
}

/**
 * Implements http_build_query introduced in v5.0.0
 */
if (!function_exists('http_build_query')) {
	function http_build_query ($formdata, $numeric_prefix = null) {
		// Check we have an array to work with
		if (!is_array($formdata)) {
			return $formdata;
		}

		// Start building the query
		$tmp = array ();
		foreach ($formdata as $key => $val) {
			array_push($tmp, urlencode($key).'='.urlencode($val));
		}
		return implode('&', $tmp);
	}
}

/*
 * De-uniquify multi-language statistics
 *
 * Makes sure videos with mulitple languages are count once for each language
 * contained instead of once for a unique combination
 *
 * @param   array   $langs  array of all languages from
 */
function collapse_multiple_languages($langs) {

    $templangs = array();

    foreach($langs as $key => $val) {
        $lang_ary  = preg_split('/,\s*/', $val['language']);
        foreach($lang_ary as $numid => $lang) {
            // take care of english vs. English
            $lang = ucwords($lang);

            $templangs[$lang]['language'] = $lang;
            $templangs[$lang]['count']   += $val['count'];
        }
    }
    usort($templangs, 'compare_count');
    return $templangs;
}

/*
 * Helper function for comparing an associative array by it's 'count' values
 */
function compare_count($a, $b) {
    return strnatcasecmp($b['count'], $a['count']);
}

/**
 * Verify variable is valid according to validation function
 *
 * @author Andreas Goetz <cpuidle@gmx.de>
 * @param  string   $var                variable to validate (e.g. $id)
 * @param  string   $validation_func    validation function name (e.g. is_numeric)
 */
function validate_input(&$var, $validation_func = 'is_numeric') {
    if (function_exists($validation_func)) {
        if (!$validation_func($var)) {
            errorpage('Forbidden', _USER_ERROR_DEL);
        }
    }
}

/**
 * Redirect to new location
 *
 * @author  Andreas Goetz   <cpuidle@gmx,de>
 * @param   string  $dest   Redirect destination
 * @todo    Read somewhere that according to RFC redirects need to specify full URI
 */
function redirect($dest) {
    header('Location: '.$dest);
    exit();
}


/**
 * Edit Page
 *
 * The edit form for adding and editing video data
 *
 * @todo    Check if 0000 instead of empty year is needed
 * @todo    Add error message for unknown genres
 *
 * @package videoDB
 * @author  Andreas Gohr <a.gohr@web.de>
 * @author  Chinamann <chinamann@users.sourceforge.net>
 * @version $Id: edit.php,v 2.66 2005/09/27 12:47:13 andig2 Exp $
 */
function getDiskId() {
    global $config;

    // how many digits have to be used for DiskId?
    $digits = ($config['diskid_digits']) ? $config['diskid_digits'] : 4;

    // get all DiskIds ordered from DB
	$results = db_getDiskIds();

	// find first 'free' diskId
    $lastid = 0;
    foreach($results as $result) {
        $thisid = preg_replace('/^0+/','',$result['id']);
        if ($lastid + 1 < $thisid) break;
        $lastid = $thisid;
    }

    // return the found id
    return str_pad($lastid + 1, $digits, '0', STR_PAD_LEFT);
}

?>