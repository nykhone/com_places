<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');
require_once '/home/nykhos/Desktop/www/Joomla_2_5_8/administrator/components/com_places/sql/db_tool.php';

class places_Model_ville extends JModelItem
{
	protected $Ville;

	public function get_ville() 
	{
		$this->Ville = DB_Tool::get()->db_getVille();
		return $this->Ville;
	}
}