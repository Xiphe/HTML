<?php
$name = 'Default Attributes';
$order = 60;
$tags = 'attribute, default';

$description = <<<'EOD'
Some Tags have default attributes with values. They can be overwritten.

%s
EOD;

$defaultList = '';
foreach (Xiphe\HTML\core\TagInfo::$defaultAttributes as $tag => $attrs) {
    $attrstring = '';
    foreach ($attrs as $key => $value) {
        $attrstring .= $key.'="'.$value.'" ';
    }
    $defaultList .= "\n+ **".$tag.'**: '.trim($attrstring);
}
$description = sprintf($description, $defaultList);

$code = <<<'EOD'
$HTML->link('../style.css');
EOD;

$prediction = <<<'EOD'
<link href="../style.css" media="all" rel="stylesheet" type="text/css" />

EOD;
