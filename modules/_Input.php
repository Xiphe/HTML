<?php
/**
 * Input Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Input.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Input Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Input extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * The Label
     *
     * @var string
     */
    private $_label;

    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        switch ($this->called) {
        case 'textarea':
            $Tag = new HTML\Tag($this->called, array($this->args[0], $this->args[1]), array('generate'));
            break;
        default:
            $Tag = new HTML\Tag($this->called, array($this->args[0]), array('generate'));
            break;
        }
        $labelArgs = $this->_label;

        if ($this->called == 'checkbox' && isset($this->args[2]) && $this->args[2]) {
            $Tag->setAttrs(array('checked' => null));
        }

        $Label = HTML\Generator::getLabel($labelArgs, $Tag);

        HTML\Generator::appendLabel($Label, $Tag, $labelArgs);
    }

    /**
     * Check if Module can be used.
     *
     * @return boolean
     */
    public function sure()
    {
        $this->_label = null;
        switch ($this->called) {
        case 'textarea':
            $i = 2;
            break;
        default:
            $i = 1;
            break;
        }
        if (!isset($this->args[$i])) {
            return true;
        } elseif ($this->args[$i] !== false) {
            $this->_label = $this->args[$i];

            return true;
        }

        return false;
    }
}
