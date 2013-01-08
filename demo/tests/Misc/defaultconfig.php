<?php
$name = 'default config';
$order = 10;
$tags = 'settings, default';

$description = <<<'EOD'
Here are the default settings from Xiphe\HTML\core\config.
EOD;

$code = <<<'EOD'
var_dump(Xiphe\HTML\core\Config::getDefaults());
EOD;

$prediction = <<<'EOD'
array(17) {
  ["baseUrl"]=>
  string(2) "./"
  ["noComments"]=>
  bool(false)
  ["magicUrl"]=>
  bool(true)
  ["disable"]=>
  bool(false)
  ["cleanwpoutput"]=>
  bool(true)
  ["translator"]=>
  string(2) "__"
  ["textdomain"]=>
  string(4) "html"
  ["tabs"]=>
  int(0)
  ["tab"]=>
  string(1) "	"
  ["break"]=>
  string(1) "
"
  ["debug"]=>
  string(8) "disabled"
  ["store"]=>
  string(6) "global"
  ["tabWorth"]=>
  int(4)
  ["maxLineWidth"]=>
  int(140)
  ["minLineWidth"]=>
  int(50)
  ["clean"]=>
  bool(false)
  ["cleanMode"]=>
  string(5) "basic"
}

EOD;
