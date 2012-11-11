<?php

// Start session
session_start();

// Require basic site files

require("../include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}
include("$config->path_root/include/functions.lang.php");
include("$config->path_root/include/accesscontrol.inc.php");
//include("$config->path_root/include/class_hlsi.php");

if(($_SESSION['amxadmins_edit'] != "yes") || ($config->admin_management != "enabled")) {
	echo lang("_NOACCESS");
	exit();
}

//display_post_get();

if ((isset($_GET['action'])) && ($_GET['action'] == "apply")) {

	foreach($_GET as $key => $value) {
		if (is_numeric($key)) {

			// check if admin was active on this server...
			$resource = mysql_query("SELECT COUNT(admin_id) AS get_adm FROM $config->admins_servers WHERE admin_id = '$key' AND server_id = '".$_GET['server_id']."'") or die (mysql_error());
			$result = mysql_fetch_object($resource);

			if ($result->get_adm == 0) {
				if($value == "on") {
					$resource = mysql_query("INSERT INTO $config->admins_servers VALUES('$key', '".$_GET['server_id']."')") or die (mysql_error());

					$now = date("U");
					$add_log	= mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$now', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'serveradmins', 'Assigned AdminID $key to ServerID ".$_GET['server_id']."')") or die (mysql_error());
				}
			}	else if ($result->get_adm == 1) {
				if($value == "off") {
					$resource = mysql_query("DELETE FROM $config->admins_servers WHERE admin_id = '$key' AND server_id = '".$_GET['server_id']."'") or die (mysql_error());

					$now = date("U");
					$add_log	= mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$now', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'serveradmins', 'Removed AdminID $key from ServerID ".$_GET['server_id']."')") or die (mysql_error());
				}
			} else {
				echo "Duplicate entry found?";
			}
		}
	}
}

// get a list of servers...
$resource = mysql_query("SELECT id, hostname, amxban_version FROM $config->servers ORDER BY hostname ASC") or die (mysql_error());

while($result = mysql_fetch_object($resource)) {

	$checkplug	= explode ("_", $result->amxban_version);
	$amx_version	= $checkplug['0'];

	//echo "<h2>$amx_version</h2>";

	// Asign variables to the array used in the template
	$server_info = array(
		"id"		=> $result->id,
		"hostname"	=> $result->hostname,
		"amxversion"	=> $amx_version
		);
	
	$server_array[] = $server_info;
}

if ( isset($_GET['server_id']) && $_GET['server_id'] != "xxx")
{
	$serverid = $_GET['server_id'];

	// get a list of admins for this server
	$resource2 = mysql_query("SELECT admin_id FROM $config->admins_servers WHERE server_id = '$serverid'") or die (mysql_error());
	$these_admins = array();

	while($result2 = mysql_fetch_object($resource2)) {

		//get their user- and nicknames too
		$resource2a	= mysql_query("SELECT username, nickname FROM $config->amxadmins WHERE id = '$result2->admin_id' ORDER BY access DESC") or die (mysql_error());

		while($result2a = mysql_fetch_object($resource2a)) {
			$admin_info = array(
				"id"		=> $result2->admin_id,
				"username"	=> $result2a->username,
				"nickname"	=> $result2a->nickname
				);
		}
		$these_admins[] = $admin_info;
	}

	$resource3	= mysql_query("SELECT admin_id FROM $config->admins_servers WHERE server_id = '$serverid'") or die (mysql_error());
	$these_adminids = array();

	while($result3 = mysql_fetch_object($resource3)) {
		$these_adminids[] = $result3->admin_id;
	}

	// get a list of all adminIDs (but not those who are active for this server...
	$resource3	= mysql_query("SELECT id, username, nickname FROM $config->amxadmins WHERE username IS NOT NULL AND username != '' ORDER BY id ASC") or die (mysql_error());
	$all_admins	= array();

	while($result3 = mysql_fetch_object($resource3)) {
		
		if(in_array($result3->id, $these_adminids)) {
			$admin_info = array(
				"id"		=> $result3->id,
				"username"	=> $result3->username,
				"nickname"	=> $result3->nickname,
				"checked"	=> 1
				);
		} else {
			$admin_info = array(
				"id"		=> $result3->id,
				"username"	=> $result3->username,
				"nickname"	=> $result3->nickname,
				"checked"	=> 0
				);
		}

		$all_admins[] = $admin_info;
	}
}

/*
 *
 * Template parsing
 *
 */

$title	= "Serveradmins";

// Section
$section = "server_admins";

$smarty	= new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this", $_SERVER['PHP_SELF']);
$smarty->assign("submitted",get_post('submitted'));

$smarty->assign("thisserver", isset($serverid) ? $serverid : NULL);
$smarty->assign("servers", isset($server_array) ? $server_array : NULL);
$smarty->assign("all_admins", isset($all_admins) ? $all_admins : NULL);
$smarty->assign("these_admins", isset($these_admins) ? $these_admins : NULL);

$smarty->display('main_header.tpl');
$smarty->display('server_admins.tpl');
$smarty->display('main_footer.tpl');

?>