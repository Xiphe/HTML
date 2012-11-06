<?php
$name = 'The checkbox() method';
$order = 50;
$tags = 'specialtag, script';

$description = <<<'EOD'
The script() method will automaticly switch between embeded or extern scripts.
EOD;

$code = <<<'PHP'
$HTML->checkbox('foo', 'Be cool?', true);
$HTML->checkbox('bar', 'or not?');
PHP;

$prediction = <<<'HTML'
<label for="foo">Be cool?</label>
<input checked id="foo" name="foo" type="checkbox" />
<label for="bar">or not?</label>
<input id="bar" name="bar" type="checkbox" />

HTML;
