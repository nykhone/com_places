<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class places_View_lieu extends JView
{
    protected $lieu;

	function display( $tpl = null ) 
	{
		JToolbarHelper::title( "Places - Lieu" );

		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');

		// Check for errors.
		if ( count ( $errors = $this->get( 'Errors' ) ) ) 
		{
			JError::raiseError( 500, implode( 'raised error <br />', $errors ) );
			return false;
		}

		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;

		// Display the template
		parent::display( $tpl );
	}
}