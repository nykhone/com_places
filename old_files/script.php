<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class com_helloWorldInstallerScript
{
	/* method to install the component
	** @return void */
	function install( $parent )
	{
		// $parent is the class calling this method
		// $parent->getParent()->setRedirectURL('index.php?option=com_helloworld');
		echo '<center><table width="60%" border="0"><tr><td>
			<div class="message">places component installed<br /></div>
			<div class="error">places database installed<br /></div>
			</td></tr></table></center>';
	}

	/* method to uninstall the component
	** @return void */
	function uninstall( $parent ) 
	{
		// $parent is the class calling this method
		echo '<center><table width="60%" border="0"><tr><td>
			<div class="message">Uninstall OK<br /></div>
			<div class="error"> ...? <br /></div>
			</td></tr></table></center>';
	}

	/* method to update the component
	** @return void */
	function update( $parent ) 
	{
		// $parent is the class calling this method
		// echo '<p>' . JText::sprintf('COM_HELLOWORLD_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
	}

	/* method to run before an install/update/uninstall method
	** @return void */
	function preflight( $type, $parent ) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		// echo '<p>' . JText::_('COM_HELLOWORLD_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}

	/* method to run after an install/update/uninstall method
	** @return void */
	function postflight( $type, $parent ) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		// echo '<p>' . JText::_('COM_HELLOWORLD_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}
