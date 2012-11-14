<?php
/**
 * Tag class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Tag.php
 */

namespace Xiphe\HTML\core;

/**
 * Tag class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Tag
{
    /**
     * TagStore ID of this Tag.
     *
     * @var integer
     */
    public $ID;

    /**
     * The name of the tag
     *
     * @var string
     */
    public $name;

    /**
     * The real name of the Tag.
     *
     * Example: if name is "utf8" the real name is "meta".
     *
     * @var string
     */
    public $realName;

    /**
     * The Tags options
     *
     * @var array
     */
    public $options = array();

    /**
     * The Tags attributes.
     *
     * @var array
     */
    public $attributes = array();

    /**
     * The Tags content
     *
     * @var string
     */
    public $content = '';

    /**
     * What brackets to use
     *
     * @var array
     */
    public $brackets;

    /**
     * The Tags attributes in HTML-ready string format.
     *
     * @var string
     */
    public $attributeString = '';

    /**
     * Holder of all the classes
     *
     * @var array
     */
    public $classes = array();

    /**
     * If the inner content of tag should be in a new line and indented.
     *
     * @var boolean
     */
    public $inlineInner = false;

    /**
     * By setting this value the defaults from Taginfo::$selfClosing will be overwritten.
     *
     * @var boolean
     */
    public $selfclosing;

    /**
     * Whether or not the tag was opened jet.
     *
     * @var boolean
     */
    private $_opened = false;

    /**
     * Whether or not the tag was closed jet.
     *
     * @var boolean
     */
    private $_closed = false;

    /**
     * Whether or not the tag content was printed jet.
     *
     * @var boolean
     */
    private $_contentPrinted = false;

    /**
     * Checks if the tag has a specific option.
     *
     * @param string $option the option name
     *
     * @return boolean
     */
    public function hasOption($option)
    {
        return in_array($option, $this->options);
    }

    /**
     * Adds an option to the Tag
     *
     * @param string $option the new option
     *
     * @return void
     */
    public function addOption($option)
    {
        if (in_array($option, Generator::$tagOptionKeys)
            && !$this->hasOption($option)
        ) {
            $this->options[] = $option;
        }
    }

    /**
     * Removes an option from the Tag
     *
     * @param string $option the option that should be removed
     *
     * @return void
     */
    public function removeOption($option)
    {
        if ($this->hasOption($option)) {
            $key = array_search($option, $this->options);
            unset($this->options[$key]);
        }
    }

    /**
     * Checks if the Tag has a specific class
     *
     * @param string $class the class
     *
     * @return boolean
     */
    public function hasClass($class)
    {
        return in_array($class, $this->classes);
    }

    /**
     * Constructor method
     *
     * @param string $name    the tags name
     * @param array  $args    additional arguments
     * @param array  $options the tags options
     */
    public function __construct($name, $args = array(), $options = array())
    {
        /*
         * Store initiation arguments.
         */
        $this->ID = Store::getNewID();
        $this->name = $name;
        $this->options = $options;
        $this->realName = $this->name;

        /*
         * Get default brackets
         */
        $this->brackets = &TagInfo::$defaultBrackets;

        /*
         * Check if name is an alias and set realName or custom brackets.
         * @see TagInfo::$aliasTags
         */
        if (isset(TagInfo::$aliasTags[$this->name])) {
            if (is_array(TagInfo::$aliasTags[$this->name])) {
                $this->brackets = &TagInfo::$aliasTags[$this->name];
            } else {
                $this->realName = TagInfo::$aliasTags[$this->name];
            }
        }

        /*
         * Default to empty array if no arguments were passed.
         */
        if (empty($args[0])) {
            $args[0] = '';
        }
        /*
         * Default to empty array if no arguments were passed.
         */
        if (empty($args[1])) {
            $args[1] = array();
        }

        /*
         * Set attributes and content according to options and self-closing
         */
        if ($this->isSelfclosing() || $this->hasOption('start')) {
            $this->attributes = $args[0];
        } else {
            $this->content = $args[0];
            if (isset($args[1])) {
                $this->attributes = $args[1];
            }
        }

        /*
         * Additional Arguments were passed - try to sprintf them.
         */
        if (isset($this->content) && count($args) > 2) {
            array_splice($args, 0, 2);
            $this->content = vsprintf($this->content, $args);
        }

        /*
         * Add Default Options
         */
        Generator::addDefaultOptions($this);

        if ((empty($this->content) && !$this->hasOption('start'))
            || $this->hasOption('inlineInner')
        ) {
            $this->inlineInner = true;
        }

        /*
         * Parse the attributes
         */
        $this->attributes = Generator::parseAtts($this);

        /*
         * Add Defaults
         */
        Generator::addDefaultAttributes($this);

        /*
         * Add potential doubled attributes
         */
        Generator::addDoubleAttributes($this);

        $this->update();
        $this->update('content');

        /*
         * Execute Tag generated Hook if Wordpress is available.
         */
        if (class_exists('\WP')) {
            call_user_func_array('do_action', array('Xiphe\HTML\TagCreated', &$this, Config::getHTMLInstance()));
        }
    }

    /**
     * Updates class variables.
     *
     * @param string $what set to just update a specific part of the tag
     * 
     * @return void
     */
    public function update($what = 'all')
    {
        /*
         * Generate Class array.
         */
        if ($what == 'all' || $what == 'classes') {
            Generator::updateClasses($this);
        }

        /*
         * Generate Class array.
         */
        if ($what == 'all' || $what == 'urls') {
            Generator::magicUrls($this);
        }

        /*
         * Parse the content.
         */
        if ($what == 'content') {
            Content::parse($this);
        }

        if ($what == 'content' || $what == 'all' || $what == 'inlineInner') {
            if ($this->hasOption('inlineInner')
                || ($this->name !== 'blank'
                && !$this->hasOption('forbidInlineInner')
                && !$this->isSelfClosing()
                && !$this->hasOption('start')
                && strlen($this->content) < Config::get('maxLineWidth')
                && !preg_match('/\r\n|\n|\r/', $this->content))
            ) {
                $this->inlineInner = true;
            } else {
                $this->inlineInner = false;
            }
        }

        if ($what == 'all' || $what == 'attributes') {
            /*
             * Sort Atrributes and Classes.
             */
            ksort($this->attributes);

            /*
             * Parse the attributes to string format.
             */
            $this->attributeString = Generator::attsToString($this);
        }
    }

    /**
     * Add an array of attributes to the tag.
     *
     * Merges class and style attributes
     * Accepts attributes in string format.
     *
     * @param mixed $attrs the new attributes.
     *
     * @return void
     */
    public function setAttrs($attrs)
    {
        $oldAttrs = $this->attributes;
        $oldClasses = $this->classes;

        $this->attributes = $attrs;
        $this->attributes = Generator::parseAtts($this);

        $this->attributes = array_merge($oldAttrs, $this->attributes);
        $this->classes = null;
        $this->update('classes');

        if (!empty($oldClasses) && !empty($this->classes)) {
            $this->attributes['class'] = implode(' ', array_merge($oldClasses, $this->classes));
        }
        $this->classes = null;

        if (!empty($oldAttrs['style']) && !empty($this->attributes['style'])) {
            $this->attributes['style'] = Generator::mergeStyles($this->attributes['style'], $oldAttrs['style']);
        }

        $this->update();
    }

    /**
     * Removes the tag from the generators tag store.
     *
     * @return void
     */
    public function destroy()
    {
        Store::remove($this);
    }

    /**
     * Checks if this tag is meant to be self closing.
     *
     * @return boolean
     */
    public function isSelfclosing()
    {
        if (isset($this->selfclosing)) {
            return (bool) $this->selfclosing;
        }
        if ($this->hasOption('selfQlose')) {
            $this->selfclosing = true;

            return true;
        } elseif ($this->hasOption('doNotSelfQlose')) {
            $this->selfclosing = false;

            return false;
        }

        return in_array($this->realName, TagInfo::$selfClosing);
    }

    /**
     * Opens the Start Tag (Normally: <div)
     *
     * @return void
     */
    private function _openStart()
    {
        if ($this->name === 'blank') {
            return;
        }

        /*
         * Store it.
         */
        Store::add($this);

        if (!$this->hasOption('inline')) {
            Generator::tabs();
        }
        echo str_replace(':name', $this->realName, $this->brackets['start']);
    }

    /**
     * Closes the Start Tag (Normally: > or />)
     *
     * @return void
     */
    private function _closeStart()
    {
        if ($this->name === 'blank') {
            return;
        }

        if ($this->isSelfclosing()) {
            echo str_replace(':name', $this->realName, $this->brackets['close_short']);
            $this->_closed = true;
            $this->destroy();
            if (!$this->hasOption('inline')) {
                Generator::lineBreak();
            }
            $this->_contentPrinted = true;
        } else {
            echo str_replace(':name', $this->realName, $this->brackets['close_start']);
            if (!$this->inlineInner && !$this->hasOption('inline')) {
                Config::set('tabs', '++');
                Generator::lineBreak();
            }
        }
    }

    /**
     * Opens the End Tag (Normally: </div)
     *
     * @return void
     */
    private function _openEnd()
    {
        if ($this->name === 'blank') {
            return;
        }

        if (!$this->inlineInner) {
            if ($this->name !== 'blank' && !$this->hasOption('inline')) {
                Config::set('tabs', '--');
            }
            Generator::tabs();
        }
        echo str_replace(':name', $this->realName, $this->brackets['end']);
    }

    /**
     * Closes the End Tag (Normally: >)
     *
     * @return void
     */
    private function _closeEnd()
    {
        if ($this->name === 'blank') {
            return;
        }

        echo str_replace(':name', $this->realName, $this->brackets['close_end']);
        if (!$this->hasOption('inline')) {
            if (!$this->inlineInner) {
                $this->closingComment();
            }
            if ($this->name !== 'blank') {
                Generator::lineBreak();
            }
        }
    }

    /**
     * Adds the closing comment containing the tag id or class.
     *
     * @return void
     */
    public function closingComment()
    {
        if (!empty($this->attributes['id'])) {
            $hint = '#'.$this->attributes['id'];
        } elseif (!empty($this->classes)) {
            $hint = '.'.$this->classes[0];
        } else {
            return false;
        }
        Generator::call('il_comment', array($hint));
    }

    /**
     * Opens the whole Tag (Normally <div id="foo">)
     *
     * @return void
     */
    public function open()
    {

        if (!$this->_opened) {
            $this->_openStart();
            if ($this->name !== 'blank') {
                echo $this->attributeString;
            }
            $this->_closeStart();
            $this->_opened = true;
        }
    }

    /**
     * Echoes the tag content.
     *
     * @return void
     */
    public function content()
    {
        if (!$this->_contentPrinted) {
            if (!$this->inlineInner) {
                Generator::tabs();
            }

            if ($this->hasOption('cleanContent')
                || (Config::get('clean') && !$this->hasOption('doNotCleanContent'))
            ) {
                echo trim(Cleaner::getClean($this->content));
            } else {
                echo $this->content;
            }

            if (!$this->inlineInner) {
                Generator::lineBreak();
            }
            $this->_contentPrinted = true;
        }
    }

    /**
     * Closes the Tag (Normally </div>)
     *
     * @return void
     */
    public function close()
    {
        if (!$this->_closed) {
            $this->_openEnd();
            $this->_closeEnd();
            $this->destroy();
            $this->_closed = true;
        }
    }

    /**
     * Checks if this tag is waiting to be closed.
     *
     * @return boolean
     */
    public function wasOpened()
    {
        return $this->_opened;
    }

    /**
     * Convert the Tag into a string (open() content() close())
     *
     * @return string
     */
    public function __tostring()
    {
        ob_start();
        $close = $this->_opened;
        $this->open();
        if (!in_array('start', $this->options)) {
            $this->content();
        }
        if (!$this->hasOption('start') || $close) {
            $this->close();
        }

        return ob_get_clean();
    }
}
