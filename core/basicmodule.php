<?php

namespace Xiphe\HTML\core;

class BasicModule {
	final public function init(&$args, &$options, &$called) {
		$this->args = &$args;
		$this->options = &$options;
		$this->called = &$called;
	}

	final public function has_option($name) {
		return in_array($name, $this->options);
	}

	public function sure()
	{
		return true;
	}
}
?>