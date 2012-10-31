<?php
$name = 'default config';
$order = 10;
$tags = 'settings, default';

$description = <<<'EOD'
Here are the default settings from Xiphe\HTML\core\config.
EOD;

$code = <<<'EOD'
var_dump(Xiphe\HTML\core\Config::get_defaults());
EOD;

$prediction = <<<'EOD'
array(14) {
  ["baseUrl"]=>
  string(2) "./"
  ["tabs"]=>
  int(0)
  ["tab"]=>
  string(1) "	"
  ["tabWorth"]=>
  int(4)
  ["break"]=>
  string(1) "
"
  ["noComments"]=>
  bool(false)
  ["magicUrl"]=>
  bool(true)
  ["disable"]=>
  bool(false)
  ["maxLineWidth"]=>
  int(140)
  ["minLineWidth"]=>
  int(50)
  ["debug"]=>
  bool(false)
  ["store"]=>
  string(6) "global"
  ["clean"]=>
  bool(false)
  ["cleanMode"]=>
  string(5) "basic"
}

EOD;
?>