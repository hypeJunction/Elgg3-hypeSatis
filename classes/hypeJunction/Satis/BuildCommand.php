<?php

namespace hypeJunction\Satis;

use Elgg\Cli\Command;

/**
 * elgg-cli satis:build
 */
class BuildCommand extends Command {

	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this->setName('satis:build')
			->setDescription('Build satis composer repository');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function command() {
		$build = new Build();

		$build();

		return 0;
	}

}