<?php
$name = 'The end() Method';
$order = 50;
$tags = 'tag, basic, end';

$description = <<<'EOD'
As mentioned [above](#startendtags): This method closes tags that have been opened by the **s_**prefix.
If you call it without arguments, it will close the last tag.
If you call it with an integer, it will try to close as many tags,
If you pass an #id or .class all tags including the one with the class or id will be closed.
if you call it with 'all' ...guess what :)
EOD;

$code = <<<'EOD'
$HTML->s_html()->s_head()->title('foo')->end() //Ends the head tag
	 ->s_body()->s_div('#wrap')->s_div()->s_div()->s_div()->p('content') //Stack some divs
	 ->end(2)       //Ends the last two divs
	 ->comment('Closed two tags.')
	 ->end('#wrap') //Ends all tags until the wrap id (.classes are supported, too).
	 ->comment('Closed until #wrap.')
	 ->end('all')  //Ends body and html tag
	 ->comment('Closed the rest.');
EOD;

$prediction = <<<'EOD'
<html>
	<head>
		<title>foo</title>
	</head>
	<body>
		<div id="wrap">
			<div>
				<div>
					<div>
						<p>content</p>
					</div>
				</div>
				<!-- Closed two tags. -->
			</div>
		</div><!-- #wrap -->
		<!-- Closed until #wrap. -->
	</body>
</html>
<!-- Closed the rest. -->

EOD;
