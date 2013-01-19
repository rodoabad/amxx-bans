<?php

// Make sure the installation hasn't already occurred (check for config.inc.php)

if ( file_exists('../include/config.inc.php') ) {
	header( 'Location:../list.php' );
	exit();
}


function display_post_get() {
   if ($_POST) {
      echo 'Displaying POST Variables: <br> \n';
      echo '<table border=1> \n';
      echo ' <tr> \n';
      echo '  <td><b>result_name </b></td> \n ';
      echo '  <td><b>result_val  </b></td> \n ';
      echo ' </tr> \n';
      while (list($result_nme, $result_val) = each($_POST)) {
         echo ' <tr> \n';
         echo '  <td> $result_nme </td> \n';
         echo '  <td> $result_val </td> \n';
         echo ' </tr> \n';
      }
      echo '</table> \n';
   }
   if ($_GET) {
      echo 'Displaying GET Variables: <br> \n';
      echo '<table border=1> \n';
      echo ' <tr> \n';
      echo '  <td><b>result_name </b></td> \n ';
      echo '  <td><b>result_val  </b></td> \n ';
      echo ' </tr> \n';
      while (list($result_nme, $result_val) = each($_GET)) {
         echo ' <tr> \n';
         echo '  <td> $result_nme </td> \n';
         echo '  <td> $result_val </td> \n';
         echo ' </tr> \n';
      }
      echo '</table> \n';
   }
}

if (isset($_POST['action'])) {
	$action = $_POST['action'];
}

if ((isset($action)) && ($action == 'go to frontpage')) {
	//header( "Location:$config->document_root" );
	header( "Location:../" );
}

if ((isset($_POST['action'])) && ($_POST['action'] == 'step 5')) {
	if (($_POST['admin_nick'] == '') || ($_POST['admin_email'] == '') || ($_POST['admin_pass'] == '')) {
		$empty_details = 1;
		$action = 'step 4';
	}
}

