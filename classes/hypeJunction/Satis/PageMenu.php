<?php

namespace hypeJunction\Satis;

use Elgg\Hook;
use ElggMenuItem;

class PageMenu {

	/**
	 * Setup page menu
	 *
	 * @param Hook $hook Hook
	 */
	public function __invoke(Hook $hook) {

		$menu = $hook->getValue();
		/* @var $menu \Elgg\Menu\MenuItems */

		$menu->add(ElggMenuItem::factory([
			'name' => "admin:satis_packages",
			'text' => elgg_echo('collection:object:satis_package'),
			'href' => elgg_generate_url('collection:object:satis_package:all'),
			'section' => 'configure',
			'context' => ['admin'],
		]));
	}
}
