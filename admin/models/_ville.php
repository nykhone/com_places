<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');

class places_Model_ville extends JModelItem
{
	protected $Ville;

	public function get_ville() 
	{
		xdebug_break();
		# TODO : runSQL facon places.class.db.php
		# return RunSql('select id, nom, drapeau from jos_places_pays order by nom')
		$aDB = JFactory::getDBO();
		$aQuery = $aDB->getQuery( true );
		$aQuery->select( 'id, nom, pays' );
		$aQuery->from( '#__places_ville' );
		$aDB->setQuery( (string)$aQuery );

		$this->Ville = $aDB->loadObjectList();

		return $this->Ville;
	}
}