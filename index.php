<?php
require_once dirname(__FILE__).'/lib/PHPMarkdown/markdown.php';
$rm = file_get_contents(dirname(__FILE__).'/readme.md');
echo Markdown($rm);
exit;