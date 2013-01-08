<?php
/**
 * Checkgroup Module class file
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
 * Ul Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Checkgroup extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        $ckbxs = $this->args[0];
        $checked = $this->args[1];

        $i = 1;
        foreach ($ckbxs as $name => $label) {
            $ckd = false;

            if (in_array($i, $checked, true) || in_array($name, $checked)) {
                $ckd = true;
            }


            HTML\Generator::call(
                'checkbox',
                array(
                    $name,
                    $label,
                    $ckd
                )
            );

            $i++;
        }
    }
}
