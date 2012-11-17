<?php

// Added by Geesu
if ( !file_exists("include/config.inc.php") ) {

header("Location: http://" . $_SERVER['HTTP_HOST']
                     . rtrim(dirname($_SERVER['PHP_SELF']), '/\\')
                     . "/" . "admin/setup.php");

}

$previous_button = NULL;
$next_button = NULL;
// End Added by Geesu


// Start session
session_start();

// Require basic site files
require('include/config.inc.php');

if ($config->error_handler == 'enabled') {
	//include("$config->error_handler_path");
}

if ($config->geoip == 'enabled') {
	include($config->path_root. '/include/geoip.inc');
    include($config->path_root. '/include/geoipcity.inc');
    include($config->path_root. '/include/geoipregionvars.php');
}

require($config->path_root. '/include/functions.lang.php');
require($config->path_root. '/include/functions.inc.php');

// First we get the total number of bans in the database.


$resource	= mysql_query('SELECT COUNT(bid) AS `all_bans` FROM `' .$config->bans. '`') or die(mysql_error());
$result		= mysql_fetch_object($resource);

// Get the page number, if no number is defined make default 1
if(isset($_GET['page']) AND is_numeric($_GET['page'])) {
	$page = $_GET['page'];
	
	if($page < 1) {
		trigger_error("Pagenumbers need to be >= 1.", E_USER_NOTICE);
	}
} else {
	$page = 1;
}

// Get the view number, if no number is defined set to default
if(isset($_GET["view"]) AND is_numeric($_GET["view"])) {
	$view = $_GET["view"];
} else {
	$view = $config->bans_per_page;
}

// Dunno what to say here ;)
if($result->all_bans < $view) {
	$query_start = 0;
	$query_end = $view;
	
	$page_start = 1;
	$page_end = $result->all_bans;
	
	$pages_results = "Results ".$page_start." to ".$page_end;
}

else {
	if($page == 1) {
		$query_start = 0;
		$query_end = $view;
	
		$page_start = 1;
		$page_end = $view;
		
		$pages_results = lang("_DISPLAYING")."&nbsp;".$page_start." - ".$page_end."&nbsp;".lang("_OF")."&nbsp;".$result->all_bans."&nbsp;".lang("_RESULTS");
		
		$next_page = $page + 1;
		
		$previous_button = NULL;
		$next_button = "<a href='".$config->document_root."/ban_list.php?view=".$view."&amp;page=".$next_page."' class='hover_black'>Next &rarr;</a>";
	}
	
	else {
		$remaining = $result->all_bans % $view;
		$pages = ($result->all_bans - $remaining) / $view;
		
		$query_start = $view * ($page - 1);
		$query_end = $view;
		
		if($page > $pages + 1) {
			trigger_error("De pagina die je hebt opgegeven bestaat niet.", E_USER_NOTICE);
		}
		
		elseif($page == $pages + 1) {
			$page_start = ($view * ($page - 1)) + 1;
			$page_end = $page_start + $remaining - 1;
			
			$previous_page = $page - 1;
			
			$previous_button = "<a href='".$config->document_root."/ban_list.php?view=".$view."&amp;page=".$previous_page."' class='hover_black'>&larr; Prev</a>";
			$next_button = NULL;
		}
			
		else {
			$page_start = ($view * ($page - 1)) + 1;
			$page_end = $page_start + ($view - 1);
			
			$previous_page = $page - 1;
			$next_page = $page + 1;
			
			$previous_button = "<a href='".$config->document_root."/ban_list.php?view=".$view."&amp;page=".$previous_page."' class='hover_black'>&larr; Prev</a>";
			$next_button = "<a href='".$config->document_root."/ban_list.php?view=".$view."&amp;page=".$next_page."' class='hover_black'>Next &rarr;</a>";
		}
		
		$pages_results = lang("_DISPLAYING")."&nbsp;".$page_start." - ".$page_end."&nbsp;".lang("_OF")."&nbsp;".$result->all_bans."&nbsp;".lang("_RESULTS");

	}
}

