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
Plugin Name: !HTML
Plugin URI: https://github.com/Xiphe/-HTML
Description: A Plugin to provide global access to the HTML class
Version: 2.0.0
Date: 2012-30-10 17:30:00 +02:00
Author: Hannes Diercks
Author URI: https://github.com/Xiphe/
Update Server: http://plugins.red-thorn.de/v2/api/
*/

namespace Xiphe;

// die('!HTML SYMLINKED');

$GLOBALS['Xiphe\THEMASTER\Updatable'][] = __FILE__;
$GLOBALS['Xiphe\THEMASTER\Settings'][] = array('Xiphe\HTML\core\Config', 'get_themaster_settings');
define('XIPHE_HTML_ROOT_FOLDER', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('XIPHE_HTML_LIB_FOLDER', XIPHE_HTML_ROOT_FOLDER.'lib'.DIRECTORY_SEPARATOR);

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

if (!defined('HTMLCLASSAVAILABLE')) {
    $GLOBALS['HTML'] = new HTML();
    define('HTMLCLASSAVAILABLE', true);
}
