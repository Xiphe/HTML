<?php
$name = 'The if() method';
$order = 100;
$tags = 'specialtag, if';

$description = <<<'EOD'
HTML conditions. Comments are disabled inside conditions
EOD;

$code = <<<'PHP'
$HTML->s_div('#wrap')
	->if('lt IE 7')
		->s_p('.foo')
			->a('A Link', '#')
			->comment('deactivated')
->end('#wrap');
PHP;

$prediction = <<<'HTML'
<div id="wrap">
	<!--[if lt IE 7]>
		<p class="foo">
			<a href="#">A Link</a>
		</p>
	<![endif]-->
</div><!-- #wrap -->

HTML;
