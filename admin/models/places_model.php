<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modellist' );

class Places_Model_PlacesDefaultModel extends JModelList
{
	protected function getList_Pays()
	{
		// Create a new query object.           
		$db = JFactory::getDBO();
		$query = $db->getQuery( true );

		$query->select( 'id, nom, drapeau' );
		$query->from( '#__places_pays' );

		return $query;
	}
}
