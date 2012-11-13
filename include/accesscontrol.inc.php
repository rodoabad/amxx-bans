<?php

function secure($str)
{
// Secure fix + hack logger (writes in sql access log)
	if ($str != "")
	{
		$str = eregi_replace("content-disposition:"," hacking attemptt ",$str);
		$str = eregi_replace("content-type:"," hacking attempt ",$str);
		$str = eregi_replace("content-transfer-encoding:"," hacking attempt ",$str);
		$str = eregi_replace("include"," hacking attempt ",$str);
		$str = eregi_replace("\<\?"," hacking attempt ",$str);
		$str = eregi_replace("\<"," hacking attempt ",$str);
		$str = eregi_replace("<"," hacking attempt ",$str);
		$str = eregi_replace("<\?php"," hacking attempt ",$str);
		$str = eregi_replace("\?\>"," hacking attempt ",$str);
		$str = eregi_replace("\>"," hacking attempt ",$str);
		$str = eregi_replace(">"," hacking attempt ",$str);
		$str = eregi_replace("script"," hacking attempt ",$str);
		$str = eregi_replace("eval"," hacking attempt ",$str);
		$str = eregi_replace("javascript"," hacking attempt ",$str);
		$str = eregi_replace("embed"," hacking attempt ",$str);
		$str = eregi_replace("iframe"," hacking attempt ",$str);
		$str = eregi_replace("refresh"," hacking attempt ",$str);
		$str = eregi_replace("onload"," hacking attempt ",$str);
		$str = eregi_replace("onstart"," hacking attempt ",$str);
		$str = eregi_replace("onerror"," hacking attempt ",$str);
		$str = eregi_replace("onabort"," hacking attempt ",$str);
		$str = eregi_replace("onblur"," hacking attempt ",$str);
		$str = eregi_replace("onchange"," hacking attempt ",$str);
		$str = eregi_replace("onclick"," hacking attempt ",$str);
		$str = eregi_replace("ondblclick"," hacking attempt ",$str);
		$str = eregi_replace("onfocus"," hacking attempt ",$str);
		$str = eregi_replace("onkeydown"," hacking attempt ",$str);
		$str = eregi_replace("onkeypress"," hacking attempt ",$str);
		$str = eregi_replace("onkeyup"," hacking attempt ",$str);
		$str = eregi_replace("onmousedown"," hacking attempt ",$str);
		$str = eregi_replace("onmousemove"," hacking attempt ",$str);
		$str = eregi_replace("onmouseover"," hacking attempt ",$str);
		$str = eregi_replace("onmouseout"," hacking attempt ",$str);
		$str = eregi_replace("onmouseup"," hacking attempt ",$str);
		$str = eregi_replace("onreset"," hacking attempt ",$str);
		$str = eregi_replace("onselect"," hacking attempt ",$str);
		$str = eregi_replace("onsubmit"," hacking attempt ",$str);
		$str = eregi_replace("onunload"," hacking attempt ",$str);
		$str = eregi_replace("document"," hacking attempt ",$str);
		$str = eregi_replace("cookie"," hacking attempt ",$str);
		$str = eregi_replace("vbscript"," hacking attempt ",$str);
		$str = eregi_replace("location"," hacking attempt ",$str);
		$str = eregi_replace("object"," hacking attempt ",$str);
		$str = eregi_replace("vbs"," hacking attempt ",$str);
		$str = eregi_replace("href"," hacking attempt ",$str);
		$str = eregi_replace("scrtipt"," hacking attempt ",$str);
		$str = eregi_replace(" src"," hacking attempt ",$str);
		$str = eregi_replace("src "," hacking attempt ",$str);
		$str = eregi_replace(" src "," hacking attempt ",$str);
	} 
	return($str);
}

if(isset($_POST['uid'])){
	$_POST['uid'] = secure($_POST['uid']);
}

if(isset($_POST['pwd'])){
	$_POST['pwd'] = secure($_POST['pwd']);
}

