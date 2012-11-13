<?php

// Start session
session_start();

// Require basic site files
require("../include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}

include("$config->path_root/include/accesscontrol.inc.php");

if(($_SESSION['bans_delete'] != "yes" ) && ($_SESSION['bans_delete'] != "own" ) && ($_SESSION['bans_edit'] != "yes" ) && ($_SESSION['bans_delete'] != "own" ) && ($_SESSION['bans_unban'] != "yes" ) && ($_SESSION['bans_unban'] != "own" )){
	echo "You do not have the required credentials to view this page.";
	exit();
}

if (isset($_POST['action'])) {

	
if ($_POST['action'] == "delete_ex") { // THIS IS NEW
		$now = date("U");
		$resource = mysql_query("DELETE FROM $config->ban_history WHERE bhid = '".$_POST['bhid']."'") or die(mysql_error());
		$add_log  = mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$now', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'delete ban', 'Ban with BanID ".$_POST['bhid']." deleted')") or die (mysql_error());

		$url	  = "$config->document_root"."/ban_search.php";
		$delay	  = "0";
		//echo "Deleted bid ".$_POST['bid'].". Redirecting...";
		echo "<meta http-equiv=\"refresh\" content=\"".$delay.";url='http://".$_SERVER["HTTP_HOST"]."$url'\">";
		exit();
	} 
	else if ($_POST['action'] == "edit_ex") 
	{// THIS IS NEW

		// Get ban details
		if(isset($_POST['bhid']) && is_numeric($_POST['bhid'])) {
			$resource = mysql_query("SELECT * FROM $config->ban_history WHERE bhid = '".mysql_escape_string($_POST["bhid"])."'") or die(mysql_error());
			//echo "SELECT * FROM $config->ban_history WHERE bhid = '".mysql_escape_string($_POST["bid"])."'";
			if(mysql_num_rows($resource) == 0) {
				trigger_error("Can't find ban with given ID.", E_USER_NOTICE);
			} else {
				$result = mysql_fetch_object($resource);
		
				// Get the AMX username of the admin if the ban was invoked from inside the server
				if($result->server_name <> "website") {
					$query2		= "SELECT nickname FROM $config->amxadmins WHERE steamid = '".$result->admin_id."'";	
					$resource2	= mysql_query($query2) or die(mysql_error());	
					$result2	= mysql_fetch_object($resource2);
					$admin_amxname	= htmlentities($result2->nickname, ENT_QUOTES);
				}
		
				// Prepare all the variables
				$player_name	= $result->player_nick;
				$player_id	= htmlentities($result->player_id, ENT_QUOTES);
				$playa_ip	= $result->player_ip;
				$ban_type	= $result->ban_type;
		
				$ban_start = dateShorttime($result->ban_created);
		
				if(empty($result->ban_length) OR $result->ban_length == 0) {
					$ban_duration = 0;
				} else {
					$ban_duration = $result->ban_length;
				}
		
				$ban_reason = $result->ban_reason;
		
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
					"player_name"	=> isset($player_name) ? $player_name : "",
					"player_id"		=> isset($player_id) ? $player_id : "",
					"player_ip"		=> isset($playa_ip) ? $playa_ip : "",
					"ban_start"		=> isset($ban_start) ? $ban_start : "",
					"ban_duration"	=> isset($ban_duration) ? $ban_duration : "",
					"ban_end"		=> isset($ban_end) ? $ban_end : "",
					"ban_type"		=> isset($ban_type) ? $ban_type : "",
					"ban_reason"	=> isset($ban_reason) ? $ban_reason : "",
					"admin_name"	=> isset($admin_name) ? $admin_name : "",
					"server_name"	=> isset($server_name) ? $server_name : ""
					);	
			}
		}
	
	} 
	else if ($_POST['action'] == "apply_ex") 
	{
		$player_nick = htmlentities($_POST['player_nick'], ENT_QUOTES);
		$ban_reason = htmlentities($_POST['ban_reason'], ENT_QUOTES);

		if($_POST['player_ip'] == "") {
			$resource = mysql_query("UPDATE `$config->ban_history` SET `player_ip` = NULL, `player_id` = '".$_POST['player_id']."', `player_nick` = '$player_nick', `ban_type` = '".$_POST['ban_type']."', `ban_reason` = '$ban_reason', `ban_length` = '".$_POST['ban_length']."' WHERE `bhid` = '".$_POST['bhid']."'") or die (mysql_error());
		} else {
			$resource = mysql_query("UPDATE `$config->ban_history` SET `player_ip` = '".$_POST['player_ip']."', `player_id` = '".$_POST['player_id']."', `player_nick` = '$player_nick', `ban_type` = '".$_POST['ban_type']."', `ban_reason` = '$ban_reason', `ban_length` = '".$_POST['ban_length']."' WHERE `bhid` = '".$_POST['bhid']."'") or die (mysql_error());
		}

		$now = date("U");
		$add_log	= mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$now', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'edit ban', 'Ban with BanID ".$_POST['bhid']." edited')") or die (mysql_error());

		$url		= "$config->document_root"."/ban_search.php";
		$delay		= "0";
		//echo "Edited bid ".$_POST['bid'].". Redirecting...";
		echo "<meta http-equiv=\"refresh\" content=\"".$delay.";url='http://".$_SERVER["HTTP_HOST"]."$url'\">";
		exit();
	}
}


/*
 *
 *		Template parsing
 *
 */

$title = "Edit bandetails";

// Section
$section = "config";

$smarty = new dynamicPage;
$smarty->assign("section",$section);
$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("action", isset($_POST['action']) ? $_POST['action'] : "");
$smarty->assign("bid", isset($_POST['bid']) ? $_POST['bid'] : "");
$smarty->assign("bhid", isset($_POST['bhid']) ? $_POST['bhid'] : "");
$smarty->assign("ban_info",$ban_info);

$smarty->display('main_header.tpl');
$smarty->display('edit_ban_ex.tpl');
$smarty->display('main_footer.tpl');
?>
