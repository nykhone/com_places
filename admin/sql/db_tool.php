<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class DB_Tool
{
	private static $_instance;
	private function __construct() {}
	private function __clone() {}

	public static function get()
	{
		if ( !( self::$_instance instanceof self ) )
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __runSql( $sql_string )
	{
		$instr = explode( ' ', trim( $sql_string ) );
		$com = strtoupper( $instr[0] );

		$aDB = JFactory::getDBO();
		$aDB->setQuery( $sql_string );

		if ($com == "INSERT" || $com == "DELETE" || $com == "UPDATE" || $com == "REPLACE")
		{
			$result = $aDB->query();
			if ($aDB->getErrorNum())
			{
				JError::raiseWarning(500, $aDB->getErrorMsg());
			}
		}
		else
		{
//			$result = $aDB->loadAssocList();
			$result = $aDB->loadObjectList();
			if ($aDB->getErrorNum())
			{
				JError::raiseWarning(500, $aDB->getErrorMsg());
			}
		}

		return $result;
	}

// ----------------------------------------------------------
// --> requetes sur la base PAYS
// ----------------------------------------------------------
	public function db_getPays()
	{
		return $this->__runSql( 'select id, nom, drapeau from #__places_pays order by nom' );
	}

	public function db_getLieuOrdered()
	{
		return $this->__runSql( 'select l.*, v.nom as vnom from #__places_lieu as l, #__places_ville as v where l.ville = v.id order by v.nom asc, l.nom asc');
	}

	public function db_getVille()
	{
		return $this->__runSql( 'select id, nom, pays from #__places_ville order by nom' );
	}
}