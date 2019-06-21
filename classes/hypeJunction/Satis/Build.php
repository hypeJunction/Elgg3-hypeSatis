<?php

namespace hypeJunction\Satis;

use Composer\Satis\Console\Application;
use Elgg\Project\Paths;
use Symfony\Component\Console\Input\StringInput;

class Build {

	public function __invoke() {
		$dataroot = elgg_get_data_path();

		Satis::buildConfig($dataroot);

		$config_file = Paths::sanitize($dataroot) . 'satis.json';
		$output_dir = Paths::sanitize($dataroot) . 'satis';

		$input = new StringInput("build $config_file $output_dir");
		$app = new Application();
		$app->run($input);
	}
}