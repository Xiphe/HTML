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
class Googleanalytics extends HTML\BasicModule implements HTML\ModuleInterface
{
    const JS = "var _gaq = _gaq || [];
        _gaq.push(['_setAccount', ':UA:']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        }) ();";

    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        HTML\Generator::call(
            'script',
            array(
                str_replace(':UA:', $this->args[0], self::JS)
            ),
            array(
                'compress',
                'inlineInner',
                'noCache'
            )
        );
    }
}
