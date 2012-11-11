<?php

// Start session
session_start();

// Require basic site files
require("include/config.inc.php"); 	// General configuration settings for the site

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}
include("$config->path_root/include/functions.lang.php");
include("$config->path_root/include/accesscontrol.inc.php");

if($_SESSION['bans_export'] != "yes") {
	echo "You do not have the required credentials to view this page.";
	exit();
}

if (!isset($_POST['gtype'])) {
	$gtype = "all";
} else {
	$gtype = $_POST['gtype'];
}

if (!isset($_POST['bantype'])) {
	$bantype = "perm";
} else {
	$bantype = $_POST['bantype'];
}

// Make the array for the gametypes
$resource = mysql_query("SELECT DISTINCT gametype FROM $config->servers") or die (mysql_error());

$gametypes = array();

while($result = mysql_fetch_object($resource)) {
	$gametype = $result->gametype;

	// Asign variables to the array used in the template
	$gametypes_info = array(
		"gametype"	=> $gametype
		);
	
	$gametypes[] = $gametypes_info;
}

if (isset($_REQUEST['submitted'])) {

	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";

	if ((isset($_POST['include_reason'])) && ($_POST['include_reason'] == "include")) {
		$reason = "on";
	} else {
		$reason = "off";
	}

	$now	 = date('F j, Y, \a\t g:i A');

	// Format the query based on submitted data
	if($gtype != "all") {
		$table = "$config->bans, $config->servers";
	} else {
		$table = "$config->bans";
	}

	if($bantype == "temp") {
		$list_exportbans = "SELECT player_id, ban_reason FROM $table WHERE ban_length != '0'";
	} else if ($bantype == "both") {
		$list_exportbans = "SELECT player_id, ban_reason FROM $table WHERE 1";
	} else {
		$list_exportbans = "SELECT player_id, ban_reason FROM $table WHERE ban_length = '0'";
	}

	if($gtype != "all") {
		$list_exportbans = $list_exportbans." AND $config->bans.server_ip = $config->servers.address AND $config->servers.gametype = '$gtype'";
	}

	$list_exportbans = $list_exportbans." ORDER BY $config->bans.player_id ASC";

	$exportedbans	= mysql_query($list_exportbans) or die (mysql_error());


	$data = array();
	while($myexportbans = mysql_fetch_object($exportedbans)) {

		// Asign variables to the array used in the template
		$mybans = array(
			"steamid"	=> $myexportbans->player_id,
			"reason"	=> $myexportbans->ban_reason
			);
	
		$data[] = $mybans;
	}

/*
	while ($myexportbans	= mysql_fetch_array($exportedbans)) {
		$data[]=$myexportbans[player_id] ;
	}
*/

	if ($data == 0) {
		echo lang("_NOBANMATCH")."</td></tr>";
		echo "<br>";
		exit();
	}  	
}

/****************************************************************
* Template parsing
****************************************************************/

// Header
$title = lang("_EXPORT");

// Section
$section = "export";

// Parsing
$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("gametypes",$gametypes);
$smarty->assign("submitted",get_post('submitted'));
$smarty->assign("exported_bans", isset($data) ? $data : "");
$smarty->assign("include_reason", isset($reason) ? $reason : "");
$smarty->assign("gtype",$gtype);
$smarty->assign("bantype",$bantype);
$smarty->display('main_header.tpl');
$smarty->display('export_bans.tpl');
$smarty->display('main_footer.tpl');

?>