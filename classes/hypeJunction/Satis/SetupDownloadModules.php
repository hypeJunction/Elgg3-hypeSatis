<?php

namespace hypeJunction\Satis;

use Elgg\Hook;

class SetupDownloadModules {

	public function __invoke(Hook $hook) {

		$modules = $hook->getValue();

		$modules['download/satis'] = [
			'enabled' => true,
			'position' => 'sidebar',
			'priority' => 200,
		];

		return $modules;
	}
}