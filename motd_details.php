<?php

// Start session
session_start();

// Require basic site files
require("include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}

include("$config->path_root/include/functions.lang.php");

require("$config->path_root/include/functions.inc.php");

// Get ban details
if((isset($_GET["bid"]) AND is_numeric($_GET["bid"])) OR (isset($_GET["bhid"]) AND is_numeric($_GET["bhid"]))) {
	if(isset($_GET["bid"])) {
		$query = "SELECT * FROM $config->bans WHERE bid = '".mysql_escape_string($_GET["bid"])."'";
	} else {
		$query = "SELECT * FROM $config->ban_history WHERE bhid = '".mysql_escape_string($_GET["bhid"])."'";
	}
	
	$resource = mysql_query($query) or die(mysql_error());	
	$numrows = mysql_num_rows($resource);
	
	if(mysql_num_rows($resource) == 0) {
		trigger_error("Can't find ban with given ID.", E_USER_NOTICE);
	} else {
		$result = mysql_fetch_object($resource);
		
		// Get the AMX username of the admin if the ban was invoked from inside the server
		if($result->server_name <> "website") {
			$query2 = "SELECT nickname FROM $config->amxadmins WHERE steamid = '".$result->admin_id."'";	
			$resource2 = mysql_query($query2) or die(mysql_error());	
			$result2 = mysql_fetch_object($resource2);
			
			$admin_amxname = htmlentities($result2->nickname, ENT_QUOTES);
		}
		
		// Prepare all the variables
		$player_name = htmlentities($result->player_nick, ENT_QUOTES);
		$player_id = htmlentities($result->player_id, ENT_QUOTES);
		
		if(!empty($result->player_ip)) {
			$player_ip = htmlentities($result->player_ip, ENT_QUOTES);
		} else {
			$player_ip = "<i><font color='#677882'>no IP address present</font></i>";
		}
		
		$ban_start = dateShorttime($result->ban_created);
		
		if(empty($result->ban_length) OR $result->ban_length == 0) {
			$ban_duration = "Permanent";
			$ban_end = "<i><font color='#677882'>Not applicable</font></i>";
		} else {
			$ban_duration = $result->ban_length." mins";
			$date_and_ban = $result->ban_created + ($result->ban_length * 60);

			$now = date("U");
			if($now >= $date_and_ban) {
				$ban_end = dateShorttime($date_and_ban)."&nbsp;(allready expired)";
			} else {
				$ban_end = dateShorttime($date_and_ban)."&nbsp;(".timeleft($now,$date_and_ban)." remaining)";
			}
		}
		
		if($result->ban_type == "SI") {
			$ban_type = "SteamID and/or IP address";
		} else {
			$ban_type = "SteamID";
		}
		
		$ban_reason = htmlentities($result->ban_reason, ENT_QUOTES);
		
		if($result->server_name <> "website") {
			$query2 = "SELECT nickname FROM $config->amxadmins WHERE steamid = '".$result->admin_id."'";	
			$resource2 = mysql_query($query2) or die(mysql_error());	
			$result2 = mysql_fetch_object($resource2);
			
			$admin_name = htmlentities($result->admin_nick, ENT_QUOTES)." (".htmlentities($result2->nickname, ENT_QUOTES).")";
			$server_name = $result->server_name;
		} else {
			$admin_name = htmlentities($result->admin_nick, ENT_QUOTES);
			$server_name = "Website";
		}
		
		$ban_info = array(
			"player_name"	=> $player_name,
			"player_id"	=> $player_id,
			"player_ip"	=> $player_ip,
			"ban_start"	=> $ban_start,
			"ban_duration"	=> $ban_duration,
			"ban_end"	=> $ban_end,
			"ban_type"	=> $ban_type,
			"ban_reason"	=> $ban_reason,
			"admin_name"	=> $admin_name,
			"server_name"	=> $server_name
			);	
		
		if(isset($_GET["bhid"])) {
			$unban_info = array(
				"verify"	=> TRUE,
				"unban_start"	=> dateShorttime($result->unban_created),
				"unban_reason"	=> htmlentities($result->unban_reason, ENT_QUOTES),
				"admin_name"	=> $result->unban_admin_nick
				);
		}
	}
	
	if(isset($_GET["bid"])) {
		// Make the array for the history ban list
		if($result->player_id <> "")
		{
			$query = "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE player_id = '".$result->player_id."' ORDER BY ban_created DESC";
		}
		else // Search for IP bans
		{
			$query = "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE player_ip = '".$result->player_ip."' ORDER BY ban_created DESC";
		}
		$resource = mysql_query($query) or die(mysql_error());
		
		$unban_array = array();
		
		while($result = mysql_fetch_object($resource)) {
			$bhid = $result->bhid;
			$date = dateMonth($result->ban_created);
			$player = htmlentities($result->player_nick, ENT_QUOTES);
			$admin = htmlentities($result->admin_nick, ENT_QUOTES);
			$reason = htmlentities($result->ban_reason, ENT_QUOTES);
			$duration = $result->ban_length;
			
			if(empty($duration)) {
				$duration = lang("_PERMANENT");
			}
			
			else {
				$duration = "$duration" . lang("_MINS");
			}
			
			// Asign variables to the array used in the template
			$unban_info = array(
				"bhid" => $bhid,
				"date" => $date,
				"player" => $player,
				"admin" => $admin,
				"reason" => $reason,
				"duration" => $duration
				);
			
			$unban_array[] = $unban_info;
		}
		
		$history = TRUE;
	}
}


/****************************************************************
* Template parsing						*
****************************************************************/


$title = "Bandetails";

$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("working_title","home");
$smarty->assign("dir",$config->document_root);
$smarty->assign("display_admin", $config->display_admin);
$smarty->assign("ban_info",$ban_info);
$smarty->assign("unban_info",$unban_info);
$smarty->assign("history",$history);
$smarty->assign("bhans",$unban_array);
$smarty->assign("parsetime",$parsetime);

$smarty->display('motd_details.tpl');
?>