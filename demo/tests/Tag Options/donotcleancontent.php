<?php
$name = 'n for do NOT clean content';
$order = 120;
$tags = 'tag options, options, tag, dont clean';

$description = <<<'EOD'
If the [clean Setting](#cleanmode) is set to true. This tag option negatiates it.
EOD;

$code = <<<'EOD'
$markup = '<div class="foo"><div class="bar">Lorem!</dvi></div>';
$CleaningHTML = new Xiphe\HTML(array(
	'tabs' => 0,
	'clean' => true,
	'cleanMode' => 'strong'
));
$CleaningHTML->f_div($markup, '#wrap'); // no cleaning.

$HTML->n();

$CleaningHTML->n_div($markup, '#wrap'); // basic cleaning (default)

EOD;

$prediction = <<<'EOD'
<div id="wrap">
	<div class="foo">
		<div class="bar">Lorem!</div>
	</div><!-- .foo -->
</div><!-- #wrap -->

<div id="wrap"><div class="foo"><div class="bar">Lorem!</dvi></div></div>

EOD;
?>