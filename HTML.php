<?php
/**
 * HTML class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/HTML.php
 */

namespace Xiphe;
use Xiphe\HTML\core as Core;

/**
 * HTML class
 * 
 * This is the interface for other projects to use HTML.
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class HTML
{
    /**
     * Internal tag storage. requires setting "store" to be "internal"
     *
     * @see core/Config
     * @var array
     */
    public $tagStore = array();

    /**
     * ID of this instance
     * 
     * @var integer
     */
    private $_ID;

    /**
     * Global ID counter.
     * 
     * @var integer
     */
    private static $_cID = 0;

    /**
     * Getter for a HTML instance.
     *
     * Returns the first available instance in this order.
     *  - last used intance
     *  - global instance
     *  - new instance
     *  
     * @param array $initArgs if a new instance is created initiation 
     *    args can be passed here
     * 
     * @return Xiphe\HTML
     */
    public static function get($initArgs = array())
    {
        if (get_class(Core\Config::getHTMLInstance()) == 'Xiphe\HTML') {
            return Core\Config::getHTMLInstance();
        } elseif (get_class($GLOBALS['HTML']) == 'Xiphe\HTML') {
            return $GLOBALS['HTML'];
        } else {
            return new HTML($initArgs);
        }
    }

    /**
     * returns the ID of the instance.
     * 
     * @return integer
     */
    public function getID()
    {
        return $this->_ID;
    }

    /**
     * Request an option value.
     *
     * Returns global option value if instance option is not set.
     * 
     * @param string $key the requested option key
     * 
     * @return mixed       the requested value
     */
    public function getOption($key)
    {
        if (Core\Config::isValidOptionName($key)) {
            if (isset($this->$key)) {
                return $this->$key;
            } else {
                return Core\Config::get($key, true);
            }
        }
    }

    /**
     * Set an option value for this instance
     * 
     * @param string $key   the target option name
     * @param mixed  $value the new option value
     *
     * @return Xiphe\HTML
     */
    public function setOption($key, $value)
    {
        if (Core\Config::isValidOptionName($key)) {
            Core\Config::s3t($this->$key, $value);
        }

        return $this;
    }

    /**
     * Deletes an intance option if set.
     * 
     * @param string $key the target option name
     * 
     * @return Xiphe\HTML
     */
    public function unsetOption($key)
    {
        if (Core\Config::isValidOptionName($key) && isset($this->$key)) {
            unset($this->$key);
        }

        return $this;
    }

    /**
     * Deletes all instance options of this instance.
     * 
     * @return Xiphe\HTML
     */
    public function unsetInstanceOptions()
    {
        foreach (Core\Config::getDefaults() as $k => $v) {
            if (isset($this->$k)) {
                unset($this->$k);
            }
        }

        return $this;
    }

    /**
     * Manipulates the current Tab count.
     *
     * internal or globaly depends on settings.
     * 
     * @param integer $i the tabs to be added or remove (negative value for remove)
     * 
     * @return Xiphe\HTML
     */
    public function addTabs($i = 1)
    {
        Core\Config::setHTMLInstance($this);
        Core\Config::set('tabs', (Core\Config::get('tabs') + $i));

        return $this;
    }

    /**
     * Escapes equal and pipe symbols from given string by
     * prefixing them with a backslash.
     * 
     * @param string $str input
     * 
     * @return string
     */
    public function escape($str)
    {
        return preg_replace('/[=|]/', '\$1', $str);
    }

    /**
     * Shorthand for escape
     *
     * @param string $str input
     *
     * @return string
     */
    public function esc($str) {
        return $this->escape($str);
    }

    /**
     * Constructor
     *
     * Sets the _ID and valid initiation arguments.
     * 
     * @param array $initArgs instance options
     *
     * @return Xiphe\HTML
     */
    public function __construct($initArgs = array())
    {
        if (empty($this->_ID)) {
            $this->_ID = self::$_cID++;

            if (!empty($initArgs) && is_string($initArgs)) {
                $initArgs = array(
                    'baseUrl' => $initArgs
                );
            }
            foreach (Core\Config::getDefaults() as $k => $v) {
                if (isset($initArgs[$k])) {
                    $this->$k = $initArgs[$k];
                }
            }
        }

        return $this;
    }

    /**
     * This is where the magic happens.
     *
     * Catch all method calls to unknown methods and pass them
     * to the Generator.
     * 
     * @param string $name      the called method
     * @param array  $arguments passed arguments
     * 
     * @return mixed             Xiphe\HTML or whatever the generator returns.
     */
    public function __call($name, $arguments)
    {
        Core\Config::setHTMLInstance($this);
        $r = Core\Generator::call($name, $arguments);
        if (!empty($r)) {
            return $r;
        }

        return $this;
    }

    /**
     * When this is cloned - give a new ID and empty tag store.
     *
     * @return Xiphe\HTML
     */
    public function __clone()
    {
        $this->_ID = self::$_cID++;
        $this->tagStore = array();
    }
}