require("$config->path_root/include/functions.inc.php");
if(isset($_COOKIE["amxbans"])) {
	$cook			= explode(":", $_COOKIE["amxbans"]);
	$uid			= $cook[0];
	$pwd			= $cook[1];
	$lvl			= $cook[2];
	$uip			= $cook[3];
	$logcode		= $cook[4];
	$bans_add		= $cook[5];
	$bans_edit		= $cook[6];
	$bans_delete		= $cook[7];
	$bans_unban		= $cook[8];
	$bans_import		= $cook[9];
	$bans_export		= $cook[10];
	$amxadmins_view		= $cook[11];
	$amxadmins_edit		= $cook[12];
	$webadmins_view		= $cook[13];
	$webadmins_edit		= $cook[14];
	$permissions_edit	= $cook[15];
	$prune_db		= $cook[16];
	$servers_edit		= $cook[17];
	$ip_view		= $cook[18];

	$uid			= secure($uid);

	if (isset($_POST['uid'])) {
	 $uid = $_POST['uid'];
	}

	if (isset($_POST['pwd'])) {
	 $pwd = $_POST['pwd'];
	}

	if (isset($_POST['uip'])) {
	 $uip = $_POST['uip'];
	}

	if (isset($_POST['lvl'])) {
	 $lvl = $_POST['lvl'];
	}

	if (isset($_POST['bans_add'])) {
	 $bans_add = $_POST['bans_add'];
	}

	if (isset($_POST['bans_edit'])) {
	 $bans_edit = $_POST['bans_edit'];
	}

	if (isset($_POST['bans_delete'])) {
	 $bans_delete = $_POST['bans_delete'];
	}

	if (isset($_POST['bans_unban'])) {
	 $bans_unban = $_POST['bans_unban'];
	}

	if (isset($_POST['bans_import'])) {
	 $bans_import = $_POST['bans_import'];
	}

	if (isset($_POST['bans_export'])) {
	 $bans_export = $_POST['bans_export'];
	}

	if (isset($_POST['amxadmins_view'])) {
	 $amxadmins_view = $_POST['amxadmins_view'];
	}

	if (isset($_POST['amxadmins_edit'])) {
	 $amxadmins_edit = $_POST['amxadmins_edit'];
	}

	if (isset($_POST['webadmins_view'])) {
	 $webadmins_view = $_POST['webadmins_view'];
	}

	if (isset($_POST['webadmins_edit'])) {
	 $webadmins_edit = $_POST['webadmins_edit'];
	}

	if (isset($_POST['permissions_edit'])) {
	 $permissions_edit = $_POST['permissions_edit'];
	}

	if (isset($_POST['prune_db'])) {
	 $prune_db = $_POST['prune_db'];
	}

	if (isset($_POST['servers_edit'])) {
	 $servers_edit = $_POST['servers_edit'];
	}

	if (isset($_POST['ip_view'])) {
	 $ip_view = $_POST['ip_view'];
	}

} else {
	if (isset($_POST['uid'])) {
	 $uid = $_POST['uid'];
	} else if ( isset($_SESSION['uid']) ){
	 $uid = $_SESSION['uid'];
	}

	if (isset($_POST['pwd'])) {
	 $pwd = $_POST['pwd'];
	} else if ( isset($_SESSION['pwd']) ) {
	 $pwd = $_SESSION['pwd'];
	}

	if (isset($_POST['uip'])) {
	 $uip = $_POST['uip'];
	} else if ( isset($_SESSION['uip']) ) {
	 $uip = $_SESSION['uip'];
	}

	if (isset($_POST['lvl'])) {
	 $lvl = $_POST['lvl'];
	} else if ( isset($_SESSION['lvl']) ){
	 $lvl = $_SESSION['lvl'];
	}

	if (isset($_POST['bans_add'])) {
	 $bans_add = $_POST['bans_add'];
	} else if ( isset($_SESSION['bans_add']) ){
	 $bans_add = $_SESSION['bans_add'];
	}

	if (isset($_POST['bans_edit'])) {
	 $bans_edit = $_POST['bans_edit'];
	} else if ( isset($_SESSION['bans_edit']) ){
	 $bans_edit = $_SESSION['bans_edit'];
	}

	if (isset($_POST['bans_delete'])) {
	 $bans_delete = $_POST['bans_delete'];
	} else if ( isset($_SESSION['bans_delete']) ){
	 $bans_delete = $_SESSION['bans_delete'];
	}

	if (isset($_POST['bans_unban'])) {
	 $bans_unban = $_POST['bans_unban'];
	} else if ( isset($_SESSION['bans_unban']) ){
	 $bans_unban = $_SESSION['bans_unban'];
	}

	if (isset($_POST['bans_import'])) {
	 $bans_import = $_POST['bans_import'];
	} else if ( isset($_SESSION['bans_import']) ){
	 $bans_import = $_SESSION['bans_import'];
	}

	if (isset($_POST['bans_export'])) {
	 $bans_export = $_POST['bans_export'];
	} else if ( isset($_SESSION['bans_export']) ){
	 $bans_export = $_SESSION['bans_export'];
	}

	if (isset($_POST['amxadmins_view'])) {
	 $amxadmins_view = $_POST['amxadmins_view'];
	} else if ( isset($_SESSION['amxadmins_view']) ){
	 $amxadmins_view = $_SESSION['amxadmins_view'];
	}

	if (isset($_POST['amxadmins_edit'])) {
	 $amxadmins_edit = $_POST['amxadmins_edit'];
	} else if ( isset($_SESSION['amxadmins_edit']) ){
	 $amxadmins_edit = $_SESSION['amxadmins_edit'];
	}

	if (isset($_POST['webadmins_view'])) {
	 $webadmins_view = $_POST['webadmins_view'];
	} else if ( isset($_SESSION['webadmins_view']) ){
	 $webadmins_view = $_SESSION['webadmins_view'];
	}

	if (isset($_POST['webadmins_edit'])) {
	 $webadmins_edit = $_POST['webadmins_edit'];
	} else if ( isset($_SESSION['webadmins_edit']) ){
	 $webadmins_edit = $_SESSION['webadmins_edit'];
	}

	if (isset($_POST['permissions_edit'])) {
	 $permissions_edit = $_POST['permissions_edit'];
	} else if ( isset($_SESSION['permissions_edit']) ){
	 $permissions_edit = $_SESSION['permissions_edit'];
	}

	if (isset($_POST['prune_db'])) {
	 $prune_db = $_POST['prune_db'];
	} else if ( isset($_SESSION['prune_db']) ){
	 $prune_db = $_SESSION['prune_db'];
	}

	if (isset($_POST['servers_edit'])) {
	 $servers_edit = $_POST['servers_edit'];
	} else if ( isset($_SESSION['servers_edit']) ){
	 $servers_edit = $_SESSION['servers_edit'];
	}

	if (isset($_POST['ip_view'])) {
	 $ip_view = $_POST['ip_view'];
	} else if ( isset($_SESSION['ip_view']) ){
	 $ip_view = $_SESSION['ip_view'];
	}
}

