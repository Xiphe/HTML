<?php
$name = 'Pseudo Tags';
$order = 10;
$tags = 'specialtag, pseudo';

$description = <<<'EOD'
There are some non-HTML-tags provided as shortcut to a specific tag/attr combo in cooperation with
[Default Attributes](#defaultattributes)  
*.zerowrap is a class i use for stacking elements on top of each other, while css position still is relative or static*
Here are examples:
EOD;


$code = <<<'EOD'
$HTML->comment('foo bar');
$HTML->s_div('.wrap')->blank('Lorem Ipsum')->end('.wrap');
$HTML->hidden('login');
$HTML->pw('password', false);
$HTML->zw();
$HTML->favicon('./icon.ico');
$HTML->clear();
$HTML->dclear();
$HTML->utf8();
$HTML->jquery();
$HTML->jqueryui();
$HTML->rederect('5; URL\=http://www.example.org');
$HTML->viewport();
$HTML->appleIcon('./icon.png');
$HTML->action('actionname');
$HTML->description('Lorem Ipsum');
EOD;

$prediction = <<<'EOD'
<!-- foo bar -->
<div class="wrap">
	Lorem Ipsum
</div><!-- .wrap -->
<input id="action" name="action" type="hidden" value="login" />
<input id="password" name="password" type="password" />
<div class="zerowrap"></div>
<link href="http://www.example.org/icon.ico" rel="shortcut icon" type="image/ico" />
<br class="clear" />
<div class="clear"></div>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js" type="text/javascript"></script>
<meta content="5; URL=http://www.example.org" http-equiv="refresh" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<link href="http://www.example.org/icon.png" rel="apple-touch-icon" />
<input id="action" name="action" type="hidden" value="actionname" />
<meta content="Lorem Ipsum" name="description" />

EOD;
?>