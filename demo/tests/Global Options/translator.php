<?php
$name = 'translator';
$order = 200;
$tags = 'global, settings, translation';

$description = <<<'EOD'
Handles the translation for tags called with the [translate tag option](#tagoptions_xfortranslate).
Has to be a valid callback function.

**Type:** *function*
**Default:** "__"
EOD;

$code = <<<'EOD'
/**
 * Think this as the default Wordpress translation method.
 * 
 * @param string $content the text that should be translated.
 * @param string $domain  identifier of the project/script (used in __ from Wordpress)
 * @return string the translation if found or the passed content.           [description]
 */
function __($content, $textdomain) {
	var_dump(func_get_args());
	return $content;
}
$HTML->x_p('Translate this.');
EOD;

$prediction = <<<'EOD'
array(2) {
  [0]=>
  string(15) "Translate this."
  [1]=>
  string(4) "html"
}
<p>Translate this.</p>

EOD;
