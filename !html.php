<?php
/*
Plugin Name: !HTML
Plugin URI: http://plugins.red-thorn.de/libary/!html/
Description: A Plugin to provide global access to the HTML class
Version: 1.4.7
Date: 2012-01-18
Author: Hannes Diercks
Author URI: http://red-thorn.de/
Update Server: http://plugins.red-thorn.de/api/index.php
*/

define('THEUPDATES_UPDATABLE_HTML', '!html');

if(!defined('HTMLCLASSAVAILABLE')) {
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'html.php');
	$GLOBALS['HTML'] = new HTML();
}
?>