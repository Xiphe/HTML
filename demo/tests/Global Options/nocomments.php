<?php
$name = 'noComments';
$order = 20;
$tags = 'global, settings, comments, disable';

$description = <<<'EOD'
Set to true to skip comment tags.

**Type:** *boolean*  
**Default:** false
EOD;

$code = <<<'EOD'
for ($i=0; $i < 2; $i++) {
	if ($i === 1) {
		/* Disabling Comments on the second run */
		$HTML->set_option('noComments', true)->n();
	}

	$HTML->s_div('#foo')
		->span('LOREM')
	->end();
	$HTML->comment('This is a comment');
}
EOD;

$prediction = <<<'EOD'
<div id="foo">
	<span>LOREM</span>
</div><!-- #foo -->
<!-- This is a comment -->

<div id="foo">
	<span>LOREM</span>
</div>

EOD;
?>