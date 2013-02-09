<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');
require_once '/home/nykhos/Desktop/www/Joomla_2_5_8/administrator/components/com_places/sql/db_tool.php';

class places_Model_pays extends JModelItem
{
	protected $Pays;

	public function get_pays() 
	{
		$this->Pays = DB_Tool::get()->db_getPays();
		return $this->Pays;
	}
}