<?php
$name = 'l for inLine Inner';
$order = 45;
$tags = 'tag options, options, inline inner';

$description = <<<'EOD'
Generates the content without tabs and line breaks.
This is appended to most tags as long as the content has no line breaks and is not
longer as specified in the [global options](#globaloptions)
EOD;

$code = <<<'EOD'
$longString = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.';
$HTML->p($longString);
$HTML->l_p($longString);
EOD;

$prediction = <<<'EOD'
<p>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>

EOD;
?>