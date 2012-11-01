<?php
$name = 'A label for inputs etc.';
$order = 20;
$tags = 'specialtag, label, input';

$description = <<<'EOD'
When generating a input, textfield or select tag, a label can be added as second/third parameter.

Per default the label will be named after the id of the input,
**false** will return no label, a **string** will be the inner content of the label.
An array or string can contain following options:

+ **inner**: the inner content
+ **pos**: after|**before**
+ **sep**: a string to put between label and input (def: "")
+ **glue**: "true" or "false". True to give the seperator a new line. ("true" is default if no seperator is set. "false" if not)
EOD;


$code = <<<'EOD'
$HTML->input('username');
$HTML->n(); // empty line

$HTML->input('foo', false);
$HTML->n();

$HTML->pw('password', 'Insert Password:');
$HTML->n();

$HTML->input('foo', 'sep=:|inner=Hello Foo');
$HTML->n();

$HTML->textarea(
    'Inner Content',
    'textarea',
    array(
        'inner' => 'This is a lable',
        'pos' => 'after',
        'sep' => $HTML->ri_span('/'),
        'glue' => false
    )
);
EOD;

$prediction = <<<'EOD'
<label for="username">Username</label>
<input id="username" name="username" type="text" />

<input id="foo" name="foo" type="text" />

<label for="password">Insert Password:</label>
<input id="password" name="password" type="password" />

<label for="foo">Hello Foo</label>:<input id="foo" name="foo" type="text" />

<textarea id="textarea" name="textarea">Inner Content</textarea>
<span>/</span>
<label for="textarea">This is a lable</label>

EOD;
