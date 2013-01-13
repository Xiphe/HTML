<?php
/**
 * Sandbox file.
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'bootstrap.php';

$HTML = new Xiphe\HTML(
    array(
        'debug' => 'Exception',
        'baseUrl' => 'http://example.org',
        'cleanMode' => 'strong',
        'tabs' => 0
    )
);

/* GO PLAY! */
$HTML->s_div('.test')
	->div('Hallo')
	->end('.test');


// $HTML->HTML5()
// 	->title('CacheTest')
// ->end('head')->s_body('.eineKlasse')
// ->h1('Miese Überschrift', '.headline')
// ->p('Lorem Ipsum')
// ->close('all');