if(!isset($uid)) {

	$urlparams = GetUrlParams();

	/////////////////////////////////////////////////////////////////
	//	Template parsing
	/////////////////////////////////////////////////////////////////

	$title			= "Login";

	$smarty = new dynamicPage;

	$smarty->assign("meta","");
	$smarty->assign("title",$title);
	$smarty->assign("dir",$config->document_root);
	$smarty->assign("this",$_SERVER['PHP_SELF']);
	//$smarty->display('main_header.tpl');
	$smarty->display('login.tpl');
	//$smarty->display('main_footer.tpl');

	exit;
}

if ( !isset( $uip) )
{
	$uip = "";
}
$_SESSION['uid'] = $uid;
$_SESSION['pwd'] = $pwd;
$_SESSION['uip'] = $uip;

$_SESSION['uid'] = secure($_SESSION['uid']);
$_SESSION['pwd'] = secure($_SESSION['pwd']);

if(isset($_COOKIE["amxbans"])) {
	$sql = "SELECT * FROM $config->webadmins WHERE username = '$uid' AND password = '$pwd'";
} else {
	$sql = "SELECT * FROM $config->webadmins WHERE username = '$uid' AND password = md5('$pwd')";
}

$result		= mysql_query($sql);

if (!$result) {
	echo "A database error occurred while checking your login details.";
	exit;
}

