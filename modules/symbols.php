<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Symbols extends HTML\BasicModule implements HTML\ModuleInterface {
	public static $singleton = true;

	public function execute()
	{
		switch ($this->called) {
			case 'n':
			case 'r':
				HTML\Generator::lineBreak();
				break;
			case 't':
				HTML\Generator::tabs();
				break;
			default:
				break;
		}
	}
} ?>