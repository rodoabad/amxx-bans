<?php

$db_connect = @mysql_connect($config->db_host, $config->db_user, $config->db_pass) or die (mysql_error());
$db_site    = @mysql_select_db($config->db_name, $db_connect) or die (mysql_error());

function convertGameType($sGameType) {

    $aGames = array(
        'cstrike' => 'Counter-Strike 1.6',
        'czero' => 'Condition Zero',
    );

    foreach ($aGames as $sGameKey => $sGameValue) {
        if ($sGameKey == $sGameType) {
            return $sGameValue;
        }
    }
}

function formatTime($iTime) {
    $sDate = strftime('%B %e, %Y - %l:%M %p', $iTime);

    return $sDate;
}

// OLD

function dateFull($timestamp) { // zondag 20 april 2003
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%A %d %B %Y", $timestamp);

	return $date;
}

function dateShort($timestamp) { // 20-04-03
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%d-%m-%y", $timestamp);

	return $date;
}

function dateMonth($timestamp) { // 20/04
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%d/%m", $timestamp);

	return $date;
}

function dateShortYear($timestamp) { // 20-04-2003
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%d-%m-%Y", $timestamp);

	return $date;
}

function dateMonthYear($timestamp) { // maart 2004
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%B %Y", $timestamp);

	return $date;
}

function dateFulltime($timestamp) { // zondag 20 april 2003 - 15:32
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%A %d %B %Y - %H:%M", $timestamp);

	return $date;
}

function dateShorttime($timestamp) { // 20-04-03 15:32
	setlocale (LC_TIME, 'Dutch');
	$date = strftime("%B %d, %Y - %I:%M %p", $timestamp);

	return $date;
}

function dateRFC822($timestamp) { // Sat, 28 Jun 2003 18:06:03 GMT
	$timestamp = $timestamp - 7200;

	$date = strftime("%a, %d %b %Y %H:%M:%S GMT", $timestamp);

	return $date;
}

function firstDayOfWeek($timestamp = NULL) { // Return a UNIX timestamp of the first day in a week
	global $currenttime;

	if(isset($timestamp)) {
		$year = strftime("%Y",$timestamp);
		$week_number = strftime("%W",$timestamp);
	}

	else {
		$year = strftime("%Y",$currenttime);
		$week_number = strftime("%W",$currenttime);
	}

	// Numeric day of the week for the 1st of January, $year
	$no = date("w", mktime(0,0,0,1,1,$year));

	// First day of first week in $year
	$first_day = mktime(0,0,0,1,1,$year) - ($no-1) * 86400;

	// Add $week weeks to first day (current week is not to be added)
	$add_no_of_weeks = $week_number;

	return strtotime("$add_no_of_weeks weeks", $first_day);
}

function checkLeapYear($year) {
	if($year % 4 != 0) {
		return FALSE;
	}

	elseif(($year % 100 != 0) || ($year % 400 == 0)) {
		return TRUE;
	}

	else {
		return FALSE;
	}
}

function timing($command) {
	global $starttime, $endtime;

	if($command == 'start') {
		$mtime1 = microtime();
		$mtime1 = explode(" ",$mtime1);
		$mtime1 = $mtime1[1] + $mtime1[0];
		$starttime = $mtime1;
	}

	else if($command == 'end') {
		$mtime2 = microtime();
		$mtime2 = explode(" ",$mtime2);
		$mtime2 = $mtime2[1] + $mtime2[0];
		$endtime = $mtime2;
		$totaltime = ($endtime - $starttime);
		$totaltime = round($totaltime,5);
		return $totaltime;
	}
}

function timeleft($begin,$end) {
	$dif=$end-$begin;
	//$week=0;

	$years=intval($dif/(60*60*24*365));
	 $dif=$dif-($years*(60*60*24*365));

	$months=intval($dif/(60*60*24*30));
	 $dif=$dif-($months*(60*60*24*30));

	$weeks=intval($dif/(60*60*24*7));
	 $dif=$dif-($weeks*(60*60*24*7));

	$days=intval($dif/(60*60*24));
	 $dif=$dif-($days*(60*60*24));

	$hours=intval($dif/(60*60));
	 $dif=$dif-($hours*(60*60));

	  $minutes=intval($dif/(60));
	$seconds=$dif-($minutes*60);

	$s = "";

	if($years == 1) {
		$s.= $years."&nbsp;".lang("_YEAR")."&nbsp;";
	}

	elseif($years > 1) {
		$s.= $years."&nbsp;".lang("_YEARS")."&nbsp;";
	}

	if($months == 1) {
		$s.= $months."&nbsp;".lang("_MONTH")."&nbsp;";
	}

	elseif($months > 1) {
		$s.= $months."&nbsp;".lang("_MONTHS")."&nbsp;";
	}

	if($weeks == 1) {
		$s.= $weeks."&nbsp;".lang("_WEEK")."&nbsp;";
	}

	elseif($weeks > 1) {
		$s.= $weeks."&nbsp;".lang("_WEEKS")."&nbsp;";
	}

	if($days == 1) {
		$s.= $days."&nbsp;".lang("_DAY")."&nbsp;";
	} else if($days > 1) {
		$s.= $days."&nbsp;".lang("_DAYS")."&nbsp;";
	}

	if($hours == 1) {
		$s.= $hours."&nbsp;".lang("_HOUR")."&nbsp;";
	} else if($hours > 1) {
		$s.= $hours."&nbsp;".lang("_HOURS")."&nbsp;";
	}

	if($minutes == 1) {
		$s.= $minutes."&nbsp;".lang("_MIN");
	} else if($minutes > 1) {
		$s.= $minutes."&nbsp;".lang("_MINS");
	}

	return $s;
}

