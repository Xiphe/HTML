<?php
$name = 'disable';
$order = 20;
$tags = 'global, settings, disbale';

$description = <<<'EOD'
Set true to disable tab generation (direct methods will work).

**Type:** *boolean*  
**Default:** false
EOD;

$code = <<<'EOD'
$HTML->div('Lorem', '.foo');
$HTML->set_option('disable', true);
$HTML->div('Ipsum', '.bar');
EOD;

$prediction = <<<'EOD'
<div class="foo">Lorem</div>

EOD;
?>