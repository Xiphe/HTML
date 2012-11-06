<?php
$name = 'p for comPress';
$order = 100;
$tags = 'tag options, options, compress, css, js';

$description = <<<'EOD'
Removes Comments and unifyes whitespace.
EOD;

$code = <<<'EOD'
$script = '
jQuery(document).ready(function($) {
	alert(\'HELP!\'); // Comments will be stripped.
}
';
$HTML->p_script($script);

$css = '
#foo {
	/* comment */
	margin: 0 auto 20px auto;
	background: black;
}
';
$HTML->n()->p_css($css);
EOD;


$prediction = <<<'EOD'
<script type="text/javascript">jQuery(document).ready(function($){alert('HELP!');}</script>

<style media="all" rel="stylesheet" type="text/css">#foo{margin:0 auto 20px auto;background:black;}</style>

EOD;
