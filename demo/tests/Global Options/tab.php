<?php
$name = 'tab';
$order = 20;
$tags = 'global, settings, tab';

$description = <<<'EOD'
The Tab setting is the symbol used to indent a new line.

**Type:** *string*
**Default:** "\t"
EOD;

$code = <<<'EOD'
$HTML->setOption('tab', '  '); // Set tab to two spaces.

$HTML->s_div('#foo');
$HTML->div('This is indented with two spaces. (instance Setting)');
$HTML->end();

$HTML->unsetOption('tab')->n();

$HTML->s_div('#bar');
$HTML->div('This is indented with a tab. (global setting)');
$HTML->end();

EOD;

$prediction = <<<'EOD'
<div id="foo">
  <div>This is indented with two spaces. (instance Setting)</div>
</div><!-- #foo -->

<div id="bar">
	<div>This is indented with a tab. (global setting)</div>
</div><!-- #bar -->

EOD;
