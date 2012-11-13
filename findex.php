<?php

// Start session
session_start();

// Require basic site files
require("include/config.inc.php");

if ($config->error_handler == "enabled") 
{
	include("$config->error_handler_path");
}
require("$config->path_root/include/functions.lang.php");
require("$config->path_root/include/functions.inc.php");

// Get ban details
	
if(isset($_GET["steamid"])) 
{
	// Make the array for the history ban list
	$query = "SELECT player_nick, admin_nick, ban_length, ban_created, player_id, ban_reason FROM $config->ban_history WHERE player_id = '".mysql_escape_string($_GET["steamid"])."' ORDER BY ban_created DESC";
		
	$resource = mysql_query($query) or die(mysql_error());
		
	if(mysql_num_rows($resource) == 0) 
	{
		//trigger_error("Can't find ban with given ID: ".mysql_escape_string($_GET["steamid"] , E_USER_NOTICE);
		// H�r beh�ver man inte ha n�got. Har bortkommenterat raden ovan. Tycker att NOTICE �r on�digt f�r det f�rst�r mest formatet p� motd sidan.
	}
	else
	{		
		$unban_array = array();
			
		while($result = mysql_fetch_object($resource)) 
		{
			$date = dateMonth($result->ban_created);
			$player = htmlentities($result->player_nick, ENT_QUOTES);
			$player_id = htmlentities($result->player_id, ENT_QUOTES);
			$duration = $result->ban_length;
			$reason = htmlentities($result->ban_reason, ENT_QUOTES);
			$admin = htmlentities($result->admin_nick, ENT_QUOTES);			
				
			if(empty($duration)) 
			{
				$duration = "Permanent";
			}			
			else 
			{
				$duration = $duration." mins";
			}
				
			// Asign variables to the array used in the template
			$unban_info = array(				
				"date" => $date,
				"player" => $player,
				"player_id" => $player_id,
				"duration" => $duration,
				"reason" => $reason,
				"admin" => $admin,				
				);
				
			$unban_array[] = $unban_info;
		}
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
$smarty->assign("display_admin", $config->display_admin);
$smarty->assign("unban_info",$unban_info);
$smarty->assign("bhans",$unban_array);
$smarty->assign("parsetime",$parsetime);

$smarty->display('findex.tpl');
?>