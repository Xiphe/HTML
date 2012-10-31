<?php
$name = 'd for don\'t selfclose';
$order = 100;
$tags = 'tag options, options, don\'t selfclose';

$description = <<<'EOD'
Forces this tag to be not self-closing
EOD;

$code = <<<'EOD'
$Div = $HTML->d_br('?!?' ,'foo=bar');
EOD;

$prediction = <<<'EOD'
<br foo="bar">?!?</br>

EOD;
?>