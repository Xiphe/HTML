<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Input extends HTML\BasicModule implements HTML\ModuleInterface {
	public static $singleton = true;

	private $label;

	public function execute()
	{
		switch($this->called) {
			case 'textarea':
				$Tag = new HTML\Tag($this->called, array($this->args[0], $this->args[1]), array('generate'));
				break;
			default:
				$Tag = new HTML\Tag($this->called, array($this->args[0]), array('generate'));
				break;
		}
		$labelArgs = $this->label;

		$Label = HTML\Generator::get_label($labelArgs, $Tag);

		HTML\Generator::append_label($Label, $Tag, $labelArgs);
	}

	public function sure()
	{
		$this->label = null;
		switch ($this->called) {
			case 'textarea':
				$i = 2;
				break;
			default:
				$i = 1;
				break;
		}
		if(!isset($this->args[$i])) {
			return true;
		} elseif($this->args[$i] !== false) {
			$this->label = $this->args[$i];
			return true;
		}
		return false;
	}
}
?>