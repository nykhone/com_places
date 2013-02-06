<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');

class places_Model_lieu extends JModelItem
{
	protected $Lieu;

	public function get_lieu() 
	{
		xdebug_break();
		# TODO : runSQL facon places.class.db.php
		# return RunSql('select id, nom, drapeau from jos_places_pays order by nom')
		$aDB = JFactory::getDBO();
		$aQuery = $aDB->getQuery( true );
		$aQuery->select( 'id, nom, description, ville, latitude, longitude, section' );
		$aQuery->from( '#__places_lieu' );
		$aDB->setQuery( (string)$aQuery );

		$this->Lieu = $aDB->loadObjectList();

		return $this->Lieu;
	}
}