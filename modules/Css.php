<?php
/**
 * Css Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Css.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Css Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe
 */
class Css extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        $options = $this->options;
        $options[] = 'doNotSelfQlose';
        if (in_array('compressCss', $options)) {
            $options[] = 'inlineInner';
        }

        $Tag = new HTML\Tag('style', $this->args, $options);

        $Tag->open();
        $Tag->content();
        $Tag->close();
    }

    /**
     * Don't use this module if content looks like an url.
     *
     * @return boolean
     */
    public function sure()
    {
        return !(substr($this->args[0], 0, 4) == 'http'
            || substr($this->args[0], 0, 3) == '../'
            || substr($this->args[0], 0, 3) == '\./'
            || substr($this->args[0], 0, 2) == './'
            || substr($this->args[0], 0, 1) == '/'
        );
    }
}
