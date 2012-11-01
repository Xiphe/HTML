<?php
/**
 * ModuleInterface interface file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/ModuleInterface.php
 */

namespace Xiphe\HTML\core;

/**
 * ModuleInterface interface
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
interface ModuleInterface
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
    public function init(&$args, &$options, &$called);

    /**
     * Checks if the module has a specific (tag)option
     * 
     * @param string $name the option name
     * 
     * @return boolean
     */
    public function hasOption($name);

    /**
     * The Module logic starts here.
     *
     * @return [type] [description]
     */
    public function execute();

    /**
     * Weather or not the module should be used.
     * 
     * @return boolean
     */
    public function sure();
}
