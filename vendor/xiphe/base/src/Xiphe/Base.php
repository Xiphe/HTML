<?php
namespace Xiphe;

/**
 * Basic logic for new projects.
 *
 * Provides singleton, configuration, callback and basic api methods.
 *
 * @category inherit
 * @package  Xiphe\Base
 * @author   Hannes 'Xiphe' Diercks <info@xiphe.net>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/Base
 */
class Base {

    const DS = DIRECTORY_SEPARATOR;

    /* ------------------ *
     *  STATIC VARIABLES  *
     * ------------------ */

    /**
     * The api response which is serialized and printed on Base::exit().
     *
     * @var array
     */
    private static $_baseR = array(
        'status' => 'error',
        'msg' => 'nothing happened.',
        'errorCode' => -1
    );

    /**
     * Collection of all singletons
     *
     * @var array
     */
    private static $_baseInstances = array();

    /**
     * All Callback functions are stored here.
     *
     * @var array
     */
    private static $_baseRealCallbacks = array();


    /* -------------------- *
     *  INSTANCE VARIABLES  *
     * -------------------- */

    /**
     * The configuration.
     *
     * @var stdClass
     */
    protected $_configuration;

    /**
     * The presets
     *
     * @var stdClass|array
     */
    protected $_defaultConfiguration = array();

    /**
     * The arguments given through initiation
     *
     * @var  array
     */
    protected $_initArgs = array();

    /**
     * Collection of callbacks for this instance.
     *
     * @var array
     */
    protected $_callbacks = array();


    /* -------------------- *
     *  INITIATION METHODS  *
     * -------------------- */

    /**
     * The construction
     *
     * @return object
     */
    public function __construct($initArgs = array())
    {
        /*
         * Singleton Logic.
         */
        $class = get_class($this);
        if (!empty($this->_singleton)) {
            if (empty(self::$_baseInstances[$class])) {
                self::$_baseInstances[$class] = $this;
            } else {
                throw new \Exception(sprintf('Multiple constructions of Singleton "%s"', $class), 1);
            }
        }

        /*
         * Initiation
         */
        $this->_configuration = new \stdClass;
        $this->_name = str_replace('\\', '_', strtolower($class));

        $this->_initArgs = func_get_args();
        if (count($this->_initArgs) === 1) {
            $this->_initArgs = $this->_initArgs[0];
        }
        call_user_func_array(array($this, 'init'), (array) $this->_initArgs);
    }

    /**
     * Direct static constructor and singleton getter.
     *
     * @return object
     */
    public static function i()
    {
        $class = get_called_class();
        $initArgs = func_get_args();
        if (count($initArgs) === 1) {
            $initArgs = $initArgs[0];
        }

        if (!empty(self::$_baseInstances[$class])) {
            $inst = self::$_baseInstances[$class];
            if (!empty($initArgs)) {
                $inst->initConfig($initArgs);
            }

            return $inst;
        }

        return new $class($initArgs);
    }

    /**
     * Destroy a potential singleton instance of the called class.
     * 
     * @return null
     */
    public static function destroySingleton()
    {
        $class = get_called_class();
        if (!empty(self::$_baseInstances[$class])) {
            unset(self::$_baseInstances[$class]);
        }
    }

    /**
     * Fall-back for classes that does not need the init function
     *
     * @access public
     * @return void
     */
    public function init()
    {
        $this->initConfig($this->_initArgs);
        return null;
    }


    /* --------------- *
     *  CONFIGURATION  *
     * --------------- */

    /**
     * Initiate class configuration
     *
     * @param mixed $config a filename or array/object of config values
     *
     * @return object
     */
    public function initConfig($config)
    {  
        if (is_string($config)) {
            if (file_exists(($configFile = $config)) ||
                file_exists(($configFile = dirname(dirname(__FILE__)).self::DS.$config))
            ) {
                $config = $this->loadConfig($configFile);
            }
        } elseif (!is_array($config) && !is_object($config)) {
            throw new \Exception("Invalid configuration.", 1);
        }

        $this->mergeConfig($config);

        $this->doCallback('configurationInitiated', array($this->_configuration, $this));

        return $this;
    }

    /**
     * Merge new data into the current defaults and configuration
     *
     * @param mixed $new new data for configuration
     *
     * @return object
     */
    public function mergeConfig($new = array())
    {
        $config = (object) array_merge(
            (array) $this->_defaultConfiguration,
            (array) $this->_configuration,
            (array) $new
        );

        foreach ($config as $key => $value) {
            $this->setConfig($key, $value);
        }

        return $this;
    }


    /**
     * Loads the configuration from a json or php file
     *
     * @param string $file the full path to the configuration file
     *
     * @return object
     */
    public function loadConfig($file)
    {
        $config;

        switch (pathinfo($file, PATHINFO_EXTENSION)) {
        case 'json':
            $config = json_decode(file_get_contents($file));
            break;
        case 'php':
            $config = include $file;
            break;
        default:
            return $this;
        }

        $this->doCallback('configurationLoaded', array($config, $this));
        
        return $config;
    }

    /**
     * Getter for the configuration.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getConfig($key)
    {
        if (isset($this->_configuration->$key)) {
            return $this->_configuration->$key;
        }
    }

    /**
     * Setter for the configuration
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return  object
     */
    public function setConfig($key, $value)
    {
        $this->_configuration->$key = $value;

        return $this;
    }

