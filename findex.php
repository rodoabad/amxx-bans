<?php

/*
 *
 *  AMXBans, managing bans for Half-Life modifications
 *  Copyright (C) 2003, 2004  Ronald Renes / Jeroen de Rover
 *
 *	web		: http://www.xs4all.nl/~yomama/amxbans/
 *	mail	: yomama@xs4all.nl
 *	ICQ		: 104115504
 *   
 *	This file is part of AMXBans.
 *
 *  AMXBans is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  AMXBans is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with AMXBans; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */

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
		// Här behöver man inte ha något. Har bortkommenterat raden ovan. Tycker att NOTICE är onödigt för det förstör mest formatet på motd sidan.
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