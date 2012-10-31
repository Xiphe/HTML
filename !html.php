<?php
/*
Plugin Name: !HTML
Plugin URI: http://plugins.red-thorn.de/libary/!html/
Description: A Plugin to provide global access to the HTML class
Version: 1.4.9
Date: 2012-10-31
Author: Hannes Diercks
Author URI: http://red-thorn.de/
Update Server: http://plugins.red-thorn.de/api/
*/
// die( '!HTML SYMLINKED' );

define( 'THEUPDATES_UPDATABLE_HTML', __FILE__ );

if( !defined( 'HTMLCLASSAVAILABLE' ) ) {
	require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'html.php' );
	$GLOBALS[ 'HTML' ] = new HTML();
}
?>