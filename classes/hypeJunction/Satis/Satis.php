<?php

namespace hypeJunction\Satis;

use Elgg\Project\Paths;
use hypeJunction\Downloads\Download;

class Satis {

	public static function buildConfig($dir) {
		$config = [
			'name' => elgg_get_site_entity()->name,
			'homepage' => elgg_get_site_url(),
			'archive' => [
				'directory' => 'packages',
				'absolute-directory' => elgg_get_data_path() . 'satis/packages',
				'format' => 'zip',
				'prefix-url' => elgg_normalize_url('satis'),
				'skip-dev' => true,
				'override-dist-type' => true,
    			'rearchive' => true,
			],
			'output-html' => false,
			'require-all' => true,
			'require-dependencies' => true,
			'require-dev-dependencies' => true,
			'repositories' => [],
		];

		elgg_call(ELGG_IGNORE_ACCESS, function () use (&$config) {
			$packages = elgg_get_entities([
				'types' => 'object',
				'subtypes' => Download::SUBTYPE,
				'metadata_names' => [
					'github:package_name',
					'composer:package_name',
				],
				'limit' => 0,
				'batch' => true,
			]);

			foreach ($packages as $package) {
				/* @var $package \hypeJunction\Downloads\Download */
				$gh_name = $package->{'github:package_name'};

				$config['repositories'][] = [
					'type' => 'vcs',
					'url' => "https://github.com/$gh_name",
				];
			}
		});

		if (!is_dir($dir)) {
			mkdir($dir, 0700, true);
		}

		$filename = Paths::sanitize($dir) . 'satis.json';
		$h = fopen($filename, 'w');
		fwrite($h, json_encode($config));
		fclose($h);
	}

	/**
	 * Generate an access key for the user
	 *
	 * @param \ElggUser $user       User
	 * @param bool      $regenerate Regenerate if exists
	 *
	 * @return string
	 */
	public static function makeAccessKey(\ElggUser $user, $regenerate = false) {
		if (!$user->satis_access_key || $regenerate) {
			$ts = time();
			$hmac = elgg_build_hmac([
				'username' => $user->username,
				'ts' => $ts,
			]);

			$user->satis_access_key_ts = $ts;
			$user->satis_access_key = $hmac->getToken();
		}

		return $user->satis_access_key;
	}
}