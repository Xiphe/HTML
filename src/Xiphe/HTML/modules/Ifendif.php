<?php
/**
 * Ifendif Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Ul.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Module Ifendif class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Ifendif extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        if ($this->called === 'if') {
            $this->generate();
            \Xiphe\HTML::get()->addTabs();
        } elseif($this->called === 'endif') {
            \Xiphe\HTML::get()->addTabs(-1);
            $this->generate();
        }
    }
}
