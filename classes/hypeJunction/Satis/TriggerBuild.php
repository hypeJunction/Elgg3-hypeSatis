<?php

namespace hypeJunction\Satis;

use Elgg\HooksRegistrationService\Hook;

class TriggerBuild {

	/**
	 * Rebuild satis when Github informs about new release
	 *
	 * @param Hook $hook Hook
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function __invoke(Hook $hook) {
		$build = new Build();

		try {
			$build();
		} catch (\Exception $ex) {
			elgg_log($ex, 'error');
		}
	}
}