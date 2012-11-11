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

require("include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}

include("$config->path_root/include/accesscontrol.inc.php");

if(isset($_COOKIE["amxbans"])) {

	$res = mysql_query("UPDATE $config->webadmins SET user_logcode = '' WHERE user_nick = '$uid'");
	setcookie("amxbans", "clearing", time()-60*60*24*7, "$config->document_root/", $_SERVER["SERVER_NAME"]);
}

unset($_SESSION['uid']);
unset($_SESSION['pwd']);
unset($_SESSION['uip']);
unset($_SESSION['lvl']);

session_destroy();

// This dont seem to work on some systems.. use the javascript below instead
//header("Location: $config->document_root");

$ref = $_GET['ref'];

?>

<script type="text/javascript" language="javascript">
window.location.href = document.referrer;
</script> 
