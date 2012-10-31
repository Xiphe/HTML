<?php

namespace Xiphe\HTML\core;

interface ModuleInterface {
	public function init(&$args, &$options, &$called);
	public function execute();
	public function sure();
}
?>