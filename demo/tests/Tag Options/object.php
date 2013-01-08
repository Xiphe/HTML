<?php
$name = 'o for tag object';
$order = 80;
$tags = 'tag options, options, tag, object';

$description = <<<'EOD'
This returns the tag object after its output was made.
EOD;

$code = <<<'EOD'
$Div = $HTML->o_div('Content', 'foo=bar');
print_r($Div->ID);
EOD;

$prediction = <<<'EOD'
<div foo="bar">Content</div>
183
EOD;
