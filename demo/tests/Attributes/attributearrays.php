<?php
$name = 'Attribute Arrays';
$order = 40;
$tags = 'attribute, array';

$description = <<<'EOD'
Attributes can be passed as an array to improve php readability.
EOD;

$code = <<<'EOD'
$HTML->a('lorem', array(
    'href' => 'http://www.example.org/?foo=bar',
    'target' => '_blank',
    'style' => 'color: green;',
));
EOD;

$prediction = <<<'EOD'
<a href="http://www.example.org/?foo=bar" style="color: green;" target="_blank">lorem</a>

EOD;
