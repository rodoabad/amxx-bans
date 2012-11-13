<?php

// Start session
session_start();

// Require basic site files
require("../include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}

if ($config->geoip == "enabled") {
	include("$config->path_root/include/geoip.inc");
}

include("$config->path_root/include/functions.lang.php");
include("$config->path_root/include/accesscontrol.inc.php");

if($_SESSION['bans_add'] != "yes") {
	echo lang("_NOACCESS");
	exit();
}

if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
	$browser = "IE";
} else {
	$browser = "MO";
}

if ($config->rcon_class == "one") {
	include("$config->path_root/include/class_hlsi.php");
} else if ($config->rcon_class == "two") {
	include("$config->path_root/include/rcon_hl_net.inc");
}

if ((isset($_POST['submit'])) && ($_POST['submit'] == lang("_KICKBAN"))) {

	// get my steamID
	$get_admin		= mysql_query("SELECT * FROM $config->webadmins WHERE username = '".$_SESSION['uid']."'") or die (mysql_error());
	$my_admin			= mysql_fetch_object($get_admin);
	$admin_id			= $my_admin->steamid;
	$ban_created	= date("U");
	$server_name	= "website";

	// ban! ban! ban!
	if ( $_POST['player_id'] == "STEAM_ID_LAN" || $_POST['player_id'] == "VALVE_ID_LAN" || $_POST['player_id'] == "HLTV" )
		$_POST['player_id'] = "";
	
	$insert_ban		= mysql_query("INSERT INTO $config->bans (player_ip, player_id, player_nick, admin_ip, admin_id, admin_nick, ban_type, ban_reason, ban_created, ban_length, server_name) VALUES ('".$_POST['player_ip']."', '".$_POST['player_id']."', '".$_POST['player_nick']."', '".$_SERVER["REMOTE_ADDR"]."', '$admin_id', '".$_SESSION['uid']."', '".$_POST['ban_type']."', '".$_POST['ban_reason']."', '$ban_created', '".$_POST['ban_length']."', '$server_name')") or die (mysql_error());

	//fetch server_information
	$resource3	= mysql_query("SELECT * FROM $config->servers WHERE id = '".$_POST['server_id']."'") or die (mysql_error());
	$result3		= mysql_fetch_object($resource3);

	if ($config->rcon_class == "one") {

		// create class
		$gspy = new HLSERVER_INFOS($result3->address);
		$gspy->win32 = false; // set this according to your server

		// connection
		if ($gspy->connect() == false) {
			if ($gspy->errno != '') {
				echo 'Error no.' . $gspy->errno . ' : ' . $gspy->errstr;
			} else {
				echo 'Error : ' . $gspy->error;
			}
		}	else {

			if ($gspy->rcon($result3->rcon,"kick \"".$_POST['player_nick']."\"") == false) {
				$kick_success = 0;
			} else if ($gspy->serv_rcon_response != '') {
				$kick_success = 1;
			} else {
				$kick_success = 1;
			}
		}
	
	} else if ($config->rcon_class == "two") {

		$split_address = explode (":", $result3->address);
		$eye_pee	= $split_address['0'];
		$poort		= $split_address['1'];

		$server = new Rcon();
		$server->Connect($eye_pee, $poort, $result3->rcon);

		$info		= $server->Info();
		$result	= $server->RconCommand("kick \"".$_POST['player_nick']."\"");

		if(trim($result) == "Bad rcon_password.") {
			$kick_success = 0;
		} else {
			$kick_success = 1;
		}

		//close connection
		$server->Disconnect();

	}
}

//make an array for the servers...
$resource = mysql_query("SELECT * FROM $config->servers ORDER BY hostname ASC") or die (mysql_error());

if ($config->rcon_class == "one") {
	$gspy = new HLSERVER_INFOS();
	$gspy->win32 = false; // set this according to your server
}



$server_array	= array();

while($result = mysql_fetch_object($resource)) {

	if ($config->rcon_class == "one") {
		if ( $gspy->connect($result->address,'',true,false,false) == false) {
			if ($gspy->errno != '') {
				$info_error = 1;
			} else {
				//echo 'Error : ' . $gspy->error;
			}
		} else {
			$gspy->parse();
		}

		$curplayers = $gspy->get_info('players','-');
		$maxplayers = $gspy->get_info('maxplayers','-');

	} else if ($config->rcon_class == "two") {

		$split_address = explode (":", $result->address);
		$eye_pee	= $split_address['0'];
		$poort		= $split_address['1'];

		$server = new Rcon();
		$server->Connect($eye_pee, $poort, $result->rcon);
		$info = $server->Info();

		$curplayers = $info["activeplayers"];
		$maxplayers = $info["maxplayers"];
	}

	$server_info = array(
		"server_id"				=> $result->id,
		"hostname"				=> $result->hostname,
		"address"					=> $result->address,
		"gametype"				=> $result->gametype,
		"curplayers"			=> $curplayers,
		"maxplayers"			=> $maxplayers
		);

	$server_array[] = $server_info;
}

