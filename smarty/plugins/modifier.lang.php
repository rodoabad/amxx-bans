<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty language modifier plugin
 *
 * Type:     modifier<br>
 * Name:     language<br>
 * Purpose:  Show player country info
 * @param string
 * @return string
 */


function smarty_modifier_lang($lang) {
	global $config;
	$language = $_SESSION['lang'];
	if(isset($language) && is_file($config->path_root."/include/lang/lang.".$language.".php")){
	$path=$config->path_root."/include/lang/lang.".$language.".php";
	}else{
	//$path=$config->path_root."/include/lang/lang.".english.".php";
	$path="$config->path_root/include/lang/lang.".$config->default_lang.".php";
	}
	$lp = fopen($path,"r"); $temp = fread($lp, filesize($path)); fclose($lp); 

	if ($lp)
  	{

	$s_lang = explode("\n",$temp); $int=sizeof($s_lang); 
	for ($i=0;$i<$int;$i++) {
  	$s_lang[$i] = str_replace ("\n","",$s_lang[$i]);  
			
	$test = explode("\"",$s_lang[$i]);
	if($lang == $test[1]){$ret = $test[3];}
	
		}	
	}
	return $ret;
}

?>
