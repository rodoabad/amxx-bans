<?php

// Start session
session_start();

require('include/config.inc.php');

if ($config->error_handler == 'enabled') {
	include('$config->error_handler_path');
}

include($config->path_root. '/include/accesscontrol.inc.php');

if(isset($_COOKIE['amxbans'])) {

	$res = mysql_query('UPDATE `' .$config->webadmins. '` SET `user_logcode` = "" WHERE `user_nick` = "' .$uid. '"');
	setcookie('amxbans', 'clearing', time()-60*60*24*7, $config->document_root. '/', $_SERVER['SERVER_NAME']);
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
