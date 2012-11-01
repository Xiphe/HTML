<?php
$name = 'The HTML5() and XHTML() methods';
$order = 70;
$tags = 'specialtag, html';

$description = <<<'EOD'
Two methods to start a new HTML document.

The first parameter can be attributes for the head-tag, the second attributes for the html tag.
if [**THETOOLS**](https://github.com/Xiphe/-THE-MASTER/blob/master/core/tools.php) are availabe,
some additional html classes will be set (browser, css-engine and ie classes).
EOD;

$code = <<<'PHP'
$HTML->HTML5()->end('all');

$HTML->n();

$HTML->XHTML('http://example.org/profile')->end('all');

$HTML->n();

$HTML->HTML5(null, '.myhtmlclass')
	->title('foo')
->end()
->s_body()
	->blank('Hello World!')
->end('all');
PHP;

$prediction = <<<'HTML'
<!DOCTYPE HTML>
<html class="no-js">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
	</head>
</html><!-- .no-js -->

<?xml version="1.0" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html class="no-js" xmlns="http://www.w3.org/1999/xhtml">
	<head profile="http://example.org/profile">
	</head>
</html><!-- .no-js -->

<!DOCTYPE HTML>
<html class="myhtmlclass no-js">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
		<title>foo</title>
	</head>
	<body>
		Hello World!
	</body>
</html><!-- .myhtmlclass -->

HTML;
