<?php

function lang($lang) {
	global $config;
	if (!isset($_SESSION['lang']))
	{
		$_SESSION['lang'] = $config->default_lang;
	}
	$language = $_SESSION['lang'];
	if(isset($language) && is_file("$config->path_root/include/lang/lang.$language.php")){
	$path=$config->path_root . '/include/lang/lang.' . $language . '.php';
	}else{
	$path=$config->path_root . '/include/lang/lang.' . $config->default_lang . '.php';
	}
	$lp = fopen($path,'r'); $temp = fread($lp, filesize($path)); fclose($lp); 

	if ($lp) {
	$s_lang = explode("\n",$temp); $int=sizeof($s_lang); 
	for ($i=1;$i<$int-1;$i++) {
  	$s_lang[$i] = str_replace ("\n","",$s_lang[$i]);  
			
	$test = explode("\"",$s_lang[$i]);
	if($lang == $test[1]){$ret = $test[3];}
		}	
	}
	return $ret;
}

?>