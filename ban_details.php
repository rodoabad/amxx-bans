<?php

// Start session
session_start();

// Require basic site files
require("include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}

if ($config->geoip == "enabled") {
    include("$config->path_root/include/geoip.inc");
    include("$config->path_root/include/geoipcity.inc");
    include("$config->path_root/include/geoipregionvars.php");
}

require("$config->path_root/include/functions.lang.php");
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
		if($result->server_name != "website") {
			//$query2 = "SELECT nickname FROM $config->amxadmins WHERE steamid = '".$result->admin_id."'";
			$query2 = "SELECT nickname FROM $config->amxadmins WHERE username = '".$result->admin_id."' OR username = '".$result->admin_ip."' OR username = '".$result->admin_nick."'";		
			$resource2 = mysql_query($query2) or die(mysql_error());	
			$result2 = mysql_fetch_object($resource2);
			
			$admin_amxname = htmlentities(($result2) ? $result2->nickname : "", ENT_QUOTES);
		}
		
		// Prepare all the variables
		//$player_name = htmlentities($result->player_nick, ENT_QUOTES);
		$player_name = $result->player_nick;
		
		if(!empty($result->player_ip)) {
			$player_ip = htmlentities($result->player_ip, ENT_QUOTES);
		} else {
			$player_ip = "<i><font color='#677882'>" . lang("_NOIP") . "</font></i>";
		}
		
		if(!empty($result->player_id)) {
			$player_id = htmlentities($result->player_id, ENT_QUOTES);
		} else {
			//$player_id = "<i><font color='#677882'>" . lang("_NOSTEAMID") . "</font></i>";
			$player_id = "&nbsp;";
		}
		
		$timezone = $config->timezone_fix * 3600;
		$ban_start = dateShorttime($result->ban_created + $timezone);
		
		if(empty($result->ban_length) OR $result->ban_length == 0) {
			$ban_duration = lang("_PERMANENT");
			$ban_end = "" . lang("_NOTAPPLICABLE") . "";
		} else {
			
			//echo $timezone;
			$ban_duration = $result->ban_length."&nbsp;" . lang("_MINS");
			$date_and_ban = $result->ban_created + $timezone + ($result->ban_length * 60);

			$now = date("U");
			if($now >= $date_and_ban) {
				$ban_end = dateShorttime($date_and_ban)."&nbsp;(" . lang("_ALREADYEXP") . ")";
			} else {
				$ban_end = dateShorttime($date_and_ban)."&nbsp;(".timeleft($now + $timezone,$date_and_ban)."&nbsp;".lang("_REMAINING").")";
			}
		}
		
		if($result->ban_type == "SI") {
			$ban_type = lang("_STEAMID&IP");
		} else {
			$ban_type = "Steam ID";
		}
		
		//$ban_reason = htmlentities($result->ban_reason, ENT_QUOTES);
		$ban_reason = $result->ban_reason;
		
		if($result->server_name != "website") {
			//$query2 = "SELECT nickname FROM $config->amxadmins WHERE steamid = '".$result->admin_id."'";
			$query2 = "SELECT nickname FROM $config->amxadmins WHERE username = '".$result->admin_id."' OR username = '".$result->admin_ip."' OR username = '".$result->admin_nick."'";	
			$resource2 = mysql_query($query2) or die(mysql_error());	
			$result2 = mysql_fetch_object($resource2);
			
			//$admin_name = htmlentities($result->admin_nick, ENT_QUOTES)." (".htmlentities(($result2) ? $result2->nickname : "", ENT_QUOTES).")";
			$server_name = $result->server_name;
            $server_ip = $result->server_ip;
            $admin_name = htmlentities($result2->nickname, ENT_QUOTES);
		} else {
			$admin_name = htmlentities($result->admin_nick, ENT_QUOTES);
			$server_name = lang("_WEBSITE");
		}

		if(isset($_GET["bid"])) {
			$id_type = "bid";
			$id = $_GET["bid"];
		} else {
			$id_type = "bhid";
			$id = $_GET["bhid"];
		}


        // Convert IP to Country Names + country Codes
        if ($config->geoip == 'enabled') {
            $gi = geoip_open($config->path_root . '/include/GeoIP.dat', GEOIP_STANDARD);
            $ga = geoip_open($config->path_root . '/include/GeoLiteCity.dat', GEOIP_STANDARD);
            
            $cc = geoip_country_code_by_addr($gi, $player_ip);
            $cn = geoip_country_name_by_addr($gi, $player_ip);
            $ct = geoip_record_by_addr($ga, $player_ip);
            
            geoip_close($gi);
            geoip_close($ga);
        }
        else {
            $cc = '';
            $cn = '';
            $ca = '';
        }

		$ban_info = array(
			"id_type"	=> $id_type,
			"bid"		=> $id,
			"player_name"	=> $player_name,
			"player_id"	=> $player_id,
			"player_ip"	=> $player_ip,
			"ban_start"	=> $ban_start,
			"ban_duration"	=> $ban_duration,
			"ban_end"	=> $ban_end,
			"ban_type"	=> $ban_type,
			"ban_reason"	=> $ban_reason,
			"cc" => $ca,
			"cn" => $cn,
			"ctname" => $ct->city,
			"ctlong" => $ct->longitude,
			"ctlat" => $ct->latitude,
			"admin_name"	=> $admin_name,
			"amx_name"	=> isset($admin_amxname) ? $admin_amxname : "",
			"server_ip" => $server_ip,
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


$title = lang("_BANDETAILS");

$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("working_title","home");
$smarty->assign("dir",$config->document_root);

$smarty->assign("display_search", $config->display_search);
$smarty->assign("display_admin", $config->display_admin);
$smarty->assign("display_reason", $config->display_reason);

$smarty->assign("ban_info", isset($ban_info) ? $ban_info : "");
$smarty->assign("unban_info", isset($unban_info) ? $unban_info : "");
$smarty->assign("history", isset($history) ? $history : "" );
$smarty->assign("bhans", isset($unban_array) ? $unban_array : "");
$smarty->assign("parsetime", isset($parsetime) ? $parsetime : "");

$smarty->display('main_header.tpl');
$smarty->display('ban_details.tpl');
$smarty->display('main_footer.tpl');
?>