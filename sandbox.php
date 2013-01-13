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

use Xiphe\HTML\core as H;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'bootstrap.php';

$HTML = new Xiphe\HTML(
    array(
        'debug' => 'Exception',
        'baseUrl' => 'http://example.org',
        'cleanMode' => 'strong',
        'tabs' => 0,
        'tab' => '',
        'break' => '',
        'noComments' => true
        // ,'useCache' => false
    )
);

/* GO PLAY! */
$s_mt = explode(" ",microtime());
// $HTML->HTML5()
// ->end('head');
$HTML->s_body('.eineKlasse')->end()->s_div('test');
// ->p('Lore Ipsum')
// ->close('all');
;
$e_mt = explode(" ",microtime());
echo '<br /><br />Runtime: '.(($e_mt[1] + $e_mt[0]) - ($s_mt[1] + $s_mt[0]))*1000;


// $s_mt = explode(" ",microtime());
// $HTML->s_p('.test')->p('Hallo Welt');
// // var_dump(Xiphe\HTML\core\Store::get('latest'));
// $HTML->end();
// $e_mt = explode(" ",microtime());
// echo '<br /><br />Runtime: '.(($e_mt[1] + $e_mt[0]) - ($s_mt[1] + $s_mt[0]))*1000;
	// ->div('Hallo')
	// ->end('.test)


// $HTML->HTML5()
// 	->title('CacheTest')
// ->end('head')->s_body('.eineKlasse')
// ->h1('Miese Überschrift', '.headline')
// ->p('Lorem Ipsum')
// ->close('all');