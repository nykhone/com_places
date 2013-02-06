<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class places_View_lieu extends JView
{
    protected $lieu;

	function display( $tpl = null ) 
	{
		JToolbarHelper::title( "Places - Lieu" );

		xdebug_break();
		// Get data from the model
		$aLieu = $this->get( '_lieu', '_lieu' );

		// Check for errors.
		if ( count ( $errors = $this->get( 'Errors' ) ) ) 
		{
			JError::raiseError( 500, implode( 'raised error <br />', $errors ) );
			return false;
		}

		// Assign data to the view
		$this->lieu = $aLieu;

		// Display the template
		parent::display( $tpl );
	}
}
