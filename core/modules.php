<?php

namespace Xiphe\HTML\core;

class Modules {
	/**
	 * The absolute module base path
	 * @var string
	 */
	private static $_modulePath;

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


	public static $_moduleAliases = array(
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


	public static function appendAlias(&$moduleName)
	{
		if (isset(self::$_moduleAliases[$moduleName])) {
			$moduleName = self::$_moduleAliases[$moduleName];
		}
	}

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

	public static function get($name, &$args, &$options, &$called)
	{
		$moduleClass = 'Xiphe\HTML\modules\\'.ucfirst($name);

		if (!isset(self::$_loadedModules[$name])) {
			$Reflection = new \ReflectionClass($moduleClass);
			try {
				$singleton = $Reflection->getStaticPropertyValue('singleton');
			} catch(\ReflectionException $e) {
				$singleton = false;
			}
			if ($singleton) {
				self::$_loadedModules[$name] = new $moduleClass();
				self::$_loadedModules[$name]->name = $name;
			} else {
				self::$_loadedModules[$name] = true;
			}
		}

		if (is_object(self::$_loadedModules[$name])) {
			self::$_loadedModules[$name]->init($args, $options, $called);
			return self::$_loadedModules[$name];
		} else {
			$Module = new $moduleClass();
			$Module->name = $name;
			$Module->init($args, $options, $called);
			return $Module;
		}
	}

	/**
	 * Getter for the absolute module base path.
	 * 
	 * @return string
	 */
	public static function get_modulePath()
	{
		if (!self::$_modulePath) {
			self::$_modulePath = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR;
		}
		return self::$_modulePath;
	}

	/**
	 * Checks if the Module was loaded before or if the module file exists 
	 * 
	 * @param  string  $name the module name
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
		if (file_exists(self::get_modulePath().$name.'.php')) {
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
?>