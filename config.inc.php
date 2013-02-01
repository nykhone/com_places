<?php
/**
* Places Config File
*/

	/* Release option */
	$config['release']['version'] = "0.1";
	$config['release']['date'] = "06.05.2007";

	/* Database options */
	$config['db_prefix'] = '#__places_'; // Database table prefix (for use in hosting environments)

	/* Debug option */
	$config['debug'] = 0; // Usually leave this at 0, 1-list _POST, 2-list _SESSION, 3-list SETUP_GLOBAL

	/* Logging */
	$config['httpclientlog'] = 0; // HttpClient logging

	/* Configuration Table */
	$config['conf_table']	= 'config'; // Table holding configuration
?>