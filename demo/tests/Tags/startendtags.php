<?php
$name = 'Starting and ending Tags';
$order = 40;
$tags = 'tag, basic, start, end';

$description = <<<'EOD'
You can start Tags without inner-content whith the [prefix](#tagoptions) **s_**.
And you can end this Tag with the method [$HTML->end()](#tags_theendmethod).
EOD;

$code = <<<'EOD'
$HTML->s_div()->p('this is wrapped')->end();
EOD;

$prediction = <<<'EOD'
<div>
	<p>this is wrapped</p>
</div>

EOD;
