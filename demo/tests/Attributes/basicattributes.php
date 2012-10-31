<?php
$name = 'Basic attributes';
$order = 10;
$tags = 'attribute, basic';

$description = <<<'EOD'
Attributes are passed as a the second parameter - or for starting and self-closing tags as the first and only.  
name and value are separated by an equality sign. (can be escaped)  
The Default Attribute is **class**, see [First Attributes](#firstattributes) for exceptions.
EOD;

$code = <<<'EOD'
$HTML->div('this is a div with a class', 'foo');
$HTML->br('bar');
$HTML->nav('...', 'role=access');
$HTML->a('link', 'href=http://www.example.org?get\=param'); //escaped
EOD;

$prediction = <<<'EOD'
<div class="foo">this is a div with a class</div>
<br class="bar" />
<nav role="access">...</nav>
<a href="http://www.example.org?get=param">link</a>

EOD;
?>