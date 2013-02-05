<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');

class places_Model_pays extends JModelItem
{
	protected $Pays;

	public function get_pays() 
	{
		xdebug_break();
		# TODO : runSQL facon places.class.db.php
		# return RunSql('select id, nom, drapeau from jos_places_pays order by nom')
		$aDB = JFactory::getDBO();
		$aQuery = $aDB->getQuery( true );
		$aQuery->select( 'id, nom, drapeau' );
		$aQuery->from( '#__places_pays' );
		$aDB->setQuery( (string)$aQuery );

		$this->Pays = $aDB->loadObjectList();

		return $this->Pays;
	}
}