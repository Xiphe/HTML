<?php
/**
 * Store class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Store.php
 */

namespace Xiphe\HTML\core;

/**
 * Store class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Store
{
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
    private static $_cID = 1;

    /**
     * Gets a new unique Tag id.
     *
     * @return integer
     */
    public static function getNewID()
    {
        return self::$_cID++;
    }

    /**
     * returns the whole tag store.
     *
     * @return array
     */
    public static function getAll()
    {
        return self::$_tagStore;
    }

    /**
     * Pass a opened tag to the store
     *
     * Checks if configuration is set to internal and puts the tag
     * into HTML calls if true
     *
     * @param Tag &$Tag the Tag to be stored.
     *
     * @return void
     */
    public static function add(Tag &$Tag)
    {
        if (Config::get('store') == 'global') {
            self::$_tagStore[$Tag->ID] = &$Tag;
        } elseif (Config::get('store') == 'internal') {
            Config::getHTMLInstance()->tagStore[$Tag->ID] = &$Tag;
        }
    }

    /**
     * Gets a Tag from store.
     *
     * Checks if configuration is set to internal
     *
     * @param mixed $ID Tag ID or 'last' for the last stored tag.
     *
     * @return Tag
     */
    public static function get($ID)
    {
        if ($ID === 'last') {
            if (Config::get('store') == 'global') {
                return end(self::$_tagStore);
            } elseif (Config::get('store') == 'internal') {
                return end(Config::getHTMLInstance()->tagStore);
            }
        } elseif (is_int($ID)) {
            if (Config::get('store') == 'global' && isset(self::$_tagStore[$ID])) {
                return self::$_tagStore[$ID];
            } elseif (Config::get('store') == 'internal'
                && isset(Config::getHTMLInstance()->tagStore[$ID])
            ) {
                return Config::getHTMLInstance()->tagStore[$ID];
            }
        }

        return false;
    }

    /**
     * Removes the passed tag from tag store.
     *
     * @param Tag &$Tag the tag to be removed
     *
     * @return void
     */
    public static function remove(Tag &$Tag)
    {
        if (Config::get('store') == 'global' && isset(self::$_tagStore[$Tag->ID])) {
            unset(self::$_tagStore[$Tag->ID]);
        } elseif (Config::get('store') == 'internal'
            && isset(Config::getHTMLInstance()->tagStore[$Tag->ID])
        ) {
            unset(Config::getHTMLInstance()->tagStore[$Tag->ID]);
        }
    }

    /**
     * Checks if some Tags are stored.
     *
     * @return boolean
     */
    public static function hasTags()
    {
        if (Config::get('store') == 'global') {
            return count(self::$_tagStore);
        } elseif (Config::get('store') == 'internal') {
            return count(Config::getHTMLInstance()->tagStore);
        }
    }
}