// Make the array for the ban list
if ($config->fancy_layers != "enabled") {
	if ($config->display_reason == "enabled") {  
		$resource	= mysql_query("SELECT bid, player_ip, player_nick, admin_nick, ban_reason, ban_created, ban_length, server_ip FROM $config->bans ORDER BY ban_created DESC LIMIT ".$query_start.",".$query_end) or die(mysql_error());
	} else {
		$resource	= mysql_query("SELECT bid, player_ip, player_nick, admin_nick, ban_reason, ban_created, ban_length, server_ip FROM $config->bans ORDER BY ban_created DESC LIMIT ".$query_start.",".$query_end) or die(mysql_error());
	}
} else {
	$resource		= mysql_query("SELECT * FROM $config->bans ORDER BY ban_created DESC LIMIT ".$query_start.",".$query_end) or die(mysql_error());
}


$ban_array	= array();
$timezone_correction = $config->timezone_fix * 3600;

while($result = mysql_fetch_object($resource)) {
	$bid		= $result->bid;
	// $date		= dateShort($result->ban_created + $timezone_correction);
	//$date		= date('n d, Y  h:i A',$result->ban_created + $timezone_correction);
	$date = date('n/j/y', $result->ban_created + $timezone_correction);
	$player		= $result->player_nick;
	$player 	= htmlentities($player, ENT_QUOTES);
	$admin		= $result->admin_nick;
	$admin 		= htmlentities($admin, ENT_QUOTES);
	$duration 	= $result->ban_length;
	$serverip	= $result->server_ip;
	$player_ip 	= $result->player_ip;

	if ($config->fancy_layers == "enabled") {

		if(!empty($result->player_ip)) {
			$player_ip = htmlentities($result->player_ip, ENT_QUOTES);
		} else {
			$player_ip = "<i><font color='#677882'>" . lang("_NOIP") . "</font></i>";
		}
		
		if(!empty($result->player_id)) {
			$steamid = htmlentities($result->player_id, ENT_QUOTES);
		} else {
			//$steamid = "<i><font color='#677882'>" . lang("_NOSTEAMID") . "</font></i>";
			$steamid = "&nbsp;";
		}

		$ldate		= dateShorttime($result->ban_created + $timezone_correction);
		$banlength	= $result->ban_length;
	
		if(empty($result->ban_length) OR $result->ban_length == 0) {
			$ban_duration = lang("_PERMANENT");
			$ban_end = lang("_NOTAPPLICABLE");
		} else {
			$ban_duration = $result->ban_length . "&nbsp; ". lang("_MINS") . "&nbsp;";
			$date_and_ban = $result->ban_created + $timezone_correction + ($result->ban_length * 60);

			$now = date("U");
			if($now >= $date_and_ban) {
				$ban_end = dateShorttime($date_and_ban)."&nbsp; (".lang("_ALREADYEXP").")";
			} else {
				$ban_end = dateShorttime($date_and_ban)."&nbsp; (".timeleft($now,$date_and_ban) ."&nbsp;". lang("_REMAINING") .")";
			}
		}
		
		if($result->ban_type == "SI") {
			$ban_type = lang("_STEAMID&IP");
		} else {
			$ban_type = "SteamID";
		}
		
		if($result->server_name != "website") {
			//$query2 = "SELECT nickname FROM $config->amxadmins WHERE steamid = '".$result->admin_id."'";	
			$query2 = "SELECT nickname FROM $config->amxadmins WHERE username = '".$result->admin_id."' OR username = '".$result->admin_ip."' OR username = '".$result->admin_nick."'";	
			$resource2 = mysql_query($query2) or die(mysql_error());	
			$result2 = mysql_fetch_object($resource2);

			
			$admin_name = htmlentities($result->admin_nick, ENT_QUOTES);
			if ( $result2 )
			{
				$web_admin_name = htmlentities($result2->nickname, ENT_QUOTES);
                $admin_name = htmlentities($result2->nickname, ENT_QUOTES);
			}
			else
			{
				$web_admin_name = '';
			}
			$server_name = $result->server_name;
		} else {
			$admin_name = htmlentities($result->admin_nick, ENT_QUOTES);
			$web_admin_name = $admin_name;
			$server_name = lang('_WEBSITE');
		}
	}

	$ban_reason = htmlentities($result->ban_reason, ENT_QUOTES);

	if ($serverip != "") {

		// Get the gametype for each ban
		$resource2	= mysql_query("SELECT gametype FROM $config->servers WHERE address = '$serverip'") or die(mysql_error());

		while($result2 = mysql_fetch_object($resource2)) {
			$gametype = $result2->gametype;
		}
	} else {
		$gametype = "html";
	}


// We dont need to count the bans if fancy layers arent enabled (Lantz69 060906)
if ($config->fancy_layers == "enabled") {	
	// get previous offences if any
	//$resource4   = mysql_query("SELECT count(player_id) FROM $config->ban_history WHERE player_id = '$steamid'") or die(mysql_error());
	//$bancount = mysql_result($resource4, 0);
	
	// get previous offences if any 
	$resource4   = mysql_query("SELECT count(player_id) AS repeatOffence FROM $config->ban_history WHERE player_id = '$steamid'") or die(mysql_error()); 
	while($result4 = mysql_fetch_object($resource4)) { 
		$bancount = $result4->repeatOffence; 
	}
}

	if(empty($duration)) {
		$duration = lang("_PERMANENT");
	}	else {
		if ($duration >= 1440) {
			$duration = round($duration / 1440);
			if ($duration == 1)
				$duration = "$duration " . lang("_DAY");
			else
				$duration = "$duration " . lang("_DAYS");
		} else {
			$duration = "$duration " . lang("_MINS");
		}
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

	// Asign variables to the array used in the template
	if ($config->fancy_layers == "enabled") {
		$ban_info = array(
		"gametype"	=> $gametype,
		"bid"		=> $bid,
		"date"		=> $date,
		"player"	=> $player,
		"cc"		=> $cc,
		"cn"		=> $cn,
		"ct"        => $ct->city,
		"ctlong"    => $ct->longitude,
		"ctlat"     => $ct->latitude,
		"admin"		=> $admin_name,
		"webadmin"	=> $web_admin_name,
		"duration"	=> $duration,
		"player_id"	=> $steamid,
		"player_ip"	=> $player_ip,
		"ban_start"	=> $ldate,
		"ban_duration"	=> $ban_duration,
		"ban_end"	=> $ban_end,
		"ban_type"	=> $ban_type,
		"ban_reason"	=> $ban_reason,
		"server_name"	=> $server_name,
		"bancount"	=> $bancount
		);
	} else {
		if ($config->display_reason == "enabled") {
			$ban_info = array(
				"gametype"	=> $gametype,
				"bid"		=> $bid,
				"date"		=> $date,
				"player"	=> $player,
				"cc"		=> $cc,
				"cn"		=> $cn,
				"admin"		=> $admin,
				"duration"	=> $duration,
				"ban_reason"	=> $ban_reason
			);
		} else {
			$ban_info = array(
				"gametype"	=> $gametype,
				"bid"		=> $bid,
				"date"		=> $date,
				"player"	=> $player,
				"cc"		=> $cc,
				"cn"		=> $cn,
				"admin"		=> $admin,
				"duration"	=> $duration
			);
		}
	}
	
	$ban_array[] = $ban_info;
}

if ($config->version_checking == "enabled") {
	$new_version_exists = CheckAMXWebVersion();
} else {
	$new_version_exists = 0;
}


/*
 * Template parsing
 */


$title			= lang("_BANLIST");

// Section
$section = "banlist";

$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("fancy_layers", $config->fancy_layers);
$smarty->assign("display_search", $config->display_search);
$smarty->assign("display_admin", $config->display_admin);
$smarty->assign("display_reason", $config->display_reason);
$smarty->assign("geoip", $config->geoip);
$smarty->assign("bans",$ban_array);
$smarty->assign("pages_results",$pages_results);
$smarty->assign("previous_button",$previous_button);
$smarty->assign("next_button",$next_button);
$smarty->assign("new_version",$new_version_exists);
$smarty->assign("update_url",$config->update_url);

$smarty->display('main_header.tpl');
$smarty->display('ban_list.tpl');
$smarty->display('main_footer.tpl');

?>