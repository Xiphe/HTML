<?php
/**
 * Initiate yourself!
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */

/*
 * Set internal constants.
 */
define('XIPHE_HTML_ROOT_FOLDER', __DIR__.DIRECTORY_SEPARATOR);
define('XIPHE_HTML_BASE_FOLDER', XIPHE_HTML_ROOT_FOLDER.'src'.
    DIRECTORY_SEPARATOR.'Xiphe'.DIRECTORY_SEPARATOR.'HTML'.DIRECTORY_SEPARATOR);

/*
 * Include functions in the core namespace.
 */
include_once XIPHE_HTML_BASE_FOLDER.'corefunctions.php';
include_once XIPHE_HTML_ROOT_FOLDER.'vendor/autoload.php';

/*
 * Set the HTML global variable and define the availability constant.
 */
if (!defined('XIPHE_HTML_AVAILABLE')) {
    $GLOBALS['HTML'] = new Xiphe\HTML();
    define('XIPHE_HTML_AVAILABLE', true);
}