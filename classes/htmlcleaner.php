<?php 
// Version 1.0.1
// TODO: Clean this string:
// <li id="rb_92" class="rb_listentry rb_artist_listentry"><span class="rb_drag_handler" title="Drag here to move this Artist.">&nbsp;</span><span class="rb_list-title">Hannes Diem</span><span class="alignright rb_showhover"><a href="http://test.red-thorn.de/wunderkind/cms/wp-admin/post.php?post=92&action=edit" title="Edit Artist">Bearbeiten</a><a href="http://test.red-thorn.de/wunderkind/cms/wp-admin/post.php?post=37&action=edit&rb_artist_action=hide&rb_artist_id=92&rb_artist__nonce=5829adefb4" title="Hide this Artist on this side of the relation.">Verstecken</a><a class="rb_submitdelete" href="http://test.red-thorn.de/wunderkind/cms/wp-admin/post.php?post=37&action=edit&rb_artist_action=release&rb_artist_id=92&rb_artist__nonce=3902d2e91c" title="Delete the relation between this Artist and Testalbum (The elements itself will not be deleted).">Release</a></span><!-- .alignright --></li>

class HTMLCleaner {
	public $store = 'static';
	public $tabs = 0; // Starting Count for Tabs
	private static $_tabs = 0; // Starting Count for Tabs
	public $tab = "\t";
	public $tabWorth = 8;
	public $break = "\n";
	public $noComments = false;
	public $maxLineWith = 130;
	public $minLineWith = 30;
	public $commentParsedParts = false;

