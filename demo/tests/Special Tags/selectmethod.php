<?php
$name = 'The select() method';
$order = 30;
$tags = 'specialtag, select';

$description = <<<'EOD'
The select() method accepts up to four parameters.

1. Attributes for the select tag.
2. Array of options. the value can be a string or a [Tag Object](#tagobject)
3. If this is a string an option with this value/content will be selected. If it is an integer the nth option will be selected.
   It is also possible to pass an array of values for multiple selections.
4. The [label](#speciallabel).
EOD;


$code = <<<'PHP'
$HTML->select('user-role', array(
 	'admin' => 'Administrator',
 	'user' => 'Standard User',
 	'guest' => 'Mr. X',
), 'guest', 'Please choose a role');
$HTML->n();

$HTML->select('foo', array(
 	$HTML->t_option('Hello'),
 	$HTML->t_option('World', 'data-info=bar')
), 1, false);
$HTML->n();

$HTML->select('lorem', array(
 	'Test1',
 	'foo' => 'Test2',
 	'Test3',
 	'Test4'
), array('foo', 'Test4', 1));
PHP;

$prediction = <<<'HTML'
<label for="user-role">Please choose a role</label>
<select id="user-role" name="user-role">
	<option value="admin">Administrator</option>
	<option value="user">Standard User</option>
	<option selected value="guest">Mr. X</option>
</select><!-- #user-role -->

<select id="foo" name="foo">
	<option selected>Hello</option>
	<option data-info="bar">World</option>
</select><!-- #foo -->

<label for="lorem">Lorem</label>
<select id="lorem" multiple name="lorem">
	<option selected>Test1</option>
	<option selected value="foo">Test2</option>
	<option>Test3</option>
	<option selected>Test4</option>
</select><!-- #lorem -->

HTML;
?>