<?php

namespace Xiphe\HTML\modules;

use Xiphe\HTML\core as HTML;

class Close extends HTML\BasicModule implements HTML\ModuleInterface {
	public static $singleton = true;

	public function execute()
	{
		if (empty($this->args)) {
			if (HTML\Store::hasTags()) {
				HTML\Store::get('last')->close();
			}
			return;
		}
		$until = $this->args[0];
		if (is_int($until)) {
			$i = 0;
			while ($i < $until && HTML\Store::hasTags()) {
				HTML\Store::get('last')->close();
				$i++;
			}
		} elseif ($until === 'all') {
			while(HTML\Store::hasTags()) {
				HTML\Store::get('last')->close();
			}
		} elseif (strpos($until, '.') === 0) {
			$found = false;
			while(!$found && HTML\Store::hasTags()) {
				if (HTML\Store::get('last')->hasClass(substr($until, 1))) {
					$found = true;
				}
				HTML\Store::get('last')->close();
			}
		} elseif (strpos($until, '#') === 0) {
			$found = false;
			while(!$found && HTML\Store::hasTags()) {
				if (isset(HTML\Store::get('last')->attributes['id'])
				 && HTML\Store::get('last')->attributes['id'] == substr($until, 1)
				) {
					$found = true;
				}
				HTML\Store::get('last')->close();
			}
		}
	}
}
?>