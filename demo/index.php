<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

include('initdemo.php');

$HTML->s_body('id=tests')->s_div('.content');

$nav = array();

$lastSection = '';

$r = array(
	'error' => 0,
	'failed' => 0,
	'successfull' => 0	
);
$runtime = 0;

foreach ($Tests as $Test) {
	if ($Test->section !== $lastSection) {
		$HTML->h2($Test->section, '.section|#'.preg_replace('/[^a-z0-9]/', '', strtolower($Test->section)));
		$lastSection = $Test->section;
	}
	if (!isset($r[$Test->success])) {
		$r[$Test->success] = 1;
	} else {
		$r[$Test->success]++;
	}
	$runtime += $Test->runtime;
	echo $Test;
}
$HTML->end('.content')->s_nav('.navigation');
$lastSection = false;
foreach ($Tests as $Test) {
	if ($Test->section !== $lastSection) {
		if ($lastSection !== false) {
			$HTML->end();
		}
		$HTML->a($Test->section, '.section|%#'.preg_replace('/[^a-z0-9]/', '', strtolower($Test->section)));
		$HTML->sg_ul();
		$lastSection = $Test->section;
	}

	$HTML->s_li()->a($Test->name, '#'.str_replace('test_', '', $Test->ID))->end();
}
$HTML->end('.navigation')->s_footer('#info');

$HTML->s_p();
	$HTML->a('%d Errors', '%?status\=error', $r['error']);
	$HTML->a('%d Fails', '%?status\=failed', $r['failed']);
	$HTML->a('%d Successfull', '%?status\=successfull', $r['successfull']);
	$HTML->a('All', '\./');
	$HTML->span('%fms runtime', null, $runtime);

$HTML->end('all');
?>