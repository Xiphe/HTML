<?php
$name = 'g for generate';
$order = 50;
$tags = 'tag options, options, generate';

$description = <<<'EOD'
Bypasses the [Special Tags](#specialtags)
EOD;

$code = <<<'EOD'
$HTML->g_select('foo', array('class' => 'bar')); // standard
$HTML->n();
$HTML->select('foo', array('class' => 'bar')); // special behaviour
EOD;

$prediction = <<<'EOD'
<select class="bar">foo</select>

<label for="foo">Foo</label>
<select id="foo" name="foo">
	<option value="class">bar</option>
</select><!-- #foo -->

EOD;
?>