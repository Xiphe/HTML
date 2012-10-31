<?php

namespace Xiphe\HTML\core;

class Store {
	/**
	 * All Tags are stored here as long as they have not been closed.
	 * 
	 * @var array
	 */
	private static $_tagStore = array();

	/**
	 * Current internal Tag ID.
	 *
	 * @var intager.
	 */
	private static $cID = 1;

	/**
	 * Gets a new unique Tag id.
	 * 
	 * @return integer
	 */
	public static function get_newID()
	{
		return self::$cID++;
	}

	public static function get_all()
	{
		return self::$_tagStore;
	}
	
	public static function add(Tag &$Tag)
	{
		if (Config::get('store') == 'global') {
			self::$_tagStore[$Tag->ID] = &$Tag;
		} elseif(Config::get('store') == 'internal') {
			Config::get_CurrentHTMLInstance()->tagStore[$Tag->ID] = &$Tag;
		}
	}

	public static function get($ID)
	{
		if ($ID === 'last') {
			if (Config::get('store') == 'global') {
				return end(self::$_tagStore);
			} elseif(Config::get('store') == 'internal') {
				return end(Config::get_CurrentHTMLInstance()->tagStore);
			}
		} elseif(is_int($ID)) {
			if (Config::get('store') == 'global' && isset(self::$_tagStore[$ID])) {
				return self::$_tagStore[$ID];
			} elseif(Config::get('store') == 'internal'
			 && isset(Config::get_CurrentHTMLInstance()->tagStore[$ID])) {
				return Config::get_CurrentHTMLInstance()->tagStore[$ID];
			}
		}
		return false;
	}

	public static function remove(Tag &$Tag)
	{
		if (Config::get('store') == 'global' && isset(self::$_tagStore[$Tag->ID])) {
			unset(self::$_tagStore[$Tag->ID]);
		} elseif(Config::get('store') == 'internal'
		 && isset(Config::get_CurrentHTMLInstance()->tagStore[$Tag->ID])) {
			unset(Config::get_CurrentHTMLInstance()->tagStore[$Tag->ID]);
		}
	}

	public static function hasTags()
	{
		if (Config::get('store') == 'global') {
			return count(self::$_tagStore);
		} elseif(Config::get('store') == 'internal') {
			return count(Config::get_CurrentHTMLInstance()->tagStore);
		}
	}
}
?>