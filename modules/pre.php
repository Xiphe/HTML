<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Pre extends HTML\BasicModule implements HTML\ModuleInterface {

	public function execute()
	{

	}

	public function sure()
	{
		$this->options[] = 'inlineInner';
		return false;
	}
} ?>