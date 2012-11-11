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
require('../include/config.inc.php');

if ($config->error_handler == 'enabled') {
	include($config->error_handler_path);
}

require($config->path_root . '/include/functions.lang.php');
include($config->path_root . '/include/accesscontrol.inc.php');

if(($_SESSION['amxadmins_edit'] != "yes") && ($_SESSION['webadmins_edit'] != "yes") && ($_SESSION['permissions_edit'] != "yes")) {
	echo lang("_NOACCESS");
	exit();
}

if ( isset($_POST['action']) && $_POST['action'] == lang("_APPLY")) {

	$config->document_root		= $_POST['document_root'];
	$config->path_root		= $_POST['path_root'];
	$config->importdir		= $_POST['import_dir'];
	$config->templatedir		= $_POST['template_dir'];

	$config->db_host		= $_POST['db_host'];
	$config->db_name		= $_POST['db_name'];
	$config->db_user		= $_POST['db_user'];
	$config->db_pass		= $_POST['db_pass'];

	$config->bans			= $_POST['tbl_bans'];
	$config->ban_history		= $_POST['tbl_banhistory'];
	$config->webadmins		= $_POST['tbl_webadmins'];
	$config->amxadmins		= $_POST['tbl_amxadmins'];
	$config->levels			= $_POST['tbl_levels'];
	$config->admins_servers		= $_POST['tbl_admins_servers'];
	$config->servers		= $_POST['tbl_servers'];
	$config->logs			= $_POST['tbl_logs'];
	$config->reasons		= $_POST['tbl_reasons'];
	

	$config->admin_nickname		= $_POST['admin_nick'];
	$config->admin_email		= $_POST['admin_email'];

	$config->error_handler		= $_POST['error_handler'];
	$config->error_handler_path	= $_POST['error_handler_path'];

	$config->admin_management	= $_POST['admin_management'];

	$config->fancy_layers		= $_POST['fancy_layers'];

	$config->version_checking	= $_POST['version_checking'];

	$config->bans_per_page		= $_POST['bans_per_page'];

	$config->display_search		= $_POST['display_search'];
	
	$config->timezone_fix 		= $_POST['timezone_fix'];
	
	$config->display_admin		= $_POST['display_admin'];
	
	$config->display_reason		= $_POST['display_reason'];

	$config->disable_frontend	= $_POST['disable_frontend'];

	$config->rcon_class		= $_POST['rcon_class'];

	$config->geoip			= $_POST['geoip'];

	$config->autopermban_count	= $_POST['autopermban_count'];
	$config->default_lang	= $_POST['default_lang'];

	$disclaimer = " 
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
";

	$security_fix = "
if (!get_magic_quotes_gpc()) { 
   \$_POST = addslashes(\$_POST); 
   \$_GET = addslashes(\$_GET); 
} 
// fix text to display 
\$_POST = str_replace(\"\'\", \"\", \$_POST); 
\$_POST = str_replace(\"\\\"\", \"\", \$_POST); 
\$_POST = str_replace(\"\\\\\", \"\", \$_POST); 

\$_GET = str_replace(\"\'\", \"\", \$_GET); 
\$_GET = str_replace(\"\\\"\", \"\", \$_GET); 
\$_GET = str_replace(\"\\\\\", \"\", \$_GET);
";

	$smarty_meuk = "

/* Smarty settings */
define(\"SMARTY_DIR\", \$config->path_root.\"/smarty/\");

require(SMARTY_DIR.\"Smarty.class.php\");

class dynamicPage extends Smarty {
	function dynamicPage() {

		global \$config;

		\$this->Smarty();

		\$this->template_dir	= \$config->templatedir;
		\$this->compile_dir	= SMARTY_DIR.\"templates_c/\";
		\$this->config_dir	= SMARTY_DIR.\"configs/\";
		\$this->cache_dir	= SMARTY_DIR.\"cache/\";
		\$this->caching		= FALSE;

		\$this->assign(\"app_name\",\"dynamicPage\");
	}
}

?>";
	
	$arr	= get_object_vars($config);
	$fp	= fopen("$config->path_root/include/config.inc.php", "w");

	if (!$fp) {
		$config_fail = 1;
	} else {
		$config_fail = 0;


		fwrite($fp, "<?php\n");
		fwrite($fp, $disclaimer);
		fwrite($fp, $security_fix);
		
		fwrite($fp, "\n\n");

		while (list($prop, $val) = each($arr)) {
			fwrite($fp, "\$config->$prop = \"$val\";\n");
		}

		fwrite($fp, $smarty_meuk);
		fclose($fp);
	}

	$now = date("U");
	$add_log	= mysql_query("INSERT INTO $config->logs (timestamp, ip, username, action, remarks) VALUES ('$now', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['uid']."', 'AMXBans config', 'Changed AMXBans configuration')") or die (mysql_error());

}


if (isset($_POST['db']) && $_POST['db'] == lang("_CHECKCONNECT")) {
	if (($_POST['db_host'] == "") || ($_POST['db_name'] == "") || ($_POST['db_user'] == "")) {
		$dblogin = 0; //some fields are left blank
	} else {
		$link = @mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);

		if (!$link) { // can't connect to database
			$dblogin = 1;
		} else {
			$db_selected = mysql_select_db($_POST['db_name'], $link);

			if (!$db_selected) { //can't switch to mentioned database
				$dblogin = 2;
			} else { // connection successfull and database exists
				$dblogin = 3;
			}
		}
	}
} else {
	$dblogin = 9;
}

if (isset($_POST['dir']) && $_POST['dir'] == lang("_CHECKDIRS")) {
	unset($checked_dirs);
	if (($_POST['document_root'] == "") || ($_POST['path_root'] == "") || ($_POST['import_dir'] == "") || ($_POST['template_dir'] == "")) {
		$checked_dirs = 1; //some fields are left blank
	} else {

		$docroot = str_replace("/admin/cfg.php", "", $_SERVER["PHP_SELF"]);

		if ($_POST['document_root'] == $docroot) {
			$doc_root_is_dir = 1;
		} else {
			$doc_root_is_dir = 0;
		}

		if (is_dir($_POST['path_root'])) {
			$path_root_is_dir = 1;
		} else {
			$path_root_is_dir = 0;
		}

		if (is_dir($_POST['import_dir'])) {
			$dir_import_is_dir = 1;
		} else {
			$dir_import_is_dir = 0;
		}

		if (is_dir($_POST['template_dir'])) {
			$dir_template_is_dir = 1;
		} else {
			$dir_template_is_dir = 0;
		}
	}


	if (isset($checked_dirs) && $checked_dirs != 1) {
		if (($path_root_is_dir == 0) || ($dir_import_is_dir == 0) || ($dir_template_is_dir == 0)) {
			$checked_dirs = 2;
		} else {
			$checked_dirs = 3;
		}
	}
}

/*
 *
 * 		Template parsing
 *
 */

// Header
$title = lang("_AMXBANSCONFIG");

// Section
$section = "config";

// Parsing
$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("section",$section);
$smarty->assign("dir",$config->document_root);
$smarty->assign("cfg",$config);
$smarty->assign("post",$_POST);
$smarty->assign("this",$_SERVER['PHP_SELF']);
$smarty->assign("dblogin",$dblogin);
$smarty->assign("checked_dirs", isset($checked_dirs) ? $checked_dirs : NULL);
$smarty->assign("doc_root_is_dir", isset($doc_root_is_dir) ? $doc_root_is_dir : NULL);
$smarty->assign("path_root_is_dir", isset($path_root_is_dir) ? $path_root_is_dir : NULL);
$smarty->assign("dir_import_is_dir", isset($dir_import_is_dir) ? $dir_import_is_dir : NULL);
$smarty->assign("dir_template_is_dir", isset($dir_template_is_dir) ? $dir_template_is_dir : NULL);

$smarty->display('main_header.tpl');
$smarty->display('cfg.tpl');
$smarty->display('main_footer.tpl');

?>
