<?php
$name = 'debug';
$order = 20;
$tags = 'global, settings, disbale';

$description = <<<'EOD'
If and how debuging should be handled.

**false** skips every debug attempt
**'Exception'** throws an Exception,
**'THEDEBUG'** will try to use THEDEBUG from [!THE MASTER](https://github.com/Xiphe/THEMASTER)

**Type:** *string/boolean*
**Default:** false
EOD;

$code = <<<'EOD'
$HTML->setOption('debug', 'Exception');
try {
    $HTML->t_b_div('Lorem', '.foo');
} catch (\Exception $e) {
    echo $e->getMessage();
}
EOD;

$prediction = <<<'EOD'
Invalid format in HTML Call "t_b_div"
EOD;
