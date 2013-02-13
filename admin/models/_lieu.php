<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modellist');
require_once '/home/nykhos/Desktop/www/Joomla_2_5_8/administrator/components/com_places//sql/db_tool.php';

class places_Model_lieu extends JModelList
{
	protected function getListQuery()
	{
		$this->Lieu = DB_Tool::get()->db_get_allLieux( true );
		return $this->Lieu;
	}
}