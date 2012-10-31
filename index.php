<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


	require_once('_html.php');

	global $HTML;
	$HTML = new Xiphe\HTML(array(
		'debug' => 'Exception',
		'baseUrl' => 'http://example.org',
		'cleanMode' => 'strong'
	));

$HTML->m_blank('# h1 
**strong** _em_');
?>