<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty language modifer plugin
 *
 * Type:     modifer<br>
 * Name:     getlanguage<br>
 * Purpose:  returns an language name.
 * @version  1.0
 * @param array
 * @param Smarty
 */
function smarty_modifier_getlanguage()
{
	global $config;
	$langs = array();
	if ($handle = opendir($config->path_root."/include/lang/")) {
	if ($handle) {
	if( $file != "." && $file != ".." )
	{
	while ($file = readdir($handle))
	if ($file != "." && $file != "..")
	{
	$show_lang = explode(".", $file);
	$langs[] = $show_lang[1];
				}
			}
		}
	}
    sort($langs);
    return $langs;
}

?>
