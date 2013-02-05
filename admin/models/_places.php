<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modellist');

class places_Model_default extends JModelList
{
	protected function getListQuery()
	{
		return "Hello";
	}
}
