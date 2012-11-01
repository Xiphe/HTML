<?php
$name = 's for start';
$order = 10;
$tags = 'tag options, options, start';

$description = <<<'EOD'
This starts a tag that can contain content and registers it to be ended when
[The end() Method](#theend) is called.
This will also register an identifyer of the tag (the **#id** or first **.class**) to be added as a comment
when the tag is closed.
EOD;

$code = <<<'EOD'
$HTML->s_div('#foo')->end();
EOD;

$prediction = <<<'EOD'
<div id="foo">
</div><!-- #foo -->

EOD;
