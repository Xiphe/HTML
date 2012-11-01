<?php
$name = 'f for forbid inline inner';
$order = 48;
$tags = 'tag options, options, tag, forbid inline inner, inline, inner';

$description = <<<'EOD'
This option puts the tags content always into a new line.
EOD;

$code = <<<'EOD'
$HTML->div('Foo');
$HTML->f_div('Bar');

EOD;

$prediction = <<<'EOD'
<div>Foo</div>
<div>
	Bar
</div>

EOD;
