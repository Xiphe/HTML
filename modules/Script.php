<?php
/**
 * Script Module class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/modules/Script.php
 */

namespace Xiphe\HTML\modules;
use Xiphe\HTML\core as HTML;

/**
 * Script Module class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Script extends HTML\BasicModule implements HTML\ModuleInterface
{
    /**
     * Module Logic
     *
     * @return void
     */
    public function execute()
    {
        if ($this->hasOption('start')) {
            $this->options[] = 'doNotSelfQlose';
            echo new HTML\Tag('script', $this->args, $this->options);

            return;
        }

        $options = $this->options;
        $options[] = 'doNotSelfQlose';
        if (in_array('compressJs', $options)) {
            $options[] = 'inlineInner';
        }

        $Tag = new HTML\Tag('script', $this->args, $options);

        $Tag->open();
        $Tag->content();
        $Tag->close();
    }

    /**
     * Check if Module should be used.
     *
     * @return boolean
     */
    public function sure()
    {
        if ($this->hasOption('start')) {
            $this->addOption('doNotSelfQlose');
        }
        if (empty($this->args[0])) {
            $this->args[0] = array();
        }
        switch ($this->called) {
        case 'jquery':
            $this->called = 'script';
            $this->args[0] = array_merge(
                array(
                    'type' => 'text/javascript',
                    'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'
                ),
                $this->args[0]
            );

            return false;
        case 'jqueryui':
            $this->called = 'script';
            $this->args[0] = array_merge(
                array(
                    'type' => 'text/javascript',
                    'src' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'
                ),
                $this->args[0]
            );

            return false;
        default:
            $this->called = 'script';
            break;
        }

        if (empty($this->args[0])) {
            return false;
        }

        return !(substr($this->args[0], 0, 4) == 'http'
         || substr($this->args[0], 0, 3) == '../'
         || substr($this->args[0], 0, 3) == '\./'
         || substr($this->args[0], 0, 2) == './'
         || substr($this->args[0], 0, 1) == '/'
        );
    }
}
