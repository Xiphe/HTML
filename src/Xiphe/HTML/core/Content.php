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

    public static $MarkdownParser = null;

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
        if (!empty($Tag->content) && $Tag->hasOption('translate') && is_callable(Config::get('translator'))) {
            $Tag->content = call_user_func_array(
                Config::get('translator'),
                array(
                    $Tag->content,
                    Config::get('textdomain')
                )
            );
        }
        
        if ($Tag->hasOption('bbContent')) {
            self::bb($Tag->content);
        }

        if ($Tag->hasOption('markdown')) {
            $Tag->addOption('cleanContent');
            self::markdown($Tag->content);
        }

        if ($Tag->hasOption('compress')) {
            self::compress($Tag);
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
        if (self::$MarkdownParser === null) {
            if (class_exists('dflydev\markdown\MarkdownParser')) {
                self::$MarkdownParser = new \dflydev\markdown\MarkdownParser;
            } else {
                self::$MarkdownParser = false;
            }
        }

        if (self::$MarkdownParser !== false) {
            $content = trim(self::$MarkdownParser->transformMarkdown($content));
        }

        return $content;
    }

    /**
     * Compresses the tags content for inline js and css
     *
     * Main Logic: [Fat-Free Framework](https://github.com/bcosca/fatfree)
     * Distributed under the GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007
     *
     * Original here: https://github.com/bcosca/fatfree/blob/918eb1048742cf8780c6e3d61f3d1ea066d9fb73/lib/web.php#L464
     * 
     * @param string &$content the tags content.
     *
     * @return string the tags content.
     */
    public static function compress(Tag &$Tag) {
        $src = $Tag->content;
        $ext = ($Tag->realName === 'script' ? 'js' : 'css');
        $dst = '';
        for ($ptr=0,$len=strlen($src);$ptr<$len;) {
            if ($src[$ptr]=='/') {
                if (substr($src,$ptr+1,2)=='*@') {
                    // Conditional block
                    $str=strstr(
                        substr($src,$ptr+3),'@*/',TRUE);
                    $dst.='/*@'.$str.$src[$ptr].'@*/';
                    $ptr+=strlen($str)+6;
                }
                elseif ($src[$ptr+1]=='*') {
                    // Multiline comment
                    $str=strstr(
                        substr($src,$ptr+2),'*/',TRUE);
                    $ptr+=strlen($str)+4;
                }
                elseif ($src[$ptr+1]=='/') {
                    // Single-line comment
                    $str=strstr(
                        substr($src,$ptr+2),"\n",TRUE);
                    $ptr+=strlen($str)+2;
                }
                else {
                    // Presume it's a regex pattern
                    $regex=TRUE;
                    // Backtrack and validate
                    for ($ofs=$ptr;$ofs;$ofs--) {
                        // Pattern should be preceded by
                        // open parenthesis, colon,
                        // object property or operator
                        if (preg_match(
                            '/(return|[(:=!+\-*&|])$/',
                            substr($src,0,$ofs))) {
                            $dst.='/';
                            $ptr++;
                            while ($ptr<$len) {
                                $dst.=$src[$ptr];
                                $ptr++;
                                if ($src[$ptr-1]=='\\') {
                                    $dst.=$src[$ptr];
                                    $ptr++;
                                }
                                elseif ($src[$ptr-1]=='/')
                                    break;
                            }
                            break;
                        }
                        elseif (!ctype_space($src[$ofs-1])) {
                            // Not a regex pattern
                            $regex=FALSE;
                            break;
                        }
                    }
                    if (!$regex) {
                        // Division operator
                        $dst.=$src[$ptr];
                        $ptr++;
                    }
                }
                continue;
            }
            if (in_array($src[$ptr],array('\'','"'))) {
                $match=$src[$ptr];
                $dst.=$match;
                $ptr++;
                // String literal
                while ($ptr<$len) {
                    $dst.=$src[$ptr];
                    $ptr++;
                    if ($src[$ptr-1]=='\\') {
                        $dst.=$src[$ptr];
                        $ptr++;
                    }
                    elseif ($src[$ptr-1]==$match)
                        break;
                }
                continue;
            }
            if (ctype_space($src[$ptr])) {
                if ($ptr+1<strlen($src) &&
                    preg_match('/([\w'.($ext[0]=='css'?
                        '#\.+\-*()\[\]':'\$').']){2}/',
                        substr($dst,-1).$src[$ptr+1]))
                    $dst.=' ';
                $ptr++;
                continue;
            }
            $dst.=$src[$ptr];
            $ptr++;
        }
        $Tag->content = $dst;
    } 
}