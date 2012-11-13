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


if($_SESSION['bans_add'] != "yes") {
	echo lang("_NOPERM");
	exit();
}

if ((isset($_POST['action'])) && ($_POST['action'] == "insert")) {
	//display_post_get();

	if (($_POST['ban_type'] == "SI") && (empty($_POST['player_ip'])))
	{
		echo "You need to specify an IP-address.";
	}
	else if ( isset($_POST['player_id']) && strlen( $_POST['player_id'] ) == 0 && ($_POST['ban_type'] != "SI") )
	{
		echo "You need to specify a player steam id to ban.";
		exit();
	}
	else
	{
		// get my steamID
		$result	= mysql_query("SELECT steamid FROM $config->amxadmins WHERE nickname = '".$_SESSION['uid']."'");
		
		$admin_id = "";

		if ( $result && mysql_num_rows($result) > 0 )
		{
			$val = mysql_fetch_object($result);
			$admin_id = $val->steamid;
		}

		// check if player_id already exists
		$check_steamid	= mysql_query("SELECT COUNT(player_id) as ban_exists FROM $config->bans WHERE player_id != '' AND player_id = '".$_POST['player_id']."'") or die (mysql_error());
		$got_steamid		= mysql_fetch_object($check_steamid);

		if ($got_steamid->ban_exists != 0) {
			echo "An active ban with SteamID '".$_POST['player_id']."' already exists...";
			exit();
		} else {
			$ban_created = date("U");
			$server_name = "website";
			$player_nick = $admin_amxname	= $_POST['player_nick'];

			if (empty($_POST['player_ip'])) {
				$insert_ban = mysql_query("INSERT INTO $config->bans (player_id, player_nick, admin_ip, admin_id, admin_nick, ban_type, ban_reason, ban_created, ban_length, server_name) VALUES ('".$_POST['player_id']."', '$player_nick', '".$_SERVER["REMOTE_ADDR"]."', '$admin_id', '".$_SESSION['uid']."', '".$_POST['ban_type']."', '".$_POST['ban_reason']."', '$ban_created', '".$_POST['ban_length']."', '$server_name')") or die (mysql_error());
				$add_log		= mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$ban_created', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'add ban', 'banned user by SteamID (".$_POST['player_id'].")')") or die (mysql_error());
			} else {
				$insert_ban = mysql_query("INSERT INTO $config->bans (player_ip, player_id, player_nick, admin_ip, admin_id, admin_nick, ban_type, ban_reason, ban_created, ban_length, server_name) VALUES ('".$_POST['player_ip']."', '".$_POST['player_id']."', '$player_nick', '".$_SERVER["REMOTE_ADDR"]."', '$admin_id', '".$_SESSION['uid']."', '".$_POST['ban_type']."', '".$_POST['ban_reason']."', '$ban_created', '".$_POST['ban_length']."', '$server_name')") or die (mysql_error());
				$add_log		= mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$ban_created', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'add ban', 'banned user by SteamID and IP (".$_POST['player_id']." / ".$_POST['player_ip'].")')") or die (mysql_error());
			}

			$url		= "$config->document_root";
			$delay	= "2";
			//echo "Added ban. Redirecting...";
			echo "<meta http-equiv=\"refresh\" content=\"".$delay.";url='http://".$_SERVER["HTTP_HOST"]."$url'\">";
			exit();
		}
	}
}


/*
 *
 * 		Template parsing
 *
 */

// Header
$title = lang("_ADDBAN");

// Section
$section = "addban";

// Parsing
$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);

//$smarty->assign("servers",$server_array);
//$smarty->assign("players",$player_array);
//$smarty->assign("empty_result",$empty_result);
//$smarty->assign("post",$_POST);

$smarty->display('main_header.tpl');
$smarty->display('add_ban.tpl');
$smarty->display('main_footer.tpl');

?>
