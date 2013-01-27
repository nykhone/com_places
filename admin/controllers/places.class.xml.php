<?php
/**
 * XML Import/ Export functions
 *
 * Lets you browse through your movie collection
 * Requires PHP 5 for import
 *
 * @package Core
 * @author  Andreas Götz    <cpuidle@gmx.de>
 * @version $Id: xml.php,v 1.20 2005/09/23 09:59:23 andig2 Exp $
 */
global $mosConfig_absolute_path;
require_once( $mosConfig_absolute_path . '/includes/domit/xml_domit_lite_include.php' );


/**
 * Encodes HTML entities into XML character entities
 * this avoids problems with unknown entities in XML
 *
 * @param   string  $string HTML string to encode
 * @return  string          encoded string containing XML character entities
 */
function encode_character_entities($string)
{
    return strtr($string, get_html_translation_table(HTML_SPECIALCHARS));
#   return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
}

/**
 * Create an XML tag
 *
 * @param   string  $tag    XML tag name
 * @param   string  $value  value for XML tag
 * @param   boolean $encode require encoding of tag value
 * @return  string          XML tag
 */
function createTag($tag, $value, $encode = true) {
    if ($encode) $value = encode_character_entities($value);
    return "<$tag>".$value."</$tag>\n";
}

function createContainer($tag, $value = '') {
    return createTag($tag, $value, false);
}


/**
 * Import XML data
 *
 * @param   string   $xmlfile    XML input file
 * @param   string   $xmlformat  format pliku xml = nazwa wywo³ywanej funkcji przetwarzajacej
 * @param   array    $xmloptions dodatkowe opcje oczekiwane przez funkcje przetwarzajac¹
 * @param   &string  & $error    wskaŸnik do zmiennej przechowujacej komunikat b³edu
 * @param   &string  & $xmldata  wskaŸnik do zmiennej przechowujacej raport funkcji przetwarzajacej
 * @return			 rezultat funkcji przetwarzaj¹cej
 * @autor Waland.pl
 */
function xmlimport($xmlfile, $xmlformat, $xmloptions, &$error, &$xmldata) {

    if (empty($xmlformat)) {
		$error = _XML_IMPORT_ERR1;
		return false;
	}
    // create DOM document
    $xml = new DOMIT_Lite_Document();

	// @ToDo sprawdzic czy to plik XML
	if (!$xml->loadXML( $xmlfile, true, false )) {
        $error = _XMLIMPORT_ERR2;
        return false;
    }
	//echo "<pre>";print_r($xml->toArray());echo '</pre><hr>';

	//rozpoznawanie formatu pliku XML: <DATAPACKET>=Kolekcjoner, <catalog>=videonyko <modVDB>=upgrade database
	$element = &$xml->documentElement;
	switch ($element->nodeName) {
		case 'catalog':
			$func = 'videonyko';
			if ($xmlformat !== $func) {
			    $error = _XML_IMPORT_ERR2a.$xmlformat._XML_IMPORT_ERR2b.$func;
				return false;
			}
			break;
		case 'DATAPACKET':
			$func = 'kolekcjoner';
			if ($xmlformat !== $func) {
			    $error = _XML_IMPORT_ERR2a.$xmlformat._XML_IMPORT_ERR2b.$func;
				return false;
			}
			break;
		case 'modVDB':
			$func = 'upgradeVDB';
			if ($xmlformat !== $func) {
			    $error = _XML_IMPORT_ERR2a.$xmlformat._XML_IMPORT_ERR2b.$func;
				return false;
			}
			break;
		default:
			$error = $element->nodeName;
			return false;
	}
	$xmlitems = $func($element, $xmloptions, $xmldata);
	if (!$xmlitems) $error = $xmldata;
	return $xmlitems;
}

/**
 * Upgrade DB structure
 *
 * @param   file  XML modification instructions
 * @return  res   tru if OK, false if not
 * @autor	Waland.pl
 * @todo	dodac sukcesywny upgrade DB wg wersji i skok do elementu zgodnego z wersj¹
 */

