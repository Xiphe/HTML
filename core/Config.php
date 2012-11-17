<?php
/**
 * Config class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Config.php
 */

namespace Xiphe\HTML\core;
use Xiphe\THEMASTER\core as TM;

/**
 * Config class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Config
{

    /**
     * Holds the instance of \Xiphe\HTML that performed the last call.
     * 
     * @var \Xiphe\HTML
     */
    private static $_CurrentHTMLInstance;

    /**
     * The current global configuration.
     * 
     * @var array
     */
    private static $_config = array();

    /**
     * Weather or not this class was initiated.
     * 
     * @var boolean
     */
    private static $_initiated = false;

    /**
     * Backup of global configuration when ajax-mode is activated.
     * 
     * @var array
     */
    private static $_ajaxModeBackup = array();

    /**
     * Settings array for !THE MASTER.
     *
     * Will be generated through initiation.
     *
     * @var array
     */
    private static $_themasterSettings;

    /**
     * The default configuration.
     * 
     * @var array
     */
    private static $_defaults = array();

    /**
     * Turn ajax mode on or off
     * 
     * @var boolean
     */
    private static $_ajaxMode = false;

    /**
     * Overload configuration for ajax mode.
     * 
     * @var array
     */
    private static $_ajaxSettings = array(
        'tabs' => 0,
        'tab' => "",
        'break' => "",
        'noComments' => true
    );

    /**
     * Checks if given name exists in default configuration.
     * 
     * @param string $name check this.
     * 
     * @return boolean
     */
    public static function isValidOptionName($name)
    {
        return isset(self::$_defaults[$name]);
    }

    /**
     * One-time-initiation for this Class.
     *
     * Checks the config.php file and builds the global config.
     * 
     * @param array $initArgs additional configuration
     * 
     * @return void
     */
    public static function init(array $initArgs = array())
    {
        if (!self::$_initiated) {
            if (!defined('XIPHE_HTML_ROOT_FOLDER')) {
                define('XIPHE_HTML_ROOT_FOLDER', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
            }

            require_once XIPHE_HTML_ROOT_FOLDER.'corefunctions.php';

            foreach (self::getThemasterSettings() as $key => $s) {
                if (is_array($s) && isset($s['default'])) {
                    self::$_defaults[$key] = $s['default'];
                }
            }

            /*
             * Get the config array from config.php
             */
            $config = array();
            if (file_exists(XIPHE_HTML_ROOT_FOLDER.'config.php')) {
                call_user_func(
                    function () use (&$config) {
                        include XIPHE_HTML_ROOT_FOLDER.'config.php';
                    }
                );
            } elseif(!file_exists(XIPHE_HTML_ROOT_FOLDER.'config-sample.php')) {
                self::_createSampleConfig();
            }

            /*
             * Make sure config is an array.
             */
            if (!is_array($config)) {
                Generator::debug('$config is not an array.', 3, 7);
                $config = array();
            }

            /*
             * Merge it into the defaults
             */
            $defaults = array_merge(self::$_defaults, $config);

            /*
             * Remove invalid keys and merge the initArgs.
             */
            foreach (self::$_defaults as $k => $v) {
                self::$_config[$k] = (isset($initArgs[$k]) ? $initArgs[$k] : $defaults[$k]);
            }

            self::$_initiated = true;
        }
    }

    /**
     * Returns the default configuration.
     * 
     * @return array
     */
    public static function getDefaults()
    {
        if (!self::$_initiated) {
            self::init();
        }
        return self::$_defaults;
    }

    /**
     * Activates or deactivates the ajax mode.
     * 
     * @param boolean $activate turn it off or on.
     * 
     * @return void
     */
    public static function ajax($activate = true)
    {
        if ($activate) {
            self::$_ajaxMode = true;
        } else {
            self::$_ajaxMode = false;
        }
    }

    /**
     * Getter for the current value for the requested key.
     *
     * Setting hierarchy:
     *  - Ajax setting (if Mode is on)
     *  - Instance setting
     *  - THEWPSETTING (if Xiphe\THEMASTER\core\THEWPSETTINGS exists)
     *  - config.php setting (if exists)
     *  - default.
     *
     * If the requested key is not existent on one layer the next one
     * will be used.
     * 
     * @param string  $key          The name of the setting.
     * @param boolean $preferGlobal Eliminates the instance setting from hierarchy.
     * 
     * @return mixed The setting value.
     */
    public static function get($key, $preferGlobal = false)
    {
        if (!self::$_initiated) {
            self::init();
        }

        if (!isset(self::$_config[$key])) {
            return null;
        }

        if (self::$_ajaxMode === true && isset(self::$_ajaxSettings[$key])) {
            return self::$_ajaxSettings[$key];
        }

        if (!$preferGlobal && self::$_CurrentHTMLInstance && isset(self::$_CurrentHTMLInstance->$key)) {
            return self::$_CurrentHTMLInstance->$key;
        } else {
            if (class_exists('Xiphe\THEMASTER\core\THE')
                && class_exists(TM\THE::WPSETTINGS)
            ) {
                return TM\THEWPSETTINGS::get_setting($key, XIPHE_HTML_TEXTID);
            }
            return self::$_config[$key];
        }
    }

    /**
     * Changes a global configuration.
     * 
     * @param string  $key          the settings name
     * @param mixed   $value        the settings value
     * @param boolean $preferGlobal Eliminates the instance setting from hierarchy.
     *
     * @return boolean weather or not the setting was set.
     */
    public static function set($key, $value, $preferGlobal = false)
    {
        if (!isset(self::$_config[$key])) {
            return false;
        }

        if (!$preferGlobal && self::$_CurrentHTMLInstance && isset(self::$_CurrentHTMLInstance->$key)) {
            self::s3t(self::$_CurrentHTMLInstance->$key, $value);
        } else {
            if (class_exists('Xiphe\THEMASTER\core\THE')
                && class_exists(TM\THE::SETTINGS)
            ) {
                $prev = TM\THEWPSETTINGS::get_setting($key, XIPHE_HTML_TEXTID);
                self::s3t($prev, $value);
                TM\THESETTINGS::sSet_setting($key, XIPHE_HTML_TEXTID, $prev);
            } else {
                self::s3t(self::$_config[$key], $value);
            }
        }

        return true;
    }

    /**
     * Sets the given value to the linked target.
     *
     * Allows '++' and '--' for increment or decrement the numeric target.
     *
     * @param mixed &$target the place were the value should be set to.
     * @param mixed $value   the value.
     *
     * @return void
     */
    public static function s3t(&$target, $value)
    {
        if ($value === '++' && is_numeric(($oldValue = $target))) {
            $value = $oldValue + 1;
        } elseif ($value === '--' && is_numeric(($oldValue = $target))) {
            $value = $oldValue - 1;
        }

        $target = $value;
    }

    /**
     * Sets a instance of \Xiphe\HTML to the static class variable.
     * Thereby indicating that this instance does the last call.
     *
     * @param \Xiphe\HTML &$HTML the last used instance.
     *
     * @return void
     */
    public static function setHTMLInstance(\Xiphe\HTML &$HTML)
    {
        self::$_CurrentHTMLInstance = $HTML;
    }

    /**
     * Retrieves the last used instance of \Xiphe\HTML from static 
     * class variable.
     *
     * @return \Xiphe\HTML
     */
    public static function getHTMLInstance()
    {
        return self::$_CurrentHTMLInstance;
    }

    /**
     * Removes the last used instance of \Xiphe\HTML from static
     * class variable. 
     *
     * @return void
     */
    public static function unsetHTMLInstance()
    {
        self::$_CurrentHTMLInstance = null;
    }

    private static function _createSampleConfig()
    {
        $r = <<<'EOD'
<?php
/**
 * Configuration file.
 *
 * Rename to config.php if you want to use it.
 * If you use this as a Wordpress-plugin together with !THE MASTER
 * config.php will have no affect once you saved the configuration in the plugin screen.
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/HTML.php
 */

namespace Xiphe/HTML;

$config = array(

EOD;

        $template = <<<'EOD'
    /*
     * :title:description
     * Default: :default
     */
    ':name' => :default,


EOD;

        $default = function ($v) {
            switch (gettype($v)) {
            case 'string':
                $v = preg_replace('/\t/', '\t', $v);
                $v = preg_replace('/\r\n|\n|\r/', '\n', $v);
                return '"'.$v.'"';
            case 'integer':
            case 'double':
                return $v;
            case 'boolean':
                return ($v ? 'true' : 'false');
            }
        };

        foreach (self::getThemasterSettings() as $name => $s) {
            if (!is_array($s) || !isset($s['default'])) {
                continue;
            }

            $r .= str_replace(
                array(
                    ':title',
                    ':description',
                    ':default',
                    ':name'
                ),
                array(
                    $s['label'],
                    "\n     *".(isset($s['description']) ? "\n     * ".$s['description'] : ' '),
                    $default($s['default']),
                    $name
                ),
                $template
            );
        }

        $r = rtrim(rtrim($r), ',')."\n);";

        file_put_contents(XIPHE_HTML_ROOT_FOLDER.'config-sample.php', $r);
    }

    public static function getThemasterSettings()
    {
        if (empty(self::$_themasterSettings)) {
            self::$_themasterSettings = array(
                /*'key' => array(
                    'label' => ''
                    'type' => '', // checkbox|dropdown|select|input|textarea
                    'default' => '', // bool|name|array(names)|string
                    'validation' => '', // function|regex OPTIONAL
                    'args' => array() // OPTIONAL
                    'description' => '' // OPTIONAL
                ),*/
                'h3' => __('Basic', 'html'),
                'baseUrl' => array(
                    'label' => __('Base URI', 'html'),
                    'type' => 'input',
                    'default' => './',
                    'description' => __('Used to replace ./ in src & href if MagicURI is enabled.', 'html')
                ),
                'noComments' => array(
                    'label' => __('Disable comments', 'html'),
                    'type' => 'checkbox',
                    'default' => false,
                    'description' => __('No <!-- comments --> will be generated by HTML.', 'html')
                ),
                'magicUrl' => array(
                    'label' => __('Enable MagicURI', 'html'),
                    'type' => 'checkbox',
                    'default' => true,
                    'description' => __('Will replace ./ in src and href attributes by the Base URI', 'html')
                ),
                'disable' => array(
                    'label' => __('Disable HTML', 'html'),
                    'type' => 'checkbox',
                    'default' => false,
                    'description' => __('No generation of HTML Tags.', 'html')
                ),
                'cleanwpoutput' => array(
                    'label' => __('Clean Wordpress output', 'html'),
                    'type' => 'checkbox',
                    'default' => true,
                    'description' => __('Cleans up things like the wp_head.', 'html')
                ),
                'sep',
                'h3.1' => __('Advanced', 'html'),
                'tabs' => array(
                    'label' => __('Starting tabcount', 'html'),
                    'type' => 'input',
                    'default' => 0,
                    'validation' => '[0-9]+',
                    'beforeSave' => function (&$v) {
                        $v = intval($v);
                    },
                    'errorMessage' => __('Only integers are allowed.', 'html'),
                    'description' => __('This is the indention-level the document will start with.', 'html')
                ),
                'tab' => array(
                    'label' => __('Tab-symbol', 'html'),
                    'type' => 'input',
                    'default' => "\t",
                    'beforeDisplay' => function (&$v) {
                        $v = preg_replace('/\t/', '\t', $v);
                        $v = preg_replace('/\r/', '\r', $v);
                        $v = preg_replace('/\n/', '\n', $v);
                        $v = preg_replace('/\r\n/', '\r\n', $v);
                    },
                    'beforeSave' => function (&$v) {
                        $v = preg_replace('/\\\t/', "\t", $v);
                        $v = preg_replace('/\\\r\\\n/', "\r\n", $v);
                        $v = preg_replace('/\\\n/', "\n", $v);
                        $v = preg_replace('/\\\r/', "\r", $v);
                    },
                    'description' => __('The string that is used for indenting new lines.', 'html')
                ),
                'break' => array(
                    'label' => __('Line-break-symbol', 'html'),
                    'type' => 'input',
                    'default' => "\n",
                    'beforeDisplay' => function (&$v) {
                        $v = preg_replace('/\t/', '\t', $v);
                        $v = preg_replace('/\r/', '\r', $v);
                        $v = preg_replace('/\n/', '\n', $v);
                        $v = preg_replace('/\r\n/', '\r\n', $v);
                    },
                    'beforeSave' => function (&$v) {
                        $v = preg_replace('/\\\t/', "\t", $v);
                        $v = preg_replace('/\\\r\\\n/', "\r\n", $v);
                        $v = preg_replace('/\\\n/', "\n", $v);
                        $v = preg_replace('/\\\r/', "\r", $v);
                    },
                    'description' => __('The string that is used to break the current line.', 'html')
                ),
                'debug' => array(
                    'label' => __('Debug', 'html'),
                    'type' => 'dropdown',
                    'default' => 'disabled',
                    'args' => array(
                        'disabled' => __('Disabled', 'html'),
                        'exception' => __('Exception', 'html'),
                        'thedebug' => __('THEDEBUG', 'html'),
                    )
                ),
                'store' => array(
                    'label' => __('Store', 'html'),
                    'type' => 'dropdown',
                    'default' => 'global',
                    'args' => array(
                        'global' => __('Global', 'html'),
                        'internal' => __('Internal', 'html')
                    ),
                    'description' => __('Default storage method for started tags.', 'html')
                ),
                'sep',
                'h3.2' => __('Cleaning', 'html'),
                'tabWorth' => array(
                    'label' => __('Tab-worth', 'html'),
                    'type' => 'input',
                    'default' => 4,
                    'validation' => '[0-9]+',
                    'beforeSave' => function (&$v) {
                        $v = intval($v);
                    },
                    'errorMessage' => __('Only integers are allowed.', 'html'),
                    'description' => __('How much spaces is the worth of the \'tab\' setting.', 'html')
                ),
                'maxLineWidth' => array(
                    'label' => __('Maximal line width', 'html'),
                    'type' => 'input',
                    'default' => 140,
                    'validation' => '[0-9]+',
                    'beforeSave' => function (&$v) {
                        $v = intval($v);
                    },
                    'errorMessage' => __('Only integers are allowed.', 'html'),
                    'description' => __('Maximum count of letters per line. Used by strong cleaning mode.', 'html')
                ),
                'minLineWidth' => array(
                    'label' => __('Maximal line width', 'html'),
                    'type' => 'input',
                    'default' => 50,
                    'validation' => '[0-9]+',
                    'beforeSave' => function (&$v) {
                        $v = intval($v);
                    },
                    'errorMessage' => __('Only integers are allowed.', 'html'),
                    'description' => __('Minimum count of letters per line. Used by strong cleaning mode.', 'html')
                ),
                'clean' => array(
                    'label' => __('Clean', 'html'),
                    'type' => 'checkbox',
                    'default' => false,
                    'description' => __('If true the content of every tag will be cleaned up.', 'html')
                ),
                'cleanMode' => array(
                    'label' => __('Clean-mode', 'html'),
                    'type' => 'dropdown',
                    'default' => 'basic',
                    'args' => array(
                        'basic' => __('Basic', 'html'),
                        'strong' => __('Strong', 'html')
                    ),
                    'description' => __('What kind of cleaning should be used? Strong looks better and takes longer :)', 'html')
                )
            );
        }
        return self::$_themasterSettings;
    }
}
