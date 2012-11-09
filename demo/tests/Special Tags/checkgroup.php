<?php
$name = 'The checkgroup() method';
$order = 70;
$tags = 'specialtag, checkbox, checkgroup';

$description = <<<'EOD'
This will parse the given content to fit into the tabbed markup but will not add
any tags to it.
EOD;

$code = <<<'PHP'
$HTML->checkgroup(
	array(
		'myID1' => 'Hello Mister',
		'anotherId' => 'Foo',
		'whatsoever' => 'inner=Bar|sep=\=|pos=after',
		'mooh' => 'Cow makes'
	),
	array(
		'anotherId',
		4
	)
);
PHP;

$prediction = <<<'HTML'
<label for="myID1">Hello Mister</label>
<input id="myID1" name="myID1" type="checkbox" />
<label for="anotherId">Foo</label>
<input checked id="anotherId" name="anotherId" type="checkbox" />
<input id="whatsoever" name="whatsoever" type="checkbox" />=<label for="whatsoever">Bar</label>
<label for="mooh">Cow makes</label>
<input checked id="mooh" name="mooh" type="checkbox" />

HTML;
