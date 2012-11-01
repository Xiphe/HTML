<?php
$name = 'r for return';
$order = 20;
$tags = 'tag options, options, return';

$description = <<<'EOD'
Returns the generated content.
EOD;

$code = <<<'EOD'
$div = $HTML->r_div('foo', 'bar');
echo "Lorem Ipsum\n";
echo $div;
EOD;

$prediction = <<<'EOD'
Lorem Ipsum
<div class="bar">foo</div>

EOD;
