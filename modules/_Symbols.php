<?php
/**
 * Symbols Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Symbols.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Symbols Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Symbols extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        switch ($this->called) {
        case 'n':
        case 'r':
            HTML\Generator::lineBreak();
            break;
        case 't':
            HTML\Generator::tabs();
            break;
        default:
            break;
        }
    }
}
