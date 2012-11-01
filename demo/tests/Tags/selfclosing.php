<?php
$name = 'Self-closing Tags';
$order = 20;
$tags = 'tag, basic, self-closing';

$description = <<<'EOD'
Followeing tags are preregistered as self-closing tags.

* %s
EOD;

$shorttags = array();
foreach (Xiphe\HTML\core\TagInfo::$selfClosing as $k => $v) {
    if ($k >= 0) {
        $shorttags[] = $v;
    }
}
sort($shorttags);
$description = sprintf($description, implode("\n* ", $shorttags));

$code = <<<'EOD'
$HTML->br();
EOD;

$prediction = <<<'EOD'
<br />

EOD;
