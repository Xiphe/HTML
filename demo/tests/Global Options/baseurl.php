<?php
$name = 'baseUrl';
$order = 20;
$tags = 'global, settings, url, magic url';

$description = <<<'EOD'
The Base Url is used by the [Magic Url replacement](#attributes_magicurl) to replace any href or src
attributes starting with a ./.

**Type:** *string*
**Default:** "./"
EOD;

$code = <<<'EOD'
$HTML->setOption('baseUrl', "http://www.example.org");

$HTML->img('./img/example.jpg');
$HTML->a('Link', './subpage.html');

$HTML->unsetOption('baseUrl'); // Default.
$HTML->img('./img/example.jpg');
EOD;

$prediction = <<<'EOD'
<img alt="example.jpg" src="http://www.example.org/img/example.jpg" />
<a href="http://www.example.org/subpage.html">Link</a>
<img alt="example.jpg" src="./img/example.jpg" />

EOD;
