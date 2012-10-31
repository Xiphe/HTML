<?php
$name = 'Own instance';
$order = 40;
$tags = 'instance, class';

$description = <<<'EOD'
You can have multiple other instances of the HTML object containing different settings.  
This is very useful to set the baseUrl setting used by [magic url](#magicurl)
EOD;

$code = <<<'EOD'
$myHTML = new Xiphe\HTML('http://www.example.org');
print_r($myHTML);
EOD;

$prediction = <<<'EOD'
Xiphe\HTML Object
(
    [tagStore] => Array
        (
        )

    [ID:Xiphe\HTML:private] => 5
    [baseUrl] => http://www.example.org
)

EOD;
?>