<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modelitem');
require_once '/home/nykhos/Desktop/www/Joomla_2_5_8/administrator/components/com_places/sql/db_tool.php';

class places_Model_ville extends JModelItem
{
	protected $Ville;

	public function get_ville() 
	{
		$this->Ville = DB_Tool::get()->db_getVille();

		foreach( $this->Ville as $aVille )
		{
			if ( $aVille->pays > 0 )
			{
				$aPays = DB_Tool::get()->db_getPaysDrapeau( $aVille->pays );
			}
			$aVille->pays_drapeau = $aPays[0]->drapeau;

			$aLieu = DB_Tool::get()->db_getCountLieuForVille( $aVille->id );
			$aVille->lieux_count = $aLieu[0]->count;
		}
		return $this->Ville;
	}
}