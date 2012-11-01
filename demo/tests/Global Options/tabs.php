<?php
$name = 'tabs';
$order = 20;
$tags = 'global, settings, tabs, tab';

$description = <<<'EOD'
The Tabs setting is used as counter for the current indention depth.
Setting this as instance setting gains you the option to generate tags
that does not use the global indention counter.
This is especialy usefull for demo applications like this one. (Global tab count for document
and internal for Demo results).

**Type:** *integer*
**Default:** 0
EOD;

$code = <<<'EOD'
$testHtml = new Xiphe\HTML(); // Use Global Tabs
$testHtml2 = new Xiphe\HTML(array(
	'tabs' => 2 // Use internal Tabs
));
$HTML->unsetOption('tabs'); // Use global count
$HTML->div('This is not indented because global count is 0');

$HTML->setOption('tabs', 2); // Use internal Count
$HTML->div('This is indented because internal count is 2.');

$HTML->addTabs(-2); // this is the correct way to add and remove tabs.

$HTML->div('This not indented anymore.');

EOD;

$prediction = <<<'EOD'
<div>This is not indented because global count is 0</div>
		<div>This is indented because internal count is 2.</div>
<div>This not indented anymore.</div>

EOD;
