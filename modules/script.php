<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Script extends HTML\BasicModule implements HTML\ModuleInterface {
	public static $singleton = true;

	public function execute()
	{
		if ($this->has_option('start')) {
			$this->options[] = 'doNotSelfQlose';
			echo new HTML\Tag('script', $this->args, $this->options);
			return;
		}

		$options = $this->options;
		$options[] = 'doNotSelfQlose';
		if (in_array('compressJs', $options)) {
			$options[] = 'inlineInner';
		}

		$Tag = new HTML\Tag('script', $this->args, $options);

		$Tag->open();
		$Tag->content();
		$Tag->close();
	}

	public function sure()
	{
		if (empty($this->args[0])) {
			$this->args[0] = '';
		}	
		switch ($this->called) {
			case 'jquery':
				$this->called = 'script';
				$this->args[0] = array_merge(array(
					'type' => 'text/javascript',
					'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'
				), $this->args[0]);
				return false;
			case 'jqueryui':
				$this->called = 'script';
				$this->args[0] = array_merge(array(
					'type' => 'text/javascript',
					'src' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'
				), $this->args[0]);
				return false;
			default:
				$this->called = 'script';
				break;
		}
		return !(substr($this->args[0], 0, 4) == 'http'
		 || substr($this->args[0], 0, 3) == '../'
		 || substr($this->args[0], 0, 3) == '\./'
		 || substr($this->args[0], 0, 2) == './'
		 || substr($this->args[0], 0, 1) == '/'
		);
	}
}
?>