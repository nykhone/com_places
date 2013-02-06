<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class places_View_pays extends JView
{
    protected $pays;

	function display( $tpl = null ) 
	{
		JToolbarHelper::title( "Places - Pays" );

		xdebug_break();
		// Get data from the model
		$aPays = $this->get( '_pays', '_pays' );

		// Check for errors.
		if ( count ( $errors = $this->get( 'Errors' ) ) ) 
		{
			JError::raiseError( 500, implode( 'raised error <br />', $errors ) );
			return false;
		}

		// Assign data to the view
		$this->pays = $aPays;

		// Display the template
		parent::display( $tpl );
	}
}