function upgradeVDB($xmlDoc, $version, &$report) {
	global $database, $config;

	$report = '';

	//Tworzy tablicê odwo³añ do objektów (Nodów)
	$queries = $xmlDoc->childNodes;
	foreach($queries as $query) {
		$value	= str_replace('%db_prefix%', $config['db_prefix'], $query->getText());

		$database->setQuery($value);
		if (!$database->query()) {
			$res = false;
			$report = '<div align="left"><pre>'.$database->stderr(true).'</pre></div>';
			break;
		}
	}
	return $res;
}


function kolekcjoner(&$xmlDoc, $xmloptions, &$xmldata) {
	global $my;

	$attrTableConv = array(
		"ID_CD"			=>"diskid",
		"T_ORG"			=>"subtitle",
		"T_PL"			=>"title",
		"GATUNEK"		=>"genres",
		"ROK_PROD"		=>"year",
		"KRAJ"			=>"country",
		"REZYSER"		=>"director",
		"SCENARIU"		=>"custom2",
		"ZDJECIA"		=>"custom3",
		"AKTORZY"		=>"actors",
		"MUZYKA"		=>"custom4",
		"ILOSC_CD"		=>"disklabel",
		"ROZMIAR"		=>"filesize",
		"CVIDEO"		=>"video_codec",
		"ROZDZIEL"		=>"",
		"FPS"			=>"",
		"CZAS"			=>"runtime",
		"VBITRATE"		=>"",
		"CAUDIO"		=>"audio_codec",
		"SAMPLE_R"		=>"",
		"ABITRATE"		=>"",
		"KANALY"		=>"",
		"UWAGI"			=>"comment",
		"TLUMACZ"		=>"",
		"OPIS"			=>"plot",
		"DATA_DOD"		=>"filedate",			//format YYYYMMDD
		"OBEJRZAN"		=>"seen",
		"OCENA"			=>"custom1",
		"OKLADKA"		=>"",
		"JEST"			=>"",
		"FOTO"			=>"imgurl",
		"AKA"			=>"",
		"SUBTYPE"		=>"",
		"LOCATION"		=>"",
		"VideoDVD"		=>"",
		"AudioDVD"		=>"",
		"LangSubTitles" =>""
	);

	$genreTableConv = array(
		'Akcja'				=>'Action',
		'Katastroficzny'	=>'Action',
		'Przygodowy'		=>'Adventure',
		'Animowany'			=>'Animation',
		'Biograficzny'		=>'Biography',
		'Komedia'			=>'Comedy',
		'Komedia familijna'	=>'Comedy',
		'Komedia fantastyczna'	=>'Comedy',
		'Komedia wojenna'	=>'Comedy',
		'Dokumentalny'		=>'Documentary',
		'Dramat'			=>'Drama',
		'Familijny'			=>'Family',
		'bajka'				=>'Family',
		'Dla dzieci'		=>'Family',
		'Fantasy'			=>'Fantasy',
		'Historyczny'		=>'History',
		'Horror'			=>'Horror',
		'Obyczajowy'		=>'Moral',
		'Musical'			=>'Musical',
		'Sensacja'			=>'Mystery',
		'Romans'			=>'Romance',
		'S-F'				=>'SciFi',
		'Thriller'			=>'Thriller',
		'Wojenny'			=>'War',

		'Krymina³'			=>'Crime',
		'Film-Noir'			=>'FilmNoir',
		'Krótki'			=>'Short',
		'Western'			=>'Western',
		'Erotyk'			=>'Adult',
		'Opera'				=>'Opera',
		'Kostiumowy'		=>'Costume',
		'Przyrodniczy'		=>'Natural',
		'Psychologiczny'	=>'Psychological',
		'Poetycki'			=>'Poetic',
		'Balet'				=>'Ballet'
		);

	$imported = 0;
	$xmldata  = _XML_IMPORT_REPORT_TITLE."\n";
	$xmldata .= "===============================================================\n";
	$xmldata .= _XML_IMPORT_REPORT_START." Klekcjoner\n\n";
	$xmldata .= "--Lp-";
	//$xmldata .= ($xmloptions['import_diskid']) ? "--[Did]--" : "---";
	$xmldata .= "--[Did]--";
    $xmldata .= ($xmloptions['import_custom']) ? "-".substr(_OPT_CUSTOM, 0,6)."--" : "";
	$xmldata .= _EDIT_TTITLE."-------------------------------";
	//$xmldata .= ($xmloptions['import_diskid']) ? "" : "------";
	$xmldata .= ($xmloptions['import_custom']) ? "----\n" : "-------------\n";

	//Tworzy tablicê nodów xmlDoc
	$nodeArray = $xmlDoc->childNodes;

	//obs³uga rekordów z danymi
	$tagName='ROWDATA/ROW';
	$rowData = & $xmlDoc->getElementsByPath($tagName, $nodeIndex);

	$cs1 = false; $cs2 = false; $cs3 = false; $cs4 = false;

	//przegl¹d rekordach
	for ($i=0; $i < $rowData->getLength(); $i++) {

		$tcs1 = false; $tcs2 = false; $tcs3 = false; $tcs4 = false;
		$cdata = array();
        $genres  = array();

		$row = $rowData->arNodeList[$i];

		//przygotowanie reordu dla instrukcji foreach
        $data    = $row->attributes;

        // loop over item data
        foreach($data as $keyorg=>$value) {
			$key = $attrTableConv[$keyorg];
			if (empty($key)) continue;
			$value = trim(strip_tags($value));

			switch ($key) {
                case 'custom1':
                    if ($xmloptions['import_custom']) {
						$tcs1 = true;
						$cdata[$key] = $value;
						if (!$cs1) {
							$SQL1 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'","'.$keyorg.'")';
							$SQL2 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'type","text")';
							$cs1 = runSQL($SQL1);
							$cs1 = runSQL($SQL2);
						}
					}
                    break;
                case 'custom2':
                    if ($xmloptions['import_custom']) {
						$tcs2 = true;
						$cdata[$key] = $value;
						if (!$cs2) {
							$SQL1 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'","'.$keyorg.'")';
							$SQL2 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'type","text")';
							$cs2 = runSQL($SQL1);
							$cs2 = runSQL($SQL2);
						}
					}
                    break;
                case 'custom3':
                    if ($xmloptions['import_custom']) {
						$tcs3 = true;
						$cdata[$key] = $value;
						if (!$cs3) {
							$SQL1 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'","'.$keyorg.'")';
							$SQL2 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'type","text")';
							$cs3 = runSQL($SQL1);
							$cs3 = runSQL($SQL2);
						}
					}
                    break;
                case 'custom4':
                    if ($xmloptions['import_custom']) {
						$tcs4 = true;
						$cdata[$key] = $value;
						if (!$cs4) {
							$SQL1 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'","'.$keyorg.'")';
							$SQL2 = 'REPLACE INTO '.TBL_CONFIG.' (opt,value) VALUES ("'.$key.'type","text")';
							$cs4 = runSQL($SQL1);
							$cs4 = runSQL($SQL2);
						}
					}
                    break;

                case 'diskid':
                    // import disk ids?
                    $cdata[$key] = (!$xmloptions['import_diskid']) ? getDiskId() : $value;
                    break;

                case 'genres':
					$cgenre = array();
					$idgenre = array();
					//$genre = preg_split('/,\s*/', $value);
					$genre = explode(',', $value);
					foreach ($genre as $it=>$v) {
						$v = trim($v);
						$gen = $genreTableConv[$v];
						if (isset($gen) && !in_array($gen, $cgenre)) {
							$cgenre[]  = $gen;
							$idgenre[] = getGenreId($gen);
						}
					}
                    break;
				case 'actors':
					$cast = '';
					//$ary = preg_split('/,\s*/', $value);
					$ary = explode(',', $value);
					foreach ($ary as $it=>$v) {
						$v = trim($v);
						$cast  .= "$v\n";
					}
					$cdata[$key] = $cast;
					break;
				case 'filesize':
					$val = 0;
					$ary = explode('/',$value);
					foreach ($ary as $it=>$v) {
						$val += $v * 1024;
					}
					$cdata[$key] = $val;
					break;
                case 'filedate':
					$y = substr($value,0,4);
					$m = substr($value,4,2);
					$d = substr($value,6,2);
					$cdata[$key] = mktime(0,0,0,$m,$d,$y,-1);
					break;
                default:
                    $cdata[$key] = $value;
					break;
            }
		}

        $cdata['owner_id'] = $my->id;

       // data to import?
        if (count($cdata)) {
            $values = '';
			$keys	= '';
            foreach($cdata as $k=>$value) {
				$keys	.= ($k !== 'genres') ? ",$k" : "";
				$values .= ', \''.mysql_escape_string($value).'\'';
            }
			$keys		.=",created";
			$values		.=",NOW()";
			$keys[0]	 =' ';
            $values[0]	 =' ';

            // import base table data
            $SQL = "INSERT INTO ".TBL_DATA." ($keys) VALUES ($values)";
            $video_id = runSQL($SQL);

            if ($video_id === false) {
                // shouldn't happen
                $error = _XMLIMPORT_ERR6."[ ".$SQL." ]";
                return false;
            }

            // import genres data
            setItemGenres($video_id, $idgenre);

            $title	= (!empty($cdata['title'])) ? $cdata['title'] : $cdata['subtitle'];
			$idv	= $cdata['diskid'];
			++$imported;
			$str = substr("   ",0, (3 - strlen($imported)));
			$xmldata .= $str." $imported. ";
			$xmldata .= (($xmloptions['import_diskid']) ? $str : "")."[$idv] ";
			if ($xmloptions['import_custom']) {
				$xmldata .= ($tcs1 && !empty($cdata['custom1'])) ? " T" : " &nbsp;";
				$xmldata .= ($tcs2 && !empty($cdata['custom2'])) ? " T" : " &nbsp;";
				$xmldata .= ($tcs3 && !empty($cdata['custom3'])) ? " T" : " &nbsp;";
				$xmldata .= ($tcs4 && !empty($cdata['custom4'])) ? " T " : " &nbsp; ";
			}
			$xmldata .= "  $title\n";

        }
    }
	$xmldata .= "---------------------------------------------------------------\n";
	$text = _XML_IMPORT_REPORT_STOP;
	$xmldata .= str_replace('%imported%', $imported, $text);

    if ($imported == 1) {
        // return last item created
        return $video_id;
    } else {
        // return true if > 1 item imported
        return true;
    }
}



