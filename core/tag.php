<?php

namespace Xiphe\HTML\core;

class Tag {

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

	public function has_option($option)
	{
		return in_array($option, $this->options);
	}

	public function add_option($option)
	{
		if (in_array($option, Generator::$tagOptionKeys)
		 && !$this->has_option($option)
		) {
			$this->options[] = $option;
		}
	}

	public function remove_option($option)
	{
		if ($this->has_option($option)) {
			$key = array_search($option, $this->options);
			unset($this->options[$key]);
		}
	}

	/**
	 * Constructor method
	 * 
	 * @param string $name the tags name
	 * @param array  $args additional arguments
	 */
	public function __construct($name, $args = array(), $options = array())
	{
		/*
		 * Store initiation arguments.
		 */
		$this->ID = Store::get_newID();
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
		if ($this->is_selfclosing() || $this->has_option('start')) {
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
		Generator::add_defaultOptions($this);

		if ((empty($this->content) && !$this->has_option('start'))
		 || $this->has_option('inlineInner')
		) {
			$this->inlineInner = true;
		}

		/*
		 * Parse the attributes
		 */
		$this->attributes = Generator::parse_atts($this);

		/*
		 * Add Defaults
		 */
		Generator::add_defaultAttributes($this);


		/*
		 * Add potential doubled attributes
		 */
		Generator::add_doubleAttributes($this);

		$this->update();
		$this->update('content');
	}

	/**
	 * Updates class variables.
	 * 
	 * @param  string $what set to just update a specific part of the tag
	 * @return void
	 */
	public function update($what = 'all')
	{
		/*
		 * Generate Class array.
		 */
		if ($what == 'all' || $what == 'classes') {
			Generator::update_classes($this);
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
			if ($this->has_option('inlineInner') || ($this->name !== 'blank'
			 && !$this->has_option('forbidInlineInner')
			 && !$this->is_selfClosing()
			 && !$this->has_option('start')
			 && strlen($this->content) < Config::get('maxLineWidth')
			 && !preg_match('/\r\n|\n|\r/', $this->content)
			)) {
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

	public function set_attrs($attrs)
	{
		$oldAttrs = $this->attributes;
		$oldClasses = $this->classes;

		$this->attributes = $attrs;
		$this->attributes = Generator::parse_atts($this);

		$this->attributes = array_merge($oldAttrs, $this->attributes);
		$this->classes = null;
		$this->update('classes');

		if (!empty($oldClasses) && !empty($this->classes)) {
			$this->attributes['class'] = implode(' ' , array_merge($oldClasses, $this->classes));
		}
		$this->classes = null;

		if (!empty($oldAttrs['style']) && !empty($this->attributes['style'])) {
			$this->attributes['style'] = Generator::merge_styles($this->attributes['style'], $oldAttrs['style']);
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

	public function is_selfclosing()
	{
		if (isset($this->selfclosing)) {
			return (bool) $this->selfclosing;
		}
		if ($this->has_option('selfQlose')) {
			$this->selfclosing = true;
			return true;
		} elseif($this->has_option('doNotSelfQlose')) {
			$this->selfclosing = false;
			return false;
		}
		return in_array($this->realName, TagInfo::$selfClosing);
	}

	private function _openStart()
	{
		if ($this->name === 'blank') { return; }

		/*
		 * Store it.
		 */
		Store::add($this);

		if (!$this->has_option('inline')) {
			Generator::tabs();
		}
		echo str_replace(':name', $this->realName, $this->brackets['start']);
	}

	private function _closeStart()
	{
		if ($this->name === 'blank') { return; }

		if ($this->is_selfclosing()) {
			echo str_replace(':name', $this->realName, $this->brackets['close_short']);
			$this->_closed = true;
			$this->destroy();
			if (!$this->has_option('inline')) {
				Generator::lineBreak();
			}
			$this->_contentPrinted = true;
		} else {
			echo str_replace(':name', $this->realName, $this->brackets['close_start']);
			if (!$this->inlineInner && !$this->has_option('inline')) {
				Config::set('tabs', '++');
				Generator::lineBreak();
			}
		}
	}

	private function _openEnd()
	{
		if ($this->name === 'blank') { return; }

		if (!$this->inlineInner) {
			if ($this->name !== 'blank' && !$this->has_option('inline')) {
				Config::set('tabs', '--');
			}
			Generator::tabs();
		}
		echo str_replace(':name', $this->realName, $this->brackets['end']);
	}

	private function _closeEnd()
	{
		if ($this->name === 'blank') { return; }

		echo str_replace(':name', $this->realName, $this->brackets['close_end']);
		if (!$this->has_option('inline')) {
			if (!$this->inlineInner) {
				$this->closingComment();
			}
			if ($this->name !== 'blank') {
				Generator::lineBreak();
			}
		}
	}

	public function closingComment()
	{
		if (!empty($this->attributes['id'])) {
			$hint = '#'.$this->attributes['id'];
		} elseif(!empty($this->classes)) {
			$hint = '.'.$this->classes[0];
		} else {
			return false;
		}
		Generator::call('il_comment', array($hint));
	}

	public function hasClass($class)
	{
		return in_array($class, $this->classes);
	}

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

	public function content()
	{
		if (!$this->_contentPrinted) {
			if (!$this->inlineInner) {
				Generator::tabs();
			}
			
			if ($this->has_option('cleanContent')
			|| (Config::get('clean') && !$this->has_option('doNotCleanContent'))
			) {
				echo trim(Cleaner::get_clean($this->content));
			} else {
				echo $this->content;
			}

			if (!$this->inlineInner) {
				Generator::lineBreak();
			}
			$this->_contentPrinted = true;
		}
	}

	public function close()
	{
		if (!$this->_closed) {
			$this->_openEnd();
			$this->_closeEnd();
			$this->destroy();
			$this->_closed = true;
		}
	}

	public function wasOpened()
	{
		return $this->_opened;
	}

	public function __tostring()
	{
		ob_start();
		$close = $this->_opened;
		$this->open();
		if (!in_array('start', $this->options)) {
			$this->content();
		}
		if (!$this->has_option('start') || $close) {
			$this->close();
		}
		return ob_get_clean();
	}
}