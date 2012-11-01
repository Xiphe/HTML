<?php
$name = 'break';
$order = 20;
$tags = 'global, settings, break';

$description = <<<'EOD'
The default symbol to end a line.

**Type:** *string*
**Default:** "\n"
EOD;

$code = <<<'EOD'
$HTML->setOption('break', ""); // No breaks (usefull for minimal output and ajax results.)

$HTML->div('Lorem', '.foo');
$HTML->div('Ipsum', '.bar');
EOD;

$prediction = <<<'EOD'
<div class="foo">Lorem</div><div class="bar">Ipsum</div>
EOD;
