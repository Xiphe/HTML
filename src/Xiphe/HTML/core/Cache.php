<?php
/**
 * Cache class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Cleaner.php
 */

namespace Xiphe\HTML\core;

use Xiphe\THETOOLS;

/**
 * Cache class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Cache
{
	private static $_initiated = false;

	private static $_folder = false;

	private static $_cache = array();

	public static function init()
	{
		if (!self::$_initiated) {
			self::$_initiated = true;

			register_shutdown_function(array('Xiphe\HTML\core\Cache', 'shutdown'));

			/*
			 * Get and normalize the cache dir from config.
			 */
			$baseDir = Config::get('cacheDir', true);
			$baseDir = preg_replace('/[\/\\\\]/', DIRECTORY_SEPARATOR, $baseDir);
			$baseDir = trim($baseDir, DIRECTORY_SEPARATOR);

			$dir = realpath(XIPHE_HTML_BASE_FOLDER.$baseDir);
			if (false !== $dir && is_writable($dir)) {
				self::$_folder = $dir.DIRECTORY_SEPARATOR;
			} else {
				$dir = realpath($baseDir);
				if (false !== $dir && is_writable($dir)) {
					self::$_folder = $dir.DIRECTORY_SEPARATOR;
				} else {
					self::$_folder = false;
				}
			}
		}
	}

	private static function _getDir()
	{
		self::init();
		return self::$_folder;
	} 

	public static function get($hash)
	{
		if (false !== self::_getDir()) {
			$key = substr($hash, 0, 2);
			$hash = substr($hash, 2);

			self::load($key);

			if (isset(self::$_cache[$key][$hash])) {
				self::$_cache[$key][$hash]['t'] = time();
				return self::$_cache[$key][$hash]['c'];
			}
		}	
		return false;
	}

	public static function load($key)
	{
		if (false !== $cd = self::_getDir()) {
			if (!isset(self::$_cache[$key]) && file_exists($cd.$key)) {
				self::$_cache[$key] = unserialize(file_get_contents($cd.$key));
			} elseif(!isset(self::$_cache[$key])) {
				self::$_cache[$key] = false;
			}
		}	
	}


	public static function set($hash, $content)
	{	
		if (false !== self::_getDir()) {
			$key = substr($hash, 0, 2);
			$hash = substr($hash, 2);

			if (empty(self::$_cache[$key])) {
				self::$_cache[$key] = array();
			} else {
				$inspect = true;
			}

			self::$_cache[$key][$hash] = array(
				'c' => $content,
				't' => time()
			);
		}
	}

	public static function shutdown()
	{	
		if (false !== $cd = self::_getDir()) {
			foreach (self::$_cache as $key => $data) {
				if ($data !== false) {
					file_put_contents($cd.$key, serialize($data));
				}
			}
		}
	}
}