<?php

// Start session
session_start();

// Require basic site files
require("include/config.inc.php");

if ($config->error_handler == "enabled") {
	include("$config->error_handler_path");
}
require("$config->path_root/include/functions.lang.php");
require("$config->path_root/include/functions.inc.php");

if ($_GET['msg'] == "frontend_disabled") {
	$message = lang("_ERRORAMXBANSDISABLED");
} else if ($_GET['msg'] == "setupfile_exists") {
	$message = lang("_ERRORSETUPPHP");
}

/*
 * Template parsing
 */


$title			= lang("_UNAVAILABLE");

$smarty = new dynamicPage;

$smarty->assign("meta","");
$smarty->assign("title",$title);
$smarty->assign("dir",$config->document_root);
$smarty->assign("message",$message);

$smarty->display('unavailable.tpl');

?>