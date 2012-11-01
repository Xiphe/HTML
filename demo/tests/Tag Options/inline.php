<?php
$name = 'i for inline';
$order = 40;
$tags = 'tag options, options, inline';

$description = <<<'EOD'
Generates a tag without tabs and breaks.
EOD;

$code = <<<'EOD'
$HTML->addTabs(5); // Pretend we are deeply nested.

$string = 'This is '.$HTML->ri_span('what', '.foo').' you want.';
print_r($string);
$HTML->n()->n();

$string = 'This '.$HTML->r_span('looks', '.bar').' strange.';
print_r($string);
EOD;

$prediction = <<<'EOD'
This is <span class="foo">what</span> you want.

This 					<span class="bar">looks</span>
 strange.
EOD;
