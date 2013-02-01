<?php
/**
* @version $Id: google_maps.class.php,v 1.5 2005/09/17 17:41:17 sjashe Exp $
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Pull in the NuSOAP code
//require_once( $mosConfig_absolute_path . '/administrator/components/'.$option.'/IXR_Library.inc.php');

class mosPlace extends mosDBTable {
	/** @var int Primary key */
	var $id=null;
	/** @var string */
	var $name=null;
	/** @var string */
	var $place_position=null;
	/** @var string */
	var $address=null;
	/** @var string */
	var $suburb=null;
	/** @var string */
	var $state=null;
	/** @var string */
	var $country=null;
	/** @var string */
	var $postcode=null;
	/** @var string */
	var $misc=null;
	/** @var int */
	var $published=null;
	/** @var int */
	var $checked_out=null;
	/** @var datetime */
	var $checked_out_time=null;
	/** @var int */
	var $ordering=null;
	/** @var string */
	var $params=null;
	/** @var int A link to a category */
	var $catid=null;
	/** @var int */
	var $access=null;
	/** @var string */
	var $lat=null;
	/** @var string */
	var $lng=null;
	/** @var date */
	var $date=null;

	/**
	* @param database A database connector object
	*/
	function mosPlace() {
	    global $database;
		$this->mosDBTable( '#__google_maps', 'id', $database );
	}

	function check() {
		$this->checkLatLong();
		return true;
	}

	/************************************************

	This function scrapes information from google maps.
	It will no longer be used but it is the only way
	of getting international geocoding so far.

	*************************************************/

	function checkLatLong2() {

    	  $q= $this->address.', '.$this->suburb.' '.$this->state.' '.$this->postcode;
	      $gm=fopen('http://maps.google.com/maps?q='.urlencode($q).'&output=js','r');

		  $tmp=@fread($gm,30000);
		  fclose($gm);

		  $x=preg_replace('/.*<point lat="([^"]*)" lng="([^"]*)".*/',"|$1|$2|", nl2br(trim($tmp)));

		  list ($dummy,$lat_value, $lng_value) = explode("|",$x);

		  $this->lat = ($lat_value) ? $lat_value : $this->lat;
		  $this->lng = ($lng_value) ? $lng_value : $this->lng;

	}


	/************************************************

	This function uses the free XML-RPC interface
	of geocoder.us. It will only code for US address
	and not for any foreign addresses

	*************************************************/

	function checkLatLong() {


		if($this->country == "us" || $this->country == "") {
			// This builds the address
			$q= $this->address.', '.$this->suburb.' '.$this->state.' '.$this->postcode;

			// This sends the query out to the geocoder.us server.
			$client = new IXR_Client('http://geocoder.us/service/xmlrpc');
			$client->query('geocode', "$q");
			$result = $client->getResponse();
		} elseif (!$this->address) {


			// This is for international geocoding

			$base = 'http://brainoff.com/geocoder/rest/';
			$query_string = '';

			$key = "city";
			$value = "$this->suburb,$this->country";

			$query_string .= "$key=" . urlencode($value);

			$url = "$base?$query_string";

			$c   = curl_init($url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			$xml = curl_exec($c);
			curl_close($c);

			$expression = "/[<]geo[:][l][a-z]*[>]([ ]?[-+]?\d+(?:\.\d+)?[ ]?)/";
			preg_match_all($expression,$xml,$coords);


			list($result[0]["long"],$result[0]["lat"]) = $coords[1];



		}


		// This sets the latitude and longitude
		$this->lng = ($result[0]["long"]) ? $result[0]["long"] : $this->lng;
		$this->lat = ($result[0]["lat"]) ? $result[0]["lat"] : $this->lat;
	}
}


class mosPlaceConf extends mosDBTable {