function GetUrlParams($exclude=false) {

	/*
	Fetches HTTP get parameters

	If you have: www.mysite.com?pos=1&item=2

	GetUrlParams(); will return "?pos=1&item=2"
	GetUrlParams("pos"); will return "?item=2"
	GetUrlParams(array("pos","item")); will return "?"
	*/

	reset($_GET);
	while (list($k, $v) = each($_GET)) {
		if (is_array($exclude)) {
			foreach($exclude as $x)
			$get_params_excluded[$i++].=($k==$x)?'&'.$k.'='.$v:'';
		}
		$get_params.=($k!=$exclude)?'&'.$k.'='.$v:'';
	}

	if ( isset($get_params) )
	{
		$get_params = str_replace($get_params_excluded, '', $get_params);
		if(!empty($get_params))
			$get_params='?'.substr($get_params, 1);
		else
			$get_params='?';

		return $get_params;
	}

	return NULL;
}

function CheckAbility($action,$user_lvl) {

	global $config;

	$check_ability	= mysql_query("SELECT $action FROM $config->levels WHERE level = '$user_lvl'") or die (mysql_error());
	$numrows				= mysql_num_rows($check_ability);

	if($numrows == 0) {
		return 0;
	} else {
		while($ability = mysql_fetch_array($check_ability)) {
			$value = $ability[$action];
			return $value;
		}
	}
}

function CheckFrontEndState() {

	global $config;
	global $_SESSION;

	if($config->disable_frontend == "true") {
		if ($_SESSION['uid'] == $config->admin_nickname) {
		} else {
			header( "Location:$config->document_root/unavailable.php?msg=frontend_disabled" );
		}
	}
}

function GenerateString($strlen) {

	$auto_string= chr(mt_rand(ord('A'), ord('Z')));

	for ($i= 0; $i<$strlen; $i++) {
		$ltr= mt_rand(1, 3);
			if ($ltr==1) $auto_string .= chr(mt_rand(ord('A'), ord('Z')));
			if ($ltr==2) $auto_string .= chr(mt_rand(ord('a'), ord('z')));
			if ($ltr==3) $auto_string .= chr(mt_rand(ord('0'), ord('9')));
	}
	return $auto_string;
}

function IsLoggedIn() {

	global $_SESSION, $REMOTE_ADDR;
	return isset($_SESSION) && isset($_SESSION['uid']) && isset($_SESSION['pwd']) && $_SESSION['uip'] == $REMOTE_ADDR;
}

function CheckAMXWebVersion() {
	global $config;
	@include("$config->update_url/version.inc");

	if ($config->php_version >= $current_php_vers) {
		return 0;
	}

	return 1;
}

function CheckAMXPlugVersion($mod,$version) {

	global $config;
	include("$config->update_url/version.inc");

	if($mod == "amxx") {
		if($version < $current_amxx_vers) {
			$result = 1;
		} else {
			$result = 0;
		}
	} else if($mod == "amx") {
		if($version < $current_amx_vers) {
			$result = 1;
		} else {
			$result = 0;
		}
	}
	return $result;
}

function AddImportBan($player_id,$player_nick,$admin_nick,$admin_ip,$ban_type,$ban_reason,$ban_length,$player_ip="") {

	global $config;

	$check_steamid	= mysql_query("SELECT player_id FROM $config->bans WHERE player_id = '$player_id'") or die (mysql_error());
	$numrows	= mysql_num_rows($check_steamid);

	if ($numrows != 0) {
		return 0;
	} else {
		$ban_created = date("U");
		$server_name = "website";

		$insert_ban = mysql_query("INSERT INTO $config->bans (bid, player_ip, player_id, player_nick, admin_ip, admin_id, admin_nick, ban_type, ban_reason, ban_created, ban_length, server_ip, server_name) VALUES ('', '$player_ip', '$player_id', '$player_nick', '$admin_ip', '$admin_id', '$admin_nick', '$ban_type', '$ban_reason', '$ban_created', '$ban_length', '', '$server_name')") or die (mysql_error());
		return 1;
	}
}

