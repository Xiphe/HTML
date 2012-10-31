<?php
$name = 'm for markdowm';
$order = 60;
$tags = 'tag options, options, markdown';

$description = <<<'EOD'
Parses [markdown](http://daringfireball.net/projects/markdown/)-syntax in the tags content.
EOD;

$code = <<<'EOD'
$HTML->m_blank('# h1 
**strong** _em_');
EOD;

$prediction = <<<'EOD'
<h1>h1</h1>
<p><strong>strong</strong> <em>em</em></p>

EOD;
?>