<?php

// Start session
session_start();

// Require basic site files
require("include/config.inc.php");

require("$config->path_root/include/functions.lang.php");
require("$config->path_root/include/functions.inc.php");

/*include("$config->path_root/include/accesscontrol.inc.php");

if( ($_SESSION['bans_add'] != "yes") && ($config->display_search != "enabled") ) {
	echo "You do not have the required credentials to view this page.";
	exit();
}*/


// Add error handling.
if ($config->error_handler == 'enabled') {
	include($config->error_handler_path);
}

// Add geoip.
if ($config->geoip == 'enabled') {
	include("$config->path_root/include/geoip.inc");
}

// Make the array for the admin list
$query      = "SELECT DISTINCT username, nickname FROM $config->amxadmins ORDER BY nickname ASC";
$resource   = mysql_query($query) or die(mysql_error());

$admin_array    = array();

while($result = mysql_fetch_object($resource)) {
    $steamid    = $result->username;
    $nickname   = htmlentities($result->nickname, ENT_QUOTES);


	// Asign variables to the array used in the template
	$admin_info = array(
		"steamid"	=> $steamid,
		"nickname"	=> $nickname
		);
	
	$admin_array[] = $admin_info;
}

// Make the array for the server list
$query2		= "SELECT DISTINCT address, hostname FROM $config->servers ORDER BY hostname ASC";
$resource2	= mysql_query($query2) or die(mysql_error());
	
$server_array	= array();

while($result2 = mysql_fetch_object($resource2)) {
	$address	= $result2->address;
	$hostname	= htmlentities($result2->hostname, ENT_QUOTES);


	// Asign variables to the array used in the template
	$server_info = array(
		"address"	=> $address,
		"hostname"	=> $hostname
		);
	
	$server_array[] = $server_info;
}

// SquarePants
// Make the array for the reason list

$query6 = "SELECT DISTINCT reason FROM $config->reasons ORDER BY reason";
$resource6  = mysql_query($query6) or die(mysql_error());

$reason_array   = array();

while($result6 = mysql_fetch_object($resource6)) {
    $reasons    = $result6->reason;

    // Asign variables to the array used in the template
    $reason_info = array(
        "reasons"   => $reasons,
        );

    $reason_array[] = $reason_info;
}
//

