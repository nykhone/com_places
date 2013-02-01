<?php

defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');


?>
<style type="text/css">
<!--

	/* displayList() */
		.center {text-align: center;}
		.even {vertical-align: top; background-color:#fff;}
		.odd  {vertical-align: top; background-color:#eee;}
		.lent {background-color:#fcc;}
		.wanted {background-color:#ff9;}
		.cover {margin: 0px 4px 1px 0px;}
		.list_title,
		.list_diskid { font-weight:bold; font-size:12px; }
		.list_info { font-style:italic; font-size:10px; }
		.list_seen,
		.list_plot { font-size:10px; }
		.list_episode { padding: 2px; }
		input.button {text-transform: capitalize; font-size: 12px; }
		.listerr {
			width: 100%;
			color : #C40000;
			font-size : 11px;
			font-weight : bold;
			background-color:#ccf;
		}

	/* displayStat() */
		.bar_1{ background-color: #8D1B1B; border: 1px ridge #B22222; }
		.bar_2{ background-color: #6740E1; border: 1px ridge #4169E1; }
		.bar_3{ background-color: #8D8D8D; border: 1px ridge #D2D2D2; }
		.bar_4{ background-color: #CC8500; border: 1px ridge #FFA500; }
		.bar_5{ background-color: #5B781E; border: 1px ridge #6B8E23; }
		.bar_1:hover{ background-color: red;}
		.bar_2:hover{ background-color: red;}
		.bar_3:hover{ background-color: red;}
		.bar_4:hover{ background-color: red;}
		.bar_5:hover{ background-color: red;}

		/* standard list style table */
		table.statlist {
			background-color: #FFF;
			margin: 0px;
			padding: 0px;
			border-width: 1px;
			border-spacing: 0px;
			width: 100%;
			border: 1px ridge #000;
		}
		table.statlist tr.row0 { background-color: #F5F5F5; }
		table.statlist tr.row1 { background-color: #FFF; }
		table.statlist td {
			border-bottom: 1px solid #e5e5e5;
			font-size: 10px;
			font-weight: normal;
			margin: 2px;
			padding: 2px 2px 2px 4px;
		}
		table.statlist tr.row0:hover { background-color: #f1f1f1; }
		table.statlist tr.row1:hover { background-color: #f1f1f1; }
		table.statlist td.options { background-color: #ffffff; font-size: 8px; }
		table.statlist a:hover { color: red; }
		table.statlist2 { /*border: 1px ridge #000;*/ }
		table.statlist2 td {
			border-bottom: 1px solid #e5e5e5;
			font-size: 10px;
			font-weight: normal;
			padding: 1px;
		}

	/* displayShow() */
		.tablefilter, #topspacer {width:100%; background-color:#ccf;  border-bottom: 1px solid #339; }
		.show_info {background-color:#f0f0f0; border-bottom: 1px solid #bbbbbb;}
		.show_info tr,
		.show_info td {vertical-align: top;text-align: left;}
		.show_plot {background-color:#f6f6f6; border-bottom: 1px solid #bbbbbb;}
		.show_title {font-size: 18px; font-weight: bolder;}
		.show_subtitle,
		.show_id {font-size: 18px; font-weight: bolder; text-align: center;}
		.list_episode { padding: 2px; }
		.thumb{float: left;	margin: 0px 2px 1px 0px;}
		.tabcast td {vertical-align: top;text-align: left;}
		.notavail {color:#ff0000; font-weight:bold; text-align: center;}
		.lent {background-color:#fcc; border-bottom: 1px solid #bbbbbb; text-align: left;}
		.lent tr,
		.lent td {vertical-align: top;text-align: left;}

	/* displayFilter() */
		form {margin: 2px 0px 2px 0px; }
		.thumb {float: left;margin: 0px 2px 1px 0px;}
		.tablelist {font-size: 10px;}
		.tablelist input {height: 20px; font-size: 12px;}
		.filterlink A,
		.filterlink A:visited,
		.filterlink A:link,
		.filterlink A:hover,
		.filterlink {font-weight: bold;	color: #339; text-align:center; }
		select { font-size: 10px;}
		.genreselect input { height: 14px; margin: 0px 0px 0px 0px; }
		.genreselect tr {vertical-align: top; }
		.genreselect td {vertical-align: top;text-align: left; font-size: 10px; }

	/* displayEdit() */
		.editcaption {text-transform: capitalize; }
		.tableborder tr {vertical-align: top;text-align: left; }
		.genreselect td {vertical-align: top;text-align: left; }

	/*- displayLookup() */
		.tablelist td {vertical-align: top;text-align: left; }
		.tablemenu {width:100%; background-color: #339;vertical-align: top;text-align: left;}
		.tabInactive A,
		.tabInactive A:visited,
		.tabInactive A:link,
		.tabInactive A:hover {
			font-size: 11px;
			font-weight: bold;
			height: 18px;
			border-color: #ccccff #333399 #ccccff #ccccff;
			border-style: groove;
			border-width: 2px 1px 0px 2px ;
			margin: 4px 0px 0px 0px;
			padding: 0px 6px 0px 6px;
			background-color:#6666cc;
			color:#ffffff;
			text-decoration: none;
			text-transform: capitalize;
		}
		.tabInactive A:hover { background-color:#ccccff; color:#6666cc;	}
		.tabActive A:visited,
		.tabActive A:link,
		.tabActive A:hover {
			font-size: 11px;
			font-weight:bold;
			height: 22px;
			border-color:#ffffff #333399 #ffffff #ffffff;
			border-style: groove;
			border-width: 2px 1px 0px 2px;
			padding: 2px 6px 2px 6px;
			background-color:#ccccff;
			color:#333399;
			text-decoration:none;
			text-transform: capitalize;
		}
		.tabActive A:hover { background-color:#ccccff; color:#6666cc; }
		.thumbnail {float: left; margin: 5px; }

	/* displayPerson() */
		.personpanel {font-size: 10px}
		.personpanel td {vertical-align: top;text-align: left; }
		.card_stat {
			font-size:	18px;
			font-weight: bolder;
			font-style:	italic;
			text-decoration:none;
			color:		#aaa;
			float:		right;
			text-align: right;
			padding-right: 5px;
		}
//-->
</style>
