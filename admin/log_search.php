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
require("../include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}
include("$config->path_root/include/functions.lang.php");
require("$config->path_root/include/functions.inc.php");


if (!isset($_POST['date'])) {
	$date = date("d-m-Y");
} else if ($_POST['date'] == ""){
	$date = "%";
} else {
	$date = $_POST['date'];
}

if ((!isset($_POST['admin'])) || ($_POST['admin'] == "all")) {
	$admin = "%";
} else {
	$admin = $_POST['admin'];
}

if ((!isset($_POST['action'])) || ($_POST['action'] == "all")) {
	$action = "%";
} else {
	$action = $_POST['action'];
}

//$date		= substr_replace($date, '', 2, 1);
//$date		= substr_replace($date, '', 4, 1);

// Make the array for the log list
$query			= "SELECT * FROM $config->logs WHERE FROM_UNIXTIME(timestamp,'%d-%m-%Y') LIKE '$date' AND username LIKE '$admin' AND action LIKE '$action' ORDER BY timestamp DESC";
$resource		= mysql_query($query) or die(mysql_error());
	
$log_array	= array();

while($result = mysql_fetch_object($resource)) {
	$username	= htmlentities($result->username, ENT_QUOTES);

	// Asign variables to the array used in the template
	$log_info = array(
		"id"				=> $result->id,
		"date"			=> dateShorttime($result->timestamp),
		"ip"				=> $result->ip,
		"username"	=> $username,
		"action"		=> $result->action,
		"remarks"		=> $result->remarks
		);
	
	$log_array[] = $log_info;
}

// Make the array for the actions
$query2			= "SELECT DISTINCT action FROM $config->logs ORDER BY action ASC";
$resource2	= mysql_query($query2) or die(mysql_error());
	
$action_array	= array();

while($result2 = mysql_fetch_object($resource2)) {
	$action_array[]	= $result2->action;
}

// Make the array for the admin list
$query3			= "SELECT username FROM $config->webadmins ORDER BY id ASC";
$resource3		= mysql_query($query3) or die(mysql_error());
	
$admin_array	= array();

while($result3 = mysql_fetch_object($resource3)) {
	$admin_array[] = $result3->username;
}

/****************************************************************
* Template parsing
****************************************************************/

// Header
$title = lang("_ACCESSLOG");

// Section
$section = "logs";

// Parsing
$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("date",$date);
$smarty->assign("admin",$admin);
$smarty->assign("action",$action);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("logs",$log_array);
$smarty->assign("actions",$action_array);
$smarty->assign("admins",$admin_array);
$smarty->display('main_header.tpl');
$smarty->display('log_search.tpl');
$smarty->display('main_footer.tpl');

?>
