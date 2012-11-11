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
include("$config->path_root/include/accesscontrol.inc.php");

if($_SESSION['bans_import'] != "yes") {
	echo lang("_NOACCESS");
	exit();
}

require("$config->path_root/include/fileupload-class.php");
$path			= $config->importdir.'/';
$upload_file_name	= "banlog";
$acceptable_file_types	= "text/plain";
$default_extension	= ".cfg";
$mode			= 1;

if (isset($_POST['submitted']) && $_POST['submitted'] == "true") {

	function ban_file($filename) {
		global $path;
		$filename	= $path.$filename;
		$array		= array('VALVE_ID_LAN');
		$dump		= file($filename);
		$var		= "";
		$count		= count($dump);

		// Make the array for the imports
		$import_array	= array();

		$j = 0;
		for ($i=0; $i<$count; $i++) {
			$var = trim($dump[$i]);
			if(!empty($var)){
				if(!eregi($array,$var)){
					$j++;
					$each = explode(" ",$var);

					if (substr($each[2], 0, 5) == "STEAM") {
						$ban_type = "S";
					} else {
						$ban_type = "I";
					}  

					$result = AddImportBan($each[2],"unknown (imported)",$_SESSION['uid'],$_SERVER['REMOTE_ADDR'],$ban_type,$_REQUEST['ban_reason'],$_REQUEST['ban_length']);


					// Asign variables to the array used in the template
					$import_info = array(
						"counter"	=> $j,
						"id"		=> $each[2],
						"result"	=> $result
						);
	
					$import_array[] = $import_info;
					//print_r($import_info);

				}
			}
			$var="";


		}
		$now = date("U");
		$add_log = mysql_query("INSERT INTO amx_logs (timestamp, ip, username, action, remarks) VALUES ('$now', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'import ban', 'imported bans: $j')") or die (mysql_error());
		return $import_array;
	}
	
	if ( isset( $_POST['en'] ) )
	{
		$my_uploader = new uploader($_POST['en']);
	}
	else
	{
		$my_uploader = new uploader("en");
	}
	$my_uploader->max_filesize(45000);

	if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
		$my_uploader->save_file($path, $mode);
	}
	
	if ($my_uploader->error) {
		//echo $my_uploader->error . "<br><br>\n";	
	} else {
		$import_array = ban_file($my_uploader->file['name']);
	}
}

if (isset($acceptable_file_types) && trim($acceptable_file_types)) {
	$submit = "This form only accepts <b>".str_replace("|", " or ", $acceptable_file_types)."</b> files &nbsp;&nbsp;<input type='submit' name='importit' value='".lang("_IMPORT")."' style='font-family: verdana, tahoma, arial; font-size: 10px;'>";
} else {
	$submit = "No acceptable filetypes set.&nbsp;&nbsp;<input type='submit' name='importit' value='".lang("_IMPORT")."' style='font-family: verdana, tahoma, arial; font-size: 10px;' disabled>";
}

/****************************************************************
* Template parsing
****************************************************************/

// Header
$title = lang("_IMPORT");

// Section
$section = "import";

// Parsing

//$config->logs

$smarty = new dynamicPage;
$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("filename",$upload_file_name);
$smarty->assign("submit",$submit);
$smarty->assign("submitted",get_post('submitted'));
$smarty->assign("import", isset($import_array) ? $import_array : "");
$smarty->display('main_header.tpl');
$smarty->display('import_bans.tpl');
$smarty->display('main_footer.tpl');

?>