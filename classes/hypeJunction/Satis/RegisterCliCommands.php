<?php

namespace hypeJunction\Satis;

use Elgg\Hook;

/**
 * Register CLI commands
 */
class RegisterCliCommands {

	/**
	 * Register commands
	 *
	 * @elgg_plugin_hook commands cli
	 *
	 * @param Hook $hook Hook
	 *
	 * @return array
	 */
	public function __invoke(Hook $hook) {
		$commands = $hook->getValue();
		$commands[] = BuildCommand::class;

		return $commands;
	}
}