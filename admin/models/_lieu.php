<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');
require_once '/home/nykhos/Desktop/www/Joomla_2_5_8/administrator/components/com_places/sql/db_tool.php';

class places_Model_lieu extends JModelItem
{
	protected $Lieu;

	public function get_lieu() 
	{
		$this->Lieu = DB_Tool::get()->db_getLieuOrdered();
		return $this->Lieu;
	}
}