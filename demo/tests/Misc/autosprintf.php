<?php
$name = 'auto sprintf';
$order = 20;
$tags = 'sprintf, args, tag, content';

$description = <<<'EOD'
If you pass more than two arguments to a tag generation, HTML will try to
sprintf them into the content string.
This does not work on [special tags](#specialtags), [starting tags](#tagoptions_sforstart)
and [self-closing tags](#tags_self-closingtags).
EOD;

$code = <<<'EOD'
$var = 'World';
$HTML->p('Hello %s', '.foo', $var);
EOD;

$prediction = <<<'EOD'
<p class="foo">Hello World</p>

EOD;
