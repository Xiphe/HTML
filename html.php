<?php

namespace Xiphe;
use Xiphe\HTML\core as Core;

class HTML {

	public $tagStore = array();
	private $ID;

	private static $_cID = 0;

	public static function get($initArgs = array())
	{
		if (get_class(Core\Config::get_CurrentHTMLInstance()) == 'Xiphe\HTML') {
			return Core\Config::get_CurrentHTMLInstance();
		} elseif (get_class($GLOBALS['HTML']) == 'Xiphe\HTML') {
			return $GLOBALS['HTML'];
		} else {
			return new HTML($initArgs);
		}
	}

	public function get_ID()
	{
		return $this->ID;
	}

	public function get_option($key)
	{
		if (Core\Config::is_validOptionName($key)) {
			if (isset($this->$key)) {
				return $this->$key;
			} else {
				return Core\Config::get($key, true);
			}
		}
	}

	public function set_option($key, $value)
	{
		if (Core\Config::is_validOptionName($key)) {
			$this->$key = $value;
		}

		return $this;
	}

	public function unset_option($key)
	{
		if (Core\Config::is_validOptionName($key) && isset($this->$key)) {
			unset($this->$key);
		}

		return $this;
	}

	public function unset_instanceOptions()
	{
		foreach (Core\Config::get_defaults() as $k => $v) {
			if (isset($this->$k)) {
				unset($this->$k);
			}
		}
	}

	public function add_tabs($i = 1)
	{
		Core\Config::set_HTMLInstance($this);
		Core\Config::set('tabs', (Core\Config::get('tabs') + $i));
	}

	public function __construct($initArgs = array())
	{
		$this->ID = self::$_cID++;

		if (!empty($initArgs) && is_string($initArgs)) {
			$initArgs = array(
				'baseUrl' => $initArgs
			);
		}
		foreach (Core\Config::get_defaults() as $k => $v) {
			if (isset($initArgs[$k])) {
				$this->$k = $initArgs[$k];
			}
		}
	}

	public function escape($str)
	{
		return preg_replace('/[=|]/', '\$1', $str);
	}

	public function __call($name, $arguments)
	{
		Core\Config::set_HTMLInstance($this);
		$r = Core\Generator::call($name, $arguments);
		if (!empty($r)) {
			return $r;
		}

		return $this;
	}

	public function __clone()
	{
		$this->ID = self::$_cID++;
	}
}
?>