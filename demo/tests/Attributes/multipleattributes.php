<?php
$name = 'Multiple Attributes';
$order = 20;
$tags = 'attribute, multiple';

$description = <<<'EOD'
If you need more than one attribute on one tag, they can be separated by an pipe char "|" (can be escaped, too).
EOD;

$code = <<<'EOD'
$HTML->div('this is a div with a class and an id', 'class=foo|id=bar');
$HTML->a('lorem', 'href=http://www.example.org/?foo\=bar|target=_blank');
EOD;

$prediction = <<<'EOD'
<div class="foo" id="bar">this is a div with a class and an id</div>
<a href="http://www.example.org/?foo=bar" target="_blank">lorem</a>

EOD;