if ((isset($_POST['check'])) && ($_POST['check'] == 'check connection')) {
	unset($dblogin);
	if (($_POST['db_host'] == '') || ($_POST['db_name'] == '') || ($_POST['db_user'] == '')) {
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
} else if ((isset($_POST['check'])) && ($_POST['check'] == 'create')) {

	$link = mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);

	function TableExists($tablename, $db) {

		$result = mysql_list_tables($db);
		$rcount = mysql_num_rows($result);

		for ($i=0;$i<$rcount;$i++) {
			if (mysql_tablename($result, $i)==$tablename) {
				return true;
			}
		}
		return false;
	}

	$tbl_bans_exists = TableExists($_POST['tbl_bans'], $_POST['db_name']);
	if ($tbl_bans_exists == 'true') {
		$tbl_bans_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_bans']."` (`bid` int(11) NOT NULL auto_increment, `player_ip` varchar(100) default NULL, `player_id` varchar(50) NOT NULL default '0', `player_nick` varchar(100) NOT NULL default 'Unknown', `admin_ip` varchar(100) default NULL, `admin_id` varchar(50) NOT NULL default '0', `admin_nick` varchar(100) NOT NULL default 'Unknown', `ban_type` varchar(10) NOT NULL default 'S', `ban_reason` varchar(255) NOT NULL default '', `ban_created` int(11) NOT NULL default '0', `ban_length` varchar(100) NOT NULL default '', `server_ip` varchar(100) NOT NULL default '', `server_name` varchar(100) NOT NULL default 'Unknown', PRIMARY KEY (`bid`))") or die (mysql_error());
		$tbl_bans_created = 1;
	}

	$tbl_banhistory_exists = TableExists($_POST['tbl_banhistory'], $_POST['db_name']);
	if ($tbl_banhistory_exists == "true") {
		$tbl_banhistory_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_banhistory']."` (`bhid` int(11) NOT NULL auto_increment, `player_ip` varchar(100) default NULL, `player_id` varchar(50) NOT NULL default '0', `player_nick` varchar(100) NOT NULL default 'Unknown', `admin_ip` varchar(100) default NULL, `admin_id` varchar(50) NOT NULL default '0', `admin_nick` varchar(100) NOT NULL default 'Unknown', `ban_type` varchar(10) NOT NULL default 'S', `ban_reason` varchar(255) NOT NULL default '', `ban_created` int(11) NOT NULL default '0', `ban_length` varchar(100) NOT NULL default '', `server_ip` varchar(100) NOT NULL default '', `server_name` varchar(100) NOT NULL default 'Unknown', `unban_created` int(11) NOT NULL default '0', `unban_reason` varchar(255) NOT NULL default 'tempban expired', `unban_admin_nick` varchar(100) NOT NULL default 'Unknown', PRIMARY KEY (`bhid`))") or die (mysql_error());
		$tbl_banhistory_created = 1;
	}

	$tbl_webadmins_exists = TableExists($_POST['tbl_webadmins'], $_POST['db_name']);
	if ($tbl_webadmins_exists == "true") {
		$tbl_webadmins_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_webadmins']."` (`id` int(12) NOT NULL auto_increment, `username` varchar(32) default NULL, `password` varchar(32) default NULL, `level` varchar(32) NOT NULL default '6', `logcode` varchar(32) NOT NULL default '', PRIMARY KEY  (`id`), UNIQUE KEY (`username`))") or die (mysql_error());
		$tbl_webadmins_created = 1;
	}

	$tbl_amxadmins_exists = TableExists($_POST['tbl_amxadmins'], $_POST['db_name']);
	if ($tbl_amxadmins_exists == "true") {
		$tbl_amxadmins_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_amxadmins']."` (`id` int(12) NOT NULL auto_increment, `username` varchar(32) default NULL, `password` varchar(32) default NULL, `access` varchar(32) default NULL, `flags` varchar(32) default NULL, `steamid` varchar(32) default NULL, `nickname` varchar(32) NOT NULL default '', PRIMARY KEY  (`id`))") or die (mysql_error());
		$tbl_amxadmins_created = 1;
	}

	$tbl_levels_exists = TableExists($_POST['tbl_levels'], $_POST['db_name']);
	if ($tbl_levels_exists == "true") {

		$check_ip_view = @mysql_query("SELECT ip_view FROM `".$_POST['tbl_levels']."` WHERE 1");

		if (!$check_ip_view) {
			$add_ip_view = mysql_query("ALTER TABLE `".$_POST['tbl_levels']."` ADD `ip_view` ENUM( 'yes', 'no' ) DEFAULT 'no' NOT NULL") or die (mysql_error());
			$update_amxlevels = 1;
		} else {
			$update_amxlevels = 0;
		}

		$check_servers_view = @mysql_query("SELECT servers_view FROM `".$_POST['tbl_levels']."` WHERE 1");

		if (!$check_servers_view) {
			$update_amxlevels = 0;
		} else {
			$edit_servers_view = mysql_query("ALTER TABLE `".$_POST['tbl_levels']."` CHANGE `servers_view` `servers_edit` ENUM( 'yes', 'no' ) DEFAULT 'no' NOT NULL ") or die (mysql_error());
			$update_amxlevels = 1;
		}

		$check_servers_delete = @mysql_query("SELECT servers_delete FROM `".$_POST['tbl_levels']."` WHERE 1");

		if (!$check_servers_delete) {
			$update_amxlevels = 0;
		} else {
			$delete_servers_delete = mysql_query("ALTER TABLE `".$_POST['tbl_levels']."` DROP `servers_delete") or die (mysql_error());
			$update_amxlevels = 1;
		}

		$edit_own = @mysql_query("ALTER TABLE `".$_POST['tbl_levels']."` CHANGE `bans_edit` `bans_edit` ENUM( 'yes', 'no', 'own' ) DEFAULT 'no' NOT NULL, CHANGE `bans_delete` `bans_delete` ENUM( 'yes', 'no', 'own' ) DEFAULT 'no' NOT NULL , CHANGE `bans_unban` `bans_unban` ENUM( 'yes', 'no', 'own' ) DEFAULT 'no' NOT NULL") or die (mysql_error());

		$tbl_levels_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_levels']."` (`level` int(12) NOT NULL default '0', `bans_add` enum('yes','no') NOT NULL default 'no', `bans_edit` enum('yes','no', 'own') NOT NULL default 'no', `bans_delete` enum('yes','no', 'own') NOT NULL default 'no', `bans_unban` enum('yes','no', 'own') NOT NULL default 'no', `bans_import` enum('yes','no') NOT NULL default 'no', `bans_export` enum('yes','no') NOT NULL default 'no', `amxadmins_view` enum('yes','no') NOT NULL default 'no', `amxadmins_edit` enum('yes','no') NOT NULL default 'no', `webadmins_view` enum('yes','no') NOT NULL default 'no', `webadmins_edit` enum('yes','no') NOT NULL default 'no', `permissions_edit` enum('yes','no') NOT NULL default 'no', `prune_db` enum('yes','no') NOT NULL default 'no', `servers_edit` enum('yes','no') NOT NULL default 'no', `ip_view` enum('yes','no') NOT NULL default 'no', PRIMARY KEY  (`level`))") or die (mysql_error());
		$tbl_levels_created = 1;
	}

	$tbl_admins_servers_exists = TableExists($_POST['tbl_admins_servers'], $_POST['db_name']);
	if ($tbl_admins_servers_exists == "true") {
		$tbl_admins_servers_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_admins_servers']."` (`admin_id` int(12) NOT NULL default '0', `server_id` int(12) NOT NULL default '0')") or die (mysql_error());
		$tbl_admins_servers_created = 1;
	}

	$tbl_servers_exists = TableExists($_POST['tbl_servers'], $_POST['db_name']);
	if ($tbl_servers_exists == "true") {

		$check_amxban_menu = @mysql_query("SELECT amxban_menu FROM `".$_POST['tbl_servers']."` WHERE 1");

		if (!$check_amxban_menu) {
			$add_amxbans_menu = mysql_query("ALTER TABLE `".$_POST['tbl_servers']."` ADD `amxban_menu` int(10) DEFAULT '0' NOT NULL") or die (mysql_error());
			$update_amxservers = 1;
		} else {
			$update_amxservers = 0;
		}

		$tbl_servers_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_servers']."` (`id` int(11) NOT NULL auto_increment, `timestamp` varchar(50) NOT NULL default '0', `hostname` varchar(100) NOT NULL default 'Unknown', `address` varchar(32) NOT NULL default '', `gametype` varchar(32) NOT NULL default '', `rcon` varchar(32) default NULL, `amxban_version` varchar(32) NOT NULL default '', `amxban_motd` varchar(250) NOT NULL default '', `motd_delay` int(10) NOT NULL default '10', `amxban_menu` int(10) NOT NULL default '0', PRIMARY KEY  (`id`))") or die (mysql_error());
		$tbl_servers_created = 1;
	}

	$tbl_logs_exists = TableExists($_POST['tbl_logs'], $_POST['db_name']);
	if ($tbl_logs_exists == "true") {
		$tbl_logs_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_logs']."` (`id` int(11) NOT NULL auto_increment, `timestamp` int(1) NOT NULL, `ip` varchar(100) NOT NULL, `username` varchar(100) NOT NULL, `action` varchar(100) NOT NULL, `remarks` varchar(100) NOT NULL, PRIMARY KEY (`id`))") or die (mysql_error());
		$tbl_logs_created = 1;
	}

	$tbl_reasons_exists = TableExists($_POST['tbl_reasons'], $_POST['db_name']);
	if ($tbl_reasons_exists == "true") {
		$tbl_reasons_created = 0;
	} else {
		$create_tbl = mysql_query("CREATE TABLE `".$_POST['tbl_reasons']."` (`id` int(12) NOT NULL auto_increment, `address` varchar(32) NOT NULL, `reason` varchar(250) NOT NULL, PRIMARY KEY (`id`))") or die (mysql_error());
		$tbl_reasons_created = 1;
	}
} else if ((isset($_POST['check'])) && ($_POST['check'] == 'check dirs')) {
	unset($checked_dirs);
	//if (($_POST['doc_root'] == "") || ($_POST['path_root'] == "") || ($_POST['dir_import'] == "") || ($_POST['dir_template'] == "")) {
	// Removed the check for doc_rot if emty because sometimes it has to be empty // lantz69
	if (($_POST['path_root'] == '') || ($_POST['dir_import'] == '') || ($_POST['dir_template'] == '')) {
		$checked_dirs = 1; //some fields are left blank
	} else {

		if (is_dir($_POST['path_root'])) {
			$path_root_is_dir = 1;
		} else {
			$path_root_is_dir = 0;
		}

		if (is_dir($_POST['dir_import'])) {
			$dir_import_is_dir = 1;
		} else {
			$dir_import_is_dir = 0;
		}

		if (is_dir($_POST['dir_template'])) {
			$dir_template_is_dir = 1;
		} else {
			$dir_template_is_dir = 0;
		}
	}


	if ($checked_dirs != 1) {
		if (($path_root_is_dir == 0) || ($dir_import_is_dir == 0) || ($dir_template_is_dir == 0)) {
			$checked_dirs = 2;
		} else {
			$checked_dirs = 3;
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Installation - AMXX Bans</title>

		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache" />

		<link rel="stylesheet" type="text/css" href="../css/reset.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../css/amxbans.css" />

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.0.3/bootstrap.min.js"></script>

	</head>

	<body>
		<div id="setup-container" class="span12">


			<? if ((isset($action)) && ($action == 'step 2' || $action == 'check tables')) { ?>
					<h1>Step 2: Table Setup</h1>
					<p>
						Here you can define names for your tables. Please note that if you choose a different name for the Bans table and/or AMXAdmins table, you need to specify the same names in the amxbans and admin_mysql plugins.
						Existing tables will <b>*not*</b> be overwritten. So this script is safe when upgrading from previous versions of AMXBans.
					</p>
					<form class="well" name="section" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
						<input type="hidden" name="action" value="<?=$_POST['action'] ?>">
						<input type="hidden" name="db_host" value="<?=$_POST['db_host'] ?>">
						<input type="hidden" name="db_name" value="<?=$_POST['db_name'] ?>">
						<input type="hidden" name="db_user" value="<?=$_POST['db_user'] ?>">
						<input type="hidden" name="db_pass" value="<?=$_POST['db_pass'] ?>">
						<input type="hidden" name="tbl_bans" value="<?=isset($_POST['tbl_bans']) ? $_POST['tbl_bans'] : "" ?>">
						<input type="hidden" name="tbl_banhistory" value="<?=isset($_POST['tbl_banhistory']) ? $_POST['tbl_banhistory'] : "" ?>">
						<input type="hidden" name="tbl_webadmins" value="<?=isset($_POST['tbl_webadmins']) ? $_POST['tbl_webadmins'] : "" ?>">
						<input type="hidden" name="tbl_amxadmins" value="<?=isset($_POST['tbl_amxadmins']) ? $_POST['tbl_amxadmins'] : "" ?>">
						<input type="hidden" name="tbl_levels" value="<?=isset($_POST['tbl_levels']) ? $_POST['tbl_levels'] : "" ?>">
						<input type="hidden" name="tbl_admins_servers" value="<?=isset($_POST['tbl_admins_servers']) ? $_POST['tbl_admins_servers'] : "" ?>">
						<input type="hidden" name="tbl_servers" value="<?=isset($_POST['tbl_servers']) ? $_POST['tbl_servers'] : "" ?>">
						<input type="hidden" name="tbl_logs" value="<?=isset($_POST['tbl_logs']) ? $_POST['tbl_logs'] : "" ?>">
						<input type="hidden" name="tbl_reasons" value="<?=isset($_POST['tbl_reasons']) ? $_POST['tbl_reasons'] : "" ?>">

						<label>Bans</label>
						<? if ((!isset($_POST['tbl_bans'])) && (!isset($tbl_bans_created))) { ?>
							<input type="text" name="tbl_bans" value="<? if (!isset($POST['tbl_bans'])) { echo "amx_bans"; } else { print $_POST['tbl_bans']; } ?>" >
						<? } else {
							if ($tbl_bans_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_bans'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_bans'].'\' successfully created.
									</div>';
							}
						}?>
						<label>Ban History</label>
						<? if ((!isset($_POST['tbl_banhistory'])) && (!isset($tbl_banhistory_created))) { ?>
							<input type="text" name="tbl_banhistory" value="<? if (!isset($POST['tbl_banhistory'])) { echo "amx_banhistory"; } else { print $_POST['tbl_banhistory']; } ?>" >
						<? } else {
							if ($tbl_banhistory_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_banhistory'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_banhistory'].'\' successfully created.
									</div>';
							}
						}?>
						<label>Web Admins</label>
						<? if ((!isset($_POST['tbl_webadmins'])) && (!isset($tbl_webadmins_created))) { ?>
							<input type="text" name="tbl_webadmins" value="<? if (!isset($POST['tbl_webadmins'])) { echo "amx_webadmins"; } else { print $_POST['tbl_webadmins']; } ?>" >
						<? } else {
							if ($tbl_webadmins_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_webadmins'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_webadmins'].'\' successfully created.
									</div>';
							}
						}?>
						<label>AMXX Admins</label>
						<? if ((!isset($_POST['tbl_amxadmins'])) && (!isset($tbl_amxadmins_created))) { ?>
							<input type="text" name="tbl_amxadmins" value="<? if (!isset($POST['tbl_amxadmins'])) { echo "amx_amxadmins"; } else { print $_POST['tbl_amxadmins']; } ?>" >
						<? } else {
							if ($tbl_amxadmins_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_amxadmins'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_amxadmins'].'\' successfully created.
									</div>';
							}
						}?>
						<label>Levels</label>
						<? if ((!isset($_POST['tbl_levels'])) && (!isset($tbl_levels_created))) { ?>
							<input type="text" name="tbl_levels" value="<? if (!isset($POST['tbl_levels'])) { echo "amx_levels"; } else { print $_POST['tbl_levels']; } ?>" > <? } else {
							if ($tbl_levels_created == 0) {
								if ($update_amxlevels == 1) {
									echo
										'<div class="alert alert-info">
											<strong>Heads Up!</strong> Found an older version of \''.$_POST['tbl_levels'].'\'. Upgrade to version 3 successful!
										</div>';
								} else {
									echo
										'<div class="alert">
											<strong>Warning!</strong> Table \''.$_POST['tbl_levels'].'\' already exists, skipping...
										</div>';
								}
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_levels'].'\' successfully created.
									</div>';
							}
						}?>
						<label>Admins/Servers Crosstable</label>
						<? if ((!isset($_POST['tbl_admins_servers'])) && (!isset($tbl_admins_servers_created))) { ?>
							<input type="text" name="tbl_admins_servers" value="<? if (!isset($POST['tbl_admins_servers'])) { echo "amx_admins_servers"; } else { print $_POST['tbl_admins_servers']; } ?>" >
							<? } else {
								if ($tbl_admins_servers_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_admins_servers'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_admins_servers'].'\' successfully created.
									</div>';
								}
							}?>

						<label>Server Info</label>
						<? if ((!isset($_POST['tbl_servers'])) && (!isset($tbl_servers_created))) { ?>
							<input type="text" name="tbl_servers" value="<? if (!isset($POST['tbl_servers'])) { echo "amx_serverinfo"; } else { print $_POST['tbl_servers']; } ?>" > <?
						} else {
							if ($tbl_servers_created == 0) {
								if ($update_amxservers == 1) {
									echo
										'<div class="alert alert-info">
											<strong>Heads Up!</strong> Found an older version of \''.$_POST['tbl_servers'].'\'. Upgrade to version 3.1 successful!
										</div>';
								} else {
									echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_servers'].'\' already exists, skipping...
									</div>';
								}
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_servers'].'\' successfully created.
									</div>';
							}
						}?>
						<label>Logs</label>
						<? if ((!isset($_POST['tbl_logs'])) && (!isset($tbl_logs_created))) { ?>
							<input type="text" name="tbl_logs" value="<? if (!isset($POST['tbl_logs'])) { echo "amx_logs"; } else { print $_POST['tbl_logs']; } ?>" >
						<? } else {
							if ($tbl_logs_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_logs'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_logs'].'\' successfully created.
									</div>';
							}
						}?>
						<label>Ban Reasons</label>
						<? if ((!isset($_POST['tbl_reasons'])) && (!isset($tbl_reasons_created))) { ?>
							<input type="text" name="tbl_reasons" value="<? if (!isset($POST['tbl_reasons'])) { echo "amx_banreasons"; } else { print $_POST['tbl_reasons']; } ?>" >
						<? } else {
							if ($tbl_reasons_created == 0) {
								echo
									'<div class="alert">
										<strong>Warning!</strong> Table \''.$_POST['tbl_reasons'].'\' already exists, skipping...
									</div>';
							} else {
								echo
									'<div class="alert alert-success">
										<strong>Status ok!</strong> Table \''.$_POST['tbl_reasons'].'\' successfully created.
									</div>';
							}
						}?>

						<div class="clearfix"></div>

						<? if (isset($_POST['check']) && $_POST['check'] == 'create') { ?>
							<button class="btn btn-primary" type="submit" name="action" value="step 3"><i class="icon-ok icon-white"></i> Continue to step 3</button>
						<? }else { ?>
							<button class="btn btn-primary" type="submit" name="check" value="create" >Create Tables</button>
						<? } ?>
					</form>


			<? } else if ((isset($action)) && ($action == 'step 3')) { ?>

				<h1>Step 3: Directory Setup</h1>
				<p>
					Enter the path-information for AMXBans here. This script tries to calculate the correct values. Do not change the default values if you are not sure what you are doing.
				</p>

				<form class="well" name="section" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
					<input type="hidden" name="action" value="<?=$_POST['action'] ?>">
					<input type="hidden" name="db_host" value="<?=$_POST['db_host'] ?>">
					<input type="hidden" name="db_name" value="<?=$_POST['db_name'] ?>">
					<input type="hidden" name="db_user" value="<?=$_POST['db_user'] ?>">
					<input type="hidden" name="db_pass" value="<?=$_POST['db_pass'] ?>">
					<input type="hidden" name="tbl_bans" value="<?=$_POST['tbl_bans'] ?>">
					<input type="hidden" name="tbl_banhistory" value="<?=$_POST['tbl_banhistory'] ?>">
					<input type="hidden" name="tbl_webadmins" value="<?=$_POST['tbl_webadmins'] ?>">
					<input type="hidden" name="tbl_amxadmins" value="<?=$_POST['tbl_amxadmins'] ?>">
					<input type="hidden" name="tbl_levels" value="<?=$_POST['tbl_levels'] ?>">
					<input type="hidden" name="tbl_admins_servers" value="<?=$_POST['tbl_admins_servers'] ?>">
					<input type="hidden" name="tbl_servers" value="<?=$_POST['tbl_servers'] ?>">
					<input type="hidden" name="tbl_logs" value="<?=$_POST['tbl_logs'] ?>">
					<input type="hidden" name="tbl_reasons" value="<?=$_POST['tbl_reasons'] ?>">

					<label>Document Root</label>
					<input class="input-xxlarge" type="text" name="doc_root" value="<? if (!isset($_POST['doc_root'])) { $docroot = str_replace('/admin/setup.php', '', $_SERVER['PHP_SELF']); echo $docroot; } else { print $_POST['doc_root']; } ?>" >
					<label>Path root</label>
					<input class="input-xxlarge" type="text" name="path_root" value="<? if (!isset($_POST['path_root'])) { $scriptrealpath = ereg_replace('\\\\','/', realpath('.'));$scriptrealpath = ereg_replace('/admin','', $scriptrealpath); echo $scriptrealpath; } else { print $_POST['path_root']; } ?>" >

					<? if ((isset($_POST['check']) && $_POST['check'] == 'check dirs') && ($path_root_is_dir != 1)) {
						echo "&nbsp;<font color=\"#ff0000\">Directory does not exist or is invalid.</font>";
					} ?>

					<label>Import dir</label>
					<input class="input-xxlarge" type="text" name="dir_import" value="<? if (!isset($_POST['dir_import'])) {$scriptrealpath = ereg_replace('\\\\','/', realpath('.'));$scriptrealpath = ereg_replace('/admin','', $scriptrealpath); echo $scriptrealpath.'/tmp'; } else { print $_POST['dir_import']; } ?>" >

					<? if (( isset($_POST['check']) && $_POST['check'] == 'check dirs') && ($dir_import_is_dir != 1)) {
						echo "&nbsp;<font color=\"#ff0000\">Directory does not exist or is invalid.</font>";
					} ?>

					<label>Template dir</label>
					<input class="input-xxlarge" type="text" name="dir_template" value="<? if (!isset($_POST['dir_template'])) { $scriptrealpath = ereg_replace('\\\\','/', realpath('.'));$scriptrealpath = ereg_replace('/admin','', $scriptrealpath); echo $scriptrealpath.'/templates'; } else { print $_POST['dir_template']; } ?>" >

					<? if ((isset($_POST['check']) && $_POST['check'] == 'check dirs') && ($dir_template_is_dir != 1)) {
						echo "&nbsp;<font color=\"#ff0000\">Directory does not exist or is invalid.</font>";
					} ?>

					<? if ((( isset($_POST['check']) && $_POST['check'] == 'check dirs') && ($checked_dirs == 1))) {
							echo "<font color=\"#ff0000\">Please fill in all required fields.</font>";
					} else {
						if (isset($checked_dirs) && $checked_dirs == 3) {
								echo "<font color=\"#00b266\">Directory information OK. Proceed.</font>";
						}
					} ?>

					<div class="clearfix"></div>
					<? if (isset($checked_dirs) && $checked_dirs != 3) {
						echo '<button class="btn btn-primary" type="submit" name="check" value="check dirs"><i class="icon-refresh icon-white"></i> Check Dir</button>';
					} else {
						echo '<button class="btn btn-primary" type="submit" name="action" value="step 4"><i class="icon-ok icon-white"></i> Continue to step 4</button>';
					} ?>

			</form>

			<? } else if ((isset($action)) && ($action == 'step 4')) { ?>

				<h1>Step 4: Back-End Administrator</h1>
				<p>
					Create your admin-account here. This admin will be granted all privileges (level 1). You will be able to add more admins and levels at a later stage.
				</p>
				<p>
					The E-mail address you enter here will not be visible to anyone. It's only used for displaying and handling error messages.
				</p>
				<form class="well" name="section" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
					<input type="hidden" name="action" value="<?=$_POST['action'] ?>">
					<input type="hidden" name="db_host" value="<?=$_POST['db_host'] ?>">
					<input type="hidden" name="db_name" value="<?=$_POST['db_name'] ?>">
					<input type="hidden" name="db_user" value="<?=$_POST['db_user'] ?>">
					<input type="hidden" name="db_pass" value="<?=$_POST['db_pass'] ?>">
					<input type="hidden" name="tbl_bans" value="<?=$_POST['tbl_bans'] ?>">
					<input type="hidden" name="tbl_banhistory" value="<?=$_POST['tbl_banhistory'] ?>">
					<input type="hidden" name="tbl_webadmins" value="<?=$_POST['tbl_webadmins'] ?>">
					<input type="hidden" name="tbl_amxadmins" value="<?=$_POST['tbl_amxadmins'] ?>">
					<input type="hidden" name="tbl_levels" value="<?=$_POST['tbl_levels'] ?>">
					<input type="hidden" name="tbl_admins_servers" value="<?=$_POST['tbl_admins_servers'] ?>">
					<input type="hidden" name="tbl_servers" value="<?=$_POST['tbl_servers'] ?>">
					<input type="hidden" name="tbl_logs" value="<?=$_POST['tbl_logs'] ?>">
					<input type="hidden" name="tbl_reasons" value="<?=$_POST['tbl_reasons'] ?>">
					<input type="hidden" name="doc_root" value="<?=$_POST['doc_root'] ?>">
					<input type="hidden" name="path_root" value="<?=$_POST['path_root'] ?>">
					<input type="hidden" name="dir_import" value="<?=$_POST['dir_import'] ?>">
					<input type="hidden" name="dir_template" value="<?=$_POST['dir_template'] ?>">

					<label>Nickname</label>
					<input class="input-xlarge" type="text" name="admin_nick" value="<? if (!isset($_POST['admin_nick'])) { echo 'John Smith'; } else { print $_POST['admin_nick']; } ?>" >
					<label>E-mail address</label>
					<input class="input-xlarge" type="text" name="admin_email" value="<? if (!isset($_POST['admin_email'])) { echo 'email@example.com'; } else { print $_POST['admin_email']; } ?>" >
					<label>Password</label>
					<input class="input-xlarge" type="password" name="admin_pass" value="<?=isset($_POST['admin_pass']) ? $_POST['admin_pass'] : '' ?>" >

					<div class="clearfix"></div>
					<? if (isset($empty_details) && $empty_details == 1){
						echo "<font color=\"#ff0000\">Please fill in all required fields.</font>";
					} ?>
					<button class="btn btn-primary" type="submit" name="action" value="step 5"><i class="icon-ok icon-white"></i> Continue to step 4</button>
				</form>

			<? } else if ((isset($action)) && ($action == 'step 5')) { ?>

				<h1>Step 5: AMXBans config items</h1>

				<p>
					Use included AMX admin manager
				</p>
				<p>
					With this option you can decide to use the AMX admin manager that comes with AMXBans. Should you choose to a different method of defining admins (such as via the users.ini file per server) you should set this option to 'disabled'. We obviously recommend you check out our included AMXadmin manager (leave 'enabled'). You can easily disable it at a later stage.
				</p>
				<p>
					Use fancy layers
				</p>
				<p>
					Setting this to 'enabled' enables visitors to 'unfold' ban_details (instead of being directed to a separate 'ban_details'-page).Please note that this functionality was only tested with Internet Explorer. You can easily disable it at a later stage should you or your users experience difficulties viewing the ban list.
				</p>
				<p>
					Enable version-checking
				</p>
				<p>
					AMXBans is frequently updated to include added functionalities and/or bugfixes. Enabling this option allows admins to see when a new version is released. If a new version becomes available, logged-in admins can see a notice on the ban_list page.
				</p>
				<p>
					Display reason on front-page
				</p>
				<p>
					By default only the date, player nickname, admin and ban-length are displayed on the front-page. If you enable this option, the ban-reason will also be displayed.
				</p>
				<p>
					Use custom error-handler
				</p>
				<p>
					You can use your own error-handler if you want. Leave this option disabled if unsure.
				</p>
				<p>
					Bans per page
				</p>
				<p>
					Here you can set how many bans are displayed per page.
				</p>

				<form class="well" name="section" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
					<input type="hidden" name="action" value="<?=$_POST['action'] ?>">
					<input type="hidden" name="db_host" value="<?=$_POST['db_host'] ?>">
					<input type="hidden" name="db_name" value="<?=$_POST['db_name'] ?>">
					<input type="hidden" name="db_user" value="<?=$_POST['db_user'] ?>">
					<input type="hidden" name="db_pass" value="<?=$_POST['db_pass'] ?>">
					<input type="hidden" name="tbl_bans" value="<?=$_POST['tbl_bans'] ?>">
					<input type="hidden" name="tbl_banhistory" value="<?=$_POST['tbl_banhistory'] ?>">
					<input type="hidden" name="tbl_webadmins" value="<?=$_POST['tbl_webadmins'] ?>">
					<input type="hidden" name="tbl_amxadmins" value="<?=$_POST['tbl_amxadmins'] ?>">
					<input type="hidden" name="tbl_levels" value="<?=$_POST['tbl_levels'] ?>">
					<input type="hidden" name="tbl_admins_servers" value="<?=$_POST['tbl_admins_servers'] ?>">
					<input type="hidden" name="tbl_servers" value="<?=$_POST['tbl_servers'] ?>">
					<input type="hidden" name="tbl_logs" value="<?=$_POST['tbl_logs'] ?>">
					<input type="hidden" name="tbl_reasons" value="<?=$_POST['tbl_reasons'] ?>">
					<input type="hidden" name="doc_root" value="<?=$_POST['doc_root'] ?>">
					<input type="hidden" name="path_root" value="<?=$_POST['path_root'] ?>">
					<input type="hidden" name="dir_import" value="<?=$_POST['dir_import'] ?>">
					<input type="hidden" name="dir_template" value="<?=$_POST['dir_template'] ?>">
					<input type="hidden" name="admin_nick" value="<?=$_POST['admin_nick'] ?>">
					<input type="hidden" name="admin_email" value="<?=$_POST['admin_email'] ?>">
					<input type="hidden" name="admin_pass" value="<?=$_POST['admin_pass'] ?>">

					<label>Use included AMX admin manager?</label>


					<select name="admin_management">
						<option value="enabled" <? if ((isset($_POST['admin_management'])) && ($_POST['admin_management'] == 'enabled')) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if ((isset($_POST['admin_management'])) && ($_POST['admin_management'] == 'disabled')) { echo 'selected'; } ?>>Disabled</option>
					</select>

					<label>Use fancy layers?</label>

					<select name="fancy_layers">
						<option value="enabled" <? if ((isset($_POST['fancy_layers'])) && ($_POST['fancy_layers'] == 'enabled')) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if ((isset($_POST['fancy_layers'])) && ($_POST['fancy_layers'] == 'disabled')) { echo 'selected'; } ?>>Disabled</option>
					</select>

					<label>Enable version-checking?</label>

					<select name="version_checking">
						<option value="enabled" <? if ((isset($_POST['version_checking'])) && ($_POST['version_checking'] == 'enabled') || (!isset($_POST['version_checking']))) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if ((isset($_POST['version_checking'])) && ($_POST['version_checking'] == 'disabled')) { echo 'selected'; } ?>>Disabled</option>
					</select>


					<label>Hours between web server and game server.</label>

					<select name='timezone_fix'>
						<option value="0" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "0"))  { echo 'selected'; } ?>>0</option>
						<option value="1" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "1"))  { echo 'selected'; } ?>>+1</option>
						<option value="2" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "2"))  { echo 'selected'; } ?>>+2</option>
						<option value="3" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "3"))  { echo 'selected'; } ?>>+3</option>
						<option value="4" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "4"))  { echo 'selected'; } ?>>+4</option>
						<option value="5" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "5"))  { echo 'selected'; } ?>>+5</option>
						<option value="6" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "6"))  { echo 'selected'; } ?>>+6</option>
						<option value="7" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "7"))  { echo 'selected'; } ?>>+7</option>
						<option value="8" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "8"))  { echo 'selected'; } ?>>+8</option>
						<option value="9" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "9"))  { echo 'selected'; } ?>>+9</option>
						<option value="10" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "10")) { echo 'selected'; } ?>>+10</option>
						<option value="11" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "11")) { echo 'selected'; } ?>>+11</option>
						<option value="12" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "12")) { echo 'selected'; } ?>>+12</option>
						<option value="-1" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-1"))  { echo 'selected'; } ?>>-1</option>
						<option value="-2" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-2"))  { echo 'selected'; } ?>>-2</option>
						<option value="-3" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-3"))  { echo 'selected'; } ?>>-3</option>
						<option value="-4" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-4"))  { echo 'selected'; } ?>>-4</option>
						<option value="-5" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-5"))  { echo 'selected'; } ?>>-5</option>
						<option value="-6" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-6"))  { echo 'selected'; } ?>>-6</option>
						<option value="-7" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-7"))  { echo 'selected'; } ?>>-7</option>
						<option value="-8" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-8"))  { echo 'selected'; } ?>>-8</option>
						<option value="-9" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-9"))  { echo 'selected'; } ?>>-9</option>
						<option value="-10" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-10")) { echo 'selected'; } ?>>-10</option>
						<option value="-11" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-11")) { echo 'selected'; } ?>>-11</option>
						<option value="-12" <? if ((isset($_POST['timezone_fix'])) && ($_POST['timezone_fix'] == "-12")) { echo 'selected'; } ?>>-12</option>
					</select>

					<label>Should public users be able to use search?</label>

					<select name="display_search">
						<option value="enabled" <? if ((isset($_POST['display_search'])) && ($_POST['display_search'] == 'enabled')) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if (((isset($_POST['display_search'])) && ($_POST['display_search'] == 'disabled'))) { echo 'selected'; } ?>>Disabled</option>
					</select>

					<label>Display admin nick for public users on front-page?</label>

					<select name="display_admin">
						<option value="enabled" <? if ((isset($_POST['display_admin'])) && ($_POST['display_admin'] == 'enabled')) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if (((isset($_POST['display_admin'])) && ($_POST['display_admin'] == 'disabled'))) { echo 'selected'; } ?>>Disabled</option>
					</select>

					<label>Display reason on front-page?</label>

					<select name="display_reason">
						<option value="enabled" <? if ((isset($_POST['display_reason'])) && ($_POST['display_reason'] == 'enabled')) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if (((isset($_POST['display_reason'])) && ($_POST['display_reason'] == 'disabled'))) { echo 'selected'; } ?>>Disabled</option>
					</select>

					<label>Use custom error handler?</label>

					<select name="error_handler">
						<option value="enabled" <? if ((isset($_POST['error_handler'])) && ($_POST['error_handler'] == 'enabled')) { echo 'selected'; } ?>>Enabled</option>
						<option value="disabled" <? if (((isset($_POST['error_handler'])) && ($_POST['error_handler'] == 'disabled')) || (!isset($_POST['error_handler']))) { echo 'selected'; } ?>>Disabled</option>
					</select>
					<span class="help-inline">Enable this feature if you want to receive emails when something goes wrong.</span>

					<label>Error Handler</label>
					<input class="input-xxlarge" type="text" name="error_handler_path" value="<? if (!isset($_POST['error_handler_path'])) { print (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '').(isset($docroot) ? $docroot : '').'/include/error_handler.inc.php'; } else { print $_POST['error_handler_path']; } ?>" >
					<? if ((isset($_POST['check']) && $_POST['check'] == 'check dirs') && ($path_root_is_dir != 1)) {
						echo "&nbsp;<font color=\"#ff0000\">Directory does not exist or is invalid.</font>";
					} ?>

					<label>Bans per page</label>

					<select name="bans_amount">
						<option value="10" <? if ((isset($_POST['bans_amount'])) && ($_POST['bans_amount'] == '10')) { echo 'selected'; } ?>>10</option>
						<option value="25" <? if ((isset($_POST['bans_amount'])) && ($_POST['bans_amount'] == '25')) { echo 'selected'; } ?>>25</option>
						<option value="50" <? if ((isset($_POST['bans_amount'])) && ($_POST['bans_amount'] == '50')) { echo 'selected'; } ?>>50</option>
						<option value="75" <? if ((isset($_POST['bans_amount'])) && ($_POST['bans_amount'] == '75')) { echo 'selected'; } ?>>75</option>
						<option value="100" <? if ((isset($_POST['bans_amount'])) && ($_POST['bans_amount'] == '100')) { echo 'selected'; } ?>>100</option>
					</select>

					<div class="clearfix"></div>


				<? if ( isset($empty_details) && $empty_details == 1){
					echo "<font color=\"#ff0000\">Please fill in all required fields.</font>";
				} ?>

					<button class="btn btn-primary" type="submit" name="action" value="finalize">Finalize Settings</button>
				</form>


			<? } else if ((isset($action)) && ($action == 'finalize')) { ?>

				<h1>Step 6: Create objects/tables</h1>

				<p>
					Level 1 will be created and the admin you entered earlier will be assigned this level. The file config.inc.php will be created. If you are upgrading from a previous version, and you are getting 'failed' on creating the level and webadmin; this is caused by the fact that level 1 an the specified webadmin allready exists in the database.
				</p>

			<form class="well" name="section" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
			<?
				$config->document_root		= $_POST['doc_root'];
				$config->path_root			= $_POST['path_root'];
				$config->importdir			= $_POST['dir_import'];
				$config->templatedir		= $_POST['dir_template'];

				$config->db_host			= $_POST['db_host'];
				$config->db_name			= $_POST['db_name'];
				$config->db_user			= $_POST['db_user'];
				$config->db_pass			= $_POST['db_pass'];

				$config->bans				= $_POST['tbl_bans'];
				$config->ban_history		= $_POST['tbl_banhistory'];
				$config->webadmins			= $_POST['tbl_webadmins'];
				$config->amxadmins			= $_POST['tbl_amxadmins'];
				$config->levels				= $_POST['tbl_levels'];
				$config->admins_servers		= $_POST['tbl_admins_servers'];
				$config->servers			= $_POST['tbl_servers'];
				$config->logs				= $_POST['tbl_logs'];
				$config->reasons			= $_POST['tbl_reasons'];

				$config->admin_nickname		= $_POST['admin_nick'];
				$config->admin_email		= $_POST['admin_email'];

				$config->error_handler		= $_POST['error_handler'];
				$config->error_handler_path	= $_POST['error_handler_path'];

				$config->admin_management	= $_POST['admin_management'];

				$config->fancy_layers		= $_POST['fancy_layers'];

				$config->version_checking	= $_POST['version_checking'];

				$config->bans_per_page		= $_POST['bans_amount'];

				$config->display_search 	= $_POST['display_search'];

				$config->timezone_fix 		= $_POST['timezone_fix'];

				$config->display_admin 		= $_POST['display_admin'];

				$config->display_reason		= $_POST['display_reason'];

				$config->disable_frontend	= "false";
				$config->rcon_class 		= "two";
				$config->geoip				= "enabled";
				$config->autopermban_count 	= "disabled";

				$link			= @mysql_connect($config->db_host, $config->db_user, $config->db_pass);
				$db_selected	= @mysql_select_db($config->db_name, $link);
				$insert_level 	= @mysql_query("INSERT INTO $config->levels VALUES ('1', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes')");
				$pass			= md5($_POST['admin_pass']);
				$insert_admin 	= @mysql_query("INSERT INTO $config->webadmins (username, password, level) VALUES ('$config->admin_nickname', '$pass', '1')");

				$insert_level;

				if (!$insert_level) {
					$insert_level_error = 1;
				} else {
					$insert_level_error = 0;
				}

				if (!$insert_admin) {
					$insert_admin_error = 1;
				} else {
					$insert_admin_error = 0;
				}

			?>

				<label>Creating the default level</label>
				<? if ($insert_level_error == 0) {
					echo
						'<div class="alert alert-success">
							<strong>Success!</strong>
							Default level successfully created.
						</div>';
				} else {
					echo
						'<div class="alert">
							<strong>Warning!</strong>
							Can\'t add a default level. This can happen if you\'re upgrading. Double-check to be sure!
						</div>';
				} ?>

				<label>Creating the root administrator account (<?=$_POST['admin_nick'] ?>)</label>
				<? if ($insert_level_error == 0) {
					echo
						'<div class="alert alert-success">
							<strong>Success!</strong>
							Root administrator account successfully created.
						</div>';
				} else {
					echo
						'<div class="alert">
							<strong>Warning!</strong>
							Can\'t add \''.$_POST['admin_nick'].'\' as a root administrator. This can happen if you\'re upgrading. Double-check to be sure!
						</div>';
				} ?>

			<?


				$security_fix = "
			// fix text to display
			\$_POST = str_replace(\"\'\", \"\", \$_POST);
			\$_POST = str_replace(\"\\\"\", \"\", \$_POST);
			\$_POST = str_replace(\"\\\\\", \"\", \$_POST);

			\$_GET = str_replace(\"\'\", \"\", \$_GET);
			\$_GET = str_replace(\"\\\"\", \"\", \$_GET);
			\$_GET = str_replace(\"\\\\\", \"\", \$_GET);
			";


				$smarty_meuk = "

			/* Don't edit below this line */
			\$config->update_url = \"http://www.amxbans.net\";
			\$config->php_version = \"5.0\";
			\$config->default_lang = \"english\";

			/* Smarty settings */
			define(\"SMARTY_DIR\", \$config->path_root.\"/smarty/\");

			require(SMARTY_DIR.\"Smarty.class.php\");

			class dynamicPage extends Smarty {
				function dynamicPage() {

					global \$config;

					\$this->Smarty();

					\$this->template_dir = \$config->templatedir;
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

				if (!fopen("$config->path_root/include/config.inc.php", "w")) {
					$config_fail = 1;
				} else {
					$config_fail = 0;
				}

				fwrite($fp, "<?php\n");
				fwrite($fp, $security_fix);

				fwrite($fp, "\n\n");

				while (list($prop, $val) = each($arr)) {
					fwrite($fp, "\$config->$prop = \"$val\";\n");
				}

				fwrite($fp, $smarty_meuk);
				fclose($fp);

			?>

				<label>Writing the config file</label>
				<? if ($config_fail == 0) {
					echo
						'<div class="alert alert-success">
							<strong>Success!</strong>
							Config file has successfully been created.
						</div>';
				} else {
					echo
						'<div class="alert alert-error">
							<strong>Oh snap!</strong>
							Can\'t write the config file! Make sure you have properly set your user permissions.
						</div>';
				} ?>


				<input type="hidden" name="action" value="<?=$_POST['action'] ?>">
				<input type="hidden" name="doc_root" value="<?=$_POST['doc_root'] ?>">

				<? if (isset($empty_details) && $empty_details == 1){
					echo "<font color=\"#ff0000\">Please fill in all required fields.</font>";
				} ?>

				<div class="clearfix"></div>

			      <button class="btn btn-primary" type="submit" name="action" value="go to frontpage">Go to frontpage</button>
			  </form>

			<? } else { ?>

				<h1>Step 1: Adding your database information.</h1>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tempus turpis ac lacus consectetur porttitor. Nullam sollicitudin lectus a quam laoreet suscipit ac vitae lorem. Sed adipiscing auctor quam at vestibulum. Mauris suscipit, sem sed cursus lacinia, eros sem condimentum quam, in gravida elit metus quis neque. Vestibulum convallis sapien in metus tempor id vehicula magna consectetur. Cras viverra auctor viverra. Integer placerat mi vitae nulla molestie vitae volutpat enim fermentum. Nullam viverra gravida sodales. Phasellus nec risus quis tellus gravida lacinia. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nam tempus euismod sem. Maecenas.
				</p>

				<? if ((isset($_POST['check'])) && ($_POST['check'] == 'check connection')) {
					if ($dblogin == 0) {
						echo
							'<div class="alert">
								<button class="close" data-dismiss="alert">×</button>
								<h4 class="alert-heading">Warning!</h4>
								Please fill in all the required fields.
							</div>';
					} else if ($dblogin == 1) {
						echo
							'<div class="alert alert-error">
								<button class="close" data-dismiss="alert">×</button>
								<h4 class="alert-heading">Oh snap!</h4>
								Can\'t connect to the MySQL. Double-check your connection details and try again.
							</div>';
					} else if($dblogin == 2) {
						echo
							'<div class="alert alert-info">
								<button class="close" data-dismiss="alert">×</button>
								<h4 class="alert-heading">Hey there!</h4>
								I can connect to the server but I can\'t access \''.$_POST['db_name'].'\'. Make sure you have created \''.$_POST['db_name'].'\' first, and then try again.
							</div>';
					} else {
						echo
							'<div class="alert alert-success">
								<button class="close" data-dismiss="alert">×</button>
								<h4 class="alert-heading">Connection Successful!</h4>
								Everything seems to be working fine! Well done!
							</div>';
					}
				} ?>

				<form class="well" name="section" method="post" action="<?=$_SERVER['PHP_SELF'] ?>">
					<label>Hostname</label>
					<input type="text" name="db_host" value="<?= isset($_POST['db_host']) ? $_POST['db_host'] : "" ?>">
					<label>Database Name</label>
					<input type="text" name="db_name" value="<?=isset($_POST['db_name']) ? $_POST['db_name'] : "" ?>">
					<label>Username</label>
					<input type="text" name="db_user" value="<?=isset($_POST['db_host']) ? $_POST['db_user'] : "" ?>">
					<label>Password</label>
					<input type="password" name="db_pass" value="<?=isset($_POST['db_host']) ? $_POST['db_pass'] : "" ?>">

					<div class="clearfix"></div>


					<? if ((!isset($dblogin)) || ($dblogin != 3)) {
						echo '<button class="btn btn-info" type="submit" name="check" value="check connection"><i class="icon-refresh icon-white"></i> Check Connection</button>';
					}
					if ((isset($_POST['check']) && ($_POST['check'] == 'check connection')) && (isset($dblogin) && ($dblogin == 3))) {
						echo '<button class="btn btn-primary" type="submit" name="action" value="step 2"><i class="icon-ok icon-white"></i> Continue to step 2</button>';
					} ?>
				</form>
			<? } ?>

		</div>
	</body>

</html>
