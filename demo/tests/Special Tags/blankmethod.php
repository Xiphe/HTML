<?php
$name = 'The blank() method';
$order = 60;
$tags = 'specialtag, blank';

$description = <<<'EOD'
This will parse the given content to fit into the tabbed markup but will not add
any tags to it.
EOD;

$code = <<<'PHP'
$HTML->s_div();
echo 'Not that nice.';
$HTML->end();

$HTML->n();

$HTML->s_div()
	->blank('This is nicely indented text')
->end();
PHP;

$prediction = <<<'HTML'
<div>
Not that nice.</div>

<div>
	This is nicely indented text
</div>

HTML;
