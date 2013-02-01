<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');

class Places_Model_Pays extends JModelItem
{
	protected $messages;

        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
        public function getTable( $type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array() )
        {
                return JTable::getInstance($type, $prefix, $config);
        }
        /**
         * Get the message
         * @param  int    The corresponding id of the message to be retrieved
         * @return string The message to be displayed to the user
         */
        public function getMsg($id = 1) 
        {
                if (!is_array($this->messages))
                {
                        $this->messages = array();
                }
 
                if (!isset($this->messages[$id])) 
                {
                        //request the selected id
                        $id = JRequest::getInt('id');
 
                        // Get a TableHelloWorld instance
                        $table = $this->getTable();
 
                        // Load the message
                        $table->load($id);
 
                        // Assign the message
                        $this->messages[$id] = $table->greeting;
                }
 
                return $this->messages[$id];
        }
}
