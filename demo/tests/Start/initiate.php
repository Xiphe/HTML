<?php
$name = 'Initiate';
$order = 30;
$tags = 'require, global, class';

$description = <<<'EOD'
Include the **Classfile** [!html.php](#Github) and a global instance will be created using the settings
from [core/config.php](#Github).
EOD;

$code = <<<'EOD'
require_once('../_html.php');
global $HTML;
print_r($HTML);
EOD;

$prediction = <<<'EOD'
Xiphe\HTML Object
(
    [tagStore] => Array
        (
        )

    [ID:Xiphe\HTML:private] => 1
)

EOD;
?>