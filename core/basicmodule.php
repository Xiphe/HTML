<?php
/**
 * BasicModule class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/BasicModule.php
 */

namespace Xiphe\HTML\core;

/**
 * BasicModule class
 * 
 * Modules inherit from this class.
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class BasicModule
{
    /**
     * Initiation of a new module.
     * 
     * @param array  &$args    argument passed during HTML call 
     * @param array  &$options (tag)-options added to the module
     * @param string &$called  original call if module has alias
     * 
     * @return void
     */
    final public function init(&$args, &$options, &$called)
    {
        $this->args = &$args;
        $this->options = &$options;
        $this->called = &$called;
    }

    /**
     * Checks if the module has a specific (tag)option
     * 
     * @param string $name the option name
     * 
     * @return boolean
     */
    final public function hasOption($name)
    {
        return in_array($name, $this->options);
    }

    /**
     * Fallback method
     *
     * Can be overwritten by module to ensure that the module should be used.
     * 
     * @return boolean
     */
    public function sure()
    {
        return true;
    }
}
