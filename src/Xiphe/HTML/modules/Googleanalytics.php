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
    const JS = "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', ':UA:');
        ga('send', 'pageview');";

    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        if (!empty($this->args[1])) {
            $this->args[0] .= "', '".str_replace('\'', '"', $this->args[1]);
        }

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
