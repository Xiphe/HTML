<?php
$name = 'textdomain';
$order = 210;
$tags = 'global, settings, translation, textdomain';

$description = <<<'EOD'
Sets the textdomain passed as second argument to the translator.

**Type:** *string*
**Default:** "html"
EOD;

$code = <<<'EOD'
/* __ function has been defined in the previous example */
$HTML->setOption('textdomain', 'myPlugin');
$HTML->x_p('Translate this.');
EOD;

$prediction = <<<'EOD'
array(2) {
  [0]=>
  string(15) "Translate this."
  [1]=>
  string(8) "myPlugin"
}
<p>Translate this.</p>

EOD;
