<?php
$name = 'Initiate';
$order = 30;
$tags = 'require, global, class';

$description = <<<'EOD'
Include the **Classfile** [_html.php](//github.com/Xiphe/HTML/blob/master/_html.php) and a global instance will be created using the settings
from core/config.php (If it does not exist you have to run _html.php one time so a config-sample.php will be generated. You then can rename it to config.php and make your settings).
EOD;

$code = <<<'EOD'
require_once '../_html.php';
global $HTML;
print_r($HTML);
EOD;

$prediction = <<<'EOD'
Xiphe\HTML Object
(
    [tagStore] => Array
        (
        )

    [_ID:Xiphe\HTML:private] => 1
)

EOD;
