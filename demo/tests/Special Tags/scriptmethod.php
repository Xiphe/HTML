<?php
$name = 'The script() method';
$order = 50;
$tags = 'specialtag, script';

$description = <<<'EOD'
The script() method will automaticly switch between embeded or extern scripts.
EOD;

$code = <<<'PHP'
$HTML->script('./script.js');
$HTML->script('jQuery(document).ready(function($){ alert("hi"); });');
PHP;

$prediction = <<<'HTML'
<script src="http://www.example.org/script.js" type="text/javascript"></script>
<script type="text/javascript">jQuery(document).ready(function($){ alert("hi"); });</script>

HTML;
