<?php // die('!HTML Symlinked');
// * Version 1.2.2
require_once('htmlcleaner.php');
define('HTMLCLASSAVAILABLE', true);
class HTML extends HTMLCleaner {
	// Configuable Config
	public $baseUrl = './'; // Used to replace ./ in src & href
	public $store = 'static';
	public $tabs = 0; // Starting Count for Tabs
	private static $_tabs = 0; // Starting Count for Tabs
	// public $tab = "";
	public $tab = "\t";
	public $tabWorth = 8;
	// public $break = "";
	public $break = "\n";
	// public $noComments = true;
	public $noComments = false;
	public $jsCssCompress = true;
	public $magicUrl = true;
	public $disableParsing = false;
	public $maxLineWith = 130;
	public $minLineWith = 30;
	public $disable = false; // Fastest Posible returning if True
	// Configuable Config End
	
	// Intern Config
	
	// array of possible initiaton-arguments if 'arg' => 'static' the value will be assigned to static class var.
	private $_possibleInitArgs = array(
		'baseUrl' => '',
		'disableParsing' => '',
		'jsCssCompress' => '',
		'store' => '',
		'tabs' => '',
		'tab' => '',
		'tabWorth' => '',
		'break' => '',
		'noComments' => '',
		'magiUrl' => '',
		'maxLineWith' => '',
		'minLineWith' => '',
		'disable' => '',
	);
	
	// The first attr to use if Tag is called whith only a value
	private $_default_attr = 'class';
	private $_first_attr = array(
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
		'appleIcon' => 'href',
		'abbr' => 'title',
		'action' => 'value',
		'description' => 'content'
	);

	// if Tag is in Array the specified arguments will be copyed - see $this->_doubleAttrs();
	private $_doubleAttrs = array(
		'input' => array('id', 'name'),
		'checkbox' => array('id', 'name'),
		'select' => array('id', 'name'),
		'pw' => array('id', 'name'),
		'textarea' => array('id', 'name'),
		'hidden' => array('id', 'name'),
		'action' => array('id', 'name'),
		'img' => array('src', 'alt'),
	);
	
