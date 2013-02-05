<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class places_Controller extends JController
{
	function display( $cachable = false, $urlparams = false ) 
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set( 'view', $input->getCmd( 'view', '_pays' ) );

		// call parent behavior
		parent::display( $cachable, $urlparams );
	}
}