    /**
     * Unsetter for the configuration
     *
     * @param string $key
     *
     * @return  object
     */
    public function unsetConfig($key)
    {
        unset($this->_configuration->$key);

        return $this;
    }


    /* ------------------------ *
     *  CALLBACK FUNCTIONALITY  *
     * ------------------------ */

    /**
     * Generates unique hashes for callback functions
     *
     * @param mixed $callback
     *
     * @return sting
     */
    public function getCallbackKey($callback)
    {
        if (is_array($callback)) {
            if (is_object($callback[0])) {
                $callback[0] = spl_object_hash($callback[0]);
            }
        } elseif ((function(){} instanceof $callback)) {
            $callback = spl_object_hash($callback);
        }

        return md5(serialize($callback));
    }

    /**
     * Executes callbacks for a hook
     *
     * @param string $name
     * @param array  $values
     *
     * @return object
     */
    public function doCallback($name, array $values = array(), $getResult = false)
    {
        $values = array_merge(
            $values,
            array($name, $this)
        );

        if ($getResult) {
            $result = $values[0];
        }

        /*
         * Hook into Wordpress if wanted.
         */
        if ($this->getConfig('hookIntoWordpress') && class_exists('\WP')) {
            $result = call_user_func_array(
                ($getResult ? 'apply_filters' : 'do_action'),
                array_merge(
                    (array) sprintf('%s_%s', $this->_name, strtolower($name)),
                    $values
                )
            );
        }

        /*
         * Do own callbacks.
         */
        if (!empty($this->_callbacks[$name])) {
            foreach ($this->_callbacks[$name] as $prio => $callbacks) {
                foreach ($callbacks as $callbackKey) {
                    if (!empty(self::$_baseRealCallbacks[$callbackKey])) {
                        if ($getResult) {
                            $values[0] = $result;
                        }
                        $result = call_user_func_array(self::$_baseRealCallbacks[$callbackKey], $values);
                    }
                }
            }
        }

        return ($getResult ? $result : $this);
    }

    /**
     * Adds a callback listener
     *
     * @param string    $name     the hook name
     * @param function  $callback
     * @param integer   $prio     higher means later
     *
     * return object
     */
    public function addCallback($name, $callback, $prio = 10)
    {
        if (!is_callable($callback)) {
            throw new \Exception("Callback not callable.", 3);
            return false;
        }
        $key = $this->getCallbackKey($callback);
        if (!isset(self::$_baseRealCallbacks[$key])) {
            self::$_baseRealCallbacks[$key] = $callback;
        }

        $this->_callbacks[$name][$prio][] = $key;
        ksort($this->_callbacks[$name]);

        return $this;
    }

    /**
     * Removes the callback from the specific hook at the specific priority
     *
     * @param string    $name     the hook name
     * @param function  $callback
     * @param integer   $prio
     *
     * @return object
     */
    public function removeCallback($name, $callback, $prio = 10)
    {
        $key = $this->getCallbackKey($callback);

        if (in_array($key, $this->_callbacks[$name][$prio])) {
            while(false !== $k = array_search($key, $this->_callbacks[$name][$prio])) {
                unset($this->_callbacks[$name][$prio][$k]);
            }
            if (empty($this->_callbacks[$name][$prio])) {
                unset($this->_callbacks[$name][$prio]);
            }
            if (empty($this->_callbacks[$name])) {
                unset($this->_callbacks[$name]);
            }
        }

        return $this;       
    }

    /**
     * Globally disables the passed function from being called by any hook.
     *
     * @param mixed $callback
     *
     * @return object
     */
    public function killCallback($callback)
    {
        $key = $this->getCallbackKey($callback);

        self::$_baseRealCallbacks[$key] = false;

        return $this;
    }

    /**
     * Globally enables the passed function to receive callback calls.
     * 
     * Happens automatically when using addCallback().
     * Use this to re enable callbacks disabled by detachCallbackFunction()
     *
     * @param mixed $callback
     *
     * @return object
     */
    public function reanimateCallback($callback)
    {
        $key = $this->getCallbackKey($callback);

        self::$_baseRealCallbacks[$key] = $callback;

        return $this;
    }


    /* ------------------- *
     *  API FUNCTIONALITY  *
     * ------------------- */

    /**
     * Killer function stops the script and echoes the serialized response
     *
     * @access public
     * @param  string $status    short string describing the status (error|ok|...)
     * @param  string $msg       longer description of the status, error msg etc.
     * @param  int    $errorCode unique number for the error.
     * @return void
     */
    public function _exit($status = null, $msg = null, $errorCode = null)
    {
        foreach (array('status', 'msg', 'errorCode') as $k) {
            if ($$k !== null) {
                self::$_baseR[$k] = $$k;
            }
        }
        
        echo serialize(self::$_baseR);
        exit;
    }


    /**
     * Setter for the response array.
     *
     * @param string $key
     * @param mixed $value
     * @return void.
     */
    public function set_r($key, $value)
    {
        self::$_baseR[$key] = $value;
        return $this;
    }

    /**
     * Getter for the response array.
     *
     * @param string $key
     * @return void.
     */
    public function get_r($key)
    {
        return self::$_baseR[$key];
    }

    /**
     * Unsetter for the response array.
     *
     * @param string $key
     * @return void.
     */
    public function unset_r($key)
    {
        unset(self::$_baseR[$key]);
        return $this;
    }
}