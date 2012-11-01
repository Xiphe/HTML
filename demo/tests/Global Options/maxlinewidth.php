<?php
$name = 'maxLineWidth';
$order = 20;
$tags = 'global, settings, line width, clean';

$description = <<<'EOD'
**This is a verry advanced setting - normaly you do not need to change it.**

The maximal width of a line of code when [strong cleaning](#globaloptions_cleanmode) is activated.

**Type:** *integer*
**Default:** 140
EOD;

$code = <<<'EOD'
$HTML->setOption('cleanMode', 'strong');

$lorem = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.';

$HTML->c_p($lorem);
$HTML->setOption('maxLineWidth', 40);
$HTML->c_p($lorem);
EOD;

$prediction = <<<'EOD'
<p>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
	Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
	ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
</p>
<p>
	Lorem ipsum dolor sit amet, consectetuer adipiscing
	elit. Aenean commodo ligula eget dolor. Aenean
	massa. Cum sociis natoque penatibus et magnis dis
	parturient montes, nascetur ridiculus mus. Donec
	quam felis, ultricies nec, pellentesque eu, pretium
	quis, sem.
</p>

EOD;
