<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>HTML - THE CLEAN CODE APPROACH</title>
        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
        <link href='http://fonts.googleapis.com/css?family=Uncial+Antiqua' rel='stylesheet' type='text/css'>
        <style type="text/css">
        	body {
			    font-family: "Gill Sans", "Gill Sans MT", Calibri, sans-serif;
			}
			h1, h2, h3, h4, h5, h6 {
			    font-family: 'Uncial Antiqua', cursive;
			}

			a {
			    color: #011e68;
			}
			a:hover, a:focus, a:active {
			    color: #740505;
			    text-decoration: none;
			}
        	#wrap {
        		width: 95%;
        		max-width: 48em;
        		margin: 0 auto;
        	}
        </style>
    </head>
    <body>
    	<div id="wrap">
	        <?php
	        	require_once dirname(__FILE__).'/lib/PHPMarkdown/markdown.php';
				$rm = file_get_contents(dirname(__FILE__).'/readme.md');
				echo Markdown($rm);
				exit;
			?>
		</div>
    </body>
</html>