if (mysql_num_rows($result) == 0) {
	unset($_SESSION['uid']);
	unset($_SESSION['pwd']);
	unset($_SESSION['uip']);
	unset($_SESSION['lvl']);
	unset($_SESSION['bans_add']);
	unset($_SESSION['bans_edit']);
	unset($_SESSION['bans_delete']);
	unset($_SESSION['bans_unban']);
	unset($_SESSION['bans_import']);
	unset($_SESSION['bans_export']);
	unset($_SESSION['amxadmins_view']);
	unset($_SESSION['amxadmins_edit']);
	unset($_SESSION['webadmins_view']);
	unset($_SESSION['webadmins_edit']);
	unset($_SESSION['permissions_edit']);
	unset($_SESSION['prune_db']);
	unset($_SESSION['servers_edit']);
	unset($_SESSION['ip_view']);

	echo "Your username or password is incorrect, or you are not an admin.";

	$now = date("U");
	$add_log	= mysql_query("INSERT INTO $config->logs VALUES ('', '$now', '".$_SERVER['REMOTE_ADDR']."', 'unknown', 'admin logins', '$uid failed to login')") or die (mysql_error());

	exit;
}

while ($my_admin		= mysql_fetch_array($result)) {
	$lvl			= isset($my_admin['level']) ? $my_admin['level'] : "";
	$userid			= isset($my_admin['user_id']) ? $my_admin['user_id'] : "";
	$bans_add		= CheckAbility("bans_add", $lvl);
	$bans_edit		= CheckAbility("bans_edit", $lvl);
	$bans_delete		= CheckAbility("bans_delete", $lvl);
	$bans_unban		= CheckAbility("bans_unban", $lvl);
	$bans_import		= CheckAbility("bans_import", $lvl);
	$bans_export		= CheckAbility("bans_export", $lvl);
	$amxadmins_view		= CheckAbility("amxadmins_view", $lvl);
	$amxadmins_edit		= CheckAbility("amxadmins_edit", $lvl);
	$webadmins_view		= CheckAbility("webadmins_view", $lvl);
	$webadmins_edit		= CheckAbility("webadmins_edit", $lvl);
	$permissions_edit	= CheckAbility("permissions_edit", $lvl);
	$prune_db		= CheckAbility("prune_db", $lvl);
	$servers_edit		= CheckAbility("servers_edit", $lvl);
	$ip_view		= CheckAbility("ip_view", $lvl);

	if(isset($_POST['remember']) && $_POST['remember'] == "on") {
		$logcode	= md5(GenerateString(8));
		$res		= mysql_query("UPDATE $config->webadmins SET logcode = '$logcode' WHERE username = '$uid'");
		$pwdhash	= md5($pwd);
		$cookiestring	= $uid.":".$pwdhash.":".$lvl.":".$uip.":".$logcode.":".$bans_add.":".$bans_edit.":".$bans_delete.":".$bans_unban.":".$bans_import.":".$bans_export.":".$amxadmins_view.":".$amxadmins_edit.":".$webadmins_view.":".$webadmins_edit.":".$permissions_edit.":".$prune_db.":".$servers_edit.":".$ip_view;

		setcookie("amxbans", $cookiestring, time()+60*60*24*7, "$config->document_root/", $_SERVER['SERVER_NAME']);
	}
}

$_SESSION['lvl'] = $lvl;
$_SESSION['userid'] = $userid;
$_SESSION['bans_add'] = $bans_add;
$_SESSION['bans_edit'] = $bans_edit;
$_SESSION['bans_delete'] = $bans_delete;
$_SESSION['bans_unban'] = $bans_unban;
$_SESSION['bans_import'] = $bans_import;
$_SESSION['bans_export'] = $bans_export;
$_SESSION['amxadmins_view'] = $amxadmins_view;
$_SESSION['amxadmins_edit'] = $amxadmins_edit;
$_SESSION['webadmins_view'] = $webadmins_view;
$_SESSION['webadmins_edit'] = $webadmins_edit;
$_SESSION['permissions_edit'] = $permissions_edit;
$_SESSION['prune_db'] = $prune_db;
$_SESSION['servers_edit'] = $servers_edit;
$_SESSION['ip_view'] = $ip_view;

?>
