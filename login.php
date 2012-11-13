<?php

// Start session
session_start();

include('include/config.inc.php');

if ($config->error_handler == 'enabled') {
	include($config->error_handler_path);
}
require($config->path_root . '/include/functions.lang.php');
include($config->path_root . '/include/accesscontrol.inc.php');

echo "<script>document.location.href='$config->document_root/'</script>";

?>
