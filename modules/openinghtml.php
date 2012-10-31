<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as Core;

class Openinghtml extends Core\BasicModule implements Core\ModuleInterface {
	public static $singleton = true;

	public function execute()
	{

		$this->htmlattrs = array('class' => 'no-js'.$this->ieClass(' ').$this->browserClass(' '));
		$this->headattrs = array();

		if ($this->called == 'xhtml') {
			$this->xhtml();
		} else {
			$this->html5();
		}

	}

	public function xhtml()
	{
		$this->htmlattrs['xmlns'] = 'http://www.w3.org/1999/xhtml';

		echo '<?xml version="1.0" ?>';
		Core\Generator::lineBreak();
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"';
		Core\Generator::lineBreak();
		Core\Config::set('tabs', '++');
		Core\Generator::tabs();
   		echo '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
   		Core\Generator::lineBreak();
		Core\Config::set('tabs', '--');

		echo $this->get_html();
		echo $this->get_head();
	}

	public function html5()
	{
		echo '<!DOCTYPE HTML>';
		Core\Generator::lineBreak();
		echo $this->get_html();
		echo $this->get_head();
		\Xiphe\HTML::get()->utf8()
			->meta('http-equiv=X-UA-Compatible|content=IE\=edge,chrome\=1');
	}

	public function get_html()
	{
		$html = new Core\Tag(
			'html',
			array((isset($this->args[1]) ? $this->args[1] : null)),
			array('generate', 'start')
		);
		$html->set_attrs($this->htmlattrs);

		return $html;
	}

	public function get_head()
	{
		$head = new Core\Tag(
			'head',
			array((isset($this->args[0]) ? $this->args[0] : null)),
			array('generate', 'start')
		);
		$head->set_attrs($this->headattrs);
		return $head;
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
}
?>