/**
 * Import XML VideoDB
 *
 * @param   object DOM  $xmlDoc			objekt DOM
 * @param   array		$xmloptions		opcje sterujace
 * @param   string		$xmldata		raport przetwarzania pliku XML
 * @return	array/true
 * @autor	Waland.pl
 */
function videonyko(&$xmlDoc, $xmloptions, &$xmldata) {
    global $my;

	$genreTableConv = array(

		//oryginal VideoDB
		'Action'		=>'Action',
		'Adventure'		=>'Adventure',
		'Animation'		=>'Animation',
		'Comedy'		=>'Comedy',
		'Crime'			=>'Crime',
		'Documentary'	=>'Documentary',
		'Drama'			=>'Drama',
		'Family'		=>'Family',
		'Fantasy'		=>'Fantasy',
		'Film-Noir'		=>'FilmNoir',
		'Horror'		=>'Horror',
		'Musical'		=>'Musical',
		'Mystery'		=>'Mystery',
		'Romans'		=>'Romance',
		'Sci-Fi'		=>'SciFi',
		'Short'			=>'Short',
		'Thriller'		=>'Thriller',
		'Wojenny'		=>'War',
		'Western'		=>'Western',
		'Adult'			=>'Adult',
		'Music'			=>'Musical',
		'Biography'		=>'Biography',
		'History'		=>'History',

		//Polish version VideoDB
		'Akcja'			=>'Action',
		'Przygoda'		=>'Adventure',
		'Animacja'		=>'Animation',
		'Komedia'		=>'Comedy',
		'Krymina³'		=>'Crime',
		'Dokument'		=>'Documentary',
		'Dramat'		=>'Drama',
		'Rodzinny'		=>'Family',
		'Fantastyka'	=>'Fantasy',
		'Film-Noir'		=>'FilmNoir',
		'Horror'		=>'Horror',
		'Muzyczny'		=>'Musical',
		'Sensacyjny'	=>'Mystery',
		'Romans'		=>'Romance',
		'Sci-Fi'		=>'SciFi',
		'Krótki'		=>'Short',
		'Wojenny'		=>'War',
		'Erotyk'		=>'Adult',
		'Opera' 		=>'Opera',
		'Obyczajowy'	=>'Moral',
		'Kostiumowy'	=>'Costume',
		'Przyrodniczy'	=>'Natural',
		'Psychologiczny'=>'Psychological',
		'Historyczny'	=>'History' ,
		'Poetycki'		=>'Poetic',
		'Biograficzny'	=>'Biography',
		'Balet'			=>'Ballet'
		);


	$imported = 0;
	$xmldata  = _XML_IMPORT_REPORT_TITLE."\n";
	$xmldata .= "===============================================================\n";
	$xmldata .= _XML_IMPORT_REPORT_START." VideoDB\n\n";
	$xmldata .= "--Lp-";
	$xmldata .= ($xmloptions['import_diskid']) ? "---[Did]----" : "---";
    $xmldata .= ($xmloptions['import_custom']) ? "-".substr(_OPT_CUSTOM, 0,6)."--" : "";
	$xmldata .= _EDIT_TTITLE;
	$xmldata .= ($xmloptions['import_owner'])  ? "-(owner)" : "--------";
	$xmldata .= "-----------------";
	$xmldata .= ($xmloptions['import_diskid']) ? "" : "---------";
	$xmldata .= ($xmloptions['import_custom']) ? "-------\n" : "----------------\n";
	$cs1 = false; $cs2 = false; $cs3 = false; $cs4 = false;

	//Tworzy tablicê odwo³añ do objektów (Nodów)
	$nodeArray = $xmlDoc->childNodes;

	//przegl¹d rekordach
	for ($i=0; $i < count($nodeArray); $i++) {

		$tcs1 = false; $tcs2 = false; $tcs3 = false; $tcs4 = false;
		$cdata = array();

		//utworzenie tablicy odsy³aczy do danych rekordu
		$dataArray = $nodeArray[$i]->childNodes;

		// loop over items
		for ($j = 0; $j < count($dataArray); $j++) {

			$key	= $dataArray[$j]->nodeName;
			$data   = $dataArray[$j]->toArray();
			$value	= $data[$key][0];

			$genre_ids  = array();

			// handle individual attributes
			switch ($key) {
				case 'id':
					break;

				case 'owner':
					// import owner?
					$owner = "<".$my->username.">";
					$cdata['owner_id'] = $my->id;
					if ($xmloptions['import_owner']) {
						// check if owner exists
						$owners = runSQL('SELECT id FROM '.TBL_USERS.' WHERE name=\''.mysql_escape_string($value).'\'');
						if (count($owners)) {
							$cdata['owner_id'] = $owners[0]['id'];
							$owner = $value;
						}
					}
					break;

					// import custom fields?
				case 'custom1':
					if ($xmloptions['import_custom']) {
						$tcs1 = true;
						$cdata[$key] = $value;
					}
					break;
				case 'custom2':
					if ($xmloptions['import_custom']) {
						$tcs2 = true;
						$cdata[$key] = $value;
					}
					break;
				case 'custom3':
					if ($xmloptions['import_custom']) {
						$tcs3 = true;
						$cdata[$key] = $value;
					}
					break;
				case 'custom4':
					if ($xmloptions['import_custom']) {
						$tcs4 = true;
						$cdata[$key] = $value;
					}
					break;

				case 'diskid':
					// import disk ids?
                    $cdata[$key] = (!$xmloptions['import_diskid']) ? getDiskId() : $value;
					break;

				case 'genres':
					// loop over item data
					for ($g = 0; $g < count($data[$key])-1; $g++) {
						$genre  = $data[$key][$g]['genre'][0];
						$id     = getGenreId($genreTableConv[$genre]);

						/*if (empty($id)) {
							$error = _XMLIMPORT_ERR5.$genre._XMLIMPORT_ERR4;
							return false;
						}  */

						$genre_ids[] = $id;
					}
					break;

				default:
					$cdata[$key] = $value;
			}
		}

		// data to import?
		if (count($cdata)) {
			$keys = join(', ', array_keys($cdata));
			$values = '';
			foreach(array_values($cdata) as $value) {
				if ($values) $values .= ', ';
				$values .= '\''.mysql_escape_string($value).'\'';
			}

			// import base table data
			$SQL = "INSERT INTO ".TBL_DATA." ($keys) VALUES ($values)";
			$video_id = runSQL($SQL);

			if ($video_id === false) {
				// shouldn't happen
				$error = _XMLIMPORT_ERR6.$SQL;
				return false;
			}

			// import genres data
			setItemGenres($video_id, $genre_ids);

            $title	= (!empty($cdata['title'])) ? $cdata['title'] : $cdata['subtitle'];
			$idv	= $cdata['diskid'];
			++$imported;
			$str = substr("   ",0, (3 - strlen($imported)));
			$xmldata .= $str." $imported. ";
			$xmldata .= ($xmloptions['import_diskid']) ? $str."[$idv] " : "";
			//$xmldata .= (($xmloptions['import_diskid']) ? $str : "")."[$idv] ";
			if ($xmloptions['import_custom']) {
				$xmldata .= ($tcs1 && !empty($cdata['custom1'])) ? " T" : " &nbsp;";
				$xmldata .= ($tcs2 && !empty($cdata['custom2'])) ? " T" : " &nbsp;";
				$xmldata .= ($tcs3 && !empty($cdata['custom3'])) ? " T" : " &nbsp;";
				$xmldata .= ($tcs4 && !empty($cdata['custom4'])) ? " T " : " &nbsp; ";
			}
			$xmldata .= "  $title";
			$xmldata .= ($xmloptions['import_owner']) ? "&nbsp;(".$owner.")\n" : "\n";
		}
	}
	$xmldata .= "---------------------------------------------------------------\n";
	$text = _XML_IMPORT_REPORT_STOP;
	$xmldata .= str_replace('%imported%', $imported, $text);

	if ($imported == 1) {
		// return last item created
		return $video_id;
	} else {
		// return true if > 1 item imported
		return true;
	}
}

