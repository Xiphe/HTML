<?php
/**
 * Initiation file for !HTML
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */

/*
Plugin Name: HTML
Plugin URI: https://github.com/Xiphe/HTML
Description: PHP-based HTML Markup generator
Version: 2.0.0
Date: 2013-01-02 13:00:00 +01:00
Author: Hannes Diercks <info@xiphe.net>
License: http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
Author URI: https://github.com/Xiphe/
Update Server: http://plugins.red-thorn.de/v2/api/
*/

namespace Xiphe;

/*
 * In development i use one central symlinked version of this plugin.
 * Whenever something seems to be wrong i always uncomment this line
 * to check if i use the latest version or if the link was broken
 * through a sync process.
 */
// die('!HTML SYMLINKED');

/*
 * Register as updatable wordpress plugin (requires https://github.com/XIPHE/THEMASTER)
 */
$GLOBALS['Xiphe\THEMASTER\Updatable'][] = __FILE__;

/*
 * Register wordpress settings (requires https://github.com/XIPHE/THEMASTER)
 */
$GLOBALS['Xiphe\THEMASTER\Settings'][] = array(
    'file' => __FILE__,
    'name' => '!HTML',
    'settings' => array(
        'Xiphe\HTML\core\Config',
        'getThemasterSettings'
    )
);

/*
 * Set internal constants.
 */
define('XIPHE_HTML_ROOT_FOLDER', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('XIPHE_HTML_LIB_FOLDER', XIPHE_HTML_ROOT_FOLDER.'lib'.DIRECTORY_SEPARATOR);
define('XIPHE_HTML_TEXTID', basename(dirname(__FILE__)).'/'.basename(__FILE__));

/*
 * Include functions in the core namespace.
 */
include_once 'corefunctions.php';

/*
 * Register autoloading.
 */
spl_autoload_register(
    function ($class) {
        if (strpos($class, 'Xiphe\HTML\\') === 0) {
            $path = explode('\\', $class);
            $name = end($path);
            $path = array_splice($path, 2, -1);
            $path[] = $name.'.php';
            $path = implode(DIRECTORY_SEPARATOR, $path);

            include XIPHE_HTML_ROOT_FOLDER.$path;
            if ($class == 'Xiphe\HTML\core\Config') {
                HTML\core\Config::init();
            }
        } elseif ($class === 'Xiphe\HTML') {
            include dirname(__FILE__).DIRECTORY_SEPARATOR.'HTML.php';
        }
    }
);

/*
 * Set the HTML global variable and define the availability constant.
 */
if (!defined('HTMLCLASSAVAILABLE')) {
    $GLOBALS['HTML'] = new HTML();
    define('HTMLCLASSAVAILABLE', true);
}

/*
 * Register cleaning hooks for wordpress if wanted and wp is available.
 */
if (class_exists('\WP') && HTML\core\Config::get('cleanwpoutput')) {
    $startCleaning = function () {
         ob_start();
    };
    $clean = function () {
        HTML\core\Cleaner::clean(ob_get_clean());
    };
    add_action('wp_head', $startCleaning, 0, 0);
    add_action('Xiphe\wp_head_end', $clean, 99, 0);
}