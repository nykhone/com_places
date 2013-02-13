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

	private function __replySql( $sql_string, $qr )
	{
		if ( $qr )
		{
			return $sql_string;
		}
		else
		{
			return $this->__runSql( $sql_string );
		}
	}

// ----------------------------------------------------------
// --> requetes sur la base PAYS
// ----------------------------------------------------------
	public function db_get_allPays( $qr = false )
	{
		$aQuery = 'select id, nom, drapeau from #__places_pays order by nom';
		return $this->__replySql($aQuery, $qr);
	}

	public function db_get_allLieux( $qr = false )
	{
		$aQuery = 'select l.*, v.nom as ville_name, s.name as section_name from #__places_lieu as l, #__places_ville as v, #__places_section as s where l.ville = v.id and l.section = s.id order by v.nom asc, l.nom asc';
		return $this->__replySql($aQuery, $qr);
	}

	public function db_getVille()
	{
		return $this->__runSql( 'select id, nom, pays from #__places_ville order by nom' );
	}

	public function db_getPaysDrapeau( $theID )
	{
		return $this->__runSql( 'select drapeau from #__places_pays where id = ' . $theID );
	}

	public function db_getCountLieuForVille( $theVilleID )
	{
		return $this->__runSql( 'select count(id) as count from #__places_lieu where ville = ' . $theVilleID );
	}

	public function db_getCountVilleForPays( $thePaysID )
	{
		return $this->__runSql( 'select count(id) as count from #__places_ville where pays = ' . $thePaysID );
	}

	public function db_get_aSection_Details( $theID )
	{
		return $this->__runSql( 'select * from #__places_section where id = ' . $theID );
	}
}