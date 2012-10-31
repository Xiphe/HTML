<?php
$name = 'The ul() and ol() methods';
$order = 40;
$tags = 'specialtag, ol, ul';

$description = <<<'EOD'
As seen in [The select() method](#selectmethod) this methods are accepting an array of lis as a second parameter.
EOD;


$code = <<<'PHP'
$HTML->ul('foo', array(
	'a', 'b', 'c'
));
$HTML->n();

$HTML->ol('bar', array(
	'bar' => 'Lorem',
	'Ipsum',
	'rel=ipsum' => 'Dolor'
));
PHP;

$prediction = <<<'HTML'
<ul class="foo">
	<li>a</li>
	<li>b</li>
	<li>c</li>
</ul><!-- .foo -->

<ol class="bar">
	<li class="bar">Lorem</li>
	<li>Ipsum</li>
	<li rel="ipsum">Dolor</li>
</ol><!-- .bar -->

HTML;
?>