/**
 * Export XML data
 *
 * @param   string  $where  WHERE clause for SQL statement
 */
function xmlexport($WHERE) {
    global $config, $my;

    // includes genres table in query?
    $TABLE = '';
    if (strstr($WHERE, 'genre_id')) {
        $TABLE  = TBL_VIDEOGENRE.', ';
        $WHERE .= ' AND '.TBL_DATA.'.id = '.TBL_VIDEOGENRE.'.video_id';
    }

    $SQL = 'SELECT '.TBL_DATA.'.*,
                   '.TBL_USERS.'.name AS owner,
                   '.TBL_MEDIATYPES.'.name AS mediatype
              FROM '.$TABLE.TBL_DATA.'
         LEFT JOIN '.TBL_USERSEEN.' ON '.TBL_DATA.'.id = '.TBL_USERSEEN.'.video_id AND
                   '.TBL_USERSEEN.'.user_id = \''.addslashes($my->id).'\'
         LEFT JOIN '.TBL_USERS.' ON '.TBL_DATA.'.owner_id = '.TBL_USERS.'.id
             WHERE '.$WHERE;

    $result = runSQL($SQL);
    $xml = '';

    // loop over items
    foreach ($result as $item) {
        $xml_item = '';

        // loop over attributes
        foreach ($item as $key => $value) {
            if (!empty($value)) {
                if ($key != 'owner_id') {
                    $tag       = strtolower($key);
                    $xml_item .= createTag($tag, trim(html_entity_decode($value)));
                }
            }
        }

        // this is a hack for exporting thumbnail URLs
        if ($item['imgurl'] && $config['xml_thumbnails']) {
            $thumb = getThumbnail($item['imgurl']);
            if (ereg('cache', $thumb))
                $xml_item .= createTag('thumbnail', trim($thumb));
        }

        // genres
        $genres = getItemGenres($item['id'], true);
        if (count($genres)) {
            $xml_genres = '';
            foreach ($genres as $genre) {
                $xml_genres .= createTag('genre', $genre['name']);
            }
            $xml_item .= createContainer('genres', $xml_genres);
        }

        $xml .= createContainer('item', $xml_item);
    }

    $xml    = "<?xml version=\"1.0\" encoding=\"iso-8859-2\"?>\n".createContainer('catalog', $xml);

//    header('Content-type: text/xml');
    $mime   = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) ? 'application/force-download' : 'application/octet-stream';
    header('Content-type: '.$mime);
    header('Content-length: '.strlen($xml));
    header('Content-disposition: attachment; filename=videoDB.xml');

    echo $xml;
}

