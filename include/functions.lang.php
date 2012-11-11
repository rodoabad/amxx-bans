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