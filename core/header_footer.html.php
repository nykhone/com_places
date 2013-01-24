<?php
/**
* Adaptacja VideoDb dla Mambo
*
* @package VideoDB
* @copyright 2005 Andrzej Waland http://www.waland.pl
* @license http://www.gnu.org/copyleft/gpl.html GNU Public License
* @version $Revision: 0.3 $
*/

// sprawdzenie ¿e ten plik jest uruchamiany przez plik nadrzêdny ensure
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function displayHeader($option) {
	global $config, $Itemid, $task;

	$diskid	= trim( mosGetParam( $_REQUEST, 'id', 0 ) );

	$out='';
	$out.='<table width="100%" cellspacing="0"';
	$out.= ($task != 'stat') ? ' class="tablefilter">' : '>';
	$out.='<tr>';
	$out.='<td width=12%" ><div class="status" align="left">';
	if (empty($config['msname'])) {
		$out.='VideoDB<span style="font-size:0.5em;">&nbsp;v'.REL_VERSION.'</span>';
	} else {
		$out.=$config['msname'];
	}
	$out.='</div></td >';

	// Switch over language interface
	$out .= out_langInterface($task);

	if ($config['borrow'] && $task == 'show' && isset($diskid)) {
		$out.='<td >';
			$out.='<form action="index.php" name="borrow" metod="get">';
				$out.='<input type="hidden" name="option" value="'.$option.'"/>';
				$out.='<input type="hidden" name="Itemid" value="'.$Itemid.'"/>';
				$out.='<input type="hidden" name="task" value="borrow_ask"/>';
				$out.='<input type="hidden" name="diskid" value="'.$diskid.'"/>';
				$out.='<input type="submit" value="'._HEADER_BORROW.'" class="button"/>';
			$out.='</form>';
		$out.='</td>';
	}
	if ($task !== 'shownew' && $task !== 'search' ) {
		$out.='<td align="right" >';
			$out.='<form action="index.php" name="showfilms" metod="get">';
				$out.='<input type="hidden" name="option" value="'.$option.'"/>';
				$out.='<input type="hidden" name="Itemid" value="'.$Itemid.'"/>';
				if (!$config['easyfilter'])
					$out.='<input type="hidden" name="task" value="shownew"/>';
				$out.='<input type="submit" value="';
				$out.=($config['easyfilter']) ? _HEADER_BROWSE : _HEADER_SEARCH;
				$out.='" class="button"/>';
			$out.='</form>';
		$out.='</td>';
	}
	if ($task !== 'browse' AND !$config['easyfilter']) {
		$out.='<td align="right" >';
			$out.='<form action="index.php" name="shownew" metod="get">';
				$out.='<input type="hidden" name="option" value="'.$option.'"/>';
				$out.='<input type="hidden" name="Itemid" value="'.$Itemid.'"/>';
				$out.='<input type="hidden" name="task" value="browse"/>';
				$out.='<input type="submit" value="'._HEADER_BROWSE.'" class="button"/>';
			$out.='</form>';
		$out.='</td>';
	}
	if ($task !== 'stat' AND !$config['easyfilter']) {
		$out.='<td >';
			$out.='<form action="index.php" name="showstat" metod="get">';
				$out.='<input type="hidden" name="option" value="'.$option.'"/>';
				$out.='<input type="hidden" name="Itemid" value="'.$Itemid.'"/>';
				$out.='<input type="hidden" name="task" value="stat"/>';
				$out.='<input type="submit" value="'._HEADER_STAT.'" class="button"/>';
			$out.='</form>';
		$out.='</td>';
	}
	$out.='</tr>';
	$out.='</table>';
	echo $out;
}