if ((isset($_GET['q']))) {
	// Make the array for the active bans list
	if ($_GET['type'] == 'playername') {
		$resource3    = mysql_query("SELECT * FROM $config->bans WHERE player_nick LIKE '%".$_GET['q']."%' ORDER BY ban_created DESC") or die(mysql_error());
	}
	else if ($_GET['type'] == 'steamid') {
		$resource3	= mysql_query("SELECT * FROM $config->bans WHERE player_id = '".$_GET['q']."' AND ban_type='S'  ORDER BY ban_created DESC") or die(mysql_error());
	}
    else if ($_GET['type'] == 'ipaddress') {
        $resource3  = mysql_query("SELECT * FROM $config->bans WHERE player_ip LIKE '%".$_GET['q']."%' AND ban_type='S' ORDER BY ban_created DESC") or die(mysql_error());
    }
	else if (isset($_GET['reason'])) {
		$resource3	= mysql_query("SELECT * FROM $config->bans WHERE ban_reason LIKE '%".$_GET['reason']."%' ORDER BY ban_created DESC") or die(mysql_error());
	}
	else if (isset($_GET['date'])) {
		$date		= substr_replace($_GET['date'], '', 2, 1);
		$date		= substr_replace($date, '', 4, 1);
		$resource3	= mysql_query("SELECT * FROM $config->bans WHERE FROM_UNIXTIME(ban_created,'%d%m%Y') LIKE '$date' ORDER BY ban_created DESC") or die(mysql_error());
	}
	else if (isset($_GET['admin'])) {
		$resource3	= mysql_query("SELECT * FROM $config->bans WHERE admin_id = '".$_GET['admin']."' ORDER BY ban_created DESC") or die(mysql_error());
	}
	else if (isset($_GET['server'])) {
		$resource3	= mysql_query("SELECT * FROM $config->bans WHERE server_ip = '".$_GET['server']."' ORDER BY ban_created DESC") or die(mysql_error());
	}
	else  {
		echo "KOE";
	}
	$ban_array	= array();
	$timezone = $config->timezone_fix * 3600;
	$bancount = 0;

	while($result3 = mysql_fetch_object($resource3)) {
		$bid = $result3->bid;
		$date = dateShorttime($result3->ban_created + $timezone);
		
		$playernick	= htmlentities($result3->player_nick, ENT_QUOTES);
        $playerid = $result3->player_id;
        $playerip = $result3->player_ip;
        
		$adminnick = htmlentities($result3->admin_nick, ENT_QUOTES);
        $adminid = htmlentities($result3->admin_id, ENT_QUOTES);
        
		$reason = htmlentities($result3->ban_reason, ENT_QUOTES);
		$duration = $result3->ban_length;
		$serverip = $result3->server_ip;
        $servername = $result3->server_name;
		$bancount = $bancount+1;
	    $bantype = $result3->ban_type;
	    
		if ($serverip != "") {

			// Get the gametype for each ban
			$query4		= "SELECT gametype FROM $config->servers WHERE address = '$serverip'";
			$resource4	= mysql_query($query4) or die(mysql_error());
			while($result4 	= mysql_fetch_object($resource4)) {
				$gametype = $result4->gametype;
			}
		} else {
			$gametype = "html";
		}

		if(empty($duration)) {
			$duration = lang("_PERMANENT");
		}	else {
			$duration = "$duration " . lang("_MINS");
		}
	
		// Asign variables to the array used in the template
		$ban_info = array(
			"gametype" => $gametype,
			"bid" => $bid,
			"date" => $date,
			
			"playernick" => $playernick,
			"playerid" => $playerid,
			"playerip" => $playerip,
			
            "adminnick" => $adminnick,
			"adminid"	=> $adminid,
			
			"reason" => $reason,
			"duration" => $duration,
			"serverip" => $serverip,
			"servername" => $servername,
			"bancount" => $bancount,
			"bantype" => $bantype
			);
	
		$ban_array[] = $ban_info;
	}

	// Make the array for the expired bans list

	if (isset($_GET['q'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE player_nick like '%".$_GET['q']."%' ORDER BY ban_created DESC";
	} else if (isset($_GET['steamid'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE (player_id = '".$_GET['steamid']."' AND ban_type='S' ) OR ( player_ip='".$_GET['ip']."' AND ban_type='SI')  ORDER BY ban_created DESC";
	} else if (isset($_GET['reason'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE ban_reason LIKE '%".$_GET['reason']."%' ORDER BY ban_created DESC";
	} else if (isset($_GET['date'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE FROM_UNIXTIME(ban_created,'%d%m%Y') LIKE '$date' ORDER BY ban_created DESC";
	} else if (isset($_GET['timesbanned'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip, COUNT(*) FROM $config->ban_history GROUP BY player_id HAVING COUNT(*) >= '".$_GET['timesbanned']."' ORDER BY ban_created DESC";
	} else if (isset($_GET['admin'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE admin_id = '".$_GET['admin']."' ORDER BY ban_created DESC";
	} else if (isset($_GET['server'])) {
		$query5	= "SELECT bhid, player_nick, admin_nick, ban_length, ban_reason, ban_created, server_ip FROM $config->ban_history WHERE server_ip = '".$_GET['server']."' ORDER BY ban_created DESC";
}

	$resource5	= mysql_query($query5) or die(mysql_error());
	$exban_array	= array();
	$ex_bancount = 0;

	while($result5 = mysql_fetch_object($resource5)) {
		$bhid		= $result5->bhid;
		$ex_date	= dateShorttime($result5->ban_created + $timezone);
		$ex_player	= $result5->player_nick;
		$ex_admin	= htmlentities($result5->admin_nick, ENT_QUOTES);
		$ex_reason      = $result5->ban_reason;
		$ex_duration	= $result5->ban_length;
		$ex_serverip	= $result5->server_ip;
		
		$ex_bancount = $ex_bancount+1;

		if ($ex_serverip != "") {

			// Get the gametype for each ban
			$query6		= "SELECT gametype FROM $config->servers WHERE address = '$ex_serverip'";
			$resource6	= mysql_query($query6) or die(mysql_error());

			$ex_gametype = NULL;
			while($result6 = mysql_fetch_object($resource6)) {
				$ex_gametype = $result6->gametype;
			}
			
			// If a ban that have a serverip that's NOT in the table amx_serverinfo use the steam icon
			if ($ex_gametype == "")
				$ex_gametype = "steam";
				
		} else {
			$ex_gametype = "html";
		}

		if(empty($ex_duration)) {
			$ex_duration = lang("_PERMANENT");
		}	else {
			$ex_duration = "$ex_duration " . lang("_MINS");
		}
	
		// Asign variables to the array used in the template
		$exban_info = array(
			"ex_gametype"	=> $ex_gametype,
			"bhid"		=> $bhid,
			"ex_date"	=> $ex_date,
			"ex_player"	=> $ex_player,
			"ex_admin"	=> $ex_admin,
			"ex_reason"	=> $ex_reason,
			"ex_duration"	=> $ex_duration,
			"ex_bancount"	=> $ex_bancount
			);
	
		$exban_array[] = $exban_info;
	}
}

/****************************************************************
* Template parsing
****************************************************************/

// Header
$title = lang("_SEARCH");

// Section
$section = "search";

// Parsing
$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("dir",$config->document_root);

$smarty->assign("fancy_layers", $config->fancy_layers);
$smarty->assign("display_reason", $config->display_reason);
$smarty->assign("display_search", $config->display_search);
$smarty->assign("display_admin", $config->display_admin);

$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("section",$section);
$smarty->assign("admins",$admin_array);
$smarty->assign("servers",$server_array);
$smarty->assign("bans", isset($ban_array) ? $ban_array : NULL);
$smarty->assign("exbans", isset($exban_array) ? $exban_array : NULL);

if ( isset($_GET['q']) )
{
	$smarty->assign("nick", get_post('q'));
}
if ( isset($_GET['steamid']) )
{
	$smarty->assign("steamid", get_post('steamid'));
}
if ( isset($_GET['ip']) )
{
	$smarty->assign("ip", get_post('ip'));
}
if ( isset($_GET['reason']) )
{
	$smarty->assign("reason", get_post('reason'));
}
if ( isset($_GET['date']) )
{
	$smarty->assign("date", get_post('date'));
}
if ( isset($_GET['timesbanned']) )
{
	$smarty->assign("timesbanned", get_post('timesbanned'));
}
if ( isset($_GET['admin']) )
{
	$smarty->assign("admin", get_post('admin'));
}
if ( isset($_GET['server']) )
{
	$smarty->assign("server", get_post('server'));
}
$smarty->display('main_header.tpl');
$smarty->display('ban_search.tpl');
$smarty->display('main_footer.tpl');

?>
