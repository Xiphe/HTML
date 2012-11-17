<?php
/**
 * Openinghtml Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Openinghtml.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as Core;

/**
 * Openinghtml Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Openinghtml extends Core\BasicModule implements Core\ModuleInterface
{

    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {

        $this->htmlattrs = array('class' => 'no-js'.$this->ieClass(' ').$this->browserClass(' '));
        $this->headattrs = array();

        if ($this->called == 'xhtml') {
            $this->xhtml();
        } else {
            $this->html5();
        }

    }

    /**
     * Generate a XHTML header.
     *
     * @return void
     */
    public function xhtml()
    {
        $this->htmlattrs['xmlns'] = 'http://www.w3.org/1999/xhtml';

        echo '<?xml version="1.0" ?>';
        Core\Generator::lineBreak();
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"';
        Core\Generator::lineBreak();
        Core\Config::set('tabs', '++');
        Core\Generator::tabs();
           echo '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
           Core\Generator::lineBreak();
        Core\Config::set('tabs', '--');

        echo $this->getHtml();
        echo $this->getHead();
    }

    /**
     * Generate a HTML5 header.
     *
     * @return void
     */
    public function html5()
    {
        echo '<!DOCTYPE HTML>';
        Core\Generator::lineBreak();
        echo $this->getHtml();
        echo $this->getHead();
        \Xiphe\HTML::get()->utf8()
            ->meta('http-equiv=X-UA-Compatible|content=IE\=edge,chrome\=1');
    }

    /**
     * Returns the actual html tag.
     *
     * @return Tag
     */
    public function getHtml()
    {
        $html = new Core\Tag(
            'html',
            array((isset($this->args[1]) ? $this->args[1] : null)),
            array('generate', 'start')
        );
        $html->setAttrs($this->htmlattrs);

        return $html;
    }

    /**
     * Returns the head tag.
     *
     * @return Tag
     */
    public function getHead()
    {
        $head = new Core\Tag(
            'head',
            array((isset($this->args[0]) ? $this->args[0] : null)),
            array('generate', 'start')
        );
        $head->setAttrs($this->headattrs);

        return $head;
    }

    /**
     * Checks if \Xiphe\THETOOLS exists and append ie classes. 
     *
     * @param string $before separator.
     *
     * @return string
     */
    public function ieClass($before = '')
    {
        $sIeClass = '';
        if (class_exists('Xiphe\THEMASTER\core\THEMASTER')) {
            if (\Xiphe\THETOOLS::is_browser('ie')) {
                if (\Xiphe\THETOOLS::is_browser('ie6x')) {
                    $sIeClass = $before.'lt-ie10 lt-ie9 lt-ie8 lt-ie7';
                } elseif (\Xiphe\THETOOLS::is_browser('ie7x')) {
                    $sIeClass = $before.'lt-ie10 lt-ie9 lt-ie8';
                } elseif (\Xiphe\THETOOLS::is_browser('ie8x')) {
                    $sIeClass = $before.'lt-ie10 lt-ie9';
                } elseif (\Xiphe\THETOOLS::is_browser('ie9x')) {
                    $sIeClass = $before.'lt-ie10';
                }
            }
        }

        return $sIeClass;
    }

    /**
     * Checks if \Xiphe\THETOOLS exists and appends browser classes. 
     *
     * @param string $before separator.
     *
     * @return string
     */
    public function browserClass($before = '')
    {
        if (class_exists('Xiphe\THEMASTER\core\THEMASTER')) {
            $browser = str_replace(' ', '_', strtolower(\Xiphe\THETOOLS::get_browser()));
            $version = str_replace('.', '-', \Xiphe\THETOOLS::get_browserVersion());
            $engine = strtolower(\Xiphe\THETOOLS::get_layoutEngine());
            if (!empty($engine)) {
                $engine .=' ';
            }

            return "$before$engine$browser $browser-$version";
        }

        return '';
    }
}
