<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Ul extends HTML\BasicModule implements HTML\ModuleInterface {
	public static $singleton = true;

	private $label;

	public function execute()
	{
		$Tag = new HTML\Tag($this->called, array($this->args[0]), array('generate', 'start'));

		echo $Tag;
		if (isset($this->args[1])) {
			foreach($this->args[1] as $k => $v) {
				echo new HTML\Tag('li', array($v, (!is_int($k) ? $k : null)), array());
			}
		}
		echo $Tag;
	}
}
?>