<?php

namespace hypeJunction\Satis;

use Composer\Satis\Console\Application;
use Elgg\Cli\Command;
use Elgg\Project\Paths;
use Symfony\Component\Console\Input\StringInput;

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

		$dataroot = elgg_get_data_path();

		Satis::buildConfig($dataroot);

		$config_file = Paths::sanitize($dataroot) . 'satis.json';
		$output_dir = Paths::sanitize($dataroot) . 'satis';

		$input = new StringInput("build $config_file $output_dir");
		$app = new Application();
		$app->run($input);

		return 0;
	}

}