/**
 * Update RSS File
 *
 * @author  Mike Clark    <mike.clark@cinven.com>
 */
function rssexport($WHERES) {
    global $config;

	// get the latest items from the DB according to config setting
    $SELECT = 'SELECT id, title, plot, created
                 FROM '.TBL_DATA.'
             ORDER BY created DESC LIMIT '.$config['shownew'];
	$result = runSQL($SELECT);

    // script root
    $base = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

	// setup the RSS Feed
    $rssfeed  = "<?xml version=\"1.0\" encoding=\"iso-8859-2\"?>\n";
	$rssfeed .= '<rss version="2.0">';
	$rssfeed .= '<channel>';
	$rssfeed .= createTag('title', 'VideoDB');
	$rssfeed .= createTag('link', $base.'/index.php?export=rss');
	$rssfeed .= createTag('description', 'New items posted on VideoDB');
	$rssfeed .= createTag('language', 'en-us');
	$rssfeed .= createTag('lastBuildDate', date("D, j M Y G:i:s T"));

	// build the <item></item> section of the Feed
	foreach ($result as $item)
	{
        // Lets sort this nasty timestamp nonsense out ;D
        $itemtimestamp = $item['created'];
        //$length = strlen($itemtimestamp);
        $y  = substr($itemtimestamp,0,4);
        $m  = substr($itemtimestamp,4,2);
        $d  = substr($itemtimestamp,6,2);
        $h  = substr($itemtimestamp,8,2);
        $min= substr($itemtimestamp,10,2);
        $s  = substr($itemtimestamp,12,2);
        $itemtimestamp = mktime($h,$min,$s,$m,$d,$y);

        $xml_item  = createTag('title', $item['title']);
        $xml_item .= createTag('link', $base.'/show.php?id='.$item['id']);
        $xml_item .= createTag('description', $item['plot']);
        $xml_item .= createTag('guid', $base.'/show.php?id='.$item['id']);
        $xml_item .= createTag('pubDate', date("D, j M Y G:i:s T", $itemtimestamp));

        $rssfeed  .= createTag('item', $xml_item, false);
	}
	$rssfeed .= '</channel>';
	$rssfeed .= '</rss>';

    header('Content-type: text/xml');
#   header('Content-length: '.rssfeed($xml));
#   header('Content-disposition: filename=rss.xml');
    echo $rssfeed;
}

?>