function footer($option, $index='index.php') {
	global $config, $my, $Itemid, $task;

	$pageno		  = $_SESSION['ms']['pageno'];         // assign current Page Number
	$maxpageno    = $_SESSION['ms']['maxpageno'];		// set Maximum Pages
	$totalresults = $_SESSION['ms']['totalresults'];   // set Total Records Returned
	$number		  = $_SESSION['ms']['number'];
	$filter		  = $_SESSION['ms']['filter'];
	$listcolumns  = $_SESSION['ms']['listcolumns'];

	switch ($task) {
		case 'browse':
			$filter = 'option='.$option.'&Itemid='.$Itemid.'&task='.$task.'&filter='.$filter;
			break;
		case 'search':
			$filter = $_SERVER['QUERY_STRING'];
			break;
		default:
			$filter = '';
			break;
	}

	$link = $index.'?'.$filter.'&listcolumns='.$listcolumns.'&';

	if ($config['pdf']) $pdf = $_SESSION['ms']['pdf'];
	if ($config['xls']) $xls = $_SESSION['ms']['xls'];
	if ($config['xml']) $xml = $_SESSION['ms']['xml'];
	if ($config['rss']) $rss = $_SESSION['ms']['rss'];

?>
	<table class="tablefooter">
	<tr>
		<td><a href="#top"><img src="<?php echo IMAGE_PATH;?>top.gif" alt=""/></a></td>
		<td style="text-align:left" nowrap="nowrap">
			<span class="version">
<?php
				$out='';
				if ($pageno && $maxpageno) {
					if ($pageno != 1) {
						$str = $pageno -1;
						$out.='<a href="'.$link.'pageno='.$str.'"><span class="prev_next">&#171;&nbsp;</span></a>';
					}
					$out.=_FOOTER_PAGENO.$pageno._FOOTER_OF.$maxpageno;
					if ($pageno != $maxpageno) {
						$str = $pageno +1;
						$out.='<a href="'.$link.'pageno='.$str.'"><span class="prev_next">&nbsp;&#187;</span></a>';
					}
					$out.= '&nbsp;[';
					$out.= $totalresults._FOOTER_RECORDS.']';
				}
				if ($number && !$totalresults) {
					$out.= $number._FOOTER_DISPLAYED;
				}
				echo $out;
?>
			</span>
		</td>
		<td align="right" style="text-align:right" nowrap="nowrap">
<?php
			$out='';
			if ($pdf) {
				$out.='<a href="'.$pdf.'export=pdf&ext=.pdf"><img src="'.IMAGE_PATH.'pdfexport.png" style="float:right;margin-left:3px;"/></a>';
			}
			if ($xls) {
				$out.='<a href="'.$xls.'export=xls&ext=.xls"><img src="'.IMAGE_PATH.'xlsexport.png" style="float:right;margin-left:3px;"/></a>';
			}
			if ($xml) {
				$out.='<a href="'.$xml.'export=xml" target="_blank"><img src="'.IMAGE_PATH.'xmlexport.png" style="float:right;margin-left:3px;"/></a>';
			}
			if ($rss) {
				$out.='<a href="'.$rss.'export=rss" target="_blank"><img src="'.IMAGE_PATH.'rssexport.png" style="float:right;margin-left:3px;"/></a>';
			}
			echo $out;
?>
		</td>
		<td width="100%" nowrap="nowrap" align="left">
			<a href="http://www.waland.pl/mambo/index.php?option=com_moviestats&Itemid=<?php echo $Itemid;?>" class="splitbrain">com_moviestats v<?php echo $config['release']['version'];?></a>
		<!--
<?php		if ($my->id) {
?>
				<span class="version" >,<?php echo '&nbsp;'._FOOTER_LOGIN.$my->username;?></span>
<?php		}
?>		-->
		</td>
<?php
			if ($config['easyfilter']) {
				$out = '<td align="right">';
				$out .= '<a href="'.$index.'?option='.$option.'&Itemid='.$Itemid.'&task=stat">'._VIDEONYKO_STAT.'</a>';
				$out .= '</td>';
				$out .= '<td>&nbsp;<a href="#top"><img src="'.IMAGE_PATH.'top.gif" alt=""/></a></td>';
				echo $out;
			}
?>
	</tr>
	</table>
<?php
}
?>