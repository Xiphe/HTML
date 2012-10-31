<?php
$name = 'First Attributes';
$order = 50;
$tags = 'attribute, single, first';

$description = <<<'EOD'
The Default First Attribute is **class** but specific tags do have other firsts with more sence.

%s
EOD;

$singles = array();
foreach (Xiphe\HTML\core\TagInfo::$singleAttrkeys as $k => $v) {
	$singles[$v][] = $k;
}
$singleList = '';
foreach ($singles as $val => $t) {
	$singleList .= "\n+ **".implode(', ', $t).'**: '.$val;
}
$description = sprintf($description, $singleList);

$code = <<<'EOD'
$HTML->a('link', 'http://www.example.org/');
EOD;

$prediction = <<<'EOD'
<a href="http://www.example.org/">link</a>

EOD;
?>