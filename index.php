<?php
/**
 * Overview file displays the contents of readme.md
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */

include 'bootstap.php';
global $HTML;
$HTML->setOption('cleanMode', 'strong');
$HTML->HTML5()
	->title('HTML - THE CLEAN CODE APPROACH')
	->viewport()
	->favicon('favicon.ico')
	->css('http://fonts.googleapis.com/css?family\=Uncial+Antiqua')
	->p_css('
		body {
		    font-family: "Gill Sans", "Gill Sans MT", Calibri, sans-serif;
		}
		h1, h2, h3, h4, h5, h6 {
		    font-family: \'Uncial Antiqua\', cursive;
		    text-transform: uppercase;
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
    ', 'media=screen')
->end('head')
->s_body()
	->cm_div(file_get_contents('readme.md'), '#wrap')
->end('all');
exit;