<?php
/**
 * Generator class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Generator.php
 */

namespace Xiphe\HTML\core;

/**
 * Generator class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Generator
{

    /**
     * The possible tag options
     *
     * @var array
     */
    public static $tagOptionKeys = array(
        'g' => 'generate',
        'r' => 'return',
        's' => 'start',
        'i' => 'inline',
        'l' => 'inlineInner',
        'f' => 'forbidInlineInner',
        'b' => 'bbContent', //deprecated
        'm' => 'markdown',
        'p' => 'compress',
        'c' => 'cleanContent',
        'n' => 'doNotCleanContent',
        't' => 'justGetObject',
        'o' => 'getObject',
        'q' => 'selfQlose',
        'd' => 'doNotSelfQlose'
    );

    /**
     * Things that must be done before the Tag will be created.
     *
     * @param mixed &$Obj the current Tag or Module
     * 
     * @return mixed the object if it is in justGetObject mode or null.
     */
    private static function _applyPreGenerationFilters(&$Obj)
    {
        if ($Obj->name == 'comment' && Config::get('noComments')) {
            $Obj->destroy();

            return false;
        }

        if (in_array('justGetObject', $Obj->options)) {
            return $Obj;
        }

        if (in_array('return', $Obj->options)) {
            ob_start();
        }
    }

    /**
     * Things that must be done after the Tag was generated.
     *
     * @param object &$Obj the current Tag or Module
     * 
     * @return mixed  null or string if the tag is in getObject mode.
     */
    private static function _applyPostGenerationFilters(&$Obj)
    {
        if (in_array('return', $Obj->options)) {
            return ob_get_clean();
        }

        if (in_array('getObject', $Obj->options)) {
            return $Obj;
        }
    }

    /**
     * sends current amount of tabs to the output.
     *
     * @return void
     */
    public static function tabs()
    {
        echo self::getTabs();
    }

    /**
     * Gets a string containing the current amount of tabs
     *
     * @return string
     */
    public static function getTabs()
    {
        $tabs = Config::get('tabs');

        return str_repeat(Config::get('tab'), ($tabs >= 0 ? $tabs : 0));
    }

    /**
     * sends the current line break symbol to the output.
     *
     * @return void
     */
    public static function lineBreak()
    {
        echo self::getLineBreak();
    }

    /**
     * Getter for the current line-break symbol.
     *
     * @return string
     */
    public static function getLineBreak()
    {
        return Config::get('break');
    }

    /**
     * Debug/Error Method
     *
     * @param string  $msg    the debug message
     * @param integer $mode   null = default, 1 = info, 2 = warning, 3 = error
     * @param integer $offset backtrace offset for THEDEBUG
     * 
     * @return void
     */
    public static function debug($msg, $mode = null, $offset = null)
    {
        switch (Config::get('debug')) {
        case 'THEDEBUG':
            if (class_exists('Xiphe\THEMASTER\THEDEBUG')) {
                Xiphe\THEMASTER\debug($msg, $mode, null, 2+$offset);
            }
            break;
        case 'Exception':
            throw new \Exception($msg, 1);
            break;
        default:
            break;
        }
    }

    /**
     * Catch all Method that allows to use the tag name as method name and append options to it
     *
     * @param string $method the tag name with optional options i.e. s_div or h1
     * @param array  $args   the arguments passed to the method call
     * 
     * @return mixed  null or Tag instance or string
     */
    public static function call($method, $args = array())
    {
        /*
         * Return if not enabled.
         */
        if (Config::get('disable')) {
            return;
        }

        /*
         * Sanitize Method name. (Just to be sure XD)
         */
        $method = preg_replace('/[^a-z0-9_]+/', '', strtolower($method));

        /*
         * Split the method name into options and tag.
         */
        $e = explode('_', $method);
        if (count($e) == 1 && !empty($e[0])) {
            $tag = $e[0];
            $options = false;
        } elseif (count($e) == 2 && !empty($e[1])) {
            $tag = $e[1];
            $options = $e[0];
        } else {
            /*
             * Invalid format
             */
            self::debug(sprintf('Invalid format in HTML Call "%s"', $method), 3, 2);

            return null;
        }

        /*
         * Verify the options
         */
        $tmp = array();
        foreach (str_split($options) as $key) {
            if (isset(self::$tagOptionKeys[$key])) {
                $tmp[] = self::$tagOptionKeys[$key];
            }
        }
        $options = $tmp;
        unset($tmp);

        $called = $tag;
        Modules::appendAlias($tag);
        $Module = '';

        /**
         * Loads the Module and asks if is should be used for this case.
         *
         * @var function
         */
        $useModule = function () use (&$Module, $tag, &$args, &$options, &$called) {
            $Module = Modules::get($tag, $args, $options, $called);
            return $Module->sure();
        };

        /*
         * Check if the Tag is forced to be generated or no module exists and generate it.
         * Otherwise prefer the module.
         */
        if (in_array('generate', $options)
            || !Modules::exist($tag)
            || !$useModule()
        ) {
            $tag = $called;

            /*
             * Create new Tag
             */
            $Tag = new Tag($tag, $args, $options);

            /*
             * Do things that should be done before tag will be created
             */
            $r = self::_applyPreGenerationFilters($Tag);

            /*
             * Check if the pre-generation filters have returned anything and return it in this case.
             */
            if ($r !== null) {
                return $r;
            }

            $Tag->open();
            if (!$Tag->hasOption('start')) {
                $Tag->content();
                $Tag->close();
            }

            /*
             * Do things that should be done after tag generation.
             */

            return self::_applyPostGenerationFilters($Tag);
        } else {
            if (empty($Module)) {
                $Module = Modules::get($tag, $args, $options, $called);
            }

            /*
             * Do things that should be done before tag will be created
             */
            $r = self::_applyPreGenerationFilters($Module);

            /*
             * Check if the pre-generation filters have returned anything and return it in this case.
             */
            if ($r !== null) {
                return $r;
            }

            $Module->execute();

            /*
             * Do things that should be done after tag generation.
             */

            return self::_applyPostGenerationFilters($Module);
        }
    }

    /**
     * Parser for string formated attribute arrays
     *
     * Arrays will be returned immediate.
     * Multiple attributes should be separated by a pipe char "|"
     * Name and value of the attribute should be separated by an equal sign "="
     * The signs can be escaped by a backslash (foo\|bar will not be separated)
     *
     * @param mixed $input the attribute array, string or Tag object
     * 
     * @return void
     */
    public static function parseAtts($input)
    {
        if (is_object($input) && get_class($input) == 'Xiphe\HTML\core\Tag') {
            $Tag = $input;
            $input = $Tag->attributes;
        }

        /*
         * Check if attributes are already in array form.
         */
        if (is_array($input)) {
            return $input;
        }

        /*
         * If no attributes were passed - return empty array.
         */
        if (empty($input)) {
            return array();
        }

        /*
         * Split the attribute string into separated attributes by |
         */
        $atts = preg_split('/(?<=[^\\\])[|]+/', $input, -1, PREG_SPLIT_NO_EMPTY);

        /*
         * Set the tags attributes to array
         */
        $input = array();

        /*
         * Split the attributes in key an value by =
         */
        foreach ($atts as $k => $attr) {
            $attr = preg_split('/(?<=[^\\\])[=]+/', $attr, 2);

            foreach ($attr as $k => $v) {
                /*
                 * replace escaped pipe and equal glyphs.
                 */
                $attr[$k] = preg_replace('/[\\\]([=|\|])/', '$1', $v);
            }

            /*
             * Has no value or key
             */
            if (count($attr) == 1) {

                /*
                 * A single attribute was passed
                 */
                if (isset($Tag) && count($atts) == 1) {
                    if (($t = self::getKeyAlias($attr)) && !self::_ignoreKeyAlias($t, $Tag) ) {
                        extract($t);
                        $attr[1] = substr($attr[0], strlen($alias));
                        $attr[0] = $key;
                    } else {
                        /*
                         * use the key from TagInfo::$singleAttrkeys
                         */
                        $attr[1] = $attr[0];
                        $attr[0] = self::getSingleAttrKey($Tag);
                    }
                } elseif (isset($Tag) && ($t = self::getKeyAlias($attr))) {
                    extract($t);
                    $attr[1] = substr($attr[0], strlen($alias));
                    $attr[0] = $key;
                } else {
                    $attr[1] = null;
                }

                if (isset($Tag) && $attr[0] === '%default') {
                    $attr[0] = TagInfo::$singleAttrkeys[$Tag->name];
                }
            }

            /*
             * Write Attribute to tag.
             */
            $input[$attr[0]] = $attr[1];
        }

        return $input;
    }

    /**
     * Replaces ./ in the beginning of href and src attributes into baseUrl
     *
     * @param Tag &$Tag the current tag
     * 
     * @return void
     */
    public static function magicUrls(Tag &$Tag)
    {
        foreach (TagInfo::$magicUrlAttributes as $name) {
            if (isset($Tag->attributes[$name])) {
                $Tag->attributes[$name] = preg_replace(
                    '/^(\.\/)/',
                    rtrim(Config::get('baseUrl'), '/').'/',
                    $Tag->attributes[$name]
                );
                $Tag->attributes[$name] = preg_replace(
                    '/^(\\\\.\/)/',
                    './',
                    $Tag->attributes[$name]
                );
            }
        }
    }

    /**
     * Builds an array of classes by seperating the class attribute by spaces
     * If if was not build before
     *
     * If the classes array exists the attributes class will be updates
     *
     * @param Tag &$Tag the current Tag
     * 
     * @return void
     */
    public static function updateClasses(Tag &$Tag)
    {
        if (empty($Tag->classes) && isset($Tag->attributes['class'])) {
            $classes = explode(' ', $Tag->attributes['class']);
        } elseif (!empty($Tag->classes)) {
            $classes = $Tag->classes;
        }

        if (isset($classes)) {
            sort($classes);
            $Tag->classes = $classes;
            $Tag->attributes['class'] = implode(' ', $classes);
        }
    }

    /**
     * Merges two strings containing styles.
     *
     * @param string $a style A
     * @param string $b style B
     * 
     * @return string style A + style B
     */
    public static function mergeStyles($a, $b)
    {
        /*
         * Cut the styles at the ; symbols
         */
        $a = explode(';', $a);

        /*
         * Will contain all style keys and the indexes of them in $a.
         */
        $amap = array();

        /*
         * Getter for the style key.
         */
        $gk = function ($s) {
            return trim(substr($s, 0, strpos($s, ':')));
        };

        /*
         * Cleanup $a and build the map.
         */
        foreach ($a as $k => $v) {
            if (trim($v) == '') {
                unset($a[$k]);
                continue;
            }
            $a[$k] = trim($v);
            $amap[$gk($v)] = $k;
        }

        /*
         * Merge $b
         */
        foreach (explode(';', $b) as $st) {
            if (trim($st) == '') {
                continue;
            }

            /*
             * If the current key is set in the map.
             * remove it from $a
             */
            if (isset($amap[$gk($st)])) {
                unset($a[$amap[$gk($st)]]);
            }
            $a[] = trim($st);
        }

        /*
         * sort, minimize and return.
         */
        sort($a);

        return str_replace(array(': ', ': '), ':', implode(';', $a));
    }

    /**
     * Adds default attributes to the tag.
     *
     * @param Tag &$Tag the current Tag.
     * 
     * @see    TagInfo::$defaultAttributes
     * @return void
     */
    public static function addDefaultAttributes(Tag &$Tag)
    {
        if (isset(TagInfo::$defaultAttributes[$Tag->name])) {
            $Tag->attributes = array_merge(
                TagInfo::$defaultAttributes[$Tag->name],
                $Tag->attributes
            );
        }
    }

    /**
     * Adds default options to the tag.
     *
     * @param Tag &$Tag the current Tag.
     * 
     * @see    TagInfo::$defaultOptions
     * @return void
     */
    public static function addDefaultOptions(Tag &$Tag)
    {
        if (isset(TagInfo::$defaultOptions[$Tag->name])) {
            foreach (TagInfo::$defaultOptions[$Tag->name] as $defopt) {
                if (!in_array($defopt, $Tag->options)) {
                    $Tag->options[] = $defopt;
                }
            }
        }
    }

    /**
     * Duplicates some attributes if needed.
     *
     * src & alt on image or name and id on inputs
     *
     * @param Tag &$Tag the current Tag
     * 
     * @return void
     */
    public static function addDoubleAttributes(Tag &$Tag)
    {
        if (isset(TagInfo::$doubleAttrs[$Tag->name])) {
            $missing = array();
            $found = '';
            foreach (TagInfo::$doubleAttrs[$Tag->name] as $k => $name) {
                if ($k === '%callback') {
                    $callback = $name;
                    continue;
                }
                if (isset($Tag->attributes[$name])) {
                    $found = $Tag->attributes[$name];
                } else {
                    $missing[] = $name;
                }
            }
            if (empty($found) || empty($missing)) {
                return;
            }
            foreach ($missing as $k) {
                $Tag->attributes[$k] = $found;
            }

            if (count($missing) && isset($callback) && is_callable($callback)) {
                call_user_func_array($callback, array(&$Tag, $missing));
            }
        }
    }

    /**
     * Callback function for double attrs on an image tag.
     *
     * @param Tag   &$Tag    the current tag
     * @param array $changed the tags that were changed
     * 
     * @return void
     */
    public static function magicAlt(Tag &$Tag, $changed)
    {
        switch ($Tag->realName) {
        case 'img':
            if (in_array('alt', $changed)) {
                $Tag->attributes['alt'] = basename($Tag->attributes['alt']);
            }
            break;
        default:
            break;
        }
    }

    /**
     * Validates Label arguments and builds a label tag for $Tag
     *
     * @param mixed &$labelArgs the passed label info (empty, string or array)
     * @param Tag   &$Tag       the tag retrieving the label (must have name & id)
     * 
     * @return Tag   the label
     */
    public static function getLabel(&$labelArgs, &$Tag)
    {
        /*
         * Normalize empty.
         */
        if (empty($labelArgs)) {
            $labelArgs = array();
        } else {
            /*
             * Parse the label arguments.
             */
            $t = $labelArgs;
            $labelArgs = self::parseAtts($labelArgs);

            if (count($labelArgs) == 1 && @array_shift(array_values($labelArgs)) === null) {
                $labelArgs = array('inner' => $t);
            }
        }

        /*
         * Merge the passed args into defaults.
         */
        $labelArgs = array_merge(
            array(
                'inner' => ucfirst($Tag->attributes['id']),
                'pos' => 'before',
                'sep' => ''
            ),
            $labelArgs
        );

        /*
         * Set and normalize the glue arg.
         */
        if (!isset($labelArgs['glue'])) {
            if (!empty($labelArgs['sep'])) {
                $labelArgs['glue'] = true;
            } else {
                $labelArgs['glue'] = false;
            }
        } elseif ($labelArgs['glue'] == 'false') {
            $labelArgs['glue'] = false;
        } else {
            $labelArgs['glue'] = (bool) $labelArgs['glue'];
        }

        /*
         * Create and return the label object.
         */

        return new Tag('label', array($labelArgs['inner'], $Tag->attributes['id']));
    }

    /**
     * Puts the $Label and $Tag together according to $labelArgs
     *
     * @param mixed &$Label    The label string or Tag objec.
     * @param mixed &$Tag      The Tag string or object.
     * @param array $labelArgs How to append the label.
     * 
     * @return void
     */
    public static function appendLabel(&$Label, &$Tag, $labelArgs)
    {
        if ($labelArgs['glue'] != false) {
            /*
             * Use glue (no tabs and line breaks between label, seperator and tag)
             */
            if ($labelArgs['pos'] == 'after') {
                self::call('blank', array(trim($Tag).$labelArgs['sep'].trim($Label)));
            } else {
                self::call('blank', array(trim($Label).$labelArgs['sep'].trim($Tag)));
            }
        } else {
            /*
             * Don't use glue.
             */
            if ($labelArgs['pos'] == 'after') {
                echo $Tag;
                if (!empty($labelArgs['sep'])) {
                    self::call('blank', array($labelArgs['sep']));
                }
                echo $Label;
            } else {
                echo $Label;
                if (!empty($labelArgs['sep'])) {
                    self::call('blank', array($labelArgs['sep']));
                }
                echo $Tag;
            }
        }
    }

    /**
     * Checks and applies aliases for attribute keys
     *
     * For example .foo will be converted into class="foo" ("." is the alias for "class")
     * 
     * @param array &$attr the current attribute
     *
     * @see    TagInfo::$attrKeyAliases
     * @return mixed alias if found, false if not
     */
    public static function getKeyAlias(array &$attr)
    {
        foreach (TagInfo::$attrKeyAliases as $alias => $key) {
            if (strpos($attr[0], $alias) === 0) {
                return compact('key', 'alias');
            }
        }

        return false;
    }

    /**
     * Checks if the current key alias is meant to be ignored.
     *
     * It's important to make sure, that this is only used to tags containing just one attribute.
     *
     * @param array $t    the attributes alias
     * @param Tag   &$Tag the current Tag.
     * 
     * @return boolean true if it alias should be ignored.
     */
    private static function _ignoreKeyAlias(array $t, Tag &$Tag)
    {
        extract($t);
        $single = self::getSingleAttrKey($Tag);
        if (isset(TagInfo::$ignoreAlisasesOnSingle[$single])
            && in_array($alias, TagInfo::$ignoreAlisasesOnSingle[$single])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Getter for the single attribute keys
     *
     * For Example if you do $HTML->a('example', 'http://example.org'); The url will be used
     * as value for the href attribute. Defaults to class
     * ($HTML->div('foo', 'bar') will turn into <div class="bar">foo</div>)
     * 
     * @param Tag &$Tag the current Tag
     *
     * @see    TagInfo::$singleAttrkeys
     * @see    TagInfo::$defaultSingleAttrkey
     * @return string the attribute key.
     */
    public static function getSingleAttrKey(Tag &$Tag)
    {
        if (isset(TagInfo::$singleAttrKeys[$Tag->name])) {
            return TagInfo::$singleAttrKeys[$Tag->name];
        } else {
            return TagInfo::$defaultSingleAttrKey;
        }
    }

    /**
     * Converts the Attributes of $Tag into a string
     *
     * @param Tag &$Tag the current tag
     * 
     * @return string the attribute string
     */
    public static function attsToString(Tag &$Tag)
    {
        /*
         * Return empty string if tag does not have attributes.
         */
        if (empty($Tag->attributes)) {
            return '';
        }

        $r = ' ';
        foreach ($Tag->attributes as $key => $value) {
            /*
             * Validate the attribute name.
             */
            $tmp = $key;
            if (!self::ensureAttrNameValidation($key)) {
                self::debug(sprintf('Invalid attribute name "%s" was changed to "%s"', $tmp, $key), 2, 7);
            }

            /*
             * If we have an value we make sure critical letters are escaped and use the format :name=":value"
             */
            if (!empty($value)) {
                $tmp = $value;
                if (!self::ensureAttrValueValidation($value)) {
                    self::debug(sprintf('Dangerous attribute value "%s" was changed to "%s"', $tmp, $value), 2, 7);
                }
                $value = str_replace('"', '&quot;', $value);
                $r .= "$key=\"$value\" ";
            } elseif ($value !== false) {
                /*
                 * No value? Alright just take the name.
                 */
                $r .= $key.' ';
            }
        }

        /*
         * Remove the last space and return.
         */

        return rtrim($r, ' ');
    }

    /**
     * Make sure that the attribute name is W3C conform.
     *
     * http://www.w3.org/TR/2000/REC-xml-20001006#NT-Name
     *
     * @param string &$name the attribute name
     * 
     * @return boolean true if it was valid, false if something was replaced.
     */
    public static function ensureAttrNameValidation(&$name)
    {
        $count = 0;
        $name = preg_replace('/^[^a-zA-Z_:]|[^a-zA-Z0-9-_:.]/', '', $name, -1, $count);

        return !$count;
    }

    /**
     * Make sure critical letters are escaped
     *
     * @param string &$value the attribute name
     * 
     * @return boolean true if if was valid, false if something was escaped.
     */
    public static function ensureAttrValueValidation(&$value)
    {
        $count = 0;
        $name = preg_replace('/"/', '&quot;', $value, -1, $count);

        return !$count;
    }
}
