<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class places_View_ville extends JView
{
    protected $ville;

	function display( $tpl = null ) 
	{
		JToolbarHelper::title( "Places - Ville" );

		// Get data from the model
		$aVille = $this->get( '_ville', '_ville' );

		// Check for errors.
		if ( count ( $errors = $this->get( 'Errors' ) ) ) 
		{
			JError::raiseError( 500, implode( 'raised error <br />', $errors ) );
			return false;
		}

		// Assign data to the view
		$this->ville = $aVille;

		// Display the template
		parent::display( $tpl );
	}
}