	// Defaut attr="value" pairs for specific Tags
	private $_presets = array(
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
		'jquery' => array(
			'type' => 'text/javascript',
			'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'
		),
		'jqueryui' => array(
			'type' => 'text/javascript',
			'src' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'
		),
		'rederect' => array(
			'http-equiv' => 'refresh',
		),
		'viewport' => array(
			'name' => 'viewport',
			'content' => 'width=device-width, initial-scale=1.0',
		),
		'appleIcon' => array(
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
	
	// Special Tags or Pseudo-Name-Tags
	private $_special_tags = array(
		'comment' => array(
			'start' => '<!-- ',
			'end' => ' -->',
			'close_start' => '',
			'close_short' => '',
			'close_end' => ''
		),
		'hidden' => 'input',
		'zw' => 'div',
		'favicon' => 'link',
		'clear' => 'br',
		'dclear' => 'div',
		'utf8' => 'meta',
		'jquery' => 'script',
		'jqueryui' => 'script',
		'pw' => 'input',
		'checkbox' => 'input',
		'css' => 'link',
		'less' => 'link',
		'rederect' => 'meta',
		'viewport' => 'meta',
		'appleIcon' => 'link',
		'action' => 'input',
		'description' => 'meta'
	);
	
	private $_bbs = array(
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
	
	private $_selfContainingTags = array(
		'checked',
		'multiple',
		'disabled',
		'required'
	);
	
	private $_tagOptionKeys = array(
		'r' => 'return',
		's' => 'start',
		'i' => 'inline',
		'g' => 'generate',
		'b' => 'bbContent',
		'p' => 'parseContent',
		'n' => 'noParseContent'
	);
	
	// INTERN Holders
	private $_tagstoend = array(); // Array of all Started Tags - used by $this->end();
	
	// The id or/and class of the current Tag - used for ending Comments and input-label linking
	private $_current_identifyer = array();
	
	// Current Tag Options
	private $_cTO = array();
		
	// Array for Content to be added to empty Tags - example: $this->set_inner_preset('title', 'Hello World');
	private $_inner_presets = array();
	
	private $_initialNoComments;
	private $_initialBreak;
	private $_initialTab;

		

		
	/** The Contructor - cann be called with init arguments
	 *
	 * @param mixed $init string or array possible values: url or see $this->_possibleInitArgs
	 * @return instance self
	 * @access public
	 * @date Nov 11th 2011
	 */
	public function __construct($init = array()) {
		$this->_initialNoComments = $this->noComments;
		$this->_initialBreak = $this->break;
		$this->_initialTab = $this->tab;

		$this->_unsetMagic();
		if(!is_array($init))
			$init = array('baseUrl' => $init);
		foreach($this->_possibleInitArgs as $arg => $opt) {
			if(isset($init[$arg])) {
				if($opt == 'static')
					self::$$arg = $init[$arg];
				else			
					$this->$arg = $init[$arg];
			}
		}
	}
	
	private function _is_shorttag($tag) {
		if(isset($this->_special_tags[$tag]) && is_string($this->_special_tags[$tag])) 
			$tag = $this->_special_tags[$tag];
		return in_array($tag, $this->_standaloneTags);
	}
	
	/** Getter for self::$baseUrl - checks for ending slash
	 *
	 * @return string the baseUrl
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _baseUrl() {
		return substr($this->baseUrl, strlen($this->baseUrl)-1, 1) != '/' ? $this->baseUrl.'/' : $this->baseUrl;
	}
	
	/** 
	 * Checkes the $this->_doubleAttrs; array for Tags that need dublicated args
	 * Example: You can call $HTML->input('id=foo'); and will get <input id="foo" name="foo" [...] />
	 *
	 * @access private
	 * @date   Sep 18th 2012
	 * @param  string $tag the tagname
	 * @param  array $attrs the attributes of tag
	 * @return array new attributes
	 */
	private function _doubleAttrs($tag, $attrs) {
		$opt = $this->_doubleAttrs;
		if(isset($opt[$tag])) {
			foreach (array(0 => 1, 1 => 0) as $k1 => $k2) {
				$attr1 = $opt[$tag][$k1];
				$attr2 = $opt[$tag][$k2];
				if (!isset($attrs[$attr1])
				 && isset($attrs[$attr2]))  {
					if ($attr2 == 'name' && $attr1 == 'id') {
						$attrs[$attr1] = preg_replace(
							'/[\[\]]/',
							'_',
							$attrs[$attr2]
						);
					} else {
						$attrs[$attr1] = $attrs[$attr2];
					}
				}
			}
		}
		return $attrs;
	}
	
	/** • Parses the attribute array to HTML formated string
	 *  • Sets $this->_current_identifyer; if class and/or id is found in attrs
	 *
	 * @param mixed $attrs shortstyle string or array of attrs
	 * @param string $tag the tagname
	 * @return string HTML formated attrs
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _parse_attrs($attrs, $tag) {
		$attrs = array_merge($this->_get_presets($tag), $this->_try_explode($attrs, $tag));
		$r = '';
		$this->_current_identifyer = array();
		$attrs = $this->_doubleAttrs($tag, $attrs);

		foreach($attrs as $key => $value) {
			if($this->magicUrl && ($key == 'href' || $key == 'src') && substr($value, 0, 2) == './')
				$value = str_replace('./', $this->_baseUrl(), $value);
			if($key == 'id')
				$this->_current_identifyer[$key] = $value;
			if($key == 'class')
				$this->_current_identifyer[$key] = substr($value, 0, (($pos = strpos($value, ' ')) !== false ? $pos : strlen($value)));
			if($key && $value === null) {
				continue;
			} elseif($key && strlen($value))
				$r .= ' '.$key.'="'.$this->_minibb($value).'"';
			elseif($key && $value === '') {
				if(in_array($key, $this->_selfContainingTags))
					$r .= ' '.$key.'="'.$key.'"';
				else
					$r .= ' '.$key.'=""';
			}
		}
		return $r;
	}
	
	/** replaces \| & \= to minibb tags
	 *
	 * @param string $string normaly the attr string
	 * @return string the replaced string
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _escapeEqu($string) {
		return str_replace('\\=', '[equ]', str_replace('\\|', '[pipe]', $string));
	}
	
	/** revers function for $this->_escapeEqu();
	 *
	 * @param string $string normaly the attr string
	 * @return string the replaced string
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _minibb($string) {
		return str_replace('[equ]', '=', str_replace('[pipe]', '|', $string));
	}
	
	/** Function to look for $this->_inner_presets if a tag is called without inner content
	 *
	 * @param string $tag the tagname
	 * @param string $string the inner content
	 * @return string
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _gen_inner($tag, $string) {
		$inner = '';
		if(!empty($string)) 
			$inner = $string;
		elseif(!empty($this->_inner_presets[$tag]))
			$inner = $this->_inner_presets[$tag];
		
		if(trim($string) == '') {
			$this->_set_onLineInner();
			return '';
		}
		
		if($tag != 'blank')
			$this->_set_onLineInner();
		
		if($this->jsCssCompress && ($tag == 'style' || $tag == 'script')) {
			$inner = $this->_css_min($inner);
		}
		
		if(isset($this->_cTO['bbContent']) && $this->_cTO['bbContent'] == true)
			$inner = $this->bb($inner);
				
		if(!$this->disableParsing && (strlen($string) > $this->_mLW() 
			&& isset($this->_cTO['noParseContent']) && $this->_cTO['noParseContent'] == false)
			|| (isset($this->_cTO['parseContent']) && $this->_cTO['parseContent'] == true)
		) {
			$r1 = '';
			$r2 = '';
			if(!$this->_cTO['inline']) {
				$r1 = $this->break.$this->get_tabs();
				$this->removeTab();
				$r2 = $this->break.$this->get_tabs();
				$this->addTab();
			}
			$inner = $r1.$this->get_clean($inner, $tag).$r2;
		} 
		// elseif($tag != 'pre') {
			// $inner = preg_replace('/\r\n|\r|\n|\t/', '', $inner);
		// }
			
			
		return $inner;
	}
		
	private function _css_min($inner) {
		foreach(array(
			' { ' => '{',
			'{ ' => '{',
			' }' => '}',
			'} ' => '}',
			': ' => ':',
			'; ' => ';',
			', ' => ',',
		) as $s => $r) {
			$inner = str_replace($s, $r, $inner);
		}
		return $inner;
	}
	
	private function _addToLast($c, $p, $glue = false) {
		
		end($c);
		$tc1 = $c[key($c)].$p;
		if(strlen($tc1) <= $this->_mLW()) {
			unset($c[key($c)]);
			$c[] = $tc1;
		} elseif($glue === false) {
			$c[] = $this->get_tabs().$p;
		} else {
			if($this->is_nTag($p)) {
				$ps = explode(' ', $p, 2);
				$tc1 = $c[key($c)].$ps[0];
				unset($c[key($c)]);
				$c[] = $tc1;
				if(isset($ps[1]))
					$c[] = $this->get_tabs().$ps[1];
			} else {
				unset($c[key($c)]);
				$c[] = $tc1;
			}
			
		}
		return $c;
	}

	
	private function _set_onLineInner() {
		end($this->_tagstoend);
		$this->_tagstoend[key($this->_tagstoend)]['noComment'] = true;
		$this->_tagstoend[key($this->_tagstoend)]['opts']['inline'] = true;
	}
	
	
	/** Parses a shortstyle attr string to attr array or returnes array if called whith array
	 *
	 * @param mixed $attrs shortstyle string or attr array
	 * @param string $tag the tagname
	 * @return array the attr array
	 * @param bool $force false to return the $attr string if it couldn't be exploded
	 * @access private
	 * @date Dez 15th 2011
	 */
	private function _try_explode($attrs, $tag = null, $force = true) {
		if($attrs === false) 
			return false; // NEEDED FOR LABEL DISABELING
		if(!$attrs)
			return array();
		if(is_array($attrs))
			return $attrs;
			
		
		$attrs = $this->_escapeEqu($attrs);
		
		if(count(($attrsex = explode('|', $attrs))) <= 1 && count(explode('=', $attrs)) <= 1) {
			if( substr( $attrs, 0, 1 ) == '#' )
				$r['id'] = substr( $attrs, 1, strlen( $attrs ) );
			elseif( substr( $attrs, 0, 1 ) == '.' && !in_array( substr( $attrs, 1, 1 ), array( '/', '\\' ) ) )
				$r['class'] = substr( $attrs, 1, strlen( $attrs ) );
			elseif(isset($this->_first_attr[$tag]))
				return array($this->_first_attr[$tag] => $attrs);
			elseif($force !== false)
				return array($this->_default_attr => $attrs);
			else
				return $attrs;
		}
		$r = array();
		foreach($attrsex as $attr) {
			$e = explode('=', $attr);
			if(count($e) == 2)
				$r[$e[0]] = $e[1];
			elseif(count($e) == 1) {
				if( substr( $e[0], 0, 1 ) == '#' ) {
					$r['id'] = substr( $e[0], 1, strlen( $attrs ) );
				} elseif( substr( $e[0], 0, 1 ) == '.' ) {
					$r['class'] = substr( $e[0], 1, strlen( $attrs ) );
				} else {
					$r[$e[0]] = null;
				}
			}
		}
		return $r;
	}
	
	/** gets the conten of $this->_presets; for the given tag or returnes empty array
	 *
	 * @param string $tag the tagname
	 * @return array the presets
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _get_presets($tag) {
		return (isset($this->_presets[$tag]) && is_array(($presets = $this->_presets[$tag]))) ? $presets : array();
	}
	
	/** checks for entry in $this->_special_tags; for the given tag and returns the bracket-array
	 *
	 * @param string $tag the tagname
	 * @param string $pos the key to be returned
	 * @return mixed the specified string or bracket array
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _check_special($tag, $pos = null) {
		$tt = isset($this->_special_tags[$tag]) && is_string($this->_special_tags[$tag]) ? $this->_special_tags[$tag] : $tag;
		$def_brackets = array(
			'start' => '<'.$tt, 
			'close_start' => '>',
			'close_short' => ' />',
			'end' => '</'.$tt,
			'close_end' => '>'	
		);
		if(isset($this->_special_tags[$tag]) && is_array($this->_special_tags[$tag])) {
			$def_brackets = array_merge($def_brackets, $this->_special_tags[$tag]);
		}
		return $pos != null ? $def_brackets[$pos] : $def_brackets;
	}
	
	/** checks for an ident key in given array and returnes the closing-comment if one is found
	 *
	 * @param array $arr the tag to be closed
	 * @return string comment or empty
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _get_identifyerComment($arr) {
		if($this->noComments == true || (isset($arr['noComment']) && $arr['noComment'] === true))
			return '';
		
		$check_not_empty = false;
		$r = '';
		foreach(array('id', 'class') as $key) {
			if(isset($arr['ident'][$key]) && $arr['ident'][$key] != '') {
				$check_not_empty = true;
				$r .= $this->ri_comment(($key == 'id' ? '#' : '.').$arr['ident'][$key]);
				break;
			}
		}
		return $check_not_empty ? $r : '';
	}
	
	/** generates a label tag array to be attached to inputs and selects via $this->_add_label();
	 *
	 * @param mixed $label a string with the label inner content or label array
	 * @return array the label array
	 * @date Nov 11th 2011
	 */
	private function _gen_label($label, $sep = '') {
		if($label !== false) {
			if(is_string($label))
				$label = array('inner' =>$label);
			$label = array_merge(array(
				'inner' => ucfirst(strtolower($this->_current_identifyer['id'])), 
				'pos' => 'before', 
				'sep' => $sep
			), $label);
			$label['label'] = $this->ri_label(
				$label['inner'], 
				'for='.$this->_current_identifyer['id']
			);
		}
		return $label;
	}
	
	private function _add_label($label, $string) {
		if(!$label['inner'])
			return $string;
		if($label['sep'] != '')
			$label['sep'] = $this->r_blank($label['sep']);
		if($label['pos'] == 'before')
			return $this->r_blank($label['label']).$this->_minibb($label['sep']).$string;
		else  {
			return $string.$this->_minibb($label['sep']).$this->r_blank($label['label']);
		}
	}
	
	/** Generates a normal tabbed tag with a break
	 *  Example: $this->_tag('div', 'foo', 'bar'); generates [tabs]&lt;div class="bar"&gt;foo&lt;/div&gt;[break]
	 *
	 * @param string $tag the tagname
	 * @param string $inner optional: the inner content
	 * @param mixed $attrs optional: shortstyle attr string or attr array
	 * @return string the tag
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _tag($tag, $inner = null, $attrs = null) {
		if($this->disable) return;
		if($tag == 'comment' && $this->noComments == true) return '';
				
		echo $this->get_tabs();
		call_user_func_array(array($this, 'ig_'.$tag), array($inner, $attrs));
		echo $this->break;
	}
	
	/** Generates a normal tag without tabs and break
	 *  Example: $this->_inline('div', 'foo', 'bar'); generates &lt;div class="bar"&gt;foo&lt;/div&gt;
	 *
	 * @param string $tag the tagname
	 * @param string $inner optional: the inner content
	 * @param mixed $attrs optional: shortstyle attr string or attr array
	 * @return string the tag
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _inline($tag, $inner = null, $attrs = null) {
		if($this->disable) return;
		if($tag == 'comment' && $this->noComments == true) return '';
		
		$attrs = $this->_is_shorttag($tag) ? $inner : $attrs;
		call_user_func(array($this, 'sig_'.$tag), $attrs);
		

		if(!$this->_is_shorttag($tag)) {
			echo $this->_gen_inner($tag, $inner);
			$this->end();
		}
	}
	
	/** Starts a normal tabbed tag with a break
	 *  Example: $this->_start_tag('div', 'foo'); generates [tabs]&lt;div class="foo"&gt;[break]
	 *
	 * @param string $tag the tagname
	 * @param mixed $attrs optional: shortstyle attr string or attr array
	 * @return string the tag
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _start_tag($tag, $attrs = null) {
		// var_dump('hi');
		if($this->disable) return;
		if($tag == 'comment' && $this->noComments == true) return '';
		
		$this->tabs();
		call_user_func_array(array($this, 'sig_'.$tag), array($attrs, false));
		echo $this->break;
	}
	
	/** Starts a normal tag without tabs and break
	 *  Example: $this->_start_inline('div', 'foo'); generates &lt;div class="foo"&gt;
	 *
	 * @param string $tag the tagname
	 * @param mixed $attrs optional: shortstyle attr string or attr array
	 * @return string the tag
	 * @access private
	 * @date Nov 11th 2011
	 */
	private function _start_inline($tag, $attrs = null, $inline = true) {
		// var_dump('hi');
		// $inline is used intern by start_tag
		if($this->disable) return;
		if($tag == 'comment' && $this->noComments == true) return '';
		
		if($this->_is_shorttag($tag)) {
			echo $this->_check_special($tag, 'start');
			echo $this->_parse_attrs($attrs, $tag);
			echo $this->_check_special($tag, 'close_short');
		} else {
			echo $this->_check_special($tag, 'start');
			echo $this->_parse_attrs($attrs, $tag);
			echo $this->_check_special($tag, 'close_start');
			$this->addTab();
			$this->_tagstoend[] = array('opts' => $this->_cTO, 'tag' => $tag, 'ident' => $this->_current_identifyer);
		}
	}
	
	/** 
	 * END PRIVATES
	 * START SETTERS 
	 */
	
	public function set_title($name) {
		$this->set_inner_preset('title', $name);
	}
	
	public function set_preset($tag, $key, $value) {
		$this->_presets[$tag][$key] = $value;
	}
	
	public function set_inner_preset($tag, $value) {
		$this->_inner_presets[$tag] = $value;
	}
	
	public function manipulate($key, $value) {
		if(isset($this->_possibleInitArgs[$key])) {
			if($this->_possibleInitArgs[$key] != 'static')
				$this->$key == $vale;
			else
				self::$$key = $value;
		}
	}
	
	/** returns the bbed string
	 *
	 * @param string $string a string containing [bb] tags
	 * @return strin a string with compiled bb
	 * @date Feb 13th 2012
	 */
	public function bb($string) {
		return preg_replace(array_flip($this->_bbs), $this->_bbs, $string);
	}

	/** Turn the ajax-mode on or off.
	 *  In ajax-mode there will be no comments, braks or tabs. only the minimal markup will be generated
	 *
	 * @param bool $flag true/false
	 * @return void
	 * @date Mrz 27th 2012
	 */
	public function ajaxMode( $flag ) {
		if( $flag === true ) {
			$this->noComments = true;
			$this->break = '';
			$this->tab = '';
		} elseif( $flag === false ) {
			$this->noComments = $this->_initialNoComments;
			$this->break = $this->_initialBreak;
			$this->tab = $this->_initialTab;
		}
	}
	
	/** 
	 * START TAG GENERATORS 
	 */
	
	
	/** Ends a started tag parameter can be:
	 *  • inager to close multible tags
	 *  • 'all' to close all open tags
	 *  • '#foo' to close all tags including the first with id="foo"
	 *  • '.bar' to close all tags including the first with class="bar" 
	 * 	  (this must be the first class if there are multiple ones)
	 * @param mixed $until see description
	 * @return object HTML
	 * @date Nov 11th 2011
	 */
	public function end( $until = null ) {
		if($this->disable) return;
		
		$r = '';
		if(is_int($until)) {
			$j = 0;
			while($until > $j) {
				$r .= $this->r_end(null);
				$j++;
			}
		} elseif($until == 'all') {
			while(count($this->_tagstoend) > 0) {
				$r .= $this->r_end(null);
			}
		} elseif($until !== null) {
			$doEnd = true;			
			while($doEnd) {
				end($this->_tagstoend);
				$lastTag = $this->_tagstoend[key($this->_tagstoend)];
				
				if($lastTag['tag'] == $until) {
					$doEnd = false;
				} elseif( substr($until, 0, 1) == '#' 
				 && isset($lastTag['ident']['id']) 
				 && $lastTag['ident']['id'] == substr($until, 1, strlen($until))
				) {
					$doEnd = false;
				} elseif( substr($until, 0, 1) == '.' 
				 && isset($lastTag['ident']['class']) 
				 && $lastTag['ident']['class'] == substr($until, 1, strlen($until))
				) {
					$doEnd = false;
				}
				$r .= $this->r_end(null);
			}
		} else {
			$this->removeTab();
			// echo('end Called; Tabs: '.$this->tabs);
			end($this->_tagstoend);
			$lastIndex = key($this->_tagstoend);
			if(isset($this->_tagstoend[$lastIndex])) {
				$lIndex = $this->_tagstoend[$lastIndex];
				if(!isset($lIndex['opts']['inline']))
					$this->_tagstoend[$lastIndex]['opts']['inline'] = false;
				$tag = $lIndex['tag'];
				// var_dump($this->_tagstoend[$lastIndex]);
				if(!isset($lIndex['opts']['inline']) || !$lIndex['opts']['inline']) {
					$this->tabs();
				}
				
				$r .= $this->_check_special($tag, 'end').
					$this->_check_special($tag, 'close_end');
				if(!isset($lIndex['opts']['inline']) || !$lIndex['opts']['inline'])
					$r .= $this->_get_identifyerComment($this->_tagstoend[$lastIndex]);
				$r .= $this->_tagstoend[$lastIndex]['opts']['inline'] ? '' : $this->break;
				unset($this->_tagstoend[$lastIndex]);
			}
		}
		echo $r;
		return $this;
	}
	
	/** echoes the current amount of Tabs
	 *
	 * @return object HTML
	 * @date Nov 11th 2011
	 */
	public function tabs() {
		if($this->disable) return;
		
		echo $this->get_tabs();
		return $this;
	}
	
	/** echoes a line break char
	 *
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function n() {
		if($this->disable) return;
		
		echo $this->break;
		return $this;
	}
	
	/** Build an input field
	 *
	 * @param string|array $attrs attributes of the input
     *        the id or name will be used for linking with the label
	 * @param string|array|false|null $label 
     *        string for label text
     *        for details: array('inner' => 'label text', 'pos' => 'before|after', 'sep' => '<br />')
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function input($attrs = null, $label = null) {
		if($this->disable) return;
		
		$label = $this->_try_explode($label, null, false);
		
		$input = $this->gr_input($attrs);
		echo $this->_add_label($this->_gen_label($label), $input);
		return $this;
	}
	
	/** Build an password input
	 *
	 * @param string|array $attrs attributes of the input
     *        the id or name will be used for linking with the label
	 * @param string|array|false|null $label 
     *        string for label text
     *        for details: array('inner' => 'label text', 'pos' => 'before|after', 'sep' => '<br />')
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function pw($attrs = null, $label = null) {
		if($this->disable) return;
		
		$label = $this->_try_explode($label, null, false);
		
		$input = $this->gr_pw($attrs);
		echo $this->_add_label($this->_gen_label($label), $input);
		return $this;
	}

    /** 
     * Build a Textarea with optional Label
     * 
	 * the label can be a string for label text or
     * for details: array('inner' => 'label text', 'pos' => 'before|after', 'sep' => '<br />')
	 * 
     * @param string $inner the content of the textbox
     * @param string|array $attrs attributes of the textbox
     *        the id or name will be used for linking with the label
     * @param string|array|false|null $label 
     *        
     * @return object HTML
     * @date Feb 13th 2012
     */
	public function textarea($inner, $attrs = null, $label = null) {
		if($this->disable) return;
		
		$label = $this->_try_explode($label, null, false);
		
		$textarea = $this->gr_textarea($inner, $attrs);
		echo $this->_add_label($this->_gen_label($label), $textarea);
		return $this;
	}
	
	/** wrapper for $HTML->checkbox() accepts an array('id/name' => 'Label')
	 *
	 * @param array $checkboxes an array of checkbox values
	 * @param mixed $checked flag, string or array. String and array will be
	 * 				checked against the name="" attribute.
	 * @return object HTML
	 * @access public
	 * @date Dez 15th 2011
	 */
	public function checkgroup($checkboxes, $checked = false) {
		foreach($checkboxes as $name => $label) {
			$this->checkbox($name, $label, $checked);
		}
		return $this;
	}
	
	/** generates a checkbox with optional Label and
	 *
	 * @param mixed $attrs shortstyle attr string or attr array
 	 * @param mixed $label string for label name or array with label options
	 * @param mixed $checked flag, string or array. String and array will be
	 * 				checked against the name="" attribute.
	 * @return object HTML
	 * @access public
	 * @date Dez 15th 2011
	 */
	public function checkbox($attrs, $label = array(), $checked = false) {
		if($this->disable) return;
		
		
		$label = $this->_try_explode($label, null, false);
		$attrs = $this->_try_explode($attrs, 'checkbox');
		if($checked == true
			|| (
				isset($attrs['id'])
				&& (
					(is_array($checked) && in_array($attrs['id'], $checked))
					||
					(is_string($checked) && $attrs['id'] == $checked)
					)
				)
		) {
			$attrs['checked'] = 'checked';
		}
			
		$r = $this->rg_checkbox($attrs);
		echo $this->_add_label($this->_gen_label($label), $r);
		return $this;
	}
	
	/** generates a select input with options and label
	 *
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @param array $options optional: array of options 
	 * 	Example: 
	 * 		array('foo' => 'bar'); generates <option value="bar">foo</option>
	 *  Example 2: 
	 *  	array( 'foo' => array( 'inner' => 'Lorem', 'attrs' => 'bar=dude|x=y' ) ) generates
	 *  	<option value="foo" bar="dude" x="y">Lorem</option>
	 * @param string $selected
	 * @param mixed $label string for label name or array with label options
	 * @return object HTML
	 * @access public
	 * @date Mrz 13th 2012
	 */
	public function select($attrs, $options = array(), $selected = null, $label = array()) {
		if($this->disable) return;

		$options = $this->_try_explode($options);
		$label = $this->_try_explode($label, null, false);
		
		$r = $this->rsg_select($attrs);
		
		$label = $this->_gen_label($label);
		foreach($options as $key => $option) {
			if( is_array($option) ) {
				$inner = $option['inner'];
				$attrs = $this->_try_explode($option['attrs'], 'option', true);
				if( !isset( $attrs['value'] ) ) {
					$attrs['value'] = $key;
				}
				if( $key == $selected ) {
					$attrs['selected'] = 'selected';
				}
			} else {
				$inner = $option;
				$attrs = $key == $selected ? 'value='.$key.'|selected=selected' : $key;
			}

			$r .= $this->r_option($inner, $attrs);
		}
		
		$r .= $this->r_end();
		echo $this->_add_label($label, $r);
		return $this;
	}
	
	/** builds a code block, usualy with a <pre> tag
	 *
	 * @param string $inner the inner code
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @param string $tag the tagname to be used. Default: pre
	 * @return object HTML
	 * @access public
	 * @date Feb 13th 2012
	 */
	public function code($inner, $attrs = null, $tag = 'pre') {
		call_user_func_array(array($this, 'n_'.$tag), array(htmlspecialchars($inner), $attrs));
		return $this;
	}
	
	/** builds an unsorted list
	 *
	 * @param array $lis an array of list elements array('inner' => 'attrs')
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function ul($lis, $attrs = null) {
		
		if($this->disable) return;
		
		$r = $this->sg_ul($attrs);
		foreach($lis as $inner2 => $attrs) {
			if( is_int( $inner2 ) ) {
				if( is_string( $attrs ) ) {
					$inner = $attrs;
					$attrs = null;
				} elseif( is_array( $attrs ) && isset( $attrs['inner'] ) && isset( $attrs['attrs'] ) ) {
					$inner = $attrs['inner'];
					$attrs = $attrs['attrs'];
				}
			}
			$this->li($inner, $attrs);
		}
		$this->end();
		return $this;
	}
	
	/** builds a sorted list
	 *
	 * @param array $lis an array of list elements array('inner' => 'attrs')
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function ol($lis, $attrs = null) {
		if($this->disable) return;
		
		$r = $this->sg_ol($attrs);
		foreach($lis as $inner => $attrs) {
			$inner = is_int($inner) ? $attrs : $inner;
			$attrs = is_int($inner) ? null : $attrs;
			$this->li($inner, $attrs);
		}
		$this->end();
		return $this;
	}
	

	public function XHTML($headattrs = null) {
		if($this->disable) return;
		
		echo '<?xml version="1.0" ?>'.$this->break;
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"';
		echo $this->break.$this->tab;
   		echo '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.$this->break;
		$this->s_html('xmlns=http://www.w3.org/1999/xhtml|class=no-js'.$this->ieClass(' '));
		$this->s_head($headattrs);
		return $this;
	}
	
	public function HTML5($headattrs = null) {
		if($this->disable) return;

		$htmlattrs = array('class' => 'no-js'.$this->ieClass(' ').$this->browserClass(' '));
		if(is_array($headattrs) && isset($headattrs['html'])) {
			$htmlattrs = array_merge(
				$htmlattrs,
				$this->_try_explode($headattrs['html'], 'html')
			);
		}
		
		$headattrs = array();
		$headattrsAdd = is_array($headattrs) && isset($headattrs['head']) ?
			$headattrs['head'] : $headattrs;

		$headattrs = array_merge(
			$headattrs,
			$this->_try_explode($headattrs, 'head')
		);
		

		echo '<!DOCTYPE HTML>'.$this->break;

		$this->s_html($htmlattrs)
			->s_head($headattrs)
			->utf8()
			->meta('http-equiv=X-UA-Compatible|content=IE\=edge,chrome\=1');
		return $this;
	}	
	
	public function ieClass($before = '') {
		$sIeClass = '';
		if( class_exists( 'Xiphe\THEMASTER\THETOOLS' ) ) {
			if(Xiphe\THEMASTER\THETOOLS::is_browser('ie')) {
				if(Xiphe\THEMASTER\THETOOLS::is_browser('ie6x')) {
					$sIeClass = $before.'lt-ie10 lt-ie9 lt-ie8 lt-ie7';
				} elseif(Xiphe\THEMASTER\THETOOLS::is_browser('ie7x')) {
					$sIeClass = $before.'lt-ie10 lt-ie9 lt-ie8';
				} elseif(Xiphe\THEMASTER\THETOOLS::is_browser('ie8x')) {
					$sIeClass = $before.'lt-ie10 lt-ie9';
				} elseif(Xiphe\THEMASTER\THETOOLS::is_browser('ie9x')) {
					$sIeClass = $before.'lt-ie10';
				}
			}
		}
		return $sIeClass;
	}
	
	public function browserClass($before = '') {
		if (class_exists('Xiphe\THEMASTER\THETOOLS')) {
			$browser = str_replace(' ', '_', strtolower(Xiphe\THEMASTER\THETOOLS::get_browser()));
			$version = str_replace('.', '-', Xiphe\THEMASTER\THETOOLS::get_browserVersion());
			$engine = strtolower(Xiphe\THEMASTER\THETOOLS::get_layoutEngine());
			if (!empty($engine)) {
				$engine .=' ';
			}

			return "$before$engine$browser $browser-$version";
		}
		return '';
	}

	/** alias for $this->script()
	 *
	 * @param string $inner the inner javascript text
	 * @param string|array $attrs shortstyle attr string or attr array
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function js($inner, $attrs = null) {
		$this->script($inner, $attrs);
		return $this;
	}
	
	/** builds a script tag.
	 *  if the inner content starts with "ht", "./" or ".." it will be handled as
	 *  the src value and there will be no inner content
	 *
	 * @param string $inner inner content or src url
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function script($inner, $attrs = null) {
		if($this->disable) return;
		
		if(!isset($attrs) && in_array(substr($inner, 0, 2), array('./', 'ht', '..'))) {
			$attrs = $inner;	
			$inner = '';
		}
		
		$this->g_script($inner, $attrs);
		return $this;
	}
	
	/** no tags just tabs and breaks
	 *
	 * @param string $inner the content
	 * @return object HTML
	 * @date Feb 13th 2012
	 */
	public function blank($inner = null) {
		if($this->disable) return;
		
		$this->_cTO['inline'] = true;
		if(trim($inner) != '') {
			echo $this->get_tabs();
			echo trim($this->_gen_inner('blank', $inner));
		}
		echo $this->break;
		return $this;
	}

	public function to_get(array $arr) {
		$r = array();
		foreach($arr as $key => $value) {
			$r[] = $key.'\='.$value;
		}
		return implode('&', $r);
	}
	
	public function escape_mBB($string) {
		return str_replace('=', '\=', str_replace('|', '\|', $string));
	}
	public function esc($string) {
		return str_replace('=', '\=', str_replace('|', '\|', $string));
	}

	public function merge_attrs($attrs1, $attrs2)
	{
		$attrs = array();
		foreach (func_get_args() as $fargs) {
			$newAttrs = $this->_try_explode($fargs);
			if (isset($attrs['class']) && isset($newAttrs['class'])) {
				$attrs['class'] = $this->merge_classes($attrs['class'], $newAttrs['class']);
				unset($newAttrs['class']);
			}
			if (isset($attrs['style']) && isset($newAttrs['style'])) {
				$attrs['style'] = $this->merge_styles($attrs['style'], $newAttrs['style']);
				unset($newAttrs['style']);
			}
			$attrs = array_merge($attrs, $newAttrs);
		}
		return $attrs;
	}
	
	public function merge_classes($a, $b)
	{
		$a = explode(' ', $a);
		foreach (explode(' ', $b) as $cls) {
			if (!in_array($cls, $a)) {
				$a[] = $cls;
			}
		}
		return implode(' ', $a);
	}

	public function merge_styles($a, $b) {
		$a = explode(';', $a);
		$amap = array();
		$gk = function($s) {
			return trim(substr($s, 0, strpos($s, ':')));
		};
		foreach ($a as $k => $v) {
			if(empty($v)) {
				continue;
			}
			$a[$k] = trim($v);
			$amap[$gk($v)] = $k;
		}

		foreach (explode(';', $b) as $st) {
			if(empty($v)) {
				continue;
			}
			if (isset($amap[$gk($st)])) {
				unset($a[$amap[$gk($st)]]);
			}
			$a[] = trim($st);
		}
		return implode(';', $a);
	}

	/** testing
	 *
	 * @param __mixed__ $__foo__ __description__
	 * @return __void__ __description__
	 * @date Feb 13th 2012
	 */
	public function __call($method, $args) {
		// var_dump($method);
		// $this->i++;
		// if($this->i >= 3) die(); 
		
				
		$e = explode('_', $method);
		if($e[0] == '')
			return false;
		else {
			$tagOpts = '';
			if(count($e) == 1) 
				$method = $e[0];
			else {
				$tagOpts = $e[0];
				$method = $e[1];
			}
			foreach($this->_tagOptionKeys as $key => $value) {
				if(strstr($tagOpts, $key))
					$opts[$value] = true;
				else {
					$opts[$value] = null;
				}
			}
			if(!strstr($tagOpts, 'g')) {
				$this->_cTO = $opts;
			}
			
			if($opts['return']) {
				ob_start();
			}
			
			if($opts['generate'] || !method_exists($this, $method)) {
				$tag = $method;
				$method = $opts['start'] ? '_start' : '';
				$method .= $opts['inline'] ? '_inline' : '_tag';
				call_user_func_array(array($this, $method), array_merge(array($tag), $args));
			} else
				call_user_func_array(array($this, $method), $args);
			
			if($opts['return']) {
				return ob_get_clean();
			}
			return $this;
		}
	}
	
	public function listen() {
		ob_start();
		return $this;
	}
	
	public function print_nice() {
		$this->clean(ob_get_clean());
		return $this;
	}
	

}
?>