function display_post_get() {
   if ($_POST) {
      echo "Displaying POST Variables: <br> \n";
      echo "<table border=1> \n";
      echo " <tr> \n";
      echo "  <td><b>result_name </b></td> \n ";
      echo "  <td><b>result_val  </b></td> \n ";
      echo " </tr> \n";
      while (list($result_nme, $result_val) = each($_POST)) {
         echo " <tr> \n";
         echo "  <td> $result_nme </td> \n";
         echo "  <td> $result_val </td> \n";
         echo " </tr> \n";
      }
      echo "</table> \n";
   }
   if ($_GET) {
      echo "Displaying GET Variables: <br> \n";
      echo "<table border=1> \n";
      echo " <tr> \n";
      echo "  <td><b>result_name </b></td> \n ";
      echo "  <td><b>result_val  </b></td> \n ";
      echo " </tr> \n";
      while (list($result_nme, $result_val) = each($_GET)) {
         echo " <tr> \n";
         echo "  <td> $result_nme </td> \n";
         echo "  <td> $result_val </td> \n";
         echo " </tr> \n";
      }
      echo "</table> \n";
   }
}

function display_array($array) {
	echo "<pre>\n";
	print_r($array);
	echo "</pre>\n";
}

function ReadSessionFromCookie() {

	global $config;

	$cook			= explode(":", $_COOKIE["amxbans"]);
	$uid			= $cook[0];
	$pwd			= $cook[1];
	$lvl			= $cook[2];
	$uip			= $cook[3];
	$logcode		= $cook[4];
	$bans_add		= $cook[5];
	$bans_edit		= $cook[6];
	$bans_delete		= $cook[7];
	$bans_unban		= $cook[8];
	$bans_import		= $cook[9];
	$bans_export		= $cook[10];
	$amxadmins_view		= $cook[11];
	$amxadmins_edit		= $cook[12];
	$webadmins_view		= $cook[13];
	$webadmins_edit		= $cook[14];
	$permissions_edit	= $cook[15];
	$prune_db		= $cook[16];
	$servers_edit		= $cook[17];
	$ip_view		= $cook[19];

	$sql = mysql_query("SELECT * FROM $config->webadmins WHERE username = '$uid' AND password = '$pwd'") or die (mysql_error());

	if (mysql_num_rows($sql) == 0) {
  	unset($_SESSION['uid']);
  	unset($_SESSION['pwd']);
  	unset($_SESSION['uip']);
  	unset($_SESSION['lvl']);
		unset($_SESSION['bans_add']);
		unset($_SESSION['bans_edit']);
		unset($_SESSION['bans_delete']);
		unset($_SESSION['bans_unban']);
		unset($_SESSION['bans_import']);
		unset($_SESSION['bans_export']);
		unset($_SESSION['amxadmins_view']);
		unset($_SESSION['amxadmins_edit']);
		unset($_SESSION['webadmins_view']);
		unset($_SESSION['webadmins_edit']);
		unset($_SESSION['permissions_edit']);
		unset($_SESSION['prune_db']);
		unset($_SESSION['servers_edit']);
		unset($_SESSION['ip_view']);

		echo "Username or password is incorrect, or you are not an admin.";
		exit;
	}

	$_SESSION['uid'] = $uid;
	$_SESSION['pwd'] = $pwd;
	$_SESSION['uip'] = $uip;
	$_SESSION['lvl'] = $lvl;
	$_SESSION['userid'] = $userid;
	$_SESSION['bans_add'] = $bans_add;
	$_SESSION['bans_edit'] = $bans_edit;
	$_SESSION['bans_delete'] = $bans_delete;
	$_SESSION['bans_unban'] = $bans_unban;
	$_SESSION['bans_import'] = $bans_import;
	$_SESSION['bans_export'] = $bans_export;
	$_SESSION['amxadmins_view'] = $amxadmins_view;
	$_SESSION['amxadmins_edit'] = $amxadmins_edit;
	$_SESSION['webadmins_view'] = $webadmins_view;
	$_SESSION['webadmins_edit'] = $webadmins_edit;
	$_SESSION['permissions_edit'] = $permissions_edit;
	$_SESSION['prune_db'] = $prune_db;
	$_SESSION['servers_edit'] = $servers_edit;
	$_SESSION['ip_view'] = $ip_view;
}

function CountBans() {

	global $config;

	$active_bans	= mysql_query("SELECT COUNT(bid) AS active_bans FROM $config->bans") or die(mysql_error());
	$result		= mysql_fetch_object($active_bans);

	$expired_bans	= mysql_query("SELECT COUNT(bhid) AS expired_bans FROM $config->ban_history") or die(mysql_error());
	$result2	= mysql_fetch_object($expired_bans);


	$total = $result->active_bans + $result2->expired_bans;

	return $total." (".$result->active_bans." active)";
}

function get_post( $var )
{

	if ( isset( $_POST[$var] ) )
	{
		return $_POST[$var];
	}

	return "";
}

function print_it( $var )
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function throw_error( $msg )
{



}

?>