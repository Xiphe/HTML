<?php
/**
 * Select Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Select.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Select Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Select extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        // var_dump($this->args);

        $Select = new HTML\Tag('select', array($this->args[0]), array('generate', 'start'));
        if (isset($this->args[2]) && is_array($this->args[2]) && !isset($Select->attributes['multiple'])) {
            $Select->attributes['multiple'] = '';
            $Select->update('attributes');
        }

        $r = '';
        $r .= $Select;

        $i = 1;
        if (!isset($this->args[1])) {
            $this->args[1] = array();
        }
        foreach ($this->args[1] as $k => $v) {
            if (is_string($v)) {
                $args = array();
                if (!is_int($k)) {
                    $args['value'] = $k;
                }

                if (isset($this->args[2]) && $this->isSelected($this->args[2], (!is_int($k) ? $k : $v), $i)) {
                    $args['selected'] = '';
                }

                $r .= new HTML\Tag('option', array($v, $args));
            } elseif (is_object($v) && get_class($v) == 'Xiphe\HTML\core\Tag') {
                if (isset($this->args[2])) {
                    if (isset($v->attributes['value'])) {
                        $k = $v->attributes['value'];
                    } else {
                        $k = $v->content;
                    }

                    if ($this->isSelected($this->args[2], $k, $i)) {
                        $v->attributes['selected'] = '';
                        $v->update('attributes');
                    }
                }

                $r .= $v;
            }
            $i++;
        }

        $r .= $Select;

        if (!isset($this->args[3]) || $this->args[3] !== false) {
            $labelArgs = array();
            if (isset($this->args[3])) {
                $labelArgs = $this->args[3];
            }

            $Label = HTML\Generator::getLabel($labelArgs, $Select);

            HTML\Generator::appendLabel($Label, $r, $labelArgs);
        } else {
            echo $r;
        }
    }

    /**
     * Checks for selected options.
     *
     * @param string  $selected targeted selected value
     * @param mixed   $value    the current value
     * @param integer $i        the current key
     * 
     * @return boolean
     */
    public function isSelected($selected, $value, $i)
    {
        if (is_array($selected)) {
            foreach ($selected as $s) {
                if ($this->isSelected($s, $value, $i)) {
                    return true;
                }
            }
        } elseif (is_int($selected) && $i === $selected) {
            return true;
        } elseif ($value === $selected) {
            return true;
        }

        return false;
    }
}
