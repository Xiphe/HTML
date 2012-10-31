<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Css extends HTML\BasicModule implements HTML\ModuleInterface {
	public static $singleton = true;

	public function execute()
	{
		$options = $this->options;
		$options[] = 'doNotSelfQlose';
		if (in_array('compressCss', $options)) {
			$options[] = 'inlineInner';
		}

		$Tag = new HTML\Tag('style', $this->args, $options);

		$Tag->open();
		$Tag->content();
		$Tag->close();
	}

	public function sure()
	{
		return !(substr($this->args[0], 0, 4) == 'http'
			|| substr($this->args[0], 0, 3) == '../'
			|| substr($this->args[0], 0, 3) == '\./'
			|| substr($this->args[0], 0, 2) == './'
			|| substr($this->args[0], 0, 1) == '/'
		);
	}
}
?>