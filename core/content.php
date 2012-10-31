<?php

namespace Xiphe\HTML\core;

class Content {

	private static $_bbs = array(
		'/\*\*(.*)\*\*/Usi' => '<strong>$1</strong>',
		'/([^:]+)\/\/(.*)([^:]+)\/\//Usi' => '$1<em>$2$3</em>', // TODO: FIX
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


	public static function parse(&$Tag)
	{
		if (in_array('bbContent', $Tag->options)) {
			self::bb($Tag->content);
		}

		if (in_array('markdown', $Tag->options)) {
			$Tag->add_option('cleanContent');
			self::markdown($Tag->content);
		}

		if ($Tag->realName == 'style' && in_array('compressCss', $Tag->options)) {
			self::compressCSS($Tag->content);
		}

		if ($Tag->realName == 'script' && in_array('compressCss', $Tag->options)) {
			self::compressCSS($Tag->content);
		}

		if (!is_string($Tag->content)) {
			var_dump($Tag);
			die('%%nostring');
		}

		return $Tag->content;
	}

	public static function bb(&$content)
	{
		$content = preg_replace(array_flip(self::$_bbs), self::$_bbs, $content);
		return $content;
	}

	public static function markdown(&$content)
	{
		require_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'PHPMarkdown'.DIRECTORY_SEPARATOR.'markdown.php');
		$content = trim(\Markdown($content));
		return $content;
	}


	public static function compressCSS(&$content)
	{
		// remove comments
	    $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
	    // remove tabs, spaces, newlines, etc.
	    $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
	    return $content;
	}
}
?>