<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.form.helper' );
JFormHelper::loadFieldClass( 'list' );

class JFormFieldHelloWorld extends JFormFieldList
{
	protected $type = 'HelloWorld';

	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery( true );
		$query->select( 'id, nom, drapeau' );
		$query->from( '#__places_pays' );
		$db->setQuery( (string)$query );
		$messages = $db->loadObjectList();
		$options = array();
		if ( $messages )
		{
			foreach( $messages as $message ) 
			{
				$options[] = JHtml::_('select.option', $message->id, "$message->nom + <img=../media/flags/$message->drapeau>" );
			}
		}
		$options = array_merge( parent::getOptions(), $options );
		return $options;
	}
}
