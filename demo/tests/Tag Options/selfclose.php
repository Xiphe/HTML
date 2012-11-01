<?php
$name = 'q for selfclose';
$order = 90;
$tags = 'tag options, options, selfclose';

$description = <<<'EOD'
Forces this tag to be self-closing
EOD;

$code = <<<'EOD'
$Div = $HTML->q_div('foo=bar');
EOD;

$prediction = <<<'EOD'
<div foo="bar" />

EOD;