	protected $_standaloneTags = array(
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

	protected $_inlineTags = array(
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
		'script',
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
		'time',
	);

	private $_html = '';
	private $_currentPart = false;
	private $_lastString = false;
	private $_nextString = null;
	private $_currentString = null;
	private $_currentFirstChar = null;
	private $_currentLastChar = null;
	private $_lastChar = false;
	private $_nextChar = null;
	private $_lastTag = null;
	private $_tree = array();
	private $_return = array();
	private $_key = 0;
	private $_tagsToEnd = array();
	
	private function _checkPart($part) {
		if($this->isTag($part)) {
			$this->_lastTag = $part;
			if($this->isStartTag($part)) {
				// var_dump($part);
				$r = array('name' => $this->get_tagName($part));
				preg_match('/id=["|\']([^"|\']+)["|\'].*/', $part, $ident);
				if(isset($ident[1]))
					$r['ident'] = '#'.$ident[1];
				else {
					preg_match('/class=["|\']([^"|\'|\s]+)["|\'|\s].*/', $part, $ident);
					if(isset($ident[1]))
						$r['ident'] = '.'.$ident[1];
				}
				$this->_tagsToEnd[] = $r;
			}
			
			if(isset($this->_currentString)) {
				$this->_lastString = $this->_currentString;
				$this->_lastChar = $this->_currentLastChar;
			}
			if(!$this->_nextString)
				$this->_setNextString();
			return;
		}
		$this->_lastString = $this->_currentString;
		$this->_lastChar = $this->_currentLastChar;
		
		$this->_currentString = $part;
		$this->_currentFirstChar = substr($part, strlen($part)-1, 1);
		$this->_currentLastChar = substr($part, strlen($part)-1, 1);
		
		$this->_setNextString();
	}

	private function _setNextString() {
		if($this->_nextChar === false)
			return;
		for ($i=$this->_key+1; $i < count($this->_tree); $i++) {
			if($this->isNoTag(($t = $this->_tree[$i][0]))) {
				$this->_nextString = $t;
				$this->_nextChar = substr($t, 0, 1);
				return;
			}
		}
		$this->_nextChar = false;
		$this->_nextString = false;
	}
	
	private function _currentTag() {
		if(count($this->_tagsToEnd) <= 0)
			return '';
		end($this->_tagsToEnd);
		return $this->_tagsToEnd[key($this->_tagsToEnd)]['name'];
	}
	
	private function _reset() {
		$this->_html = '';
		$this->_currentPart = false;
		$this->_lastString = false;
		$this->_nextString = null;
		$this->_currentString = null;
		$this->_currentFirstChar = null;
		$this->_currentLastChar = null;
		$this->_lastChar = false;
		$this->_nextChar = null;
		$this->_lastTag = null;
		$this->_tree = array();
		$this->_return = array();
		$this->_key = 0;	
	}
	
	private function _block() {
		$this->_currentString = false;
		$this->_currentFirstChar = false;
		$this->_currentLastChar = false;
	}
	
	private function _prevLine() {
		end($this->_return);
		return isset($this->_return[($k = key($this->_return))]) ? $this->_return[$k] : false;
	}
	
	private function _addToPrevLine($string) {
		end($this->_return);
		if(isset($this->_return[($k = key($this->_return))]))
			$this->_return[($k = key($this->_return))] = $this->_return[$k].$string;
		else 
			$this->_return[] = $string;
	}
	
	private function _breakPart($part) {
		// $delm = in_array($this->currentTag, array('style', 'script')) ? '}' : ' '; // TODO
		$delm = ' ';
		
		$r = '';
		while(strlen($part) > $this->_mLW()) {
			$breakPos = strrpos(substr($part, 0, $this->_mLW()), $delm)+1;
			if(!$breakPos || $breakPos == 1)
				$breakPos = strpos($part, $delm)+1;
			if(!$breakPos) break;
			
			$r .= $this->get_tabs().substr($part, 0, $breakPos).$this->break;
			
			$part = substr($part, $breakPos, strlen($part));
		}
		$r .= $this->get_tabs().substr($part, 0, $breakPos);
		return trim($r);
	}
	
	
	private function _pushLast($part) {
		if(strlen($part)+strlen($this->_prevLine()) < $this->_mLW())
			$this->_addToPrevLine($part);
		else
			$this->_return[] = $this->get_tabs().$part;
	}
	
	private function _spaceWrapCount() {
		return strlen(trim($this->_lastChar.$this->_nextChar));
	}
	
	private function _needGlue() {
		if($this->isTag($this->_currentPart))
			$nC = $this->_nextChar;
		else
			$nC = $this->_currentFirstChar;

		if(isset($this->_lastChar) && $this->_lastChar !== false
		&& isset($nC) && $nC !== false
		&& strlen(trim($this->_lastChar.$nC)) == 2)
			return true;
		return false;
	}
	
	private function _glueToLast($part) {
		if(strlen($this->_prevLine().$part) > $this->_mLW() && preg_match('/\s/', $part, $m)) {
			
			$pos = strpos($part, $m[0]);
			$this->_addToPrevLine(substr($part, 0, $pos));
			$this->_return(substr($part, $pos+1, strlen($part)));
		} else {
			$this->_addToPrevLine($part);
		}
	}
	
	protected function _mLW() {
		$t = $this->store == 'static' ? self::$_tabs : $this->tabs;
		$w = $this->maxLineWith-($t*$this->tabWorth);
		return $w > $this->minLineWith ? $w : $this->minLineWith;
	}
	
	private function _return($string) {
		$this->_return[] = $this->get_tabs().$string;
	}
	
	private function _end() {
		if(count($this->_tagsToEnd) <= 0) { return; die('error'); }
		end($this->_tagsToEnd);
		$tag = $this->_tagsToEnd[key($this->_tagsToEnd)];
		$ident = '';
		if(!$this->noComments && $this->isBlockTag($this->_lastTag) || strlen($this->_lastString) > $this->_mLW()) {
			$ident = isset($tag['ident']) ? '<!-- '.$tag['ident'].' -->' : '';
		}
		unset($this->_tagsToEnd[key($this->_tagsToEnd)]);
		return '</'.$tag['name'].'>'.$ident;
	}
	
	public function get_clean($html, $tag = null) {
		$t = $this;
		$t->_reset();
		$delm = ' ';
		
		$t->_html = trim(preg_replace('/(\r\n|\r|\n|\t)+/', ' ', $html));
		
		$t->_tree = preg_split(
			'~(<[^!]?[^>]+>(<![^>]+>)?)~', 
			$t->_html, 
			-1, 
			PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
		);
		
		foreach($t->_tree as $t->_key => $pt) {
			$part = $pt[0];
			$t->_currentPart = $part;
			if(trim($part) == '')
				continue;
			$t->_checkPart($part);
			
			if($t->isEndTag($part)) {
				$part = $t->_end();
			}
			
			if($t->isBlockTag($part)) {
				if($t->isEndTag($part))
					$t->removeTab();
				
				$t->_block();
				$t->_return($part);
				
				if($t->isStartTag($part))
					$t->addTab();
			} elseif($t->isTag($part)) {
				$a = ($t->isEndTag($part) && strlen($part.$t->_lastString) > $t->_mLW());
				$b = ($t->isStartTag($part) && strlen($part.$t->_nextString) > $t->_mLW());

				if($a)
					$t->removeTab();

				if($t->_needGlue()) {
					$t->_glueToLast($part);
				} elseif($a || $b || $t->isBlockTag($t->_prevLine())) {
					$t->_return($part);
				} else {
					$t->_pushLast($part);
				}
				
				if($b)
					$t->addTab();
				
			} elseif($t->isNoTag($part)) {
				
				if($t->isStartTag($t->_lastTag) && $t->_spaceWrapCount() == 0) 
					$part = trim($part);
				
				if(strlen($part) > $t->_mLW())
					$part = $t->_breakPart($part);
				
				if($t->isBlockTag($t->_lastTag))
					$t->_return($part);
				elseif($t->_needGlue()) 
					$t->_glueToLast($part);
				else 
					$t->_pushLast($part);
				
			} else {
				$t->_return[] = $t->get_tabs().$part;
			}
			
			
			
		}
		$r = trim(preg_replace('/( )+/', ' ', implode($t->break, $t->_return)));
		if($t->commentParsedParts)
			$r = '<!-- // parsed by HTMLCleaner // START // -->'.$this->break.$this->get_tabs().$r.
				$this->break.$this->get_tabs().'<!-- // parsed by HTMLCleaner // END // -->';
		return $r;
	}
	
	
	public function clean($html) {
		echo $this->get_clean($html);
	}
	
	
	
	public function get_tagName($t) {
		if($this->isCommentTag($t))
			return 'comment';
		preg_match('~<([a-zA-Z]+).*>~', str_replace('</', '<', $t), $m);
		if(isset($m[1]))
			return $m[1];
		return false;
	}
	
	public function isStartTag($t) {
		return preg_match('~<([\w]+)[^>]*>~', $t);
	}
	public function isStandaloneTag($t) {
		return preg_match('~(<[^>|!]+[\/]+>)~', $t);
	}
	public function isEndTag($t) {
		return preg_match('~(</[\w]+>(<![^>]+>)?)~', $t);
	}
	public function isCommentTag($t) {
		if($this->isEndTag($t))
			return 0;
		return preg_match('~(<![^>]+>)~', $t);
	}
	public function isTag($t) {
		return preg_match('~(<[^>]+>)~', $t);
	}
	
	public function isNoTag($t) {
		if(!$this->isTag($t))
			return 1;
		return 0;
	}
	
	public function isBlockTag($t) {
		if(!$this->isTag($t) || $this->isStandaloneTag($t))
			return 0;
		
		return !in_array($this->get_tagName($t), $this->_inlineTags);
	}
	
	
	public function isInlineTag($t) {
		if(!$this->isTag($t))
			return 0;
		
		return in_array($this->get_tagName($t), $this->_inlineTags);
	}



	public function addTab($i = 1) {
		if($this->disable) return;
		
		if($this->store == 'static')
			self::$_tabs = self::$_tabs+$i;
		else
			$this->tabs = $this->tabs+$i;
		return $this;
	}
	
	public function removeTab($i = 1) {
		if($this->disable) return;
		
		if($this->store == 'static')
			self::$_tabs = self::$_tabs-$i < 0 ? 0 : self::$_tabs-$i;
		else {
			$this->tabs = $this->tabs-$i < 0 ? 0 : $this->tabs-$i;
		}
		
		return $this;
	}
	
	public function get_tabs() {
		if($this->disable) return;
		
		$r = '';
		for($i = 0; $i < ($this->store == 'static' ? self::$_tabs : $this->tabs); $i++) 
			$r .= $this->tab;
		return $r;
	}
} ?>