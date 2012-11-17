<?php
/**
 * Modules class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Modules.php
 */

namespace Xiphe\HTML\core;

/**
 * Modules class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Modules
{
    /**
     * Array of Loaded Modules
     *
     * @var array
     */
    private static $_loadedModules = array();

    /**
     * Array of Tag names that don't have a module.
     *
     * @var array
     */
    private static $_unavailableModules = array();

    /**
     * If a module can be called by multiple names the alternatives
     * are here.
     *
     * @var array
     */
    public static $moduleAliases = array(
        'end' => 'close',
        'n' => 'symbols',
        'r' => 'symbols',
        't' => 'symbols',
        'style' => 'css',
        'js' => 'script',
        'jquery' => 'script',
        'jqueryui' => 'script',
        'xhtml' => 'openinghtml',
        'html5' => 'openinghtml',
        'textarea' => 'input',
        'checkbox' => 'input',
        'radio' => 'input',
        'pw' => 'input',
        'ol' => 'ul'
    );

    /**
     * Checks if the called name is a module alias.
     *
     * @param string &$moduleName the called name
     *
     * @return void
     */
    public static function appendAlias(&$moduleName)
    {
        if (isset(self::$moduleAliases[$moduleName])) {
            $moduleName = self::$moduleAliases[$moduleName];
        }
    }

    /**
     * Loads and executes modules
     *
     * @param string $name     the module name
     * @param array  &$args    passed arguments
     * @param array  &$options passed module options
     * @param string $called   original call name (alias)
     *
     * @return void
     */
    public static function execute($name, &$args, &$options, $called)
    {
        $moduleClass = 'Xiphe\HTML\modules\\'.ucfirst($name);

        if (is_object(self::$_loadedModules[$name])) {
            self::$_loadedModules[$name]->execute($args, $options, $called);
        } else {
            $Module = new $moduleClass();
            $Module->execute($args, $options, $called);
        }
    }

    /**
     * Returns a freshly initiated module.
     *
     * @param string $name     the module name
     * @param array  &$args    passed arguments
     * @param array  &$options passed module options
     * @param string &$called  original call name (alias)
     *
     * @return object
     */
    public static function get($name, &$args, &$options, &$called)
    {
        $moduleClass = 'Xiphe\HTML\modules\\'.ucfirst($name);

        if (!isset(self::$_loadedModules[$name])) {
            self::$_loadedModules[$name] = new $moduleClass();
            self::$_loadedModules[$name]->name = $name;
        }

        self::$_loadedModules[$name]->init($args, $options, $called);
        return self::$_loadedModules[$name];
    }

    /**
     * Getter for the absolute module base path.
     *
     * @return string
     */
    public static function getModulePath()
    {
        if (!defined('XIPHE_HTML_ROOT_FOLDER')) {
            define('XIPHE_HTML_ROOT_FOLDER', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
        }

        return XIPHE_HTML_ROOT_FOLDER.'modules'.DIRECTORY_SEPARATOR;
    }

    /**
     * Checks if the Module was loaded before or if the module file exists
     *
     * @param string $name the module name
     * 
     * @return boolean
     */
    public static function exist($name)
    {
        /*
         * If it was checked before negatively - direct return.
         */
        if (in_array($name, self::$_unavailableModules)) {
            return false;
        }

        /*
         * Check if it was already loaded.
         */
        if (isset(self::$_loadedModules[$name])) {
            return true;
        }

        /*
         * Or the file exists.
         */
        if (file_exists(self::getModulePath().$name.'.php')) {
            return true;
        } else {
            self::$_unavailableModules[] = $name;
        }

        /*
         * Module does not exist.
         */

        return false;
    }
}
