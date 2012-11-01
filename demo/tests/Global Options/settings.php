<?php
$name = 'Set Options';
$order = 10;
$tags = 'global, settings';

$description = <<<'EOD'
There are multiple ways to set the global options.

1. You can rename the config-sample.php in config.php and uncomment and adjust the settings
   to globaly overwrite the defaults.
2. If you use this as a Wordpress plugin along with [!THE MASTER](https://github.com/Xiphe/-THE-MASTER)
   you can change the settings in the plugins tab.
3. When creating a new intance of Xiphe\HTML you can pass an array of settings
   into the creation. Values set there will overwrite the global options just for this instance.
4. An instance of Xiphe\HTML has the methods **get_option()**, **set_option()** and **unset_option()**
   get_option() will return the default option if the key is not set in the instance.
EOD;

$code = <<<'EOD'
$myHTML = new Xiphe\HTML(array(
  'tab' => '  ' // Set tab to two spaces.
));

printf('\'%s\'', $myHTML->getOption('tab'));

$myHTML->unsetOption('tab')->n(); // reset to global.

printf('\'%s\'', $myHTML->getOption('tab'));

EOD;

$prediction = <<<'EOD'
'  '
'	'
EOD;
