<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.database.table' );

/** Table qui recupere un tableau dans la table pays **/
class Places_Table_Pays extends JTable
{
	function __construct( &$db ) 
	{
		parent::__construct( '#__places_pays', 'id', $db );
	}
}
