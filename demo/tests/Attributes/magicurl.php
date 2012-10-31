<?php
$name = 'Magic Url';
$order = 70;
$tags = 'attribute, default';

$description = <<<'EOD'
If you specify a Base-Url in the [Global Options](#globaloptions_baseurl),
a "./" to the beginning of the value of a src or href attribute will be replaced by the baseurl.  
*This can be turned off in the Global Options or escaped by "\"*
EOD;

$code = <<<'EOD'
$HTML->a('Link to', './somewhere/');
$HTML->a('Link to', '\./somewhere/'); //escaped
EOD;

$prediction = <<<'EOD'
<a href="http://www.example.org/somewhere/">Link to</a>
<a href="./somewhere/">Link to</a>

EOD;
?>