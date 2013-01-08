<?php
/**
 * TagInfo class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/TagInfo.php
 */

namespace Xiphe\HTML\core;

/**
 * TagInfo class
 *
 * Just a holder for internal tag configuration.
 * 
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class TagInfo
{
    /**
     * If a single attribute is passed and tag is not in $singleAttrKeys
     * this will be used as the attribute key.
     *
     * @var string
     */
    public static $defaultSingleAttrKey = 'class';

    /**
     * If a single attribute is passed a key from this array
     * will be used if it fits.
     *
     * @var array
     */
    public static $singleAttrKeys = array(
        'a' => 'href',
        'img' => 'src',
        'link' => 'href',
        'css' => 'href',
        'less' => 'href',
        'script' => 'src',
        'input' => 'name',
        'checkbox' => 'id',
        'radio' => 'id',
        'submit' => 'value',
        'select' => 'name',
        'textarea' => 'name',
        'pw' => 'name',
        'option' => 'value',
        'hidden' => 'value',
        'favicon' => 'href',
        'form' => 'action',
        'head' => 'profile',
        'label' => 'for',
        'rederect' => 'content',
        'viewport' => 'content',
        'appleicon' => 'href',
        'abbr' => 'title',
        'action' => 'value',
        'description' => 'content'
    );

    /**
     * Some tags need specific options badly.
     *
     * @var array
     */
    public static $defaultOptions = array(
        'pre' => array(
            'doNotCleanContent',
            'inlineInner'
        )
    );

    /**
     * If Tag is in Array the specified arguments will be copyed.
     *
     * If the %callback key is callable if will be called after the
     * attributes are copied.
     * 
     * @see Generator::addDoubleAttributes()
     * @var array
     */
    public static $doubleAttrs = array(
        'input' => array('id', 'name'),
        'checkbox' => array('id', 'name'),
        'radio' => array('id', 'name'),
        'select' => array('id', 'name'),
        'pw' => array('id', 'name'),
        'textarea' => array('id', 'name'),
        'hidden' => array('id', 'name'),
        'action' => array('id', 'name'),
        'img' => array('src', 'alt', '%callback' => array('Xiphe\HTML\core\Generator', 'magicAlt')),
    );

    /**
     * Some default attributes for tags.
     *
     * @var array
     */
    public static $defaultAttributes = array(
        'link' => array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'media' => 'all'
        ),
        'css' => array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'media' => 'all'
        ),
        'less' => array(
            'rel' => 'stylesheet/less',
            'type' => 'text/css',
            'media' => 'all'
        ),
        'style' => array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'media' => 'all'
        ),
        'script' => array(
            'type' => 'text/javascript'
        ),
        'form' => array(
            'method' => 'post'
        ),
        'input' => array(
            'type' => 'text'
        ),
        'checkbox' => array(
            'type' => 'checkbox'
        ),
        'radio' => array(
            'type' => 'radio'
        ),
        'pw' => array(
            'type' => 'password'
        ),
        'hidden' => array(
            'type' => 'hidden',
            'name' => 'action'
        ),
        'submit' => array(
            'type' => 'submit',
            'name' => 'submit'
        ),
        'zw' => array(
            'class' => 'zerowrap'
        ),
        'favicon' => array(
            'rel' => 'shortcut icon',
            'type' => 'image/ico'
        ),
        'clear' => array(
            'class' => 'clear',
        ),
        'dclear' => array(
            'class' => 'clear',
        ),
        'utf8' => array(
            'http-equiv' => 'Content-Type',
            'content' => 'text/html; charset=utf-8'
        ),
        'rederect' => array(
            'http-equiv' => 'refresh',
        ),
        'viewport' => array(
            'name' => 'viewport',
            'content' => 'width=device-width, initial-scale=1.0',
        ),
        'appleicon' => array(
            'rel' => 'apple-touch-icon',
        ),
        'action' => array(
            'type' => 'hidden',
            'name' => 'action',
        ),
        'description' => array(
            'name' => 'description'
        )
    );

    /**
     * These are the default brackets for any HTML Tag.
     *
     * @var array
     */
    public static $defaultBrackets = array(
        'start' => '<:name',
        'end' => '</:name',
        'close_start' => '>',
        'close_short' => ' />',
        'close_end' => '>'
    );

    /**
     * Alias tags are set here.
     *
     * Key is the alias value is the original
     * or an array of alternative brackets.
     *
     * @var array
     */
    public static $aliasTags = array(
        'comment' => array(
            'start' => '<!-- ',
            'end' => ' -->',
            'close_start' => '',
            'close_short' => '',
            'close_end' => ''
        ),
        'script' => array(
            'start' => '<:name',
            'end' => '</:name',
            'close_start' => '>',
            'close_short' => '></:name>',
            'close_end' => '>'
        ),
        'hidden' => 'input',
        'zw' => 'div',
        'favicon' => 'link',
        'clear' => 'br',
        'dclear' => 'div',
        'utf8' => 'meta',
        'pw' => 'input',
        'checkbox' => 'input',
        'submit' => 'input',
        'radio' => 'input',
        'css' => 'link',
        'less' => 'link',
        'rederect' => 'meta',
        'viewport' => 'meta',
        'appleicon' => 'link',
        'action' => 'input',
        'description' => 'meta'
    );

    /**
     * Attribute key alias symbols.
     *
     * instead of writing href=example.org you can write %example.org.
     *
     * @var array
     */
    public static $attrKeyAliases = array(
        '.' => 'class',
        '#' => 'id',
        '%' => 'href',
        '?' => 'src',
        '}' => 'style',
        '~' => '%default'
    );

    /**
     * This aliases will be ignored on the specific attribute key
     *
     * @var array
     */
    public static $ignoreAlisasesOnSingle = array(
        'src' => array('.', '?'),
        'href' => array('.', '#', '?')
    );

    /**
     * Attributes that use the magic-url logic.
     *
     * @var array
     */
    public static $magicUrlAttributes = array(
        'src',
        'href'
    );

    /**
     * Predefined self-closing tags.
     *
     * Can be overwritten by using the q and d prefixes.
     *
     * @var array
     */
    public static $selfClosing = array(
        'script',
        'area',
        'base',
        'basefont',
        'br',
        'col',
        'frame',
        'hr',
        'img',
        'input',
        'isindex',
        'link',
        'meta',
        'param',
        'source',
        'wbr'
    );

    /**
     * List of inline Tags.
     *
     * Just used when content is cleaned.
     *
     * @var array
     */
    public static $inlineTags = array(
        'a',
        'abbr',
        'acronym',
        'applet',
        'b',
        'basefont',
        'bdo',
        'big',
        'br',
        'button',
        'cite',
        'code',
        'del',
        'dfn',
        'em',
        'font',
        'i',
        'img',
        'ins',
        'input',
        'iframe',
        'kbd',
        'label',
        'map',
        'object',
        'q',
        'samp',
        'select',
        'small',
        'span',
        'strong',
        'sub',
        'sup',
        'textarea',
        'tt',
        'var',
        'mark',
        'meter',
        'progress',
        'time'
    );
}