if (isset($_POST['live_player_ban']) && $_POST['live_player_ban'] == "true") {

	//create array of admin steamIDs
	$resource = mysql_query("SELECT DISTINCT steamid, username FROM $config->amxadmins, $config->admins_servers WHERE $config->amxadmins.id = $config->admins_servers.admin_id") or die (mysql_error());
	$admin_steamids_array	= array();
	$admin_usernames_array	= array();

	while($result = mysql_fetch_object($resource)) {
		$admin_steamids_array[] = $result->steamid;
		$admin_usernames_array[] = $result->username;
	}

	//fetch server_information
	$resource2	= mysql_query("SELECT * FROM $config->servers WHERE id = '".$_POST['server_id']."'") or die (mysql_error());
	$result2		= mysql_fetch_object($resource2);


	if ($config->rcon_class == "one") {
		$gspy = new HLSERVER_INFOS($result2->address);
		$gspy->win32 = false; // set this according to your server

		// connection
		if ($gspy->connect() == false) {
			if ($gspy->errno != '') {
				echo 'Error no.' . $gspy->errno . ' : ' . $gspy->errstr;
			} else {
				echo 'Error : ' . $gspy->error;
			}
		}	else {

			if ($gspy->rcon($result2->rcon,"amx_list") == false) {
				echo 'Error : ' . $gspy->error;
			} else if ($gspy->serv_rcon_response != '') {
				//echo 'Server has responded : ' . $gspy->serv_rcon_response;
				$response = $gspy->serv_rcon_response;
			} else {
				//echo 'Command has been sent but no response has been receveid (does not indicate an error)';
				$empty_result = "Command has been sent but no response has been received (does not indicate an error)";
			}
		}
	} else if ($config->rcon_class == "two") {

		$split_address = explode (":", $result2->address);
		$eye_pee	= $split_address['0'];
		$poort		= $split_address['1'];

		$server = new Rcon();
		$server->Connect($eye_pee, $poort, $result2->rcon);

		//Action
		$response = $server->RconCommand("amx_list");

		//close connection
		$server->Disconnect();

	}

	$lists = explode("#WM#", $response);

	if(ereg("ogeoip", $lists['0'])){
		$geoip = "off";
	} else {
		$geoip = "on";
	}
	
	$lists = array_slice($lists, 1);

	$player_array	= array();

	foreach ($lists as $list) {
		$list_2 = explode ("#WMW#", $list);

		if (in_array($list_2['1'], $admin_steamids_array) || in_array($list_2['2'], $admin_usernames_array) || in_array($list_2['0'], $admin_usernames_array)) {
			$is_admin = 1;
		} else {
			$is_admin = 0;
		}

		if ($config->geoip == "enabled") {
			$gi = geoip_open("$config->path_root/include/GeoIP.dat",GEOIP_STANDARD);
			$cc = geoip_country_code_by_addr($gi, $list_2['2']);
			$cn = geoip_country_name_by_addr($gi, $list_2['2']);
			geoip_close($gi);
		} else {
			$cc = "";
			$cn = "";
		}

		$player_info = array(
			"nick"			=> htmlentities($list_2['0'], ENT_QUOTES),
			"steamid"		=> $list_2['1'],
			"ip"				=> $list_2['2'],
			"cc"				=> $cc,
			"cn"				=> $cn,
			"is_admin"	=> $is_admin
			);
	
		$player_array[] = $player_info;
	}
}


/*
 *
 * 		Template parsing
 *
 */

// Header
$title = lang("_ADDLIVEBAN");

// Section
$section = "addliveban";

// Parsing
$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("browser",$browser);


$smarty->assign("live_player_ban", get_post('live_player_ban'));
$smarty->assign("geoip", $config->geoip);
$smarty->assign("servers",$server_array);
$smarty->assign("players", isset($player_array) ? $player_array : NULL);
$smarty->assign("empty_result",isset($empty_result) ? $empty_result : NULL);
$smarty->assign("post",$_POST);

$smarty->display('main_header.tpl');
$smarty->display('add_live_ban.tpl');
$smarty->display('main_footer.tpl');

?>
