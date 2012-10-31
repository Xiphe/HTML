<?php

namespace Xiphe\HTML\core;

class TagInfo {

// The first attr to use if Tag is called whith only a value
	public static $defaultSingleAttrkey = 'class';
	public static $singleAttrkeys = array(
		'a' => 'href',
		'img' => 'src',
		'link' => 'href',
		'css' => 'href',
		'less' => 'href',
		'script' => 'src',
		'input' => 'name',
		'checkbox' => 'id',
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

	public static $defaultOptions = array(
		'pre' => array(
			'doNotCleanContent',
			'inlineInner'
		)
	);

	// if Tag is in Array the specified arguments will be copyed - see $this->_doubleAttrs();
	public static $doublAattrs = array(
		'input' => array('id', 'name'),
		'checkbox' => array('id', 'name'),
		'select' => array('id', 'name'),
		'pw' => array('id', 'name'),
		'textarea' => array('id', 'name'),
		'hidden' => array('id', 'name'),
		'action' => array('id', 'name'),
		'img' => array('src', 'alt', '%callback' => array('Xiphe\HTML\core\Generator', 'magicAlt')),
	);
	
	// Defaut attr="value" pairs for specific Tags
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
		'pw' => array(
			'type' => 'password'	
		),
		'hidden' => array(
			'type' => 'hidden',
			'name' => 'action'
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
	
	public static $defaultBrackets = array(
		'start' => '<:name',
		'end' => '</:name',
		'close_start' => '>',
		'close_short' => ' />',
		'close_end' => '>'
	);

	// Special Tags or Pseudo-Name-Tags
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
		'css' => 'link',
		'less' => 'link',
		'rederect' => 'meta',
		'viewport' => 'meta',
		'appleicon' => 'link',
		'action' => 'input',
		'description' => 'meta'
	);
	
	public static $bbs = array(
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
	
	public static $attrKeyAliases = array(
		'.' => 'class',
		'#' => 'id',
		'%' => 'href',
		'?' => 'src',
		'}' => 'style',
		'~' => '%default'
	);

	public static $ignoreAlisasesOnSingle = array(
		'src' => array('.', '?'),
		'href' => array('.', '#', '?')
	);

	public static $magicUrlAttributes = array(
		'src', 'href'
	);

	public static $selfClosing = array(
		-100 =>'script',
		0 => 'area',
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
?>