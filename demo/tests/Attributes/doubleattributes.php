<?php
$name = 'Double Attributes';
$order = 80;
$tags = 'attribute, double';

$description = <<<'EOD'
Some Tags will copy an attribute if the other is not given to prevent W3C errors and enhance semantic.

%s
EOD;

$list = '';
foreach (Xiphe\HTML\core\TagInfo::$doublAattrs as $n => $a) {
	if (isset($a['%callback'])) {
		unset($a['%callback']);
	}
	$list .= "\n+ **$n**: ".implode(', ', $a);
}
$description = sprintf($description, $list);

$code = <<<'EOD'
$HTML->img('./picture.jpg');
$HTML->img('\./picture.jpg');
EOD;

$prediction = <<<'EOD'
<img alt="picture.jpg" src="http://www.example.org/picture.jpg" />
<img alt="picture.jpg" src="./picture.jpg" />

EOD;
?>