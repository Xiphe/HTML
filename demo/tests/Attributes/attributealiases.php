<?php
$name = 'Attribute Aliases';
$order = 30;
$tags = 'attribute, alias';

$description = <<<'EOD'
class(.), id(#), src(?), style(}) and href(%) have aliases to shorten the writing process.
EOD;

$code = <<<'EOD'
$HTML->div('this is a div with a class and an id', '.foo|#bar');
$HTML->a('lorem', '%http://www.example.org/?foo\=bar|target=_blank|}color: green;');
$HTML->img('?http://www.example.org/test.jpg|alt=A test image');
EOD;

$prediction = <<<'EOD'
<div class="foo" id="bar">this is a div with a class and an id</div>
<a href="http://www.example.org/?foo=bar" style="color: green;" target="_blank">lorem</a>
<img alt="A test image" src="http://www.example.org/test.jpg" />

EOD;
?>