<?php
/**
 * Content class file
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML/blob/master/core/Content.php
 */

namespace Xiphe\HTML\core;

/**
 * Content class
 *
 * @category Markup
 * @package  Xiphe\HTML
 * @author   Hannes Diercks <xiphe@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE
 * @link     https://github.com/Xiphe/-HTML
 */
class Content
{
    /**
     * Self-made, BB-Code'ish replacements
     *
     * @deprecated in favor of markdown.
     * @var array
     */
    private static $_bbs = array(
        '/\*\*(.*)\*\*/Usi' => '<strong>$1</strong>',
        '/([^:]+)\/\/(.*)([^:]+)\/\//Usi' => '$1<em>$2$3</em>',
        '/__(.*)__/Usi' => '<span class="underline">$1</span>',
        '/•••(.*)•••/Usi' => '<ul>•$1•</ul>',
        '/\|\|\|(.*)\|\|\|/Usi' => '<ol>•$1•</ol>',
        '/•(.*)•/Usi' => '<li>$1</li>',
        '/\[h1\](.*)\[h1\]/Usi' => '<h1>$1</h1>',
        '/\[h2\](.*)\[h2\]/Usi' => '<h2>$1</h2>',
        '/\[h3\](.*)\[h3\]/Usi' => '<h3>$1</h3>',
        '/\[h4\](.*)\[h4\]/Usi' => '<h4>$1</h4>',
        '/\[h5\](.*)\[h5\]/Usi' => '<h5>$1</h5>',
        '/\[h6\](.*)\[h6\]/Usi' => '<h6>$1</h6>',
        '/\[s\](.*)\[s\]/Usi' => '<small>$1</small>',
        '#\/\|\|#' => '<br />'
    );

    /**
     * Checks if any parsing method should be appended to the
     * Tags content.
     *
     * @param Tag &$Tag a Tag instance.
     *
     * @return string the tags content.
     */
    public static function parse(Tag &$Tag)
    {
        if ($Tag->hasOption('bbContent')) {
            self::bb($Tag->content);
        }

        if ($Tag->hasOption('markdown')) {
            $Tag->addOption('cleanContent');
            self::markdown($Tag->content);
        }

        if ($Tag->hasOption('compress')) {
            self::compress($Tag->content);
        }

        return $Tag->content;
    }

    /**
     * Appends the BB replacements to the tags content.
     *
     * @param string &$content the tags content.
     *
     * @return string the tags content.
     */
    public static function bb(&$content)
    {
        $content = preg_replace(array_flip(self::$_bbs), self::$_bbs, $content);

        return $content;
    }

    /**
     * Appends markdown to the tags content.
     *
     * @param string &$content the tags content.
     *
     * @return string the tags content.
     */
    public static function markdown(&$content)
    {
        if (!function_exists('Markdown')) {
            include XIPHE_HTML_LIB_FOLDER.'PHPMarkdown'.DIRECTORY_SEPARATOR.'markdown.php';
        }

        $content = trim(\Markdown($content));

        return $content;
    }

    /**
     * Compresses the tags content by removing comments and
     * justifying tabs, line breaks etcetera into spaces.
     *
     * @param string &$content the tags content.
     *
     * @return string the tags content.
     */
    public static function compress(&$content)
    {
        // remove comments
        $content = preg_replace('/\/\/.*[\r\n\n\r]/', '', $content);
        $content = preg_replace('/\/\*[^*]*\*+([^\/][^*]*\*+)*\//', '', $content);
        // remove tabs, spaces, newlines, etc.
        $content = preg_replace('/[\r\n\r\n\t\s]+/', ' ', $content);
        $content = preg_replace('/\s?([\{\}\(\);:])\s?/', '$1', $content);

        $content = trim($content);

        return $content;
    }
}
