<?php
$name = 'The if() and endif() methods';
$order = 100;
$tags = 'specialtag, if, endif';

$description = <<<'EOD'
See Example
EOD;

$code = <<<'PHP'
$HTML->if('lt IE 7')
	->p('Hello Old IE.')
->endif();
PHP;

$prediction = <<<'HTML'
<!--[if lt IE 7]>
	<p>Hello Old IE.</p>
<![endif]-->

HTML;
