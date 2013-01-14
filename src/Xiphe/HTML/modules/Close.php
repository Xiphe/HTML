<?php
/**
 * Close Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Close.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Close Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Close extends HTML\BasicModule implements HTML\ModuleInterface
{
    // public $noCache = true;

    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {   
        $this->closed = 0;
        $before = HTML\Store::count();

        if (isset($this->args[1]) && $this->args[1] && !HTML\Store::has($this->args[0])) {
            return;
        }
        
        if (isset($this->args[0])) {
            $until = $this->args[0];
        }

        if (empty($this->args) || $this->args[0] == '')  {
            if (HTML\Store::hasTags()) {
                HTML\Store::get()->close();
            }
        } elseif (is_int($until)) {
            $i = 0;
            while ($i < $until && HTML\Store::hasTags()) {
                HTML\Store::get()->close();
                $i++;
            }
        } elseif ($until === 'all') {
            while (HTML\Store::hasTags()) {
                HTML\Store::get()->close();
            }
        } elseif (strpos($until, '.') === 0) {
            $found = false;
            while (!$found && HTML\Store::hasTags()) {
                if (HTML\Store::get()->hasClass(substr($until, 1))) {
                    $found = true;
                }
                HTML\Store::get()->close();
            }
        } elseif (strpos($until, '#') === 0) {
            $found = false;
            while (!$found && HTML\Store::hasTags()) {
                if (isset(HTML\Store::get()->attributes['id'])
                    && HTML\Store::get()->attributes['id'] == substr($until, 1)
                ) {
                    $found = true;
                }
                HTML\Store::get()->close();
            }
        } elseif(!empty($until)) {
            $found = false;
            while (!$found && HTML\Store::hasTags()) {
                if (HTML\Store::get()->name === $until) {
                    $found = true;
                }
                HTML\Store::get()->close();
            }
        }

        $this->closed = $before - HTML\Store::count();
    }
}
