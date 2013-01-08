<?php
$name = 'x for translate';
$order = 200;
$tags = 'tag options, options, translation';

$description = <<<'EOD'
If the translator option is a valid callback this tag option will run the tags content throu it.
EOD;

$code = <<<'EOD'
/*
 * A translation Array
 */
$lang = array('Hello World!' => 'Hallo Welt!');

/**
 * Checks if the passed content has a translation entry in $lang
 * and returns it.
 *
 * @param string $content the text that should be translated.
 * @param string $domain  identifier of the project/script (used in __ from Wordpress)
 * @return string the translation if found or the passed content.
 */
$translator = function ($content, $domain) use ($lang) {
	if (isset($lang[$content])) {
		return $lang[$content];
	}

	return $content;
};

/*
 * Tell HTML to use our translator function.
 */
$HTML->setOption('translator', $translator);

/*
 * Use the tag option to run the content through our translator.
 */
$HTML->x_p('Hello World!');
EOD;

$prediction = <<<'EOD'
<p>Hallo Welt!</p>

EOD;
