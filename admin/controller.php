<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class Places_Controller extends JController
{
	function display( $cachable = false ) 
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set( 'view', $input->getCmd( 'view', 'Places_View_Default' ) );

		// call parent behavior
		parent::display( $cachable );
	}
}