	/** @var int Primary key */
	var $id=null;
	/** @var int */
	var $mapWidth=null;
	/** @var int */
	var $mapHeight=null;
	/** @var int */
	var $mapBorder=null;
	/** @var int */
	var $zoomLevel=null;
	/** @var string */
	var $APIKey=null;
	/** @var string */
    var $title=null;
	/** @var string */
	var $misc=null;
	/** @var string */
    var $centerId=null;
	/** @var string */
	var $centerLng=null;
	/** @var string */
    var $centerLat=null;
	/** @var int */
	var $autoOpen=null;
	/** @var int */
	var $showScale=null;
	/** @var int */
	var $showZoom=null;
	/** @var int */
    var $whichZoom=null;
	/** @var int */
	var $showType=null;
	/** @var int */
	var $whichType=null;
	/** @var string */
	var $xsl=null;
	/** @var int */
	var $pdMarkers=null;
	/** @var int */
	var $geocode=null;



	/**
	* @param database A database connector object
	*/
	function mosPlaceConf() {
	    global $database;
		$this->mosDBTable( '#__google_maps_conf', 'id', $database );
	}

	function createJSArray($object, $key) {
		$j = 0;
		$return = '["';
		while($object[$j]->$key) {
			if($j == 0) {
				$return .= $object[$j]->$key;
			} elseif ($j > 0) {
				$return .= '","';
				$return .= $object[$j]->$key;
			}
			$j++;
		}
		$return .= '"]';
		return $return;
	}


}

class pdMarkers {

	var $pdEnable = "";
	var $pdCreateMarker = "";
	var $pdStandardTip = "";
	var $pdTooltip = "";
	var $pdHoverImage = "";
	var $pdHelpCursor = "";
	var $pdTooltipOpacity = "";
	var $pdZoomMarkers = "";
	var $pdLeftTooltips = "";

	function pdMarkers($object) {
		if($object->pdEnable) {
			$this = $object;
			$this->pdCreateMarker = "\tvar marker = new PdMarker(point);\n";
			$this->pdCreateMarker .= "\tif(pdArray[0] == 1) {\n";
			$this->pdCreateMarker .= "\t\tmarker.setTitle(localName);\n";
			$this->pdCreateMarker .= "\t}\n";
			$this->pdCreateMarker .= "\tif(pdArray[1] == 1) {\n";
			$this->pdCreateMarker .= "\t\tmarker.setTooltip(localName);\n";
			$this->pdCreateMarker .= "\t}\n";
			$this->pdCreateMarker .= "\tif(pdArray[2] == 1) {\n";
			$this->pdCreateMarker .= "\t\tmarker.setHoverImage(pdArray[pdHoverImage])\n";
			$this->pdCreateMarker .= "\t}\n";
			$this->pdCreateMarker .= "\tif(pdArray[3] == 1) {\n";
			$this->pdCreateMarker .= "\t\tmarker.allowLeftTooltips(true)\n";
			$this->pdCreateMarker .= "\t}\n";


/***********************************************************
			$this->pdStandardTip = $object->pdStandardTip;
			$this->pdStandardTip = $object->pdStandardTip;
			$this->pdStandardTip = $object->pdStandardTip;
************************************************************/
		} else {
			$this->pdCreateMarker = 	"\tvar marker = new GMarker(point);\n";
		}
	}

	function pdIncludes() {
		if($this->pdEnable) {
?>
<script type="text/javascript" src="components/com_google_maps/pdmarker.js"></script>
<link href="components/com_google_maps/pdmarkers.css" rel="stylesheet" type="text/css" />
<?
		}
	}

	function pdCreateMarker() {
		return $this->pdCreateMarker;
	}

	function pdCreateJSArray() {
		$j = 0;
		$return = '\tvar pdArray = ["';
		$key = array("pdStandardTip","pdToolTip");
		while($this->$key[$j]) {
			if($j == 0) {
				$return .= $this->$key[$j];
			} elseif ($j > 0) {
				$return .= '","';
				$return .= $this->$key[$j];
			}
			$j++;
		}
		$return .= '"];';
		return $return;
	}


}

?>